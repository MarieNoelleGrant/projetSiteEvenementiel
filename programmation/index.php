<!--
***************************************************************************************************
    PROGRAMMATION - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php
    $niveau = "../";

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
    // 1. Variable array pour les mois
    $arrMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');


    //**************************************************************************************
    // REQUÊTE POUR FILTRE JOURS
    // --------------------------
    $strRequete = 'SELECT DISTINCT DAYOFMONTH(date_et_heure) AS jour_evenement, MONTH(date_et_heure) AS mois_evenement
                   FROM ti_evenement';

    $pdosResultatDatesFiltre = $pdoConnexion->query($strRequete);

    $arrJoursFiltre = array();
    for ($intCpt=0; $ligne = $pdosResultatDatesFiltre->fetch(); $intCpt++)
    {
        $arrJoursFiltre[$intCpt]['id_date'] = $intCpt;
        $arrJoursFiltre[$intCpt]['jour_evenement'] = $ligne['jour_evenement'];
        $arrJoursFiltre[$intCpt]['mois_evenement'] = $ligne['mois_evenement'];
    }

    $pdosResultatDatesFiltre->closeCursor();


    //**************************************************************************************
    // GESTION QUERYSTRING
    // -------------------

    // 1. Récuperation du jour filtré dans le queryString

    if(isset($_GET['id_date'])===true)
    {
        $strIdJourFiltre = $_GET['id_date'];
    }
    else
    {
        $strIdJourFiltre = "0";
    }

    //**************************************************************************************
    // REQUÊTE POUR INFOS DES ÉVÈNEMENTS
    // ---------------------------------
    $strRequeteEvenements = 'SELECT t_artiste.id_artiste, nom_artiste, nom_lieu, date_et_heure, MONTH(date_et_heure) AS mois_evenement, DAYOFMONTH(date_et_heure) AS jour_evenement, HOUR(date_et_heure) AS heure_evenement, MINUTE(date_et_heure) AS minutes_evenement
                             FROM (t_artiste INNER JOIN ti_evenement ON t_artiste.id_artiste = ti_evenement.id_artiste) INNER JOIN t_lieu ON ti_evenement.id_lieu = t_lieu.id_lieu
                             WHERE DAYOFMONTH(date_et_heure) =' . $arrJoursFiltre[$strIdJourFiltre]['jour_evenement'] . '
                             ORDER BY nom_lieu, date_et_heure';

    $pdosResultatEvenements = $pdoConnexion->query($strRequeteEvenements);

    $arrInfosEvenements = array();
    foreach ($pdosResultatEvenements AS $ligne)
    {
        $arrInfoEvenement = array();
        $arrInfoEvenement['id_artiste'] = $ligne['id_artiste'];
        $arrInfoEvenement['nom_artiste'] = $ligne['nom_artiste'];
        $arrInfoEvenement['nom_lieu'] = $ligne['nom_lieu'];
        $arrInfoEvenement['date_et_heure'] = $ligne['date_et_heure'];
        $arrInfoEvenement['mois_evenement'] = $ligne['mois_evenement'];
        $arrInfoEvenement['jour_evenement'] = $ligne['jour_evenement'];
        $ligne['heure_evenement']<=9 ? $arrInfoEvenement['heure_evenement'] = "0" . $ligne['heure_evenement'] : $arrInfoEvenement['heure_evenement'] = $ligne['heure_evenement'];
        $ligne['minutes_evenement']<=9 ? $arrInfoEvenement['minutes_evenement'] = "0" . $ligne['minutes_evenement'] : $arrInfoEvenement['minutes_evenement'] = $ligne['minutes_evenement'];

        // *** Récupération des styles multiples avec nouvelle requete et boucle
        // Initialisation des styles multiples
        $arrInfoEvenement['styles'] = "";

        // Faire une requête pour les styles de cet artiste
        $strRequeteStyles = 'SELECT nom_style
                             FROM t_style
                             INNER JOIN ti_style_artiste ON t_style.id_style=ti_style_artiste.id_style
                             WHERE id_artiste=' . $arrInfoEvenement['id_artiste'];

        $pdosResultatStyles = $pdoConnexion->query($strRequeteStyles);

        for ($intCptStyle=0;$ligneStyle=$pdosResultatStyles->fetch();$intCptStyle++)
        {
            // Si la liste des styles n'est pas vide
            if($arrInfoEvenement['styles']!="")
            {
                // Ajoute une séparation
                $arrInfoEvenement['styles']=$arrInfoEvenement['styles'].", ";
            }
            // Ajoute en suite l'identifiant du style
            $arrInfoEvenement['styles']=$arrInfoEvenement['styles'].$ligneStyle["nom_style"];
        }

        $pdosResultatStyles->closeCursor();

        array_push($arrInfosEvenements, $arrInfoEvenement);
    }

    $pdosResultatEvenements->closeCursor();
?>

<!-- DOCTYPE + HEADER ************************************ -->
<?php require_once($niveau . 'inc/fragments/header.inc.php')?>

    <main id="contenu">
        <div class="conteneur">
            <!-- AFFICHAGE DES FILTRES -->
            <h1>Programmation</h1>
            <section>
                <h2><?php echo $arrJoursFiltre[$strIdJourFiltre]['jour_evenement'] . " " . $arrMois[$arrJoursFiltre[$strIdJourFiltre]["mois_evenement"]-1] ?></h2>
                <p>
                    <?php
                    for ($intCpt=0; $intCpt<count($arrJoursFiltre); $intCpt++)
                    {?>
                        <a href="programmation/index.php?id_date=<?php echo $intCpt ?>"><span><?php echo $arrJoursFiltre[$intCpt]['jour_evenement']?></span></a>
                    <?php
                    }
                    ?>
                </p>
            </section>

            <!-- AFFICHAGE DES ÉVÈNEMENTS (listes imbriquées) -->
            <section>
                <ul>
                    <?php
                    $strNomLieuAvant = "";
                    for ($intCpt=0; $intCpt<count($arrInfosEvenements); $intCpt++)
                    {
                        if ($arrInfosEvenements[$intCpt]['nom_lieu'] != $strNomLieuAvant ) {
                            if ($strNomLieuAvant != "") {
                                ?></ul></li><?php
                            }

                            $strNomLieuAvant = $arrInfosEvenements[$intCpt]['nom_lieu'];
                            ?>
                            <li>
                                <h3><?php echo $arrInfosEvenements[$intCpt]['nom_lieu']?></h3>
                            <ul>
                            <?php
                        }?>
                        <li>
                            <div>
                                <time datetime="<?php echo $arrInfosEvenements[$intCpt]['date_et_heure']?>">
                                    <?php echo $arrInfosEvenements[$intCpt]['heure_evenement'] . "h" . $arrInfosEvenements[$intCpt]['minutes_evenement'] . ", "?>
                                </time>
                                <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrInfosEvenements[$intCpt]['id_artiste']?>">
                                    <h4><?php echo $arrInfosEvenements[$intCpt]['nom_artiste']?></h4>
                                    <img src="images/artistes/<?php echo $arrInfosEvenements[$intCpt]['id_artiste']?>_imgPrincipale" alt="<?php echo $arrInfosEvenements[$intCpt]['nom_artiste']?>"/>
                                </a>
                                <h4><?php echo " (" . $arrInfosEvenements[$intCpt]['styles'] . ")"?></h4>
                            </div>
                        </li><?php
                    }?>
                </ul>
            </section>
        </div>

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
