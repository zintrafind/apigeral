-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Set-2026 às 02:16
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `peca_por_peca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
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
-- Estrutura da tabela `jobs`
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
-- Estrutura da tabela `job_batches`
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
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
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
-- Extraindo dados da tabela `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', 1, 'api-token', '746e240e7f6b5dd6c09e97382fd9f576d32cea4644856b994b90a05af8b7b817', '[\"*\"]', NULL, NULL, '2026-09-23 19:24:34', '2026-09-23 19:24:34'),
(13, 'App\\Models\\User', 4, 'api-token', '7713bdfcfb4c6cce79041494f75431f2d990df0f236af5b11908543e2122abc1', '[\"*\"]', '2026-09-24 00:30:55', NULL, '2026-09-23 21:38:07', '2026-09-24 00:30:55'),
(20, 'App\\Models\\User', 7, 'api-token', '41386343a24f20df1db260d459fafc333e57032411aa2f97ec4c67bb7508294b', '[\"*\"]', '2026-09-24 03:13:16', NULL, '2026-09-24 03:13:06', '2026-09-24 03:13:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessions`
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
-- Estrutura da tabela `tb_avaliacao`
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
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(100) NOT NULL,
  `ds_categoria` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_categoria`
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
-- Estrutura da tabela `tb_denuncia`
--

CREATE TABLE `tb_denuncia` (
  `id_denuncia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `ds_motivo` varchar(255) NOT NULL,
  `ds_denuncia` varchar(255) DEFAULT NULL,
  `st_denuncia` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_favorito`
--

CREATE TABLE `tb_favorito` (
  `id_favorito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_historico_interacao`
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
-- Estrutura da tabela `tb_imagem_produto`
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
-- Extraindo dados da tabela `tb_imagem_produto`
--

INSERT INTO `tb_imagem_produto` (`id_imagem`, `id_produto`, `ds_imagem`, `nr_ordem`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/s0clisGKVPcju7TeL2EjV0OkQuhELEmosVVZwHqs.jpg', 1, '2026-09-23 17:20:16', '2026-09-23 17:20:16'),
(2, 2, 'products/AMfEw9RfGt0GzYU7jw9hCAYTY2atAEaDuCzgYV2a.jpg', 1, '2026-09-23 17:28:21', '2026-09-23 17:28:21'),
(3, 3, 'products/eEpFfNCnGTLotPkpQQxOB7ysA2qDV1MRAk91pXkU.jpg', 1, '2026-09-23 17:32:08', '2026-09-23 17:32:08'),
(4, 4, 'products/qGNesH7HWi4gixa96HjoKZrTdFbhgLRhpM5EGBrA.jpg', 1, '2026-09-23 17:40:23', '2026-09-23 17:40:23'),
(5, 5, 'products/HoR1mrFyGg3vZ7AQbCo2h6xmzx2oUlnv24rpCQ0V.jpg', 1, '2026-09-23 17:42:54', '2026-09-23 17:42:54'),
(6, 6, 'products/lZJ2fXI3FfJGdTLINYhRNNzjhC9JsRcP2mjQX4fh.jpg', 1, '2026-09-24 01:10:33', '2026-09-24 01:10:33'),
(7, 7, 'products/ChQ9ITlgZM51D7iCjeny0vEtOT9WIcKAsJVyjB23.jpg', 1, '2026-09-24 01:12:02', '2026-09-24 01:12:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_item_proposta`
--

CREATE TABLE `tb_item_proposta` (
  `id_item_proposta` int(11) NOT NULL,
  `id_proposta` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `tp_item` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_mensagem`
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_notificacao`
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
-- Estrutura da tabela `tb_produto`
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
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `id_usuario`, `id_categoria`, `nm_produto`, `ds_produto`, `st_condicao`, `st_status`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'Câmera Fotográfica Y2K', 'Câmera linda e super bem cuidada, perfeita para quem gosta de registrar momentos e criar fotos incríveis. Está funcionando direitinho e pronta para ganhar um novo dono.', 'U', 'A', '2026-09-23 17:20:15', '2026-09-23 17:20:15'),
(2, 2, 4, 'Pendrive ou MP3 Pink', 'Pendrive ou MP3 na cor pink, lindo e delicado, perfeito para quem ama acessórios fofos e estilosos. Troco por algo legal e que seja do meu interesse.', 'U', 'A', '2026-09-23 17:28:20', '2026-09-23 17:41:44'),
(3, 4, 9, 'Kit Rosa Delicado', 'Kit com várias coisinhas lindas em tons de rosa-claro, delicadas e super fofas. Perfeito para quem ama itens charmosos. Troco por algo que me interesse!!', 'U', 'A', '2026-09-23 17:32:08', '2026-09-23 17:41:48'),
(4, 5, 9, 'Drone Explorador', 'Drone bonito e moderno, perfeito para quem curte registrar lugares e momentos de um ângulo diferente. Nunca usei ele, disponível para troca por algo maneiro que me interesse.', 'N', 'A', '2026-09-23 17:40:23', '2026-09-23 18:30:40'),
(5, 5, 6, 'Impressora para Adesivos Fofos', 'Impressora em ótimo estado, perfeita para imprimir adesivos fofos, personalizados e coloridos. Ideal para quem ama papelaria criativa e projetos personalizados. Troco por algo legal!', 'S', 'A', '2026-09-23 17:42:54', '2026-09-23 17:41:53'),
(6, 3, 5, 'Carregador Personalizado', 'Carregador personalizado com detalhes de coração, super delicado e diferente. Perfeito para quem ama acessórios fofos e cheios de personalidade. Disponível para troca!', 'U', 'A', '2026-09-24 01:10:33', '2026-09-24 01:10:33'),
(7, 3, 7, 'Nintendo Wii Novo', 'Nintendo Wii em estado de novo, super conservado e funcionando perfeitamente. Ótimo para jogar com amigos e família e curtir vários clássicos. Disponível para troca por algo interessante!', 'N', 'A', '2026-09-24 01:12:02', '2026-09-24 01:12:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_proposta`
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
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
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `nm_usuario`, `email`, `password`, `tp_usuario`, `st_usuario`, `st_email_verificado`, `ds_foto_perfil`, `ds_usuario`, `ds_banner`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$bAWYhz96rg7dxVOwYmBwxeWM6qFUj1MIJRgrsQzudh1FvfY5LVkD6', 'A', 'A', 'N', 'usuarios/perfis/Ji9Uv6PtQfeOSD7HByv9dTnqPRDqn3tm0FW6jxA0.jpg', 'Qual é o seu filme de terror favorito?', 'usuarios/banners/odusdEa55DDgv9HGPCsCn0CIcQbro500lKovNMDZ.jpg', NULL, '2026-09-23 16:46:59', '2026-09-23 17:23:38'),
(2, 'Coraline', 'coraline@gmail.com', '$2y$12$Mr6kzL7hsWkhxeWd28V6B.8ql0jPgtihjCyZTWVzTvE1wOx3giKsS', 'C', 'A', 'N', 'usuarios/perfis/abvBf85yXd1SO46v8fFI2vueWqGuPBiXzX5XSsec.jpg', 'Eu atravessei a porta. Agora preciso encontrar o caminho de volta.', 'usuarios/banners/ORVclQEgzUC6YDi5odV8Zi2ujkEGswDrc2KFzL7S.jpg', NULL, '2026-09-23 17:24:17', '2026-09-23 17:26:15'),
(3, 'Dog', 'dog@gmail.com', '$2y$12$PisCYdcvtKBysMyRKZu3R.m/Fln3zOsudtdqkf4b7sKFA4GmGdKBe', '', '', '', 'usuarios/perfis/n0yXgYKJbcOp0XkMldO929FBbSxBQcEktJgFq2lm.jpg', 'só apareço quando tenho algo pra falar\r\n#sp #music #pop #games #random', 'usuarios/banners/t4f6AhDNYpnbTKyTPmwV83L6g0io2ijQbpPpRhwx.jpg', NULL, '2026-09-23 21:33:01', '2026-09-23 22:02:26'),
(4, 'Miau', 'miau@gmail.com', '$2y$12$U7LPmL3nd0fRCav1IHw4I.4.VQ2N7ZKuScD7e/Rk.6uGE8GPQGHxy', 'C', 'A', 'N', 'usuarios/perfis/YvbHPCxWNMUoeqA9hxi8MHavLvFXFuSoAREHA6Ql.jpg', 'Sou a Gatinha Marie super fofa, com meu clássico lacinho da Disney. sou linda e delicada. Troco meus itens por algo legal e do meu interesse!', 'usuarios/banners/qmjpvQZ0KSvLHVazMEILbtsJtXqwJ4VHFbrsC107.jpg', NULL, '2026-09-23 17:30:32', '2026-09-23 17:33:29'),
(5, 'Homem Aranha', 'homemaranha@gmail.com', '$2y$12$MxTUR/CwoO4pGQlt22plxOEfbCBPkfTVseUkAbxKMzOTmqcpMToDu', 'C', 'A', 'N', 'usuarios/perfis/wxcuxhn3ZLST9NnI25OLavfJsDAjL4ml7WfvBuMD.jpg', 'entre prédios, teias e algumas escolhas questionáveis. sempre procurando algo incrível para trocar e, quem sabe, uma nova aventura para chamar de minha.', 'usuarios/banners/iYKK0PTk175DvlKf4gorOohf5TS5hU67BgbJz6D8.jpg', NULL, '2026-09-23 17:37:33', '2026-09-23 17:38:16'),
(6, 'Investigador L', 'deathnote@gmail.com', '$2y$12$bAWYhz96rg7dxVOwYmBwxeWM6qFUj1MIJRgrsQzudh1FvfY5LVkD6', 'C', 'A', 'N', 'usuarios/perfis/CUzjKIxbjVHDcgUOJsQFxG30b9j10JmOSrfxFlTj.jpg', 'Quanto menos você souber sobre mim, melhor. Eu já sei o suficiente sobre você.', 'usuarios/banners/fXw8TA0WzpWz0Rd062D3z1AxJvEq3RdabzjRN7xM.jpg', NULL, '2026-09-24 00:31:35', '2026-09-24 01:39:38'),
(7, 'aaaaaaaa@gmail.com', 'aaaaaaaa@gmail.com', '$2y$12$Cge93VLdWCY3tjchhu6twuwRtrpB/1Tue.6jX.J47T0KJ85ZlenKu', 'C', 'A', 'N', NULL, NULL, NULL, NULL, '2026-09-24 03:12:54', '2026-09-24 03:12:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
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
-- Índices para tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Índices para tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Índices para tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices para tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Índices para tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices para tabela `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD PRIMARY KEY (`id_denuncia`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_favorito`
--
ALTER TABLE `tb_favorito`
  ADD PRIMARY KEY (`id_favorito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  ADD PRIMARY KEY (`id_historico`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  ADD PRIMARY KEY (`id_item_proposta`),
  ADD KEY `id_proposta` (`id_proposta`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_proposta` (`id_proposta`);

--
-- Índices para tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  ADD PRIMARY KEY (`id_notificacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices para tabela `tb_proposta`
--
ALTER TABLE `tb_proposta`
  ADD PRIMARY KEY (`id_proposta`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id_denuncia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_favorito`
--
ALTER TABLE `tb_favorito`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  MODIFY `id_item_proposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  MODIFY `id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_proposta`
--
ALTER TABLE `tb_proposta`
  MODIFY `id_proposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD CONSTRAINT `tb_avaliacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_avaliacao_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Limitadores para a tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD CONSTRAINT `tb_denuncia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_denuncia_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Limitadores para a tabela `tb_favorito`
--
ALTER TABLE `tb_favorito`
  ADD CONSTRAINT `tb_favorito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_favorito_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tb_historico_interacao`
--
ALTER TABLE `tb_historico_interacao`
  ADD CONSTRAINT `tb_historico_interacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_historico_interacao_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Limitadores para a tabela `tb_imagem_produto`
--
ALTER TABLE `tb_imagem_produto`
  ADD CONSTRAINT `tb_imagem_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tb_item_proposta`
--
ALTER TABLE `tb_item_proposta`
  ADD CONSTRAINT `tb_item_proposta_ibfk_1` FOREIGN KEY (`id_proposta`) REFERENCES `tb_proposta` (`id_proposta`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_item_proposta_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Limitadores para a tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD CONSTRAINT `tb_mensagem_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_mensagem_ibfk_2` FOREIGN KEY (`id_proposta`) REFERENCES `tb_proposta` (`id_proposta`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  ADD CONSTRAINT `tb_notificacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_produto_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`);

--
-- Limitadores para a tabela `tb_proposta`
--
ALTER TABLE `tb_proposta`
  ADD CONSTRAINT `tb_proposta_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `tb_usuario` (`id_usuario`),
  ADD CONSTRAINT `tb_proposta_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `tb_usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
