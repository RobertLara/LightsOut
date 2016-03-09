//Varaibles predefinides
var timercount = 0;
var timestart = null;
var level_structure = null;
var save_Level = null;
var moves = null;
var isStart = false;

$(function () {
    //Acció que permet jugar al nivell seleccionat
    $(".panel-yellow").click(function () {
        loadGame($(this).data('level'));
        $('#game').modal('show');
    });

    //Tanca el modal de joc
    $("#btnCloseGame").click(function () {
        $('#game').modal('hide');
    });

    //Torna a jugar al nivell anterior
    $("#btnReloadGame").click(function () {
        loadGame($('#board').data('level'));
    });

    //Continua amb una partida desada
    $("#btnContinue").click(function () {
        moves = save_Level['clicks'];
        level_structure = save_Level['status'];
        save_Level['time'] = save_Level['time'].substr(3)
        makeBoard(save_Level['id'], save_Level['status'], save_Level['time'],save_Level['clicks']);
        $('#modalOption').modal('hide');
    });

    //Ignora la partida desada i juga al nivell per defecte
    $("#btnNewGame").click(function () {
        var id = save_Level.id;
        save_Level = null;
        makeBoard(id,level_structure);
        $('#modalOption').modal('hide');
    });

    //Neteja la varaibles al tancar el modal
    $('#game').on('hidden.bs.modal', function () {
        resetVariable();
    });

    //Guarda la partida en l'estat actual
    $("#btnSaveTmp").click(function () {
        saveLevel();
    });


});

//Carrega el joc
function loadGame(level) {

    $.ajax({
        url: '/Codeigniter/game/getGame/' + level,  //Recurs
        type: 'post',
        dataType: 'json',
        beforeSend: function () {   //Mentres fa la petició
            $('#game .modal-body').html('<i class="fa fa-spinner fa-spin"></i> Generant...');
        },
        success: function (response) {

            if(response.save!==undefined){
                $('#modalOption').modal('show');
                save_Level = response.save;
                level_structure = response.level;
            }else{
                makeBoard(level, response.level);
                level_structure = response.level;
            }


        }
    });

}

//Crear el tauler
function makeBoard(id, level,time,clicks) {
    $('#game .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
    //Mostrar el nivell en el header
    $('#game .modal-title').html('<i class="fa fa-star fa-gold"></i> Nivell '+id+' <i class="fa fa-star fa-gold"></i>')
    var board = $('#game #board');
    board.attr('data-level', id);

    //Crear les cinc files del tauler
    for (var i = 0; i < 5; i++) {
        $(board).append('<div class="row" data-row="' + i + '"></div>');
    }

    //Crear l'estructura de les caixes
    var rows = $(board).find('.row');
    $(rows).each(function (index, value) {
        for (var i = 0; i < 5; i++) {
            var node = $('<div>');
            node.addClass('position');
            node.attr('data-col', i);
            if (level.charAt((index * 5) + i) == '1') {
                node.addClass('active');
            }
            $(node).click(function (e) {
                play($(this));
            });

            $(this).append(node);
        }
    });
    if(clicks==undefined){  //Clicks per defecte
        moves = 0;
    }
    if(time==undefined){    //Temps per defecte
        time = "00:00";
    }

    //Mostra el temps i els clics
    $(board).append('<div id="clicksCount" class="pull-left">Clicks: <span>'+moves+'</span></div>');
    $(board).append('<form name="timeform" class="pull-right">Temps: <input class="text-right" type=text name="timetextarea" value="'+time+'" size="4"></form>');
    clock_reset(time);

}

//Mostra el rellotge
function clock_show() {
    if (timercount) {
        clearTimeout(timercount);
    }

    if (!timestart) {
        timestart = new Date();
    }
    var timeend = new Date();
    var timedifference = timeend.getTime() - timestart.getTime();
    timeend.setTime(timedifference);
    var minutes_passed = timeend.getMinutes();
    if (minutes_passed < 10) {
        minutes_passed = "0" + minutes_passed;
    }
    var seconds_passed = timeend.getSeconds();
    if (seconds_passed < 10) {
        seconds_passed = "0" + seconds_passed;
    }
    document.timeform.timetextarea.value = minutes_passed + ":" + seconds_passed;
    timercount = setTimeout("clock_show()", 1000);  //Cada segon augmenta un segon el rellotge
}

//Inicia el rellotge
function clock_start(start) {
    timestart = new Date();
    if(start==undefined){
        document.timeform.timetextarea.value = "00:00";
    }else{
        var seconds = start.substr(3);
        var minuts = start.substr(0,2)
        seconds = parseInt(seconds,10);
        minuts = parseInt(minuts,10);
        timestart.setMinutes((timestart.getMinutes()-minuts));
        timestart.setSeconds((timestart.getSeconds()-seconds));
        document.timeform.timetextarea.value = start;
    }
    timercount = setTimeout("clock_show()", 1000);
}

//Reinicia el rellotge
function clock_reset(time) {
    timestart = null;
    if(time==undefined){
        document.timeform.timetextarea.value = "00:00";
    }else{
        document.timeform.timetextarea.value = time;
    }
}

//Atura el rellotge
function clock_stop(){
    if (timercount){
        clearTimeout(timercount);
        timercount = 0;
        var timeEnd = new Date();
        var timeDifference = timeEnd.getTime() - timestart.getTime();
        timeEnd.setTime(timeDifference);
        var minutesPassed = timeEnd.getMinutes();
        if (minutesPassed < 10) {
            minutesPassed = "0"+minutesPassed;
        }
        var secondsPassed = timeEnd.getSeconds();
        if (secondsPassed < 10) {
            secondsPassed = "0"+secondsPassed;
        }
        document.timeform.timetextarea.value = minutesPassed+":"+secondsPassed;
    }
    timestart = null;
}

//Deixa les variables per defecte
function resetVariable(){
    timercount = 0;
    timestart = null;
    level_structure = null;
    save_Level = null;
    moves = null;
    isStart = false;
}

//Vigila que no es facin trampres
function fairPlay(check){
    if(check == level_structure){
        return true;
    }else{
        $('#game').modal('hide');   //Oculta el joc
        $('#modalTrampa').modal('show');    //Mostra el modal de trampes
        $.ajax({
            url: '/Codeigniter/Main/deleteMyAccount',   //Recurs
            type: 'post',
            dataType: 'json',
            success: function (response) {
                window.location.href = '/Codeigniter';  //Redirigeix
            }
        });
        return false;
    }
}

//Retorna l'estructura actual del joc
function getStructure(){
    var structure = "";
    var position = $('#board .position');
    position.each(function(){
        if($(this).hasClass('active')){ //Asignem valor depenen de la classe
            structure += "1";
        }else{
            structure += "0";
        }
    });
    return structure;
}

//Guarda la partida sense acabar
function saveLevel() {
    $('#board').modal('hide');
    //Obtenim les dades de la partida
    var level = $('#board').data('level');
    var structure = getStructure();
    var time = $('input[name="timetextarea"]').val();
    $.ajax({
        url: '/Codeigniter/game/saveGameTmp/' +level+'/'+ structure+'/'+time+'/'+moves, //recurs
        type: 'post',
        dataType: 'json',
        beforeSend:function(){  //Mentres s'espera resposta
            $('#game').modal('hide');   //S'oculta la partida
            resetVariable();    //Varaibles per defecte
        },
        success: function (response) {

        }
    });
}

//Logica del joc
function play(elem) {
    countMoves();   //Aumentem el valor de moviments
    var row = elem.parent().data('row');    //Obtenim la fila
    var col = elem.data('col'); //Obtenim la columna

    if(fairPlay(getStructure())==false){    //Check trampes
        return false;
    }

    //Modifica els valors de les classes del seu voltant
    elem.toggleClass('active');
    $('.row[data-row="' + (row + 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col + 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col - 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row - 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');

    level_structure = getStructure();

    if ($('#board .active').size() == 0) {
        clock_stop();   //Atura el rellotge
        saveRecord( //Guardar la partida
            $('#board').data('level'),
            $('input[name="timetextarea"]').val(),
            parseInt($('#clicksCount span').html(), 10)
        );
    }
}

//Gestiona els moviments efectuats
function countMoves() {
    if(!isStart){   //Si no esta iniciada la partida
        if(save_Level !== null){
            var time = save_Level['time']
            save_Level=null;
            clock_start(time);  //Inicia amb el valor desat en la base de dades

        }else{
            clock_start();  //Inici amb 00:00
        }
        isStart=true;   //S'indica que ja ha començat la partida
    }

    $('#clicksCount span').html(++moves);   //Modifica el valor del DOM
}

//Desa el record de la partida
function saveRecord(level, time, moves) {
    $.ajax({
        url: '/Codeigniter/game/saveRecord/' + level + "/" + time + "/" + moves,    //recurs
        type: 'post',
        dataType: 'json',
        beforeSend: function () {   //Mentres es realitza la petició
            $('#modalInfo').modal('show');
            $('#modalInfo .modal-body').html("Gracies per jugar");
        },
        success: function (response) {
            //Torna a carregar els records
            loadGlobalRecord();
            loadUserRecord();
            //Mostra el missatge de retorn
            $('#modalInfo .modal-body').html('<div class="alert alert-info">'+response.response+'</div>');
            //Deixa les varaible per defecte
            resetVariable();
        }
    });

}

//Carrega els records del jugador
function loadUserRecord() {
    $.ajax({
        url: '/Codeigniter/game/getUserRankings',       //recurs
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var box = $('#recordUser .panel-yellow');

            //Modifica les dades DOM
            $(box).each(function (i, value) {
                if (response.getUserRankingTime[i].time !== null) {
                    $('.fa-clock-o', this).prev().html(response.getUserRankingTime[i].time);
                }
                if (response.getUserRankingMoves[i].moves !== null) {
                    $('.fa-hand-pointer-o', this).prev().html(response.getUserRankingMoves[i].moves);
                }


            });
        }
    });
}

//Carrega els records globals
function loadGlobalRecord() {
    $.ajax({
        url: '/Codeigniter/game/getRankings',   //recurs
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var box = $('#recordGlobal .panel-yellow');
            //Modifica les dades DOM
            $(box).each(function (i, value) {
                if (response.getRankingTime[i].time !== null) {
                    $('.fa-clock-o', this).parent().html('<span class="username">'+response.getRankingTime[i].username+'</span><span>'+response.getRankingTime[i].time+'</span><i class="fa fa-clock-o"></i>');
                }
                if (response.getRankingMoves[i].moves !== 0 && response.getRankingMoves[i].moves !== null) {
                    $('.fa-hand-pointer-o', this).parent().html('<span class="username">'+response.getRankingMoves[i].username+'</span><span>'+response.getRankingMoves[i].moves+'</span><i class="fa fa-hand-pointer-o"></i>');
                }
            });
        }
    });
}

