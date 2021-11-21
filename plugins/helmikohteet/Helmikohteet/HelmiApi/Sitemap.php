<?php

declare(strict_types=1);

/**
 * Sitemap builder for Helmi listings
 */

namespace Helmikohteet\HelmiApi;

use Exception;
use Helmikohteet\ListingsList\Listing;
use Helmikohteet\ListingsList\ListParser;
use Helmikohteet\PluginConfig;
use SimpleXMLElement;

class Sitemap
{
    private string $siteURL;
    private string $detailsKey;
    private SimpleXMLElement $listings;

    /**
     * @param SimpleXMLElement $listings All listings
     */
    public function __construct(SimpleXMLElement $listings)
    {
        // get site URL
        $this->siteURL = get_site_url();

        // get listing details URL from config
        $this->detailsKey = PluginConfig::DETAILS_KEY_PARAM;

        $this->listings = $listings;
    }

    /**
     * Builds the XML site map that contains all listing ID keys.
     *
     * @return SimpleXMLElement
     */
    public function build(): SimpleXMLElement
    {
        // list all IDs

        $apartmentKeys = (new ListParser($this->listings))
            ->getAllKeys(Listing::STATUS_FOR_SALE);

        // construct XML

        $xmlBase = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            </urlset>';
        try {
            $sitemap = new SimpleXMLElement($xmlBase);

            foreach ($apartmentKeys as $key) {
                $urlNode = $sitemap->addChild('url');
                $urlNode->addChild(
                    'loc',
                    $this->siteURL . '?' . http_build_query([$this->detailsKey => $key])
                );
            }

            return $sitemap;
        } catch (Exception $e) {
            // only comes here if $xmlBase is invalid -- never happens in normal use
            return new SimpleXMLElement('');
        }
    }
}
