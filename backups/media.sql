-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/10/2025 às 18:27
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u700101648_wrcXd`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `size` bigint(20) NOT NULL,
  `path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL DEFAULT 'public',
  `conversions_disk` varchar(255) DEFAULT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`generated_conversions`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `media`
--

INSERT INTO `media` (`id`, `file_name`, `original_name`, `mime_type`, `size`, `path`, `alt_text`, `title`, `description`, `category_id`, `uploaded_by`, `created_at`, `updated_at`, `uuid`, `name`, `disk`, `conversions_disk`, `manipulations`, `custom_properties`, `generated_conversions`, `order_column`, `model_type`, `model_id`) VALUES
(65, '1_r2Z8dg0A.png', '1.png', 'image/png', 1227726, 'media/foto/1_r2Z8dg0A.png', NULL, '1.png', NULL, 1, 11, '2025-10-13 11:35:39', '2025-10-13 19:19:40', '3b1486c9-88ce-4769-98d1-5b634a22de1d', '1', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"1.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(66, '2_aQ2VDnht.png', '2.png', 'image/png', 1052898, 'media/foto/2_aQ2VDnht.png', NULL, '2.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', '5ab6765a-a8a5-4266-af64-5d55de4e352a', '2', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"2.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(67, '3_00BUcFsX.png', '3.png', 'image/png', 1223532, 'media/foto/3_00BUcFsX.png', NULL, '3.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', 'be6c938c-28f3-4230-acba-b951b99413c5', '3', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"3.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(68, '4_Cs8EAi6A.png', '4.png', 'image/png', 1278667, 'media/foto/4_Cs8EAi6A.png', NULL, '4.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', '573d74b6-3aa7-4e4f-9c00-04cf27aad1e9', '4', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"4.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(69, '5_NOtKjvrH.png', '5.png', 'image/png', 1092933, 'media/foto/5_NOtKjvrH.png', NULL, '5.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', '94a4b8ac-d8e1-44ac-9915-8728b2c2a504', '5', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"5.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(70, '6_DaYY8u9B.png', '6.png', 'image/png', 1178862, 'media/foto/6_DaYY8u9B.png', NULL, '6.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', 'c20df4f1-6b21-4e96-bd2f-c5ba94d4c914', '6', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"6.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(71, '7_jv15wM9h.png', '7.png', 'image/png', 1159716, 'media/foto/7_jv15wM9h.png', NULL, '7.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', '4ac0de1b-51b2-4504-a87a-e06fad965716', '7', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"7.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(72, '8_qaUZDgmu.png', '8.png', 'image/png', 1148723, 'media/foto/8_qaUZDgmu.png', NULL, '8.png', NULL, 4, 11, '2025-10-13 11:35:39', '2025-10-13 11:35:39', 'f75ac5b5-aa95-47a3-afc8-33658f32e699', '8', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"8.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(74, '021_55IYAE6J.png', '021.png', 'image/png', 1238966, 'media/brasao/021_55IYAE6J.png', NULL, '021.png', NULL, 1, 11, '2025-10-13 16:11:50', '2025-10-13 16:11:50', '6e8e9474-b543-4fe9-8969-4f0996df43ac', '021', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"021.png\",\"description\":null}', '[]', NULL, NULL, NULL),
(75, '021_46m3pt4y.png', '021.png', 'image/png', 1238966, 'media/foto/021_46m3pt4y.png', NULL, '021.png', NULL, 4, 11, '2025-10-13 18:29:57', '2025-10-13 18:29:57', 'e90ceefa-aebf-45a1-bd81-4f7186b61f6c', '021', 'public', 'public', '[]', '{\"alt_text\":null,\"title\":\"021.png\",\"description\":null}', '[]', NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_filename_unique` (`file_name`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_mime_type_index` (`mime_type`),
  ADD KEY `media_uploaded_by_index` (`uploaded_by`),
  ADD KEY `media_created_at_index` (`created_at`),
  ADD KEY `media_order_column_index` (`order_column`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `media_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
