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
  <td>$label</td>
  <td>$value$suffix</td>
</tr>
EOF : '';

// formats a non-empty value as float
$float = fn($val) => $val ? number_format($val, 2, ',', ' ') : '';

?>

<?php get_header(); // site theme header ?>

<main class="helmi-listing">
  <section class="helmi-heading">
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
  <section class="helmi-pictures">
    <?php foreach ($ls->pictureUrls as $url): ?>
      <div><?= $url ?></div>
    <?php endforeach ?>
  </section>
  <section class="helmi-details">
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
  <section class="helmi-details">

  </section>
  <section class="helmi-details">

  </section>
  <section class="helmi-details">

  </section>
  <section class="helmi-details">

  </section>
</main>

<pre><?php var_dump($ls) ?></pre>
<!--
<?php var_dump($ls) ?>
-->

<?php get_footer(); // site theme footer ?>
