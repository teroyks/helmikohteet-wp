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
?>

<?php get_header(); // site theme header ?>

<main class="helmik-details-container">
  <section class="helmik-details-heading">
    <h1><?= $ls->streetAddress ?></h1>
    <div>
      <?= $ls->postalCode ?>
      <?= $ls->city ?>
      <?= $ls->salesPrice ?>
    </div>
    <div>
      <?= $ls->apartmentType ?>
      <?= $ls->livingArea ?>
      <?= $ls->roomTypes ?>
    </div>
  </section>
  <section class="helmik-details-pictures">
    <div class="fotorama" data-nav="thumbs" data-width="100%">
      <?php foreach ($ls->pictureUrls as $url): ?>
        <img src=<?= $url ?>>
      <?php endforeach ?>
    </div>
  </section>
  <section class="helmik-details-description">
    <?php if ($ls->description): ?>
      <?= $fmt->description($ls->description) ?>
    <?php endif ?>
  </section>
  <section class="helmik-details-props">
    <h2>Perustiedot</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Kohdenumero', $ls->id) ?>
      <?= $fmt->tr('Kohdetyyppi', $ls->apartmentType) ?>
      <?= $fmt->tr('Vapautuminen', $ls->becomesAvailable) ?>
      <?= $fmt->tr('Myyntihinta', $fmt->float($ls->salesPrice), ' €') ?>
      <?= $fmt->tr('Osoite', $ls->streetAddress) ?>
      <?= $fmt->tr('Postinumero', $ls->postalCode) ?>
      <?= $fmt->tr('Kaupunginosa', $ls->region) ?>
      <?= $fmt->tr('Kaupunki', $ls->city) ?>
      <?= $fmt->tr('Maakunta', $ls->pdxRegion) ?>
      <?= $fmt->tr('Kiinteistötunnus', $ls->realEstateId) ?>
      <?= $fmt->tr('Tontin pinta-ala', $fmt->float($ls->siteArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Tontin omistus', $ls->siteCode) ?>
      <?= $fmt->tr('Tontin vuokrasopimus päättyy', $ls->siteRentContractEndDate) ?>
      <?= $fmt->tr('Kaavoitustilanne', $ls->buildingPlanSituation) ?>
      <?= $fmt->tr('Lisätietoja kaavoituksesta', $ls->buildingPlanInformation) ?>
      <?= $fmt->tr('Rakennusoikeus', $ls->buildingRights) ?>
      <?= $fmt->tr('Tilan nimi', $ls->estateNameAndNumber) ?>
      <?= $fmt->tr('Kiinteistön lisätiedot', $ls->propertyAdditionalInfo) ?>
      <?= $fmt->tr('Liittymät', $ls->municipalDevelopment) ?>
      <?= $fmt->tr('Ranta', $ls->shore) ?>
      <?= $fmt->tr('Ranta-alueiden kuvaus', $ls->shoreDescription) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <h2>Rakennuksen tiedot</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Rakennusvuosi', $ls->yearOfBuilding) ?>
      <?= $fmt->tr('Rakennusmateriaali', $ls->buildingMaterial) ?>
      <?= $fmt->tr('Kattotyyppi', $ls->roofType) ?>
      <?= $fmt->tr('Huonekuvaus', $ls->roomTypes) ?>
      <?= $fmt->tr('Lämmitys', $ls->heating) ?>
      <?= $fmt->tr('Ilmanvaihto', $ls->ventilationSystem) ?>
      <?= $fmt->tr('Pinta-ala', $fmt->float($ls->livingArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Kokonaispinta-ala', $fmt->float($ls->totalArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Lisätietoja pinta-alasta', $ls->totalAreaDescription) ?>
      <?= $fmt->tr('Kunto', $ls->generalConditionLevel) ?>
      <?= $fmt->tr('Kunnon lisätiedot', $ls->generalCondition) ?>
      <?= $fmt->tr('Energialuokka', $ls->energyClass) ?>
      <?= $fmt->tr('Rakennuksen lisätiedot', $ls->supplementaryInformation) ?>
      <?= $fmt->tr('Tehdyt korjaukset', $ls->basicRenovations) ?>
      <?= $fmt->tr('Kerrosmäärä', $ls->floorLocation) ?>
      <?= $fmt->tr('Parveke', $ls->balcony) ?>
      <?= $fmt->tr('Parvekkeen lisätiedot', $ls->balconyDescription) ?>
      <?= $fmt->tr('Asbestikartoitus tehty', $ls->asbestosMapping) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <h2>Tilat ja materiaalit</h2>
    <table>
      <tbody>
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
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <h2>Palvelut ja liikenneyhteydet</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Palvelut', $ls->services) ?>
      <?= $fmt->tr('Liikenneyhteydet', $ls->connections) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <h2>Kustannukset</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Energiankulutus', $fmt->float($ls->electricityConsumption)) ?>
      <?= $fmt->tr('Kiinteistövero', $fmt->float($ls->estateTax), ' €/kk') ?>
      <?= $fmt->tr('Muut maksut', $fmt->float($ls->otherFees), ' €/kk') ?>
      </tbody>
    </table>
  </section>
</main>
<?php if (!empty(PluginConfig::googleApiUrl())): ?>
  <div id="map" class="helmi-map"></div>
<?php endif ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

<?php if (!empty(PluginConfig::googleApiUrl())): ?>
  <script src="<?= PluginConfig::googleApiUrl() ?>" async></script>
  <script>
    let map;
    function initMap() {
      const mapOptions = {
        zoom: 16,
        center: { lat: <?= $ls->latitude ?>, lng: <?= $ls->longitude ?> },
      };
      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      const marker = new google.maps.Marker({
        position: { lat: <?= $ls->latitude ?>, lng: <?= $ls->longitude ?> },
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

<!--
<?php var_dump($ls) ?>
-->

<?php get_footer(); // site theme footer ?>
