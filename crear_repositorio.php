<?php

// Datos del nuevo repositorio
$repoName = 'Prueba Crear Repositorio 2'; // Cambiar al nombre que desees
$repoDescription = 'Prueba Crear Repositorio 2'; // Cambiar a la descripción que desees
$private = false; // Cambiar a true para crear un repositorio privado

// Datos de autenticación
$githubUsername = 'LeoAvila1911';
$accessToken = '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';

// URL de la API de GitHub para crear repositorios
$apiUrl = 'https://api.github.com/user/repos';

// Datos para la solicitud POST
$data = array(
    'name' => $repoName,
    'description' => $repoDescription,
    'private' => $private
);

// Convertir los datos a formato JSON
$dataJson = json_encode($data);

// Configurar la solicitud cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Script');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: token ' . $accessToken
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);

// Ejecutar la solicitud cURL
$result = curl_exec($ch);

// Verificar el resultado y cerrar la solicitud cURL
if ($result === false) {
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
} else {
    $response = json_decode($result, true);
    if (isset($response['html_url'])) {
        echo 'Repositorio creado exitosamente. URL: ' . $response['html_url'];
    } else {
        echo 'Error al crear el repositorio. Detalles: ' . print_r($response, true);
    }
}
curl_close($ch);
