    <?php
        include_once './php_backend/fn_eglobalinvoice_auth.php';

        $minjs = true;

        $minjs == true ? define('ScriptJS', 'main_monitor_min.js') : define('ScriptJS', 'main_monitor.js');

        if( session_valida() )
            print '<script>
                   if (typeof Monitor === \'undefined\') {
                     $.getScript(\'./js/'.ScriptJS.'\', function() {
                        Monitor.init()
                     });
                   } else {
                        Monitor.init()
                   }
                   </script>';
        else
            print '<script>javascript: window.location = \'./index.php\' </script>';


        /* ---- Definimos los atributos de html necesarios ----- */
        define('ID_TABLA_GRID',              'table-datagrid-monitor');
        define('ID_MODAL_FORM',              'modal-detalle-estatus');
        define('ID_TABLA_LOG_PROCESAMIENTO', 'table-log-procesamiento');

        /* ---- Definimos los nombres de las funciones de javascript ----- */
        define('FN_FILTRAR_GRID_JS',        'Monitor.filtrar_grid()');
        define('FN_CHECK_GRID_JS',          'Monitor.check_grid()');
        define('FN_UNCHECK_GRID_JS',        'Monitor.uncheck_grid()');
        define('FN_PRIMERA_PAGINA_JS',      'Monitor.primera_pagina()');
        define('FN_PAGINA_PREVIA_JS',       'Monitor.pagina_previa()');
        define('FN_PAGINA_SIGUIENTE_JS',    'Monitor.pagina_siguiente()');
        define('FN_ULTIMA_PAGINA_JS',       'Monitor.ultima_pagina()');
        define('FN_PAGINACION_JS',          'Monitor.cambiar_paginacion()');
    ?>

    <div class="main-container container-xxl mt-3">
        <!-- HEADER DEL GRID-->
        <div class="row pb-3 pt-2">
            <div class="col">
                <h1 class="only-title p-2">
                    <span class="grid-tit-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                    <span class="grid-tit-text">
                        <span class="grid-subtit">MONITOR</span>
                    </span>
                </h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grid btn-default float-end m-1" onclick="" disabled style="display: none;"><i class="fa-solid fa-file-arrow-up"></i> Agregar Factura(s)</button>
            </div>
        </div>

        <div class="row datagrid-container">
            <div class="col-xxl">
                <table id="<?= ID_TABLA_GRID ?>" class="table datagrid datagrid-top-line-blue">
                  <thead>
                    <tr class="datagrid-filters">
                      <td><input id="flt_id" class="form-control form-control-sm m-1" type="text" value="" placeholder="ID"/></td>
                      <td><input id="flt_emisor" class="form-control form-control-sm m-1" type="text" value="" placeholder="Emisor"/></td>
                      <td><input id="flt_receptor" class="form-control form-control-sm m-1" type="text" value="" placeholder="Receptor"/></td>
                       <td><input id="flt_fecha_solicitud" class="form-control form-control-sm m-1 datetimepicker-input"  data-target="#flt_fecha_solicitud" type="text" value="" placeholder="Fecha solicitud"/></td>
                      <td colspan="2"><input id="flt_factura" class="form-control form-control-sm m-1" type="text" value="" placeholder="Factura"/></td>
                      <td><input id="flt_items" class="form-control form-control-sm m-1" type="text" value="" placeholder="&Iacute;tems"/></td>
                      <td><input id="flt_fecha_entrega" class="form-control form-control-sm m-1" type="text" value="" placeholder="Fecha entrega"/></td>
                      <td>                                                                                                                                       
                        <button type="button" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_FILTRAR_GRID_JS ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="BUSCAR REGISTROS"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="button" id="btn_check"  class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_CHECK_GRID_JS ?>"><i class="fa-solid fa-square-check" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="SELECCIONAR TODOS LOS REGISTROS"></i></button>
                        <button type="button" id="btn_uncheck" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_UNCHECK_GRID_JS ?>"><i class="fa-regular fa-square" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="DESELECCIONAR TODOS LOS REGISTROS"></i></button>
                        <button style="padding: 5px 4px!important;" disabled="disabled" id="descarga-archivo-salisa-multiple" type="button" class="btn btn-dark-blue float-start m-1" onclick="Monitor.descargar_multiples_archivos_salida()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="DESCARGAR M&Uacute;LTIPLES ARCHIVOS EN 1 SOLO ARCHIVO SALIDA"><i style="margin-left: 5px;" class="fa-solid fa-cloud-arrow-down fa-lg"><span class="span-plus-icon">+</span></i></button>
                      </td>
                      <td colspan="2">
                        <select style="float:right!important;width:70%;" class="paginacion_grid form-select form-select-sm m-1" aria-label="Small" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Cantidad de registros por p&aacute;gina" onchange="<?= FN_PAGINACION_JS ?>">
                          <option value="25">25</option>
                          <option value="50">50</option>
                          <option value="75">75</option>
                          <option value="100" selected>100</option>
                        </select>
                      </td>
                    </tr>
                    <!-- DEFINIR EL ANCHO DE LAS COLIMNAS POR EL WIDTH % DEBE DAR SIEMPRE 100% -->
                    <tr class="datagrid-columns">
                      <td style="width: 6%;">ID</td>
                      <td style="width: 13%;">Emisor</td>
                      <td style="width: 13%;">Receptor</td>
                      <td style="width: 11%;">Fecha Solicitud (CST)</td>
                      <td style="width: 22%;" colspan="2">Factura</td>
                      <td style="width: 5%;">&Iacute;tems</td>
                      <td style="width: 11%;">Fecha entrega (CST)</td>
                      <td style="width: 11%;">Tiempo procesamiento</td>
                      <td style="width: 1%;">Estatus</td>
                      <td style="width: 5%;"></td>
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
    <div id="<?= ID_MODAL_FORM ?>" class="modal fade modal-globalivoice-form" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header modal-globalinvoice">
            <h1 class="modal-title fs-5">DETALLE DE PROCESAMIENTO</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body d-flex justify-content-center">

          <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mb-4">Informaci&oacute;n general</h4>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <strong>Solicitud: </strong><label class="label-solicitud"></label>
                                
                            </div>
                            <div class="col-md-3">
                                <strong>Emisor: </strong><label class="label-emisor"></label>
                            </div>
                            <div class="col-md-3">
                                <strong>Receptor: </strong><label class="label-receptor"></label>
                            </div>
                            <div class="col-md-3">
                                <strong>Factura: </strong><label class="label-numero-factura"></label>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Estatus: </strong><label class="label-estatus"></label>
                                
                            </div>
                            <div class="col-md-3">
                                <strong>Tiempo procesamiento: </strong><label class="label-tiempo-procesamiento"></label>
                            </div>
                            <div class="col-md-3">
                                <strong>Items: </strong><label class="label-items"></label>
                            </div>                            
                        </div>                        
                    </div>
                </div>
                <p id="label-nota-factura-multiple" style="margin-top:6px; font-size:11px; display:none" align="right"><i>En archivos con mas de una factura, el tiempo de procesamiento equivale al tiempo en el que se procesaron todas las facturas del archivo original</i></p>

                <hr>

                <div class="alert alert-warning label-detalle-procesamiento" role="alert" style="display: none;"></div>
                
                <div class="row align-items-center">
                  <div class="col-12">
                    <table id="<?= ID_TABLA_LOG_PROCESAMIENTO ?>" class="table table-borderless table-sm">
                      <thead>
                        <tr>
                          <th scope="col" style="width:18%;"></th>
                          <th scope="col" style="width:21%;">Fecha solicitud</th>
                          <th scope="col" style="width:25%;">Fecha entrega (1er intento)</th>
                          <th scope="col" style="width:24%;">Fecha entrega final</th>
                          <th scope="col" style="width:14%;"></th>                          
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <p style="margin-top:-8px;  font-size:11px;" align="right"><i>Formato de fechas: dd/mm/aaaa CST</i></p>
                </div>                

                <div id="container-resultado-procesamiento" style="display: none;">
                  <h4 class="mb-3">Resultado del procesamiento</h4>

                  <div class="table-responsive">
                      <table id="tabla-avisos-procesamiento" class="table table-bordered">
                          <thead>
                              <tr>
                                  <th style="width: 10%;">Consecutivo</th>
                                  <th style="width: 90%;"> Descripci&oacute;n</th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                      </table>
                  </div>
                </div>
          </div>          
          
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>