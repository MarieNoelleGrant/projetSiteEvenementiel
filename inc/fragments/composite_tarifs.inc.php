<!--
***************************************************************************************************
    FRAGMENTS : COMPOSITES - TARIFS - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php
    //**************************************************************************************
    // VARIABLES POUR CHEMIN ANCRE COMPOSITE TARIFS (permet d'éviter beaucoup de php dans le body!)
    // --------------------------------------------
    switch (true) {
        case strpos($_SERVER['PHP_SELF'], 'fiche') : $cheminAncreTarifs = "artistes/fiche/index.php?id_artiste=".$strIdArtiste;
            break;
        case strpos($_SERVER['PHP_SELF'], 'artistes') : $cheminAncreTarifs = "artistes/index.php?id_page=".$strIdPage."&id_style=".$strIdStyle;
            break;
        case strpos($_SERVER['PHP_SELF'], 'programmation') : $cheminAncreTarifs = "programmation/index.php?id_date=".$strIdJourFiltre;
            break;
        default : $cheminAncreTarifs = "index.php";
    }
?>




<?php
if (strpos($_SERVER['PHP_SELF'], 'fiche') || strpos($_SERVER['PHP_SELF'], 'artistes') || strpos($_SERVER['PHP_SELF'], 'programmation')) { ?>

        <aside class="composite2eNiveau tarifs">
            <p class="h2 tarifs__titre">Tarifs</p>
            <ul class="tarifs__liste">
                <li class="tarifs__listeItem tarifs__listeItem--fondCouleur">
                    <a href="<?php echo $cheminAncreTarifs ?>#achatPasseport">
                        <span class="tarifs__prixTarifs tarifs__span">10<span class="tarifs__prixTarifs--signeComplement">$</span></span>
                        <span class="tarifs__texteTarifs tarifs__span"><span class="tarifs__titreTarifs">Passeport </span>pour toute la durée du festival</span>
                    </a>
                </li>
                <li class="tarifs__listeItem">
                    <span class="tarifs__prixTarifs tarifs__span">5<span class="tarifs__prixTarifs--signeComplement">$/soir*</span></span>
                    <span class="tarifs__texteTarifs tarifs__span">Spectacles à la <span class="tarifs__titreTarifs">Méduse</span>* à la porte</span>
                </li>
                <li class="tarifs__listeItem">
                    <span class="tarifs__prixTarifs tarifs__prixTarifs--texteSeul tarifs__span">Gratuit</span>
                    <span class="tarifs__texteTarifs tarifs__span">Spectacles au <span class="tarifs__titreTarifs">Bar le Sacrilège, parvis Église st-roch, Fou Bar ou Extérieurs</span></span>
                </li>
            </ul>

            <p id="achatPasseport" class="h3 tarifs__titrePasseport passeport">Achetez vos passeports :</p>
            <ul class="passeport__liste">
                <li class="passeport__listeItem">
                    <span class="h4 passeport__choix">En ligne au <a href="http://www.pointdevente.com">pointdevente.com</a> et profitez d'offres spéciales! </span>
                    <a href="http://www.pointdevente.com" class="passeport__bouton bouton">Acheter passeport en ligne</a>
                </li>
                <li class="passeport__listeItem">
                    <span class="h4 passeport__choix">Chez nos partenaires en prévente :</span>
                    <ul class="passeport__sousListe">
                        <li class="passeport__sousListeItem passeport__sousListeItem--ninkasi">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">La Ninkasi</span>
                                811, rue Saint-Jean
                            </span>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--korrigane">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">La Korrigane</span>
                                380, rue Dorchester
                            </span>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--faubourg">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">Faubourg St-Jean</span>
                                550, rue Saint-Jean
                            </span>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--piazzetta">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">Piazzetta</span>
                                1191, avenue Cartier
                            </span>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--chyz">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">Chyz</span>
                                2305, rue de l'université
                                Local 0236, Pavillion Maurice-Pollack
                            </span>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--schuz">
                            <span class="passeport__partenaireTexte">
                                <span class="h5 passeport__nomLieu">Schüz</span>
                                748, rue Saint-Jean
                            </span>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>
<?php
}

else {?>
        <section class="compositeAccueil tarifs">

            <h2 class="tarifs__titre">Tarifs</h2>
            <ul class="tarifs__liste">
                <li class="tarifs__listeItem tarifs__listeItem--fondCouleur">
                    <a href="<?php echo $cheminAncreTarifs ?>#achatPasseport">
                        <span class="tarifs__prixTarifs tarifs__span">10<span class="tarifs__prixTarifs--signeComplement">$</span></span>
                        <span class="tarifs__texteTarifs tarifs__span"><span class="tarifs__titreTarifs">Passeport </span>pour toute la durée du festival</span>
                    </a>
                </li>
                <li class="tarifs__listeItem">
                    <span class="tarifs__prixTarifs tarifs__span">5<span class="tarifs__prixTarifs--signeComplement">$/soir*</span></span>
                    <span class="tarifs__texteTarifs tarifs__span">Spectacles à la <span class="tarifs__titreTarifs">Méduse</span>* à la porte</span>
                </li>
                <li class="tarifs__listeItem">
                    <span class="tarifs__prixTarifs tarifs__prixTarifs--texteSeul tarifs__span">Gratuit</span>
                    <span class="tarifs__texteTarifs tarifs__span">Spectacles au <span class="tarifs__titreTarifs">Bar le Sacrilège, parvis Église st-roch, Fou Bar ou Extérieurs</span></span>
                </li>
            </ul>

            <h3 id="achatPasseport" class="tarifs__titrePasseport passeport">Achetez vos passeports :</h3>
            <ul class="passeport__liste">
                <li class="passeport__listeItem">
                    <h4 class="passeport__choix">En ligne au <a href="http://www.pointdevente.com">pointdevente.com</a> et profitez d'offres spéciales! </h4>
                    <a href="http://www.pointdevente.com" class="passeport__bouton bouton">Acheter passeport en ligne</a>
                </li>
                <li class="passeport__listeItem">
                    <h4 class="passeport__choix">Chez nos partenaires en prévente :</h4>
                    <ul class="passeport__sousListe">
                        <li class="passeport__sousListeItem passeport__sousListeItem--ninkasi">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">La Ninkasi</h5>
                                811, rue Saint-Jean
                            </div>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--korrigane">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">La Korrigane</h5>
                                380, rue Dorchester
                            </div>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--faubourg">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">Faubourg St-Jean</h5>
                                550, rue Saint-Jean
                            </div>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--piazzetta">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">Piazzetta</h5>
                                1191, avenue Cartier
                            </div>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--chyz">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">Chyz</h5>
                                2305, rue de l'université
                                Local 0236, Pavillion Maurice-Pollack
                            </div>
                        </li>
                        <li class="passeport__sousListeItem passeport__sousListeItem--schuz">
                            <div class="passeport__partenaireTexte">
                                <h5 class="passeport__nomLieu">Schüz</h5>
                                748, rue Saint-Jean
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
<?php
}?>