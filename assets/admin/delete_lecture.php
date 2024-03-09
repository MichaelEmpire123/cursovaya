<?php
session_start(); // Убедимся, что сессия начата

// Проверяем, была ли передана информация о пользователе с ролью администратора
if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1) {
    // Подключаемся к базе данных
    $link = new mysqli("localhost", "root", "123", "curs2");

    // Проверяем подключение
    if ($link->connect_error) {
        die("Ошибка подключения: " . $link->connect_error);
    }

    // Получаем id лекции для удаления
    if(isset($_GET['topic_id'])) {
        $topic_id = $_GET['topic_id'];

        // Подготавливаем SQL-запрос для удаления лекции
        $sql_delete = "DELETE FROM Lectures WHERE id = '$topic_id'";

        // Выполняем запрос
        if ($link->query($sql_delete) === TRUE) {
            echo "Лекция успешно удалена.";
            header('Location: ../pages/lectures_tema.php');
        } else {
            echo "Ошибка при удалении лекции: " . $link->error;
        }

        // Закрываем соединение с базой данных
        $link->close();
    } else {
        echo "ID лекции не указан.";
    }
} else {
    header('Location: ../pages/lectures_tema.php');
}
?>
