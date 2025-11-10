<?php

    isset($_GET['i']) ? $id = $_GET['i'] : die("Error al inicializar los paramentos necesarios.");
    
    include_once './php_backend/fn_eglobalinvoice_auth.php';

    if ( session_valida() === false )
         http_response(401);    
        
    include './php_backend/Monitor.php';

    $Monitor = new Monitor();
    
    $response = $Monitor->get_archivo_original($id);
    
    if( $response === false )
    {
        print $Monitor->msg_error;
        exit();
    }
    
    $name      = $response['archivo_nombre'];
    $size      = $response['archivo_tamano'];
    $contenido = $response['archivo_contenido'];
    
    $_file = explode('.', $name);
    if ( isset($_file[1]) && strtolower($_file[1]) == 'pdf' ) {
        $type = 'application/pdf';
    } else if ( isset($_file[1]) && in_array(strtolower($_file[1]), array('xls', 'xlsx')) ) {
        $type = 'application/vnd.ms-excel';
    } else {
        $type = 'application/octet-stream';
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-type: $type");
    header("Content-length: $size");
    header("Content-Disposition: inline; filename=$name");
    header("Content-Description: PHP Generated Data");

    print base64_decode($contenido);    
