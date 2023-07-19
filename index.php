<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Release en GitHub</title>
</head>
<body>
    <h1>Crear Release en GitHub</h1>
    <form action="create_release.php" method="post">
        <label for="version">Nombre de la versión:</label>
        <input type="text" name="version" id="version" required>
        <button type="submit">Crear Release</button>
    </form>
</body>
</html>
