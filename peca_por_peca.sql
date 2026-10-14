-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/10/2026 às 02:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1790853396),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1790853396;', 1790853396);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
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
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', 1, 'api-token', '746e240e7f6b5dd6c09e97382fd9f576d32cea4644856b994b90a05af8b7b817', '[\"*\"]', NULL, NULL, '2026-09-23 19:24:34', '2026-09-23 19:24:34'),
(13, 'App\\Models\\User', 4, 'api-token', '7713bdfcfb4c6cce79041494f75431f2d990df0f236af5b11908543e2122abc1', '[\"*\"]', '2026-09-24 00:30:55', NULL, '2026-09-23 21:38:07', '2026-09-24 00:30:55'),
(29, 'App\\Models\\User', 2, 'api-token', '8fe4563e924db04fd11b6be8f675d2a1c0030d0a7b0db05c6a68d86c92a023b3', '[\"*\"]', '2026-09-25 17:06:09', NULL, '2026-09-25 15:56:09', '2026-09-25 17:06:09'),
(30, 'App\\Models\\User', 8, 'api-token', '6e8aa9b5ff82ff763fe1272d7d6f9931cb34d8c2d72334bfac5823b216cf16d7', '[\"*\"]', '2026-09-27 15:36:08', NULL, '2026-09-27 15:21:28', '2026-09-27 15:36:08'),
(31, 'App\\Models\\User', 1, 'api-token', '39b65b99421c711e8bc15ea8131f47c55a324e3443056f355faf723801c05c68', '[\"*\"]', NULL, NULL, '2026-09-27 15:27:25', '2026-09-27 15:27:25'),
(32, 'App\\Models\\User', 1, 'api-token', 'a20b77c9c44e6906ad82533f2b5442186a8e8eb0c402f9975c2d2f3cd7069502', '[\"*\"]', '2026-09-27 18:50:28', NULL, '2026-09-27 15:27:28', '2026-09-27 18:50:28'),
(33, 'App\\Models\\User', 1, 'api-token', '0e3082b07fcc98bcec5f2c8f8b2e88433e850cbaee6431959a0e20383a892edc', '[\"*\"]', NULL, NULL, '2026-09-27 15:37:01', '2026-09-27 15:37:01'),
(34, 'App\\Models\\User', 1, 'api-token', '825ce0d5cf5a8e76d7eb6474f77f90fd3eabc602f1a0ae2f08f1fd158c761ff6', '[\"*\"]', NULL, NULL, '2026-09-27 15:37:03', '2026-09-27 15:37:03'),
(35, 'App\\Models\\User', 1, 'api-token', '286c26c4b6e5eded1c135a1954c6d8ed770be29edf6aaced9165ce2db406baa4', '[\"*\"]', NULL, NULL, '2026-09-27 15:42:35', '2026-09-27 15:42:35'),
(36, 'App\\Models\\User', 2, 'api-token', '735e87a4da3e849da6a6d29f65e45b79cde81a25ed3644c1e7f3808773828e72', '[\"*\"]', NULL, NULL, '2026-09-29 11:47:15', '2026-09-29 11:47:15'),
(37, 'App\\Models\\User', 2, 'api-token', '102e137c526d7472d235e058ead4d6b1decc5aaead8c8fd5e5f668e96d6d31c2', '[\"*\"]', NULL, NULL, '2026-09-29 11:47:16', '2026-09-29 11:47:16'),
(38, 'App\\Models\\User', 2, 'api-token', 'f0335011a9f2eb5812c0a376f4e494c4c35ead0e053f92a26d69f15c295746dc', '[\"*\"]', '2026-09-29 23:06:12', NULL, '2026-09-29 11:47:18', '2026-09-29 23:06:12'),
(39, 'App\\Models\\User', 1, 'api-token', '5bcd8bc0c0585f3db18328009b3084031aeee4ad4ea1025494d01d2bb471694b', '[\"*\"]', NULL, NULL, '2026-09-29 12:54:59', '2026-09-29 12:54:59'),
(40, 'App\\Models\\User', 1, 'api-token', 'c84bac870c372c223d5bdb91e490942385396387ff2c52e9283ac62b89e291db', '[\"*\"]', NULL, NULL, '2026-09-29 12:55:01', '2026-09-29 12:55:01'),
(42, 'App\\Models\\User', 2, 'api-token', '4bbe4842b7620c1896dfe547b02f87f12a9065079646d92006b43de6784bb734', '[\"*\"]', NULL, NULL, '2026-09-29 23:19:57', '2026-09-29 23:19:57'),
(44, 'App\\Models\\User', 5, 'api-token', '6f07293c30cefc091cafa871676f89ed3cbba167501ccce22aadaf061cb662ce', '[\"*\"]', '2026-09-30 11:39:51', NULL, '2026-09-29 23:57:09', '2026-09-30 11:39:51'),
(45, 'App\\Models\\User', 2, 'api-token', '48a65e605af2fd6ee99a5595dbe29f4defecef0b52fa3aab9fdc203ed6c07f73', '[\"*\"]', '2026-10-01 12:30:27', NULL, '2026-09-30 11:13:28', '2026-10-01 12:30:27'),
(46, 'App\\Models\\User', 9, 'api-token', '3a53827139dd50926ed60458c07fde169227396a6840543925d8a3a2b6428d40', '[\"*\"]', NULL, NULL, '2026-09-30 13:22:43', '2026-09-30 13:22:43'),
(47, 'App\\Models\\User', 1, 'api-token', '18c7a60f688ef2a74f4ca5f36e39544657814b75023a49284abfe15f456088dd', '[\"*\"]', NULL, NULL, '2026-09-30 13:23:40', '2026-09-30 13:23:40'),
(48, 'App\\Models\\User', 1, 'api-token', '6cb5af1c28bc75e7be19735e942796d468582fb77c797c618a5d0ffc29d1a891', '[\"*\"]', NULL, NULL, '2026-09-30 21:00:10', '2026-09-30 21:00:10'),
(49, 'App\\Models\\User', 1, 'api-token', 'ffc36498a48f69ee464cf550b252e4c2d5198aca8c9e4011a45aa53924179ef4', '[\"*\"]', NULL, NULL, '2026-09-30 21:00:14', '2026-09-30 21:00:14'),
(50, 'App\\Models\\User', 1, 'api-token', '00a475c5f74a8081765b0be7d8553a0940253823b3e7529c4d746156e064e917', '[\"*\"]', NULL, NULL, '2026-09-30 21:00:16', '2026-09-30 21:00:16'),
(51, 'App\\Models\\User', 1, 'api-token', '48fb9d9ec033b4ee4149bd1c40959d2deafcfb719be3202126e1d903b09052d0', '[\"*\"]', NULL, NULL, '2026-09-30 21:00:17', '2026-09-30 21:00:17'),
(52, 'App\\Models\\User', 1, 'api-token', 'ff26efe19a6cda844ac8993c5c7efa6f54a371db7c4f6e8015cfa2870203dcce', '[\"*\"]', NULL, NULL, '2026-09-30 23:02:03', '2026-09-30 23:02:03'),
(53, 'App\\Models\\User', 2, 'api-token', '683c2ff1db2797db1cacacc70a9a4b32642757ef311ecc533e9de30f70cf868f', '[\"*\"]', '2026-10-02 20:23:35', NULL, '2026-10-01 12:54:01', '2026-10-02 20:23:35'),
(54, 'App\\Models\\User', 1, 'api-token', '23a90e44814ea07a40af73a1f30b4e4f6b16ecce79de5e8709ec5ab3ecedc224', '[\"*\"]', NULL, NULL, '2026-10-02 20:20:13', '2026-10-02 20:20:13'),
(55, 'App\\Models\\User', 1, 'api-token', 'bf0e16360e1f7e116558416644fb2550515b4fbc5a453149a746f2f07c491c33', '[\"*\"]', NULL, NULL, '2026-10-02 20:20:15', '2026-10-02 20:20:15'),
(56, 'App\\Models\\User', 10, 'api-token', 'c3846df7f6d0863b3aede55379ee0d3cd73bd7d2fbbe656ab358de721db5fd5e', '[\"*\"]', '2026-10-12 14:02:29', NULL, '2026-10-12 13:03:11', '2026-10-12 14:02:29'),
(57, 'App\\Models\\User', 10, 'api-token', '3388f1477e5ace6133402ff657a907b0824089ab0b5cacbf9f466f08495fe65a', '[\"*\"]', NULL, NULL, '2026-10-12 14:13:13', '2026-10-12 14:13:13'),
(58, 'App\\Models\\User', 10, 'api-token', '95bce0ba51a5b91d90e218ced677765f31cee7327e22363637c4b3c56e8e6e2d', '[\"*\"]', NULL, NULL, '2026-10-12 14:13:15', '2026-10-12 14:13:15'),
(63, 'App\\Models\\User', 2, 'api-token', 'ebf60fd51d8a7bb1468e39dfd04eea5f878640ceba38a2cfd83162f0fa9309c4', '[\"*\"]', '2026-10-13 20:03:04', NULL, '2026-10-13 20:00:04', '2026-10-13 20:03:04'),
(64, 'App\\Models\\User', 2, 'api-token', '8a4989b87a6113300b309f5f5f641a01ad00961eb7bd369531ceff61275a9870', '[\"*\"]', NULL, NULL, '2026-10-13 20:03:45', '2026-10-13 20:03:45'),
(65, 'App\\Models\\User', 2, 'api-token', 'facebbcb56434235d095a3b253ad76869c5d3260d375f3b4afd29819d9d68365', '[\"*\"]', '2026-10-13 20:11:51', NULL, '2026-10-13 20:03:46', '2026-10-13 20:11:51'),
(67, 'App\\Models\\User', 2, 'api-token', 'ca5b7adc267e9c26a86f10150115567f3579794e2d399cb3a199f819d981f58c', '[\"*\"]', '2026-10-13 20:14:33', NULL, '2026-10-13 20:14:22', '2026-10-13 20:14:33'),
(69, 'App\\Models\\User', 2, 'api-token', 'edf4f203258795795d0166b954ef33c66652bcc2a639b922a5deed141bd17052', '[\"*\"]', '2026-10-13 20:38:22', NULL, '2026-10-13 20:16:09', '2026-10-13 20:38:22'),
(70, 'App\\Models\\User', 2, 'api-token', 'a6beefa3f0caf3a5a2127baf1006cc9ab6c9b7c6b2c90c9d921cfa5f83e51799', '[\"*\"]', '2026-10-13 20:42:27', NULL, '2026-10-13 20:40:17', '2026-10-13 20:42:27'),
(78, 'App\\Models\\User', 10, 'api-token', '1c89e363615142080b23e5502da400e3fec475a2e1e7ee6b9e473418e5ba9ee1', '[\"*\"]', '2026-10-14 00:08:55', NULL, '2026-10-13 23:59:09', '2026-10-14 00:08:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_avaliacao`
--

CREATE TABLE `tb_avaliacao` (
  `id_avaliacao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nr_nota` int(11) NOT NULL,
  `ds_comentario` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(100) NOT NULL,
  `ds_categoria` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`id_categoria`, `nm_categoria`, `ds_categoria`, `created_at`, `updated_at`) VALUES
(1, 'Hardware', 'Componentes internos e periféricos de computadores, como placas-mãe, processadores, placas de vídeo, coolers, gabinetes e outros equipamentos de hardware.', '2026-09-23 14:20:06', NULL),
(2, 'Computador e notebook', 'Computadores desktop, notebooks e seus acessórios, incluindo peças completas, equipamentos usados, novos ou para manutenção.', '2026-09-23 14:20:06', NULL),
(3, 'Celular e tablet', 'Smartphones, tablets e acessórios relacionados, como capas, telas, baterias, botões, conectores e demais componentes.', '2026-09-23 14:20:06', NULL),
(4, 'Memórias e pen drives', 'Dispositivos de armazenamento e memória, como memória RAM, SSDs, HDs, cartões de memória, pen drives e outros meios de armazenamento de dados.', '2026-09-23 14:20:06', NULL),
(5, 'Fontes e carregadores', 'Fontes de alimentação, carregadores, cabos de energia, adaptadores de tomada e acessórios utilizados para fornecer energia a equipamentos eletrônicos.', '2026-09-23 14:20:06', NULL),
(6, 'Impressoras e adaptadores', 'Impressoras, scanners, cartuchos, toners, adaptadores, conversores e acessórios utilizados para impressão e conexão de dispositivos.', '2026-09-23 14:20:06', NULL),
(7, 'Consoles e videogames', 'Consoles, controles, jogos, cabos, peças de reposição e acessórios para videogames e entretenimento eletrônico.', '2026-09-23 14:20:06', NULL),
(8, 'Câmeras', 'Câmeras fotográficas, webcams, filmadoras, lentes, tripés, baterias e demais acessórios relacionados à captura de imagens e vídeos.', '2026-09-23 14:20:06', NULL),
(9, 'Outros', 'Outros tipos de componentes eletrônicos.', '2026-09-23 14:20:06', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_denuncia`
--

CREATE TABLE `tb_denuncia` (
  `id_denuncia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_denunciado` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `ds_motivo` varchar(255) NOT NULL,
  `ds_denuncia` text DEFAULT NULL,
  `st_denuncia` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_denuncia`
--

INSERT INTO `tb_denuncia` (`id_denuncia`, `id_usuario`, `id_usuario_denunciado`, `id_produto`, `ds_motivo`, `ds_denuncia`, `st_denuncia`, `created_at`, `updated_at`) VALUES
(1, 2, 5, NULL, 'Comportamento ofensivo', 'aaaaaalllllllllllllpppppppppppppp', 'P', '2026-09-30 22:39:56', '2026-09-30 22:39:56'),
(2, 2, 5, NULL, 'Assédio', 'fez a pose do it girl', 'P', '2026-10-01 11:15:36', '2026-10-01 11:15:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_favorito`
--

CREATE TABLE `tb_favorito` (
  `id_favorito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_favorito`
--

INSERT INTO `tb_favorito` (`id_favorito`, `id_usuario`, `id_produto`, `created_at`, `updated_at`) VALUES
(2, 2, 3, '2026-09-29 18:00:38', NULL),
(3, 2, 15, '2026-09-30 00:46:42', NULL),
(4, 2, 2, '2026-09-30 00:46:48', NULL),
(5, 2, 11, '2026-09-30 00:46:54', NULL),
(6, 2, 12, '2026-09-30 00:47:00', NULL),
(7, 2, 16, '2026-10-01 11:12:27', NULL),
(8, 2, 17, '2026-10-01 12:17:33', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_historico_interacao`
--

CREATE TABLE `tb_historico_interacao` (
  `id_historico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `tp_interacao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_imagem_denuncia`
--

CREATE TABLE `tb_imagem_denuncia` (
  `id_imagem_denuncia` int(11) NOT NULL,
  `id_denuncia` int(11) NOT NULL,
  `ds_imagem` varchar(255) NOT NULL,
  `nr_ordem` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_imagem_denuncia`
--

INSERT INTO `tb_imagem_denuncia` (`id_imagem_denuncia`, `id_denuncia`, `ds_imagem`, `nr_ordem`, `created_at`, `updated_at`) VALUES
(1, 1, '1/MsQzGqHJ5Q2wzMtL0dTLtdgqZS6oBWtellajh62z.jpg', 1, '2026-09-30 22:39:56', '2026-09-30 22:39:56'),
(2, 1, '1/EMdc8LiZojVaAXwjF4WK6Ij5C5T3f68tdwaepbnz.jpg', 2, '2026-09-30 22:39:56', '2026-09-30 22:39:56'),
(3, 1, '1/2VFLel5xfFUVC8FGjpUMvJMflv71oEPLvC6X5xXr.jpg', 3, '2026-09-30 22:39:56', '2026-09-30 22:39:56'),
(4, 2, '2/lrECisR1KJvT32BVoeVi8kW9ExtZSXhrKINrOGjj.jpg', 1, '2026-10-01 11:15:37', '2026-10-01 11:15:37'),
(5, 2, '2/YJTHVBBoT9OlEsroUviPW4Wn8X4iROYMlKaO5N6N.jpg', 2, '2026-10-01 11:15:37', '2026-10-01 11:15:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_imagem_produto`
--

CREATE TABLE `tb_imagem_produto` (
  `id_imagem` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `ds_imagem` varchar(255) NOT NULL,
  `nr_ordem` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_imagem_produto`
--

INSERT INTO `tb_imagem_produto` (`id_imagem`, `id_produto`, `ds_imagem`, `nr_ordem`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/s0clisGKVPcju7TeL2EjV0OkQuhELEmosVVZwHqs.jpg', 1, '2026-09-23 17:20:16', '2026-09-23 17:20:16'),
(2, 2, 'products/AMfEw9RfGt0GzYU7jw9hCAYTY2atAEaDuCzgYV2a.jpg', 1, '2026-09-23 17:28:21', '2026-09-23 17:28:21'),
(3, 3, 'products/eEpFfNCnGTLotPkpQQxOB7ysA2qDV1MRAk91pXkU.jpg', 1, '2026-09-23 17:32:08', '2026-09-23 17:32:08'),
(4, 4, 'products/qGNesH7HWi4gixa96HjoKZrTdFbhgLRhpM5EGBrA.jpg', 1, '2026-09-23 17:40:23', '2026-09-23 17:40:23'),
(5, 5, 'products/HoR1mrFyGg3vZ7AQbCo2h6xmzx2oUlnv24rpCQ0V.jpg', 1, '2026-09-23 17:42:54', '2026-09-23 17:42:54'),
(6, 6, 'products/lZJ2fXI3FfJGdTLINYhRNNzjhC9JsRcP2mjQX4fh.jpg', 1, '2026-09-24 01:10:33', '2026-09-24 01:10:33'),
(7, 7, 'products/ChQ9ITlgZM51D7iCjeny0vEtOT9WIcKAsJVyjB23.jpg', 1, '2026-09-24 01:12:02', '2026-09-24 01:12:02'),
(8, 8, 'products/BmaPkCtQv3kcG2ErWLgBSPW5GEV3WlkjYrfKe6MT.jpg', 1, '2026-09-25 14:39:01', '2026-09-25 14:39:01'),
(9, 9, 'products/qUvQHqtTfwYqLhxloP5CeRCwfakvL6Tv8LlrbNpD.jpg', 1, '2026-09-25 14:53:56', '2026-09-25 14:53:56'),
(10, 10, 'products/AyeJipoSaHBDYfGsaDoDOLmYG0Fd4Cb9EuQ5WrpY.jpg', 1, '2026-09-25 14:59:01', '2026-09-25 14:59:01'),
(11, 11, 'products/tAeX74HkRiFlkdMjH4Y2OiaBu1szAg5biQdNHM1h.jpg', 1, '2026-09-25 15:02:57', '2026-09-25 15:02:57'),
(12, 12, 'products/GaXJqOTPezuhT6fIVzGRXEi16hQdi4JRUc0FqTeS.jpg', 1, '2026-09-25 15:04:46', '2026-09-25 15:04:46'),
(13, 13, 'products/DySuvNNn5lKYmcBnLitwYxtpB426UpWNykNb7bTK.jpg', 1, '2026-09-25 15:51:07', '2026-09-25 15:51:07'),
(14, 14, 'products/TD9guXS7EcARXZQ8gYW7LQvFqHPhTkrofbxEo538.jpg', 1, '2026-09-27 15:24:06', '2026-09-27 15:24:06'),
(15, 15, 'products/YamSErEkSoy0F5sPLhT71jkhxJ96tc7pB45qO2CH.jpg', 1, '2026-09-29 12:10:34', '2026-09-29 12:10:34'),
(16, 16, 'products/QZdegNKvnPELOaezilXIV0q32Av3PzDV37Pj9Eru.jpg', 1, '2026-09-30 21:38:52', '2026-09-30 21:38:52'),
(17, 16, 'products/hktCbZ5jPPKT3TzwnJWzUCC8qc4IQQOxaWW9lExA.jpg', 2, '2026-09-30 21:38:52', '2026-09-30 21:38:52'),
(18, 16, 'products/vZoL29eQk0Bdbcu6EutwRLIrwlkwJVMRxThAEYFX.jpg', 3, '2026-09-30 21:38:52', '2026-09-30 21:38:52'),
(19, 16, 'products/VyKZgcBEnbhXUZU0n7ALceVFRMv48s3tPGBcmjlM.jpg', 4, '2026-09-30 21:38:52', '2026-09-30 21:38:52'),
(20, 17, 'products/loX0BxsSc6SJGV5lF6On0WlP2zcxbS9p1i9R5a21.jpg', 1, '2026-10-01 11:32:43', '2026-10-01 11:32:43'),
(21, 17, 'products/ewfX7ays6dwRi6jzId1TA9vOR84BNu6RKUqpmxRf.jpg', 2, '2026-10-01 11:32:43', '2026-10-01 11:32:43'),
(22, 17, 'products/kPTV7OBBJQTkOCAOAVYHvwfU48EEw7prJyGhWwLk.jpg', 3, '2026-10-01 11:32:43', '2026-10-01 11:32:43'),
(23, 17, 'products/nG8VJbdvsKzurI1lMwrkGJ8KhhJsUHa2P25kCbCR.jpg', 4, '2026-10-01 11:32:43', '2026-10-01 11:32:43'),
(24, 17, 'products/OokzhoagBS9yKTeJNsnT4MJYWepJzLRwiDCRLOtP.jpg', 5, '2026-10-01 11:32:43', '2026-10-01 11:32:43'),
(25, 18, 'products/MrRvxI5qR4yGsIOAzjlwXvBQ3mG9FEa8bZ9mV0bC.webp', 1, '2026-10-12 13:13:30', '2026-10-12 13:13:30'),
(26, 19, 'products/tfMauZDAbblpFdLPI5yGQzM4CfpMqBK4ZA39rYLA.webp', 1, '2026-10-12 14:33:00', '2026-10-12 14:33:00'),
(27, 20, 'products/lpwlYlfnlF9VJv6ZPNHnUhwWO8T4rGeEezE7ISYH.webp', 1, '2026-10-13 22:46:12', '2026-10-13 22:46:12'),
(28, 21, 'products/GTgHwSw6h1tPHQ11cE6C3tlyBt4cJfqXwQq6to8a.jpg', 1, '2026-10-13 23:51:56', '2026-10-13 23:51:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_item_proposta`
--

CREATE TABLE `tb_item_proposta` (
  `id_item_proposta` int(11) NOT NULL,
  `id_proposta` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `tp_item` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_item_proposta`
--

INSERT INTO `tb_item_proposta` (`id_item_proposta`, `id_proposta`, `id_produto`, `tp_item`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 'O', '2026-09-30 11:37:07', '2026-09-30 11:37:07'),
(2, 1, 12, 'D', '2026-09-30 11:37:07', '2026-09-30 11:37:07'),
(3, 2, 4, 'O', '2026-09-30 11:37:29', '2026-09-30 11:37:29'),
(4, 2, 2, 'D', '2026-09-30 11:37:29', '2026-09-30 11:37:29'),
(5, 3, 16, 'O', '2026-09-30 21:40:52', '2026-09-30 21:40:52'),
(6, 3, 9, 'D', '2026-09-30 21:40:52', '2026-09-30 21:40:52'),
(7, 4, 18, 'O', '2026-10-12 13:14:20', '2026-10-12 13:14:20'),
(8, 4, 17, 'D', '2026-10-12 13:14:20', '2026-10-12 13:14:20'),
(9, 5, 18, 'O', '2026-10-12 13:30:49', '2026-10-12 13:30:49'),
(10, 5, 13, 'D', '2026-10-12 13:30:49', '2026-10-12 13:30:49'),
(11, 6, 19, 'O', '2026-10-13 19:38:17', '2026-10-13 19:38:17'),
(12, 6, 11, 'D', '2026-10-13 19:38:17', '2026-10-13 19:38:17'),
(13, 7, 17, 'O', '2026-10-13 20:13:38', '2026-10-13 20:13:38'),
(14, 7, 18, 'D', '2026-10-13 20:13:38', '2026-10-13 20:13:38'),
(15, 8, 21, 'O', '2026-10-13 23:52:32', '2026-10-13 23:52:32'),
(16, 8, 20, 'D', '2026-10-13 23:52:32', '2026-10-13 23:52:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_mensagem`
--

CREATE TABLE `tb_mensagem` (
  `id_mensagem` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_proposta` int(11) NOT NULL,
  `ds_mensagem` text NOT NULL DEFAULT '',
  `ds_imagem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_mensagem`
--

INSERT INTO `tb_mensagem` (`id_mensagem`, `id_usuario`, `id_proposta`, `ds_mensagem`, `ds_imagem`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 'oiee', NULL, '2026-10-13 19:41:34', '2026-10-13 19:41:34'),
(2, 10, 6, 'oikkkk', NULL, '2026-10-13 19:47:59', '2026-10-13 19:47:59'),
(3, 10, 8, 'e aí mano qual a fita', NULL, '2026-10-13 23:53:45', '2026-10-13 23:53:45'),
(4, 10, 8, 'de boa', NULL, '2026-10-13 23:53:50', '2026-10-13 23:53:50'),
(5, 11, 8, 'de boa cara', NULL, '2026-10-13 23:55:07', '2026-10-13 23:55:07'),
(6, 11, 8, 'to precisando de uma peça que voce tem', NULL, '2026-10-13 23:55:24', '2026-10-13 23:55:24'),
(7, 11, 8, 'como faz', NULL, '2026-10-13 23:55:33', '2026-10-13 23:55:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_notificacao`
--

CREATE TABLE `tb_notificacao` (
  `id_notificacao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ds_notificacao` varchar(255) NOT NULL,
  `st_visualizada` char(1) NOT NULL,
  `st_push` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nm_produto` varchar(100) NOT NULL,
  `ds_produto` varchar(255) DEFAULT NULL,
  `st_condicao` char(1) NOT NULL,
  `st_status` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `id_usuario`, `id_categoria`, `nm_produto`, `ds_produto`, `st_condicao`, `st_status`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'Câmera Fotográfica Y2K', 'Câmera linda e super bem cuidada, perfeita para quem gosta de registrar momentos e criar fotos incríveis. Está funcionando direitinho e pronta para ganhar um novo dono.', 'U', 'A', '2026-09-23 17:20:15', '2026-09-29 12:08:12'),
(2, 2, 4, 'Pendrive ou MP3 Pink', 'Pendrive ou MP3 na cor pink, lindo e delicado, perfeito para quem ama acessórios fofos e estilosos. Troco por algo legal e que seja do meu interesse.', 'U', 'A', '2026-09-23 17:28:20', '2026-09-23 17:41:44'),
(3, 4, 9, 'Kit Rosa Delicado', 'Kit com várias coisinhas lindas em tons de rosa-claro, delicadas e super fofas. Perfeito para quem ama itens charmosos. Troco por algo que me interesse!!', 'U', 'A', '2026-09-23 17:32:08', '2026-09-23 17:41:48'),
(4, 5, 9, 'Drone Explorador', 'Drone bonito e moderno, perfeito para quem curte registrar lugares e momentos de um ângulo diferente. Nunca usei ele, disponível para troca por algo maneiro que me interesse.', 'N', 'A', '2026-09-23 17:40:23', '2026-09-23 18:30:40'),
(5, 5, 6, 'Impressora para Adesivos Fofos', 'Impressora em ótimo estado, perfeita para imprimir adesivos fofos, personalizados e coloridos. Ideal para quem ama papelaria criativa e projetos personalizados. Troco por algo legal!', 'S', 'A', '2026-09-23 17:42:54', '2026-09-23 17:41:53'),
(6, 3, 5, 'Carregador Personalizado', 'Carregador personalizado com detalhes de coração, super delicado e diferente. Perfeito para quem ama acessórios fofos e cheios de personalidade. Disponível para troca!', 'U', 'A', '2026-09-24 01:10:33', '2026-09-24 01:10:33'),
(7, 3, 7, 'Nintendo Wii Novo', 'Nintendo Wii em estado de novo, super conservado e funcionando perfeitamente. Ótimo para jogar com amigos e família e curtir vários clássicos. Disponível para troca por algo interessante!', 'N', 'A', '2026-09-24 01:12:02', '2026-09-29 12:08:02'),
(8, 7, 2, 'notebook', 'Notebook seminovo, ideal para estudar, navegar na internet e jogar Minecraft com bom desempenho. Uma boa opção para quem busca um computador para o dia a dia e momentos de diversão. Disponível para troca!', 'S', 'A', '2026-09-25 14:39:00', '2026-09-29 12:07:54'),
(9, 5, 3, 'Celular iPhone 8 roxo do MIN', 'iPhone para quem busca praticidade no dia a dia, seja para acessar redes sociais, tirar fotos ou conversar. Disponível para troca! Entre em contato para saber mais sobre o aparelho e combinar uma proposta.', 'N', 'A', '2026-09-25 14:53:56', '2026-09-25 14:53:56'),
(10, 2, 1, 'Placa de Vídeo', 'Placa de vídeo disponível para troca por outras peças eletrônicas. Entre em contato para conferir o modelo, as especificações e a compatibilidade com seu computador. Aceito propostas!', 'U', 'A', '2026-09-25 14:59:01', '2026-09-25 14:59:01'),
(11, 2, 3, 'Celular da Coraline', 'Quero trocar meu celular personalizado por outro modelo. Gosto muito dele, mas está na hora de mudar!', 'U', 'T', '2026-09-25 15:02:57', '2026-10-13 20:07:50'),
(12, 5, 3, 'Celular do Homem Aranha', 'Estou querendo trocar meu celular personalizado do Homem-Aranha por outro modelo. Quem tiver interesse, pode mandar uma proposta!', 'U', 'A', '2026-09-25 15:04:46', '2026-09-29 12:07:43'),
(13, 7, 3, 'Celular Quebrado', 'celular quebrado', 'Q', 'A', '2026-09-25 15:51:07', '2026-09-25 15:51:07'),
(14, 8, 3, 'LLL', NULL, 'U', 'A', '2026-09-27 15:24:05', '2026-09-29 12:07:51'),
(15, 2, 3, 'celular comido', 'estava com fome', 'Q', 'A', '2026-09-29 12:10:34', '2026-09-29 14:09:41'),
(16, 2, 9, 'Memes', 'humor quebrado', 'Q', 'A', '2026-09-30 21:38:52', '2026-09-30 21:38:52'),
(17, 2, 3, 'celularzinhos', NULL, 'S', 'T', '2026-10-01 11:32:43', '2026-10-13 20:16:20'),
(18, 10, 2, 'computadorzinho', 'quero celular', 'N', 'T', '2026-10-12 13:13:28', '2026-10-13 20:16:20'),
(19, 10, 3, 'celular', 'é', 'S', 'T', '2026-10-12 14:32:59', '2026-10-13 20:07:50'),
(20, 10, 7, 'videogame', NULL, 'S', 'T', '2026-10-13 22:46:09', '2026-10-13 23:59:19'),
(21, 11, 3, 'peças de celular', 'dependendo do rolo eu to dentro', 'U', 'T', '2026-10-13 23:51:56', '2026-10-13 23:59:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_proposta`
--

CREATE TABLE `tb_proposta` (
  `id_proposta` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `st_troca` char(1) NOT NULL,
  `ds_local_troca` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `st_confirmacao_solicitante` char(1) NOT NULL DEFAULT 'N',
  `st_confirmacao_destinatario` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_proposta`
--

INSERT INTO `tb_proposta` (`id_proposta`, `id_solicitante`, `id_destinatario`, `st_troca`, `ds_local_troca`, `created_at`, `updated_at`, `st_confirmacao_solicitante`, `st_confirmacao_destinatario`) VALUES
(1, 2, 5, 'R', NULL, '2026-09-30 11:37:07', '2026-09-30 11:39:51', 'N', 'N'),
(2, 5, 2, 'A', NULL, '2026-09-30 11:37:29', '2026-09-30 11:39:07', 'N', 'N'),
(3, 2, 5, 'P', NULL, '2026-09-30 21:40:52', '2026-09-30 21:40:52', 'N', 'N'),
(4, 10, 2, 'P', NULL, '2026-10-12 13:14:20', '2026-10-12 13:14:20', 'N', 'N'),
(5, 10, 7, 'P', NULL, '2026-10-12 13:30:49', '2026-10-12 13:30:49', 'N', 'N'),
(6, 10, 2, 'F', NULL, '2026-10-13 19:38:17', '2026-10-13 20:07:50', 'S', 'S'),
(7, 2, 10, 'F', NULL, '2026-10-13 20:13:38', '2026-10-13 20:16:20', 'S', 'S'),
(8, 11, 10, 'F', NULL, '2026-10-13 23:52:32', '2026-10-13 23:59:19', 'S', 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `nm_usuario` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tp_usuario` char(1) NOT NULL,
  `st_usuario` char(1) NOT NULL,
  `st_email_verificado` char(1) NOT NULL,
  `ds_foto_perfil` varchar(255) DEFAULT NULL,
  `ds_usuario` text DEFAULT NULL,
  `ds_banner` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `nm_usuario`, `email`, `password`, `tp_usuario`, `st_usuario`, `st_email_verificado`, `ds_foto_perfil`, `ds_usuario`, `ds_banner`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$bAWYhz96rg7dxVOwYmBwxeWM6qFUj1MIJRgrsQzudh1FvfY5LVkD6', 'A', 'A', 'N', 'usuarios/perfis/Ji9Uv6PtQfeOSD7HByv9dTnqPRDqn3tm0FW6jxA0.jpg', 'Qual é o seu filme de terror favorito?', 'usuarios/banners/odusdEa55DDgv9HGPCsCn0CIcQbro500lKovNMDZ.jpg', NULL, '2026-09-23 16:46:59', '2026-09-23 17:23:38'),
(2, 'Coraline', 'coraline@gmail.com', '$2y$12$Mr6kzL7hsWkhxeWd28V6B.8ql0jPgtihjCyZTWVzTvE1wOx3giKsS', 'C', 'A', '0', 'usuarios/perfis/abvBf85yXd1SO46v8fFI2vueWqGuPBiXzX5XSsec.jpg', 'Eu atravessei a porta. Agora preciso encontrar o caminho de volta.', 'usuarios/banners/ORVclQEgzUC6YDi5odV8Zi2ujkEGswDrc2KFzL7S.jpg', NULL, '2026-09-23 17:24:17', '2026-10-13 21:52:55'),
(3, 'Dog', 'dog@gmail.com', '$2y$12$PisCYdcvtKBysMyRKZu3R.m/Fln3zOsudtdqkf4b7sKFA4GmGdKBe', '', '', '', 'usuarios/perfis/n0yXgYKJbcOp0XkMldO929FBbSxBQcEktJgFq2lm.jpg', 'só apareço quando tenho algo pra falar\r\n#sp #music #pop #games #random', 'usuarios/banners/t4f6AhDNYpnbTKyTPmwV83L6g0io2ijQbpPpRhwx.jpg', NULL, '2026-09-23 21:33:01', '2026-09-23 22:02:26'),
(4, 'Miau', 'miau@gmail.com', '$2y$12$U7LPmL3nd0fRCav1IHw4I.4.VQ2N7ZKuScD7e/Rk.6uGE8GPQGHxy', 'C', 'A', 'N', 'usuarios/perfis/YvbHPCxWNMUoeqA9hxi8MHavLvFXFuSoAREHA6Ql.jpg', 'Sou a Gatinha Marie super fofa, com meu clássico lacinho da Disney. sou linda e delicada. Troco meus itens por algo legal e do meu interesse!', 'usuarios/banners/qmjpvQZ0KSvLHVazMEILbtsJtXqwJ4VHFbrsC107.jpg', NULL, '2026-09-23 17:30:32', '2026-09-23 17:33:29'),
(5, 'Homem Aranha', 'homemaranha@gmail.com', '$2y$12$MxTUR/CwoO4pGQlt22plxOEfbCBPkfTVseUkAbxKMzOTmqcpMToDu', 'C', 'A', 'N', 'usuarios/perfis/wxcuxhn3ZLST9NnI25OLavfJsDAjL4ml7WfvBuMD.jpg', 'entre prédios, teias e algumas escolhas questionáveis. sempre procurando algo incrível para trocar e, quem sabe, uma nova aventura para chamar de minha.', 'usuarios/banners/iYKK0PTk175DvlKf4gorOohf5TS5hU67BgbJz6D8.jpg', NULL, '2026-09-23 17:37:33', '2026-09-23 17:38:16'),
(6, 'Investigador L', 'deathnote@gmail.com', '$2y$12$bAWYhz96rg7dxVOwYmBwxeWM6qFUj1MIJRgrsQzudh1FvfY5LVkD6', 'C', 'A', 'N', 'usuarios/perfis/CUzjKIxbjVHDcgUOJsQFxG30b9j10JmOSrfxFlTj.jpg', 'Quanto menos você souber sobre mim, melhor. Eu já sei o suficiente sobre você.', 'usuarios/banners/fXw8TA0WzpWz0Rd062D3z1AxJvEq3RdabzjRN7xM.jpg', NULL, '2026-09-24 00:31:35', '2026-09-24 01:39:38'),
(7, 'aaaaaaaa', 'aaaaaaaa@gmail.com', '$2y$12$Cge93VLdWCY3tjchhu6twuwRtrpB/1Tue.6jX.J47T0KJ85ZlenKu', 'C', 'A', 'N', NULL, NULL, NULL, NULL, '2026-09-24 03:12:54', '2026-09-25 14:45:26'),
(8, 'Simone', 'simone@gmail.com', '$2y$12$peYcz/emONBzE1MRzGp0uOzL8LG9rYitIOJYz6q3uf5zDer0LHhzu', 'C', 'A', 'N', 'usuarios/perfis/X2sds8EPDr7rKCsnZRCFokuTH7ez0xk5toOl2dab.jpg', NULL, 'usuarios/banners/qHwBDKcLFhHdWBkRhzLr7krm60X7e9ms3C3TPMq1.jpg', NULL, '2026-09-27 15:21:09', '2026-09-27 15:49:57'),
(9, 'Thayna', 'thayadm@gmail.com', '$2y$12$qF/wITW6/fjIlps2I.oZoOLehwbl4/6FURPOkkynQDtd2nllNg6Gm', 'C', 'A', 'N', NULL, NULL, NULL, NULL, '2026-09-30 13:22:20', '2026-09-30 13:22:20'),
(10, 'miles', 'miles@gmail.com', '$2y$12$PlXw8rsseEukRh.OJzAqfuKGHK4YW/ZOrbeSJH1hORGLhZNqvzFvi', 'C', 'A', 'N', 'usuarios/perfis/ZLYaBJ4ye2HokreyWn5Beh2DXLmpR9k5GRrIwdYx.jpg', 'meu nome é Miles Morales fui picado por uma aranha radioativa e, há um ano e quatro meses, sou o único e exclusivo homem-aranha do brooklyn 🔥', 'usuarios/banners/dgrpAL4GidSymvrz58inESR3Uqo3R6VuBOfz6jG1.jpg', NULL, '2026-10-12 13:02:51', '2026-10-13 21:57:15'),
(11, 'gisele', 'gisele@gmail.com', '$2y$12$82y77vc2MZgJ46cVvWq4Ee0YSbFx6GU4J0jxf7QBR3tfMfzVwHOyC', 'C', 'A', 'N', 'usuarios/perfis/TjMGB8UDT5GfXZ39uMOinaBuLAiV2ou3GpFRq1gp.jpg', 'sou uma empresaria de sucesso no ramo da eletronica', 'usuarios/banners/816FYnPRte48kO3lDERpRENdIfWVkp4pZ0AXmD4j.jpg', NULL, '2026-10-13 23:43:29', '2026-10-13 23:48:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD PRIMARY KEY (`id_denuncia`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `idx_denuncia_usuario_denunciado` (`id_usuario_denunciado`);

--
-- Índices de tabela `tb_favorito`
--
ALTER TABLE `tb_favorito`
  ADD PRIMARY KEY (`id_favorito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  ADD PRIMARY KEY (`id_historico`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `tb_imagem_denuncia`
--
ALTER TABLE `tb_imagem_denuncia`
  ADD PRIMARY KEY (`id_imagem_denuncia`),
  ADD KEY `idx_imagem_denuncia` (`id_denuncia`);

--
-- Índices de tabela `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  ADD PRIMARY KEY (`id_item_proposta`),
  ADD KEY `id_proposta` (`id_proposta`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_proposta` (`id_proposta`);

--
-- Índices de tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  ADD PRIMARY KEY (`id_notificacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `tb_proposta`
--
ALTER TABLE `tb_proposta`
  ADD PRIMARY KEY (`id_proposta`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  MODIFY `id_denuncia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_favorito`
--
ALTER TABLE `tb_favorito`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_imagem_denuncia`
--
ALTER TABLE `tb_imagem_denuncia`
  MODIFY `id_imagem_denuncia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  MODIFY `id_item_proposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  MODIFY `id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tb_proposta`
--
ALTER TABLE `tb_proposta`
  MODIFY `id_proposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD CONSTRAINT `tb_avaliacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_avaliacao_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Restrições para tabelas `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD CONSTRAINT `tb_denuncia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_denuncia_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Restrições para tabelas `tb_favorito`
--
ALTER TABLE `tb_favorito`
  ADD CONSTRAINT `tb_favorito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_favorito_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  ADD CONSTRAINT `tb_historico_interacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_historico_interacao_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Restrições para tabelas `tb_imagem_denuncia`
--
ALTER TABLE `tb_imagem_denuncia`
  ADD CONSTRAINT `fk_imagem_denuncia` FOREIGN KEY (`id_denuncia`) REFERENCES `tb_denuncia` (`id_denuncia`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  ADD CONSTRAINT `tb_imagem_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  ADD CONSTRAINT `tb_item_proposta_ibfk_1` FOREIGN KEY (`id_proposta`) REFERENCES `tb_proposta` (`id_proposta`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_item_proposta_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Restrições para tabelas `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD CONSTRAINT `tb_mensagem_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_mensagem_ibfk_2` FOREIGN KEY (`id_proposta`) REFERENCES `tb_proposta` (`id_proposta`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  ADD CONSTRAINT `tb_notificacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_produto_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`);

--
-- Restrições para tabelas `tb_proposta`
--
ALTER TABLE `tb_proposta`
  ADD CONSTRAINT `tb_proposta_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_proposta_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `tb_usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
