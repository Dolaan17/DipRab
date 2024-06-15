
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
$sql = "SELECT * FROM models";
$result = $conn->query($sql);
$models = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('foneofmodels.jpg');
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
            max-width: 1050px;
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
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    padding: 10px;
    background-color: transparent;
    border-radius: 4px;
    position: relative;
}

.model-cover {
    width: 350px;
    height: 250px;
    overflow: hidden;
    margin-right: 20px;
}

.model-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.model-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-right: 160px; /* Добавлено для создания места для кнопок */
        }

        .model-actions {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 20px; /* Расстояние между кнопками */
        }

.model-info h2 {
    color: #00ff00;
    margin-top: 0;
    font-size: 30px;
}

.model-info p {
    margin-top: 0;
    font-size: 30px;
}

.model .cta-button {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: inline-block;
    background-color: #ff0000;
    color: white;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 20px;
    transition: background-color 0.3s ease;
}

.model .cta-button:hover {
    background-color: #b30000;
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
.model .download-button {
            position: absolute;
            bottom: 10px;
            right: 230px;
            display: inline-block;
            background-color: #00cc00;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 20px;
            transition: background-color 0.3s ease;
        }

        .model .download-button:hover {
            background-color: #009900;
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
    font-size: 20px;
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

    </style>
</head>
<body>
    <header class="topnav">
        <a href="index.php">Титульная страница</a>
        <a href="all_models.php">Каталог 3D моделей</a>
        <a href="form.php">Загрузить 3D модель</a>
        <a href="admin.php">Для разработчика</a>
        <a class="active" href="obzor_models.php">Обзор 3D моделей</a>
    </header>

    <div class="admin-content">
        <h1>Панель разработчика</h1>
        <div class="search-container">
            <div class="search-form">
                <input type="text" id="search-input" placeholder="Поиск" onkeyup="filterModels()">
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
                    echo '<h2>Название: ' . $model['title'] . '</h2>';
                    echo '<p>ФИО: ' . $model['fio'] . '</p>';
                    echo '<p>Факультет: ' . $model['facultet'] . '</p>';
                    echo '<p>Опубликовано: ' . $model['published'] . '</p>';
                    echo '<a href="romul.php?id=' . $model['id'] . '" class="edit-button">Редактировать</a>';
                    echo '<a href="download.php?id=' . $model['id'] . '" class="download-button">Скачать файл</a>';
                    echo '<a href="delete_model.php?id=' . $model['id'] . '" class="cta-button">Удалить</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Нет добавленных моделей.</p>';
            }
            ?>
        </div>
    </div>

    <div class="edit-form" id="edit-form" style="display: none;">
        <h2>Редактирование модели</h2>
        <form method="POST" action="update_model.php">
            <input type="hidden" id="model-id" name="model-id" value="">
            <label for="model-title">Название:</label>
            <input type="text" id="model-title" name="model-title" required>
            <label for="model-fio">ФИО:</label>
            <input type="text" id="model-fio" name="model-fio" required>
            <label for="model-facultet">Факультет:</label>
            <input type="text" id="model-facultet" name="model-facultet" required>
            <label for="model-published">Статус публикации:</label>
            <input type="text" id="model-published" name="model-published" required>
            <label for="model-viewer">Просмотрщик:</label>
            <input type="text" id="model-viewer" name="model-viewer" required>
            <button type="submit">Изменить</button>
        </form>
    </div>

    <script>
        var editButtons = document.querySelectorAll('.edit-button');
        var editForm = document.getElementById('edit-form');
        var modelIdInput = document.getElementById('model-id');
        var modelTitleInput = document.getElementById('model-title');
        var modelFIOInput = document.getElementById('model-fio');
        var modelFacultetInput = document.getElementById('model-facultet');
        var modelPublishedInput = document.getElementById('model-published');
        var modelViewerInput = document.getElementById('model-viewer');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var modelId = this.getAttribute('href').split('=')[1];
                modelIdInput.value = modelId;

                // Запрос к серверу для получения данных модели
                fetch('get_model.php?id=' + modelId)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(model) {
                        modelTitleInput.value = model.title;
                        modelFIOInput.value = model.fio;
                        modelFacultetInput.value = model.facultet;
                        modelPublishedInput.value = model.published;
                        modelViewerInput.value = model.viewer;
                        editForm.style.display = 'block';
                    });
            });
        });

        function filterModels() {
            var searchInput = document.getElementById("search-input").value.toLowerCase();
            var models = document.getElementsByClassName("model");

            for (var i = 0; i < models.length; i++) {
                var modelTitle = models[i].getElementsByTagName("h2")[0].textContent.toLowerCase();
                var modelFIO = models[i].getElementsByTagName("p")[0].textContent.toLowerCase();
                var modelFacultet = models[i].getElementsByTagName("p")[1].textContent.toLowerCase();

                if (modelTitle.includes(searchInput) || modelFIO.includes(searchInput) || modelFacultet.includes(searchInput)) {
                    models[i].style.display = "flex";
                } else {
                    models[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>