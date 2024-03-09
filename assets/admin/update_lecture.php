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

    // Получаем данные из формы редактирования
    $topic_id = $_POST['topic_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Подготавливаем SQL-запрос для обновления данных
    $sql_update = "UPDATE Lectures SET name='$name', description='$description' WHERE id='$topic_id'";

    // Выполняем запрос
    if ($link->query($sql_update) === TRUE) {
        echo "Данные о лекции успешно обновлены.";
        header('Location: ../pages/lectures_tema.php');
    } else {
        echo "Ошибка при обновлении данных о лекции: " . $link->error;
    }

    // Закрываем соединение с базой данных
    $link->close();
} else {
    header('Location: ../pages/lectures_tema.php');
}
?>
