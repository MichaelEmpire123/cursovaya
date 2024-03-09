<?php
include('../../connect.php');
session_start();

// Удаление альбома и его фотографий
if (isset($_POST['delete_album']) && isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];

    // Получаем название альбома
    $sql_get_album_name = "SELECT name FROM album WHERE id = $album_id";
    $result_get_album_name = $link->query($sql_get_album_name);
    $row_album_name = $result_get_album_name->fetch_assoc();
    $album_name = $row_album_name['name'];

    // Получаем список фотографий альбома
    $sql_get_photos = "SELECT file_name FROM photos WHERE album_id = $album_id";
    $result_get_photos = $link->query($sql_get_photos);

    // Удаляем фотографии из папки
    while ($row_photo = $result_get_photos->fetch_assoc()) {
        $file_path = '../content/photogallery/' . $album_name . '/' . $row_photo['file_name'];
        if (file_exists($file_path)) {
            unlink($file_path); // Удаление файла
        }
    }

    // Удаляем записи о фотографиях из базы данных
    $sql_delete_photos = "DELETE FROM photos WHERE album_id = $album_id";
    $link->query($sql_delete_photos);

    // Удаляем запись о альбоме из базы данных
    $sql_delete_album = "DELETE FROM album WHERE id = $album_id";
    $link->query($sql_delete_album);

    // Удаляем папку альбома из photogallery
    $album_folder = '../content/photogallery/' . $album_name;
    if (is_dir($album_folder)) {
        // Удаление папки
        rmdir($album_folder);
    }

    // После удаления перенаправляем пользователя на страницу с альбомами или другую страницу
    header("Location: photogallery.php");
    exit(); // Прекращаем выполнение скрипта
}

$sql_albums = "SELECT id, name FROM album";
$result_albums = $link->query($sql_albums);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Фотогалерея</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #photos {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* CSS для слайдера */
        #sliderModal .slider-content {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .block_slider-image {
            width: 60%;
            height: 70%;
        }

        #sliderModal .slider-image {
            width: 100%;
            height: 100%;
            border: 3px solid #f7f7f7;
        }

        #sliderModal .slider-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        #sliderModal .slider-controls button {
            background: none;
            border: none;
            font-size: 40px;
            cursor: pointer;
            padding: 15px;
            background-color: #fff;
        }

        #sliderModal {
            padding: 40px;
        }

        .closeSlider,
        #prevBtn,
        #nextBtn {
            padding: 15px;
            background-color: #fff;
            color: #000;
            cursor: pointer;
            font-size: 20px;
        }


        /* CSS для слайдера */
        @media screen and (max-width: 768px) {
            #sliderModal .slider-content {
                flex-direction: column;
                align-items: center;
            }

            .block_slider-image {
                width: 100%;
            }

            #sliderModal .slider-controls {
                position: static;
                margin-top: 20px;
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            #sliderModal .slider-controls button {
                font-size: 24px;
                padding: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            #sliderModal .slider-content {
                padding: 10px;
            }

            .block_slider-image {
                width: 100%;
            }

            #sliderModal .slider-controls button {
                font-size: 20px;
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <!-- Отображение фотографий -->
    <div class="cont_aside">
        <?php
        include('../templates/aside.php');
        ?>
        <main>
        <div class="container">
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Выберите альбом</h2>
                    <br><br>
                    <form method="post">
                        <div class="album-list">
                            <?php while ($row_album = $result_albums->fetch_assoc()) : ?>
                                <a class="link-album" href="photogallery.php?album_id=<?php echo $row_album['id']; ?>">
                                    <div class="link-album_block" mt-2><?php echo $row_album['name']; ?></div>
                                </a>
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1) : ?>
                                    <button type="submit" onclick="confirmDelete(<?php echo $row_album['id']; ?>)" class="btn btn-danger mt-2 mb-2" name="delete_album">Удалить альбом</button>
                                <?php endif; ?>
                                <br>
                            <?php endwhile; ?>
                        </div>
                    </form>
                    <script>
                        function confirmDelete(albumId) {
                            if (confirm('Вы уверены, что хотите удалить этот альбом и все его фотографии?')) {
                                // Создаем скрытое поле с идентификатором альбома
                                var hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'album_id';
                                hiddenInput.value = albumId;

                                // Добавляем скрытое поле к основной форме
                                document.querySelector('#modal form').appendChild(hiddenInput);

                                // Отправляем форму
                                document.querySelector('#modal form').submit();
                            }
                        }
                    </script>
                </div>
            </div>
            <h1>Фотогалерея</h1>
            <h3>Выберите альбом для просмотра</h3>
            <button class="my-5 btn btn-photogallery" id="openModalBtn">Открыть модальное окно</button>
            <div id="photos">
                <?php
                // Проверяем, был ли выбран альбом
                if (isset($_GET['album_id'])) {
                    $album_id = $_GET['album_id'];

                    // Получаем название альбома
                    $sql_album_name = "SELECT name FROM album WHERE id = $album_id";
                    $result_album_name = $link->query($sql_album_name);
                    $row_album_name = $result_album_name->fetch_assoc();
                    $album_name = $row_album_name['name'];

                    // Получаем информацию о фотографиях выбранного альбома
                    $sql_photos = "SELECT file_name FROM photos WHERE album_id = $album_id";
                    $result_photos = $link->query($sql_photos);

                    // Выводим фотографии
                    while ($row_photo = $result_photos->fetch_assoc()) {
                        $file_name = $row_photo['file_name'];
                        // Путь к фотографии
                        $photo_path = '../content/photogallery/' . $album_name . '/' . $file_name;
                ?>
                        <img class="img_photogallery" src="<?php echo $photo_path; ?>" alt="Фото">
                <?php
                    }
                } else {
                    echo "Альбом не был выбран.";
                }
                // Закрываем соединение с базой данных
                $link->close();
                ?>

            </div>

            <div id="sliderModal" class="modal">
                <span class="closeSlider"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                    </svg></span>
                <div class="slider-content">
                    <div class="block_slider-image">
                        <img class="slider-image" src="" alt="Фото">
                    </div>
                    <div class="slider-controls">
                        <button id="prevBtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg></button>
                        <button id="nextBtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
            </main>
    </div>

    </main>
    <!-- Выбор альбома -->




    <script>
        var modal = document.getElementById("modal");
        var openModalBtn = document.getElementById("openModalBtn");
        var closeBtn = document.getElementsByClassName("close")[0];

        // Открытие модального окна при клике на кнопку
        openModalBtn.onclick = function() {
            modal.style.display = "block";
        }

        // Закрытие модального окна при клике на кнопку "Закрыть" или за пределами окна
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }



        // JavaScript для обработки событий
        var sliderModal = document.getElementById("sliderModal");
        var closeSliderBtn = document.getElementsByClassName("closeSlider")[0];
        var sliderImage = document.getElementsByClassName("slider-image")[0];
        var prevBtn = document.getElementById("prevBtn");
        var nextBtn = document.getElementById("nextBtn");
        var photos = document.querySelectorAll(".img_photogallery");
        var currentPhotoIndex = 0;

        // Открытие слайдера при клике на фотографию
        photos.forEach(function(photo, index) {
            photo.addEventListener("click", function() {
                currentPhotoIndex = index;
                sliderImage.src = photo.src;
                sliderModal.style.display = "block";
            });
        });

        // Закрытие слайдера при клике на кнопку "Закрыть"
        closeSliderBtn.onclick = function() {
            sliderModal.style.display = "none";
        }

        // Пролистывание фотографий в слайдере
        prevBtn.onclick = function() {
            currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
            sliderImage.src = photos[currentPhotoIndex].src;
        }

        nextBtn.onclick = function() {
            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
            sliderImage.src = photos[currentPhotoIndex].src;
        }

        // Закрытие слайдера при клике за его пределами
        window.onclick = function(event) {
            if (event.target == sliderModal) {
                sliderModal.style.display = "none";
            }
        }
    </script>
</body>

</html>