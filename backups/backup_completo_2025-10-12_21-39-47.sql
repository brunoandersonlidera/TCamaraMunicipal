-- Backup (fallback) gerado via PHP/PDO em 2025-10-12 21:39:47
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

--
-- Tabela: `acesso_rapido`
--
DROP TABLE IF EXISTS `acesso_rapido`;
CREATE TABLE `acesso_rapido` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL DEFAULT 'fas fa-link',
  `cor_botao` varchar(255) NOT NULL DEFAULT '#007bff',
  `cor_fonte` varchar(255) NOT NULL DEFAULT '#ffffff',
  `ordem` int(11) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `abrir_nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

