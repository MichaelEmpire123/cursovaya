<?php
include('../../connect.php');

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ../user/profile.php');
    exit;
}


if (isset($_GET['id'])) {
    // Подключение к базе данных (замените значения на свои)
    $mysqli = new mysqli("localhost", "root", "123", "curs2");

    // Проверка подключения
    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    // Получение ID новости для удаления
    $id = $_GET['id'];

    // SQL-запрос для удаления новости
    $sql = "DELETE FROM News WHERE id = ?";

    // Подготовка запроса
    $stmt = $mysqli->prepare($sql);

    // Проверка на успешную подготовку
    if ($stmt === false) {
        echo "Ошибка при подготовке запроса (" . $mysqli->error . ") " . $mysqli->error;
    }

    // Привязка параметров к запросу
    $stmt->bind_param("i", $id);

    // Выполнение запроса
    if ($stmt->execute()) {
        // Новость успешно удалена
        header("Location: ../pages/news.php"); // Перенаправляем пользователя обратно на страницу с новостями
        exit();
    } else {
        echo "Ошибка при удалении новости: " . $stmt->error;
    }

    // Закрыть соединение с базой данных
    $stmt->close();
    $mysqli->close();
} else {
    echo "Не указан ID новости для удаления.";
}
?>
