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

// Получение идентификатора модели из запроса
$modelId = $_GET['id'];

// Получение информации о модели
$sql = "SELECT image_file, blend_file FROM models WHERE id = $modelId";
$result = $conn->query($sql);
$model = $result->fetch_assoc();

// Удаление файла изображения
if (!empty($model['image_file'])) {
    $imageFile = "images/" . $model['image_file'];
    if (file_exists($imageFile)) {
        unlink($imageFile);
    }
}

// Удаление файла модели Blender
if (!empty($model['blend_file'])) {
    $blendFile = "blends/" . $model['blend_file'];
    if (file_exists($blendFile)) {
        unlink($blendFile);
    }
}

// Удаление модели из базы данных
$sql = "DELETE FROM models WHERE id = $modelId";
if ($conn->query($sql) === TRUE) {
    echo "Модель, изображение и файл модели Blender успешно удалены.";
} else {
    echo "Ошибка при удалении модели: " . $conn->error;
}

$conn->close();

// Перенаправление обратно на страницу администратора
header("Location: admin.php");
exit();
?>
