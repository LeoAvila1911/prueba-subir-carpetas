<?php
$repoOwner = 'LeoAvila1911'; // Reemplaza con el nombre del propietario del repositorio
$repoName = 'prueba-subir-carpetas'; // Reemplaza con el nombre de tu repositorio
$commitMessage = 'prueba 0.1.1'; // Reemplaza con el mensaje del commit
$githubToken = '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'; // Reemplaza con tu token de acceso personal de GitHub

$commitCommands = array(
    'cd C:\xampp\htdocs\Prueba api && git add . && git commit -m "'.$commitMessage.'"',
    // Agrega más comandos para cada carpeta que desees incluir en el push
);

foreach ($commitCommands as $command) {
    exec($command);
}

$pushCommand = 'cd C:\xampp\htdocs\Prueba api && git push origin master'; // Reemplaza /ruta/a/repo con la ruta a tu repositorio local
exec($pushCommand);

?>
