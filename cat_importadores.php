<?php
        include_once __DIR__ . '/php_backend/Class/ControlAcceso.php';

        if( ControlAcceso::validar_session() )
            print '<script>
                   if (typeof Importadores === \'undefined\') {
                     $.getScript(\'./js/cat_importadores.js\', function() {
                        Importadores.init()
                     });
                   } else {
                        Importadores.init()
                   }
                   </script>';
        else
            print "<script>javascript: window.location = './index.php' </script>"; 


        /* ---- Definimos los atributos de html necesarios ----- */
        define('ID_TABLA_GRID',       'table-datagrid-importadores');
        define('ID_MODAL_FORM',       'modal-frm-importadores');
        define('ID_FORM',             'form_importadores');
        define('ID_MODAL_FORM_CERTIFICADOS', 'modal-frm-importadores-certificados');

        /* ---- Definimos los nombres de las funciones de javascript ----- */
        define('FN_FILTRAR_GRID_JS',        'Importadores.filtrar_grid()');
        define('FN_NUEVO_REGISTRO_JS',      'Importadores.nuevo_registro()');
        define('FN_PRIMERA_PAGINA_JS',      'Importadores.primera_pagina()');
        define('FN_PAGINA_PREVIA_JS',       'Importadores.pagina_previa()');
        define('FN_PAGINA_SIGUIENTE_JS',    'Importadores.pagina_siguiente()');
        define('FN_ULTIMA_PAGINA_JS',       'Importadores.ultima_pagina()');
        define('FN_SUBMIT_JS',              'Importadores.submit()');
        define('FN_ELIMINAR_REGISTRO_JS',   'Importadores.eliminar_registro()');
    ?>

    <div class="main-container container-xxl mt-3">
        <!-- HEADER DEL GRID-->
        <div class="row pb-3 pt-2">
            <div class="col">
                <h1 class="p-2">
                    <span class="grid-tit-icon"><i class="<?= $_COOKIE['icon_class'] ?>"></i></span>
                    <span class="grid-tit-text">
                        <span class="grid-tit"><?= $_COOKIE['menu_name'] ?></span>
                        <span class="grid-subtit"><?= $_COOKIE['module_name'] ?></span>
                    </span>
                </h1>
            </div>
            <div class="col"></div>
        </div>
        <div class="row datagrid-container">
            <div class="col-xxl">
                <table id="<?= ID_TABLA_GRID ?>" class="table datagrid">
                   <thead>
                     <tr class="datagrid-filters">
                       <td><input id="flt_rfc" class="form-control form-control-sm m-1" type="text" value="" placeholder="RFC"/></td>
                       <td><input id="flt_razon_social" class="form-control form-control-sm m-1" type="text" value="" placeholder="Nombre"/></td>
                       <td>
                         <button type="button" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_FILTRAR_GRID_JS ?>"><i class="fa-solid fa-magnifying-glass"></i></button>
                         <?php if( $_SESSION['eglobalmve']['tipo_usuario'] != "UC" ) { ?>
                          <button type="button" class="btn btn-grid btn-grid btn-green btn-icon float-start m-1" onclick="<?= FN_NUEVO_REGISTRO_JS ?>"><i class="fa-solid fa-plus"></i></button>
                         <?php } ?>
                       </td>
                     </tr>
                     <!-- DEFINIR EL ANCHO DE LAS COLIMNAS POR EL WIDTH % DEBE DAR SIEMPRE 100% -->
                     <tr class="datagrid-columns">
                       <td style="width: 15%;">RFC</td>
                       <td style="width: 70%;">NOMBRE</td>
                       <td style="width:10%;"></td>
                     </tr>
                   </thead>
                   <tbody></tbody>
                   <tfoot>
                     <tr>
                       <td colspan="100%">
                         <div class="datagrid-pages">
                           <input class="page_actual" type="text" readonly="readonly" size="3" value="0">
                           <label> / </label>
                           <input class="page_total"  type="text" readonly="readonly" size="3" value="0">
                         </div>
                       </td>
                     </tr>
                     <tr>
                       <td colspan="100%" class="">
                         <div class="datagrid-menu-pages">
                           <button class="page-first" onclick="<?= FN_PRIMERA_PAGINA_JS ?>"><i class="fa-solid fa-backward-step"></i></button>
                           <button class="page-back"  onclick="<?= FN_PAGINA_PREVIA_JS ?>"><i class="fa-solid fa-caret-left"></i></button>
                           <button class="page-next"  onclick="<?= FN_PAGINA_SIGUIENTE_JS ?>"><i class="fa-solid fa-caret-right"></i></button>
                           <button class="page-last"  onclick="<?= FN_ULTIMA_PAGINA_JS ?>"><i class="fa-solid fa-forward-step"></i></button>
                         </div>
                       </td>
                     </tr>
                   </tfoot>
                </table>
                <div class="container-loader" align="center"></div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div id="<?= ID_MODAL_FORM ?>" class="modal fade modal-eglobalmve-form" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header modal-eglobalmve">
            <h1 class="modal-title fs-5"><?= $_COOKIE['module_name'] ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body d-flex justify-content-center">
            <form id="<?= ID_FORM ?>" action="" method="POST" enctype="multipart/form-data">
              <p>Los campos marcados con un (<span style="color:#d01515;"> * </span>) son obligatorios:</p>
              <fieldset id="fielset_datos_generales">
                <legend>DATOS GENERALES</legend>

                <?php //Para controlar el campo llave para la edicion/update del registro el atributo id y name llevan el nombre del id de la tabla  ?>
                <input type="hidden" id="id_importador" name="id_importador">

                <div class="row align-items-center">
                  <div class="col-4"><label for="razon_social" class="col-form-label required-field"></label> Razón social</div>
                  <div class="col-7"><input type="text" name="razon_social" id="razon_social" class="form-control form-control-sm" value=""></div>
                </div>                

                <div class="row align-items-center">
                  <div class="col-4"><label for="rfc" class="col-form-label required-field"></label> RFC</div>
                  <div class="col-7"><input type="text" name="rfc" id="rfc" class="form-control form-control-sm" value=""></div>
                </div>
                
                <div class="row align-items-center mt-1" >
                  <div class="col-4"><label for="activo" class="col-form-label required-field">Activo</label></div>
                  <div class="col-7">
                    <select name="activo" id="activo" class="form-select form-control-sm">
                      <option value="">Seleccione una opción</option>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                </div>
              </fieldset>            
            
              <div class="row align-items-center mt-3">
                  <div class="col-13 text-center" >
                   <button type="button" id="submit-button" class="btn btn-primary submit-button" onclick="<?= FN_SUBMIT_JS ?>"><span class="btn-label">Guardar</span><span class="spinner-border spinner-border-sm" aria-hidden="true" style="display:none"></span></button>
                  </div>
              </div>

            </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div id="<?= ID_MODAL_FORM_CERTIFICADOS ?>" class="modal fade modal-eglobalmve-form" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header modal-eglobalmve">
            <h1 class="modal-title fs-5"><?= $_COOKIE['module_name'] ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body d-flex justify-content-center">
            <form id="<?= ID_FORM ?>" action="" method="POST" enctype="multipart/form-data">
              <p>Los campos marcados con un (<span style="color:#d01515;"> * </span>) son obligatorios:</p>
              <fieldset id="fielset_datos_generales">
                <legend>CERTIFICADOS VENTANILLA UNICA (VUCEM)</legend>

                <div class="row align-items-center">
                  <div class="col-4"><label for="archivo_key" class="col-form-label required-field"></label> Archivo KEY</div>
                  <div class="col-7"><input type="file" name="archivo_key" id="archivo_key" class="form-control form-control-sm" value=""></div>
                </div>

                <div class="row align-items-center">
                  <div class="col-4"><label for="archivo_cer" class="col-form-label required-field"></label> Archivo CER</div>
                  <div class="col-7"><input type="file" name="archivo_cer" id="archivo_cer" class="form-control form-control-sm" value=""></div>
                </div>

                <div class="row align-items-center">
                  <div class="col-4"><label for="contrasena_key" class="col-form-label required-field"></label> Contraseña del archivo KEY</div>
                  <div class="col-7"><input type="text" name="contrasena_key" id="contrasena_key" class="form-control form-control-sm" value=""></div>
                </div>

                <div class="row align-items-center">
                  <div class="col-4"><label for="rfc" class="col-form-label required-field"></label> Usuario 'Web Service'</div>
                  <div class="col-7"><input type="text" name="rfc" id="rfc" class="form-control form-control-sm" value=""></div>
                </div>
                
                <div class="row align-items-center mt-1" >
                  <div class="col-4"><label for="activo" class="col-form-label required-field">Contraseña del usuario 'Web Service'</label></div>
                  <div class="col-7">
                    <input type="text" name="contrasena_ws_vucem" id="contrasena_ws_vucem" class="form-control form-control-sm" value="">
                  </div>
                </div>
              </fieldset>              
            
              <div class="row align-items-center mt-3">
                  <div class="col-13 text-center" >
                   <button type="button" id="submit-button" class="btn btn-primary submit-button" onclick="<?= FN_SUBMIT_JS ?>"><span class="btn-label">Guardar</span><span class="spinner-border spinner-border-sm" aria-hidden="true" style="display:none"></span></button>
                  </div>
              </div>

            </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>    
    
    <div id="modal-confirm" class="modal fade" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header modal-eglobalmve">
            <h1 class="modal-title fs-5" id="mensajeLabel">MENSAJE DEL SISTEMA</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" id="btn-confirmar-eliminar" class="btn btn-danger" data-bs-dismiss="modal" onclick="<?= FN_ELIMINAR_REGISTRO_JS ?>">Eliminar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>