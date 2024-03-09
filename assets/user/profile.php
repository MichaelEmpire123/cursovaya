<?php
include('../../connect.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../logout.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
        input {
            color: #000;
        }

        .profile {
            display: flex;
            gap: 30px;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1px solid gray;
            flex-wrap: wrap;
            background: #c9c9c9;
            margin-top: 40px;
        }

        .img {
            width: 300px;
            height: 300px;
            border: 1px solid;
        }

        .img img {
            width: 300px;
            height: 300px;
        }

        .profile_dannie p {
            font-size: 20px;
            font-weight: 500;
        }

        h1 {
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main>
        <h1>Добро пожаловать в профиль пользователя!</h1>
        <div class="profile">

            <?php
            if (isset($_SESSION['user'])) {
                // Подключение к базе данных (замените значения на свои)
                $mysqli = new mysqli("localhost", "root", "123", "curs2");

                // Проверка подключения
                if ($mysqli->connect_error) {
                    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
                }

                // Получите данные из базы данных для текущего пользователя
                $userId = $_SESSION['user']['id'];

                $sql = "SELECT * FROM Users WHERE id = $userId";
                $result = $mysqli->query($sql);

                if ($result) {
                    $userData = $result->fetch_assoc();
                    if ($userData) {
                        $name = $userData['username'];
                        $lastname = $userData['lastname'];
                        $otchestvo = $userData['otchestvo'];
                        $date_rojdenia = $userData['date_rojdenia'];
                        $gorod = $userData['gorod'];
                        $photo_user = $userData['photo_user'];
                        // Отображение данных в HTML
                        echo "<div class='img'>
                                <img src='./image/$photo_user' alt=''>
                            </div>";
                        echo '<div class="profile_dannie">';
                        echo "<p>Имя: $name</p>";
                        echo "<p>Фамилия: $lastname</p>";
                        echo "<p>Отчество: $otchestvo</p>";
                        echo "<p>Дата рождения: $date_rojdenia</p>";
                        echo "<p>Город проживания: $gorod</p>";
                        echo '</div>';
                    } else {
                        echo "Данные пользователя не найдены.";
                    }
                } else {
                    echo "Ошибка выполнения запроса: " . $mysqli->error;
                }

                // Закройте соединение с базой данных
                $mysqli->close();
            } else {
                echo "Пользователь не аутентифицирован.";
            }
            ?>


        </div>

        <div class="container mb-5">
            <p class="d-inline-flex gap-1">
                <a class="btn btn-primary mt-5 settings_btn_profile" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Настройки пользователя
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file_photo" class="form-label">Сменить фото</label> <br>
                        <input class="form-control mt-1" type="file" name="file_photo" id="file_photo" value="<?php echo $photo_user; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Сменить Имя</label>
                        <input type="text" class="form-control mt-1" name="name" id="name" placeholder="Ваше имя" value="<?php echo $name; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Сменить Фамилию</label>
                        <input type="text" class="form-control mt-1" name="lastname" id="lastname" placeholder="Ваша фамилия" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="otchestvo" class="form-label">Сменить Отчество</label>
                        <input type="text" class="form-control mt-1" name="otchestvo" id="otchestvo" placeholder="Ваше отчество(необязательно)" value="<?php echo $otchestvo; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Сменить Дату рождения</label>
                        <input type="date" class="form-control mt-1" name="date" id="date" value="<?php echo $date_rojdenia; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="gorod" class="form-label">Сменить Город</label>
                        <input type="text" class="form-control mt-1" name="gorod" id="gorod" placeholder="Город проживания" value="<?php echo $gorod; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Сменить почту</label>
                        <input type="email" class="form-control mt-1" name="email" id="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="pass_new" class="form-label">Новый пароль</label>
                        <input type="password" class="form-control mt-1" name="pass_new" id="pass_new" placeholder="Пароль должен быть не менее 10 символов">
                    </div>
                    <div class="mb-3">
                        <label for="pass_new_repeat" class="form-label">Повторите Новый пароль</label>
                        <input type="password" class="form-control mt-1" name="pass_new_repeat" id="pass_new_repeat" placeholder="Повторите новый пароль">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Для смены или добавления данных "Введите текущий пароль пользователя"</label>
                        <input type="password" class="form-control mt-1" name="pass" id="pass" placeholder="Введите текущий пароль пользователя">
                    </div>
                    <input class="btn btn-primary mt-1" type="submit" value="Изменить">
                </form>
            </div>

        </div>


        <div class="container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Подключение к базе данных (замените значения на свои)
                $mysqli = new mysqli("localhost", "root", "123", "curs2");

                // Проверка подключения
                if ($mysqli->connect_error) {
                    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
                }

                // Получите данные из формы
                $name = $_POST["name"];
                $lastname = $_POST["lastname"];
                $otchestvo = $_POST["otchestvo"];
                $date = $_POST['date'];
                $email = $_POST["email"];
                $gorod = $_POST["gorod"];
                $pass_new = md5($_POST["pass_new"]);
                $pass = md5($_POST["pass"]); // Текущий пароль пользователя

                // Проверка текущего пароля пользователя (сравнение с данными в сессии)
                $userPassword = $_SESSION['user']['password']; // Замените на свой способ получения пароля из сессии
                if ($pass !== $userPassword) {
                    echo "Текущий пароль неверен.";
                    exit;
                }

                $sqlCheckEmail = "SELECT id FROM Users WHERE email = '$email' AND id != " . $_SESSION['user']['id'] . " LIMIT 1";
                $resultCheckEmail = $mysqli->query($sqlCheckEmail);

                // Загрузка файла
                if (isset($_FILES['file_photo']) && $_FILES['file_photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = "./image/"; // Замените на путь к папке, где хранить фотографии
                    $uploadFile = $uploadDir . basename($_FILES['file_photo']['name']);

                    // Получите расширение файла
                    $fileExtension = pathinfo($_FILES['file_photo']['name'], PATHINFO_EXTENSION);

                    // Разрешенные форматы файлов
                    $allowedExtensions = ['jpg', 'jpeg', 'png'];

                    // Проверка расширения файла
                    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                        // Перемещение файла из временной директории в заданную
                        if (move_uploaded_file($_FILES['file_photo']['tmp_name'], $uploadFile)) {
                            echo "Фотография успешно загружена.";

                            // Добавление имени файла в базу данных (в поле 'photo_user')
                            $photoFileName = basename($uploadFile);
                            $sql = "UPDATE Users SET photo_user = '$photoFileName' WHERE id = " . $_SESSION['user']['id'];

                            // Выполните SQL-запрос к базе данных
                            if ($mysqli->query($sql) === TRUE) {
                                echo "Данные успешно обновлены.";
                            } else {
                                echo "Ошибка при обновлении данных: " . $mysqli->error;
                            }
                        } else {
                            echo "Ошибка при загрузке файла.";
                        }
                    } else {
                        echo "Недопустимый формат файла. Разрешены только JPG и PNG.";
                    }
                }

                // Пример SQL-запроса для обновления данных (без валидации)
                if ($resultCheckEmail && $resultCheckEmail->num_rows > 0) {
                    echo "Такая почта уже существует. Пожалуйста, укажите другую почту.";
                } else {
                    $updateFields = array();

                    if (!empty($name)) {
                        $updateFields[] = "username = '$name'";
                    }

                    if (!empty($lastname)) {
                        $updateFields[] = "lastname = '$lastname'";
                    }

                    if (!empty($otchestvo)) {
                        $updateFields[] = "otchestvo = '$otchestvo'";
                    }

                    if (!empty($gorod)) {
                        $updateFields[] = "gorod = '$gorod'";
                    }

                    if (!empty($date)) {
                        $updateFields[] = "date_rojdenia = '$date'";
                    }

                    if (!empty($email)) {
                        $updateFields[] = "email = '$email'";
                    }

                    if (!empty($pass_new)) {
                        $updateFields[] = "password = '$pass_new'";
                    }

                    if (!empty($updateFields)) {
                        $sql = "UPDATE Users SET " . implode(", ", $updateFields) . " WHERE id = " . $_SESSION['user']['id'];

                        // Выполните SQL-запрос к базе данных для обновления данных пользователя
                        if ($mysqli->query($sql) === TRUE) {
                            echo "Данные успешно обновлены.";
                        } else {
                            echo "Ошибка при обновлении данных: " . $mysqli->error;
                        }
                    } else {
                        echo "";
                    }
                }

                // Закройте соединение с базой данных
                $mysqli->close();
            }

            ?>
        </div>
    </main>







    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#editForm").on("submit", function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "", // Пустая строка означает текущую страницу
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Обработка ответа после обновления данных
                        alert(response);
                    }
                });
            });
        });
    </script>





</body>

</html>