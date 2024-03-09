<?php
include('../../connect.php');
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../style_media.css">
    <style>
        * {
            box-sizing: border-box;
        }

        .card_news .newsContent {
            word-break: break-all;
        }

        .cont_news {
            display: flex;
            gap: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 600px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Стили для размытия заднего фона */
        .blur-background {
            display: none;
            position: fixed;
            z-index: 0;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px);
        }

        p {
            font-size: 20px;
        }

        .date_auth p {
            font-size: 16px;
        }

        .user_news {
            background: #dedede;
            padding: 10px;
        }

        .user_news {
            display: none;
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
                    <button class="aside_btn btn btn-primary" onclick="aside_btn()">
                        +
                    </button>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <button id="news_user" class="btn btn-primary w-100" onclick="news_user_btn()">Предложить свою новость</button>
                        <div class="user_news mt-2">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Предложить новость</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Ваши предложенные новости</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <h2>Предложить новость</h2>
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
                                            <label for="file_photo" class="form-label">Сменить фото</label> <br>
                                            <input class="form-control mt-1" type="file" name="file_photo" id="file_photo">
                                        </div>

                                        <input name="btn_news_user" type="submit" class="btn btn-primary mt-2" value="Добавить новость">
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                    <?php
                                    // Подключение к базе данных (замените значения на свои)
                                    $mysqli = new mysqli("localhost", "root", "123", "curs2");

                                    // Проверка подключения
                                    if ($mysqli->connect_error) {
                                        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
                                    }
                                    // SQL-запрос для выборки данных из таблицы 'News'
                                    $sql = "SELECT * FROM news_user WHERE status = '$status' AND status='отклонено' AND author='$author'"; // Замените на ваше условие выборки

                                    // Выполнение SQL-запроса
                                    $result = $mysqli->query($sql);

                                    // Проверка наличия данных
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $title = $row["title"];
                                            $content = $row["content"];
                                            $author = $_SESSION['user']['id']; // ФИО пользователя из текущей сессии
                                            $creation_date = $row["creation_date"];
                                            $photoPath = $row["photo_news"];

                                            // Вывод данных
                                            echo '<div class="card_news">';
                                            echo '<h3 id="newsTitle' . $row["id"] . '">' . $title . '</h3>';
                                            echo '<p class="newsContent" id="newsContent' . $row["id"] . '">' . $content . '</p>';
                                            echo '<img src="' . $photoPath . '" alt="">';
                                            echo '<span class="date_auth mt-2">';
                                            echo 'Дата: ' . $creation_date . '</p>';
                                            echo '<p>Автор: ' . $author . '</p>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '<br>';

                                            // Добавление возможности удаления и редактирования для пользователей с ролью 1

                                            if (!isset($_SESSION['user'])) {
                                                echo '';
                                            } else {
                                                echo '<button class="btn btn-primary mb-3 edit-news" data-id="' . $row["id"] . '">Редактировать</button>';
                                                echo ' ';
                                                echo '<button class="btn btn-danger mb-3 delete-news" data-id="' . $row["id"] . '">Удалить</button>';
                                            }
                                        }
                                    } else {
                                        echo "Нет активных новостей.";
                                    }

                                    // Закрыть соединение с базой данных
                                    $mysqli->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <script>
                            function news_user_btn() {
                                var user_news_block = document.querySelector(".user_news");
                                if (user_news_block.style.display === "none") {
                                    user_news_block.style.display = "block";
                                } else {
                                    user_news_block.style.display = "none";
                                }
                            }
                        </script>
                    <?php endif; ?>


                    <?php
                    if (isset($_POST['btn_news_user'])) {
                        // Получаем данные из формы
                        $title = $_POST['title'];
                        $content = $_POST['content'];
                        $author = $_SESSION['user']['id']; // ФИО пользователя из текущей сессии

                        // Проверяем, было ли загружено фото
                        $photo_path = "";
                        if ($_FILES['file_photo']['error'] === UPLOAD_ERR_OK) {
                            // Обработка загруженного фото
                            $upload_directory = "../content/image/"; // Папка для сохранения загруженных фото
                            $photo_name = $_FILES['file_photo']['name'];
                            $photo_tmp = $_FILES['file_photo']['tmp_name'];
                            $photo_path = $upload_directory . $photo_name; // Путь к сохранению фото на сервере
                            move_uploaded_file($photo_tmp, $photo_path);
                        }

                        // Установка статуса по умолчанию - на проверке
                        $status = 'на проверке';

                        // Получаем текущую дату и время
                        $creation_date = date('Y-m-d H:i:s');

                        // Подготавливаем запрос на добавление данных в таблицу news_user
                        $stmt = $link->prepare("INSERT INTO news_user (title, content, author, creation_date, photo_news, status) VALUES (?, ?, ?, ?, ?, ?)");

                        // Проверяем успешность подготовки запроса
                        if ($stmt) {
                            // Привязываем параметры к запросу
                            $stmt->bind_param("ssssss", $title, $content, $author, $creation_date, $photo_path, $status);

                            // Выполняем запрос
                            if ($stmt->execute()) {
                                echo "Новость успешно добавлена. Ожидайте проверки администратором.";
                            } else {
                                echo "Ошибка при добавлении новости: " . $stmt->error;
                            }

                            // Закрываем запрос
                            $stmt->close();
                        } else {
                            echo "Ошибка при подготовке запроса: " . $link->error;
                        }
                    }

                    // Закрываем подключение к базе данных
                    $link->close();
                    ?>


                    <h1>Новости</h1>
                    <div class="news mt-5">
                        <?php
                        // Подключение к базе данных (замените значения на свои)
                        $mysqli = new mysqli("localhost", "root", "123", "curs2");

                        // Проверка подключения
                        if ($mysqli->connect_error) {
                            die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
                        }

                        // Проверка роли текущего пользователя
                        $userRole = 1; // Замените на способ получения роли текущего пользователя

                        // SQL-запрос для выборки данных из таблицы 'News'
                        $sql = "SELECT * FROM News WHERE status = 'active'"; // Замените на ваше условие выборки

                        // Выполнение SQL-запроса
                        $result = $mysqli->query($sql);

                        // Проверка наличия данных
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $title = $row["title"];
                                $content = $row["content"];
                                $author = $row["author"];
                                $creation_date = $row["creation_date"];
                                $photoPath = $row["photo_news"];

                                // Вывод данных
                                echo '<div class="card_news">';
                                echo '<h3 id="newsTitle' . $row["id"] . '">' . $title . '</h3>';
                                echo '<div class="cont_news">
                                <img src="' . $photoPath . '" alt="">
                                <p class="newsContent" id="newsContent' . $row["id"] . '">' . $content . '</p>
                                </div>';
                                echo '<span class="date_auth mt-2">';
                                echo 'Дата: ' . $creation_date . '</p>';
                                echo '<p>Автор: ' . $author . '</p>';
                                echo '</span>';
                                echo '</div>';
                                echo '<br>';

                                // Добавление возможности удаления и редактирования для пользователей с ролью 1

                                if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
                                    echo '';
                                } else {
                                    echo '<button class="btn btn-primary mb-3 edit-news" data-id="' . $row["id"] . '">Редактировать</button>';
                                    echo ' ';
                                    echo '<button class="btn btn-danger mb-3 delete-news" data-id="' . $row["id"] . '">Удалить</button>';
                                }
                            }
                        } else {
                            echo "Нет активных новостей.";
                        }

                        // Закрыть соединение с базой данных
                        $mysqli->close();
                        ?>
                        <?php
                        if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
                        } else {
                            echo '<div class="container">
                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModalBtn">&times;</span>
                            <h2>Редактировать новость</h2>
                            <form id="editForm" method="post">
                                <input type="hidden" id="editId" name="id">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Заголовок</label>
                                    <input type="text" class="form-control mt-1" name="title" id="editTitle" placeholder="Введите заголовок новости">
                                </div>
                                <div class="mb-3">
                                    <label for="editContent" class="form-label">Описание новости</label>
                                    <textarea class="form-control mt-1" name="content" id="editContent" cols="20" rows="5"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editAuthor" class="form-label">Автор новости</label>
                                    <input type="text" class="form-control mt-1" name="author" id="editAuthor" placeholder="Введите автора новости">
                                </div>
                                <button type="submit" name="izmen_news_btn" class="btn btn-primary mt-2">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="blurBackground" class="blur-background"></div>
                ';
                            echo '
                <script>
                var editButtons = document.querySelectorAll(".edit-news");
                var modal = document.getElementById("editModal");
                var closeModalBtn = document.getElementById("closeModalBtn");
                var editForm = document.getElementById("editForm");

                editButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        var newsId = button.getAttribute("data-id");

                        // Загрузка данных новости через AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "../admin/get_news_data.php?id=" + newsId, true);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                var data = JSON.parse(xhr.responseText);
                                document.getElementById("editId").value = data.id;
                                document.getElementById("editTitle").value = data.title;
                                document.getElementById("editContent").value = data.content;
                                document.getElementById("editAuthor").value = data.author;
                                
                                modal.style.display = "block";
                            }
                        };

                        xhr.send();
                    });
                });

                // Закрытие модального окна
                closeModalBtn.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                // Отправка данных на сервер при нажатии на кнопку "Сохранить"
                editForm.addEventListener("submit", function(e) {
                    e.preventDefault();
                
                    var formData = new FormData(editForm);
                
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../admin/edit_news.php", true);
                
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Обработка успешного ответа от сервера
                            modal.style.display = "none";
                            
                            // Обновление данных новости на текущей странице
                            var updatedTitle = document.getElementById("editTitle").value;
                            var updatedContent = document.getElementById("editContent").value;
                            var updatedAuthor = document.getElementById("editAuthor").value;
                            var newsId = document.getElementById("editId").value;
                            
                            // Найдите соответствующие элементы на странице и обновите их данными
                            var newsTitleElement = document.getElementById("newsTitle" + newsId);
                            var newsContentElement = document.getElementById("newsContent" + newsId);
                            var newsAuthorElement = document.getElementById("newsAuthor" + newsId);
                            
                            newsTitleElement.textContent = updatedTitle;
                            newsContentElement.textContent = updatedContent;
                            newsAuthorElement.textContent = updatedAuthor;
                        }
                    };
                
                    xhr.send(formData);
                });
            </script>
                ';

                            echo '<div id="deleteNewsModal" class="modal">
                <div class="modal-content">
                    <h2>Подтвердите удаление новости</h2>
                    <p>Вы уверены, что хотите удалить эту новость?</p>
                    <button class="btn btn-danger" id="confirmDeleteBtn">Удалить</button>
                    <button class="btn btn-primary mt-2" id="cancelDeleteBtn">Отмена</button>
                </div>
            </div>';
                            echo "<script>
                // Получаем ссылки на кнопки 'Удалить' и модальное окно
                const deleteButtons = document.querySelectorAll('.delete-news');
                const deleteModal = document.getElementById('deleteNewsModal');

                // Для каждой кнопки 'Удалить' добавляем обработчик события клика
                deleteButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        // Показываем модальное окно
                        deleteModal.style.display = 'block';

                        // Получаем ID новости из атрибута data-id кнопки 'Удалить'
                        const newsId = button.getAttribute('data-id');

                        // Обработчик события клика на кнопке подтверждения удаления
                        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
                            // Перенаправляем пользователя на страницу удаления новости с ID новости в качестве параметра
                            window.location.href = '../admin/delete_news.php?id=' + newsId;
                        });

                        // Обработчик события клика на кнопке отмены
                        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
                            // Скрываем модальное окно при отмене
                            deleteModal.style.display = 'none';
                        });
                    });
                });
            </script>";
                        }
                        ?>

                    </div>
                </div>
            </main>
        </div>
    </div>




</body>

</html>