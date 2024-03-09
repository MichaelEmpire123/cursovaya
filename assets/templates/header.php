<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
    <title>Document</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="logo" href="../../index.php">Рос содружество реконструкторов</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        
                    </ul>
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        
                    </ul>
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <?php
                            if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
                            } else {
                                echo '<li class="nav-item">
                                <a class="nav-link" href="../admin/admin.php">Админ панель</a>
                            </li>';
                            }
                            if (isset($_SESSION['user'])) {
                            echo '<li class="nav-item">
                                <a class="nav-link" href="../../logout.php">Выйти</a>
                            </li>';
                            } else {
                                echo '<li class="nav-item">
                                <a class="nav-link" href="../pages/log.php">Авторизация</a>
                            </li>';
                                echo '<li class="nav-item">
                                <a class="nav-link" href="../pages/reg.php">Регистрация</a>
                            </li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <style>
        header nav {
            background-color: #971e03;
        }
        header nav .nav-item .nav-link {
            color: #fff;
            transition: 0.4s;
            font-size: 20px;
        }
        header nav .navbar-brand {
            color: #fff;
            transition: 0.4s;
            font-size: 30px;
        }
        header nav .nav-item .nav-link:hover, header nav .navbar-brand:hover {
            color: #ff3700;
        }
        .navbar-toggler {
            background-color: #fff;
        }
    </style>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>