<?php
include('../../connect.php');
session_start();
if(isset($_SESSION['user'])) {
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация/регистрация</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
        .reg {
            width: 600px;
            background-color: #c6c6c6;
            padding: 30px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;
            height: 500px;
        }

        .reg input {
            margin-top: 5px;
            width: 400px;
        }

        .log {
            display: flex;
            justify-content: center;
            margin-top: 200px;
        }

        .error_dannie {
            color: red;
            font-size: 20px;
        }

        .plus_dannie {
            color: green;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main>
        <div class="container log">
            <div class="reg">
                <h1 class="mb-3">Регистрация</h1>
                <form method="post">
                    <input class="form-control" type="text" name="name_user" placeholder="Имя" required> <br>
                    <input class="form-control" type="email" name="email" id="email" placeholder="почта" required> <br>
                    <input class="form-control" type="password" name="pass" id="pass" placeholder="Пароль" required> <br>
                    <input class="form-control" type="password" name="pass_rep" id="pass_rep" placeholder="Подтвердите Пароль" required> <br>
                    <input class="form-control btn btn-primary" type="submit" value="Зарегистрироваться" name="btn_reg"> <br>
                    <?php
                    if (isset($_POST['btn_reg'])) {
                        $name = $_POST['name_user'];
                        $email = $_POST['email'];
                        $pass = md5($_POST['pass']);
                        $pass_rep = md5($_POST['pass_rep']);
                        $role = 3;

                        // Проверка имени
                        if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $name)) {
                            echo 'Ошибка в имени! Допустимы только кириллические символы.';
                            return;
                        }

                        // Проверка почты
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo "Ошибка в почте! Пожалуйста, введите действительный адрес электронной почты.";
                            return;
                        }

                        // Проверка пароля
                        if (strlen($pass) < 10) {
                            echo "Ошибка в пароле! Минимальная длина пароля должна быть 10 символов.";
                            return;
                        }

                        // Проверка повторного ввода пароля
                        if ($pass !== $pass_rep) {
                            echo "Ошибка! Пароли не совпадают.";
                            return;
                        }

                        // Проверка наличия пользователя в базе данных
                        $result = mysqli_query($link, "SELECT * FROM Users WHERE email = '$email'");
                        $rows = mysqli_num_rows($result);
                        if ($rows == 1) {
                            echo '<p class="error_dannie mt-2">Такой пользователь уже существует.</p>';
                        } else {
                            // Регистрация нового пользователя
                            $query = mysqli_query($link, "INSERT INTO Users (username, lastname, otchestvo, date_rojdenia, gorod, email, password, id_role, photo_user) VALUES ('$name', '','','','', '$email', '$pass', '$role', '')");
                            if ($query) {
                                echo '<p class="plus_dannie mt-2">Вы успешно зарегистрировались!</p>';
                            } else {
                                echo "Ошибка при выполнении запроса: " . mysqli_error($link);
                            }
                        }
                    }
                    ?>
                </form>

            </div>
        </div>
    </main>




    

</body>

</html>