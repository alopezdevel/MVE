<?php
// chat_integration.php

// 1. DEFINICIÓN DE VARIABLES CLAVE
// Usamos las variables definidas en monitor_mve.php (MY_USER_ID, RECIPIENT_ID)
$MY_USER_ID = isset($_COOKIE["egmve_usuario_actual"]) ? $_COOKIE["egmve_usuario_actual"] : 'MV_USER_001'; 
$RECIPIENT_ID = 'TRAFICO'; 

// Incluimos los estilos del chat
print '<link rel="stylesheet" href="./css/chat_styles.css">'; 
?>

<!-- 
=========================================================================
HTML DEL MODAL DE CHAT
Usamos la estructura de tu Bootstrap 5
========================================================================= 
-->
<div id="modal-chat" class="modal fade" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Encabezado con tu clase CSS personalizada -->
            <div class="modal-header modal-eglobalmve">
                <h1 class="modal-title fs-5" id="chatModalLabel">CHAT MVE #<span id="chat-mve-id-header"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Cuerpo del Modal (Área de Mensajes) -->
            <div id="chat-messages" class="modal-body chat-messages-area">
                <div class="chat-placeholder-message">Conectando...</div>
            </div>
            
            <!-- Pie de Modal (Formulario de Envío) -->
            <div class="modal-footer chat-send-form">
                <form id="send-form" class="w-100 d-flex">
                    <input type="text" id="message-input" placeholder="Escribe un mensaje..." class="form-control chat-input">
                    <button type="submit" class="btn btn-primary chat-send-btn ms-2">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT DEL CLIENTE DE CHAT -->
<!-- ========================================================================= -->
<script>
    // Variables de configuración de PHP impresas en JavaScript
    const MY_USER_ID = '<?= $MY_USER_ID ?>';
    const RECIPIENT_ID = '<?= $RECIPIENT_ID ?>';
    
    // IP/Puerto del Servidor WebSocket (Servidor MV)
    const WS_HOST = 'ws://127.0.0.1:8000'; 
    const CHAT_API_URL = 'chat_api.php'; // Endpoint HTTP para el historial

    let ws = null; // Objeto WebSocket
    let current_id_mve = null; // El ID del MVE que se está chateando actualmente
    
    // Referencias a los elementos del Modal de Bootstrap
    // Asumo que tienes Bootstrap JS cargado.
    const chatModalElement = document.getElementById('modal-chat');
    const chatModal = new bootstrap.Modal(chatModalElement);
    const messagesDiv = document.getElementById('chat-messages');
    const sendForm = document.getElementById('send-form');

    // Inicialización al cargar el DOM
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Inicia el WebSocket en cuanto carga la página
        connectWebSocket(MY_USER_ID); 

        // 2. Manejador del formulario de envío
        if (sendForm) sendForm.addEventListener('submit', sendMessage);
        
        // 3. Limpiar variables cuando el modal de Bootstrap se oculta
        chatModalElement.addEventListener('hidden.bs.modal', function () {
            current_id_mve = null;
            messagesDiv.innerHTML = '<div class="chat-placeholder-message">Inicia la conversación.</div>';
            document.getElementById('message-input').value = '';
        });
    });

    // =========================================================================
    // LÓGICA DE TABLA / ICONO (FUNCIONES GLOBALES)
    // Estas son llamadas por tu código JS existente (Monitor.js)
    // =========================================================================

    /**
     * FUNCIÓN GLOBAL: Genera el HTML del icono de chat para la tabla.
     */
    window.generarIconoChat = function(id_mve, has_unread) {
        const colorClass = has_unread ? 'text-red-500' : 'text-green-500';
        
        return `
            <button 
                class="chat-icon-table-btn ${colorClass}"
                data-id-mve="${id_mve}" 
                title="Chat MVE #${id_mve}"
                onclick="window.openChatModal(${id_mve}, this)"
            >
                <i class="fa-solid fa-comment-dots"></i>
            </button>
        `;
    };
    
    /**
     * FUNCIÓN GLOBAL: Abre el modal de chat.
     */
    window.openChatModal = function(id_mve, iconElement) {
        current_id_mve = id_mve;
        document.getElementById('chat-mve-id-header').innerText = id_mve;
        
        chatModal.show();

        if (iconElement) {
             setTableIconColor(iconElement, 'green');
        }

        loadMessages();
    };
    
    /**
     * FUNCIÓN GLOBAL: Verifica el estado de lectura al cargar la tabla (para icono rojo/verde inicial).
     */
    window.checkInitialStatusForMVE = function(id_mve, iconElement) {
        // Usamos jQuery (ya que tu app lo usa) para llamar a la API
        $.getJSON(`${CHAT_API_URL}?action=status&user_id=${MY_USER_ID}&id_mve=${id_mve}`, function(data) {
            if (data.has_unread) {
                setTableIconColor(iconElement, 'red');
            } else {
                setTableIconColor(iconElement, 'green');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(`Error al obtener estado para MVE ${id_mve}:`, textStatus, errorThrown);
        });
    };
    
    // Función interna para cambiar el color del icono en la tabla
    function setTableIconColor(iconElement, color) {
        if (iconElement) {
             $(iconElement).removeClass('text-green-500 text-red-500');
             if (color === 'red') {
                 $(iconElement).addClass('text-red-500');
             } else {
                 $(iconElement).addClass('text-green-500');
             }
         }
    }


    // =========================================================================
    // LÓGICA DE CONEXIÓN Y MENSAJES (WebSocket y AJAX)
    // =========================================================================

    function connectWebSocket(userId) {
        ws = new WebSocket(WS_HOST);

        ws.onopen = function() {
            console.log(`[${userId}] WebSocket conectado.`);
            // Informar al servidor quién soy
            ws.send(JSON.stringify({ type: 'init', user_id: userId }));
        };

        ws.onmessage = function(e) {
            const data = JSON.parse(e.data);
            
            if (data.type === 'new_message' && data.id_mve) { 
                const targetIcon = document.querySelector(`.chat-icon-table-btn[data-id-mve="${data.id_mve}"]`);
                
                if (data.id_mve == current_id_mve && chatModal._isShown) { 
                    // Si la ventana está abierta, mostrar y marcar como leído
                    appendMessage(data.sender_id, data.message, 'received', data.fecha_envio);
                    markAsRead(); // Marcar como leído en DB
                } else if (targetIcon) {
                    // Si el chat está cerrado o en otra MVE, marcar el icono de la tabla como rojo.
                    setTableIconColor(targetIcon, 'red');
                }
            } else if (data.type === 'message_sent') {
                // Confirmación de mi propio mensaje enviado.
                appendMessage(data.sender_id, data.message, 'sent', data.fecha_envio);
            }
        };

        ws.onclose = function() {
            console.warn('WebSocket cerrado. Intentando reconectar en 3s.');
            setTimeout(() => connectWebSocket(userId), 3000); 
        };

        ws.onerror = function(e) {
            console.error('Error WebSocket:', e);
            ws.close();
        };
    }
    
    // Función para enviar el mensaje
    function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const messageText = input.value.trim();
        
        if (messageText === '' || !ws || ws.readyState !== WebSocket.OPEN || !current_id_mve) {
            return;
        }

        const message = {
            type: 'chat_message',
            recipient_id: RECIPIENT_ID, 
            message: messageText,
            id_mve: current_id_mve, 
            sender_id: MY_USER_ID 
        };
        
        ws.send(JSON.stringify(message)); 
        input.value = ''; 
    }

    // Carga los mensajes previos (AJAX)
    function loadMessages() {
        messagesDiv.innerHTML = '<div class="chat-placeholder-message">Cargando historial...</div>';

        $.getJSON(`${CHAT_API_URL}?action=history&user_id=${MY_USER_ID}&id_mve=${current_id_mve}`, function(data) {
            messagesDiv.innerHTML = ''; 
            if (data.length === 0) {
                messagesDiv.innerHTML = '<div class="chat-placeholder-message">Inicia la conversación.</div>';
            } else {
                data.forEach(msg => {
                    const type = (msg.id_sender === MY_USER_ID) ? 'sent' : 'received';
                    appendMessage(msg.id_sender, msg.contenido, type, msg.fecha_envio);
                });
            }
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll al fondo
        }).fail(function() {
            messagesDiv.innerHTML = '<div class="chat-placeholder-message text-danger">Error al cargar historial.</div>';
        });
    }
    
    // Marca los mensajes como leídos (AJAX)
    function markAsRead() {
        $.post(CHAT_API_URL, {
            action: 'mark_read',
            user_id: MY_USER_ID,
            id_mve: current_id_mve
        })
        .done(function() {
            console.log(`Mensajes de MVE ${current_id_mve} marcados como leídos.`);
        })
        .fail(function() {
            console.error('Error al marcar como leído.');
        });
    }


    // =========================================================================
    // 4. LÓGICA DE INTERFAZ Y ESTILOS
    // =========================================================================
    
    // Añade el HTML de la burbuja de chat
    function appendMessage(sender, text, type, timestamp = 'Ahora') {
        const alignment = (type === 'sent') ? 'flex-row-reverse' : 'flex-row';
        const bgColorClass = (type === 'sent') ? 'bg-primary text-white' : 'bg-secondary text-white'; 

        const messageHtml = `
            <div class="d-flex ${alignment} mb-2">
                <div class="chat-bubble ${bgColorClass} shadow-sm">
                    <p class="font-weight-bold text-sm mb-0">${sender}</p>
                    <p class="mb-0">${text}</p>
                    <span class="chat-timestamp">${timestamp}</span>
                </div>
            </div>
        `;
        $(messagesDiv).append(messageHtml);
        messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll al fondo
    }

</script>