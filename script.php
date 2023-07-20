<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $repoName = $_POST["repoName"];
    /* $repoDescrip = $_POST["repoDescrip"];
 */
    // Datos de autenticación de GitHub (reemplazar con tus credenciales)
    $username = "LeoAvila1911";
    $token = "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";

    // URL de la API de GitHub para crear el repositorio
    $url = "https://api.github.com/user/repos";

    // Datos del repositorio a crear
    $data = array(
        "name" => $repoName,
        /* "description" => $repoDescrip, */
    );

    // Convertir los datos a formato JSON
    $jsonData = json_encode($data);

    // Configuración de la petición curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la petición curl
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la conexión curl
    curl_close($ch);

    // Mostrar mensaje de éxito o error en el HTML
    if ($httpCode == 201) {
        echo "¡Repositorio creado exitosamente!";
    } else {
        echo "Error al crear el repositorio. Código de respuesta: $httpCode";
    }
}
?>
