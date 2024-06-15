
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "just_user1";
$password = "12345";
$dbname = "models";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del modelo desde la URL
$modelId = $_GET['id'];

// Obtener los datos del modelo de la base de datos
$sql = "SELECT * FROM models WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $modelId);
$stmt->execute();
$result = $stmt->get_result();
$model = $result->fetch_assoc();

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $fio = $_POST["fio"];
    $facultet = $_POST["facultet"];
    $published = $_POST["published"];
    $viewer = $_POST["viewer"];

    $imageFile = $model['image_file'];
    $imageTmpName = $_FILES["image_file"]["tmp_name"];
    $imageSize = $_FILES["image_file"]["size"];
    $imageError = $_FILES["image_file"]["error"];

    $blendFile = $model['blend_file'];
    $blendTmpName = $_FILES["blend_file"]["tmp_name"];
    $blendSize = $_FILES["blend_file"]["size"];
    $blendError = $_FILES["blend_file"]["error"];

    // Verificar si se cargó una nueva imagen
    if (!empty($imageTmpName)) {
        $imageFile = $_FILES["image_file"]["name"];
        $imageDestination = "images/" . $imageFile;
        if (move_uploaded_file($imageTmpName, $imageDestination)) {
            // La imagen se cargó correctamente
        } else {
            $error = "Error al cargar la imagen.";
        }
    }

    // Verificar si se cargó un nuevo archivo Blend
    if (!empty($blendTmpName)) {
        $blendFile = $_FILES["blend_file"]["name"];
        $blendDestination = "blends/" . $blendFile;
        if (move_uploaded_file($blendTmpName, $blendDestination)) {
            // El archivo Blend se cargó correctamente
        } else {
            $error = "Error al cargar el archivo Blend.";
        }
    }

    // Actualizar el registro en la base de datos
    $sql = "UPDATE models
            SET title = ?, fio = ?, facultet = ?, published = ?, viewer = ?, image_file = ?, blend_file = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $title, $fio, $facultet, $published, $viewer, $imageFile, $blendFile, $modelId);

    if ($stmt->execute()) {
        // Redirigir a la página admin.php después de la actualización exitosa
        header("Location: admin.php");
        exit();
    } else {
        $error = "Error al actualizar el modelo: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование модели</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    font-size: 18px; /* Увеличен размер шрифта */
    background-color: #1E1E1E;
    color: #FFFFFF;
}

.header a {
    color: #FFFFFF;
    text-decoration: none;
    font-size: 22px; /* Увеличен размер шрифта */
    margin: 0 20px;
    transition: color 0.3s ease;
}


        .header {
            background-color: #2C2C2C;
            padding: 20px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        

        .header a:hover {
            color: #00D8FF;
        }

        .admin-content {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #2C2C2C;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .edit-book-form {
            padding: 20px;
        }

        .edit-book-form label {
    display: block;
    margin-bottom: 10px;
    color: #FFFFFF;
    font-size: 18px; /* Увеличен размер шрифта */
}

.edit-book-form input,
.edit-book-form textarea {
    width: 90%;
    padding: 12px 16px; /* Увеличен отступ внутри полей */
    border: 1px solid #3C3C3C;
    border-radius: 4px;
    font-size: 18px; /* Увеличен размер шрифта */
    background-color: #1E1E1E;
    color: #FFFFFF;
}

        .edit-book-form textarea {
    height: 120px; /* Увеличена высота текстового поля */
}

.edit-book-form input[type="submit"] {
    font-size: 18px; /* Увеличен размер шрифта */
    padding: 12px 24px; /* Увеличен отступ внутри кнопки */
    background-color: #00D8FF;
    color: #1E1E1E;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

        .edit-book-form input[type="submit"]:hover {
            background-color: #00B0D7;
        }

        .error-message {
    color: #FF6B6B;
    font-size: 16px; /* Увеличен размер шрифта */
    font-weight: bold;
    margin-top: 5px;
}
    </style>
</head>
<body>


    <div class="admin-content">
        <div class="edit-book-form">
            <h2>Редактирование модели</h2>
            <form id="edit-model-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $modelId; ?>" method="post" enctype="multipart/form-data">
                <label for="title">Название модели:</label>
                <input type="text" id="title" name="title" value="<?php echo $model['title']; ?>" required>
                <div id="title-error" class="error-message"></div>

                <label for="fio">ФИО разработчика:</label>
                <input type="text" id="fio" name="fio" value="<?php echo $model['fio']; ?>" required>
                <div id="fio-error" class="error-message"></div>

                <label for="facultet">Факультет:</label>
                <input type="text" id="facultet" name="facultet" value="<?php echo $model['facultet']; ?>" required>
                <div id="facultet-error" class="error-message"></div>

                <label for="published">Опубликовано:</label>
                <input type="text" id="published" name="published" value="<?php echo $model['published']; ?>" required>
                <div id="published-error" class="error-message"></div>

                <label for="viewer">Просмотрщик:</label>
                <input type="text" id="viewer" name="viewer" value="<?php echo $model['viewer']; ?>" required>
                <div id="viewer-error" class="error-message"></div>

                <label for="image_file">Изображение:</label>
                <input type="file" id="image_file" name="image_file" accept="image/*">
                <div id="image_file-error" class="error-message"></div>

                <label for="blend_file">Blend-файл:</label>
                <input type="file" id="blend_file" name="blend_file" accept=".blend">
                <div id="blend_file-error" class="error-message"></div>

                <center><input type="submit" value="Сохранить"></center>
            </form>
            <?php if (isset($error)) { ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
