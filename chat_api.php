<?php
// chat_api.php
// Endpoint HTTP (síncrono) para cargar historial y marcar mensajes como leídos.
// El cliente JavaScript llamará a este archivo vía AJAX.

header('Content-Type: application/json');

// =========================================================================
// 1. CONFIGURACIÓN DE BASE DE DATOS (REEMPLAZAR CON TUS DATOS)
// =========================================================================
define('DB_HOST', 'localhost'); // O la IP de tu DB
define('DB_USER', 'root');      // Tu usuario de DB
define('DB_PASS', 'tu_password'); // Tu contraseña de DB
define('DB_NAME', 'tu_base_de_datos'); // El nombre de tu DB
// =========================================================================


// Conexión a la DB
try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_errno) {
        throw new Exception("Error de conexión: " . $db->connect_error);
    }
    $db->set_charset("utf8mb4");
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
    exit;
}

// Nota: Usamos $_REQUEST para manejar GET (status/history) y POST (mark_read)
$action = $_REQUEST['action'] ?? null;
$user_id = $_REQUEST['user_id'] ?? null;
$id_mve = $_REQUEST['id_mve'] ?? null;

if (!$user_id || !$id_mve) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan user_id o id_mve']);
    exit;
}

// Enrutador de acciones
switch ($action) {
    // GET: Cargar historial de chat para una MVE
    case 'history':
        handleHistory($db, $user_id, $id_mve);
        break;

    // GET: Verificar si hay mensajes no leídos para una MVE
    case 'status':
        handleStatus($db, $user_id, $id_mve);
        break;

    // POST: Marcar todos los mensajes de una MVE como leídos
    case 'mark_read':
        handleMarkRead($db, $user_id, $id_mve);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
}

$db->close();

// =========================================================================
// FUNCIONES DE LA API
// =========================================================================

/**
 * Obtiene el historial de mensajes de una conversación (MVE).
 */
function handleHistory($db, $user_id, $id_mve) {
    // Aseguramos que el chat exista (o lo creamos si es necesario)
    $id_chat = getChatId($db, $id_mve, $user_id); 
    if (!$id_chat) {
        echo json_encode([]); // Chat no existe, devuelve historial vacío
        return;
    }

    // Consulta que trae todos los mensajes de ese chat
    $stmt = $db->prepare(
        "SELECT id_sender, contenido, DATE_FORMAT(fecha_envio, '%Y-%m-%d %H:%i') AS fecha_envio
         FROM chat_messages 
         WHERE id_chat = ? 
         ORDER BY fecha_envio ASC"
    );
    $stmt->bind_param("i", $id_chat);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    
    $stmt->close();
    
    echo json_encode($messages);
}

/**
 * Verifica si el usuario actual tiene mensajes sin leer para esta MVE.
 * Esto alimenta el icono rojo/verde.
 */
function handleStatus($db, $user_id, $id_mve) {
    $id_chat = getChatId($db, $id_mve, $user_id);
    if (!$id_chat) {
        echo json_encode(['has_unread' => false]);
        return;
    }

    // Contar mensajes NO leídos ('N') donde yo soy el destinatario
    $stmt = $db->prepare(
        "SELECT COUNT(cs.id_status) AS unread_count
         FROM chat_user_status cs
         JOIN chat_messages cm ON cs.id_message = cm.id_message
         WHERE cm.id_chat = ? 
           AND cs.id_receiver = ? 
           AND cs.is_read = 'N'"
    );
    $stmt->bind_param("is", $id_chat, $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    echo json_encode(['has_unread' => $result['unread_count'] > 0]);
}

/**
 * Marca como leídos ('S') todos los mensajes de una MVE para el usuario actual.
 */
function handleMarkRead($db, $user_id, $id_mve) {
    $id_chat = getChatId($db, $id_mve, $user_id);
    if (!$id_chat) {
        echo json_encode(['success' => false, 'message' => 'Chat no encontrado']);
        return;
    }

    // Actualiza el estado a 'S' (leído)
    $stmt = $db->prepare(
        "UPDATE chat_user_status cs
         JOIN chat_messages cm ON cs.id_message = cm.id_message
         SET cs.is_read = 'S', cs.fecha_lectura = NOW()
         WHERE cm.id_chat = ? 
           AND cs.id_receiver = ? 
           AND cs.is_read = 'N'"
    );
    $stmt->bind_param("is", $id_chat, $user_id);
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    echo json_encode(['success' => true, 'updated' => $affected_rows]);
}

/**
 * Función auxiliar para obtener el ID_Chat basado en el ID_MVE.
 * (Crea el chat si no existe).
 */
function getChatId($db, $id_mve, $user_id) {
    // 1. Buscar si ya existe
    $stmt = $db->prepare("SELECT id_chat FROM chat_master WHERE id_mve = ?");
    $stmt->bind_param("i", $id_mve);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $chat = $result->fetch_assoc();
        $stmt->close();
        return $chat['id_chat'];
    }
    $stmt->close();

    // 2. Si no existe, crearlo
    $stmt_insert = $db->prepare(
        "INSERT INTO chat_master (id_mve, nombre_chat, fecha_creacion, is_activo) 
         VALUES (?, ?, NOW(), 'S')"
    );
    $chat_name = "Chat MVE #" . $id_mve;
    $stmt_insert->bind_param("is", $id_mve, $chat_name);
    
    if ($stmt_insert->execute()) {
        $new_id = $db->insert_id;
        $stmt_insert->close();
        return $new_id;
    } else {
        $stmt_insert->close();
        return null; // Error al crear
    }
}
?>