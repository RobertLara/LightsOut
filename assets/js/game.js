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


});

var timercount = 0;
var timestart = null;

function loadGame(level) {

    $.ajax({
        url: '/Codeigniter/game/getGame/' + level,
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
            $('#game .modal-body').html('<i class="fa fa-spinner fa-spin"></i> Generant...');
        },
        success: function (response) {
            makeBoard(level, response.level);
        }
    });

}

function makeBoard(id, level) {
    $('#game .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
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
    $(board).append('<div id="clicksCount" class="pull-left">Clicks: <span>0</span></div>');
    $(board).append('<form name="timeform" class="pull-right">Temps: <input class="text-right" type=text name="timetextarea" value="00:00" size="2"></form>');
    clock_reset();
    clock_stop();

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

function clock_start() {
    timestart = new Date();
    document.timeform.timetextarea.value = "00:00";
    timercount = setTimeout("clock_show()", 1000);
}

function clock_reset() {
    timestart = null;
    document.timeform.timetextarea.value = "00:00";
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

function play(elem) {
    countMoves();
    var row = elem.parent().data('row');
    var col = elem.data('col');

    elem.toggleClass('active');
    $('.row[data-row="' + (row + 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col + 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row) + '"] .position[data-col="' + (col - 1) + '"]').toggleClass('active');
    $('.row[data-row="' + (row - 1) + '"] .position[data-col="' + (col) + '"]').toggleClass('active');

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
    if($('#clicksCount span').text()=='0'){
        clock_start();
    }

    $('#clicksCount span').html(parseInt($('#clicksCount span').html(), 10) + 1);
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

