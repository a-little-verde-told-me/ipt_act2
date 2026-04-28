-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fleur`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_name`, `price`, `image_url`, `qty`, `created_at`, `updated_at`) VALUES
(42, 4, 'White Rose Elegance', 1599.00, 'http://127.0.0.1:8000/images/white_rose.jpg', 2, '2026-04-11 06:28:35', '2026-04-11 06:30:39'),
(43, 4, 'Sweet Petals', 1299.00, 'http://127.0.0.1:8000/images/sweet_petals.jpg', 1, '2026-04-11 06:28:36', '2026-04-11 06:29:12'),
(45, 4, 'Pink Delight', 1499.00, 'http://127.0.0.1:8000/images/pink_delight.jpg', 1, '2026-04-11 06:31:00', '2026-04-11 06:31:00'),
(51, 5, 'Rosy Charm', 1399.00, 'http://127.0.0.1:8000/images/rosy_charm.jpg', 1, '2026-04-11 07:04:32', '2026-04-11 07:04:32'),
(52, 5, 'White Rose Elegance', 1599.00, 'http://127.0.0.1:8000/images/white_rose.jpg', 1, '2026-04-11 07:04:33', '2026-04-11 07:04:33'),
(66, 8, 'Blooming Embrace Bouquet', 1499.00, 'http://127.0.0.1:8000/images/products/blooming-embrace-bouquet.webp', 1, '2026-04-12 02:50:11', '2026-04-12 02:50:11'),
(67, 8, 'Emilia Bouquet', 1399.00, 'http://127.0.0.1:8000/images/products/emilia-bouquet.webp', 1, '2026-04-12 02:50:13', '2026-04-12 02:50:13'),
(70, 1, 'Citrus Kiss Bouquet', 1299.00, 'http://127.0.0.1:8000/images/products/citrus-kiss-bouquet.webp', 1, '2026-04-12 03:19:53', '2026-04-12 03:19:53'),
(71, 1, 'Daisy Kiss Bouquet', 1099.00, 'http://127.0.0.1:8000/images/products/daisy-kiss-bouquet.webp', 1, '2026-04-12 03:19:54', '2026-04-12 03:19:54'),
(72, 1, 'Emilia Bouquet', 1399.00, 'http://127.0.0.1:8000/images/products/emilia-bouquet.webp', 1, '2026-04-12 03:19:55', '2026-04-12 03:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `slug`, `category`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Rustic Wedding', 'rustic-wedding', 'Weddings', 'rustic_wedding.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(2, '18th Birthday', '18th-birthday', 'Birthdays', '18th_birthday.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(3, 'Corporate Gala', 'corporate-gala', 'Others', 'corporate_gala.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(4, 'Garden Wedding', 'garden-wedding', 'Weddings', 'garden_wedding.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(5, 'Debut Celebration', 'debut-celebration', 'Birthdays', 'debut_celebration.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(6, 'Anniversary Party', 'anniversary-party', 'Others', 'anniversary_party.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_images`
--

INSERT INTO `event_images` (`id`, `event_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'rustic_wedding1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(2, 1, 'rustic_wedding2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(3, 1, 'rustic_wedding3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(4, 2, '18th_birthday1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(5, 2, '18th_birthday2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(6, 2, '18th_birthday3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(7, 3, 'corporate_gala1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(8, 3, 'corporate_gala2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(9, 3, 'corporate_gala3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(10, 4, 'garden_wedding1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(11, 4, 'garden_wedding2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(12, 4, 'garden_wedding3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(13, 5, 'debut_celebration1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(14, 5, 'debut_celebration2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(15, 5, 'debut_celebration3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(16, 6, 'anniversary_party1.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(17, 6, 'anniversary_party2.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(18, 6, 'anniversary_party3.jpg', '2026-04-11 20:57:19', '2026-04-11 20:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flowers`
--

CREATE TABLE `flowers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flowers`
--

INSERT INTO `flowers` (`id`, `name`, `image`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Cosmos', 'flower1.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(2, 'Indian Paintbrush', 'flower2.jpg', 'red', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(3, 'Bluebonnet', 'flower3.jpg', 'blue', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(4, 'Wild Bergamot', 'flower4.jpg', 'purple', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(5, 'Dahlia', 'flower5.jpg', 'red', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(6, 'Zinnia', 'flower6.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(7, 'Ranunculus', 'flower7.jpg', 'orange', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(8, 'Larkspur', 'flower8.jpg', 'blue', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(9, 'Chrysanthemum', 'flower9.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(10, 'Anemone', 'flower10.jpg', 'purple', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(11, 'Celosia', 'flower11.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(12, 'Gladiolus', 'flower12.jpg', 'orange', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(13, 'Gomphrena', 'flower13.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(14, 'Sunflower', 'flower14.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(15, 'Craspedia', 'flower15.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(16, 'Gerbera Daisy', 'flower16.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(17, 'Snapdragon', 'flower17.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(18, 'Bells of Ireland', 'flower18.jpg', 'green', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(19, 'Stock', 'flower19.jpg', 'purple', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(20, 'Strawflower', 'flower20.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(21, 'Nigella', 'flower21.jpg', 'blue', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(22, 'Morning Glory', 'flower22.jpg', 'blue', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(23, 'Lobelia', 'flower23.jpg', 'purple', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(24, 'Verbena', 'flower24.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(25, 'Dusty Miller', 'flower25.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(26, 'Sweet Alyssum', 'flower26.jpg', 'white', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(27, 'Browallia', 'flower27.jpg', 'purple', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(28, 'Torenia', 'flower28.jpg', 'white', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(29, 'Gazania', 'flower29.jpg', 'yellow', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(30, 'Nicotiana', 'flower30.jpg', 'pink', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(31, 'Nasturtium', 'flower31.jpg', 'orange', '2026-04-11 20:57:19', '2026-04-11 20:57:19'),
(32, 'Alyssum', 'flower32.jpg', 'white', '2026-04-11 20:57:19', '2026-04-11 20:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_10_create_products_table', 1),
(5, '2026_04_10_000003_add_profile_fields_to_users_table', 2),
(6, '2026_04_10_000004_add_role_to_users_table', 3),
(7, '2026_04_10_000005_create_carts_table', 4),
(8, '2026_04_11_000000_rename_carts_to_cart_items', 5),
(9, '2026_04_12_000000_create_flowers_table', 6),
(10, '2026_04_12_000001_create_events_table', 6),
(11, '2026_04_28_000000_add_views_to_products_table', 7),
(12, '2026_04_28_000001_add_ratings_to_products_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image_url`, `description`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 'Blooming Embrace Bouquet', 'Bouquet', 1499.00, 'products/blooming-embrace-bouquet.webp', 'A lush bouquet of mixed blossoms with soft pinks and creams.', 1, 4.80, 117, '2026-04-28 06:10:30', '2026-04-28 06:11:25'),
(2, 'Citrus Kiss Bouquet', 'Bouquet', 1299.00, 'products/citrus-kiss-bouquet.webp', 'A bright, refreshing arrangement of yellow and orange blooms.', 0, 4.50, 89, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(3, 'Daisy Kiss Bouquet', 'Bouquet', 1099.00, 'products/daisy-kiss-bouquet.webp', 'A cheerful blend of daisies and greenery for everyday smiles.', 0, 4.60, 104, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(4, 'Emilia Bouquet', 'Bouquet', 1399.00, 'products/emilia-bouquet.webp', 'A graceful bouquet with elegant petals and delicate filler flowers.', 1, 4.70, 145, '2026-04-28 06:10:30', '2026-04-28 06:11:28'),
(5, 'Emotions Bouquet', 'Bouquet', 1299.00, 'products/emotions-bouquet.webp', 'A heartfelt arrangement designed to express warmth and care.', 0, 4.40, 76, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(6, 'Gerbera Joy Bouquet', 'Bouquet', 1249.00, 'products/gerbera-joy-bouquet.jpg', 'A vibrant gerbera-focused bouquet bursting with color.', 1, 4.90, 156, '2026-04-28 06:10:30', '2026-04-28 06:11:32'),
(7, 'Lemon Sorbet Bouquet', 'Bouquet', 1299.00, 'products/lemon-sorbet-bouquet.webp', 'A sunny citrus-inspired bouquet with soft pastel accents.', 0, 4.30, 92, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(8, 'Liliana Bouquet', 'Bouquet', 1399.00, 'products/liliana-bouquet.webp', 'A stylish floral display centered around fragrant lilies.', 0, 4.80, 128, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(9, 'Love Full In Bloom Bouquet', 'Bouquet', 1599.00, 'products/love-full-in-bloom-bouquet.webp', 'A romantic abundance of blooms in classic tones.', 0, 5.00, 203, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(10, 'Love In Bloom Bouquet', 'Bouquet', 1499.00, 'products/love-in-bloom-bouquet.jpg', 'A tender bouquet crafted for special love moments.', 0, 4.70, 134, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(11, 'Peachy Glow Bouquet', 'Bouquet', 1299.00, 'products/peachy-glow-bouquet.jpg', 'A soft peach-hued bouquet with warm, elegant charm.', 0, 4.60, 98, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(12, 'Pink Delight Bouquet', 'Bouquet', 1199.00, 'products/pink-delight-bouquet.jpg', 'A playful pink arrangement bursting with joyful petals.', 0, 4.50, 111, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(13, 'Pink Love Bouquet', 'Bouquet', 1299.00, 'products/pink-love-bouquet.webp', 'A dreamy pink bouquet made for romantic surprises.', 0, 4.80, 167, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(14, 'Pink Sweet Bouquet', 'Bouquet', 1199.00, 'products/pink-sweet-bouquet.webp', 'A sweet blush arrangement with delicate floral accents.', 0, 4.40, 83, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(15, 'Rose Romance', 'Bouquet', 1599.00, 'products/Rose Romance.jpg', 'A timeless romantic bouquet of luxurious rose blooms.', 0, 4.90, 189, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(16, 'Rosy Charm Bouquet', 'Bouquet', 1249.00, 'products/rosy-charm-bouquet.jpg', 'A charming mix of rosy tones for elegant gifting.', 0, 4.60, 105, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(17, 'Royal Orchid Bouquet', 'Bouquet', 1699.00, 'products/royal-orchid-bouquet.jpg', 'A luxurious bouquet featuring premium orchids.', 0, 4.90, 175, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(18, 'Simple Sweet Bouquet', 'Bouquet', 1099.00, 'products/simple-sweet-bouquet.webp', 'A minimal yet sweet arrangement for gentle gestures.', 0, 4.30, 67, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(19, 'Stargazing Bloom Bouquet', 'Bouquet', 1599.00, 'products/stargazing-bloom-bouquet.jpg', 'An elegant bouquet inspired by starry night florals.', 0, 4.80, 141, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(20, 'Summer Medley Bouquet', 'Bouquet', 1399.00, 'products/summer-medley-bouquet.webp', 'A lively mix of summer flowers in bright, warm hues.', 0, 4.70, 119, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(21, 'Sunshine Cheer Bouquet', 'Bouquet', 1099.00, 'products/sunshine-cheer-bouquet.jpg', 'A cheerful, sunlit bouquet to brighten any room.', 0, 4.50, 88, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(22, 'Sweet Petals Bouquet', 'Bouquet', 1199.00, 'products/sweet-petals-bouquet.jpg', 'A delicate pastel arrangement with airy, fragrant petals.', 0, 4.60, 96, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(23, 'White Rose Bouquet', 'Bouquet', 1299.00, 'products/white-rose-bouquet.jpg', 'A classic bouquet of pure white roses for refined style.', 0, 4.80, 152, '2026-04-28 06:10:30', '2026-04-28 06:10:30'),
(24, 'Wildest Dreams Bouquet', 'Bouquet', 1499.00, 'products/wildest-dreams-bouquet.webp', 'A dreamy bouquet of dramatic blooms and lush greenery.', 0, 4.90, 168, '2026-04-28 06:10:30', '2026-04-28 06:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('EPIXrAPZ8mdCIv9iRo8FtGl4js5nW3YBRQC2Q3r3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0xQeFlON0pseldNaWQwNEdIMFpNV045SjVYQk9DeHBwMXJza1Q4NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0P2NhdGVnb3J5PSZzZWFyY2g9JnNvcnQ9cG9wdWxhciI7czo1OiJyb3V0ZSI7czo3OiJwcm9kdWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777385492),
('qNrLFMkq8eooqCQCzzSmnZUJspfzjx982oa7t9v9', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTjlFTGoyRjFIWm5GTXRScEk2aUJmbkZYY2syZ3hucDNrWjRDZEJCNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ucHJvZHVjdHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1777383021);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `age` tinyint(3) UNSIGNED NOT NULL,
  `gender` varchar(20) NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `zip` varchar(4) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `email_verified_at`, `password`, `age`, `gender`, `civil_status`, `mobile`, `address`, `zip`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'verde', 'verde', 'verde@gmail.com', 'user', NULL, '$2y$12$kY9ZEbi09lo9x2eIOr4Mke6jaJ8dMF6JiDShoQpg043j7KTMld5HS', 20, 'Male', 'Single', '09123456789', '#123 Vidal, Tonton, Lingayen, Pangasinan, Philippines', '2401', NULL, '2026-04-09 22:39:09', '2026-04-09 22:39:09'),
(2, 'Admin User', 'admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$1Ag7XKQy6bPBndIiA9G7Pe9S5jo2ok9l1yCw0g1sl9A4MSsWST0mO', 30, 'Other', 'Single', '09990000000', 'Admin Office Address', '0000', NULL, '2026-04-10 01:19:50', '2026-04-28 06:10:30'),
(3, 'Jane Doe', 'jane_doe', 'janedoe@gmail.com', 'user', NULL, '$2y$12$gHC6YCD4GWVVqs30sQBxm.OelzRKwYzOdMrDDGQvTINkCa2Wm/tGW', 25, 'Female', 'Single', '09876543210', 'Alvear Street, Poblacion, Lingayen, Pangasinan, Region I, Philippines, 2401.', '2401', NULL, '2026-04-10 22:21:37', '2026-04-10 22:21:37'),
(4, 'John Doe', 'johndoe', 'johndoe@gmail.com', 'user', NULL, '$2y$12$zy2WP0mlrhfOAdmUUarSi.VG9XrlsDRJ4j8aZD3PWt1SXj7fd3lsu', 25, 'Male', 'Single', '09987654321', 'Alvear Street, Poblacion, Lingayen, Pangasinan, Region I, Philippines, 2401.', '2401', NULL, '2026-04-11 06:27:08', '2026-04-11 06:27:08'),
(5, 'Arman Salon', 'armansalon', 'armansalon@gmail.com', 'user', NULL, '$2y$12$AG15FSV7j531ut8CfO.iq.aePgI/x/2rwIGPx8RwQT36G6TA.Gxga', 18, 'Male', 'Single', '09998765432', 'Alvear Street, Poblacion, Lingayen, Pangasinan, Region I, Philippines, 2401.', '2401', NULL, '2026-04-11 07:03:18', '2026-04-11 07:03:18'),
(6, 'Test User', 'testuser', 'test@example.com', 'user', '2026-04-11 20:45:19', '$2y$12$8olcXsBRXTSx2Kaz0TS3dOAdHsR8eeP6j5KvPzsFxqFF0miuLpNtq', 25, 'Other', 'Single', '09171234567', '123 Test Street', '1000', '698RKFOrT2', '2026-04-11 20:45:19', '2026-04-28 06:10:30'),
(8, 'maya hawke', 'mayabird', 'mayabird@gmail.com', 'user', NULL, '$2y$12$Q9Qq6KOUmRrxU9AlhNWJ9ud/oZqdA8SESmI189fB7b7FHiGOdj2HC', 18, 'Female', 'Single', '09999867643', '#123 Vidal, Tonton, Lingayen, Pangasinan, Philippines', '2401', NULL, '2026-04-12 02:47:28', '2026-04-12 02:47:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_name_unique` (`name`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_images_event_id_foreign` (`event_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flowers`
--
ALTER TABLE `flowers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flowers_name_unique` (`name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flowers`
--
ALTER TABLE `flowers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
