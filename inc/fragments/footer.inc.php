<!--
***************************************************************************************************
    FRAGMENTS : FOOTER - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->


<footer class="footer">

    <div class="conteneur">
        <div class="footer__entete">
            <!-- DATES OFF FOOTER -->
            <div class="footer__elementGraphique">
                <span class="screen-reader-only">Du <time datetime="2018-07-08">8</time> au <time datetime="2018-07-11">11</time> juillet</span>
                <img src="images/elementsGraphiques/dates_footer.svg" width="100" alt="" class="footer__dates"/>
            </div>
            <!-- LOGO OFF FOOTER -->
            <div class="footer__elementGraphique">
                <a href="index.php">
                    <img src="images/elementsGraphiques/logoOff_blanc.svg" width="100" alt="Festival OFF de Québec - accueil" class="footer__logo"/>
                </a>
            </div>
        </div>

        <!-- ESPACE "PUBLICITÉ" FOOTER -->
        <div class="footer__espacePub_conteneur">
            <!-- 1. Infolettre -->
            <div class="footer__espacePub_infolettre infolettre">
                <h2 class="footer__espacePub_titre h4">Abonnez-vous à notre infolettre</h2>
                <form class="infolettre__formulaire" action="#" method="get">
                    <div class="infolettre__champ">
                        <label class="infolettre__etiquette screen-reader-only" for="courriel">Inscrire votre courriel</label>
                        <input class="infolettre__courriel" id="courriel" name="courriel" type="email" placeholder="exemple@courriel.com"/>
                    </div>
                    <button class="infolettre__bouton bouton--carre bouton" name="submitInfolettre" type="submit">
                        <span class="screen-reader-only">M'abonner à l'infolettre</span>
                        Oui je le veux
                    </button>
                </form>
            </div>
            <!-- 2. Réseaux sociaux
            ******** NE PAS OUBLIER : Faire le lien avec la font/bibliothèque font awesome ********* -->
            <div class="footer__espacePub_reseauxSociaux reseauxSociaux">
                <h2 class="footer__espacePub_titre h4">Suivez nous!</h2>
                <ul class="reseauxSociaux__liste">
                    <li class="reseauxSociaux__listeItem">
                        <a href="#" class="reseauxSociaux__lien reseauxSociaux__lien--facebook">
                            <span class="fa fa-facebook" aria-hidden="true"></span>
                            <span class="screen-reader-only">Facebook</span>
                        </a>
                    </li>
                    <li class="reseauxSociaux__listeItem">
                        <a href="#" class="reseauxSociaux__lien reseauxSociaux__lien--twitter">
                            <span class="fa fa-twitter" aria-hidden="true"></span>
                            <span class="screen-reader-only">Twitter</span>
                        </a>
                    </li>
                    <li class="reseauxSociaux__listeItem">
                        <a href="#" class="reseauxSociaux__lien reseauxSociaux__lien--instagram">
                            <span class="fa fa-youtube" aria-hidden="true"></span>
                            <span class="screen-reader-only">Instagram</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__menu_conteneur">
            <nav class="footer__menu">
                <ul class="footer__liste">
                    <li class="footer__listeItem <?php echo $menuActifLeOFF ?>">
                        <a href="index.php" class="footer__lien footer__lien--off">Le OFF</a>
                        <ul class="footer__sousListe">
                            <li class="footer__sousListeItem">
                                <a href="#" class="footer__sousLien">Lieux</a>
                            </li>
                            <li class="footer__sousListeItem">
                                <a href="#" class="footer__sousLien">Tarifs</a>
                            </li>
                            <li class="footer__sousListeItem">
                                <a href="#" class="footer__sousLien">Contact</a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer__listeItem <?php echo $menuActifProgrammation ?>">
                        <a href="programmation/index.php" class="footer__lien footer__lien--prog">Programmation</a>
                        <ul class="footer__sousListe">
                            <li class="footer__sousListeItem">
                                <a href="programmation/index.php" class="footer__sousLien">Par lieux</a>
                            </li>
                            <li class="footer__sousListeItem">
                                <a href="programmation/index.php" class="footer__sousLien">Par dates</a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer__listeItem <?php echo $menuActifArtistes ?>">
                        <a href="artistes/index.php" class="footer__lien footer__lien--artistes">Artistes</a>
                        <ul class="footer__sousListe">
                            <li class="footer__sousListeItem">
                                <a href="artistes/index.php" class="footer__sousLien">Artistes A-Z</a>
                            </li>
                            <li class="footer__sousListeItem">
                                <a href="artistes/index.php" class="footer__sousLien">Par style musical</a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer__listeItem">
                        <a href="#" class="footer__lien footer__lien--partenaires">Partenaires</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</footer>
