<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../style.css">
</head>

<body>

  <aside class="aside">
    <nav>
      <ul class="navbar-nav">
        <li>
          <button class="aside_btn btn btn-primary" onclick="aside_btn()">
            -
          </button>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../../index.php">Главная</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../pages/news.php">Новости</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../pages/photogallery.php">Фотогалерея</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../pages/lectures.php">Лекции</a>
        </li>
        <?php
        include('../../connect.php');
        ?>
        <?php if (isset($_SESSION['user'])) : ?>
          <?php
          $userId = $_SESSION['user']['id'];
          $sql = "SELECT * FROM Users WHERE id = $userId";
          $result = $link->query($sql);
          ?>
          <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
              <li class="aside_user">
                <div class="profile_aside">
                  <a class="nav-link" href="../user/profile.php"><?php echo $row['username'];
                                                                  echo ' ';
                                                                  echo $row['lastname']; ?></a>
                  <div class="profile_aside_card">
                    <div class="img_profile_aside">
                      <img src="../user/image/<?php echo $row['photo_user']; ?>" alt="ava">
                      <a class="nav-link" href="../../logout.php">Выйти</a>
                    </div>
                  </div>
                </div>
              </li>
            <?php endwhile; ?>
          <?php endif; ?>
        <?php else : ?>
          <li class="aside_user">
            <div class="profile_aside">
              <a class="nav-link" href="../pages/log.php">Войти в аккаунт</a>
            </div>
          </li>
        <?php endif; ?>

      </ul>
    </nav>
  </aside>

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
</body>

</html>