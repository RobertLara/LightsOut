$(function () {
    $("#openMakeBoard").click(function () {
        makeBoard();
    });
});

function makeBoard(){
    $('#makeBoard .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
    var board = $('#makeBoard #board');
    for (var i = 0; i < 5; i++) {
        $(board).append('<div class="row" data-row="' + i + '"></div>');
    }
    var rows = $(board).find('.row');
    $(rows).each(function (index, value) {
        for (var i = 0; i < 5; i++) {
            var node = $('<div>');
            node.addClass('position');
            $(node).click(function (e) {
                $(this).toggleClass('active');
            });
            $(this).append(node);
        }
    });

    $(board).append('<button id="btnSave" type="button" onclick="saveLevel()" class="btn btn-success">Guardar nivell</button>');
}

function saveLevel() {
    $('#makeBoard').modal('hide');
    var structure = "";
    var position = $('#makeBoard .position');
    position.each(function(){
        if($(this).hasClass('active')){
            structure += "1";
        }else{
            structure += "0";
        }
    });
    $.ajax({
        url: '/Codeigniter/game/saveLevel/' + structure,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            console.log(response);
        }
    });


}