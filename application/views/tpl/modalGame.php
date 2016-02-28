<div id="game" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Tancar</button>
                <?php if ($this->session->userdata('logged_in')): ?>
                    <button id="btnSaveTmp" type="button" class="btn btn-success" data-dismiss="modal">Guardar partida</button>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<div id="modalInfo" class="modal fade" data-backdrop="static" data-keyboard="false"  role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informació</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button id="btnReloadGame" type="button" class="btn btn-default" data-dismiss="modal">Tornar a jugar</button>
                <button id="btnCloseGame" type="button" class="btn btn-default" data-dismiss="modal">Jugar a un altre nivell</button>
            </div>
        </div>

    </div>
</div>

<div id="modalOption" class="modal fade" data-backdrop="static" data-keyboard="false"  role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hi ha una partida a mitges</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Hi ha una partida desada anteriorment. Vols continuar-la o jugar de nou?
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnNewGame" type="button" class="btn btn-default col-md-5 col-xs-12 col-sm-5 col-lg-5 " data-dismiss="modal">Jugar nova partida</button>
                <button id="btnContinue" type="button" class="btn btn-default col-md-5 col-xs-12 col-sm-5 col-lg-5 pull-right" data-dismiss="modal">Continuar partida</button>
            </div>
        </div>

    </div>
</div>

<div id="modalTrampa" class="modal fade" data-backdrop="static" data-keyboard="false"  role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Trampos</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Trampos!</strong> No volem jugadors com tu!. Prendrem mesures! Si ets usuari de la plataforma t'eliminarem compte
                </div>
            </div>
        </div>

    </div>
</div>