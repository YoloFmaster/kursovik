-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 18 2024 г., 08:14
-- Версия сервера: 10.11.10-MariaDB-ubu2204
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pushkov_kursovik`
--
CREATE DATABASE IF NOT EXISTS `pushkov_kursovik` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pushkov_kursovik`;

-- --------------------------------------------------------

--
-- Структура таблицы `Category`
--

CREATE TABLE `Category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Category`
--

INSERT INTO `Category` (`id_category`, `name`) VALUES
(1, 'пироги сытные'),
(2, 'пироги сладкие'),
(3, 'косы'),
(4, 'рулеты'),
(5, 'пицца');

-- --------------------------------------------------------

--
-- Структура таблицы `Dish`
--

CREATE TABLE `Dish` (
  `id_dish` int(11) NOT NULL,
  `foodImage` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `mainProduct` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Dish`
--

INSERT INTO `Dish` (`id_dish`, `foodImage`, `name`, `category_id`, `mainProduct`, `price`) VALUES
(1, 'api/imageOfDish/pie.png', 'Пирог с абрикосом ', 2, 'мука, сахар, соль, абрикос,', 600),
(2, 'api/imageOfDish/cosa.png', 'Коса яблочная с грецким орехом и изюмом', 3, 'мука, сахар, соль, яблоки, корица, изюм, грецкий орех', 350),
(3, 'api/imageOfDish/pizzaFourMeat.png', 'Пицца четыре мяса', 5, 'Сыр Моцарелла, охотничьи колбаски, Пепперони, бекон, ветчина, сыр Пармезан, орегано, томатный соус', 650),
(4, '80f611ef0e7747e394e979a34e8893aa2427228577ee1a9da1f7e5493d98fbf3.jpg', 'косичка', 4, 'мука, сахар, соль', 450),
(5, '884d5bff79c10dff6285cf46ba475d7dc4baed81f34b3434163ee1c08dce7cbf.jpg', 'Сыр косичка', 4, 'мука, сахар, соль', 450),
(6, '884d5bff79c10dff6285cf46ba475d7dc4baed81f34b3434163ee1c08dce7cbf.jpg', 'Сыр косичка', 4, 'мука, сахар, соль', 450);

-- --------------------------------------------------------

--
-- Структура таблицы `Ordering`
--

CREATE TABLE `Ordering` (
  `id_ordering` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `address` text NOT NULL,
  `date_making_ordering` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Ordering`
--

INSERT INTO `Ordering` (`id_ordering`, `user_id`, `dish_id`, `count`, `address`, `date_making_ordering`) VALUES
(2, 6, 2, 2, 'г. Санкт-Петербург, ул. Авиаконструкторов, д. 23, кв. 65', '2024-12-10'),
(3, 8, 3, 10, 'г. Санкт-Петербург, ул. Авиаконструкторов, д. 23, кв. 65', '2024-12-10'),
(4, 9, 3, 4, 'г. Санкт-Петербург, ул. Авиаконструкторов, д. 23, кв. 65', '2024-12-17');

-- --------------------------------------------------------

--
-- Структура таблицы `ShoppingCart`
--

CREATE TABLE `ShoppingCart` (
  `id_cart` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`id`, `username`, `phone`, `email`, `password`, `token`, `isAdmin`) VALUES
(6, 'Матвей', '+7 (589) 789 45-84', 'example@gmail.com', '$2y$13$2QpTliARhiL2/NSJ27sbd.NMh9XqWaNOiV6vvxvHpwB9FRn.BWdxS', 'xzr4fdrAGMzUcCpf9K-jMGYAG4vPd5u5', 0),
(8, 'Алексей', '+7 (999) 789 45-84', 'yol@gmail.com', '$2y$13$sEOkb.B.Vv.YEIv9KJ8yMeyzcByL0WUcnQ.JVraeHb7I4PXlo.hcW', 'pm-QRqtQVcF8SzLohnpcuUamGopP8Ibv', 1),
(9, 'Матвей', '+7 (123) 789 45-84', 'example@gmail.com', '$2y$13$mKkOTTStx9hCVL1nC119w.0bZB0sMveSnpFSjKTOjONfHOcjR48k2', 'i8GXXzgvuN9bPCjy9_psvnbF69oI6S9S', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `Dish`
--
ALTER TABLE `Dish`
  ADD PRIMARY KEY (`id_dish`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `Ordering`
--
ALTER TABLE `Ordering`
  ADD PRIMARY KEY (`id_ordering`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `Ordering_ibfk_1` (`user_id`);

--
-- Индексы таблицы `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`,`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Category`
--
ALTER TABLE `Category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `Dish`
--
ALTER TABLE `Dish`
  MODIFY `id_dish` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Ordering`
--
ALTER TABLE `Ordering`
  MODIFY `id_ordering` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Dish`
--
ALTER TABLE `Dish`
  ADD CONSTRAINT `Dish_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id_category`);

--
-- Ограничения внешнего ключа таблицы `Ordering`
--
ALTER TABLE `Ordering`
  ADD CONSTRAINT `Ordering_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

--
-- Ограничения внешнего ключа таблицы `ShoppingCart`
--
ALTER TABLE `ShoppingCart`
  ADD CONSTRAINT `ShoppingCart_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `Dish` (`id_dish`),
  ADD CONSTRAINT `ShoppingCart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
