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
    <title>Профиль админа</title>
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
        <main>
            <h1>Добро пожаловать в Админ Панель!</h1>
            <div class="container">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Новости</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Фотогалерея</button>
                    </li>
                    <a href="../admin/search.php" class="nav-link" id="pills-user-tab">Все пользователи</a>


                </ul>


                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <h2>Добавьте новость</h2>
                        <form class="news_add_adm" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Тема</label>
                                <input type="text" class="form-control mt-1" name="title" id="title" placeholder="Тема новости">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Описание</label> <br>
                                <textarea name="content" id="content" cols="30" rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Введите автора</label>
                                <input type="text" class="form-control mt-1" name="author" id="author" placeholder="Источник новости">
                            </div>
                            <div class="mb-3">
                                <label for="file_photo" class="form-label">Сменить фото</label> <br>
                                <input class="form-control mt-1" type="file" name="file_photo" id="file_photo">
                            </div>

                            <input name="btn_news" type="submit" class="btn btn-primary mt-2" value="Добавить новость">
                        </form>
                        <div id="photoPreview" style="display: none;">
                            <img id="previewImage" src="" alt="Preview">
                        </div>
                        <?php
                        if (isset($_POST['btn_news'])) {
                            // Подключение к базе данных (замените значения на свои)
                            $mysqli = new mysqli("localhost", "root", "123", "curs2");

                            // Проверка подключения
                            if ($mysqli->connect_error) {
                                die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
                            }

                            // Получение данных из формы
                            $title = $_POST["title"];
                            $content = $_POST["content"];
                            $author = $_POST["author"];

                            // Проверка и загрузка фотографии
                            if (isset($_FILES['file_photo']) && $_FILES['file_photo']['error'] === UPLOAD_ERR_OK) {
                                $uploadDir = "../content/image/"; // Замените на путь к папке, где хранятся фотографии
                                $allowedExtensions = array('jpg', 'jpeg', 'png');
                                $tempFile = $_FILES['file_photo']['tmp_name'];
                                $targetFile = $uploadDir . basename($_FILES['file_photo']['name']);
                                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                                if (in_array($imageFileType, $allowedExtensions)) {
                                    if (move_uploaded_file($tempFile, $targetFile)) {
                                        // Файл успешно загружен, сохраните путь к файлу
                                        $photoPath = $targetFile;
                                    } else {
                                        echo "Ошибка при загрузке файла.";
                                    }
                                } else {
                                    echo "Разрешены только файлы с расширениями jpg, jpeg и png.";
                                }
                            }

                            // Установка текущей даты и времени
                            $creation_date = date("Y-m-d H:i");

                            // SQL-запрос для вставки данных в таблицу 'News' с изображением
                            $sql = "INSERT INTO News (title, content, author, creation_date, status, photo_news) VALUES (?, ?, ?, ?, 'active', ?)";

                            // Подготовка запроса
                            $stmt = $mysqli->prepare($sql);

                            // Проверка на успешную подготовку
                            if ($stmt === false) {
                                echo "Ошибка при подготовке запроса (" . $mysqli->error . ") " . $mysqli->error;
                            }

                            // Привязка параметров к запросу
                            $stmt->bind_param("sssss", $title, $content, $author, $creation_date, $photoPath);

                            // Выполнение запроса
                            if ($stmt->execute()) {
                                echo "Новость успешно добавлена.";
                            } else {
                                echo "Ошибка при добавлении новости: " . $stmt->error;
                            }

                            // Закрыть соединение с базой данных
                            $stmt->close();
                            $mysqli->close();
                            exit();
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                        <form method="post">
                            <label for="category">Название альбома</label> <br>
                            <input class="mt-2" type="text" name="album_name" required> <br>
                            <label for="category">Дата создания мероприятия для альбома</label> <br>
                            <input class="mt-2" type="date" name="album_date" required> <br>
                            <input class="btn btn-primary mt-2" type="submit" name="add_album" value="Создать альбом">
                        </form>
                        <?php
                        if (isset($_POST['add_album'])) {
                            $name_album = $_POST['album_name'];
                            $date_album = $_POST['album_date'];

                            // Создание папки для нового альбома
                            $album_folder = '../content/photogallery/' . $name_album;
                            if (!is_dir($album_folder)) {
                                mkdir($album_folder);
                            }

                            // Вставить запись об альбоме в базу данных
                            $sql_photo = mysqli_query($link, "INSERT INTO album (name, date) VALUES ('$name_album', '$date_album')");

                            if ($sql_photo) {
                                echo 'Альбом создан';
                            } else {
                                echo 'Ошибка в создании альбома';
                            }
                        }
                        ?>
                        <br><br>
                        <form action="upload_photogallery.php" method="post" enctype="multipart/form-data">
                            <label for="category">Выберите категорию:</label>
                            <select name="category" id="category">
                                <?php
                                $result3 = $link->query('SELECT id, name FROM album');

                                while ($row3 = mysqli_fetch_assoc($result3)) {
                                    echo '<option value="' . $row3['id'] . '">' . $row3['name'] . '</option>';
                                }
                                ?>
                            </select>

                            <label for="photo">Выберите фотографию:</label>
                            <input type="file" name="photo[]" multiple>

                            <input type="submit" value="Загрузить">
                        </form>


                    </div>
                    <!-- <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab" tabindex="0">
                

                </div> -->
                </div>
        </main>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file_photo');
            const photoPreview = document.getElementById('photoPreview');
            const previewImage = document.getElementById('previewImage');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        photoPreview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                } else {
                    photoPreview.style.display = 'none';
                    previewImage.src = '';
                }
            });
        });
    </script>



    </div>
</body>

</html>