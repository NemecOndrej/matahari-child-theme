# Výchozí Unifer Šablona #

Toto je repozitář pro naši výchozí šablonu, ze které by měly vycházet všechny naše weby.

## Jak šablonu rozšiřovat/upravovat? ##
Pokud máš nějakou funcki, kterou bys chtěl do šablony přidat nebo upravit něco stávajícího tak si stačí jenom naklonovat tento repozitář, udělat úpravy a commitnout je zpět. Jenom pak nezapomeň úpravy nahrát i na výchozí instalaci WP, kterou používáme a dočteš se o níže. 

## Jak šablonu nainstalovat? ##
Pro naše weby máme připravenou celou výchozí instalaci Wordpressu a základních pluginů. Na [default.test-unifer.cz](https://default.test-unifer.cz/) se můžeš přihlásit do administrace a pomocí pluginu [All-in-One WP Migration](https://cs.wordpress.org/plugins/all-in-one-wp-migration/) si můžeš celou instalaci včetně výchozí šablony vyexportovat a naimportovat na svůj nově vznikající projekt. Pokud nemáš do administrace výchozího webu přístup napiš si nějakému kolegovi kodérovi aby ti ho udělal.

## Features ##

### Mini adminbar ###
Mini adminbar - transformuje výchozí WP administrační lištu (na frontendu) do minimalizované verze - čtvereček v levém horním rohu. Obsahuje jen nejnutnější odkazy - přechod do nástěnky administrace, úprava aktuálního příspěvku, odhlášení, případně zapínání content nápovědy. 
#### Zapnutí Mini adminbar ####
1. Nastavení hodnoty `enable_mini_admin_bar` na `true`, v souboru `functions.php`
2. Import sass souboru `_adminbar.scss` - např. ve `style.scss` + kompilace sassu

# Struktura šablony #

```
unifer-base-theme
|   404.php
|   archive.php
|   author.php
|   category.php
|   footer.php
|   functions.php
|   header.php
|   home.php
|   index.php
|   page.php
|   screenshot.png
|   single-POSTTYPE.php - šablona pro detail vlastní post typu - POSTTYPE je potřeba nahradit za slug vlastní PT
|   single.php
|   style.css
|   tag.php
|   taxonomy-TAXONOMY.php - šablona pro archiv taxonomie - TAXONOMY je potřeba nahradit za slug taxonomie
|___/assets/
|   |___/css/
|   |   |   _design.scss
|   |   |   _fonts.scss
|   |   |   _functions.scss
|   |   |   admin_css.css
|   |   |   admin_css.scss
|   |   |   style.css
|   |   |   sstyle.scss
|   |   |   tinymce_styles.css
|   |   |   tinymce_styles.scss
|
|   |   |___/acf-blocks/
|   |   |   |   _general.scss
|   |   |   |   _TEMPLATE.scss
|   |   |   |   breadcrumbs.scss
|
|   |   |___/components/
|   |   |   |   button.scss
|   |   |   |   form.scss
|   |   |   |   icheckbox.scss
|   |   |   |   selectboxit.scss
|   |   |   |   slick.scss
|   |   |   |   widgets.scss
|
|   |   |___/pages/
|   |   |   |   _TEMPLATE.scss
|
|   |___/favicon/
|   |   |   |   favicon.php
|
|   |___/images/
|   |   |   |   image-template.png
```