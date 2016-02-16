$(function() {
    $(".panel-yellow" ).click(function() {
        loadGame($(this).data('level'));
        $('#game').modal('show');
    });

    function loadGame(level){

        $.ajax({
            url:   '/Codeigniter/game/getGame/'+level,
            type:  'post',
            beforeSend: function () {
                $('#game .modal-body').html('<i class="fa fa-spinner fa-spin"></i> Generant...');
            },
            success:  function (response) {
                $('#game .modal-body').html(response);

            }
        });

    }

});


function loadUserRecord(){
    $.ajax({
        url:   '/Codeigniter/game/getUserRankings',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response) {
            console.log(response);

        }
    });
}

function loadRecord(){
    $.ajax({
        url:   '/Codeigniter/game/getRankings',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response) {
            console.log(response);

        }
    });

}
