<?php
include('../../connect.php');

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ../user/profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>

    <div class="cont_aside">
        <?php
        include('../templates/aside.php');
        ?>
        <main class="container">

            <?php
            // Форма для поиска пользователя
            echo "<h3>Поиск пользователя:</h3>";
            echo "<form method='post'>";
            echo "<label for='search_user'>Введите ФИО пользователя:</label><br>";
            echo "<input type='search' class='form-control mt-2' name='search_user' id='search_user' placeholder='Введите ФИО пользователя'>";
            echo "<input class='btn btn-primary mt-2' type='submit' value='Поиск'>";
            echo "</form>";

            // Обработка поиска пользователя
            if (isset($_POST['search_user'])) {
                $search_user = $_POST['search_user'];

                // Подготовленный запрос для поиска пользователя по ФИО
                $stmt = $link->prepare("SELECT * FROM Users WHERE CONCAT(lastname, ' ', otchestvo, ' ', username) LIKE ?");
                $search_user = "%$search_user%";
                $stmt->bind_param("s", $search_user);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Вывод результатов поиска
                    echo "<h3>Результаты поиска:</h3>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<p>id пользователя: " . $row['id'] . "</p>";
                        echo "<p>ФИО: " . $row['lastname'] . " " . $row['username'] . " " . $row['otchestvo'] . "</p>";
                        echo "<p>Дата рождения: " . $row['date_rojdenia'] . "</p>";
                        echo "<p>Город: " . $row['gorod'] . "</p>";
                        echo "<p>Почта: " . $row['email'] . "</p>";
                        echo "<p>Роль: " . $row['id_role'] . "</p>";

                        // Форма для изменения роли пользователя
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                        echo "<label for='new_role'>Выберите новую роль:</label><br>";
                        echo "<select name='new_role'>";

                        // Получаем роли из таблицы role
                        $role_query = $link->query("SELECT * FROM role");
                        while ($role_row = $role_query->fetch_assoc()) {
                            echo "<option value='" . $role_row['id_role'] . "'>" . $role_row['name_role'] . "</option>";
                        }

                        echo "</select><br>";
                        echo "<input class='btn btn-primary mt-2' type='submit' name='change_role' value='Изменить роль'>";
                        echo "</form>";
                        echo '<hr>';
                    }
                } else {
                    echo "Пользователь не найден.";
                }

                // Закрытие подключения к базе данных
                $stmt->close();
            }




            // Запрос для получения всех пользователей
            $sql = "SELECT u.*, r.name_role FROM Users u LEFT JOIN role r ON u.id_role = r.id_role";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Вывод всех пользователей
                echo "<h3>Все пользователи сайта:</h3>";
                while ($row = $result->fetch_assoc()) {
                    echo "<p>id пользователя: " . $row['id'] . "</p>";
                    echo "<p>ФИО: " . $row['lastname'] . " " . $row['username'] . " " . $row['otchestvo'] . "</p>";
                    echo "<p>Дата рождения: " . $row['date_rojdenia'] . "</p>";
                    echo "<p>Город: " . $row['gorod'] . "</p>";
                    echo "<p>Почта: " . $row['email'] . "</p>";
                    echo "<p>Роль: " . $row['name_role'] . "</p>";

                    // Форма для изменения роли пользователя
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                    echo "<label for='new_role'>Выберите новую роль:</label><br>";
                    echo "<select name='new_role'>";

                    // Запрос для получения всех ролей из таблицы ролей
                    $roles_query = "SELECT * FROM role";
                    $roles_result = $link->query($roles_query);
                    while ($role_row = $roles_result->fetch_assoc()) {
                        echo "<option value='" . $role_row['id_role'] . "'>" . $role_row['name_role'] . "</option>";
                    }

                    echo "</select><br>";
                    echo "<input class='btn btn-primary mt-2' type='submit' name='change_role' value='Изменить роль'>";
                    echo "</form>";
                    echo '<hr>';
                }
            } else {
                echo "Пользователи не найдены.";
            }


            if (isset($_POST['change_role'])) {
                $user_id = $_POST['user_id'];
                $new_role = $_POST['new_role'];

                // Подготовленный запрос для обновления роли пользователя
                $stmt = $link->prepare("UPDATE Users SET id_role = ? WHERE id = ?");
                $stmt->bind_param("ii", $new_role, $user_id);
                $stmt->execute();

                // Проверка успешного обновления
                if ($stmt->affected_rows > 0) {
                    echo "Роль пользователя успешно изменена!";
                } else {
                    echo "Ошибка при изменении роли пользователя.";
                }

                $stmt->close();
            }


            // Закрытие подключения к базе данных
            $link->close();
            ?>
        </main>
    </div>

</body>

</html>