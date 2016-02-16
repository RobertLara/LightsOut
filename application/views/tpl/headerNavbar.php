<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>LightOut</b></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url(); ?>">Inici</a></li>

                <?php if ($this->session->userdata('logged_in')): ?>
                    <?php if ($this->session->userdata('role')==1): ?>
                        <li><a href="<?php echo base_url('main/dashboard'); ?>">Gestio d'usuaris</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo base_url('game'); ?>">Panell de control</a></li>
                    <li><a href="<?php echo base_url('main/logout');?>">Tancar sessió</a></li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Entrar</b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Iniciar sessió</h2>
                                        <?php echo form_open("main/login"); ?>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Usuari</label>
                                                <input type="text" name="username" class="form-control" id="exampleInputEmail2" placeholder="Usuari" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Contrasenya</label>
                                                <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="Contrasenya" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                                            </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="bottom text-center">
                                        Et nou aqui? <a href="<?php echo base_url('main/register');?>"><b>Uneix-te</b></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>