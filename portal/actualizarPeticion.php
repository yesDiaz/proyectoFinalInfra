<?php
// actualizarPeticion.php
session_start();
date_default_timezone_set('America/Bogota');  // Establecer zona horaria

// Verificar que el usuario es validador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'validador') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $id = $_POST['id'];
    $accion = $_POST['accion'];

    // URL del microservicio para actualizar la petición
    $servurl = "http://balanceadors1:3003/peticiones/" . urlencode($id);

    // Definir los datos a enviar según la acción
    $estado = ($accion === 'aceptar') ? 'aceptado' : 'rechazado';

    // Crear la solicitud al microservicio
    $data = [
        'usuariovalidador' => $_SESSION['usuario'],
        'nombrevalidador' => $_SESSION['usuario'], // Asumiendo que 'nombrevalidador' es igual al usuario
        'estado' => $estado
    ];

    // Iniciar cURL
    $curl = curl_init($servurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Ejecutar la solicitud
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Verificar la respuesta del microservicio
    if ($httpCode === 200) {
        header("Location: validador.php?mensaje=peticion_actualizada");
        exit();
    } else {
        header("Location: validador.php?error=error_actualizar_peticion");
        exit();
    }
} else {
    header("Location: validador.php");
    exit();
}
?>
