$(function() {
    setInterval(loadGlobalRecord, 60000);   //Crida cada 1 minut
    setInterval(loadUserRecord, 60000);   //Crida cada 1 minut

    //Mostra els rankings globals i oculta els personals
    $('#showGlobal').click(function(){
        if(!$(this).hasClass('active')){
            $(this).addClass('active');
            $('#showUser').removeClass('active');
        }

        $('#recordUser').hide('400');
        $('#recordGlobal').delay(400).show('400');
    });

    //Mostra els rankings personals i oculta els globals
    $('#showUser').click(function(){
        if(!$(this).hasClass('active')){
            $(this).addClass('active');
            $('#showGlobal').removeClass('active');
        }
        $('#recordGlobal').hide('400');
        $('#recordUser').delay(400).show('400');
    });
});