<?php
// Подключение к базе данных
$servername = "localhost";
$username = "just_user1";
$password = "12345";
$dbname = "models";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка формы добавления модели
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $fio = $_POST["fio"];
    $facultet = $_POST["facultet"];

    $imgFile = $_FILES["image_file"]["name"];
    $imgTmpName = $_FILES["image_file"]["tmp_name"];
    $imgSize = $_FILES["image_file"]["size"];
    $imgError = $_FILES["image_file"]["error"];

    $blendFile = $_FILES["blend_file"]["name"];
    $blendTmpName = $_FILES["blend_file"]["tmp_name"];
    $blendSize = $_FILES["blend_file"]["size"];
    $blendError = $_FILES["blend_file"]["error"];

    // Проверка и загрузка файлов
    if ($imgError == 0 && $blendError == 0) {
        $imgDestination = "images/" . $imgFile;
        $blendDestination = "blends/" . $blendFile;

        if (move_uploaded_file($imgTmpName, $imgDestination) && move_uploaded_file($blendTmpName, $blendDestination)) {
            $published = "нет";
$viewer = "отсутствует";

            $sql = "INSERT INTO models (title, fio, facultet, image_file, blend_file, published, viewer)
       VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $title, $fio, $facultet, $imgFile, $blendFile, $published, $viewer);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $error = "Ошибка при добавлении модели: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Ошибка при загрузке файлов.";
        }
    } else {
        $error = "Ошибка при загрузке файлов.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление 3D-модели</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('fone3.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 16px 18px;
            text-decoration: none;
            font-size: 20px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        .admin-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 20px;
            background-color: transparent;
            margin: 50px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 90%;
            padding: 20px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 0 20px;
            transition: color 0.3s ease;
        }

        .header a:hover {
            color: #00ff00;
        }

        

        .add-book-form {
    background-color: rgba(255, 255, 255, 0.2);
    padding: 24px; /* Увеличил отступы внутри формы на 20% */
    border-radius: 8px;
    max-width: 864px; /* Увеличил ширину формы на 20% */
    width: 100%;
}

.add-book-form label {
    display: block;
    margin-bottom: 12px; /* Увеличил отступ между метками на 20% */
    color: white;
    font-size: 22px; /* Увеличил размер шрифта для меток на 20% */
}

.add-book-form input,
.add-book-form textarea {
    width: 90%;
    padding: 12px 19px; /* Увеличил отступы внутри полей ввода на 20% */
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 22px; /* Увеличил размер шрифта для полей ввода на 20% */
    background-color: rgba(255, 255, 255, 0.8);
    color: #333;
}

.add-book-form textarea {
    height: 144px; /* Увеличил высоту текстового поля на 20% */
}

.add-book-form input[type="submit"] {
    font-size: 22px; /* Увеличил размер шрифта для кнопки на 20% */
    padding: 12px 24px; /* Увеличил отступы для кнопки на 20% */
    margin-top: 20px;
}

        .add-book-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header class="topnav">
        <a href="index.php">Титульная страница</a>
        <a href="all_models.php">Каталог 3D моделей</a>
        <a class="active" href="form.php">Загрузить 3D модель</a>
        <a href="login.php">Для разработчика</a>
    </header>
    <div class="admin-content">
        <div class="add-book-form">
            <h2>Добавление новой 3D-модели</h2>
            <form id="add-model-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <h3><p>Пожалуйста, введите все необходимые данные и загрузите изображение с .blend-файлом.<br>
                    После отправки, модель будет рассмотрена разработчиком и добавлена в каталог моделей в течении суток.<br>
                    Большое спасибо за то, что делитесь своими разработками в Blender с другими пользователями. 
                </p></h3>
                <label for="title">Название модели:</label>
                <input type="text" id="title" name="title" required>
                <div id="title-error" class="error-message"></div>

                <label for="fio">ФИО разработчика:</label>
                <input type="text" id="fio" name="fio" required>
                <div id="fio-error" class="error-message"></div>

                <label for="facultet">Факультет:</label>
                <input type="text" id="facultet" name="facultet" required>
                <div id="facultet-error" class="error-message"></div>

                <label for="image_file">Изображение модели:</label>
                <input type="file" id="image_file" name="image_file" accept="image/*" required>
                <div id="image_file-error" class="error-message"></div>

                <label for="blend_file">Файл модели:</label>
                <input type="file" id="blend_file" name="blend_file" accept=".blend" required>
                <div id="blend_file-error" class="error-message"></div>

                <center><input type="submit" value="Отправить"></center>
            </form>
            <?php if (isset($error)) { ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php } ?>
        </div>
    </div>


    <script>
        function validateForm() {
            let isValid = true;

            // Проверка заполнения полей
            if (!document.getElementById('title').value) {
                document.getElementById('title-error').textContent = "Обязательное поле";
                isValid = false;
            } else {
                document.getElementById('title-error').textContent = "";
            }

            // Остальная часть кода для проверки других полей, аналогичная вашему предыдущему примеру
            // ...

            // Проверка загрузки файлов
            if (!document.getElementById('image_file').files.length) {
                document.getElementById('image_file-error').textContent = "Необходимо загрузить файл";
                isValid = false;
            } else {
                document.getElementById('image_file-error').textContent = "";
            }

            if (!document.getElementById('blend_file').files.length) {
                document.getElementById('blend_file-error').textContent = "Необходимо загрузить файл";
                isValid = false;
            } else {
                document.getElementById('blend_file-error').textContent = "";
            }

            return isValid;
        }
    </script>
</body>
</html>
