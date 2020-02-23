<!--
***************************************************************************************************
    FICHE D'UN ARTISTE
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php
// Définition variable de niveau
$niveau="../../";

// Inclusion du fichier de configuration
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
// GESTION QUERYSTRING
// -------------------
// Recupération du id_artiste
$strIdArtiste = $_GET['id_artiste'];

//**************************************************************************************
// VARIABLES
// ---------
// 1. Variables pour consultation jour evenement
$arrMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

// 2. Variables pour affichage images
// a) Tableau pour images (en attendant optimisation)
$arrImagesArtiste = array();
for ($intCpt=0; $intCpt<4; $intCpt++){
    $arrImagesArtiste[$intCpt] = $strIdArtiste . "_img" . ($intCpt+1) . "_carre";
}

// b) Tableau pour affichage
$arrImagesAffichees = array();
for ($intCpt=0; $intCpt<4; $intCpt++){
    // c) Variable hasard images
    $intImageHasard = rand(0,count($arrImagesArtiste)-1);
    array_push($arrImagesAffichees, $arrImagesArtiste[$intImageHasard]);
    array_splice($arrImagesArtiste, $intImageHasard, 1);
}

// VARIABLE POUR JOUR DE LA SEMAINE
$strJourSemaine = "";



//**************************************************************************************
// REQUETES - POUR AFFICHER EVEMENTS (CHAMPS DE TI_EVENEMENT + T_LIEU)
// -------------------------------------------------------------------
$strRequete = 'SELECT nom_lieu, date_et_heure, HOUR(date_et_heure) AS heureEve, MINUTE(date_et_heure) AS minutesEve, DAYOFMONTH(date_et_heure) AS jourEve, MONTH(date_et_heure) AS moisEve
                   FROM ti_evenement INNER JOIN t_lieu ON ti_evenement.id_lieu = t_lieu.id_lieu
                   WHERE ti_evenement.id_artiste = ' . $strIdArtiste . '
                   ORDER BY date_et_heure';

$pdosResultatEvenement = $pdoConnexion->query($strRequete);

$arrInfosEvenementsArtiste = array();
foreach ($pdosResultatEvenement AS $ligne)
{
    $arrInfoEvenementArtiste = array();
    $arrInfoEvenementArtiste['nom_lieu'] = $ligne['nom_lieu'];
    $arrInfoEvenementArtiste['date_et_heure'] = $ligne['date_et_heure'];
    // ***** Façon d'écrire les alternatives avec seulement deux options sur une ligne en php *****
    $ligne['heureEve']<=9 ? $arrInfoEvenementArtiste['heureEve'] = "0" . $ligne['heureEve'] : $arrInfoEvenementArtiste['heureEve'] = $ligne['heureEve'];
    $ligne['minutesEve']<=9 ? $arrInfoEvenementArtiste['minutesEve'] = "0" . $ligne['minutesEve'] : $arrInfoEvenementArtiste['minutesEve'] = $ligne['minutesEve'];
    $arrInfoEvenementArtiste['jourEve'] = $ligne['jourEve'];
    $arrInfoEvenementArtiste['moisEve'] = $ligne['moisEve'];

    array_push($arrInfosEvenementsArtiste, $arrInfoEvenementArtiste);
}

$pdosResultatEvenement->closeCursor();





//**************************************************************************************
// REQUETES - POUR AFFICHER INFOS ARTISTE (CHAMPS DE T_ARTISTE)
// ------------------------------------------------------------
$strRequeteInfos = 'SELECT nom_artiste, description, provenance, site_web_artiste
                        FROM t_artiste
                        WHERE id_artiste = ' . $strIdArtiste;

$pdosResultatInfosArtiste = $pdoConnexion->query($strRequeteInfos);

$arrInfosArtiste = $pdosResultatInfosArtiste->fetch();

$pdosResultatInfosArtiste->closeCursor();

// Requete supplémentaire pour aller chercher les styles
$strRequeteStyles = 'SELECT nom_style
                         FROM t_style
                         INNER JOIN ti_style_artiste ON t_style.id_style=ti_style_artiste.id_style
                         WHERE id_artiste=' . $strIdArtiste;

$pdosResultatStyles = $pdoConnexion->query($strRequeteStyles);

for ($intCpt=0; $ligne=$pdosResultatStyles->fetch(); $intCpt++)
{
    $arrInfosArtiste['style'][$intCpt]=$ligne['nom_style'];
}

$pdosResultatStyles->closeCursor();



//**************************************************************************************
// REQUETES - POUR AFFICHER ARTISTES DE MÊME GENRE (CHAMPS DE T_ARTISTE)
// ---------------------------------------------------------------------
$strRequete = 'SELECT DISTINCT t_artiste.id_artiste, nom_artiste 
                   FROM t_artiste INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste 
                   WHERE id_style IN (SELECT id_style FROM ti_style_artiste WHERE id_artiste=' . $strIdArtiste . ') AND ti_style_artiste.id_artiste!=' . $strIdArtiste;

$pdosResultatSemblables = $pdoConnexion->query($strRequete);

$arrArtistesSemblables = array();
foreach ($pdosResultatSemblables AS $ligne)
{
    $arrArtisteSemblable = array();
    $arrArtisteSemblable['id_artiste'] = $ligne['id_artiste'];
    $arrArtisteSemblable['nom_artiste'] = $ligne['nom_artiste'];
    array_push($arrArtistesSemblables, $arrArtisteSemblable);
}

$pdosResultatSemblables->closeCursor();

$arrArtistesSemblablesChoisis = array();
for ($intCpt=0; $intCpt<3; $intCpt++)
{
    // Variable de hasard pour l'affichage
    $intNbHasardSemblable = rand(0,count($arrArtistesSemblables)-1);
    if (count($arrArtistesSemblables)>0) {
        array_push($arrArtistesSemblablesChoisis, $arrArtistesSemblables[$intNbHasardSemblable]);
        array_splice($arrArtistesSemblables, $intNbHasardSemblable, 1);
    }
}
?>

<!-- DOCTYPE + HEADER ************************************ -->
<?php require_once($niveau . 'inc/fragments/header.inc.php')?>

<main id="contenu" class="fiche">
    <div class="deco_background">
        <section class="fiche__banner">
            <div class="conteneur">
                <picture class="fiche__banner_imgArtiste">
                    <source media="(max-width:600px)" srcset="images/artistes/imgPrincipale/<?php echo $strIdArtiste?>_imgPrincipale_carre_w600.jpg 1x, images/artistes/imgPrincipale/<?php echo $strIdArtiste?>_imgPrincipale_carre_w1200.jpg 2x"/>
                    <source media="(min-width:601px)" srcset="images/artistes/imgPrincipale/<?php echo $strIdArtiste?>_imgPrincipale_rect_w490.jpg 1x, images/artistes/imgPrincipale/<?php echo $strIdArtiste?>_imgPrincipale_rect_w980.jpg 2x"/>
                    <img src="images/artistes/imgPrincipale/<?php echo $strIdArtiste?>_imgPrincipale_rect_w490.jpg" alt="image principale de <?php echo $arrInfosArtiste['nom_artiste']?>"/>
                </picture>
                <div class="fiche__banner_espaceNom">
                    <div class="fiche__banner_eleGraph">
                        <h1><?php echo $arrInfosArtiste['nom_artiste']?></h1>
                        <span class="fiche__banner_style">
                                    <?php
                                    $strStyles = "";
                                    for ($intCpt=0; $intCpt<count($arrInfosArtiste['style']); $intCpt++)
                                    {
                                        $strStyles != "" ? $strStyles = $strStyles . " / " . $arrInfosArtiste['style'][$intCpt] : $strStyles = $arrInfosArtiste['style'][$intCpt];
                                    }
                                    echo $strStyles ?>
                                </span>
                    </div>
                </div>
            </div>
        </section>

        <div class="fiche__espaceInfoArtiste conteneur">
            <!-- BIOGRAPHIE ARTISTE ************************************************************************************************************************************** -->
            <section class="fiche__bioArtiste bioArtiste">
                <h2 class="bioArtiste__titre">Biographie</h2>
                <ul class="bioArtiste__liste">
                    <li class="bioArtiste__listeItem screen-reader-only">
                        <h3>Styles : </h3>
                        <?php
                        $strStyles = "";
                        for ($intCpt=0; $intCpt<count($arrInfosArtiste['style']); $intCpt++)
                        {
                            $strStyles != "" ? $strStyles = $strStyles . " / " . $arrInfosArtiste['style'][$intCpt] : $strStyles = $arrInfosArtiste['style'][$intCpt];
                        }
                        echo $strStyles ?>
                    </li>
                    <li class="bioArtiste__listeItem bioArtiste__provenance">
                        <h3 class="screen-reader-only">Provenance : </h3>
                        <?php echo $arrInfosArtiste['provenance']?>
                    </li>
                    <li class="bioArtiste__listeItem bioArtiste__description">
                        <h3 class="screen-reader-only">Description : </h3>
                        <?php echo $arrInfosArtiste['description']?>
                    </li>
                    <li class="bioArtiste__listeItem bioArtiste__siteWeb">
                        <?php
                        if ($arrInfosArtiste['site_web_artiste']){?>
                            <h3 class="screen-reader-only">Site web artiste : </h3>
                            <a href="<?php echo $arrInfosArtiste['site_web_artiste']?>">
                                Site web de <?php echo $arrInfosArtiste['nom_artiste']?></a>
                            <?php
                        }?>
                    </li>
                    <li class="bioArtiste__listeItem bioArtiste__reseauxSociaux">
                        <h3 class="screen-reader-only">Réseaux sociaux artiste : </h3>
                        <ul class="bioArtiste__sousListe">
                            <!-- ******** NE PAS OUBLIER : Faire le lien avec la font/bibliothèque font awesome ********* -->
                            <li class="bioArtiste__sousListeItem">
                                <a href="#">
                                    <span class="fa fa-facebook" aria-hidden="true"></span>
                                    <span class="screen-reader-only">Facebook</span>
                                </a>
                            </li>
                            <li class="bioArtiste__sousListeItem">
                                <a href="#">
                                    <span class="fa fa-twitter" aria-hidden="true"></span>
                                    <span class="screen-reader-only">Twitter</span>
                                </a>
                            </li>
                            <li class="bioArtiste__sousListeItem">
                                <a href="#">
                                    <span class="fa fa-youtube" aria-hidden="true"></span>
                                    <span class="screen-reader-only">Instagram</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </section>

            <!-- IMAGES ARTISTE ************************************************************************************************************************************** -->
            <section class="fiche__imagesArtiste imagesArtiste">
                <h2 class="screen-reader-only">Photos</h2> <!-- AJOUTER class="screen-reader-only" -->
                <?php
                if ($arrImagesAffichees) {
                    for ($intCpt=0; $intCpt<count($arrImagesAffichees); $intCpt++)
                    {?>
                        <picture class="fiche__imagesArtiste_img">
                            <source media="(max-width:600px)" srcset="images/artistes/imgVisionneuse/<?php echo $arrImagesAffichees[$intCpt]?>_w600.jpg 1x, images/artistes/imgVisionneuse/<?php echo $arrImagesAffichees[$intCpt]?>_w1200.jpg 2x"/>
                            <source media="(min-width:601px)" srcset="images/artistes/imgVisionneuse/<?php echo $arrImagesAffichees[$intCpt]?>_w500.jpg 1x, images/artistes/imgVisionneuse/<?php echo $arrImagesAffichees[$intCpt]?>_w1000.jpg 2x"/>
                            <img src="images/artistes/imgVisionneuse/<?php echo $arrImagesAffichees[$intCpt]?>_w500.jpg" alt="Image <?php echo $intCpt ?> pour <?php echo $arrInfosArtiste['nom_artiste']?>"/>
                        </picture>
                        <?php
                    }
                }?>
            </section>

            <!-- EXTRAITS AUDIO ARTISTE ************************************************************************************************************************************** -->
            <section class="fiche__extraitsArtiste extraitsArtiste">
                <h2 class="extraitsArtiste__titre">Extraits audio</h2> <!-- AJOUTER class="screen-reader-only" -->
                <picture class="extraitsArtiste__lecteurAudio">
                    <source media="(max-width:600px)" srcset="images/elementsGraphiques/fiche_lecteurAudio_mobile.png"/>
                    <source media="(min-width:601px)" srcset="images/elementsGraphiques/fiche_lecteurAudio_table.png"/>
                    <img src="images/elementsGraphiques/fiche_lecteurAudio_mobile.png" alt="placeholder lecteur audio"/>
                </picture>

            </section>

            <!-- EVENEMENTS ARTISTE ************************************************************************************************************************************** -->
            <section class="fiche__evenementsArtiste evenementsArtiste">
                <h2 class="h2--blanc evenementsArtiste__titre">Shows</h2>
                <ul class="evenementsArtiste__liste">
                    <?php
                    for ($intCpt=0; $intCpt<count($arrInfosEvenementsArtiste); $intCpt++)
                    {?>
                        <li class="evenementsArtiste__listeItem">
                            <p class="evenementsArtiste__nomLieu">
                                <?php echo $arrInfosEvenementsArtiste[$intCpt]['nom_lieu']?>
                            </p>
                            <p class="evenementsArtiste__infosEvenement">
                                <time datetime="<?php echo $arrInfosEvenementsArtiste[$intCpt]['date_et_heure']?>">
                                    <?php switch ($arrInfosEvenementsArtiste[$intCpt]['jourEve']) {
                                        case "8" : $strJourSemaine = 'Jeu';
                                            break;
                                        case "9" : $strJourSemaine = 'Ven';
                                            break;
                                        case "10" : $strJourSemaine = 'Sam';
                                            break;
                                        case "11" : $strJourSemaine = 'Dim';
                                            break;
                                    }?>
                                    <span class="evenementsArtiste__infosEvenement_jourSemaine"><?php echo $strJourSemaine?></span>
                                                <span class="evenementsArtiste__infosEvenement_jour"><?php echo $arrInfosEvenementsArtiste[$intCpt]['jourEve']?></span>
                                                <span class="evenementsArtiste__infosEvenement_mois"><?php echo $arrMois[$arrInfosEvenementsArtiste[$intCpt]['moisEve']-1]?></span>
                                                <span class="evenementsArtiste__infosEvenement_heure"><?php echo $arrInfosEvenementsArtiste[$intCpt]['heureEve'] . "h" . $arrInfosEvenementsArtiste[$intCpt]['minutesEve']?></span>

                                </time>
                            </p>
                        </li>
                        <?php
                    }?>
                </ul>
            </section>
        </div>


        <?php if (count($arrArtistesSemblablesChoisis)!=0) { ?>
            <section class="espaceArtistesProposes">
                <div class="conteneur">
                    <h2 class="espaceArtistesProposes__titre">Vous allez adorer</h2>
                    <ul class="espaceArtistesProposes__liste">
                        <?php
                        for ($intCpt = 0; $intCpt < count($arrArtistesSemblablesChoisis); $intCpt++) {
                            ?>
                            <li class="espaceArtistesProposes__listeItem">
                            <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>">
                                <picture>
                                    <source media="(max-width:600px)"
                                            srcset="images/artistes/imgPrincipale/<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>_imgPrincipale_carre_w490.jpg 1x, images/artistes/imgPrincipale/<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>_imgPrincipale_carre_w980.jpg 2x"/>
                                    <source media="(min-width:601px)"
                                            srcset="images/artistes/imgPrincipale/<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>_imgPrincipale_carre_w320.jpg 1x, images/artistes/imgPrincipale/<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>_imgPrincipale_carre_w640.jpg 2x"/>
                                    <img src="images/artistes/imgPrincipale/<?php echo $arrArtistesSemblablesChoisis[$intCpt]['id_artiste'] ?>_imgPrincipale_carre_w320.jpg"
                                         alt="<?php echo $arrArtistesSemblablesChoisis[$intCpt]['nom_artiste'] ?>"
                                         class="espaceArtistesProposes__listeItem_image"/>
                                </picture>
                                <span class="espaceArtistesProposes__iconePlus bouton">
                                            <svg class="svg" viewBox="0 0 2000 2000" xmlns="http://www.w3.org/2000/svg">
                                              <circle class="espaceArtistesProposes__cercle" cx="1000" cy="1000" r="1000"/>
                                            </svg>
                                            <span class="fa fa-plus espaceArtistesProposes__plus" aria-hidden="true"></span>
                                        </span>
                                <h3 class="espaceArtistesProposes__nomArtiste bouton"><?php echo $arrArtistesSemblablesChoisis[$intCpt]['nom_artiste'] ?></h3>
                            </a>
                            </li><?php
                        } ?>
                    </ul>
                </div>
            </section>
            <?php
        }
        ?>

        <!-- COMPOSITES *************************************************** -->
        <div class="conteneur conteneur__clearfix">
            <!-- 1. LIEUX -->
            <?php require_once($niveau . 'inc/fragments/composite_lieux.inc.php')?>

            <!-- 2. TARIFS -->
            <?php require_once($niveau . 'inc/fragments/composite_tarifs.inc.php')?>
        </div>

        <!-- 3. CONTACT -->
        <?php require_once($niveau . 'inc/fragments/composite_contact.inc.php')?>
    </div>
</main>

<a href="#haut" class="screen-reader-only focusable">Haut de page</a>

<!-- FOOTER ********************************************** -->
<?php require_once($niveau . 'inc/fragments/footer.inc.php')?>

<!-- BALISES SCRIPT + BALISES FERMANTES BODY & HTML ************** -->
<?php require_once($niveau . 'inc/fragments/balises_script.inc.php')?>


