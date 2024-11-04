-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/11/2024 às 00:40
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
-- Banco de dados: `adote_pet3`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `doacoes`
--

CREATE TABLE `doacoes` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `endereco_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doacoes`
--

INSERT INTO `doacoes` (`id`, `pet_id`, `usuario_id`, `data`, `criado_em`, `endereco_id`) VALUES
(1, 1, 1, '2024-10-09', '2024-10-09 02:30:23', 21),
(2, 2, 1, '2024-10-09', '2024-10-09 02:34:15', 21),
(3, 3, 1, '2024-10-09', '2024-10-09 02:35:04', 21),
(4, 4, 2, '2024-10-09', '2024-10-09 02:59:59', 18),
(5, 5, 3, '2024-10-09', '2024-10-09 03:09:29', 20),
(6, 6, 2, '2024-10-09', '2024-10-09 04:16:01', 18),
(7, 7, 3, '2024-10-09', '2024-10-09 04:17:31', 20),
(8, 8, 2, '2024-10-12', '2024-10-11 23:55:39', 18),
(9, 9, 2, '2024-10-31', '2024-10-31 02:19:17', 18),
(10, 10, 2, '2024-10-31', '2024-10-31 02:26:56', 18),
(11, 11, 2, '2024-10-31', '2024-10-31 22:24:07', 18),
(13, 13, 50, '2024-11-01', '2024-11-01 14:22:00', 38),
(14, 14, 2, '2024-11-01', '2024-11-01 14:41:03', 18),
(15, 15, 2, '2024-11-04', '2024-11-04 14:29:12', 18),
(16, 16, 2, '2024-11-04', '2024-11-04 14:48:48', 18),
(17, 17, 3, '2024-11-04', '2024-11-04 22:13:09', 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `localidade` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `usuario_id`, `cep`, `logradouro`, `bairro`, `localidade`, `uf`, `estado`) VALUES
(2, 6, '70390-90', 'SHLS Conjunto A', 'Asa Sul', 'Brasília', 'DF', 'Distrito Federal'),
(3, 8, '69082-71', 'Rua Capitão Enéas', 'Coroado', 'Manaus', 'AM', ''),
(4, 9, '72410-23', 'Praça 3 Bloco A', 'Setor Sul (Gama)', 'Brasília', 'DF', ''),
(5, 10, '57312-02', 'Rua José Valentim dos Santos', 'Santa Esmeralda', 'Arapiraca', 'AL', ''),
(6, 11, '71697-04', 'Quadra 2 Conjunto 2', 'São Bartolomeu (São Sebastião)', 'Brasília', 'DF', ''),
(7, 12, '71884-758', 'Quadra QS 23 Conjunto 2', 'Riacho Fundo II', 'Brasília', 'DF', 'Distrito Federal'),
(13, 18, '72603102', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF', ''),
(18, 2, '72622-201', 'Quadra 309 Conjunto 1', 'Recanto das Emas', 'Brasília', 'DF', 'Distrito Federal'),
(20, 3, '71693-312', 'Quadra 12', 'São Francisco (São Sebastião)', 'Brasília', 'DF', 'Distrito Federal'),
(21, 1, '21381-450', 'Travessa Dezesseis de Maio', 'Quintino Bocaiúva', 'Rio de Janeiro', 'RJ', 'Rio de Janeiro'),
(22, 5, '71994-35', 'Conjunto SHA Conjunto 4 Chácara 63', 'Setor Habitacional Arniqueira (Águas Claras)', 'Brasília', 'DF', ''),
(23, 4, '70344-50', 'Quadra CLS 105', 'Asa Sul', 'Brasília', 'DF', ''),
(24, 25, '72156-21', 'Quadra QNL 12 Bloco I', 'Taguatinga Norte (Taguatinga)', 'Brasília', 'DF', ''),
(28, 1, '21381-450', 'Travessa Dezesseis de Maio', 'Quintino Bocaiúva', 'Rio de Janeiro', 'RJ', 'Rio de Janeiro'),
(32, 1, '21381-450', 'Travessa Dezesseis de Maio', 'Quintino Bocaiúva', 'Rio de Janeiro', 'RJ', 'Rio de Janeiro'),
(36, 48, '72603102', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF', 'Distrito Federal'),
(37, 49, '71995-280', 'Conjunto SHA Conjunto 5 Chácara 44', 'Setor Habitacional Arniqueira (Águas Claras)', 'Brasília', 'DF', 'Distrito Federal'),
(38, 50, '72460-245', 'Quadra 24 Comércio Local', 'Setor Leste (Gama)', 'Brasília', 'DF', 'Distrito Federal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especie`
--

CREATE TABLE `especie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `especie`
--

INSERT INTO `especie` (`id`, `nome`) VALUES
(1, 'Cachorro'),
(2, 'Gato');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `fotos`
--

INSERT INTO `fotos` (`id`, `nome`, `url`, `pet_id`) VALUES
(1, 'Golden Laranja.png', 'uploads/Golden Laranja.png', 1),
(5, 'Sphynx.png', 'uploads/Sphynx.png', 2),
(7, 'salsichapreto.png', 'uploads/salsichapreto.png', 3),
(8, 'Balinês - branco com preto.jpeg', 'uploads/Balinês - branco com preto.jpeg', 5),
(9, 'garo Persa.jpg', 'uploads/garo Persa.jpg', 6),
(10, 'pompom - gato laranja.jpg', 'uploads/pompom - gato laranja.jpg', 7),
(12, 'gata tricolor.png', 'uploads/gata tricolor.png', 9),
(13, 'viralata caramelo.jpg', 'uploads/viralata caramelo.jpg', 10),
(15, 'Border collie laranja com branco.jpg', 'uploads/Border collie laranja com branco.jpg', 12),
(16, 'Border collie laranja com branco.jpg', 'uploads/Border collie laranja com branco.jpg', 13),
(17, 'pug_preto_topo.png', 'uploads/pug_preto_topo.png', 11),
(19, 'doberman preto.png', 'uploads/doberman preto.png', 14),
(20, 'gato preto bombaim3.jpg', 'uploads/gato preto bombaim3.jpg', 15),
(21, 'gato preto bombaim2.jpg', 'uploads/gato preto bombaim2.jpg', 15),
(22, 'gato preto bombaim1.jpg', 'uploads/gato preto bombaim1.jpg', 15),
(23, 'Gato-laranja-filhote-3.jpg', 'uploads/Gato-laranja-filhote-3.jpg', 16),
(24, 'Gato-laranja-filhote-2.jpg', 'uploads/Gato-laranja-filhote-2.jpg', 16),
(25, 'Gato-laranja-filhote-1.jpg', 'uploads/Gato-laranja-filhote-1.jpg', 16),
(29, 'Gato-Bengal.jpg', 'uploads/Gato-Bengal.jpg', 8),
(30, 'husky siberiano.png', 'uploads/husky siberiano.png', 4),
(31, 'rusky2.jpeg', 'uploads/rusky2.jpeg', 4),
(32, 'rusky3.jpg', 'uploads/rusky3.jpg', 4),
(33, 'gatopreto3.png', 'uploads/gatopreto3.png', 17),
(34, 'gatopreto1.jpg', 'uploads/gatopreto1.jpg', 17),
(35, 'gatopreto2.png', 'uploads/gatopreto2.png', 17);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfis`
--

CREATE TABLE `perfis` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `perfis`
--

INSERT INTO `perfis` (`id`, `nome`) VALUES
(1, 'Funcionario'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `especie_id` int(11) NOT NULL,
  `raca` varchar(100) NOT NULL,
  `porte` varchar(50) NOT NULL,
  `sexo` enum('Macho','Fêmea') NOT NULL,
  `cor` varchar(50) NOT NULL,
  `idade` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pets`
--

INSERT INTO `pets` (`id`, `nome`, `especie_id`, `raca`, `porte`, `sexo`, `cor`, `idade`, `descricao`, `foto`, `criado_em`) VALUES
(1, 'Meg', 1, ' Golden retriever', 'Grande', 'Fêmea', 'Laranja', 5, 'Vacina, Vermifugado, Docil.', NULL, '2024-10-09 02:30:23'),
(2, 'Lili', 2, 'Sphynx', 'Médio', 'Macho', 'Tricolor', 2, 'Vacinas em dia.', NULL, '2024-10-09 02:34:15'),
(3, 'Baco', 1, ' Dachshund', 'Pequeno', 'Macho', 'Preto', 11, 'Vacinado', NULL, '2024-10-09 02:35:04'),
(4, 'Luna', 1, 'Husky siberiano', 'Grande', 'Macho', 'Preto e Branco', 6, 'Vacinas todas em dia.', NULL, '2024-10-09 02:59:59'),
(5, 'Marie', 2, 'Balinês', 'Pequeno', 'Fêmea', 'Branco com Preto', 6, 'Vacinado.', NULL, '2024-10-09 03:09:29'),
(6, 'Jujuba', 2, 'Persa', 'Pequeno', 'Fêmea', 'laranja', 3, 'Vacinado', NULL, '2024-10-09 04:16:01'),
(7, 'Sem nome definido', 2, 'Viralata', 'Pequeno', 'Macho', 'Laranja', 5, 'Vacinado', NULL, '2024-10-09 04:17:31'),
(8, 'Paçoca', 2, 'Bengal', 'Médio', 'Macho', 'Rajado', 12, 'Vacinado, Dócil, Amigável ', NULL, '2024-10-11 23:55:39'),
(9, 'Tigresa', 2, 'Viralata', 'Pequeno', 'Macho', 'Tricolor', 13, 'Vacinada', NULL, '2024-10-31 02:19:17'),
(10, 'Arthur', 1, 'Viralata', 'Médio', 'Macho', 'Caramelo', 3, 'Vacinado', NULL, '2024-10-31 02:26:56'),
(11, 'Pinpom', 1, 'Pug', 'Pequeno', 'Macho', 'Preto', 10, 'Vacinado', NULL, '2024-10-31 22:24:07'),
(12, 'Zuzu', 1, 'Border Collie', 'Grande', 'Fêmea', 'Laranja com Branco', 5, 'Vacinada', NULL, '2024-11-01 13:49:50'),
(13, 'Zuzu', 1, 'Border collie', 'Grande', 'Fêmea', 'Laranja com Branco', 5, 'Vacinada', NULL, '2024-11-01 14:22:00'),
(14, 'Bob', 1, 'Doberman', 'Grande', 'Macho', 'Preto', 5, 'Vacinado', NULL, '2024-11-01 14:41:03'),
(15, 'Rocky', 2, 'Bombaim', 'Pequeno', 'Macho', 'Preto', 1, 'Vacinado; Vermifugado; Dócil; Amigável; ', NULL, '2024-11-04 14:29:12'),
(16, 'PimPim', 2, 'Vira-lata', 'Pequeno', 'Macho', 'Laranja', 1, 'Vacinado', NULL, '2024-11-04 14:48:48'),
(17, 'Salem', 2, 'Vira-lata', 'Pequeno', 'Macho', 'Preto', 5, 'Vacinado', NULL, '2024-11-04 22:13:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `perfil_id` int(11) NOT NULL,
  `data_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `cpf`, `telefone`, `email`, `senha`, `criado_em`, `perfil_id`, `data_nascimento`) VALUES
(1, 'Carlos', 'Eduardo', '96378915942', '61985456789', 'carloseduardo@gmail.com', '$2y$10$DrCu3CBhu1oQsHaOl95AfuiHiLZEF9/MLVMEhHB6eGzUr5TEl2MSe', '2024-10-09 02:28:31', 2, '1995-10-25'),
(2, 'Janes', 'Cleston', '77777777777', '61896547896', 'janes@gmail.com', '$2y$10$G/DsiSiULY5BLJADZRP6V.DDh6p05.zGwOVhSUagfenaIl5zi6ez2', '2024-10-09 02:32:06', 1, '1982-07-17'),
(3, 'Angel', 'Luz', '33333333333', '61987456321', 'angel@gmail.com', '$2y$10$yIH0axze1fh9y3S16fRLVOVKPYaZUctvinMhUC0cALAFAJPKuBkfe', '2024-10-09 03:05:55', 1, '1992-03-30'),
(4, 'Gustavo', 'Junior', '66666666666', '61896458745', 'gustavo@gmail.com', '$2y$10$.mXfTTy/.cCmQ9s053vXQ.jCy.s1meXd/op.CCRuNoTvGytmP9Kcu', '2024-10-12 12:35:32', 1, '2000-12-05'),
(5, 'Lucas', 'Santos', '44444444444', '61896452123', 'lucas@gmail.com', '$2y$10$/MGfoEyZwni6SpusrJjbKeQKbiESvSSXFRRMX4j12i3QMKuaDp5kO', '2024-10-12 12:47:08', 2, '1982-10-25'),
(6, 'André', 'Felipe', '44455566611', '61987456321', 'andre@gmail.com', '$2y$10$Z5672VN7Zx.hhuObacYM0.eYHtQoaeHg0nIwUWPN7.O76AhdDKP8G', '2024-10-12 15:22:05', 1, '1982-10-05'),
(8, 'João', 'Robert', '00052314562', '6199913151', 'joao@gmail.com', '123456', '2024-10-12 17:58:14', 1, '1992-02-15'),
(9, 'Maria', 'Luiza', '99999999999', '61999555441', 'marialuiza@gmail.com', '123456', '2024-10-12 18:12:42', 1, '1992-10-15'),
(10, 'Aline', 'Lima', '96325874112', '61999666333', 'alinelima@gmail.com', '123456', '2024-10-12 18:35:32', 2, '2005-11-15'),
(11, 'Luana', 'Silva', '78965412363', '61999888555', 'luana@gmail.com', '123456', '2024-10-12 22:01:46', 2, '2005-04-15'),
(12, 'Abigail', 'Santos', '85645212365', '61999888777', 'abigail@gmail.com', '$2y$10$XhB5Ii6rkYWcxh4.FFnVX.MnEsE7mVljmMMSB0qMaJ7I0wG0DE6fe', '2024-10-13 00:25:26', 1, '2007-10-15'),
(14, 'Felipe', 'Miguel', '95142356121', '61987456321', 'felipe@gmail.com', '123456', '2024-10-13 16:21:21', 2, '1985-12-05'),
(18, 'Lucas ', 'Lima', '65412395123', '61999444563', 'lucaslima1@gmail.com', '123456', '2024-10-18 00:26:30', 2, '1992-03-30'),
(19, 'Marcos', 'Vinicius', '95132178965', '61999888546', 'marcosvinicius@gmail.com', '123456', '2024-10-18 16:04:52', 2, '1998-10-25'),
(25, 'Camila', 'Silva', '65478995115', '61978645357', 'camila@gmail.com', '$2y$10$lqkurayMRQSZ9fKPth1dU.Ehgvym19wdgwDwXbGuW5ltOg4etU9OS', '2024-10-30 19:27:08', 2, '2010-05-02'),
(37, 'Abigail', 'Martins', '95478545632', '61999874563', 'abigailmartins@gmail.com', '$2y$10$W6juCP1vHxy2uF82hRDAxu1SrEkFJD2cRljIYM9yQN2SkEq3TwQrO', '2024-10-31 20:45:28', 2, '1982-10-25'),
(39, 'Henrique', 'Miguel', '12385235778', '61896753159', 'henrique@gmail.com', '$2y$10$BtNtk8zfr0vQ0s.i5PHXV.CYPKQ8UMST.gveH./.tt3bPwKYwP4PG', '2024-10-31 20:57:34', 2, '2005-12-15'),
(40, 'Martins', 'Algusto', '98735775321', '61999777548', 'martinsalgusto@gmail.com', '$2y$10$wSyP/OuC7ZhkJcahxYIUpOtFR9.GFy.oR/DhmGwc8PBEqwNzvFD6y', '2024-10-31 21:05:29', 1, '2005-12-20'),
(42, 'André', 'Gustavo', '34786152478', '61987753951', 'andregustavo@gmail.com', '$2y$10$zLI.tZDR.a0csoXwrP1nduZs/hzVO5.dwSwqUVtUnhkrtdfPIIZlm', '2024-11-01 02:35:06', 2, '1982-10-14'),
(43, 'Enzo', 'Gabriel', '85245695115', '61987321951', 'enzogabriel@gmail.com', '$2y$10$UXUih78W7AzkzJoKDpBLmOLgFYNzzpVNxyDang.IMSDfGQftFOcDy', '2024-11-01 02:42:03', 1, '2005-12-25'),
(44, 'Enzo', 'Gabriel', '25632147895', '61987321951', 'enzo@gmail.com', '$2y$10$BgwMonf3z7IY3ooijL/y5uwiJx/AVF2dQQ6fEQz1OOZTat/4EdqdK', '2024-11-01 02:49:57', 1, '2005-12-25'),
(45, 'Gabriel', 'Campos', '35425869312', '61999555333', 'gabrielcampos@gmail.com', '$2y$10$3paZ8VYS62O1HZ8RXuaxHuTjzfVrqX/VxVA9CORVCoStByOMmMJJy', '2024-11-01 12:25:20', 2, '2005-10-25'),
(48, 'Glads', 'Mota', '98775335778', '61888777546', 'glads@gmail.com', '$2y$10$zdGHYiyI.MRytEMrVT0WU.UtLveatOD3COvyfo7f9QYTaitb.bTGK', '2024-11-01 12:51:51', 1, '1990-11-17'),
(49, 'Katlyn', 'Maria', '45685123478', '61986547896', 'katlyn@gmail.com', '$2y$10$/BuIPdy3BUG95UfrXzs8xellZ1g6x.Vw4TeCmlq5NeKI.JoVB49yC', '2024-11-01 13:09:01', 1, '2018-04-17'),
(50, 'Jean', 'Carlos', '65465184121', '61999444771', 'jeancarlos@gmail.com', '$2y$10$ldO9zfXN96FjYqcEBjFTUeYe9zwntg7YqTZ.0oR6KCu7dy/X2//tG', '2024-11-01 13:47:42', 2, '1982-02-15');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_doacao_endereco` (`endereco_id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_endereco` (`usuario_id`);

--
-- Índices de tabela `especie`
--
ALTER TABLE `especie`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fotos_pets_FK` (`pet_id`);

--
-- Índices de tabela `perfis`
--
ALTER TABLE `perfis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pets_especie_FK` (`especie_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD KEY `usuarios_perfis_FK` (`perfil_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `especie`
--
ALTER TABLE `especie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `perfis`
--
ALTER TABLE `perfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `doacoes`
--
ALTER TABLE `doacoes`
  ADD CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `doacoes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_doacao_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`);

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_pets_FK` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

--
-- Restrições para tabelas `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_especie_FK` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_perfis_FK` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
