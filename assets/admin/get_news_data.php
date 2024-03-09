<?php
include('../../connect.php');
session_start();

// if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
//     header('Location: ../user/profile.php');
//     exit;
// }


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Подключение к базе данных
    $mysqli = new mysqli("localhost", "root", "123", "curs2");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    // Получение ID новости из GET-запроса
    $id = $_GET['id'];

    // SQL-запрос для получения данных о новости
    $sql = "SELECT * FROM News WHERE id = ?";

    // Подготовка запроса
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        echo "Ошибка при подготовке запроса (" . $mysqli->error . ") " . $mysqli->error;
        exit;
    }

    // Привязка параметра к запросу
    $stmt->bind_param("i", $id);

    // Выполнение запроса
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Отправляем данные в формате JSON
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            echo "Новость не найдена.";
        }
    } else {
        echo "Ошибка при выполнении запроса: " . $stmt->error;
    }

    // Закрыть соединение с базой данных
    $stmt->close();
    $mysqli->close();
}
?>
