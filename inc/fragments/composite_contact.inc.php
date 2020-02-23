<!--
***************************************************************************************************
    FRAGMENTS : COMPOSITES - CONTACT - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php

//**************************************************************************************
// VARIABLES POUR TEXTE IDENTIQUE DES BALISES 'CONTACT' DE L'ACCUEIL OU PAGES SECONDAIRES
// --------------------------------------------------------------------------------------
$arrContenuTextuelContact = array();
$arrContenuTextuelContact[0] = '110 boulevard René-Lévesque Ouest<br/>C.P. 48036<br/>Québec, Québec<br/>G1R 5R5';
$arrContenuTextuelContact[1] = 'info@quebecoff.org';
$arrContenuTextuelContact[2] = 'media@quebecoff.org';

// Alternative pour l'affichage si dans la page accueil ou dans une page secondaire

if (strpos($_SERVER['PHP_SELF'], 'fiche') || strpos($_SERVER['PHP_SELF'], 'artistes') || strpos($_SERVER['PHP_SELF'], 'programmation')) { ?>

    <aside class="composite2eNiveau contact">
        <div class="conteneur">
            <div class="contact__contenuTextuel">
                <p class="h2 contact__titre">Contact</p>

                <p class="h3 contact__titreSection">Festival OFF de Québec</p>
                <p class="contact__texteSection">
                    <span class="contact__adresse">
                        <?php echo $arrContenuTextuelContact[0] ?>
                    </span>
                    <span class="contact__courriel">
                        <?php echo $arrContenuTextuelContact[1] ?>
                    </span>
                </p>
                <p class="h3 contact__titreSection">Pour les médias</p>
                <p class="contact__texteSection contact__courriel--seul">
                    <?php echo $arrContenuTextuelContact[2] ?>
                </p>
            </div>
            <picture class="contact__imageCarte">
                <source srcset="images/composites/contact_carteStatique_w600.jpg 1x, images/composites/contact_carteStatique_w1200.jpg 2x"/>
                <img src="images/composites/contact_carteStatique_w600.jpg" alt="carte google Maps avec emplacement bureau OFF"/>
            </picture>
        </div>
    </aside>

<?php
}

else {?>

    <section class="compositeAccueil contact">
        <div class="conteneur">
            <div class="contact__contenuTextuel">
                <h2 class="contact__titre">Contact</h2>

                <h3 class="contact__titreSection">Festival OFF de Québec</h3>
                <p class="contact__texteSection">
                    <span class="contact__texteSection_adresse">
                        <?php echo $arrContenuTextuelContact[0] ?>
                    </span>
                    <span class="contact__texteSection contact__courriel">
                        <?php echo $arrContenuTextuelContact[1] ?>
                    </span>
                </p>
                <h3 class="contact__titreSection">Pour les médias</h3>
                <p class="contact__texteSection contact__courriel--seul">
                    <?php echo $arrContenuTextuelContact[2] ?>
                </p>
            </div>

            <picture class="contact__imageCarte">
                <source srcset="images/composites/contact_carteStatique_w600.jpg 1x, images/composites/contact_carteStatique_w1200.jpg 2x"/>
                <img src="images/composites/contact_carteStatique_w600.jpg" alt="carte google Maps avec emplacement bureau OFF"/>
            </picture>
        </div>
    </section>

<?php
}?>