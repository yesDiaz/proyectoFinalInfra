<?php
    // Recibir el usuario del formulario
    $usuario = $_POST["usuario"];

    // Verificar si el usuario está vacío
    if (empty($usuario)) {
        die("Usuario no proporcionado.");
    }

    // URL de la API de eliminación
    $url = 'http://microusuarios:3001/usuarios/' . urlencode($usuario);

    // Inicializar cURL
    $ch = curl_init();

    // Configurar cURL para la solicitud DELETE
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud DELETE
    $response = curl_exec($ch);

    // Manejar la respuesta
    if ($response === false) {
        // Redirigir en caso de error
        curl_close($ch);
        die("Error al eliminar el usuario");
    }

    // Cerrar cURL
    curl_close($ch);

    // Redirigir de nuevo a la página de administración
    header("Location: admin.php?success=usuario_eliminado");
    exit();
?>
