<?php
    // Obtenemos el ID del producto desde el formulario
    $id = $_POST["id"];

    // Verificamos que el ID no esté vacío
    if (empty($id)) {
        header("Location:admin-prod.php?error=missing_id");
        exit();
    }

    // URL de la solicitud DELETE, incluyendo el ID del producto
    $url = 'http://microproductos:3002/productos/' . $id;

    // Inicializar cURL
    $ch = curl_init();

    // Configurar opciones de cURL para una solicitud DELETE
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud DELETE
    $response = curl_exec($ch);

    // Manejar la respuesta
    if ($response === false) {
        header("Location:admin-prod.php?error=delete_failed");
        exit();
    }

    // Cerrar la conexión cURL
    curl_close($ch);

    // Redirigir de nuevo a la página de administración de productos
    header("Location:admin-prod.php?success=product_deleted");
    exit();
?>
