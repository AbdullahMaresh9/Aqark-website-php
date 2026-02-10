-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 06:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aqarak_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `property_id`, `created_at`) VALUES
(3, 126, 201, '2025-11-28 21:32:38'),
(5, 126, 205, '2025-11-28 22:02:53'),
(6, 124, 206, '2025-12-04 23:01:37'),
(7, 124, 201, '2025-12-04 23:03:28'),
(8, 131, 205, '2025-12-07 16:59:34');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `location` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `user_id`, `type`, `price`, `location`, `image`, `details`, `created_at`) VALUES
(201, 124, 'فيلا', 60000.00, 'صنعاء ,حي الاصبحي', 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80', 'فيلا مشطبه لوكس ومجهزه باحدث التقنيات ,مناسبة لرجال الاعمال ', '2025-11-28 18:48:58'),
(205, 126, 'شقة', 44355.00, 'عدن ,حي المعلا', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUTExMWFRUXGBUYFxgVGBgYIBgdGBgYGBcaGh0YHSggGholHRgWIjEhJSkrLi4uHR8zODMtNygtLisBCgoKDg0OGxAQGy8mICUtLS0tLS0tLS0wLS0tLS0tLS0tLS0tLS0vLy0tLS0tLS8tLS0uLS0tLS0tLS0tLS0tLf/AABEIALcBEwMBIgACEQEDEQH/', 'فيلا ببناء حديث وتصميم فريد من نوعه , مشطب لوكس جديدة', '2025-11-28 22:02:42'),
(206, 126, 'مكتب', 10000.00, 'عدن ,حي المنصورة', 'https://th.bing.com/th/id/R.ef172c0b416f7ea443b12331df24db0a?rik=8WhoiDs2bY%2bmag&riu=http%3a%2f%2fbeauty-images.net%2fwp-content%2fuploads%2f2019%2f07%2f7549.jpeg&ehk=0Y3Q6pJAIuB4vI2V92OUv4CviMpCj7UPBqkOR%2fvuyG4%3d&risl=&pid=ImgRaw&r=0', 'مكتب عقاري حديث ', '2025-11-29 23:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('زائر','وكيل','مدير') NOT NULL DEFAULT 'زائر',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `user_type`, `created_at`) VALUES
(122, 'abdullah', 'maresh', 'abdullah@gmail.com', '12', '713865879', 'مدير', '2025-11-28 13:48:40'),
(124, 'ali', 'saif', 'ah@gmail.com', '$2y$10$dxsbFpcwJ1FRgyGQuDsjmOA/HLt6QBYZJ70z81qlqFA2Cp35OW.Bu', '737719292', 'وكيل', '2025-11-28 16:03:11'),
(126, 'saeed', 'moheb', 'saeed@gmail.com', '$2y$10$feSg/.yKT1OdfU/XhWZ3s.H0sx8HsAB8tGYd0zk9i.61ElEdN65dO', '713875773', 'زائر', '2025-11-28 19:20:14'),
(127, 'عمرو', 'سلام', 'omar@gmail.com', '$2y$10$BQkKovzT5LyjGyyCFdoEruzSrhsOn3s.AekFyvmyEPSFq.nojGxWm', '733353466', 'زائر', '2025-11-28 21:56:19'),
(129, 'admin', 'user', 'admin@gmail.com', '$2y$10$dxsbFpcwJ1FRgyGQuDsjmOA/HLt6QBYZJ70z81qlqFA2Cp35OW.Bu', '71387578', 'مدير', '2025-12-05 00:59:06'),
(131, 'عمر', 'الشامي', 'omaralshamy@gmail.com', '$2y$10$ERmZhlfvPGhETJCUt/T7MOkR1QkixouUaDpkr/LHslPzG4y3GwPPi', '775638934', 'وكيل', '2025-12-07 16:57:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`property_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
