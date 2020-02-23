<!--
***************************************************************************************************
    CONFIGURATION COMMUNICATION BASE DE DONNÉES (SELON SI LOCAL OU TIMUNIX)
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->

<?php

    // variables propres au serveur
    // même si on sait qu'on est en local, garder la vérification local -vs- distant pour le futur

    if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')) {
        $blnLocal = TRUE;
    } else {
        $blnLocal = FALSE;
    }

    //var_dump($_SERVER['HTTP_HOST']);

    // Selon l'environnement d'exécution (développement ou en ligne)
    if ($blnLocal) {
        $strHost = 'localhost';
        $strBD='18_pni1_OFF';
        $strUser = 'pni1OFF_user';
        $strPassword= 'pni1OFF_psw';
        error_reporting(E_ALL);
    } else {
        $strHost = 'timunix2.cegep-ste-foy.qc.ca';
        $strBD='18_pni1_OFF';
        $strUser = '18_etudiant_2eme';
        $strPassword = 'temp' ;
        // *** le ~E_NOTICE permet d'enlever les notices qui viennent du serveur distant
        // et qui ne correspondent pas vraiment à des erreurs
        error_reporting(E_ALL & ~E_NOTICE);
        //error_reporting(0);
    }

    //Data Source Name pour l'objet PDO
    $strDsn = 'mysql:dbname='.$strBD.';host='.$strHost;

    //Tentative de connexion
    $pdoConnexion = new PDO($strDsn, $strUser, $strPassword);

    //Changement d'encodage de l'ensemble des caractères pour UTF-8
    $pdoConnexion->exec("SET CHARACTER SET utf8");

    //Pour obtenir des rapports d'erreurs et d'exception avec errorInfo() du pilote PDO
    $pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

?>