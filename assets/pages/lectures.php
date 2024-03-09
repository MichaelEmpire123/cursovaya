<?php
include('../../connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лекции</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
        .index_p {
            font-size: 25px;
        }
    </style>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <div class="container">
        <div class="cont_aside">
            <?php
            include('../templates/aside.php');
            ?>
            <main>
                <h1>Лекции</h1>
                <p class="index_p">Выберите тему для изучения:</p>
                <p class="index_p">
                    <a href="./lectures_tema.php">Тема вов</a>
                    <?php
                    $sql_albums = "SELECT * FROM Lecture_Topics";
                    $result_albums = $link->query($sql_albums);
                    ?>

                    <?php
                    if (isset($_POST['status_tema'])) {
                        // Проверяем, существует ли выбор темы и статус видимости
                        if (isset($_POST['tema_vis']) && isset($_POST['topic_id'])) {
                            // Получаем значения из формы
                            $vis_status = $_POST['tema_vis'];
                            $topic_id = $_POST['topic_id'];

                            // Подготавливаем SQL-запрос для обновления статуса видимости
                            $sql_update_vis = "UPDATE Lecture_Topics SET visible = $vis_status WHERE id = $topic_id";

                            // Выполняем запрос к базе данных
                            if ($link->query($sql_update_vis) === TRUE) {
                                echo "Статус видимости успешно обновлен.";
                            } else {
                                echo "Ошибка при обновлении статуса видимости: " . $link->error;
                            }
                        }
                    }
                    ?>
                <form method="post">
                    <div class="album-list">
                        <?php foreach ($result_albums as $row_album) : ?>
                            <nav>
                                <ul>
                                    <?php
                                    // Получаем id и имя темы
                                    $topic_id = $row_album['id'];
                                    $topic_name = $row_album['name'];

                                    // Подготавливаем SQL запрос для получения значения статуса vis
                                    $sql_vis = "SELECT visible FROM Lecture_Topics WHERE id = $topic_id";

                                    // Выполняем запрос
                                    $result_vis = $link->query($sql_vis);

                                    // Проверяем, успешно ли выполнен запрос и есть ли данные
                                    if ($result_vis && $result_vis->num_rows > 0) {
                                        $row_vis = $result_vis->fetch_assoc();
                                        $vis_status = $row_vis['visible'];

                                        // Проверяем значение статуса vis
                                        if ($vis_status == 1) {
                                            // Если статус равен 1, тему можно показывать
                                    ?>
                                            <li>
                                                <a class="tema_album" href="lectures_tema.php?topic_id=<?php echo $topic_id; ?>">
                                                    <?php echo $topic_name; ?>
                                                </a>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1) : ?>
                                        <li>
                                            <a class="tema_album" href="lectures_tema.php?topic_id=<?php echo $topic_id; ?>">
                                                <?php echo $topic_name; ?>
                                            </a>
                                            <select name="tema_vis">
                                                <option value="0">Не показывать</option>
                                                <option value="1">Показать</option>
                                            </select>
                                            <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                                            <button name='status_tema' type="submit">Обновить статус</button>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endforeach; ?>
                    </div>
                </form>
                </p>


            </main>
        </div>
    </div>
</body>

</html>