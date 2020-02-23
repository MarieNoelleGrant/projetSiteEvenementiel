/**
 * @file    Un menu mobile accordéon jQuery en amélioration progressive.
 * @author Ève Février <eve.fevrier@cegep-ste-foy.qc.ca>
 * @author Yves Hélie <yves.helie@cegep-ste-foy.qc.ca>
 * @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
 * @version 1.4
 */

//*******************
// Déclaration d'objet(s)
//*******************

var lieuxAccordeon = {

    refLieux: $('.lieux'),

    btnAccordeon : null,

    lblOuvrir : 'Ouvrir',
    lblFermer : 'Fermer',

    configurerNavLieux: function ()
    {
        // Création du libellé qui sera utilisé de base pour tous les boutons
        var lblAccordeon = $('<span>').addClass('screen-reader-only');
        var iconeAccordeon = $('<span>').addClass('fa fa-chevron-down').attr('aria-hidden', true);
        $(lblAccordeon).html(this.lblOuvrir);

        // Création des boutons qui seront utilisés par le menu mobile
        // @todo À compléter...
        // this.btnMenu = $('<button>');
        // this.btnMenu.addClass('menu__btnMobile');
        // this.btnMenu.addClass('menu__btnMobile--ferme');
        // this.btnMenu.append('<span class="menu__btnMobile_icone">');
        // // Pour que le libellé du bouton principal soit visible!!
        // this.btnMenu.prepend('<span class="menu__btnMobile_libelle">');
        // this.btnMenu.find('.menu__btnMobile_libelle').html("Menu");


        // Création des boutons qui seront utilisés par les accordéons
        this.btnAccordeon = $('<button>');
        this.btnAccordeon.addClass('lieux__btnAccordeon');
        this.btnAccordeon.addClass('lieux__btnAccordeon--ferme');
        this.btnAccordeon.append(lblAccordeon);
        this.btnAccordeon.append(iconeAccordeon);

        // // On ajoute le bouton pour le menu mobile
        // // @todo À compléter...
        // this.refMenu.prepend(this.btnMenu);

        // On gère les sous-menus; ajout des classes et des boutons nécessaires
        this.refLieux.find('.lieux__sousListe').addClass('lieux__sousListe--ferme');
        this.refLieux.find('.lieux__sousListe').before(this.btnAccordeon);

        // On ajoute la classe --ferme au menu en général; par défaut il est caché avec JS
        // @todo À compléter...
        this.refLieux.addClass('lieux--ferme');

        // // Création de l'écouteur d'événement pour le bouton du menu mobile
        // // @todo À compléter...
        // this.btnMenu.on('click', this.ouvrirFermerMenu.bind(this));

        // Création de l'écouteur d'événement pour chaque bouton accordéon
        this.refLieux.find('.lieux__btnAccordeon').on('click', this.ouvrirFermerAccordeon.bind(this));
    },

    /**
     * Méthode pour basculer l'affichage du menu mobile en se basant sur la classe --ferme
     * @param evenement
     */
    ouvrirFermerMenu: function (evenement)
    {
        // Bascule de l'état du bouton
        // @todo À compléter...
        this.btnLieux.toggleClass("lieux__btnMobile--ferme");

        // Bascule de l'état du menu
        // @todo À compléter...
        this.refLieux.toggleClass("lieux--ferme");

        // // Changement du libellé du bouton du menu mobile
        // // @todo À compléter...
        // if (this.refLieux.hasClass("lieux--ferme"))
        // {
        //     this.btnLieux.find('.lieux__btnMobile_libelle').html("Menu");
        // }
        // else
        // {
        //     this.btnMenu.find('.menu__btnMobile_libelle').html(this.lblFermer);
        // }
    },

    /**
     * Méthode pour basculer l'affichage des accordéons en se basant sur la classe --ferme
     * @param evenement
     */
    ouvrirFermerAccordeon: function (evenement)
    {
        // Bascule de l'état du bouton
        $(evenement.currentTarget).toggleClass('lieux__btnAccordeon--ferme');
        $(evenement.currentTarget).parent('.lieux__listeItem').toggleClass('lieux__listeItem--fondCouleur');

        // Bascule de l'état de la sous-liste
        // @todo À compléter...
        $(evenement.currentTarget).next('.lieux__sousListe').toggleClass('lieux__sousListe--ferme');

        // Changement du libellé du bouton accordéon
        if($(evenement.currentTarget).hasClass('lieux__btnAccordeon--ferme')){
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblOuvrir);
            $(evenement.currentTarget).find('.fa').removeClass('fa-chevron-up lieux__chevron--blanc').addClass('fa-chevron-down');
        }
        else {
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblFermer);
            $(evenement.currentTarget).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up lieux__chevron--blanc');
        }
    }
};