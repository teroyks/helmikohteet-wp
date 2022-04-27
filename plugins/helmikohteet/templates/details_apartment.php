<?php
/**
 * Listing display details page template.
 */

/** @var string $listingId Listing key */

use Helmikohteet\ListingDetails\Listing;
use Helmikohteet\PluginConfig;
use Helmikohteet\Utilities\Format;

/** @var Listing $ls Listing details */

/** @var Format $fmt Formatter */
$GLOBALS['helmi-meta'] = $ls;

function helmi_title() {
  $title = array();
  $title['title'] = $GLOBALS['helmi-meta']->streetAddress;
  return $title;
}

function helmi_header() {
  $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $description = $GLOBALS['helmi-meta']->apartmentType.' - '.$GLOBALS['helmi-meta']->livingArea.' m2 - '.$GLOBALS['helmi-meta']->roomTypes;
  echo '<title>'.$GLOBALS['helmi-meta']->streetAddress.'</title>
<meta name="description" content="'.$description.'">
<meta name="robots" content="index, follow">
<meta property="og:type" content="website">
<meta property="og:url" content="'.$url.'">
<meta property="og:title" content="'.$GLOBALS['helmi-meta']->streetAddress.'">
<meta property="og:description" content="'.$description.'">  
<meta property="og:image" content="'.$GLOBALS['helmi-meta']->pictureUrls[0].'">
<meta name="twitter:title" content="'.$GLOBALS['helmi-meta']->streetAddress.'">
<meta name="twitter:description" content="'.$description.'">
<meta name="twitter:image" content="'.$GLOBALS['helmi-meta']->pictureUrls[0].'">';
}

add_filter('document_title_parts', 'helmi_title' );
add_action('wp_head','helmi_header');
get_header(); // site theme header ?>

<main class="helmik-details-container">
  <section class="helmik-details-heading">
    <h1><?= $ls->streetAddress ?></h1>
    <div>
      <?= $ls->postalCode ?> -
      <?= $ls->city ?> -
      <?php if ($ls->modeOfHabitation != "VU"): ?>
      vh. <?= $fmt->float($ls->unencumberedSalesPrice).' €' ?>
      <?php endif ?>
      <?php if ($ls->modeOfHabitation == "VU"): ?>
      Vuokra/kk <?= $fmt->float($ls->rentAmount).' €' ?>
      <?php endif ?>
    </div>
    <div>
      <?= $ls->apartmentType ?> -
      <?= $ls->livingArea ?> m&sup2; -
      <?= $ls->roomTypes ?>
    </div>
  </section>
  <section class="helmik-details-pictures">
    <div class="fotorama" data-nav="thumbs" data-width="100%">
      <?php foreach ($ls->pictureUrls as $url): ?>
        <img src="<?= $url ?>" alt="">
      <?php endforeach ?>
    </div>
  </section>
  <div class="helmik-description-row">
    <section class="helmik-details-description">
      <?php if ($ls->description): ?>
        <?= $fmt->description($ls->description) ?>
      <?php endif ?>
    </section>
    <section id="helmik-agent-and-showing" class="helmik-details-props">
      <div class="helmik-agent">
        <div class="helmik-agent-details">
          <h2 class="helmik-heading-agent">Lisätiedot</h2>
          <div class="helmik-agent-name"><?= $ls->agentName ?></div>
          <div class="helmik-agent-links"><a href="mailto:<?= $ls->agentEmail ?>"><?= $ls->agentEmail ?></a></div>
          <div class="helmik-agent-links"><a href="tel:<?= $ls->agentPhone ?>"><?= $ls->agentPhone ?></a></div>
        </div>
        <img src="<?= $ls->agentPictureUrl ?>" alt=""/>
      </div>
      <?php if ($ls->onlineOffer == "K"): ?>
        <div class="helmik-offerbid">
          <h2 class="helmik-heading-offerbid">Tarjouskauppa</h2>
          <?php if ($ls->onlineOfferHighestBid > 0) { ?>
          <?= $fmt->tr('Korkein tarjous', $fmt->float($ls->onlineOfferHighestBid), ' €') ?>
          <?php } 
            else echo "Kohteesta ei ole vielä jätetty tarjouksia";
          ?>
          <div class="helmik-offerbid-links"><a href="<?= $ls->onlineOfferUrl ?>&offerbid">Seuraa kohteen tarjouskauppaa</a></div>
        </div>
      <?php endif ?>
      <?php if (!empty($ls->showingDate)): ?>
        <div class="helmik-showing">
          <h2 class="helmik-heading-showing">Esittelyt</h2>
          <div><?= $ls->showingDate ?></div>
          <div><?= $ls->showingStartTime ?>–<?= $ls->showingEndTime ?></div>
          <div><?= $ls->showingExplanation ?></div>
        </div>
      <?php endif ?>
    </section>
  </div>
  <div class="helmik-details-row">
    <section class="helmik-details-props">
      <h2>Perustiedot</h2>
      <?= $fmt->tr('Kohdenumero', $ls->oikotieID) ?>
      <?= $fmt->tr('Kohdetyyppi', $ls->apartmentType) ?>
      <?= $fmt->tr('Osoite', $ls->streetAddress) ?>
      <?= $fmt->tr('Huoneistotarkenne', $ls->flatNumber) ?>
      <?= $fmt->tr('Postinumero', $ls->postalCode) ?>
      <?= $fmt->tr('Kaupunki', $ls->city) ?>
      <?= $fmt->tr('Kaupunginosa', $ls->region) ?>
      <?= $fmt->tr('Maakunta', $ls->pdxRegion) ?>
      <?= $fmt->tr('Huoneiston kerros', $ls->floorLocation) ?>
      <?= $fmt->tr('Huonekuvaus', $ls->roomTypes) ?>
      <?= $fmt->tr('Pinta-ala', $fmt->float($ls->livingArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Lisätietoja pinta-alasta', $ls->totalAreaDescription) ?>
      <?php if ($ls->totalArea > 0): ?>
        <?= $fmt->tr('Kokonaispinta-ala', $fmt->float($ls->totalArea), ' m<sup>2</sup>') ?>
      <?php endif ?>
      <?= $fmt->tr('Lämmitys', $ls->heating) ?>
      <?= $fmt->tr('Vapautuminen', $ls->becomesAvailable) ?>
      <?php if ($ls->onlineOffer == "K"): ?>
        <?= $fmt->tr('Lähtöhinta ilman velkaosuutta', $fmt->float($ls->salesPrice), ' €') ?>
        <?= $fmt->tr('Velkaosuus', $fmt->float($ls->debtPart), ' €') ?>
        <?= $fmt->tr('Velaton lähtöhinta', $fmt->float($ls->unencumberedSalesPrice), ' €') ?>
      <?php endif ?>
      <?php if ($ls->onlineOffer != "K" && $ls->modeOfHabitation != "VU"): ?>
        <?= $fmt->tr('Velaton hinta', $fmt->float($ls->unencumberedSalesPrice), ' €') ?>
        <?= $fmt->tr('Velkaosuus', $fmt->float($ls->debtPart), ' €') ?>
        <?= $fmt->tr('Myyntihinta', $fmt->float($ls->salesPrice), ' €') ?>
      <?php endif ?>
      <?php if ($ls->modeOfHabitation == "VU"): ?>
        <?= $fmt->tr('Vuokra/kk', $fmt->float($ls->rentAmount), ' €') ?>
        <?= $fmt->tr('Vuokravakuus', $fmt->float($ls->rentDeposit), ' €') ?>
        <?= $fmt->tr('Vuokravakuus (kuvaus)', $ls->rentDepositText) ?>
        <?= $fmt->tr('Vuokrauksen erityisehdot', $ls->rentingTerms) ?>
      <?php endif ?>
      <?= $fmt->tr('Tehdyt korjaukset', $ls->basicRenovations) ?>
    </section>
    <section class="helmik-details-props">
      <h2>Taloyhtiön tiedot</h2>
      <?= $fmt->tr('Taloyhtiön nimi', $ls->housingCompanyName) ?>
      <?= $fmt->tr('Rakennusvuosi', $ls->yearOfBuilding) ?>
      <?= $fmt->tr('Rakennusmateriaali', $ls->buildingMaterial) ?>
      <?= $fmt->tr('Kattotyyppi', $ls->roofType) ?>
      <?= $fmt->tr('Kerroksia', $ls->floorCount) ?>
      <?= $fmt->tr('Talossa hissi', $ls->lift) ?>
      <?= $fmt->tr('Tontin pinta-ala', $fmt->float($ls->siteArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Tontin omistus', $ls->siteCode == 'O' ? 'Oma' : 'Vuokra') ?>
      <?= $fmt->tr('Energialuokka', $ls->energyClass) ?>
      <?= $fmt->tr('Kiinteistöhuolto', $ls->realEstateManagement) ?>
      <?= $fmt->tr('TV-järjestelmä', $ls->antennaSystem) ?>
      <?= $fmt->tr('Yhteiset tilat', $ls->commonAreas) ?>
      <?= $fmt->tr('Ilmanvaihto', $ls->ventilationSystem) ?>
      <?= $fmt->tr('Kunto', $ls->generalConditionLevel) ?>
      <?= $fmt->tr('Kunnon lisätiedot', $ls->generalCondition) ?>
      <?= $fmt->tr('Rakennuksen lisätiedot', $ls->supplementaryInformation) ?>
      <?= $fmt->tr('Lunastuslauseke', $ls->honoringClause) ?>
      <?= $fmt->tr('Parveke', $ls->balcony) ?>
      <?= $fmt->tr('Parvekkeen lisätiedot', $ls->balconyDescription) ?>
      <?= $fmt->tr('Asbestikartoitus tehty', $ls->asbestosMapping) ?>
      <?= $fmt->tr('Kiinteistötunnus', $ls->realEstateId) ?>
      <?= $fmt->tr('Tontin vuokranantaja', $ls->leaseHolder) ?>
      <?= $fmt->tr('Tontin vuokrasopimus päättyy', $ls->siteRentContractEndDate) ?>
      <?= $fmt->tr('Kaavoitustilanne', $ls->buildingPlanSituation) ?>
      <?= $fmt->tr('Lisätietoja kaavoituksesta', $ls->buildingPlanInformation) ?>
      <?= $fmt->tr('Rakennusoikeus', $ls->buildingRights) ?>
      <?= $fmt->tr('Tilan nimi', $ls->estateNameAndNumber) ?>
      <?= $fmt->tr('Kiinteistön lisätiedot', $ls->propertyAdditionalInfo) ?>
      <?= $fmt->tr('Liittymät', $ls->municipalDevelopment) ?>
      <?= $fmt->tr('Ranta', $ls->shore) ?>
      <?= $fmt->tr('Ranta-alueiden kuvaus', $ls->shoreDescription) ?>
    </section>
    <section id="helmik-spaces" class="helmik-details-props">
      <h2>Tilat ja materiaalit</h2>
      <?= $fmt->tr('Keittiö', $ls->kitchenAppliances) ?>
      <?= $fmt->tr('Keittiön seinät', $ls->kitchenWall) ?>
      <?= $fmt->tr('Keittiön lattia', $ls->kitchenFloor) ?>
      <?= $fmt->tr('Makuuhuoneet', $ls->bedroomAppliances) ?>
      <?= $fmt->tr('Makuuhuoneiden seinät', $ls->bedroomWall) ?>
      <?= $fmt->tr('Makuuhuoneiden lattiat', $ls->bedroomFloor) ?>
      <?= $fmt->tr('Olohuone', $ls->livingRoomAppliances) ?>
      <?= $fmt->tr('Olohuoneen lattia', $ls->livingRoomFloor) ?>
      <?= $fmt->tr('Olohuoneen seinät', $ls->livingRoomWall) ?>
      <?= $fmt->tr('Kylpyhuone', $ls->bathroomAppliances) ?>
      <?= $fmt->tr('Kylpyhuoneen seinät', $ls->bathroomWall) ?>
      <?= $fmt->tr('Kylpyhuoneen lattia', $ls->bathroomFloor) ?>
      <?= $fmt->tr('Muiden tilojen lattiat', $ls->floor) ?>
      <?= $fmt->tr('Sauna', $ls->sauna) ?>
      <?= $fmt->tr('Säilytystilat', $ls->storageSpace) ?>
      <?= $fmt->tr('Auton säilytys', $ls->parkingSpace) ?>
    </section>
    <section id="helmik-services" class="helmik-details-props">
      <h2>Palvelut ja liikenneyhteydet</h2>
      <?= $fmt->tr('Palvelut', $ls->services) ?>
      <?= $fmt->tr('Liikenneyhteydet', $ls->connections) ?>
    </section>
    <section id="helmik-expenses" class="helmik-details-props">
      <h2>Kustannukset</h2>
      <?= $fmt->tr('Yhtiövastike', $fmt->float($ls->housingCompanyFee), ' €/kk') ?>
      <?= $fmt->tr('Rahoitusvastike', $fmt->float($ls->financingFee), ' €/kk') ?>
      <?= $fmt->tr('Hoitovastike', $fmt->float($ls->maintenanceFee), ' €/kk') ?>
      <?= $fmt->tr('Vesimaksu', $fmt->float($ls->waterFee), ' €/kk') ?>
      <?= $fmt->tr('Vesimaksun lisätiedot', $ls->waterFeeExplanation) ?>
      <?= $fmt->tr('Energiankulutus', $fmt->float($ls->electricityConsumption)) ?>
      <?= $fmt->tr('Kiinteistövero', $fmt->float($ls->estateTax), ' €/kk') ?>
      <?= $fmt->tr('Muut maksut', $fmt->float($ls->otherFees), ' €/kk') ?>
    </section>
  </div>
</main>
<?php if (!empty(PluginConfig::googleApiUrl())): ?>
  <div id="map" class="helmik-map"></div>
<?php endif ?>
<?php if (!empty(PluginConfig::leafletMapsApiKey())): ?>
  <div id="leafletmap" class="helmik-map"></div>
<?php endif ?>

<script>
  const tables = ['#helmik-spaces', '#helmik-services', '#helmik-expenses']
  tables.forEach(table => {
    if (!document.querySelectorAll(table + ' div.helmik-details-grid-row').length && document.querySelector(table)) {
      document.querySelector(table).remove();
    }
  });
</script>
<script src="<?= plugin_dir_url(__DIR__) ?>public/js/jquery-1.11.1.min.js"></script>
<script src="<?= plugin_dir_url(__DIR__) ?>public/js/fotorama.js"></script>

<?php if (!empty(PluginConfig::googleApiUrl())): ?>
  <script src="<?= PluginConfig::googleApiUrl() ?>" async></script>
  <!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
  <script>
    let map;

    function initMap() {
      const mapOptions = {
        zoom: 16,
        center: {lat: <?= $ls->latitude ?>, lng: <?= $ls->longitude ?>},
      };
      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      const marker = new google.maps.Marker({
        position: {lat: <?= $ls->latitude ?>, lng: <?= $ls->longitude ?>},
        map: map,
      });
      const infowindow = new google.maps.InfoWindow({
        content: "<p><?= $ls->streetAddress ?></p>",
      });
      google.maps.event.addListener(marker, "click", () => {
        infowindow.open(map, marker);
      });
    }
  </script>
<?php endif ?>

<?php if (!empty(PluginConfig::leafletMapsApiKey())): ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
  <!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
  <script>
    var token = '<?= PluginConfig::leafletMapsApiKey() ?>';
    var mymap = L.map('leafletmap').setView([<?= $ls->latitude ?>, <?= $ls->longitude ?>], 17);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: token,
    }).addTo(mymap);

    var marker = L.marker([<?= $ls->latitude ?>, <?= $ls->longitude ?>]).addTo(mymap);
  </script>
<?php endif ?>

<?php get_footer(); // site theme footer ?>
