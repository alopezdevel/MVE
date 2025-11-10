<?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        #include_once './php_backend/fn_eglobalinvoice_auth.php';

       # $minjs = true;

       # $minjs == true ? define('ScriptJS', 'main_monitor_min.js') : define('ScriptJS', 'main_monitor.js');
       define('ScriptJS', 'main_monitor.js');

       #print_r($_SESSION['eglobalmve']);
       #exit;

       include_once  __DIR__ . '/php_backend/Class/ControlAcceso.php';

       $ControlAcceso = new ControlAcceso();

        if( $ControlAcceso->validar_session() )
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
            print '<script>javascript: window.location = \'./\' </script>';


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
                    <span class="grid-tit-icon"><i class="fa-solid fa-file-shield"></i></i></span>
                    <span class="grid-tit-text">
                        <span class="grid-subtit">MANIFESTACIONES DE VALOR</span>
                    </span>
                </h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grid btn-default float-end m-1" onclick="Monitor.agregar_mve()"><i class="fa-solid fa-file-arrow-up"></i> Agregar MVE</button>
            </div>
        </div>

        <div class="row datagrid-container">
            <div class="col-xxl">
                <table id="<?= ID_TABLA_GRID ?>" class="table datagrid datagrid-top-line-blue">
                  <thead>
                    <tr class="datagrid-filters">
                      <td></td>
                      <td><input id="flt_id" class="form-control form-control-sm m-1" type="text" value="" placeholder="Importador"/></td>
                        <td><input id="flt_importador" class="form-control form-control-sm m-1" type="text" value="" placeholder="Pedimento"/></td>
                       <td><input id="flt_pedimento" class="form-control form-control-sm m-1 datetimepicker-input"  data-target="#flt_fecha_solicitud" type="text" value="" placeholder="Valor Aduana"/></td>
                      <td ><input id="flt_valor_aduana" class="form-control form-control-sm m-1" type="text" value="" placeholder="Fecha Solicitud (CST)"/></td>
                      <td><input id="flt_mve" class="form-control form-control-sm m-1" type="text" value="" placeholder="MVE"/></td>
                      <!--
                      <td>                                                                                                                                       
                        <button type="button" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_FILTRAR_GRID_JS ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="BUSCAR REGISTROS"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="button" id="btn_check"  class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_CHECK_GRID_JS ?>"><i class="fa-solid fa-square-check" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="SELECCIONAR TODOS LOS REGISTROS"></i></button>
                        <button type="button" id="btn_uncheck" class="btn btn-dark-blue btn-icon float-start m-1" onclick="<?= FN_UNCHECK_GRID_JS ?>"><i class="fa-regular fa-square" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="DESELECCIONAR TODOS LOS REGISTROS"></i></button>
                        <button style="padding: 5px 4px!important;" disabled="disabled" id="descarga-archivo-salisa-multiple" type="button" class="btn btn-dark-blue float-start m-1" onclick="Monitor.descargar_multiples_archivos_salida()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="DESCARGAR M&Uacute;LTIPLES ARCHIVOS EN 1 SOLO ARCHIVO SALIDA"><i style="margin-left: 5px;" class="fa-solid fa-cloud-arrow-down fa-lg"><span class="span-plus-icon">+</span></i></button>
                      </td>
                      -->
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
                      <td style="width: 2%;"><i class="fa-solid fa-comment"></i></td>
                      <td style="width: 6%;">Importador</td>
                      <td style="width: 13%;">Pedimento</td>
                      <td style="width: 13%;">Valor Aduana</td>
                      <td style="width: 11%;">Fecha Solicitud (CST)</td>
                      <td style="width: 11%;">MVE</td>
                      <td style="width: 1%;">Estatus</td>
                      <td style="width: 5%;"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">3</span>
                        </span>
                      </td>
                      <td>ACME S.A. de C.V.</td>
                      <td>24 01 1234 5678901</td>
                      <td>$ 1,245,300.00</td>
                      <td>30/10/2025</td>
                      <td>MVE-2025-0001</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-1 fa-solid fa-clock" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PENDIENTE" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174571,1)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#51cf66,#2f9e44); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(47,158,68,.35); text-align:center;">0</span>
                        </span>
                      </td>
                      <td>Global Import S. de R.L.</td>
                      <td>24 02 5678 1234567</td>
                      <td>$ 980,750.50</td>
                      <td>29/10/2025</td>
                      <td>MVE-2025-0002</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-2 fa-solid fa-circle-check" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ENTREGADA" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174579,3)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">7</span>
                        </span>
                      </td>
                      <td>Tech Parts Mexicana</td>
                      <td>24 03 4321 7654321</td>
                      <td>$ 2,310,100.00</td>
                      <td>28/10/2025</td>
                      <td>MVE-2025-0003</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-circle-pause" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="EN ESPERA" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174573,2)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">1</span>
                        </span>
                      </td>
                      <td>Logística del Norte</td>
                      <td>24 04 2468 1357913</td>
                      <td>$ 450,000.00</td>
                      <td>27/10/2025</td>
                      <td>MVE-2025-0004</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-triangle-exclamation" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ERROR" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174574,5)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">5</span>
                        </span>
                      </td>
                      <td>Industrias Rivera</td>
                      <td>24 05 1111 2222333</td>
                      <td>$ 125,900.75</td>
                      <td>26/10/2025</td>
                      <td>MVE-2025-0005</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-5 fa-solid fa-clock" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PENDIENTE" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174575,1)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#51cf66,#2f9e44); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(47,158,68,.35); text-align:center;">0</span>
                        </span>
                      </td>
                      <td>Exportadora del Pacífico</td>
                      <td>24 06 9999 8888777</td>
                      <td>$ 3,780,450.00</td>
                      <td>25/10/2025</td>
                      <td>MVE-2025-0006</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-circle-check" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ENTREGADA" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174576,3)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">2</span>
                        </span>
                      </td>
                      <td>Componentes Atlas</td>
                      <td>24 07 3141 5926535</td>
                      <td>$ 890,000.00</td>
                      <td>24/10/2025</td>
                      <td>MVE-2025-0007</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-circle-pause" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="EN ESPERA" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174577,2)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#ff6b6b,#e03131); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(224,49,49,.35); text-align:center;">9</span>
                        </span>
                      </td>
                      <td>Textiles Orion</td>
                      <td>24 08 2718 2818281</td>
                      <td>$ 215,320.40</td>
                      <td>23/10/2025</td>
                      <td>MVE-2025-0008</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-clock" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PENDIENTE" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174578,1)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                    <tr>
                      <td>
                        <span style="position:relative; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#f3f6ff; color:#0d6efd; border:1px solid #dbe4ff; border-radius:999px; box-shadow:0 1px 2px rgba(0,0,0,.08);">
                          <i class="fa-regular fa-comments" style="font-size:14px;"></i>
                          <span style="position:absolute; top:-7px; right:-7px; min-width:18px; height:18px; padding:0 5px; background:linear-gradient(180deg,#51cf66,#2f9e44); color:#fff; border:1px solid rgba(255,255,255,.9); border-radius:999px; font-size:11px; font-weight:600; line-height:16px; box-shadow:0 2px 4px rgba(47,158,68,.35); text-align:center;">0</span>
                        </span>
                      </td>
                      <td>Química Andrómeda</td>
                      <td>24 10 1414 2135623</td>
                      <td>$ 675,890.99</td>
                      <td>21/10/2025</td>
                      <td>MVE-2025-0010</td>
                      <td class="text-center" style="cursor: pointer"><i class="icon-estatus-3 fa-solid fa-circle-check" style="font-size: 2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ENTREGADA" data-bs-custom-class="tooltip-estatus-3" onclick="Monitor.detalle_solicitud(174580,3)"></i></td>
                      <td><button type="button" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Usuarios.editar_registro('bmY=')"><i class="fa-solid fa-pen-to-square"></i></button></td>
                    </tr>
                  </tbody>
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

    <script>
      (function(){
        let coveCounter = 0;
        const covesData = {};

        document.addEventListener('click', function(e){
          if (e.target && e.target.id === 'btn-add-cove') {
            e.preventDefault();
            addCove();
          }
        }, true);

        function addCove(){
          coveCounter++;
          const coveId = `cove_${coveCounter}`;
          covesData[coveId] = { numero: '', precioPagado: [], precioPorPagar: [], compensoPago: [], incrementables: [], decrementables: [] };

          const accordion = document.getElementById('coves-accordion');
          const empty = document.getElementById('coves-empty');
          if (empty) empty.style.display = 'none';

          const collapseId = `${coveId}_collapse`;
          const headerId = `${coveId}_header`;

          const item = document.createElement('div');
          item.className = 'accordion-item';
          item.innerHTML = `
            <h2 class="accordion-header" id="${headerId}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                📦 COVE #${coveCounter} <span class="text-muted ms-2 small">(Sin n&uacute;mero asignado)</span>
              </button>
            </h2>
            <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headerId}" data-bs-parent="#coves-accordion">
              <div class="accordion-body">
                <fieldset>
                  <legend>INFORMACI&Oacute;N DEL COVE</legend>
                  <div class="row g-2">
                    <div class="col-md-4">
                      <label class="form-label">N&uacute;mero de COVE <span style=\"color:#d01515;\">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="${coveId}_numero">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Incoterm <span style=\"color:#d01515;\">*</span></label>
                      <select class="form-select form-select-sm" id="${coveId}_incoterm"></select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Existe Vinculaci&oacute;n <span style=\"color:#d01515;\">*</span></label>
                      <div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="${coveId}_vinculacion" value="1">
                          <label class="form-check-label">S&iacute;</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="${coveId}_vinculacion" value="0" checked>
                          <label class="form-check-label">No</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row g-2 mt-1">
                    <div class="col-md-6">
                      <label class="form-label">M&eacute;todo de Valoraci&oacute;n <span style=\"color:#d01515;\">*</span></label>
                      <select class="form-select form-select-sm" id="${coveId}_metodo_val"></select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Aduana</label>
                      <input type="text" class="form-control form-control-sm" id="${coveId}_aduana" placeholder="01 - Tijuana">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Patente</label>
                      <input type="text" class="form-control form-control-sm" id="${coveId}_patente" placeholder="1234">
                    </div>
                  </div>
                  <div class="row g-2 mt-1">
                    <div class="col-md-6">
                      <label class="form-label">N&uacute;mero de Pedimento</label>
                      <input type="text" class="form-control form-control-sm" id="${coveId}_pedimento" placeholder="24 01 1234 5678901">
                    </div>
                  </div>
                </fieldset>

                <br>

                <fieldset>
                  <legend>💵 Precio Pagado</legend>
                  <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-block="precioPagado" data-cove="${coveId}"><i class="fa-solid fa-plus"></i> A&ntilde;adir</button>
                  </div>
                  <div id="${coveId}_precioPagado" class="repeatable-items empty border rounded p-2 text-center text-muted">No hay precios pagados registrados</div>
                </fieldset>

                <fieldset>
                  <legend>💳 Precio por Pagar</legend>
                  <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-block="precioPorPagar" data-cove="${coveId}"><i class="fa-solid fa-plus"></i> A&ntilde;adir</button>
                  </div>
                  <div id="${coveId}_precioPorPagar" class="repeatable-items empty border rounded p-2 text-center text-muted">No hay precios por pagar registrados</div>
                </fieldset>

                <fieldset>
                  <legend>🔄 Compenso de Pago</legend>
                  <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-block="compensoPago" data-cove="${coveId}"><i class="fa-solid fa-plus"></i> A&ntilde;adir</button>
                  </div>
                  <div id="${coveId}_compensoPago" class="repeatable-items empty border rounded p-2 text-center text-muted">No hay compensos de pago registrados</div>
                </fieldset>

                <fieldset>
                  <legend>📈 Incrementables</legend>
                  <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-block="incrementables" data-cove="${coveId}"><i class="fa-solid fa-plus"></i> A&ntilde;adir</button>
                  </div>
                  <div id="${coveId}_incrementables" class="repeatable-items empty border rounded p-2 text-center text-muted">No hay incrementables registrados</div>
                </fieldset>

                <fieldset>
                  <legend>📉 Decrementables</legend>
                  <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-block="decrementables" data-cove="${coveId}"><i class="fa-solid fa-plus"></i> A&ntilde;adir</button>
                  </div>
                  <div id="${coveId}_decrementables" class="repeatable-items empty border rounded p-2 text-center text-muted">No hay decrementables registrados</div>
                </fieldset>
              </div>
            </div>
          `;

          accordion.appendChild(item);

          // Listeners por COVE
          const numeroInput = item.querySelector(`#${coveId}_numero`);
          numeroInput.addEventListener('input', function(){
            covesData[coveId].numero = this.value;
            const btn = item.querySelector('.accordion-button');
            const base = `📦 COVE #${coveCounter}`;
            const suffix = this.value ? ` <span class="ms-2" style="color:#2563eb; font-weight:600;">${this.value}</span>` : ' <span class="text-muted ms-2 small">(Sin n&u00FAmero asignado)</span>';
            btn.innerHTML = base + suffix;
          });

          // Delegar clicks en botones de bloques dentro del cove
          item.addEventListener('click', function(ev){
            const btn = ev.target.closest('button');
            if (!btn) return;
            const block = btn.getAttribute('data-block');
            const targetCove = btn.getAttribute('data-cove');
            if (!block || !targetCove) return;
            openItemModal(targetCove, block);
          });

          // Inicializar selects (placeholder para futura carga de catálogos)
          // Se pueden poblar mediante AJAX según catálogos reales
        }

        // Modal simple para capturar items
        function ensureItemModal(){
          if (document.getElementById('mveItemModal')) return;
          const modal = document.createElement('div');
          modal.innerHTML = `
            <div class="modal fade" id="mveItemModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header modal-eglobalmve">
                    <h1 class="modal-title fs-6" id="mveItemModalTitle">Añadir</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="mveItemModalBody"></div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="mveItemModalSave">Guardar</button>
                  </div>
                </div>
              </div>
            </div>`;
          document.body.appendChild(modal);
        }

        function openItemModal(coveId, blockType){
          ensureItemModal();
          const titleMap = {
            precioPagado: 'Añadir Precio Pagado',
            precioPorPagar: 'Añadir Precio por Pagar',
            compensoPago: 'Añadir Compenso de Pago',
            incrementables: 'Añadir Incrementable',
            decrementables: 'Añadir Decrementable'
          };
          document.getElementById('mveItemModalTitle').textContent = titleMap[blockType] || 'Añadir';
          document.getElementById('mveItemModalBody').innerHTML = generateFormHTML(blockType);

          const saveBtn = document.getElementById('mveItemModalSave');
          saveBtn.onclick = function(){ saveItem(coveId, blockType); };

          const modal = new bootstrap.Modal(document.getElementById('mveItemModal'));
          modal.show();
        }

        function generateFormHTML(blockType){
          const monedaSelect = '<option value="">Seleccione...</option><option value="MXN">MXN</option><option value="USD">USD</option><option value="EUR">EUR</option>';
          const tipoPagoSelect = '<option value="">Seleccione...</option><option>Efectivo</option><option>Transferencia</option><option>Cheque</option><option>Carta de Crédito</option><option>Otro</option>';
          const tipoIncrementable = '<option value="">Seleccione...</option><option>Comisiones</option><option>Gastos de Transporte</option><option>Seguros</option>';
          const tipoDecrementable = '<option value="">Seleccione...</option><option>Gastos de Construcción</option><option>Derechos Arancelarios</option>';

          const forms = {
            precioPagado: `
              <div class="mb-2"><label class="form-label">Fecha de Pago *</label><input type="date" class="form-control form-control-sm" id="modal_fechaPago"></div>
              <div class="mb-2"><label class="form-label">Total *</label><input type="number" class="form-control form-control-sm" id="modal_total" step="0.01" placeholder="0.00"></div>
              <div class="mb-2"><label class="form-label">Tipo de Pago *</label><select id="modal_tipoPago" class="form-select form-select-sm">${tipoPagoSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Moneda *</label><select id="modal_tipoMoneda" class="form-select form-select-sm">${monedaSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Cambio *</label><input type="number" class="form-control form-control-sm" id="modal_tipoCambio" step="0.0001" value="1.0000"></div>
            `,
            precioPorPagar: `
              <div class="mb-2"><label class="form-label">Fecha de Pago</label><input type="date" class="form-control form-control-sm" id="modal_fechaPago"></div>
              <div class="mb-2"><label class="form-label">Total *</label><input type="number" class="form-control form-control-sm" id="modal_total" step="0.01" placeholder="0.00"></div>
              <div class="mb-2"><label class="form-label">Situaci&oacute;n</label><input type="text" class="form-control form-control-sm" id="modal_situacion"></div>
              <div class="mb-2"><label class="form-label">Tipo de Pago *</label><select id="modal_tipoPago" class="form-select form-select-sm">${tipoPagoSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Moneda *</label><select id="modal_tipoMoneda" class="form-select form-select-sm">${monedaSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Cambio *</label><input type="number" class="form-control form-control-sm" id="modal_tipoCambio" step="0.0001" value="1.0000"></div>
            `,
            compensoPago: `
              <div class="mb-2"><label class="form-label">Fecha *</label><input type="date" class="form-control form-control-sm" id="modal_fecha"></div>
              <div class="mb-2"><label class="form-label">Motivo *</label><input type="text" class="form-control form-control-sm" id="modal_motivo"></div>
              <div class="mb-2"><label class="form-label">Prestaci&oacute;n *</label><input type="text" class="form-control form-control-sm" id="modal_prestacion"></div>
              <div class="mb-2"><label class="form-label">Tipo de Pago *</label><select id="modal_tipoPago" class="form-select form-select-sm">${tipoPagoSelect}</select></div>
            `,
            incrementables: `
              <div class="mb-2"><label class="form-label">Tipo de Incrementable *</label><select id="modal_tipoIncrementable" class="form-select form-select-sm">${tipoIncrementable}</select></div>
              <div class="mb-2"><label class="form-label">Fecha de Erogaci&oacute;n *</label><input type="date" class="form-control form-control-sm" id="modal_fechaErogacion"></div>
              <div class="mb-2"><label class="form-label">Importe *</label><input type="number" class="form-control form-control-sm" id="modal_importe" step="0.01" placeholder="0.00"></div>
              <div class="mb-2"><label class="form-label">Tipo de Moneda *</label><select id="modal_tipoMoneda" class="form-select form-select-sm">${monedaSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Cambio *</label><input type="number" class="form-control form-control-sm" id="modal_tipoCambio" step="0.0001" value="1.0000"></div>
              <div class="mb-2">
                <label class="form-label">¿A cargo del importador? *</label>
                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="aCargoImportador" value="1" checked><label class="form-check-label">S&iacute;</label></div>
                <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="aCargoImportador" value="0"><label class="form-check-label">No</label></div>
              </div>
            `,
            decrementables: `
              <div class="mb-2"><label class="form-label">Tipo de Decrementable *</label><select id="modal_tipoDecrementable" class="form-select form-select-sm">${tipoDecrementable}</select></div>
              <div class="mb-2"><label class="form-label">Fecha de Erogaci&oacute;n *</label><input type="date" class="form-control form-control-sm" id="modal_fechaErogacion"></div>
              <div class="mb-2"><label class="form-label">Importe *</label><input type="number" class="form-control form-control-sm" id="modal_importe" step="0.01" placeholder="0.00"></div>
              <div class="mb-2"><label class="form-label">Tipo de Moneda *</label><select id="modal_tipoMoneda" class="form-select form-select-sm">${monedaSelect}</select></div>
              <div class="mb-2"><label class="form-label">Tipo de Cambio *</label><input type="number" class="form-control form-control-sm" id="modal_tipoCambio" step="0.0001" value="1.0000"></div>
            `
          };
          return forms[blockType] || '';
        }

        function saveItem(coveId, blockType){
          const data = {};
          switch(blockType){
            case 'precioPagado':
              data.fechaPago = document.getElementById('modal_fechaPago').value;
              data.total = parseFloat(document.getElementById('modal_total').value || '0');
              data.tipoPago = document.getElementById('modal_tipoPago').value;
              data.tipoMoneda = document.getElementById('modal_tipoMoneda').value;
              data.tipoCambio = parseFloat(document.getElementById('modal_tipoCambio').value || '1');
              if (!data.fechaPago || !data.total || !data.tipoPago || !data.tipoMoneda || !data.tipoCambio) return;
              break;
            case 'precioPorPagar':
              data.fechaPago = document.getElementById('modal_fechaPago').value;
              data.total = parseFloat(document.getElementById('modal_total').value || '0');
              data.situacion = document.getElementById('modal_situacion').value || '';
              data.tipoPago = document.getElementById('modal_tipoPago').value;
              data.tipoMoneda = document.getElementById('modal_tipoMoneda').value;
              data.tipoCambio = parseFloat(document.getElementById('modal_tipoCambio').value || '1');
              if (!data.total || !data.tipoPago || !data.tipoMoneda || !data.tipoCambio) return;
              break;
            case 'compensoPago':
              data.fecha = document.getElementById('modal_fecha').value;
              data.motivo = document.getElementById('modal_motivo').value;
              data.prestacion = document.getElementById('modal_prestacion').value;
              data.tipoPago = document.getElementById('modal_tipoPago').value;
              if (!data.fecha || !data.motivo || !data.prestacion || !data.tipoPago) return;
              break;
            case 'incrementables':
              data.tipoIncrementable = document.getElementById('modal_tipoIncrementable').value;
              data.fechaErogacion = document.getElementById('modal_fechaErogacion').value;
              data.importe = parseFloat(document.getElementById('modal_importe').value || '0');
              data.tipoMoneda = document.getElementById('modal_tipoMoneda').value;
              data.tipoCambio = parseFloat(document.getElementById('modal_tipoCambio').value || '1');
              data.aCargoImportador = document.querySelector('input[name="aCargoImportador"]:checked')?.value || '1';
              if (!data.tipoIncrementable || !data.fechaErogacion || !data.importe || !data.tipoMoneda || !data.tipoCambio) return;
              break;
            case 'decrementables':
              data.tipoDecrementable = document.getElementById('modal_tipoDecrementable').value;
              data.fechaErogacion = document.getElementById('modal_fechaErogacion').value;
              data.importe = parseFloat(document.getElementById('modal_importe').value || '0');
              data.tipoMoneda = document.getElementById('modal_tipoMoneda').value;
              data.tipoCambio = parseFloat(document.getElementById('modal_tipoCambio').value || '1');
              if (!data.tipoDecrementable || !data.fechaErogacion || !data.importe || !data.tipoMoneda || !data.tipoCambio) return;
              break;
          }

          covesData[coveId][blockType].push(data);
          renderItem(coveId, blockType, data, covesData[coveId][blockType].length - 1);
          calcTotals();
          const modalEl = document.getElementById('mveItemModal');
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();
        }

        function renderItem(coveId, blockType, data, index){
          const container = document.getElementById(`${coveId}_${blockType}`);
          if (!container) return;
          container.classList.remove('empty', 'text-center', 'text-muted');

          const item = document.createElement('div');
          item.className = 'repeatable-item border rounded p-2 mb-2';
          item.setAttribute('data-index', index);

          let html = '';
          if (blockType === 'precioPagado') {
            const totalMXN = data.total * data.tipoCambio;
            html = `<div><strong>${formatDate(data.fechaPago)}</strong> — ${data.tipoMoneda} ${formatNumber(data.total)} (MXN ${formatNumber(totalMXN)}) · ${data.tipoPago} · T.C. ${data.tipoCambio.toFixed(4)}</div>`;
          } else if (blockType === 'precioPorPagar') {
            const totalMXN = data.total * data.tipoCambio;
            html = `<div><strong>${data.fechaPago ? formatDate(data.fechaPago) : 'Pendiente'}</strong> — ${data.tipoMoneda} ${formatNumber(data.total)} (MXN ${formatNumber(totalMXN)}) · ${data.tipoPago} · ${data.situacion || 'N/A'} · T.C. ${data.tipoCambio.toFixed(4)}</div>`;
          } else if (blockType === 'compensoPago') {
            html = `<div><strong>${formatDate(data.fecha)}</strong> — ${data.motivo} · ${data.prestacion} · ${data.tipoPago}</div>`;
          } else if (blockType === 'incrementables') {
            const importeMXN = data.importe * data.tipoCambio;
            html = `<div><strong>${data.tipoIncrementable}</strong> — ${formatDate(data.fechaErogacion)} · ${data.tipoMoneda} ${formatNumber(data.importe)} (MXN ${formatNumber(importeMXN)}) · ${data.aCargoImportador === '1' ? 'A cargo importador' : 'No a cargo'} · T.C. ${data.tipoCambio.toFixed(4)}</div>`;
          } else if (blockType === 'decrementables') {
            const importeMXN = data.importe * data.tipoCambio;
            html = `<div><strong>${data.tipoDecrementable}</strong> — ${formatDate(data.fechaErogacion)} · ${data.tipoMoneda} ${formatNumber(data.importe)} (MXN ${formatNumber(importeMXN)}) · T.C. ${data.tipoCambio.toFixed(4)}</div>`;
          }

          item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
              <div>${html}</div>
              <button type="button" class="btn btn-danger btn-sm" aria-label="Eliminar" data-action="del-item" data-block="${blockType}" data-cove="${coveId}" data-index="${index}"><i class="fa-solid fa-trash"></i></button>
            </div>`;

          container.appendChild(item);

          // eliminar item
          item.querySelector('[data-action="del-item"]').addEventListener('click', function(){
            const idx = parseInt(this.getAttribute('data-index'), 10);
            const blk = this.getAttribute('data-block');
            const cv = this.getAttribute('data-cove');
            covesData[cv][blk].splice(idx, 1);
            container.innerHTML = '';
            covesData[cv][blk].forEach((it, i) => renderItem(cv, blk, it, i));
            if (covesData[cv][blk].length === 0) {
              container.classList.add('empty', 'text-center', 'text-muted');
              container.textContent = blk === 'precioPagado' ? 'No hay precios pagados registrados' : blk === 'precioPorPagar' ? 'No hay precios por pagar registrados' : blk === 'compensoPago' ? 'No hay compensos de pago registrados' : blk === 'incrementables' ? 'No hay incrementables registrados' : 'No hay decrementables registrados';
            }
            calcTotals();
          });
        }

        function calcTotals(){
          let totalPrecioPagado = 0, totalPrecioPorPagar = 0, totalIncrementables = 0, totalDecrementables = 0;
          Object.values(covesData).forEach(cv => {
            cv.precioPagado.forEach(it => totalPrecioPagado += (it.total || 0) * (it.tipoCambio || 1));
            cv.precioPorPagar.forEach(it => totalPrecioPorPagar += (it.total || 0) * (it.tipoCambio || 1));
            cv.incrementables.forEach(it => totalIncrementables += (it.importe || 0) * (it.tipoCambio || 1));
            cv.decrementables.forEach(it => totalDecrementables += (it.importe || 0) * (it.tipoCambio || 1));
          });
          const totalValorAduana = totalPrecioPagado + totalPrecioPorPagar + totalIncrementables - totalDecrementables;
          setText('totalPrecioPagado', formatNumber(totalPrecioPagado));
          setText('totalPrecioPorPagar', formatNumber(totalPrecioPorPagar));
          setText('totalIncrementables', formatNumber(totalIncrementables));
          setText('totalDecrementables', formatNumber(totalDecrementables));
          setText('totalValorAduana', formatNumber(totalValorAduana));
        }

        function setText(id, txt){ const el = document.getElementById(id); if (el) el.textContent = txt; }
        function formatNumber(num){ return (Number(num)||0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
        function formatDate(str){ if(!str) return 'N/A'; const d = new Date(str + 'T00:00:00'); return d.toLocaleDateString('es-MX',{year:'numeric',month:'2-digit',day:'2-digit'}); }
      })();
    </script>

    <!-- Modal -->
    <div id="modal-agregar-mve" class="modal fade modal-eglobalmve-form" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
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