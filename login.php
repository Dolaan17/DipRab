<?php
session_start();

// Проверка авторизации
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "user_admin";
    $password_db = "admin123";
    $dbname = "admin";

    $conn = new mysqli($servername, $username, $password_db, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM admin WHERE login = '$login' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['is_authorized'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error_message = "Неправильный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <style>
        body {
            background-image: url('foneofmodels.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }

        .auth-form {
            background-color: rgba(245, 245, 245, 0.8);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            max-width: 700px;
            margin: 100px auto;
        }

        .auth-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .auth-form label {
            display: block;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .auth-form input {
            width: 90%;
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 25px;
            margin-bottom: 16px;
        }

        .auth-form button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 25px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .auth-form button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="auth-form">
        <h1>Авторизация для разработчика</h1>
        <?php if (isset($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="post" action="">
            <label for="login"><h2>Логин:</h2></label>
            <input type="text" id="login" name="login" required>
            <label for="password"><h2>Пароль:</h2></label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
