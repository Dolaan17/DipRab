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

// Получение фильтра из запроса
$filter = $_GET['filter'] ?? 'all';

// Формирование SQL-запроса в зависимости от фильтра
if ($filter == 'published') {
    $sql = "SELECT * FROM models WHERE published = 'да'";
} elseif ($filter == 'unpublished') {
    $sql = "SELECT * FROM models WHERE published = 'нет'";
} else {
    $sql = "SELECT * FROM models";
}

$result = $conn->query($sql);
$models = $result->fetch_all(MYSQLI_ASSOC);

// Возвращаем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($models);

$conn->close();
?>
