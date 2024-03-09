<?php
include('connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
    <title>Главная страница</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .index_p {
            font-size: 25px;
        }

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

        header nav .nav-item .nav-link:hover,
        header nav .navbar-brand:hover {
            color: #ff3700;
        }

        .navbar-toggler {
            background-color: #fff;
        }

        .card_sponsor img {
            width: 400px;
            border: 2px solid;
        }

        .cards_sponsors {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="logo" href="#">Рос содружество реконструкторов</a>
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
                                <a class="nav-link" href="./assets/admin/admin.php">Админ панель</a>
                            </li>';
                        }
                        if (isset($_SESSION['user'])) {
                            echo '<li class="nav-item">
                                <a class="nav-link" href="./assets/user/profile.php">Личный кабинет</a>
                            </li>';
                            echo '<li class="nav-item">
                                <a class="nav-link" href="./logout.php">Выйти</a>
                            </li>';
                        } else {
                            echo '<li class="nav-item">
                                <a class="nav-link" href="./assets/pages/log.php">Авторизация</a>
                            </li>';
                            echo '<li class="nav-item">
                                <a class="nav-link" href="./assets/pages/reg.php">Регистрация</a>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="cont_aside">
            <aside class="aside">
                <nav>
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li>
                            <button class="aside_btn btn btn-primary" onclick="aside_btn()">
                                -
                            </button>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./assets/pages/news.php">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./assets/pages/photogallery.php">Фотогалерея</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./assets/pages/lectures.php">Лекции</a>
                        </li>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php
                            $userId = $_SESSION['user']['id'];
                            $sql = "SELECT * FROM Users WHERE id = $userId";
                            $result = $link->query($sql);
                            ?>
                            <?php if ($result && $result->num_rows > 0) : ?>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <li class="aside_user">
                                        <div class="profile_aside">
                                            <a class="nav-link" href="./assets/user/profile.php"><?php echo $row['username'];
                                                                                                    echo ' ';
                                                                                                    echo $row['lastname']; ?></a>
                                            <div class="profile_aside_card">
                                                <div class="img_profile_aside">
                                                    <img src="./assets/user/image/<?php echo $row['photo_user']; ?>" alt="ava">
                                                    <a class="nav-link" href="./logout.php">Выйти</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <li class="aside_user">
                                <div class="profile_aside">
                                    <a class="nav-link" href="./assets/pages/log.php">Войти в аккаунт</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </aside>
            <main>
                <button class="aside_btn btn btn-primary" onclick="aside_btn()">
                    +
                </button>
                <h1>Главная страница</h1>
                <p class="index_p">Наш сайт создан в целях образования военно-патриотического воспитания</p>
                <p class="index_p">
                    На нашем сайте: <br>
                    - Новости событий <br>
                    - Предстоящие события связанные с военно-патриотическим воспитанием <br>
                    - Лекции связанные с военно-патриотическим воспитанием <br>
                    - Фотогалерея с различных мероприятий
                </p>
                <h2>Наши спонсоры</h2>
                <div class="cards_sponsors">
                    <div class="card_sponsor">
                        <h4>УДДМ</h4>
                        <img src="./assets/content/image/5uddm.png" alt="">
                    </div>
                    <div class="card_sponsor">
                        <h4>РОСРЕКОН</h4>
                        <img src="./assets/content/image/rosrekon.png" alt="">
                    </div>
                    <div class="card_sponsor">
                        <h4>Мин мол</h4>
                        <img src="./assets/content/image/minmol.jpg" alt="">
                    </div>
                    <div class="card_sponsor">
                        <h4>Добрый Татарстан</h4>
                        <img src="./assets/content/image/dobrrt.jpg" alt="">
                    </div>
                </div>
                <h2>Наши контакты:</h2>
                <p class="index_p">Наша почта: rossodrejstvo@mail.ru</p>
                <p class="index_p">Телефон для связи: +7(917)937-26-99</p>
            </main>
        </div>
    </div>
    <script>
        function aside_btn() {
            let aside = document.querySelector('.aside');
            if (aside.style.display === 'none') {
                aside.style.display = 'block';
                aside.style.width = '320px';
            } else {
                aside.style.display = 'none';
                aside.style.width = '0px';
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>