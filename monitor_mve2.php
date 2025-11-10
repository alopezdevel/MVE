<?php
        include_once __DIR__ . '/php_backend/Class/ControlAcceso.php';

        if( ControlAcceso::validar_session() )
            print '<script>
                   if (typeof MonitorMVE3 === \'undefined\') {
                     $.getScript(\'./js/monitor_mve3.js\', function() {
                        MonitorMVE3.init()
                     });
                   } else {
                        MonitorMVE3.init()
                   }
                   </script>';
        else
            print "<script>javascript: window.location = './index.php' </script>"; 


        /* ---- Definimos los atributos de html necesarios ----- */
        define('ID_TABLA_GRID',       'table-datagrid-monitor2');
        define('ID_MODAL_FORM',       'modal-agregar-mve');

        /* ---- Definimos los nombres de las funciones de javascript ----- */
        define('FN_FILTRAR_GRID_JS',        'MonitorMVE3.filtrar_grid()');
        define('FN_NUEVO_REGISTRO_JS',      'MonitorMVE3.nuevo_registro()');
        define('FN_PRIMERA_PAGINA_JS',      'MonitorMVE3.primera_pagina()');
        define('FN_PAGINA_PREVIA_JS',       'MonitorMVE3.pagina_previa()');
        define('FN_PAGINA_SIGUIENTE_JS',    'MonitorMVE3.pagina_siguiente()');
        define('FN_ULTIMA_PAGINA_JS',       'MonitorMVE3.ultima_pagina()');
        define('FN_ELIMINAR_REGISTRO_JS',   'MonitorMVE3.eliminar_registro()');
        define('FN_PAGINACION_JS',          'MonitorMVE3.cambiar_paginacion()');
?>

    <div class="main-container container-xxl mt-3">
        <!-- HEADER DEL GRID-->
        <div class="row pb-3 pt-2">
            <div class="col">
                <h1 class="only-title p-2">
                    <span class="grid-tit-icon"><i class="fa-solid fa-file-shield"></i></i></span>
                    <span class="grid-tit-text">
                        <span class="grid-subtit">MANIFESTACIONES DE VALOR 2</span>
                    </span>
                </h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grid btn-default float-end m-1" onclick="<?= FN_NUEVO_REGISTRO_JS ?>"><i class="fa-solid fa-file-arrow-up"></i> Agregar MVE</button>
            </div>
        </div>

        <div class="row datagrid-container">
            <div class="col-xxl">
                <table id="<?= ID_TABLA_GRID ?>" class="table datagrid datagrid-top-line-blue">
                  <thead>
                    <tr class="datagrid-filters">
                      <td></td>
                      <td><input id="flt_importador" class="form-control form-control-sm m-1" type="text" value="" placeholder="Importador"/></td>
                      <td><input id="flt_pedimento" class="form-control form-control-sm m-1" type="text" value="" placeholder="Pedimento"/></td>
                      <td><input id="flt_valor_aduana" class="form-control form-control-sm m-1" type="text" value="" placeholder="Valor Aduana"/></td>
                      <td><input id="flt_fecha_solicitud" class="form-control form-control-sm m-1" type="text" value="" placeholder="Fecha Solicitud (CST)"/></td>
                      <td><input id="flt_mve" class="form-control form-control-sm m-1" type="text" value="" placeholder="MVE"/></td>
                      <td>
                        <button type="button" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_FILTRAR_GRID_JS ?>"><i class="fa-solid fa-magnifying-glass"></i></button>
                      </td>
                      <td>
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
                      <td style="width: 2%;"><i class="fa-solid fa-comment"></i></td>
                      <td style="width: 15%;">Importador</td>
                      <td style="width: 15%;">Pedimento</td>
                      <td style="width: 15%;">Valor Aduana</td>
                      <td style="width: 12%;">Fecha Solicitud (CST)</td>
                      <td style="width: 12%;">MVE</td>
                      <td style="width: 5%;">Estatus</td>
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
    <div id="<?= ID_MODAL_FORM ?>" class="modal fade modal-eglobalmve-form" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header modal-eglobalmve">
            <h1 class="modal-title fs-5">Agregar Manifestaci&oacute;n de Valor</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body d-flex justify-content-center">
            <div class="container-fluid">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="tab-identificacion-tab" data-bs-toggle="tab" data-bs-target="#tab-identificacion" type="button" role="tab" aria-controls="tab-identificacion" aria-selected="true">Datos de Identificaci&oacute;n</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="tab-coves-tab" data-bs-toggle="tab" data-bs-target="#tab-coves" type="button" role="tab" aria-controls="tab-coves" aria-selected="false">Detalle COVEs</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="tab-totales-tab" data-bs-toggle="tab" data-bs-target="#tab-totales" type="button" role="tab" aria-controls="tab-totales" aria-selected="false">Resumen de Totales</button>
                </li>
              </ul>

              <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="tab-identificacion" role="tabpanel" aria-labelledby="tab-identificacion-tab">
                  <p>Los campos marcados con un (<span style="color:#d01515;"> * </span>) son obligatorios:</p>
                  <fieldset>
                    <legend>DATOS GENERALES</legend>
                    <div class="row align-items-center">
                      <div class="col-4"><label for="mve_rfc" class="col-form-label">RFC del Importador/Exportador <span style="color:#d01515;">*</span></label></div>
                      <div class="col-7"><input type="text" class="form-control form-control-sm" id="mve_rfc" maxlength="13" placeholder="ABC123456XYZ"></div>
                    </div>
                  </fieldset>
                </div>

                <div class="tab-pane fade" id="tab-coves" role="tabpanel" aria-labelledby="tab-coves-tab">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Detalle de COVEs</h5>
                    <button type="button" class="btn btn-primary" id="btn-add-cove"><i class="fa-solid fa-plus"></i> A&ntilde;adir COVE</button>
                  </div>
                  <div id="coves-accordion" class="accordion"></div>
                  <div id="coves-empty" class="text-center text-muted py-4 border rounded">
                    <div class="mb-2"><i class="fa-regular fa-file-lines fa-2xl"></i></div>
                    <div>No hay COVEs registrados. Haga clic en "A&ntilde;adir COVE" para comenzar.</div>
                  </div>
                </div>

                <div class="tab-pane fade" id="tab-totales" role="tabpanel" aria-labelledby="tab-totales-tab">
                  <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                      <div class="border rounded p-3 h-100">
                        <label class="fw-semibold text-muted small d-block">Total Precio Pagado</label>
                        <div class="fs-4 fw-bold">$<span id="totalPrecioPagado">0.00</span></div>
                      </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                      <div class="border rounded p-3 h-100">
                        <label class="fw-semibold text-muted small d-block">Total Precio por Pagar</label>
                        <div class="fs-4 fw-bold">$<span id="totalPrecioPorPagar">0.00</span></div>
                      </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                      <div class="border rounded p-3 h-100">
                        <label class="fw-semibold text-muted small d-block">Total Incrementables</label>
                        <div class="fs-4 fw-bold">$<span id="totalIncrementables">0.00</span></div>
                      </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                      <div class="border rounded p-3 h-100">
                        <label class="fw-semibold text-muted small d-block">Total Decrementables</label>
                        <div class="fs-4 fw-bold">- $<span id="totalDecrementables">0.00</span></div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="border rounded p-3">
                        <label class="fw-semibold text-muted small d-block">Total Valor en Aduana</label>
                        <div class="fs-3 fw-bold text-primary">$<span id="totalValorAduana">0.00</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn-guardar-mve">Guardar</button>
          </div>
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