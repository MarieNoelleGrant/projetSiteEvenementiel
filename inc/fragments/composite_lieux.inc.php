<!--
***************************************************************************************************
    FRAGMENTS : COMPOSITES - LIEUX - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->
<?php
    //**************************************************************************************
    // REQUETES - ELEMENTS POUR COMPOSITES
    // ------------------------------------
    // 1. LIEUX
    $strRequete = 'SELECT id_lieu, nom_lieu, no_civique, rue, site_web_lieu, indications
                       FROM t_lieu';

    $pdosResultatInfosLieux = $pdoConnexion->query($strRequete);

    $arrLieux = array();
    foreach ($pdosResultatInfosLieux AS $ligne){
        $arrLieu = array();
        $arrLieu['id_lieu'] = $ligne['id_lieu'];
        $arrLieu['nom_lieu'] = $ligne['nom_lieu'];
        $arrLieu['no_civique'] = $ligne['no_civique'];
        $arrLieu['rue'] = $ligne['rue'];
        $arrLieu['site_web_lieu'] = $ligne['site_web_lieu'];
        $arrLieu['indications'] = $ligne['indications'];
        array_push($arrLieux, $arrLieu);
    }

    $pdosResultatInfosLieux->closeCursor();

if (strpos($_SERVER['PHP_SELF'], 'fiche') || strpos($_SERVER['PHP_SELF'], 'artistes') || strpos($_SERVER['PHP_SELF'], 'programmation')) { ?>
<!--    <div class="conteneur clearfix">-->
        <aside class="composite2eNiveau lieux">
            <p class="h2 lieux__titre">Lieux</p>
            <picture>
                <source media="(max-width:600px)" srcset="images/composites/lieux_carteGoogle_aside_mobile.jpg">
                <source media="(min-width:601px)" srcset="images/composites/lieux_carteGoogle_aside.jpg">
                <img src="images/composites/lieux_carteGoogle_aside.jpg" alt="carte api google maps" class="lieux__imgCarte"/>
            </picture>
            <ul class="lieux__liste">
            <?php
            for ($intCpt = 0; $intCpt < count($arrLieux); $intCpt++) {
                ?>
                <li class="lieux__infosLieu lieux__listeItem">
                    <span class="h3 lieux__titreLieu"><?php echo $arrLieux[$intCpt]['nom_lieu'] ?></span>
                    <ul class="lieux__sousListe">
                        <li class="lieux__adresseLieu lieux__sousListeItem">
                            <?php echo $arrLieux[$intCpt]['no_civique'] . ", " . $arrLieux[$intCpt]['rue'] ?>
                        </li>
                        <?php
                        if ($arrLieux[$intCpt]['site_web_lieu']) {
                            ?>
                            <li class="lieux__siteWebLieu lieux__sousListeItem">
                                <a href="<?php echo $arrLieux[$intCpt]['site_web_lieu'] ?>"><?php echo $arrLieux[$intCpt]['site_web_lieu'] ?></a>
                            </li>
                            <?php
                        }
                        if ($arrLieux[$intCpt]['indications']) {
                            ?>
                            <li class="lieux__indicationsLieu lieux__sousListeItem">
                                <?php echo $arrLieux[$intCpt]['indications'] ?>
                            </li>
                            <?php
                        } ?>
                    </ul>
                </li>
                <?php
            } ?>
            </ul>
        </aside>
<!--    </div>-->
<?php
}

else {?>

<!--    <div class="conteneur clearfix">-->
        <section class="compositeAccueil lieux">
            <h2 class="lieux__titre">Lieux</h2>
            <picture>
                <source media="(max-width:600px)" srcset="images/composites/lieux_carteGoogle_aside_mobile.jpg">
                <source media="(min-width:601px)" srcset="images/composites/lieux_carteGoogle_aside.jpg">
                <img src="images/composites/lieux_carteGoogle_aside.jpg" alt="carte api google maps" class="lieux__imgCarte"/>
            </picture>
            <ul class="lieux__liste">
            <?php
            for ($intCpt = 0; $intCpt < count($arrLieux); $intCpt++) {
                ?>
                <li class="lieux__infosLieu lieux__listeItem">
                    <h3 class="lieux__titreLieu"><?php echo $arrLieux[$intCpt]['nom_lieu'] ?></h3>
                    <ul class="lieux__sousListe">
                        <li class="lieux__adresseLieu lieux__sousListeItem">
                            <?php echo $arrLieux[$intCpt]['no_civique'] . ", " . $arrLieux[$intCpt]['rue'] ?>
                        </li>
                        <?php
                        if ($arrLieux[$intCpt]['site_web_lieu']) {
                            ?>
                            <li class="lieux__siteWebLieu lieux__sousListeItem">
                                <a href="<?php echo $arrLieux[$intCpt]['site_web_lieu'] ?>"><?php echo $arrLieux[$intCpt]['site_web_lieu'] ?></a>
                            </li>
                            <?php
                        }
                        if ($arrLieux[$intCpt]['indications']) {
                            ?>
                            <li class="lieux__indicationsLieu lieux__sousListeItem">
                                <?php echo $arrLieux[$intCpt]['indications'] ?>
                            </li>
                            <?php
                        } ?>
                    </ul>
                </li>
                <?php
            } ?>
            </ul>
        </section>
<!--    </div>-->
<?php
}?>
