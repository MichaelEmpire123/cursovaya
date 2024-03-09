<?php
// Подключение к базе данных (замените значения на свои)
$mysqli = new mysqli("localhost", "root", "123", "curs");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

// Извлечение списка запрещенных слов из таблицы в базе данных
$censoredWords = array();
$result = $mysqli->query("SELECT word FROM censored_words");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $censoredWords[] = $row['word'];
    }
    $result->close();
}

// Функция для цензурирования текста
function censorText($text, $censoredWords) {
    return str_replace($censoredWords, "****", $text);
}

// Загрузка текущей HTML-страницы
$htmlContent = file_get_contents('current_page.html');

// Применение цензуры к HTML-контенту
$censoredHtmlContent = censorText($htmlContent, $censoredWords);

// Вывод цензурированной HTML-страницы
echo $censoredHtmlContent;

// Закрыть соединение с базой данных
$mysqli->close();
?>
