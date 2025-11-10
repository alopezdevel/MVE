<?php 
  include_once  __DIR__ . '/php_backend/Class/EGlobalMVE.php';
  $EGlobalMVE = new EGlobalMVE();
  $EGlobalMVE->ini();
  if( $EGlobalMVE->validar_conexion_instancia() === false ) {
    header('Location: https://www.eglobalmve.mx');
    die();
  }
?>
<?php // ofuscador de JS https://obfuscator.io/ ?>
<!DOCTYPE html>
<html class="h-100">
<head>
    <title>e-globalMVE.mx</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="text/html; charset=windows-1252" http-equiv="Content-Type">

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="img/favicon.png"/>

    <!--<script type="text/javascript" src="lib/jquery-3.6.3.min.js"></script>-->
    <script type="text/javascript" src="lib/jq.min.js"></script>
    <link rel="stylesheet" type="text/css" href="lib/jquery-ui-1.13.2.custom/jquery-ui.css"/>
    <script type="text/javascript" src="lib/jquery-ui-1.13.2.custom/jquery-ui.js"></script>
    <script type="text/javascript" src="lib/jquery.cookie.js"></script>

    <script type="text/javascript" src="./lib/jquery-validation-1.13.0/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="./js/validation_regular_expressions.js"></script>

    <!-- BOOTSTRAP -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/bootstrap/js/popper.min.js"></script>

    <!-- FONTAWESOME V6 -->
    <link href="lib/fontawesome-free-6.2.1/css/all.min.css" rel="stylesheet">

    <script>
      //eglobalinvoice.init();
    //function _0x59fa(){var _0x33813b=['1002470ZVgOin','14990XMsHdR','1524VcEYSD','1225077izXKmk','11VSlTxV','2494470UeICok','49682390pCNnrS','24xefecX','init','4222701ZuyFgq','3ZqccBC','1084728AiiyQn'];_0x59fa=function(){return _0x33813b;};return _0x59fa();}function _0x3a4c(_0x1a0145,_0x1c1005){var _0x59fa11=_0x59fa();return _0x3a4c=function(_0x3a4c08,_0x3856b1){_0x3a4c08=_0x3a4c08-0x174;var _0x1c27ce=_0x59fa11[_0x3a4c08];return _0x1c27ce;},_0x3a4c(_0x1a0145,_0x1c1005);}(function(_0xa982e,_0x3e126a){var _0x53bc94=_0x3a4c,_0x36a817=_0xa982e();while(!![]){try{var _0x2209f3=-parseInt(_0x53bc94(0x178))/0x1+-parseInt(_0x53bc94(0x17d))/0x2+parseInt(_0x53bc94(0x176))/0x3*(-parseInt(_0x53bc94(0x177))/0x4)+-parseInt(_0x53bc94(0x179))/0x5*(parseInt(_0x53bc94(0x17a))/0x6)+parseInt(_0x53bc94(0x17b))/0x7*(-parseInt(_0x53bc94(0x17f))/0x8)+-parseInt(_0x53bc94(0x175))/0x9+-parseInt(_0x53bc94(0x17e))/0xa*(-parseInt(_0x53bc94(0x17c))/0xb);if(_0x2209f3===_0x3e126a)break;else _0x36a817['push'](_0x36a817['shift']());}catch(_0xf6264e){_0x36a817['push'](_0x36a817['shift']());}}}(_0x59fa,0xa8db6),$(document)['ready'](function(){var _0x2f21fb=_0x3a4c;eglobalinvoice[_0x2f21fb(0x174)]();}));
    </script>

    <!-- MAIN GPC -->
    <!-- <script src="js/eglobalinvoice_min.js?v=<?= time() ?>" type="text/javascript"></script> -->
    <script src="js/eglobalmve.js" type="text/javascript"></script>
    <script src="js/fn_globals.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="css/eglobalmve.css">
    <!--<link rel="stylesheet" type="text/css" href="css/eglobalinvoice.css">-->  
    <link rel="stylesheet" type="text/css" href="css/style_login.css">


    <script>
      $(document).ready(function() {
        eglobalmve.init();
      });
      //eglobalmve.init();
      //function _0x59fa(){var _0x33813b=['1002470ZVgOin','14990XMsHdR','1524VcEYSD','1225077izXKmk','11VSlTxV','2494470UeICok','49682390pCNnrS','24xefecX','init','4222701ZuyFgq','3ZqccBC','1084728AiiyQn'];_0x59fa=function(){return _0x33813b;};return _0x59fa();}function _0x3a4c(_0x1a0145,_0x1c1005){var _0x59fa11=_0x59fa();return _0x3a4c=function(_0x3a4c08,_0x3856b1){_0x3a4c08=_0x3a4c08-0x174;var _0x1c27ce=_0x59fa11[_0x3a4c08];return _0x1c27ce;},_0x3a4c(_0x1a0145,_0x1c1005);}(function(_0xa982e,_0x3e126a){var _0x53bc94=_0x3a4c,_0x36a817=_0xa982e();while(!![]){try{var _0x2209f3=-parseInt(_0x53bc94(0x178))/0x1+-parseInt(_0x53bc94(0x17d))/0x2+parseInt(_0x53bc94(0x176))/0x3*(-parseInt(_0x53bc94(0x177))/0x4)+-parseInt(_0x53bc94(0x179))/0x5*(parseInt(_0x53bc94(0x17a))/0x6)+parseInt(_0x53bc94(0x17b))/0x7*(-parseInt(_0x53bc94(0x17f))/0x8)+-parseInt(_0x53bc94(0x175))/0x9+-parseInt(_0x53bc94(0x17e))/0xa*(-parseInt(_0x53bc94(0x17c))/0xb);if(_0x2209f3===_0x3e126a)break;else _0x36a817['push'](_0x36a817['shift']());}catch(_0xf6264e){_0x36a817['push'](_0x36a817['shift']());}}}(_0x59fa,0xa8db6),$(document)['ready'](function(){var _0x2f21fb=_0x3a4c;eglobalinvoice[_0x2f21fb(0x174)]();}));
    </script>    
</head>
<body class="main-login d-flex flex-column h-100">
    <!-- Contenedor de header -->
    <div id="container-header"></div>
    <!-- Contenedor de modulos -->
    <div id="container-main" class="d-flex flex-column"></div>
    <!-- Contenedor modulos modal -->
    <div id="container-modal-module" class="d-flex flex-column h-100" style="display: none;"></div>    
    <!-- Contenedor de footer -->
    <div id="container-footer" class="d-flex flex-column h-100"></div>
    <!-- Modal -->
    <div id="mensaje" class="modal fade" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header modal-eglobalmve">
            <h1 class="modal-title fs-5" id="mensajeLabel">MENSAJE DEL SISTEMA</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="img/img-modal-header.png" class="rounded me-2 img-small" alt="...">
                <strong class="me-auto">e-globalMVE.mx</strong>
                <small></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="toast-body" class="toast-body"></div>
        </div>
    </div>    
</body>
</html>