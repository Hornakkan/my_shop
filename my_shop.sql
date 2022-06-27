-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2022 at 07:02 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Vaisselle', 0),
(2, 'Couvert', 1),
(3, 'Baguette', 2),
(6, 'Plat', 1),
(7, 'Bol', 6),
(8, 'Bento', 6);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `description`, `picture`) VALUES
(1, 'Wooden bento box', 50, 8, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c02209fd06.71334671.jpg'),
(4, 'Big bento box', 100, 8, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c035ad97d2.69504020.jpg'),
(5, 'Small bento box', 45, 8, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c049715278.88466120.png'),
(6, 'Medium bento box', 60, 8, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c058747618.36634269.jpg'),
(8, 'Small bowl', 15, 7, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c0832e8046.39700769.jpg'),
(9, 'Five bowls set', 85, 7, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c09d4ca6a7.86638320.jpg'),
(10, 'Wave style bowl', 45, 7, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c0b62051e2.32436220.jpg'),
(11, 'Soup bowl', 20, 7, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c0d6924c70.32263456.jpg'),
(12, 'Chopsticks set 1', 25, 3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c0f5eaa097.79949036.jpg'),
(13, 'Chopsticks set 2', 25, 3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c109505b53.32627890.jpg'),
(14, 'Chopsticks set 3', 25, 3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c118db3ef8.67730697.jpg'),
(15, 'Chopsticks set 4', 50, 3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c12c5dc926.66689454.jpg'),
(16, 'Chopsticks set 5', 35, 3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam, corporis reiciendis. Quod error quo dolorem sequi vero quas qui architecto delectus ducimus, animi harum possimus asperiores reprehenderit. Quas ratione sit laboriosam aut dolorum veritatis quod culpa provident doloremque? Voluptates harum veniam quo ex ullam eligendi corrupti repellat reprehenderit rerum eum.', '62b1c13bc44bc3.67659433.jpeg'),
(17, 'Plate 1', 30, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c162d14ad7.44418362.jpg'),
(18, 'Plate 2', 65, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c176e22c93.69400007.jpg'),
(19, 'Plate 3', 75, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c18a97fc84.31916001.jpg'),
(20, 'Set couverts 1', 85, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c1aedf89c0.61951926.jpg'),
(21, 'Set couverts 2', 85, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c1bf02d0c1.03361293.jpg'),
(22, 'Set couverts 3', 85, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c1d1165ae0.01921342.jpg'),
(23, 'Set couverts 3', 30, 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia suscipit omnis quisquam beatae. Ut deleniti libero, doloremque vero itaque soluta quia consequuntur recusandae architecto ipsa cupiditate ratione aliquam amet placeat error officiis nostrum similique explicabo alias sunt saepe! Distinctio illo esse possimus neque voluptas eius vel praesentium sunt nostrum incidunt!', '62b1c1ed131571.00486685.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `admin`, `avatar`) VALUES
(1, 'Toto', '$2y$10$s6gv3ZaEpoTsbhId6PB5k.9A5j27SlezNWcugt.7xXUAhpTjiJEj6', 'toto@toto.com', 0, NULL),
(4, 'Tata', '$2y$10$/Dn78cBwQvdrS/qg9osw..evfWXpGTMlScpWvcZmnXhuJXRMVk9zC', 'tata@tata.com', 0, NULL),
(8, 'Orgruk', '$2y$10$kdFXGJTTE05oK164RvshXe6M3QliwJOjwNGdN0Fl/HL5/AnhKer52', 'orgruk@test.com', 1, '62b466f40dfde6.11426261.jpg'),
(13, 'Test', '$2y$10$FKNScoHHrM2dFaAshpdam.DZugabSsPpxamfc..gcnOCF4aMIJfI.', 'test@test.com', 0, NULL),
(14, 'Daniel', '$2y$10$fBaUkpEkgusH.qja4.zz/OqQ7CX9SSnX7fklKWSZ0z.5gqM6pue32', 'daniel@test.com', 0, '62b41a7624b110.52036530.jpg'),
(15, 'Miyagi', '$2y$10$BhNR5fMPi5Q7j1Q57GliiOoOuBduV6smSYmojMasw.146RAFeweu2', 'miyagi@test.com', 0, '62b49424f03ce8.84563489.jpg'),
(17, 'Titi', '$2y$10$6ae1qDUG.3rms3XPn7yAHOxvgcQ.FRWQsubjHX3Dlr8SFBVmFck1u', 'titi@titi.com', 0, '62b41adfb6b282.89781495.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
