<?php

/**
 * Apartment type mapping from listings code to human-readable type.
 */

namespace Helmikohteet\ListingsList;


class ApartmentType
{
    private const TYPE = [
        'AP'   => 'Autopaikka',
        'AT'   => 'Autotalli',
        'ET'   => 'Erillistalo',
        'HAR'  => 'Harrastetila',
        'HUB'  => 'Hub-tila',
        'KT'   => 'Kerrostalo',
        'LH'   => 'Lomahuoneisto',
        'LO'   => 'Lomaosake',
        'LT'   => 'Liiketila',
        'LUHT' => 'Luhtitalo',
        'MAT'  => 'Maatila',
        'MET'  => 'Metsätila',
        'MO'   => 'Mökki tai huvila',
        'NAY'  => 'Näyttelytila',
        'OKTT' => 'Omakotitalotontti',
        'OT'   => 'Omakotitalo',
        'PT'   => 'Paritalo',
        'PUUT' => 'Puutalo- osake',
        'RAV'  => 'Ravintolatila',
        'RT'   => 'Rivitalo',
        'RTT'  => 'Rivitalotontti',
        'TMUU' => 'Muu toimistotila',
        'TO'   => 'Tontti',
        'TOT'  => 'Toimistotila',
        'TUT'  => 'Tuotantotila',
        'UL'   => 'Loma-asunto ulkomailla',
        'VART' => 'Varastotila',
        'VT'   => 'Vapaa-ajan tontti',
    ];

    // This value is used if the apartment type does not match any known code
    private const DEFAULT = 'Muu kiinteistö';

    public static function get(string $code): string
    {
        return self::TYPE[$code] ?? self::DEFAULT;
    }
}
