<!--
***************************************************************************************************
    FRAGMENTS : BALISES SCRIPT + FERMETURE BODY & HTML - OFF
    @author Marie-Noëlle Grant <m.noelle.grant@gmail.com>
    -----------------------------------------------------
-->


<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="node_modules/jquery/dist/jquery.min.js">\x3C/script>')</script>

<script src="js/_menuAccordeon.js"></script>
<script>
    $('body').addClass('js');
    $(document).ready(function(){
        menuAccordeon.configurerNav();
    });
</script>
<script src="js/_accordeonLieux.js"></script>
<script>
    $(document).ready(function(){
        lieuxAccordeon.configurerNavLieux();
    });
</script>
</body>
</html>