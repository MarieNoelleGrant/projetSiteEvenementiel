<!--
***************************************************************************************************
    LISTE DES ARTISTES
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->


<?php
    // Définition variable de niveau
    $niveau="../";

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
    // GESTION QUERYSTRING
    // -------------------
    // 1. Recupération des styles associés aux artistes dans le queryString

    if(isset($_GET['id_style'])===true)
    {
        $strIdStyle = $_GET['id_style'];
    }
    else
    {
        $strIdStyle = 0;
    }

    // 2. Récuperation du numéro de page dans le queryString

    if(isset($_GET['id_page'])===true)
    {
        $strIdPage = $_GET['id_page'];
    }
    else
    {
        $strIdPage = 0;
    }

    //**************************************************************************************
    // MÉCANISME DE PAGNINATION
    // ------------------------
    // Combien de participants par page?
    $nbArtistesParPage=3;

    // Calcul pour l'index du premier enregistrement
    $enrDepart=$strIdPage*$nbArtistesParPage;


    // ----------------------------------------------------------------
    // REQUETE SQL : Nombre d'enregistrements total selon une sélection
    // ----------------------------------------------------------------
    if($strIdStyle!=0)
    {
        $strRequete = 'SELECT COUNT(*) AS nbEnregistrement
                       FROM t_artiste
                       INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste
                       WHERE ti_style_artiste.id_style =' .$strIdStyle;
    }
    else
    {
        $strRequete = 'SELECT COUNT(*) AS nbEnregistrement 
                       FROM t_artiste';
    }

    $pdosResultatCptEnr = $pdoConnexion->query($strRequete);

    $totalArtistes = $pdosResultatCptEnr->fetch();

    $strArtistes=$totalArtistes['nbEnregistrement'];

    $pdosResultatCptEnr->closeCursor();

    // --------------------------------
    // VARIABLE POUR LE NOMBRE DE PAGES
    // --------------------------------
    $nbPages = ceil($strArtistes / $nbArtistesParPage);



    //**************************************************************************************
    // REQUETES - CHAMPS DE LA TABLE T_ARTISTE
    // ----------------------------------------------------
    // Vérification si filtre de style appliqué
    if ($strIdStyle==0)
    {
        $strRequeteInfos = 'SELECT t_artiste.id_artiste, nom_artiste 
                            FROM t_artiste 
                            ORDER BY nom_artiste
                            LIMIT ' . $enrDepart . ','. $nbArtistesParPage;
    }
    // Si oui, recherche précise par style voulu.
    else
    {
        $strRequeteInfos = 'SELECT t_artiste.id_artiste, nom_artiste
                            FROM t_artiste INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste
                            WHERE id_style=' . $strIdStyle . ' 
                            ORDER BY nom_artiste
                            LIMIT ' . $enrDepart . ','. $nbArtistesParPage;
    }

    $pdosResultatChampsArtistes = $pdoConnexion->query($strRequeteInfos);

    $arrChampsTousArtistes = array();
    foreach ($pdosResultatChampsArtistes as $ligne)
    {
        $arrChampsUnArtiste = array();
        // *** Champs de bases récupérés
        $arrChampsUnArtiste['id_artiste'] = $ligne['id_artiste'];
        $arrChampsUnArtiste['nom_artiste'] = $ligne['nom_artiste'];

        // *** Récupération des styles multiples avec nouvelle requete et boucle
        // Initialisation des styles multiples
        $arrChampsUnArtiste['styles'] = "";

        // Faire une requête pour les styles de cet artiste
        $strRequeteStyles = 'SELECT nom_style
                             FROM t_style
                             INNER JOIN ti_style_artiste ON t_style.id_style=ti_style_artiste.id_style
                             WHERE id_artiste=' . $arrChampsUnArtiste['id_artiste'];

        $pdosResultatStyles = $pdoConnexion->query($strRequeteStyles);

        for ($intCptStyle=0;$ligneStyle=$pdosResultatStyles->fetch();$intCptStyle++)
        {
            // Si la liste des styles n'est pas vide
            if($arrChampsUnArtiste['styles']!="")
            {
                // Ajoute une virgule
                $arrChampsUnArtiste['styles']=$arrChampsUnArtiste['styles'].", ";
            }
            // Ajoute ensuite l'identifiant du style
            $arrChampsUnArtiste['styles']=$arrChampsUnArtiste['styles'].$ligneStyle["nom_style"];
        }

        $pdosResultatStyles->closeCursor();

        array_push($arrChampsTousArtistes, $arrChampsUnArtiste);
    }

    $pdosResultatChampsArtistes->closeCursor();



    //**************************************************************************************
    // REQUETES - CHAPMS TABLE T_STYLE
    // -------------------------------------------
    $strRequete = 'SELECT id_style, nom_style
                   FROM t_style';

    $pdosResultatChampsStyles = $pdoConnexion->query($strRequete);

    $arrTousStyles = array();
    foreach ($pdosResultatChampsStyles as $ligne)
    {
        $arrStyle = array();
        $arrStyle['id_style']=$ligne['id_style'];
        $arrStyle['nom_style']=$ligne['nom_style'];
        array_push($arrTousStyles, $arrStyle);
    }

    $pdosResultatChampsStyles->closeCursor();



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
?>

    <!-- DOCTYPE + HEADER ************************************ -->
    <?php require_once($niveau . 'inc/fragments/header.inc.php')?>

    <main id="contenu">
        <div class="conteneur">
            <h1>Artistes</h1>
            <p>Styles</p>
            <ul>
                <li>
                    <a href="artistes/index.php?id_style=0">Tous les styles</a>
                </li>
                <?php
                for ($intCpt=0; $intCpt<count($arrTousStyles); $intCpt++)
                {?>
                    <li>
                        <a href="artistes/index.php?id_style=<?php echo $arrTousStyles[$intCpt]['id_style']?>">
                            <?php echo $arrTousStyles[$intCpt]['nom_style']?>
                        </a>
                    </li>
                    <?php
                }?>
            </ul>
        </div>

        <section>
            <div class="conteneur">
                <div>
                    <h2>Nos Artistes : </h2>
                    <ul>
                        <?php
                        for ($intCpt=0; $intCpt<count($arrChampsTousArtistes); $intCpt++)
                        {?>
                            <li>
                                <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrChampsTousArtistes[$intCpt]['id_artiste']?>">
                                    <img src="images/artistes/imgPrincipale/<?php echo $arrChampsTousArtistes[$intCpt]['id_artiste']?>_imgPrincipale_carre_w600.jpg" alt="<?php echo $arrChampsTousArtistes[$intCpt]['nom_artiste']?>"/>
                                    <h3><?php echo $arrChampsTousArtistes[$intCpt]['nom_artiste']?></h3>
                                    <h4><?php echo " (" . $arrChampsTousArtistes[$intCpt]['styles'] . ")"?></h4>
                                </a>
                            </li>
                            <?php
                        }?>
                    </ul>
                </div>
                <div>
                    <?php
                    // pour afficher le lien 'précédent'
                    if ($strIdPage>0)
                    {?>
                        <a href="artistes/index.php?id_page=<?php echo ($strIdPage-1);?>&id_style=<?php echo $strIdStyle;?>">Précédent</a>
                        <?php
                    }
                    // pour afficher les numéros des pages (si plus qu'une)
                    if ($nbPages>1)
                    {
                        for ($intCpt=0; $intCpt<$nbPages; $intCpt++)
                        {?>
                            <a href="artistes/index.php?id_page=<?php echo $intCpt?>&id_style=<?php echo $strIdStyle?>"><?php echo ($intCpt+1)?></a>
                            <?php
                        }
                    }
                    // pour afficher le lien 'suivant'
                    if ($strIdPage<$nbPages-1)
                    {?>
                        <a href="artistes/index.php?id_page=<?php echo ($strIdPage+1);?>&id_style=<?php echo $strIdStyle;?>">Suivant</a>
                        <?php
                    }?>
                    <br/>
                    <p>Page <?php echo ($strIdPage+1);?> de <?php echo ($nbPages);?>
                </div>
            </div>
        </section>

        <aside>
            <div class="conteneur">
                <h2>En vedette : </h2>
                <ul>
                    <?php
                    for ($intCpt=0; $intCpt<count($arrArtistesChoisis); $intCpt++)
                    {?>
                        <li>
                            <a href="artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>">
                                <img src="images/artistes/imgPrincipale/<?php echo $arrArtistesChoisis[$intCpt]['id_artiste']?>_imgPrincipale_carre_w600.jpg" alt="<?php echo $arrArtistesChoisis[$intCpt]['nom_artiste']?>"/>
                                <p><?php echo $arrArtistesChoisis[$intCpt]['nom_artiste']?></p>
                            </a>
                        </li>
                        <?php
                    }?>
                </ul>
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