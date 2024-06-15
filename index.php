<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <style>
        /* Стили для шапки навигации */
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

        /* Остальные стили */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .hero {
            position: relative;
            height: 100vh;
            background-image: url('fone3.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white; /* Изменен цвет текста на белый */
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            padding: 40px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 24px;
            margin-bottom: 40px;
        }

        .author-info {
            background-color: #333;
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .author-info .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            background-image: url('author_image.jpg');
            background-size: cover;
            background-position: center;
        }

        .author-info .author-details {
            flex-grow: 1;
        }

        .author-info .author-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .author-info .author-title {
            font-size: 28px;
            color: #ccc;
        }

        .author-info .author-links {
            display: flex;
            align-items: center;
            font-size: 28px;
        }

        .author-info .author-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 28px;
        }
    </style>

    <!-- Подключение шрифтов для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header class="topnav">
        <a class="active" href="index.php">Титульная страница</a>
        <a href="all_models.php">Каталог 3D моделей</a>
        <a href="form.php">Загрузить 3D модель</a>
        <a href="login.php">Для разработчика</a>
    </header>

    <div class="hero">
        <div class="hero-content">
            <h1>Web-сайт "Работы студентов ФМФ, </h1>
            <h1>сделанные в среде 3D моделирования Blender"</h1>
        </div>
    </div>
    <div class="author-info">
        <div class="author-avatar"></div>
        <div class="author-details">
            <div class="author-name">Разработчик: Нанзат Алина Алимовна</div>
            <div class="author-title">Студентка 4 курса Тувинского Государственного Университета</div>
            <div class="author-title">группы ПрИ_300, Прикладная информатика</div>
            <br>
            <div class="author-name">Научный руководитель:</div>
            <div class="author-title">Ст.преподаватель кафедры информатики</div>
        <div class="author-name">Ооржак Чойгана Камааевна</div>
        </div>
        <div class="author-links">
            <a href="https://vk.com"><i class="fab fa-vk"></i></a>
            <a href="https://t.me"><i class="fab fa-telegram"></i></a>
            <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://ok.ru"><i class="fab fa-odnoklassniki"></i></a>
        </div>
        
    </div>
</body>
</html>
