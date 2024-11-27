<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
</head>
<body>
    <h1>Subir Imagen o Video a Cloudinary</h1>
    <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
        <label for="file">Seleccionar archivo:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Subir</button>
    </form>
</body>
</html>
