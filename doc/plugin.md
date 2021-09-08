# Pluginin asennus ja konfigurointi

## Asennus ja käyttöönotto

### Vaatimukset

- PHP:n SimpleXML-laajennus asennettu (asetettu oletuksena PHP:n mukana)
- PHP-versio vähintään 7.4

### Asennus

Asenna pluginin tiedostot WordPressin `plugins`-hakemiston alle omaan hakemistoonsa.

Aktivoi plugin WordPress-asetussivulta (Lisäosat > Helmikohteet).

## Käyttö

Luettelon myynnissä olevista kohteista saa upotettua haluamalleen sivulle lisäämällä sivulle lyhytlinkin:

```
[helmikohteet]
````

## Kustomointi

Kohdeluettelon ulkoasua voi muokata CSS:n avulla. Kohdeluettelon elementtien luokissa käytetään etuliitettä `helmik-`.

Tarkempi kuvaus TBD.

### Paketointi jakelua varten

Jos kyseessä on asiakkaalle lähetettävä versio, päivitä versionumero ennen paketointia (tiedostossa [helmikohteet.php](../plugins/helmikohteet/helmikohteet.php)).

Paketoi plugin-hakemisto zip-paketiksi (versionumero kannattaa sisällyttää paketin nimeen):

```console
cd helmikohteet/plugins
zip -r helmikohteet_$VERSION.zip helmikohteet
```
