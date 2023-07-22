<!DOCTYPE html>
<html>
<head>
    <title>Push to GitHub</title>
</head>
<body>
    <h1>Subir carpeta a GitHub</h1>
    <form action="push_to_github.php" method="post">
        <label for="rutaCarpeta">Ruta de la carpeta:</label>
        <input type="text" id="rutaCarpeta" name="rutaCarpeta" placeholder="/ruta/del/proyecto" required>
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $rutaCarpeta = $_POST["rutaCarpeta"];
        // Aquí realizaremos el proceso de push a GitHub con la ruta proporcionada.
        // Paso 3 y Paso 4 se implementarán aquí.
    }
    ?>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rutaCarpeta = $_POST["rutaCarpeta"];

    // Datos para el nuevo repositorio
    $repoName = "Prueba Repositorio"; // Cambiar al nombre que desees
    $repoDescription = "Prueba Repositorio"; // Cambiar a la descripción que desees
    $data = array(
        'name' => $repoName,
        'description' => $repoDescription,
        'private' => false
    );

    // Hacer la solicitud para crear el repositorio en GitHub
    $github_api_url = 'https://api.github.com/user/repos';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $github_api_url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Script');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: token ' . $token
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    $response = json_decode($result, true);
    curl_close($ch);

    // Verificar si la creación del repositorio fue exitosa
    if (isset($response['html_url'])) {
        echo 'Repositorio creado exitosamente. URL: ' . $response['html_url'];

        // Paso 4: Inicializar un repositorio local, agregar el control remoto de GitHub y hacer un push
        $comandoInitRepo = 'cd ' . $rutaCarpeta . ' && git init';
        $comandoAddRemote = 'cd ' . $rutaCarpeta . ' && git remote add origin ' . $response['html_url'] . '.git';
        $comandoAddAll = 'cd ' . $rutaCarpeta . ' && git add .';
        $comandoCommit = 'cd ' . $rutaCarpeta . ' && git commit -m "Primer commit"';
        $comandoPush = 'cd ' . $rutaCarpeta . ' && git push -u origin master';

        exec($comandoInitRepo);
        exec($comandoAddRemote);
        exec($comandoAddAll);
        exec($comandoCommit);
        exec($comandoPush);
    } else {
        echo 'Error al crear el repositorio. Detalles: ' . print_r($response, true);
    }
}
?>
