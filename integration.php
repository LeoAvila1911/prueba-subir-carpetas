<?php

// Paso 1: Crear proyecto en Zenodo
$zenodoUrl = 'https://zenodo.org/api/deposit/depositions';
$zenodoToken = 'Y9zp5U5MPHTM7o28LIzHmggKMeGRXgpfMbczV3CVYdLXS3SmfheJHZnes6ug';

$zenodoData = array(
    'metadata' => array(
        'title' => 'Integration Zenodo & GitHub-0.1',
        'description' => 'Prueba para comprobar la integración entre Zenodo y GitHub',
        // Añade más campos según sea necesario
    )
);
$zenodoDataString = json_encode($zenodoData);

$zenodoHeaders = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $zenodoToken
);

$zenodoCh = curl_init($zenodoUrl);
curl_setopt($zenodoCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($zenodoCh, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($zenodoCh, CURLOPT_POST, true);
curl_setopt($zenodoCh, CURLOPT_POSTFIELDS, $zenodoDataString);
curl_setopt($zenodoCh, CURLOPT_HTTPHEADER, $zenodoHeaders);

$zenodoResponse = curl_exec($zenodoCh);
curl_close($zenodoCh);

if ($zenodoResponse !== false) {
    $zenodoResult = json_decode($zenodoResponse, true);
    if (isset($zenodoResult['id'])) {
        echo '<h1>Proyecto en Zenodo creado exitosamente</h1>';
        echo '<p>ID: ' . $zenodoResult['id'] . '</p>';
        echo '<p>Título: ' . $zenodoResult['metadata']['title'] . '</p>';
        echo '<p>Descripción: ' . $zenodoResult['metadata']['description'] . '</p>';

        // Paso 2: Asociar el proyecto de Zenodo con el repositorio de GitHub
        $githubUrl = 'https://api.github.com/user/repos';
        $githubToken = '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';

        $githubData = array(
            'name' => 'Prueba Integration Zenodo & GitHub',
            'description' => 'Integration Zenodo & GitHub'
        );
        $githubDataString = json_encode($githubData);

        $githubHeaders = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $githubToken
        );

        $githubCh = curl_init($githubUrl);
        curl_setopt($githubCh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($githubCh, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($githubCh, CURLOPT_POST, true);
        curl_setopt($githubCh, CURLOPT_POSTFIELDS, $githubDataString);
        curl_setopt($githubCh, CURLOPT_HTTPHEADER, $githubHeaders);

        $githubResponse = curl_exec($githubCh);
        curl_close($githubCh);

        if ($githubResponse !== false) {
            $githubResult = json_decode($githubResponse, true);
            if (isset($githubResult['html_url'])) {
                echo '<h1>Repositorio de GitHub creado exitosamente</h1>';
                echo '<p>Nombre: ' . $githubResult['name'] . '</p>';
                echo '<p>Descripción: ' . $githubResult['description'] . '</p>';
                echo '<p>URL: <a href="' . $githubResult['html_url'] . '">' . $githubResult['html_url'] . '</a></p>';

                // Paso 3: Vincular el proyecto de Zenodo con el repositorio de GitHub
                $zenodoProjectId = $zenodoResult['id'];
                $githubRepoUrl = $githubResult['clone_url'];

                // Aquí puedes agregar el código necesario para vincular el proyecto de Zenodo con el repositorio de GitHub utilizando cURL o cualquier otra herramienta que prefieras.

                // Una vez que hayas realizado la vinculación, puedes mostrar el proyecto final en HTML
                echo '<h2>Proyecto final:</h2>';
                echo '<p>Proyecto en Zenodo: <a href="https://zenodo.org/record/' . $zenodoProjectId . '">' . $zenodoProjectId . '</a></p>';
                echo '<p>Repositorio en GitHub: <a href="' . $githubRepoUrl . '">' . $githubRepoUrl . '</a></p>';
            } else {
                echo '<p>Error al crear el repositorio en GitHub</p>';
            }
        } else {
            echo '<p>Error en la solicitud a la API de GitHub</p>';
        }
    } else {
        echo '<p>Error al crear el proyecto en Zenodo</p>';
    }
} else {
    echo '<p>Error en la solicitud a la API de Zenodo</p>';
}
?>
