<?php

$owner = 'LeoAvila1911'; // Reemplaza con el nombre del propietario del repositorio
$repo = ' prueba-subir-carpetas'; // Reemplaza con el nombre de tu repositorio
$tag = 'v1.0.0'; // Reemplaza con la etiqueta (tag) del release
$releaseName = 'Release 1.0.0'; // Reemplaza con el nombre del release
$releaseBody = 'Prueba Release'; // Reemplaza con la descripción del release
$githubToken = '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'; // Reemplaza con tu token de acceso personal de GitHub

$url = "https://api.github.com/repos/{$owner}/{$repo}/releases";
$data = array(
    'tag_name' => $tag,
    'name' => $releaseName,
    'body' => $releaseBody
);

$jsonData = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'User-Agent: PHP cURL',
    'Authorization: token '.$githubToken
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    echo 'Release creado exitosamente.';
} else {
    echo 'Error al crear el release.';
}

?>
