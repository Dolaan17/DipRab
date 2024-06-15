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

// Проверка, есть ли файл модели
if (!empty($model['blend_file'])) {
    // Установка заголовков для скачивания файла
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $model['blend_file'] . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('blends/' . $model['blend_file']));

    // Вывод содержимого файла
    readfile('blends/' . $model['blend_file']);
    exit;
} else {
    echo "Файл модели не найден.";
}
