-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 05:22 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c&o_burger`
--

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE `menuitem` (
  `Menu_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menuitem`
--

INSERT INTO `menuitem` (`Menu_ID`, `Name`, `Description`, `Price`, `Category`, `ImagePath`) VALUES
(112, 'C&O Mexicana Spicy Double Beef Burger', 'Bold, Zesty, and Packed with Fiery Flavor', '21.90', 'Burger', 'uploads/mexicanaDoubleBeefSet.jpg'),
(113, 'C&O Crispy Chicken Burger', 'Our Signature Burger With Crisp Chicken Combine with Crispy Fries', '13.90', 'Burger', 'uploads/crispySet.jpg'),
(114, 'C&O Mexicana Chicken Spicy Tower Burger', 'Savor the Heat With Juicy Chicken Tower Burger, Topped With Hawaiian Spice', '21.90', 'Burgers', 'uploads/hawaiianSet.jpg'),
(115, 'C&O Grilled Chicken Burger', 'Juicy Grilled Chicken Burger, Bursting with Flavor and Served with Your Choice of Toppings', '15.90', 'Burger', 'uploads/grilledChicken.jpg'),
(116, 'Beefy Bliss Burger', 'Succulent Beef Patties Grilled to Perfection', '11.90', 'Ala Carte', 'uploads/beefyBlissBurger.jpg'),
(117, 'Grilled Chicken Burger', 'Juicy Grilled Chicken Burger, Bursting with Flavor and Served with Your Choice of Toppings', '13.90', 'Ala Carte', 'uploads/chickenGrilledBurger.jpg'),
(118, 'Crispy Chicken Burger', 'Our Signature Burger With Crisp Chicken', '11.90', 'Ala Carte', 'uploads/crispyBurger.jpg'),
(119, 'Beefy Tower Burger', 'Juicy Beef Tower Burger, a Savory Delight', '13.90', 'Ala Carte', 'uploads/doublecheesytowerburger.jpg'),
(120, 'Mexicana Beef Burger', 'Bold, Zesty, and Packed with Fiery Flavor', '19.20', 'Ala Carte', 'uploads/mexicanaBeefBurger.jpg'),
(121, 'Spiraled Delight Crisps', 'Delicately Spiral-Cut and Perfectly Seasoned', '8.90', 'Side Dish', 'uploads/spiraledDelightCrisps.jpg'),
(122, 'Golden Bliss Potato Wedges', 'Golden Wedges are Seasoned to Perfection With a Blend of Savory Spices and Served Piping Hot', '13.90', 'Side Dish', 'uploads/goldenBlissPotatoWedges.jpg'),
(123, 'Crunchy French Fries', 'Perfect Balance of Crispy Exterior and Fluffy Interior', '6.50', 'Side Dish', 'uploads/crunchyFrenchFries.jpg'),
(124, 'Rustic Charm Potato Wedges', 'Wedges are Oven-Baked to Crispy Perfection. Seasoned with a Blend of Savory Herbs and Spices', '8.90', 'Side Dish', 'uploads/rusticCharmPotatoWedges.jpg'),
(125, 'Gourmet Cheesy Bliss Fries', 'Fries Topped with a Blend of Melted Cheeses and Savory Meats', '15.90', 'Side Dish', 'uploads/gourmetCheesyBlissFries.jpg'),
(126, 'Fanta', 'Fanta', '4.20', 'Beverage', 'uploads/fanta.jpg'),
(127, 'Coca cola', 'Coca Cola', '5.00', 'Beverage', 'uploads/cocacola.jpg'),
(128, 'Sprite', 'Sprite', '4.20', 'Beverage', 'uploads/sprite.jpg'),
(129, 'Heaven & earth ice lemon tea', 'Ice Lemon Tea', '4.20', 'Beverage', 'uploads/icelemontea.jpg'),
(130, 'Iced latte', 'Espresso is Smoothly Blended with Cold, Velvety Milk and Served Over Ice', '9.00', 'Beverage', 'uploads/icedlatte.jpg'),
(131, 'Iced americano', 'Coffee Beverage Made with Espresso and \r\nChilled Water, Served Over Ice', '8.50', 'Beverage', 'uploads/icedamericano.jpg'),
(132, 'Hot latte', 'Perfect Blend of Robust Espresso and Smooth, Steamed Milk', '8.50', 'Beverage', 'uploads/hotlatte.jpg'),
(133, 'Hot americano', 'Classic Beverage is Crafted by Combining Rich Espresso Shots with Hot Water', '7.50', 'Beverage', 'uploads/hotamericano.jpg'),
(134, 'Chocolate Pot Mousse', 'Rich, Velvety Chocolate Infused with Creamy Goodness, Offering A Delightful Sensation with Every Spoonful', '12.00', 'Desserts', 'uploads/chocolatePotMousse.jpg'),
(135, 'Cinnamon Swirl Delights', 'Fluffy Pastry Swirls Infused with Aromatic Cinnamon and Drizzled with A Delicate Glaze', '10.00', 'Desserts', 'uploads/WhimsicalCinnamonSwirlDelights.jpg'),
(136, 'Macarons Treat (6 pcs)', 'Delicate Macarons with A Burst of Delightful Flavors', '18.00', 'Desserts', 'uploads/PastelPillowTreats.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `request` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`order_item_id`, `order_id`, `menu_id`, `quantity`, `request`) VALUES
(18, 680, 125, 1, ''),
(19, 680, 130, 2, ''),
(20, 681, 117, 1, ''),
(21, 681, 129, 1, ''),
(22, 681, 136, 1, 'no chocolate flavour'),
(23, 682, 114, 3, 'extra hawaiian spice'),
(24, 682, 127, 1, ''),
(25, 682, 133, 1, ''),
(26, 682, 129, 1, ''),
(27, 683, 135, 1, ''),
(28, 684, 121, 1, ''),
(29, 684, 118, 1, ''),
(30, 684, 123, 1, ''),
(31, 684, 136, 1, ''),
(32, 685, 133, 1, 'extra shot'),
(33, 686, 114, 1, ''),
(34, 686, 134, 1, ''),
(36, 688, 116, 1, 'nasi'),
(37, 689, 113, 3, 'nasi'),
(38, 689, 112, 1, ''),
(39, 690, 113, 3, 'extra sauce'),
(40, 690, 115, 5, 'extra mic'),
(41, 691, 113, 2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Order_Date` date DEFAULT NULL,
  `Total_Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_ID`, `User_ID`, `Order_Date`, `Total_Price`) VALUES
(680, 2, '2024-05-26', '48.80'),
(681, 6, '2024-05-26', '36.10'),
(682, 10, '2024-05-26', '82.40'),
(683, 14, '2024-05-26', '10.00'),
(684, 4, '2024-05-26', '45.30'),
(685, 5, '2024-05-26', '7.50'),
(686, 11, '2024-05-26', '33.90'),
(687, 20, '2024-05-27', '16.90'),
(688, 1, '2024-05-29', '11.90'),
(689, 29, '2024-06-26', '63.60'),
(690, 30, '2024-06-26', '121.20'),
(691, 30, '2024-06-26', '27.80');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `Reservation_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `ReserveDate` date DEFAULT NULL,
  `ReserveTime` time DEFAULT NULL,
  `NumGuests` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Reservation_ID`, `User_ID`, `ReserveDate`, `ReserveTime`, `NumGuests`) VALUES
(38, 1, '2023-08-29', '18:00:00', 2),
(39, 2, '2023-09-03', '19:30:00', 6),
(40, 3, '2023-09-08', '20:00:00', 2),
(41, 4, '2023-09-13', '18:00:00', 3),
(42, 5, '2023-09-18', '19:00:00', 4),
(43, 6, '2023-09-23', '20:30:00', 5),
(44, 7, '2023-09-28', '18:30:00', 2),
(45, 8, '2023-10-03', '19:00:00', 4),
(46, 9, '2023-10-08', '20:00:00', 3),
(47, 10, '2023-10-13', '17:30:00', 5),
(48, 11, '2023-10-18', '18:00:00', 2),
(49, 12, '2023-10-23', '19:30:00', 6),
(50, 1, '2023-10-28', '20:00:00', 2),
(51, 2, '2023-11-02', '18:00:00', 3),
(52, 3, '2023-11-07', '19:00:00', 4),
(53, 4, '2023-11-12', '20:30:00', 5),
(54, 5, '2023-11-17', '18:30:00', 2),
(55, 6, '2023-11-22', '19:00:00', 4),
(56, 7, '2023-11-27', '20:00:00', 3),
(57, 8, '2023-12-02', '17:30:00', 5),
(58, 9, '2023-12-07', '18:00:00', 2),
(59, 10, '2023-12-12', '19:30:00', 6),
(60, 11, '2023-12-17', '20:00:00', 2),
(61, 12, '2023-12-22', '18:00:00', 3),
(62, 1, '2023-12-27', '19:00:00', 4),
(75, 10, '2024-01-01', '18:30:00', 2),
(76, 11, '2024-01-06', '19:00:00', 4),
(77, 12, '2024-01-11', '20:00:00', 3),
(78, 7, '2024-01-16', '17:30:00', 5),
(79, 6, '2024-01-21', '10:00:00', 2),
(80, 4, '2024-01-26', '10:30:00', 6),
(81, 5, '2024-01-31', '12:00:00', 2),
(82, 3, '2024-02-05', '14:00:00', 3),
(83, 1, '2024-02-10', '15:30:00', 4),
(84, 2, '2024-02-15', '17:00:00', 5),
(85, 9, '2024-02-20', '10:00:00', 2),
(86, 8, '2024-02-25', '11:30:00', 4),
(87, 12, '2024-03-01', '14:00:00', 3),
(88, 5, '2024-03-06', '15:30:00', 5),
(89, 1, '2024-03-11', '17:00:00', 2),
(90, 3, '2024-03-16', '10:00:00', 6),
(91, 2, '2024-03-21', '11:30:00', 2),
(92, 7, '2024-03-26', '13:00:00', 3),
(93, 4, '2024-03-31', '14:30:00', 4),
(94, 6, '2024-04-05', '16:00:00', 5),
(95, 8, '2024-04-10', '10:00:00', 2),
(96, 10, '2024-04-15', '11:30:00', 4),
(97, 11, '2024-04-20', '13:00:00', 3),
(98, 9, '2024-04-25', '14:30:00', 5),
(99, 12, '2024-04-30', '16:00:00', 2),
(100, 7, '2024-05-02', '10:00:00', 1),
(101, 8, '2024-05-06', '11:00:00', 4),
(102, 3, '2024-05-10', '12:00:00', 4),
(103, 4, '2024-05-12', '13:00:00', 2),
(104, 11, '2024-05-15', '14:00:00', 4),
(105, 6, '2024-05-15', '15:00:00', 10),
(106, 7, '2024-05-17', '16:00:00', 5),
(107, 10, '2024-05-18', '17:00:00', 6),
(108, 9, '2024-05-20', '18:00:00', 2),
(109, 2, '2024-05-20', '19:00:00', 5),
(110, 1, '2024-05-22', '20:00:00', 2),
(111, 4, '2024-05-24', '21:00:00', 8),
(122, 20, '0000-00-00', '00:00:00', 4),
(123, 30, '2024-06-26', '12:00:00', 5),
(124, 25, '2024-06-27', '12:00:00', 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Username`, `Email`, `Password`, `Type`) VALUES
(1, 'we', 'hafisamid4@gmail.com', '$2y$10$N5HdhBJNEV780HmqwPOpde8Xaj22dv2p2FSKa/HrZQU8NZ.oooo3y', 'user'),
(2, 'Haiqal', 'Haiqal11@gmail.com', 'Haiqal0102', 'admin'),
(3, 'Amir Umar', 'amir_umar@gmail.com', 'Amir7890', 'admin'),
(4, 'Nana Comel', 'nana_musa@gmail.com', 'Nana2468', 'user'),
(5, 'Sarah123', 'sarah.malik@gmail.com', 'SarahhMalik', 'admin'),
(6, 'Faizal', 'Faizal31@gmail.com', 'Faizal8721', 'admin'),
(7, 'Norazila', 'norazila99.my@gmail.com', 'Norazila3241', 'admin'),
(8, 'Azman Zakaria', 'azman.zakaria@gmail.com', 'aazman', 'user'),
(9, 'Mira', 'amirah.johari@gmail.com', 'JohariAmiraa', 'user'),
(10, 'Ismail mail', 'ismail.ali@gmail.com', 'mail@124', 'user'),
(11, 'aina', 'ainamarin4@gmail.com', '123\r\n', 'user'),
(12, 'admin', 'admin@gmail.com', 'admin\r\n', 'admin'),
(13, 'Haziqq', 'haziq.zainal@gmail.com', 'HaziqZainal12', 'user'),
(14, 'Nadhy', 'nadhira@gmail.com', '$2y$10$Egsh1zD.3F9osYj580CPHu1nhE4wVxbqzpgCUGnuqC0hGaV0/lX7i', 'user'),
(15, 'aina', 'ainamarin4@gmail.com', '123\r\n', 'admin'),
(16, 'admin', 'admin@gmail.com', '123', 'admin'),
(17, 'try', 'try@gmail.com', '$2y$10$JXP0R7S1HvOse3zqQ7kNHe7ozOfulLY5d4efv35fFxde0LZt.AL2K', 'admin'),
(18, 'aina', 'ainamarin4@gmail.com', '123', 'user'),
(19, 'nadhy', 'nadhira@gmail.com', '$2y$10$uW3NxiuYDbAogBut.UIy2.MU9LPPp7aEBkF5UCXd38hD2E5FUr8Zi', 'user'),
(20, 'customer', 'customer@gmail.com', '$2y$10$.aYhk1U6D2fIle31lUqAcOO7p8gjl8UgcI3fRGzw/0MW7U2vlj/R6', 'user'),
(21, 'admin', 'admin@gmail.com', '$2y$10$6VqOWAI.y28spl4UxQUwUOD8kEFTyoFFn8Acxwce2RfSvs4EAlti6', 'admin'),
(22, 'so', 'so@gmail.com', '$2y$10$cVsvP0Q61tJ9ywC70cKp3.4UitrvSeDLQDELTYmsXWe7sZOzvRlry', 'admin'),
(24, 'bel', 'bel@gmail.com', NULL, 'user'),
(25, 'we2', 'hafisamid4@gmail.com', '$2y$10$9a08i20hePs5350zxONIluBqOdsK8xnDNz2wc9W4jFNdcFF3VD6qu', 'admin'),
(26, 'well3', 'hafisamid4@gmail.com', '$2y$10$SDJrgznhK2r23Hty6gf0BORuW80LTjO1O5whNgsfUU8iHiE3HSJkS', 'user'),
(27, 'well33', 'hafisamid4@gmail.com', '$2y$10$s35O3pxDsZ7h6DatgG4KYO8YOdQJdK58DUOK4XMx50YzCuIAbhSUe', 'admin'),
(28, 'well333', 'hafisamid4@gmail.com', '$2y$10$2Q/8X3klgbG5vSkE2O64bu7X.J7fVgQ.EtuHroTWYrAjpgoDua3Iy', 'admin'),
(29, 'hafis', 'hafisamid4@gmail.com', '$2y$10$9DkODS9t7njbBgpZcw68h.kTKac8kkMtouLg0P55exMgCn5HxpI4C', 'user'),
(30, 'hafis1', 'hafisamid4@gmail.com', '$2y$10$loEHO9gVFOjChbMWvwabAOf721chtCkkenKh3MWok2rl3SGp8scUC', 'user'),
(31, 'welly3', 'hafisamid4@gmail.com', '$2y$10$seGaYXPLrC9G6lJELnDsyOEFc8lHsSoTm2bV0cBlaRuS0qTK4fR46', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`Menu_ID`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=767460;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=692;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`Order_ID`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menuitem` (`Menu_ID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
