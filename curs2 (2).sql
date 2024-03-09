-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Мар 08 2024 г., 16:03
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `curs2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `album`
--

CREATE TABLE `album` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `album`
--

INSERT INTO `album` (`id`, `name`, `date`) VALUES
(22, 'Проверка', '2024-03-04');

-- --------------------------------------------------------

--
-- Структура таблицы `Events`
--

CREATE TABLE `Events` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Lectures`
--

CREATE TABLE `Lectures` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `video_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lecture_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `topic_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Lectures`
--

INSERT INTO `Lectures` (`id`, `name`, `description`, `video_link`, `lecture_file`, `creation_date`, `topic_id`) VALUES
(1, 'Введение', 'сссвысыфсыфысфсыф', '111', '111', '2024-03-04', 1),
(2, 'Введение', 'Сталинградская битва стала крупнейшим сражением в мировой истории. Она продолжалась более полугода, с 17 июля 1942 года по 2 февраля 1943 года. В ней приняло участие свыше 2 миллионов солдат. Красной армии пришлось воевать не только с немцами, но и с румынами, итальянцами, хорватами и венграми.', 'ыфсыфы', 'ысфсыфы', '2024-03-04', 2),
(4, '111', 'уцвуцвв', 'uploads/', 'uploads/', '2024-03-04', 2),
(5, 'sacsas', 'acscsacsacsa', 'uploads/', 'uploads/', '2024-03-04', 2),
(7, '111', 'qqqq', 'uploads/', 'uploads/', '2024-03-04', 1),
(9, '111', 'qqqq', 'uploads/', 'uploads/', '2024-03-04', 1),
(10, 't43t43t4', 't43t4t34', '../content/image/', '../content/image/', '2024-03-04', 2),
(11, 'www', 'www', '../content/image/', '../content/image/', '2024-03-04', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `Lecture_Topics`
--

CREATE TABLE `Lecture_Topics` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `visible` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Lecture_Topics`
--

INSERT INTO `Lecture_Topics` (`id`, `name`, `visible`) VALUES
(1, 'Афган', '0'),
(2, 'Операция Кольцо Сталинград', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `News`
--

CREATE TABLE `News` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `photo_news` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `News`
--

INSERT INTO `News` (`id`, `title`, `content`, `author`, `creation_date`, `photo_news`, `status`) VALUES
(21, 'Проверка работы', '                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod soluta accusamus at nam fugit repudiandae iste excepturi amet dicta aliquid dolor laborum reprehenderit voluptatum accusantium, ab reiciendis itaque facilis voluptatem. Ullam accusamus earum voluptatem ipsum quaerat, obcaecati recusandae minima deserunt aspernatur quas. Debitis quis libero vel possimus, quos eum blanditiis, praesentium quod ad tempore esse pariatur dolores explicabo sit maxime. Facere voluptatem ex odio impedit dolorem provident dolore nobis aliquid itaque nostrum nulla, adipisci hic, deleniti voluptas voluptatibus eligendi ducimus rem amet pariatur dolor? Perspiciatis cum ex culpa laborum vel officia doloribus mollitia, enim odio itaque, quo explicabo sapiente asperiores!\r\n', 'Апраксин М.С', '2024-02-12 19:36:00', '../content/image/фон.png', 'active'),
(22, 'Проверка работы', 'wwwwhgjh', 'www', '2024-03-05 21:18:00', '../content/image/IMG_20230212_105721.jpg', 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `news_user`
--

CREATE TABLE `news_user` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `author` int NOT NULL,
  `creation_date` date NOT NULL,
  `photo_news` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `news_user`
--

INSERT INTO `news_user` (`id`, `title`, `content`, `author`, `creation_date`, `photo_news`, `status`) VALUES
(8, '1111', '111', 5, '2024-03-04', '../content/image/IMG-20210524-WA0028.jpg', 'на проверке');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int NOT NULL,
  `album_id` int NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `album_id`, `file_name`) VALUES
(164, 22, 'IMG-20220731-WA0010.jpg'),
(165, 22, 'IMG-20220820-WA0056.jpg'),
(166, 22, 'IMG-20220821-WA0027.jpg'),
(167, 22, 'IMG-20220823-WA0008.jpg'),
(168, 22, 'IMG-20220906-WA0034.jpg'),
(169, 22, 'IMG-20220906-WA0039.jpg'),
(170, 22, 'IMG-20221017-WA0012.jpg'),
(171, 22, 'IMG-20230304-WA0029.jpg'),
(172, 22, 'IMG-20230305-WA0014.jpg'),
(173, 22, 'IMG-20230305-WA0019.jpg'),
(174, 22, 'L2KiTXdbVaQ.jpg'),
(175, 22, 'zm6AHKII6lA.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `name_role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id_role`, `name_role`) VALUES
(1, 'Администратор'),
(2, 'Модератор'),
(3, 'Пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otchestvo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_rojdenia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gorod` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_role` int NOT NULL,
  `photo_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `username`, `lastname`, `otchestvo`, `date_rojdenia`, `gorod`, `email`, `password`, `id_role`, `photo_user`) VALUES
(4, 'Михаил', 'Апраксин', 'Сергеевич', '2004-12-19', 'Альметьевск', 'misha@mail.ru', 'e807f1fcf82d132f9bb018ca6738a19f', 3, 'images.jpeg'),
(5, 'Админ', 'Админ', 'Админович', '', '', 'admin@mail.ru', 'f6fdffe48c908deb0f4c3bd36c032e72', 1, '1644852387_2-fikiwiki-com-p-kartinki-admina-2.jpg'),
(6, 'Модер', '', '', '', '', 'moder@mail.ru', 'modermoder', 2, ''),
(7, 'Алмас', 'Сальманов', '', '', '', 'almas@mail.ru', 'e807f1fcf82d132f9bb018ca6738a19f', 3, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Lectures`
--
ALTER TABLE `Lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Индексы таблицы `Lecture_Topics`
--
ALTER TABLE `Lecture_Topics`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news_user`
--
ALTER TABLE `news_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_album` (`album_id`) USING BTREE;

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `album`
--
ALTER TABLE `album`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `Events`
--
ALTER TABLE `Events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `Lectures`
--
ALTER TABLE `Lectures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `Lecture_Topics`
--
ALTER TABLE `Lecture_Topics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `News`
--
ALTER TABLE `News`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `news_user`
--
ALTER TABLE `news_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Lectures`
--
ALTER TABLE `Lectures`
  ADD CONSTRAINT `Lectures_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `Lecture_Topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `news_user`
--
ALTER TABLE `news_user`
  ADD CONSTRAINT `news_user_ibfk_1` FOREIGN KEY (`author`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`);

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
