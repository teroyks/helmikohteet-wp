<?php
/**
 * Listing display details page template.
 */

/** @var string $listingId Listing key */

use Helmikohteet\ListingDetails\Listing;

/** @var Listing $ls Listing details */

// builds a data table row
$tr = fn($label, $value, $suffix = '') => $value ? <<<EOF
<tr>
  <td class="helmik-details-label">$label</td>
  <td class="helmik-details-property">$value$suffix</td>
</tr>
EOF : '';

// formats a non-empty value as float
$float = fn($val) => $val ? number_format($val, 2, ',', ' ') : '';

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
  <section class="helmik-details-props">
    <h2>Perustiedot</h2>
    <table>
      <tbody>
      <?= $tr('Kohdenumero', $ls->id) ?>
      <?= $tr('Kohdetyyppi', $ls->apartmentType) ?>
      <?= $tr('Vapautuminen', $ls->becomesAvailable) ?>
      <?= $tr('Myyntihinta', $float($ls->salesPrice), ' €') ?>
      <?= $tr('Osoite', $ls->streetAddress) ?>
      <?= $tr('Postinumero', $ls->postalCode) ?>
      <?= $tr('Kaupunginosa', $ls->region) ?>
      <?= $tr('Kaupunki', $ls->city) ?>
      <?= $tr('Maakunta', $ls->pdxRegion) ?>
      <?= $tr('Kiinteistötunnus', $ls->realEstateId) ?>
      <?= $tr('Tontin pinta-ala', $float($ls->siteArea), ' m<sup>2</sup>') ?>
      <?= $tr('Tontin omistus', $ls->siteCode) ?>
      <?= $tr('Tontin vuokrasopimus päättyy', $ls->siteRentContractEndDate) ?>
      <?= $tr('Kaavoitustilanne', $ls->buildingPlanSituation) ?>
      <?= $tr('Lisätietoja kaavoituksesta', $ls->buildingPlanInformation) ?>
      <?= $tr('Rakennusoikeus', $ls->buildingRights) ?>
      <?= $tr('Tilan nimi', $ls->estateNameAndNumber) ?>
      <?= $tr('Kiinteistön lisätiedot', $ls->propertyAdditionalInfo) ?>
      <?= $tr('Liittymät', $ls->municipalDevelopment) ?>
      <?= $tr('Ranta', $ls->shore) ?>
      <?= $tr('Ranta-alueiden kuvaus', $ls->shoreDescription) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <table>
      <tbody>
      <?= $tr('Rakennusvuosi', $ls->yearOfBuilding) ?>
      <?= $tr('Rakennusmateriaali', $ls->buildingMaterial) ?>
      <?= $tr('Kattotyyppi', $ls->roofType) ?>
      <?= $tr('Huonekuvaus', $ls->roomTypes) ?>
      <?= $tr('Lämmitys', $ls->heating) ?>
      <?= $tr('Ilmanvaihto', $ls->ventilationSystem) ?>
      <?= $tr('Pinta-ala', $float($ls->livingArea), ' m<sup>2</sup>') ?>
      <?= $tr('Kokonaispinta-ala', $float($ls->totalArea), ' m<sup>2</sup>') ?>
      <?= $tr('Lisätietoja pinta-alasta', $ls->totalAreaDescription) ?>
      <?= $tr('Kunto', $ls->generalConditionLevel) ?>
      <?= $tr('Kunnon lisätiedot', $ls->generalCondition) ?>
      <?= $tr('Energialuokka', $ls->energyClass) ?>
      <?= $tr('Rakennuksen lisätiedot', $ls->supplementaryInformation) ?>
      <?= $tr('Tehdyt korjaukset', $ls->basicRenovations) ?>
      <?= $tr('Kerrosmäärä', $ls->floorLocation) ?>
      <?= $tr('Parveke', $ls->balcony) ?>
      <?= $tr('Parvekkeen lisätiedot', $ls->balconyDescription) ?>
      <?= $tr('Asbestikartoitus tehty', $ls->asbestosMapping) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <table>
      <tbody>
      <?= $tr('Keittiö', $ls->kitchenAppliances) ?>
      <?= $tr('Keittiön seinät', $ls->kitchenWall) ?>
      <?= $tr('Keittiön lattia', $ls->kitchenFloor) ?>
      <?= $tr('Makuuhuoneet', $ls->bedroomAppliances) ?>
      <?= $tr('Makuuhuoneiden seinät', $ls->bedroomWall) ?>
      <?= $tr('Makuuhuoneiden lattiat', $ls->bedroomFloor) ?>
      <?= $tr('Olohuone', $ls->livingRoomAppliances) ?>
      <?= $tr('Olohuoneen lattia', $ls->livingRoomFloor) ?>
      <?= $tr('Olohuoneen seinät', $ls->livingRoomWall) ?>
      <?= $tr('Kylpyhuone', $ls->bathroomAppliances) ?>
      <?= $tr('Kylpyhuoneen seinät', $ls->bathroomWall) ?>
      <?= $tr('Kylpyhuoneen lattia', $ls->bathroomFloor) ?>
      <?= $tr('Muiden tilojen lattiat', $ls->floor) ?>
      <?= $tr('Sauna', $ls->sauna) ?>
      <?= $tr('Säilytystilat', $ls->storageSpace) ?>
      <?= $tr('Auton säilytys', $ls->parkingSpace) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <table>
      <tbody>
      <?= $tr('Liikenneyhteydet', $ls->connections) ?>
      <?= $tr('Palvelut', $ls->services) ?>
      </tbody>
    </table>
  </section>
  <section class="helmik-details-props">
    <table>
      <tbody>
      <?= $tr('Energiankulutus', $float($ls->electricityConsumption)) ?>
      <?= $tr('Kiinteistövero', $float($ls->estateTax), ' €/kk') ?>
      <?= $tr('Muut maksut', $float($ls->otherFees), ' €/kk') ?>
      </tbody>
    </table>
  </section>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

<!--
<?php var_dump($ls) ?>
-->

<?php get_footer(); // site theme footer ?>
