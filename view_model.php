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

// Получение ID модели из URL
$modelId = $_GET['id'];

// Получение данных модели из базы данных
$sql = "SELECT * FROM models WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $modelId);
$stmt->execute();
$result = $stmt->get_result();
$model = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Страница с 3D-моделью</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .sketchfab-embed-wrapper {
            width: 100%;
            height: 100%;
        }
        .sketchfab-embed-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="sketchfab-embed-wrapper">
        <?php echo $model['viewer']; ?>
    </div>
</body>
</html>
