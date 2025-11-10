<?php
        include_once  __DIR__ . '/php_backend/Class/ControlAcceso.php';

        if( ControlAcceso::validar_session() )
            print '<script>
                   if (typeof Usuarios === \'undefined\') {
                     $.getScript(\'./js/admin_usuarios.js\', function() {
                        Usuarios.init()
                     });
                   } else {
                        Usuarios.init()
                   }
                   </script>';
        else
            print "<script>javascript: window.location = './index.php' </script>"; 


        /* ---- Definimos los atributos de html necesarios ----- */
        define('ID_TABLA_GRID',       'table-datagrid-usuarios');
        define('ID_MODAL_FORM',       'modal-frm-usuarios');
        define('ID_FORM',             'form_usuarios');
        define('ID_FIELDSET_PERMISOS',  'fieldset-permisos-usuario');
        //define('ID_TABLA_GRID_CLAVES','table-usuarios-claves');

        /* ---- Definimos los nombres de las funciones de javascript ----- */
        define('FN_FILTRAR_GRID_JS',        'Usuarios.filtrar_grid()');
        define('FN_NUEVO_REGISTRO_JS',      'Usuarios.nuevo_registro()');
        define('FN_PRIMERA_PAGINA_JS',      'Usuarios.primera_pagina()');
        define('FN_PAGINA_PREVIA_JS',       'Usuarios.pagina_previa()');
        define('FN_PAGINA_SIGUIENTE_JS',    'Usuarios.pagina_siguiente()');
        define('FN_ULTIMA_PAGINA_JS',       'Usuarios.ultima_pagina()');
        define('FN_SUBMIT_JS',              'Usuarios.submit()');
        define('FN_ELIMINAR_REGISTRO_JS',   'Usuarios.eliminar_registro()');
        define('FN_GUARDAR_CONFIG_CLAVE_JS','Usuarios.guardar_configuracion_clave()');
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
                       <td><input id="flt_sUsuario" class="form-control form-control-sm m-1" type="text" value="" placeholder=" Usuario"/></td>
                       <td><input id="flt_sNombre" class="form-control form-control-sm m-1" type="text" value="" placeholder="Nombre"/></td>
                       <td><input id="flt_sTipoUsuario" class="form-control form-control-sm m-1" type="text" value="" placeholder="Tipo de usuario"/></td>
                       <td>
                         <button type="button" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_FILTRAR_GRID_JS ?>"><i class="fa-solid fa-magnifying-glass"></i></button>
                         <button type="button" class="btn btn-grid btn-grid btn-green btn-icon float-start m-1" onclick="<?= FN_NUEVO_REGISTRO_JS ?>"><i class="fa-solid fa-plus"></i></button>
                       </td>
                     </tr>
                     <!-- DEFINIR EL ANCHO DE LAS COLIMNAS POR EL WIDTH % DEBE DAR SIEMPRE 100% -->
                     <tr class="datagrid-columns">
                       <td style="width: 20%;">USUARIO</td>
                       <td style="width: 35%;">NOMBRE</td>
                       <td style="width: 35%;">TIPO DE USUARIO</td>
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
                <input type="hidden" id="id_usuario" name="id_usuario">

                <div class="row align-items-center">
                  <div class="col-4"><label for="usuario" class="col-form-label required-field"></label> Usuario</div>
                  <div class="col-7"><input type="text" name="usuario" id="usuario" class="form-control form-control-sm" value=""></div>
                </div>

                <div class="row align-items-center mt-1">
                  <div class="col-4"><label for="usuario" class="col-form-label required-field"></label> Contraseña</div>
                  <div class="col-7"><input type="password" name="clave" id="clave" class="form-control form-control-sm" value=""></div>
                </div>
                
                <div class="row align-items-center mt-1">
                  <div class="col-4"><label for="usuario" class="col-form-label required-field"></label> Confirmar contraseña</div>
                  <div class="col-7"><input type="password" name="confirmar_clave" id="confirmar_clave" class="form-control form-control-sm" value=""></div>
                </div>                

                <div class="row align-items-center mt-1" >
                  <div class="col-4"><label for="nombre" class="col-form-label required-field">Nombre</label>
                   <!-- Ejemplo de tooltip
                   <i style="margin: 5px" class="fa-solid fa-question-circle btn-help" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Nombre corto para identificar de manera r&aacute;pida el incoterm en el sistema."></i>
                   -->
                  </div>
                  <div class="col-7"><input type="text" name="nombre" id="nombre" class="form-control form-control-sm" value=""></div>
                </div>

                <div class="row align-items-center mt-1" >
                  <div class="col-4"><label for="nombre" class="col-form-label required-field">Perfil</label></div>
                  <div class="col-7">
                    <select name="tipo_usuario" id="tipo_usuario" class="form-select form-control-sm" onchange="Usuarios.seleccionar_tipo_usuario()">
                      <option value="">Seleccione un perfil</option>
                      <option value="AA">Administrador</option>
                      <option value="UA">Ejecutivo de tráfico</option>
                      <option value="UC">Importador (Cliente)</option>
                    </select>
                  </div>
                </div>

                <div class="row align-items-center mt-1" id="id_importador_container" style="display: none;" > <!-- style="margin-bottom: 20px;" -->
                  <div class="col-4"><label for="id_importador" class="col-form-label required-field">Importador</label></div>
                  <div class="col-7">
                    <select name="id_importador" id="id_importador" class="form-select form-control-sm">
                      <option value="">Seleccione un importador</option>
                    </select>
                  </div>
                </div>

                <div class="row align-items-center mt-1" > <!-- style="margin-bottom: 20px;" -->
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
              
              <fieldset id="<?= ID_FIELDSET_PERMISOS ?>" style="display: none;"> 
                <legend>PERMISOS DE USUARIO</legend>
                <!--  IMPORTADORES (CLIENTES) -->
                <div class="row align-items-center">
                  <div class="col-4"><label for="permiso_importador" class="col-form-label required-field">Acceso a importadores (Clientes)</label><i style="margin:4px" class="fa-solid fa-question-circle btn-help" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Sistema al que se va a transferir la informaci&oacute;n de las facturas procesadas."></i></div>
                  <div class="col-4">
                     <select id="permiso_importador" name="permiso_importador" class="form-control-sm form-select" style="padding: 0.25rem 0.5rem!important;" onchange="Usuarios.seleccionar_acceso_importadores()">
                      <option value="">Seleccione una opci&oacute;n</option>
                      <option value="T">Todos los importadores</option>
                      <option value="P">Seleccionar importadores</option>
                     </select>
                  </div>
                  <div id="importadores_container_accordion" style="display: none;" class="col-12 mt-3">
                    <div class="accordion" id="accordion_importadores">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingClientes">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClientes" aria-expanded="false" aria-controls="collapseClientes">
                            IMPORTADORES (CLIENTES)
                          </button>
                        </h2>
                        <div id="collapseClientes" class="accordion-collapse collapse" aria-labelledby="headingClientes" data-bs-parent="#accordionClientes">
                          <div class="accordion-body">
                            <div class="row">
                              <div class="col-6 text-center">
                                <input type="text" name="buscar_importador" id="buscar_importador" class="form-control form-control-sm" value="" onkeyup="Usuarios.buscar_permiso_importador()" placeholder="Buscar importador">
                              </div>
                              <div class="checkbox-importadores-container"></div> <!-- Contenedor de checkboxes de importadores -->
                          </div> <!-- row -->
                        </div>
                      </div>
                    </div>
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
            <button type="button" id="btn-confirmar-eliminar" class="btn btn-danger" data-bs-dismiss="modal" onclick="<?= FN_ELIMINAR_REGISTRO_JS ?>">Eliminarrr</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>    