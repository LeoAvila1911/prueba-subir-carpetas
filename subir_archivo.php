<?php

// Datos del archivo y del repositorio
$archivoLocal = 'C:\xampp\htdocs\mequieromori\LEER.txt'; // Cambiar al path del archivo que deseas subir
$archivoNombre = 'LEER.txt'; // Cambiar al nombre que deseas para el archivo en el repositorio
$repositorioNombre = 'Prueba-Crear-Repositorio-2'; // Cambiar al nombre del repositorio
$repositorioPropietario = 'LeoAvila1911'; // Cambiar al nombre de usuario del propietario del repositorio
$branch = 'main'; // Cambiar al nombre de la rama principal del repositorio

// Datos de autenticación
$accessToken = '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';

// Leer el contenido del archivo local
$archivoContenido = file_get_contents($archivoLocal);

// Datos para la solicitud PUT (creación o actualización del archivo)
$data = array(
    'message' => 'Agregar archivo al repositorio',
    'content' => base64_encode($archivoContenido)
);

// Convertir los datos a formato JSON
$dataJson = json_encode($data);

// URL de la API de GitHub para crear o actualizar el archivo
$apiUrl = 'https://api.github.com/repos/' . $repositorioPropietario . '/' . $repositorioNombre . '/contents/' . $archivoNombre;

// Configurar la solicitud cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Script');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: token ' . $accessToken
));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);

// Ejecutar la solicitud cURL
$result = curl_exec($ch);

// Verificar el resultado y cerrar la solicitud cURL
if ($result === false) {
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
} else {
    $response = json_decode($result, true);
    if (isset($response['content']['sha'])) {
        echo 'Archivo subido exitosamente. SHA del commit: ' . $response['content']['sha'];
    } else {
        echo 'Error al subir el archivo. Detalles: ' . print_r($response, true);
    }
}
curl_close($ch);
