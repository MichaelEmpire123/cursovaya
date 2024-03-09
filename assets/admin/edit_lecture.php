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

    // Получаем id лекции для редактирования
    if(isset($_GET['topic_id'])) {
        $topic_id = $_GET['topic_id'];

        // Подготавливаем SQL запрос для получения данных о лекции
        $sql_select = "SELECT * FROM Lectures WHERE id = '$topic_id'";
        $result = $link->query($sql_select);

        // Проверяем, найдена ли лекция
        if ($result->num_rows > 0) {
            // Получаем данные о лекции
            $row = $result->fetch_assoc();

            // Выводим форму для редактирования данных
            ?>
            <form method="post" action="update_lecture.php">
                <input type="hidden" name="lecture_id" value="<?php echo $row['id']; ?>">
                <label>Название лекции:</label><br>
                <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
                <label>Описание лекции:</label><br>
                <textarea name="description"><?php echo $row['description']; ?></textarea><br>
                <!-- Добавьте другие поля, если необходимо -->
                <input type="submit" value="Сохранить изменения">
            </form>
            <?php
        } else {
            echo "Лекция не найдена.";
        }
    } else {
        echo "ID лекции не указан.";
    }
} else {
    header('Location: ../pages/lectures_tema.php');
}
?>