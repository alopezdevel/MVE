
    <?php
            include_once  __DIR__ . '/php_backend/Class/ControlAcceso.php';
            $ControlAcceso = new ControlAcceso();

            if( $ControlAcceso->validar_session() === false )
                ControlAcceso::http_response(401);
    ?>

    <header class="p-3 mb-3 border-bottom" id="container-header">
        <div class="container-fluid">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <button class="main-menu menu-icon navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
              <i class="fa-solid fa-bars"></i>
            </button>
            <div class="main-menu offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                  <div class="offcanvas-header">
                    <img class="offcanvas-title img-logo" src="img/img-header/img-menu-logo.png" alt="img-menu-logo.png (18,172 bytes)">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                      <li class="nav-item"><a class="nav-link" href="#" onclick="eglobalmve.load_module('monitor_mve.php', '', '', '')"><i class="fa-solid fa-house"></i> Inicio</a></li>

                      <?php if ( $_SESSION['eglobalmve']['tipo_usuario']== 'AA' ) { ?>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-key"></i> Adminstrador</a>
                         <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('admin_usuarios.php', 'Administrador', 'USUARIOS', 'fa-solid fa-users');"><i class="fa-solid fa-users"></i> Usuarios</a></li>
                         </ul>
                      </li>            
                      <?php } ?>

                      <li class="nav-item"><a class="nav-link" href="#" onclick="eglobalmve.load_module('monitor_mve.php', '', '', '')"><i class="fa-solid fa-file-shield"></i> Monitor de MVE</a></li>
                      <li class="nav-item"><a class="nav-link" href="#" onclick="eglobalmve.load_module('monitor_mve2.php', '', '', '')"><i class="fa-solid fa-file-shield"></i> Monitor de MVE2</a></li>

                      <!--
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-gear"></i> Configuraci&oacute;n</a>
                         <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('config_plantillas.php', 'Layouts', 'Plantillas', 'fa-solid fa-file-import');"><i class="fa-solid fa-file-import"></i> Solicitud de plantilla</a></li>
                         </ul>
                      </li>
                      -->
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa fa-table-list"></i> Cat&aacute;logos</a>
                         <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('cat_importadores.php', 'Cat&aacute;logos', 'IMPORTADORES', 'fa-solid fa-address-book');"><i class="fa-solid fa-address-book"></i> Importadores</a></li>
                            <!--
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('cat_incoterm.php', 'Cat&aacute;logos', 'INCOTERMS', 'fa-solid fa-truck');"><i class="fa-solid fa-truck"></i> Incoterms</a></li>
                            <li><a class="dropdown-item" href="#" onclick="eglobalinvoice.load_module('cat_moneda.php', 'Cat&aacute;logos', 'MONEDAS', 'fa-solid fa-circle-dollar-to-slot');"><i class="fa-solid fa-circle-dollar-to-slot"></i> Monedas</a></li>
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('cat_pais.php', 'Cat&aacute;logos', 'PA&Iacute;SES', 'fa-solid fa-earth-americas');"><i class="fa-solid fa-earth-americas"></i> Pa&iacute;ses</a></li>
                            <li><a class="dropdown-item" href="#" onclick="eglobalmve.load_module('cat_unidad_medida.php', 'Cat&aacute;logos', 'UNIDADES DE MEDIDA', 'fa-solid fa-box');"><i class="fa-solid fa-box"></i> Unidades de medida</a></li>
                            -->
                         </ul>
                      </li>

                      <li><hr class="divider"></li>

                      <li class="nav-item"><a class="nav-link" href="#" onclick="eglobalmve.logout();"><i class="fa-solid fa-power-off"></i> Cerrar Sesi&oacute;n</a></li>
                    </ul>
                  </div>
                </div>
            <!-- LOGO -->
            <a href="#" class="d-flex align-items-center mb-2 mb-lg-0" onclick="eglobalmve.load_module('main_monitor.php', '', '', '')"> 
                <img class="img-logo" src="img/img-header/img-menu-logo.png" alt="img-menu-logo.png (18,172 bytes)">
            </a>
            <div class="col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <!-- ESPACIO PARA BARRA DE CREDITOS...-->
            </div>

            <!-- DATOS Y MENU DE USUARIO-->
            <div class="dropdown text-end menu-usuario">
              <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" >
                <img src="img/img-header/img-menu-user.jpg" alt="usr" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small">
                <li><span id="usuario_nombre" class="dropdown-item" style="text-transform:lowercase;!important"><?= $_COOKIE["egmve_usuario_actual"]; ?></span></li>
                <li><hr class="dropdown-divider"></li>
                <!--
                <li>
                    <div class="row px-3 datos-plan">
                        <div class="col-2"><i class="fa-solid fa-dollar-sign"></i></div>
                        <div class="col-10" id="saldo-disponible"></div>
                    </div>
                </li>
                -->
                 <li><a class="dropdown-item btn-cerrar-sesion" href="#"><i class="fa-solid fa-user"></i> Perfil</a></li>
                <!--
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item btn-cerrar-sesion" href="#" onclick="eglobalinvoice.abrir_modulo_modal('abonar_cuenta.php','#frm-add-pages', 'ABONAR A CUENTA');"><i class="fa-regular fa-credit-card"></i> Abonar a cuenta</a></li>
                -->
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item btn-cerrar-sesion" href="#" onclick="eglobalmve.logout();"><i class="fa-solid fa-power-off"></i> Cerrar Sesi&oacute;n</a></li>
              </ul>
            </div>
          </div>
        </div>
    </header>