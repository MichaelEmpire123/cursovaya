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

    </style>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main>
        <div class="container log">
            <div class="reg">
                <h1 class="mb-3">Авторизация</h1>
                <form method="post">
                    <input type="text" class="form-control" name="email" id="email" placeholder="почта" required> <br>
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Пароль" required> <br>
                    <input class="btn btn-primary" type="submit" class="form-control" value="Войти" name="btn_log">
                    <?php
                    if (isset($_POST['btn_log'])) {
                        $email = $_POST['email'];
                        $pass = md5($_POST['pass']);

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

                        // Проверка наличия пользователя в базе данных
                        $result = mysqli_query($link, "SELECT * FROM Users WHERE email = '$email' AND password = '$pass'");
                        $rows = mysqli_num_rows($result);
                        if ($rows == 1) {
                            session_start();
                            $_SESSION['user'] = $user = mysqli_fetch_assoc($result);
                           

                            if ($user['id_role'] == 1) {
                                echo '<script>window.location="../admin/admin.php";</script>';
                            } elseif ($user['id_role'] == 3) {
                                header('Location: ../user/profile.php');
                            } elseif ($user['id_role'] == 2) {
                                header('Location: ../admin/moder.php');
                            } else {
                                echo '<p class="error_dannie mt-2">Неверна введена почта или пароль!</p>';
                            }
                        } else {
                            echo '<p class="error_dannie mt-2">Неверна введена почта или пароль!</p>';
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </main>








    <style>
        .reg {
            max-width: 600px;
            background-color: #c6c6c6;
            padding: 30px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 30px;
            height: 400px;
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
    </style>
</body>

</html>