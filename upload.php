<?php

$repoOwner = 'LeoAvila1911'; // Reemplaza con el nombre del propietario del repositorio
$repoName = 'prueba-subir-carpetas'; // Reemplaza con el nombre de tu repositorio
$commitMessage = 'Commit Prueba 0.1'; // Reemplaza con el mensaje del commit
$githubToken = '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'; // Reemplaza con tu token de acceso personal de GitHub

$url = "https://api.github.com/repos/$repoOwner/$repoName/git/trees/master?recursive=1";

$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $githubToken,
    'User-Agent: PHP'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

if ($response !== false) {
    $result = json_decode($response, true);
    if (isset($result['tree'])) {
        $files = $result['tree'];

        foreach ($files as $file) {
            $filePath = $file['path'];
            $fileContent = file_get_contents($filePath);

            $data = array(
                'message' => $commitMessage,
                'content' => base64_encode($fileContent)
            );

            $dataString = json_encode($data);

            $url = "https://api.github.com/repos/$repoOwner/$repoName/contents/$filePath";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response === false) {
                echo 'Error al subir el archivo ' . $filePath . '<br>';
            }
        }

        echo 'Todos los archivos subidos exitosamente.';
    } else {
        echo 'Error al obtener la lista de archivos.';
    }
} else {
    echo 'Error en la solicitud a la API de GitHub.';
}

?>
