<?php
    $id_original = isset($_POST['id_original']) ? $_POST['id_original'] : null;
    $inventario = isset($_POST['inventario']) ? $_POST['inventario'] : null;
    
    if (empty($id_original) || !is_numeric($inventario)) {
        die("ID o inventario no válidos");
    }

    // URL para la solicitud PUT
    $url = 'http://microproductos:3002/productos/' . $id_original;

    // Datos que se enviarán en la solicitud PUT
    $data = array(
        'inventario' => $inventario
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

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Manejar la respuesta
    if ($response === false) {
        curl_close($ch);
        die("Error al actualizar el inventario");
    }

    // Cerrar cURL
    curl_close($ch);

    // Redirigir de nuevo a la página de administración de productos
    header("Location: admin-prod.php?success=inventario_actualizado");
    exit();
?>
