<!--
***************************************************************************************************
    FRAGMENTS : HEADER - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php
    //**************************************************************************************
    // VARIABLES POUR TEXTE DE LA BALISE TITLE
    // ---------------------------------------

    switch (true){
        case strpos($_SERVER['PHP_SELF'], 'fiche') : $strTextTitle="Fiche artiste : " . $arrInfosArtiste['nom_artiste'] . " - OFF";
                                                            break;
        case strpos($_SERVER['PHP_SELF'], 'artistes') : $strTextTitle = "Liste des artistes - OFF";
                                                               break;
        case strpos($_SERVER['PHP_SELF'], 'programmation') : $strTextTitle = "Programmation festival - OFF";
                                                                    break;
        default : $strTextTitle = "Accueil - OFF";
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width"/>
    <title><?php echo $strTextTitle ?></title>
    <base href="<?php echo $niveau?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body id="body">
<!--http://webaim.org/techniques/skipnav/-->
<a href="#contenu" class="visuallyhidden focusable">Aller au contenu</a>

<header class="entete" role="banner">
    <div class="entete__nav">
        <div class="conteneur">
            <div class="entete__logo">
                <a href="index.php" >
                    <img src="images/elementsGraphiques/logoOff_blanc.svg" alt="Festival OFF de Québec - accueil" class="menu__logoImage"/>
                </a>
            </div>
            <nav class="menu">
                <ul class="menu__liste">
                    <li class="menu__listeItem <?php echo $menuActifLeOFF ?>">
                        <a href="" class="menu__lien menu__lien--off">Le&nbsp;OFF</a>
                        <ul class="menu__sousListe contain">
                                <li class="menu__sousListeItem">
                                    <a href="#" class="menu__lien">Lieux</a>
                                </li>
                                <li class="menu__sousListeItem">
                                    <a href="#" class="menu__lien">Tarifs</a>
                                </li>
                                <li class="menu__sousListeItem">
                                    <a href="#" class="menu__lien">Contact</a>
                                </li>
                        </ul>
                    </li>
                    <li class="menu__listeItem <?php echo $menuActifProgrammation ?>">
                        <a href="programmation/index.php" class="menu__lien menu__lien--prog">Programmation</a>
                        <ul class="menu__sousListe contain">
                            <li class="menu__sousListeItem">
                                <a href="programmation/index.php" class="menu__lien">Par lieux</a>
                            </li>
                            <li class="menu__sousListeItem">
                                <a href="programmation/index.php" class="menu__lien">Par dates</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu__listeItem <?php echo $menuActifArtistes ?>">
                        <a href="artistes/index.php" class="menu__lien menu__lien--artistes">Artistes</a>
                        <ul class="menu__sousListe contain">
                            <li class="menu__sousListeItem">
                                <a href="artistes/index.php" class="menu__lien">Artistes A-Z</a>
                            </li>
                            <li class="menu__sousListeItem">
                                <a href="artistes/index.php" class="menu__lien">Par style musical</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu__listeItem">
                        <a href="#" class="menu__lien menu__lien--partenaires">Partenaires</a>
                        <ul class="menu__sousListe contain">
                            <li class="menu__sousListeItem">
                                <a href="#" class="menu__lien">Partenaires actuels</a>
                            </li>
                            <li class="menu__sousListeItem">
                                <a href="#" class="menu__lien">Devenir partenaire</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

