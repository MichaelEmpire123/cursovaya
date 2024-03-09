<?php
include('../../connect.php');
session_start();

// if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
//     header('Location: ../user/profile.php');
//     exit;
// }


// Проверка, передан ли параметр album_id
if (!isset($_GET['album_id']) || empty($_GET['album_id'])) {
    echo json_encode(array('error' => 'Неверный идентификатор альбома'));
    exit();
}

// Получение идентификатора альбома из GET-параметра
$album_id = $_GET['album_id'];

// Получение фотографий выбранного альбома
$sql_photos = "SELECT file_name FROM photos WHERE album_id = $album_id";
$result_photos = $mysqli->query($sql_photos);

// Формирование списка фотографий
$photos = array();
while ($row_photo = $result_photos->fetch_assoc()) {
    $photos[] = $row_photo['file_name'];
}

// Возвращение списка фотографий в формате JSON
echo json_encode($photos);

// Закройте соединение с базой данных
$mysqli->close();
?>
