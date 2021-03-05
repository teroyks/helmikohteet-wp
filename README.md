# Helmikohteet

Wordpress-plugin asuntokohteiden näyttämiseen

## Kehitysympäristö

### Vaatimukset

- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Ympäristön käynnistys

```console
docker-compose up
```

Wordpress asentuu projektihakemiston alihakemistoon `wordpress`. MySQL-tietokanta näkyy portissa 18766 (kirjautumistiedot löytyvät Docker-konfiguraatiotiedostosta).

### Wordpressin konfigurointi

1. Wordpress on osoitteessa [localhost](http://localhost/).
2. Asenna sivusto normaalisti kehitysympäristöön:
   1. kieli: suomi
   2. sivuston nimi, käyttäjätunnus, salasana: vapaavalintaiset
   3. sähköpostiosoite: anna toimiva osoite

### Pluginin käyttöönotto

Pluginin koodi on kehitysympäristössä valmiiksi hakemistossa [`plugins/helmikohteet`](plugins/helmikohteet). Käyttöönotto: ks. [pluginin ohje](doc/plugin.md).

### Ulkoasun muokkaus

Kohdelistauksen HTML-koodi luodaan pluginin päätiedostossa `helmikohteet.php`. Tyylimääritykset ovat [`helmikohteet.css`](plugins/helmikohteet/public/css/helmikohteet.css)-tiedostossa.
