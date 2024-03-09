<?php
include('../../connect.php');

session_start();

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    
    // Получаем информацию о выбранном альбоме
    $album_query = mysqli_query($link, "SELECT name FROM album WHERE id = $category");
    $album_info = mysqli_fetch_assoc($album_query);
    $album_name = $album_info['name'];

    // Проверяем, были ли выбраны файлы
    if (!empty($_FILES['photo']['name'][0])) {
        // Цикл для обработки каждого файла
        foreach ($_FILES['photo']['name'] as $key => $name) {
            $photoName = $_FILES['photo']['name'][$key];
            $photoTmpName = $_FILES['photo']['tmp_name'][$key];

            // Проверяем, был ли выбран файл
            if (!empty($photoName)) {
                // Перемещаем файл в нужную папку
                $destination = '../content/photogallery/' . $album_name . '/' . $photoName;
                move_uploaded_file($photoTmpName, $destination);

                // Вставляем информацию о фотографии в базу данных
                $stmt = $link->prepare("INSERT INTO photos (album_id, file_name) VALUES (?, ?)");
                $stmt->bind_param("ss", $category, $photoName);
                $stmt->execute();
            }
        }
        echo "Фотографии успешно загружены в альбом '$album_name'.";
    } else {
        echo "Файлы не были выбраны для загрузки.";
    }
} else {
    echo "Категория не была выбрана.";
}

// После завершения цикла перенаправляем пользователя обратно на страницу администратора
header('Location: ./admin.php');
exit;

?>