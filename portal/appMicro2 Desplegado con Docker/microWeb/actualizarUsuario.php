<?php
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // URL de la solicitud PUT (usamos el usuario_original para identificar al usuario)
    $url = 'http://microusuarios:3001/usuarios/' . $usuario;

    // Datos que se enviarán en la solicitud PUT
    $data = array(
        'nombre' => $nombre,
        'email' => $email, // Este es el nuevo valor de email
        'usuario' => $usuario, // Este es el nuevo valor de usuario
        'password' => $password
    );
    $json_data = json_encode($data);

    // Inicializar cURL
    $ch = curl_init();

    // Configurar cURL para la solicitud PUT
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud PUT
    $response = curl_exec($ch);

    // Manejar la respuesta
    if ($response === false) {
        // Redirigir en caso de error
        curl_close($ch);
        die("Error al actualizar los datos");
    }

    // Cerrar la conexión cURL
    curl_close($ch);

    // Redirigir de nuevo a la página de administración
    header("Location: admin.php?success=usuario_actualizado");
    exit();
?>
