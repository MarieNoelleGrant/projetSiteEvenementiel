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

var menuAccordeon = {

    refMenu: $('.entete .menu'),

    btnMenu : null,
    btnAccordeon : null,

    lblOuvrir : 'Ouvrir',
    lblFermer : 'Fermer',

    configurerNav: function ()
    {
        // Création du libellé qui sera utilisé de base pour tous les boutons
        var lblAccordeon = $('<span>').addClass('screen-reader-only');
        var iconeAccordeon = $('<span>').addClass('fa fa-chevron-down').attr('aria-hidden', true);
        $(lblAccordeon).html(this.lblOuvrir);

        // Création des boutons qui seront utilisés par le menu mobile
        // @todo À compléter...
        this.btnMenu = $('<button>');
        this.btnMenu.addClass('menu__btnMobile');
        this.btnMenu.addClass('menu__btnMobile--ferme');
        this.btnMenu.append('<span class="menu__btnMobile_icone">');
        // Pour que le libellé du bouton principal soit visible!!
        this.btnMenu.prepend('<span class="menu__btnMobile_libelle">');
        this.btnMenu.find('.menu__btnMobile_libelle').html("Menu");


        // Création des boutons qui seront utilisés par les accordéons
        this.btnAccordeon = $('<button>');
        this.btnAccordeon.addClass('menu__btnAccordeon');
        this.btnAccordeon.addClass('menu__btnAccordeon--ferme');
        this.btnAccordeon.append(lblAccordeon);
        this.btnAccordeon.append(iconeAccordeon);

        // On ajoute le bouton pour le menu mobile
        // @todo À compléter...
        this.refMenu.prepend(this.btnMenu);

        // On gère les sous-menus; ajout des classes et des boutons nécessaires
        this.refMenu.find('.menu__sousListe').addClass('menu__sousListe--ferme');
        this.refMenu.find('.menu__sousListe').before(this.btnAccordeon);

        // On ajoute la classe --ferme au menu en général; par défaut il est caché avec JS
        // @todo À compléter...
        this.refMenu.addClass('menu--ferme');

        // Création de l'écouteur d'événement pour le bouton du menu mobile
        // @todo À compléter...
        this.btnMenu.on('click', this.ouvrirFermerMenu.bind(this));

        // Création de l'écouteur d'événement pour chaque bouton accordéon
        this.refMenu.find('.menu__btnAccordeon').on('click', this.ouvrirFermerAccordeon.bind(this));
    },

    /**
     * Méthode pour basculer l'affichage du menu mobile en se basant sur la classe --ferme
     * @param evenement
     */
    ouvrirFermerMenu: function (evenement)
    {
        // Bascule de l'état du bouton
        // @todo À compléter...
        this.btnMenu.toggleClass("menu__btnMobile--ferme");

        // Bascule de l'état du menu
        // @todo À compléter...
        this.refMenu.toggleClass("menu--ferme");

        // Changement du libellé du bouton du menu mobile
        // @todo À compléter...
        if (this.refMenu.hasClass("menu--ferme"))
        {
            this.btnMenu.find('.menu__btnMobile_libelle').html("Menu");
        }
        else
        {
            this.btnMenu.find('.menu__btnMobile_libelle').html(this.lblFermer);
        }
    },

    /**
     * Méthode pour basculer l'affichage des accordéons en se basant sur la classe --ferme
     * @param evenement
     */
    ouvrirFermerAccordeon: function (evenement)
    {
        // Bascule de l'état du bouton
        $(evenement.currentTarget).toggleClass('menu__btnAccordeon--ferme');

        // Bascule de l'état de la sous-liste
        // @todo À compléter...
        $(evenement.currentTarget).next('.menu__sousListe').toggleClass('menu__sousListe--ferme');

        // Changement du libellé du bouton accordéon
        if($(evenement.currentTarget).hasClass('menu__btnAccordeon--ferme')){
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblOuvrir);
            $(evenement.currentTarget).find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
        else {
            $(evenement.currentTarget).find('.screen-reader-only').html(this.lblFermer);
            $(evenement.currentTarget).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    }
};