<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repoName = $_POST['repoName'];
    $repoDescription = $_POST['repoDescription'];

    // Paso 1: Crear el repositorio
    $url = 'https://api.github.com/user/repos';
    $data = array(
        'name' => $repoName,
        'description' => $repoDescription
    );
    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string),
        'Authorization: Bearer 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'
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $result = json_decode($response, true);
        if (isset($result['html_url'])) {
            echo '<h1>Repositorio creado exitosamente</h1>';
            echo '<p>Nombre: ' . $repoName . '</p>';
            echo '<p>Descripción: ' . $repoDescription . '</p>';
            echo '<p>URL: <a href="' . $result['html_url'] . '">' . $result['html_url'] . '</a></p>';

            // Paso 2: Subir carpetas al repositorio
            $repoUrl = $result['clone_url'];
            $folders = array('Documentos', 'Prueba'); // Carpeta(s) que contiene tu código a subir

            foreach ($folders as $folder) {
                // Crea un nuevo repositorio local
                exec('git init ' . $folder);

                // Agrega todos los archivos al repositorio local
                exec('cd ' . $folder . ' && git add .');

                // Realiza el primer commit
                exec('cd ' . $folder . ' && git commit -m "Initial commit"');

                // Establece el repositorio remoto
                exec('cd ' . $folder . ' && git remote add origin ' . $repoUrl);

                // Sube el código al repositorio remoto
                exec('cd ' . $folder . ' && git push -u origin master');
            }
        } else {
            echo '<h1>Error al crear el repositorio</h1>';
            echo '<p>' . $result['message'] . '</p>';
        }
    } else {
        echo '<h1>Error en la solicitud</h1>';
    }
}
?>

<form method="POST">
    <label for="repoName">Nombre del repositorio:</label>
    <input type="text" id="repoName" name="repoName" required><br>
    <label for="repoDescription">Descripción del repositorio:</label>
    <input type="text" id="repoDescription" name="repoDescription"><br>
    <input type="submit" value="Crear repositorio">
</form>
