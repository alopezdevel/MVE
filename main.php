    <?php
        include_once './php_backend/fn_eglobalinvoice_auth.php';

        if( 1 )
            print '<script>
                   if (typeof Main === \'undefined\') {
                     $.getScript(\'./js/main.js\', function() {
                        Main.init()
                     });
                   } else {
                        Main.init()
                   }
                   </script>';
        else
            print '<script>javascript: window.location = \'./index.php\' </script>';
    ?>

    <div class="main-container container-xxl mt-3" style="width: 100%; display: none;">
      <div class="mt-3">
        <h1><!--<i class="fa-solid fa-bell"></i>--><i class="fa-solid fa-bell fa-shake"></i><span style="font-size: 20px;">Aviso</span></h3>
        <hr class="mt-2 mb-4 border-secondary-subtle">
        <div class="alert alert-info" role="alert">
          <label style="font-size: 15px" > <b> Nueva actualizacion disponible.! </b> </label>
        </div>
      </div>
    </div>

    <div class="main-container container-xxl mt-3" style="width: 100%;">
      <div class="mt-3"> 
        <h1><i class="fa-solid fa-chart-line"></i><span style="font-size: 20px;">Reporte de facturas procesadas</span></h3>
        <hr class="mt-2 mb-4 border-secondary-subtle">

        <div class="row align-items-center">
          <div class="col-12">
            <table id="table-reporte-facturas-procesadas" class="table table-striped table-sm">
              <thead>
                <tr style="background-color: rgba(211,232,249);">
                  <th scope="col" style="width: 10%;"><button type="button" id="btn-generar-reporte-facturas-procesadas" class="btn btn-grid btn-cyan btn-icon float-start m-1" onclick="Main.listado_reporte_facturas_procesadas()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="GENERAR REPORTE"><i class="fa-solid fa-arrows-rotate"></i></button></th>
                  <th scope="col" style="width: 10%;"></th>
                  <th scope="col" style="width: 20%;"></th>
                  <th scope="col" style="width: 5%;"></th>
                  <th scope="col" style="width: 10%;" colspan="2" class="text-center"><?= get_mes(date('m', strtotime('-1 month', strtotime(date('Y-m-d'))))) . ' ' . date('Y') ?></th>
                  <th scope="col" style="width: 10%;" colspan="2" class="text-center"><?= get_mes(date('m')) . ' ' . date('Y') ?></th>
                </tr>
                <tr style="background: linear-gradient(rgb(211, 232, 249) 0%, rgb(242, 249, 255) 100%)">
                  <th class="text-center" scope="col" style="width: 20%;">Emisor</th>
                  <th class="text-center" scope="col" style="width: 20%;">Receptor</th>
                  <th class="text-center" scope="col" style="width: 20%;">Nombre plantilla</th>
                  <th class="text-center" scope="col" style="width: 7%;">Formato</th>
                  <th class="text-center" scope="col" style="width: 5%;">Total <br> facturas</th>
                  <th class="text-center" scope="col" style="width: 5%;">Total <br> &iacute;tems</th>
                  <th class="text-center" scope="col" style="width: 5%;">Total <br> facturas</th>
                  <th class="text-center" scope="col" style="width: 5%;">Total <br> &iacute;tems</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot></tfoot>
            </table>
          </div>
          <div class="col-2"></div>
          <div class="container-loader" align="center"></div>
        </div>
      </div>
    </div>