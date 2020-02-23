<!--
***************************************************************************************************
    ACCUEIL - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php
    $niveau = "./";

    //Inclusion du fichier de configuration
    include($niveau . 'inc/scripts/config.inc.php');

    //**************************************************************************************
    // POUR MENU (fourni)
    // -------------------
    $menuActifLeOFF = "";
    $menuActifProgrammation = "";
    $menuActifArtistes = "";

    if (strpos($_SERVER['PHP_SELF'], 'artistes')) {
        $suffixe = "Artistes";
    } else if (strpos($_SERVER['PHP_SELF'], 'programmation')) {
        $suffixe = "Programmation";
    } else {
        $suffixe = "LeOFF";
    }

    ${"menuActif" . $suffixe} = "menu__listeItem--actif";


    //**************************************************************************************
    // VARIABLES
    // ---------
    // 1. Variables pour consultation jour evenement
    $arrMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    $arrJours = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');


    //**************************************************************************************
    // REQUETES - POUR CHAMPS T_ACTUALITE
    // ----------------------------------
    $strRequete = 'SELECT titre, date_actualite, DAYOFMONTH(date_actualite) AS jourActualite, MONTH(date_actualite) AS moisActualite, YEAR(date_actualite) AS anneeActualite, auteurs, article
                   FROM t_actualite
                   ORDER BY date_actualite DESC';

    $pdosResultatInfosActualites = $pdoConnexion->query($strRequete);

    $arrToutesActualites = array();
    foreach ($pdosResultatInfosActualites AS $ligne)
    {
        $arrActualite = array();
        $arrActualite['titre'] = $ligne['titre'];
        $arrActualite['date_actualite'] = $ligne['date_actualite'];
        $ligne['jourActualite']<=9 ? $arrActualite['jourActualite'] = "0" . $ligne['jourActualite'] : $arrActualite['jourActualite'] = $ligne['jourActualite'];
        $ligne['moisActualite']<=9 ? $arrActualite['moisActualite'] = "0" . $ligne['moisActualite'] : $arrActualite['moisActualite'] = $ligne['moisActualite'];
        $arrActualite['anneeActualite'] = $ligne['anneeActualite'];
        $arrActualite['auteurs'] = $ligne['auteurs'];

        // POUR SEGMENTER LE TEXTE ET LE LIMITER ***********
        $arrArticle = explode(" ", $ligne['article']);
        if (count($arrArticle)>45)
        {
            array_splice($arrArticle, 45, count($arrArticle));
        }
        $arrActualite['article'] = implode(" ", $arrArticle);

        array_push($arrToutesActualites, $arrActualite);
    }

    $pdosResultatInfosActualites->closeCursor();



    //**************************************************************************************
    // REQUETES - CHOIX 3 ARTISTES SUGGÉRÉS AU HASARD
    // -------------------------------------------------------
    $strRequete = 'SELECT id_artiste, nom_artiste
                   FROM t_artiste';

    $pdosResultatArtistesSug = $pdoConnexion->query($strRequete);

    $arrArtistesSug = array();
    foreach ($pdosResultatArtistesSug AS $ligne)
    {
        $arrSuggestionArtiste = array();
        $arrSuggestionArtiste['id_artiste'] = $ligne['id_artiste'];
        $arrSuggestionArtiste['nom_artiste'] = $ligne['nom_artiste'];
        array_push($arrArtistesSug, $arrSuggestionArtiste);
    }

    $pdosResultatArtistesSug->closeCursor();

    // extraction de la liste complète des artistes de nouveau
    $arrArtistesChoisis=array();
    for ($intCpt=0; $intCpt<=2; $intCpt++)
    {
        $artisteChoisi=rand(0, count($arrArtistesSug)-1);
        // pousser artiste choisi au hasard dans le arrArtistesChoisis
        array_push($arrArtistesChoisis, $arrArtistesSug[$artisteChoisi]);
        // retirer le nom de la liste pour ne pas le piger deux fois
        array_splice($arrArtistesSug, $artisteChoisi, 1);
    }



    //**************************************************************************************
    // REQUETES - ELEMENTS POUR BALISE TIME
    // ------------------------------------
    // ???? AJOUTER UNE ENTRÉE DANS LA BASE DE DONNÉES POUR LES DATES DÉBUT ET FIN EVENEMENT?






?>
    <!-- DOCTYPE + HEADER ************************************ -->
    <?php require_once($niveau . 'inc/fragments/header.inc.php')?>

    <main id="contenu" class="accueil">
        <section class="bannerAccueil">
            <h1 class="visuallyhidden">Festival OFF de Québec</h1>
            <picture>
                <source srcset="images/elementsGraphiques/logoOFF_bannerAccueil_w320.png 1x, images/elementsGraphiques/logoOFF_bannerAccueil_w640.png 2x"/>
                <img src="images/elementsGraphiques/logoOFF_bannerAccueil_w320.png" alt="Festival OFF de Québec" class="bannerAccueil__logo"/>
            </picture>

            <div class="bannerAccueil__dates">
                <span class="screen-reader-only">Du <time datetime="2018-07-08">8</time> au <time datetime="2018-07-11">11</time> juillet</span>
                <picture>
                    <source media="(max-width:600px)" srcset="images/elementsGraphiques/datesOFF_bannerAccueil_mobile_w470.png 1x, images/elementsGraphiques/datesOFF_bannerAccueil_mobile_w940.png 2x"/>
                    <source media="(max-width:600px)" srcset="images/elementsGraphiques/datesOFF_bannerAccueil_table_w255.png 1x, images/elementsGraphiques/datesOFF_bannerAccueil_table_w510.png 2x"/>
                    <img src="images/elementsGraphiques/datesOFF_bannerAccueil_table_w255.png" alt="" class="bannerAccueil__dates_elementGraphique"/>
                </picture>
            </div>
        </section>

        <!-- ACTUALITÉS -->
        <section class="actualites">
            <div class="conteneur">
                <h2 class="actualites__titre screen-reader-only">Actualités</h2>
                <?php
                for ($intCpt=0; $intCpt<=2; $intCpt++) {?>
                <article class="actualites article">
                    <picture>
                        <source media="(max-width:600px)" srcset="http://placehold.it/600x600 1x, http://placehold.it/1200x1200 2x"/>
                        <source media="(min-width:601px)" srcset="http://placehold.it/405x405 1x, http://placehold.it/810x810 2x"/>
                        <img src="http://placehold.it/405x405" alt="image actualité <?php echo ($intCpt+1)?>" class="actualites__image"/>
                    </picture>
                    <div class="article__contenuTextuel">
                        <header>
                            <time datetime="<?php echo $arrToutesActualites[$intCpt]['date_actualite']?>" class="article__date">
                                <?php echo $arrToutesActualites[$intCpt]['jourActualite'] . "/" . $arrToutesActualites[$intCpt]['moisActualite'] . "/" . $arrToutesActualites[$intCpt]['anneeActualite']?>
                            </time>
                            <h3 class="article__titre h4"><?php echo $arrToutesActualites[$intCpt]['titre']?></h3>
                            <p class="article__auteurs"><?php echo $arrToutesActualites[$intCpt]['auteurs']?></p>
                        </header>
                        <p class="article_texte">
                            <?php
                            echo $arrToutesActualites[$intCpt]['article'];
                            if (count(explode(" ", $arrToutesActualites[$intCpt]['article']))>=45)
                            {?>
                                <a href="#">(...)</a><?php
                            }
                            ?>
                        </p>
                    </div>
                    <div class="article__lienSavoirPlus">
                        <a href="#">
                            <span class="article__iconeSavoirPlus"></span>
                            <p>En savoir plus</p>
                        </a>
                    </div>
                </article><?php
                }
                ?>
            </div>
        </section>

        <!-- ARTISTES PROPOSÉS -->
        <aside class="artistesSugeres">
            <div class="conteneur">
                <h2 class="artistesSugeres__titre">À découvrir</h2>
                <?php
                for ($intCpt=0; $intCpt<count($arrArtistesChoisis); $intCpt++)
                {?>
                <div class="artistesSugeres artistePropose">
                    <div>
                        <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>">
                            <picture>
                                <source media="(max-width:600px)" srcset="images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>_imgPrincipale_carre_w600.jpg 1x, images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>_imgPrincipale_carre_w1200.jpg 2x"/>
                                <source media="(min-width:601px)" srcset="images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>_imgPrincipale_carre_w490.jpg 1x, images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>_imgPrincipale_carre_w980.jpg 2x"/>
                                <img src="images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste'] . "_imgPrincipale_carre_w490.jpg"?>"
                                     alt="<?php echo $arrArtistesChoisis[$intCpt]['nom_artiste'] . " image" .$intCpt?>"
                                     class="artistePropose__image"/>
                            </picture>
                            <h3 class="artistePropose__nomArtiste"><?php echo $arrArtistesChoisis[$intCpt]['nom_artiste']?></h3>
                        </a>
                    </div>
                    <ul class="artistePropose__infosPlus">
                        <li class="artistePropose__extrait">
                            <a href="">
                                <span class="artistePropose__icone_extrait"></span>
                                Extrait
                            </a>
                        </li>
                        <li class="artistePropose__dates">
                            <a href="">
                                <span class="artistePropose__icone_dates"></span>
                                Dates
                            </a>
                        </li>
                        <li class="artistePropose__lienFiche">
                            <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>">
                                <span class="artistePropose__icone_lienFiche"></span>
                                Fiche complète
                            </a>
                        </li>
                    </ul>

                </div><?php
                }?>
            </div>
        </aside>

        <!-- COMPOSITES *************************************************** -->
        <div class="conteneur conteneur__clearfix">
            <!-- 1. LIEUX -->
            <?php require_once($niveau . 'inc/fragments/composite_lieux.inc.php')?>

            <!-- 2. TARIFS -->
            <?php require_once($niveau . 'inc/fragments/composite_tarifs.inc.php')?>
        </div>

        <!-- 3. CONTACT -->
        <?php require_once($niveau . 'inc/fragments/composite_contact.inc.php')?>

    </main>

    <a href="#haut" class="screen-reader-only focusable">Haut de page</a>

    <!-- FOOTER ********************************************** -->
    <?php require_once($niveau . 'inc/fragments/footer.inc.php')?>
    <!-- BALISES SCRIPT + BALISES FERMANTES BODY & HTML ************** -->
    <?php require_once($niveau . 'inc/fragments/balises_script.inc.php')?>
