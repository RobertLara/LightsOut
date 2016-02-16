$(function () {
    $(".panel-yellow").click(function () {
        loadGame($(this).data('level'));
        $('#game').modal('show');
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
                makeBoard(response.level);

            }
        });

    }

});

var timercount = 0;
var timestart = null;


function loadUserRecord() {
    $.ajax({
        url: '/Codeigniter/game/getUserRankings',
        type: 'post',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
        }
    });
}

function loadRecord() {
    $.ajax({
        url: '/Codeigniter/game/getRankings',
        type: 'post',
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
        }
    });

}

function makeBoard(level) {
    $('#game .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
    var board = $('#game #board');
    for (var i = 0; i < 5; i++) {
        $(board).append('<div class="row"></div>');
    }
    var rows = $(board).find('.row');
    $(rows).each(function (index, value) {
        for (var i = 0; i < 5; i++) {
            if (level.charAt((index * 5) + i) == '1') {
                $(this).append('<div class="position active"></div>');
            } else {
                $(this).append('<div class="position"></div>');
            }
        }
    });
    $(board).append('<div id="clicksCount" class="pull-left">Clicks: <span>0</span></div>');
    $(board).append('<form name="timeform" class="pull-right">Temps: <input class="text-right" type=text name="timetextarea" value="00:00" size="2"></form>');
    clock_reset();
    clock_start();

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