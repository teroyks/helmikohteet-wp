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
        <img src="<?= $url ?>" alt="">
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
      <?= $fmt->tr('Kohdetyyppi', $ls->apartmentType) ?>
      <?= $fmt->tr('Vapautuminen', $ls->becomesAvailable) ?>
      <?= $fmt->tr('Velaton hinta', $fmt->float($ls->unencumberedSalesPrice), ' €') ?>
      <?= $fmt->tr('Velkaosuus', $fmt->float($ls->debtPart), ' €') ?>
      <?= $fmt->tr('Myyntihinta', $fmt->float($ls->salesPrice), ' €') ?>
      <?= $fmt->tr('Osoite', $ls->streetAddress) ?>
      <?= $fmt->tr('Huoneistotarkenne', $ls->flatNumber) ?>
      <?= $fmt->tr('Postinumero', $ls->postalCode) ?>
      <?= $fmt->tr('Kaupunginosa', $ls->region) ?>
      <?= $fmt->tr('Kaupunki', $ls->city) ?>
      <?= $fmt->tr('Maakunta', $ls->pdxRegion) ?>
      <?= $fmt->tr('Kiinteistötunnus', $ls->realEstateId) ?>
      <?= $fmt->tr('Tontin pinta-ala', $fmt->float($ls->siteArea), ' m<sup>2</sup>') ?>
      <?= $fmt->tr('Tontin omistus', $ls->siteCode == 'O' ? 'Oma' : 'Vuokra') ?>
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
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <h2>Taloyhtiön tiedot</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Rakennusvuosi', $ls->yearOfBuilding) ?>
      <?= $fmt->tr('Rakennusmateriaali', $ls->buildingMaterial) ?>
      <?= $fmt->tr('Kattotyyppi', $ls->roofType) ?>
      <?= $fmt->tr('Kiinteistönhoito', $ls->realEstateManagement) ?>
      <?= $fmt->tr('Huonekuvaus', $ls->roomTypes) ?>
      <?= $fmt->tr('TV-järjestelmä', $ls->antennaSystem) ?>
      <?= $fmt->tr('Yhteiset tilat', $ls->commonAreas) ?>
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
      <?= $fmt->tr('Lunastuslauseke', $ls->honoringClause) ?>
      <?= $fmt->tr('Kerrosmäärä', $ls->floorLocation) ?>
      <?= $fmt->tr('Parveke', $ls->balcony) ?>
      <?= $fmt->tr('Parvekkeen lisätiedot', $ls->balconyDescription) ?>
      <?= $fmt->tr('Asbestikartoitus tehty', $ls->asbestosMapping) ?>
      </tbody>
    </table>
  </section>
  <section id="helmik-spaces" class="helmik-details-props">
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
  <section id="helmik-services" class="helmik-details-props">
    <h2>Palvelut ja liikenneyhteydet</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Palvelut', $ls->services) ?>
      <?= $fmt->tr('Liikenneyhteydet', $ls->connections) ?>
      </tbody>
    </table>
  </section>
  <section id="helmik-expenses" class="helmik-details-props">
    <h2>Kustannukset</h2>
    <table>
      <tbody>
      <?= $fmt->tr('Yhtiövastike', $fmt->float($ls->housingCompanyFee), ' €/kk') ?>
      <?= $fmt->tr('Rahoitusvastike', $fmt->float($ls->financingFee), ' €/kk') ?>
      <?= $fmt->tr('Hoitovastike', $fmt->float($ls->maintenanceFee), ' €/kk') ?>
      <?= $fmt->tr('Vesimaksu', $fmt->float($ls->waterFee), ' €/kk') ?>
      <?= $fmt->tr('Vesimaksun lisätiedot', $ls->waterFeeExplanation) ?>
      <?= $fmt->tr('Energiankulutus', $fmt->float($ls->electricityConsumption)) ?>
      <?= $fmt->tr('Kiinteistövero', $fmt->float($ls->estateTax), ' €/kk') ?>
      <?= $fmt->tr('Muut maksut', $fmt->float($ls->otherFees), ' €/kk') ?>
      </tbody>
    </table>
  </section>
  <section id="helmik-agent-and-showing" class="helmik-details-props">
    <div class="helmik-agent">
      <div>
        <h2 class="helmik-heading-agent">Lisätiedot</h2>
        <div><?= $ls->agentName ?></div>
        <div><?= $ls->agentEmail ?></div>
        <div><?= $ls->agentPhone ?></div>
      </div>
      <div>
        <img src="<?= $ls->agentPictureUrl ?>" alt=""/>
      </div>
    </div>
    <?php if (!empty($ls->showingDate)): ?>
      <div class="helmik-showing">
        <h2 class="helmik-heading-showing">Esittelyt</h2>
        <div><?= $ls->showingDate ?></div>
        <div><?= $ls->showingStartTime ?>–<?= $ls->showingEndTime ?></div>
        <div><?= $ls->showingExplanation ?></div>
      </div>
    <?php endif ?>
  </section>
</main>
<?php if (!empty(PluginConfig::googleApiUrl())): ?>
  <div id="map" class="helmik-map"></div>
<?php endif ?>

<script>
  const tables = ['#helmik-spaces', '#helmik-services', '#helmik-expenses']
  tables.forEach(table => {
    if (!document.querySelectorAll(table + ' td').length && document.querySelector(table)) {
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

<!--
<?php var_dump($ls) ?>
-->

<?php get_footer(); // site theme footer ?>
