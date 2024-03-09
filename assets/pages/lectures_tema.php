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

        p {
            font-size: 20px;
        }

        img {
            width: 400px;
            height: 400px;
        }

        video {
            width: 400px;
            height: 400px;
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
                <div class="container">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1) : ?>
                        <form method="post" id="lecture_form" enctype="multipart/form-data">
                            <h3>Форма добавления</h3>
                            <label>Напишите подраздел лекции</label> <br>
                            <input class="form-control" type="text" name="razdel_tema"> <br>
                            <label>Напишите текст лекции</label> <br>
                            <textarea class="w-100 form-control" name="text_tema" id="text_tema" cols="20" rows="5"></textarea><br>
                            <label>Выберите фото для лекции</label> <br>
                            <input class="form-control" type="file" name="photo_tema"> <br>
                            <label>Выберите видео для лекции</label> <br>
                            <input class="form-control" type="file" name="video_tema"> <br>
                            <input class="btn btn-primary" type="submit" name='btn_tema_add' value="Добавить">
                        </form>

                        <?php
                        // Проверяем, была ли отправлена форма методом POST
                        if (isset($_POST['btn_tema_add'])) {
                            // Подключение к базе данных должно быть предварительно установлено

                            // Получаем данные из формы
                            $razdel = $_POST['razdel_tema']; // Подраздел лекции
                            $text = $_POST['text_tema']; // Текст лекции

                            // Получаем topic_id из URL
                            $topic_id = $_GET['topic_id']; // Предполагается, что вы получаете topic_id из URL

                            // Проверяем, было ли загружено видео
                            if (isset($_FILES['video_tema']) && $_FILES['video_tema']['error'] === UPLOAD_ERR_OK) {
                                $uploadDirVideo = "../content/video/"; // Путь к папке, где хранятся видео
                                $videoFileName = basename($_FILES['video_tema']['name']);
                                $videoPath = $uploadDirVideo . $videoFileName;
                                $videoFileType = strtolower(pathinfo($videoPath, PATHINFO_EXTENSION));

                                // Проверяем расширение видео
                                if ($videoFileType != "mp4") {
                                    echo "Разрешены только файлы с расширением mp4.";
                                    exit;
                                }

                                if (move_uploaded_file($_FILES['video_tema']['tmp_name'], $videoPath)) {
                                    // Видео успешно загружено
                                } else {
                                    echo "Ошибка при загрузке видео.";
                                    exit;
                                }
                            }

                            // Проверяем, было ли загружено фото
                            if (isset($_FILES['photo_tema']) && $_FILES['photo_tema']['error'] === UPLOAD_ERR_OK) {
                                $uploadDirPhoto = "../content/image/"; // Путь к папке, где хранятся фотографии
                                $photoFileName = basename($_FILES['photo_tema']['name']);
                                $photoPath = $uploadDirPhoto . $photoFileName;
                                $photoFileType = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));

                                // Проверяем расширение фото
                                if ($photoFileType != "jpg" && $photoFileType != "jpeg" && $photoFileType != "png") {
                                    echo "Разрешены только файлы с расширениями jpg, jpeg и png.";
                                    exit;
                                }

                                if (move_uploaded_file($_FILES['photo_tema']['tmp_name'], $photoPath)) {
                                    // Фото успешно загружено
                                } else {
                                    echo "Ошибка при загрузке фото.";
                                    exit;
                                }
                            }

                            // Проверяем существование записи с таким же названием
                            $sql_check = "SELECT * FROM Lectures WHERE name = '$razdel' AND topic_id = '$topic_id'";
                            $result_check = $link->query($sql_check);

                            if ($result_check->num_rows > 0) {
                                echo "Запись с таким названием уже существует.";
                                exit;
                            }

                            // Подготавливаем SQL-запрос для вставки данных в таблицу Lectures
                            $sql_insert = "INSERT INTO Lectures (name, description, video_link, photo_file, creation_date, topic_id)
    VALUES ('$razdel', '$text', '$videoPath', '$photoPath', NOW(), '$topic_id')";

                            // Выполняем запрос
                            if ($link->query($sql_insert) === TRUE) {
                                echo "Новая запись успешно добавлена в базу данных.";
                            } else {
                                echo "Ошибка: " . $sql_insert . "<br>" . $link->error;
                            }

                            // Закрываем соединение с базой данных
                            
                        }
                        ?>
                    <?php endif; ?>



                    <br><br><br><br>
                    <?php
                    // Проверяем, был ли передан topic_id через GET параметры
                    if (isset($_GET['topic_id'])) {
                        // Получаем topic_id из GET параметров
                        $topic_id = $_GET['topic_id'];

                        // Подключаемся к базе данных (предполагая, что это еще не было сделано)
                        $link = new mysqli("localhost", "root", "123", "curs2");

                        // Проверяем подключение
                        if ($link->connect_error) {
                            die("Ошибка подключения: " . $link->connect_error);
                        }

                        // Подготавливаем SQL запрос для получения лекций по заданному topic_id
                        $sql_lectures2 = "SELECT * FROM Lecture_Topics WHERE id = $topic_id";

                        // Выполняем запрос
                        $result_lectures2 = $link->query($sql_lectures2);

                        // Проверяем, есть ли результат выборки
                        if ($result_lectures2->num_rows > 0) {
                            // Выводим фотографии
                            while ($row = $result_lectures2->fetch_assoc()) {
                                // Выводим данные о лекции
                                echo "<h1>Тема: " . $row['name'] . "</h1>";
                                // Другие данные о лекции можно выводить аналогичным образом
                            }
                        } else {
                            echo "Для этой темы лекций не найдено.";
                        }

                        // Закрываем соединение с базой данных
                        
                    } else {
                        echo "Тема не была выбрана.";
                    }
                    ?>
                    <?php
// Проверяем, была ли передана информация о пользователе с ролью администратора

    // Проверяем, была ли передан topic_id через GET параметры
    if (isset($_GET['topic_id'])) {
        // Получаем topic_id из GET параметров
        $topic_id = $_GET['topic_id'];

        // Подключаемся к базе данных (предполагая, что это еще не было сделано)
        $link = new mysqli("localhost", "root", "123", "curs2");

        // Проверяем подключение
        if ($link->connect_error) {
            die("Ошибка подключения: " . $link->connect_error);
        }

        // Подготавливаем SQL запрос для получения лекций по заданному topic_id
        $sql_lectures = "SELECT * FROM Lectures WHERE topic_id = $topic_id";

        // Выполняем запрос
        $result_lectures = $link->query($sql_lectures);

        // Проверяем, есть ли результат выборки
        if ($result_lectures->num_rows > 0) {
            // Выводим фотографии
            while ($row = $result_lectures->fetch_assoc()) {
                // Выводим данные о лекции
                echo "<h2>" . $row['name'] . "</h2>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<video controls src=" . $row['video_link'] . ">
                </video> <br/><br/>";
                echo "<img src=" . $row['photo_file'] . " alt=''>";

                // Проверяем роль пользователя для скрытия или отображения кнопок изменения и удаления
                if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1) {
                    // Добавляем ссылку для изменения данных
                    echo "<a href='../admin/edit_lecture.php?topic_id=" . $row['id'] . "'>Изменить</a>";
                    // Добавляем ссылку для удаления данных
                    echo "<a href='../admin/delete_lecture.php?topic_id=" . $row['id'] . "'>Удалить</a>";
                }

                // Другие данные о лекции можно выводить аналогичным образом
            }
        } else {
            echo "Для этой темы лекций не найдено.";
        }

        // Закрываем соединение с базой данных
        
    } else {
        echo "Тема не была выбрана.";
    }
?>
                </div>





            </main>
        </div>
    </div>
</body>

</html>