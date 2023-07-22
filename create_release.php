<?php

$owner = 'LeoAvila1911'; // Reemplaza con el nombre del propietario del repositorio
$repo = 'prueba-subir-carpetas'; // Reemplaza con el nombre de tu repositorio
$tag = 'v3.0.0'; // Reemplaza con la etiqueta (tag) del release
$releaseName = 'Release 3.0.0'; // Reemplaza con el nombre del release
$releaseBody = 'Prueba Release 3.0.0'; // Reemplaza con la descripción del release
$githubToken = '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'; // Reemplaza con tu token de acceso personal de GitHub

$url = "https://api.github.com/repos/{$owner}/{$repo}/releases";

$data = array(
    'tag_name' => $tag,
    'name' => $releaseName,
    'body' => $releaseBody);

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
print_r($response);
exit;
if ($response) {
    echo 'Release creado exitosamente.';
} else {
    echo 'Error al crear el release.';
}

?>
