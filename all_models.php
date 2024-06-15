
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

// Получение списка моделей из базы данных
$sql = "SELECT * FROM models WHERE published = 'да'";
$result = $conn->query($sql);
$models = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог 3D-моделей</title>
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
    max-width: 1000px;
    padding: 20px;
    background-color: transparent;
    margin: 50px auto;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

.model {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    padding: 10px;
    background-color: transparent;
    border-radius: 4px;
    position: relative;
}

.model-cover {
    width: 600px; /* Увеличен размер изображения */
    height: 400px; /* Увеличен размер изображения */
    overflow: hidden;
    margin: 0 auto; /* Центрирование изображения по горизонтали */
    border-radius: 8px; /* Добавлены закругленные углы */
}

.model-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px; /* Добавлены закругленные углы */
}

.model-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 10px; /* Добавлен отступ сверху для лучшего распределения пространства */
}

.model-info h2,
.model-info p {
    margin: 0;
}

.model-actions {
    display: flex;
    justify-content: flex-start;
    margin-top: 10px;
}

.model .cta-button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 20px;
    transition: background-color 0.3s ease;
    margin-right: 10px;
}

.model .edit-button {
    display: inline-block;
    background-color: #00cc00;
    color: white;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 20px;
    transition: background-color 0.3s ease;
    margin-right: 10px;
}




.cta-button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    padding: 12px 24px;
    border-radius: 4px;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

.cta-button:hover {
    background-color: #0056b3;
}

.search-form {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 20px;
}

.search-form input {
    padding: 8px 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    width: 300px;
}

.edit-button {
    display: inline-block;
    background-color: #ffc107;
    color: #333;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
    margin-right: 5px;
}

.edit-button:hover {
    background-color: #ffb300;
}

.edit-form {
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.edit-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.edit-form input,
.edit-form textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 10px;
}

.edit-form button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

.edit-form button:hover {
    background-color: #0056b3;
}

.search-options label {
    font-size: 30px; /* Aumentamos el tamaño del texto a 18px */
}

.search-options input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #ccc;
    outline: none;
    transition: border-color 0.3s ease;
    margin-right: 5px;
}

.model-info h2 {
    color: #00ff00;
    margin-top: 0;
    font-size: 30px; /* Увеличен размер шрифта названия */
}

.model-info p {
    margin-top: 0;
    font-size: 30px; /* Увеличен размер шрифта информации о разработчике */
}

.search-options input[type="radio"]:checked {
    border-color: #007bff;
    background-color: #007bff;
}

    </style>
</head>
<body>
    <header class="topnav">
        <a href="index.php">Титульная страница</a>
        <a class="active" href="all_models.php">Каталог 3D моделей</a>
        <a href="form.php">Загрузить 3D модель</a>
        <a href="login.php">Для разработчика</a>
    </header>

    <div class="admin-content">
        <h1>Каталог 3D-моделей</h1>
        <div class="search-container">
            <div class="search-form">
                <input type="text" id="search-input" placeholder="Поиск" onkeyup="filterModels()">
            </div>
            <div class="search-options">
                <label><input type="radio" name="search-option" value="title" checked>по названию; </label>
                <label><input type="radio" name="search-option" value="fio">по разработчику; </label>
                <label><input type="radio" name="search-option" value="facultet">по факультету</label>
            </div>
        </div>

        <div class="model-list">
            <?php if (!empty($models)) {
                foreach ($models as $model) {
                    echo '<div class="model" id="model-' . md5($model['title']) . '">';
                    echo '<div class="model-cover">';
                    if (!empty($model['image_file'])) {
                        echo '<img src="images/' . $model['image_file'] . '" alt="Изображение модели">';
                    } else {
                        echo '<img src="placeholder.jpg" alt="Изображение модели">';
                    }
                    echo '</div>';
                    echo '<div class="model-info">';
                    echo '<h2> Название: ' . $model['title'] . '</h2>';
                    echo '<p>Разработчик: ' . $model['fio'] . '</p>';
                    echo '<p>Факультет: ' . $model['facultet'] . '</p>';
                     echo '</div>';
                    echo '<div class="model-actions">';
                    echo '<a href="view_model.php?id=' . $model['id'] . '" class="cta-button">Просмотреть</a>';
                    echo '<a href="download.php?id=' . $model['id'] . '" class="edit-button">Скачать</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Нет добавленных моделей.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        function filterModels() {
            var searchInput = document.getElementById("search-input").value.toLowerCase();
            var searchOption = document.querySelector('input[name="search-option"]:checked').value;
            var models = document.getElementsByClassName("model");

            for (var i = 0; i < models.length; i++) {
                var modelData;
                if (searchOption === "title") {
                    modelData = models[i].getElementsByTagName("h2")[0].textContent.toLowerCase();
                } else if (searchOption === "fio") {
                    modelData = models[i].getElementsByTagName("p")[0].textContent.toLowerCase();
                } else if (searchOption === "facultet") {
                    modelData = models[i].getElementsByTagName("p")[1].textContent.toLowerCase();
                }

                if (modelData.includes(searchInput)) {
                    models[i].style.display = "flex";
                } else {
                    models[i].style.display = "none";
                }
            }
        }

        // Установка поиска по умолчанию на "по названию"
        document.querySelector('input[name="search-option"][value="title"]').checked = true;
    </script>

   
</body>
</html>
