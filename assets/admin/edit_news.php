<?php

include('../../connect.php');
session_start();

// if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
//     header('Location: ../user/profile.php');
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Подключение к базе данных
    $mysqli = new mysqli("localhost", "root", "123", "curs2");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    // Получение данных из POST-запроса
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    // SQL-запрос для обновления данных новости
    $sql = "UPDATE News SET title = ?, content = ?, author = ? WHERE id = ?";

    // Подготовка запроса
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        echo "Ошибка при подготовке запроса (" . $mysqli->error . ") " . $mysqli->error;
        exit;
    }

    // Привязка параметров к запросу
    $stmt->bind_param("sssi", $title, $content, $author, $id);

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "Данные успешно обновлены.";
    } else {
        echo "Ошибка при обновлении данных: " . $stmt->error;
    }

    // Закрыть соединение с базой данных
    $stmt->close();
    $mysqli->close();
}
?>
