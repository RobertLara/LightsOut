var timercount = 0;
var timestart = null;
var level_structure = null;
var save_Level = null;
var moves = null;
var isStart = false;

$(function () {
    $(".panel-yellow").click(function () {
        loadGame($(this).data('level'));
        $('#game').modal('show');
    });

    $("#btnCloseGame").click(function () {
        $('#game').modal('hide');
    });

    $("#btnReloadGame").click(function () {
        loadGame($('#board').data('level'));
    });

    $("#btnContinue").click(function () {
        moves = save_Level['clicks'];
        level_structure = save_Level['status'];
        save_Level['time'] = save_Level['time'].substr(3)
        makeBoard(save_Level['id'], save_Level['status'], save_Level['time'],save_Level['clicks']);
        $('#modalOption').modal('hide');
    });

    $("#btnNewGame").click(function () {
        var id = save_Level.id;
        save_Level = null;
        makeBoard(id,level_structure);
        $('#modalOption').modal('hide');
    });

    $('#game').on('hidden.bs.modal', function () {
        resetVariable();
    });

    $("#btnSaveTmp").click(function () {
        saveLevel();
    });


});



function loadGame(level) {

    $.ajax({
        url: '/Codeigniter/game/getGame/' + level,
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
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

function makeBoard(id, level,time,clicks) {
    $('#game .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
    $('#game .modal-title').html('<i class="fa fa-star fa-gold"></i> Nivell '+id+' <i class="fa fa-star fa-gold"></i>')
    var board = $('#game #board');
    board.attr('data-level', id);
    for (var i = 0; i < 5; i++) {
        $(board).append('<div class="row" data-row="' + i + '"></div>');
    }
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
    if(clicks==undefined){
        moves = 0;
    }
    if(time==undefined){
        time = "00:00";
    }
    $(board).append('<div id="clicksCount" class="pull-left">Clicks: <span>'+moves+'</span></div>');
    $(board).append('<form name="timeform" class="pull-right">Temps: <input class="text-right" type=text name="timetextarea" value="'+time+'" size="4"></form>');
    clock_reset(time);
    //clock_stop();


}

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
    timercount = setTimeout("clock_show()", 1000);
}

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

function clock_reset(time) {
    timestart = null;
    if(time==undefined){
        document.timeform.timetextarea.value = "00:00";
    }else{
        document.timeform.timetextarea.value = time;
    }
}

function resetVariable(){
    timercount = 0;
    timestart = null;
    level_structure = null;
    save_Level = null;
    moves = null;
    isStart = false;
}

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

function fairPlay(check){
    if(check == level_structure){
        return true;
    }else{
        $('#game').modal('hide');
        $('#modalTrampa').modal('show');
        $.ajax({
            url: '/Codeigniter/Main/deleteMyAccount',
            type: 'post',
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
        return false;
    }
}

function getStructure(){
    var structure = "";
    var position = $('#board .position');
    position.each(function(){
        if($(this).hasClass('active')){
            structure += "1";
        }else{
            structure += "0";
        }
    });
    return structure;
}

function saveLevel() {
    $('#board').modal('hide');
    var level = $('#board').data('level');
    var structure = getStructure();
    var time = $('input[name="timetextarea"]').val();
    $.ajax({
        url: '/Codeigniter/game/saveGameTmp/' +level+'/'+ structure+'/'+time+'/'+moves,
        type: 'post',
        dataType: 'json',
        beforeSend:function(){
            $('#game').modal('hide');
            resetVariable();
        },
        success: function (response) {
            console.log(response);
        }
    });
}

function play(elem) {
    countMoves();
    var row = elem.parent().data('row');
    var col = elem.data('col');

    if(fairPlay(getStructure())==false){
        return false;
    }

    elem.toggleClass('active');
    $('.row[data-row="' + (row + 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col + 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col - 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row - 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');

    level_structure = getStructure();

    if ($('#board .active').size() == 0) {
        clock_stop();
        saveRecord(
            $('#board').data('level'),
            $('input[name="timetextarea"]').val(),
            parseInt($('#clicksCount span').html(), 10)
        );
    }
}

function countMoves() {
    if(!isStart){
        if(save_Level !== null){
            var time = save_Level['time']
            save_Level=null;
            clock_start(time);

        }else{
            clock_start();
        }
        isStart=true;
    }

    $('#clicksCount span').html(++moves);
}

function saveRecord(level, time, moves) {
    $.ajax({
        url: '/Codeigniter/game/saveRecord/' + level + "/" + time + "/" + moves,
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#modalInfo').modal('show');
            $('#modalInfo .modal-body').html("Gracies per jugar");
        },
        success: function (response) {
            loadGlobalRecord();
            loadUserRecord();
            $('#modalInfo .modal-body').html('<div class="alert alert-info">'+response.response+'</div>');
            resetVariable();
        }
    });


}

function loadUserRecord() {
    $.ajax({
        url: '/Codeigniter/game/getUserRankings',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            var box = $('#recordUser .panel-yellow');
            $(box).each(function (i, value) {
                if (response.getUserRankingTime[i].time !== null) {
                    $('.fa-clock-o', this).prev().html(response.getUserRankingTime[i].time);
                }
                if (response.getUserRankingMoves[i].moves !== 0) {
                    $('.fa-hand-pointer-o', this).prev().html(response.getUserRankingMoves[i].moves);
                }


            });
        }
    });
}

function loadGlobalRecord() {
    $.ajax({
        url: '/Codeigniter/game/getRankings',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var box = $('#recordGlobal .panel-yellow');
            $(box).each(function (i, value) {
                if (response.getRankingTime[i].time !== null) {
                    $('.fa-clock-o', this).prev().html(response.getRankingTime[i].time);
                }
                if (response.getRankingMoves[i].moves !== 0) {
                    $('.fa-hand-pointer-o', this).prev().html(response.getRankingMoves[i].moves);
                }


            });
        }
    });
}

