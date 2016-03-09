$(function () {
    //Obre el modal per crear nivell
    $("#openMakeBoard").click(function () {
        makeBoard();
    });
});

//Crear un tauler buit per indicar posicions
function makeBoard(){
    $('#makeBoard .modal-body').html('<div id="board" class="container-fluid text-center"></div>');
    var board = $('#makeBoard #board');
    //Crear cinc files
    for (var i = 0; i < 5; i++) {
        $(board).append('<div class="row" data-row="' + i + '"></div>');
    }
    //Afegeix les posicions
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

//Guarda el nou nivell creat
function saveLevel() {
    $('#makeBoard').modal('hide');  //Tanca el modal
    var structure = "";
    var position = $('#makeBoard .position');
    //Obté l'estructura del tauler
    position.each(function(){
        if($(this).hasClass('active')){ //Segons la classe rep 1 o 0
            structure += "1";
        }else{
            structure += "0";
        }
    });
    $.ajax({
        url: '/Codeigniter/game/saveLevel/' + structure,    //recurs
        type: 'post',
        dataType: 'json',
        success: function (response) {
        }
    });


}