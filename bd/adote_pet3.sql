-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/11/2024 às 16:36
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
-- Estrutura para tabela `adocoes`
--

CREATE TABLE `adocoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `adocoes`
--

INSERT INTO `adocoes` (`id`, `nome`, `telefone`, `email`, `pet_id`, `criado_em`) VALUES
(1, 'Carlos', '61999777456', 'carlos@gmail.com', 24, '2024-11-15 21:18:17'),
(2, 'Angel', '61999888546', 'angel@gmail.com', 23, '2024-11-17 18:20:41'),
(3, 'André Santos', '61789654123', 'andre@gmail.com', 25, '2024-11-17 18:24:17');

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
(21, 21, 48, '2024-11-06', '2024-11-06 00:17:55', 36),
(22, 22, 52, '2024-11-10', '2024-11-09 23:04:59', 41),
(23, 23, 25, '2024-11-15', '2024-11-15 15:23:42', 24),
(24, 24, 25, '2024-11-15', '2024-11-15 17:03:58', 24),
(25, 25, 25, '2024-11-15', '2024-11-15 18:05:22', 24);

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
(5, 10, '57312-02', 'Rua José Valentim dos Santos', 'Santa Esmeralda', 'Arapiraca', 'AL', ''),
(6, 11, '71697-04', 'Quadra 2 Conjunto 2', 'São Bartolomeu (São Sebastião)', 'Brasília', 'DF', ''),
(13, 18, '72603102', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF', ''),
(23, 4, '72007-660', 'Rua Rua 12 Chácara 153/1', 'Setor Habitacional Vicente Pires', 'Brasília', 'DF', 'Distrito Federal'),
(24, 25, '72156-21', 'Quadra QNL 12 Bloco I', 'Taguatinga Norte (Taguatinga)', 'Brasília', 'DF', 'Distrito Federal'),
(36, 48, '72603102', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF', 'Distrito Federal'),
(37, 49, '71995-280', 'Conjunto SHA Conjunto 5 Chácara 44', 'Setor Habitacional Arniqueira (Águas Claras)', 'Brasília', 'DF', 'Distrito Federal'),
(41, 52, '72020-290', 'Quadra QSD 29', 'Taguatinga Sul (Taguatinga)', 'Brasília', 'DF', 'Distrito Federal'),
(42, 53, '72603102', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF', 'Distrito Federal');

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
-- Estrutura para tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `favoritos`
--

INSERT INTO `favoritos` (`id`, `usuario_id`, `pet_id`, `criado_em`) VALUES
(8, 25, 23, '2024-11-18 14:09:39'),
(21, 25, 22, '2024-11-20 00:08:40'),
(22, 25, 24, '2024-11-20 00:09:07'),
(23, 25, 25, '2024-11-20 00:09:48'),
(24, 25, 21, '2024-11-20 01:19:49');

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
(15, 'Border collie laranja com branco.jpg', 'uploads/Border collie laranja com branco.jpg', 12),
(36, 'Gato-laranja-filhote-1.jpg', 'uploads/Gato-laranja-filhote-1.jpg', 18),
(37, 'Gato-laranja-filhote-2.jpg', 'uploads/Gato-laranja-filhote-2.jpg', 18),
(38, 'Gato-laranja-filhote-3.jpg', 'uploads/Gato-laranja-filhote-3.jpg', 18),
(39, 'siames-p1.jpg', 'uploads/siames-p1.jpg', 19),
(40, 'siames-p2.jpg', 'uploads/siames-p2.jpg', 19),
(41, 'siames-p3.jpg', 'uploads/siames-p3.jpg', 19),
(45, 'gatopreto1.jpg', 'uploads/gatopreto1.jpg', 21),
(46, 'gatopreto2.png', 'uploads/gatopreto2.png', 21),
(47, 'gatopreto3.png', 'uploads/gatopreto3.png', 21),
(48, 'Sphynx 1.jpg', 'uploads/Sphynx 1.jpg', 22),
(49, 'Sphynx 2.jpg', 'uploads/Sphynx 2.jpg', 22),
(50, 'Sphynx 3.jpg', 'uploads/Sphynx 3.jpg', 22),
(51, 'Gato-persa-tricolor3.jpg', 'uploads/Gato-persa-tricolor3.jpg', 23),
(52, 'Gato-persa-tricolor2.jpg', 'uploads/Gato-persa-tricolor2.jpg', 23),
(53, 'Gato-persa-tricolor1.jpg', 'uploads/Gato-persa-tricolor1.jpg', 23),
(54, 'cachorro caramelo piado de manga 1.png', 'uploads/cachorro caramelo piado de manga 1.png', 24),
(55, 'podle medio.jpg', 'uploads/podle medio.jpg', 25);

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
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pets`
--

INSERT INTO `pets` (`id`, `nome`, `especie_id`, `raca`, `porte`, `sexo`, `cor`, `idade`, `descricao`, `foto`, `criado_em`, `status_id`) VALUES
(1, 'Meg', 1, ' Golden retriever', 'Grande', 'Fêmea', 'Laranja', 5, 'Vacina, Vermifugado, Docil.', NULL, '2024-10-09 02:30:23', 1),
(2, 'Lili', 2, 'Sphynx', 'Médio', 'Macho', 'Tricolor', 2, 'Vacinas em dia.', NULL, '2024-10-09 02:34:15', 1),
(3, 'Baco', 1, ' Dachshund', 'Pequeno', 'Macho', 'Preto', 11, 'Vacinado', NULL, '2024-10-09 02:35:04', 1),
(5, 'Marie', 2, 'Balinês', 'Pequeno', 'Fêmea', 'Branco com Preto', 6, 'Vacinado.', NULL, '2024-10-09 03:09:29', 1),
(12, 'Zuzu', 1, 'Border Collie', 'Grande', 'Fêmea', 'Laranja com Branco', 5, 'Vacinada', NULL, '2024-11-01 13:49:50', 1),
(18, 'Pipi', 2, 'Vira-lata', 'Pequeno', 'Fêmea', 'Laranja', 3, 'Vacina', NULL, '2024-11-05 21:32:40', 1),
(19, 'Pompi', 2, 'Siamês', 'Pequeno', 'Macho', 'Cinza com Preto', 10, 'Vacinado', NULL, '2024-11-05 21:35:50', 1),
(21, 'Salem', 2, 'Vira-lata', 'Pequeno', 'Macho', 'Preto', 2, 'Vacinado; Vermifugado; Dócil; Amigável; Independente;', NULL, '2024-11-06 00:17:55', 1),
(22, 'Vermifugado', 2, 'Sphynx', 'Pequeno', 'Macho', 'Preto', 5, 'Vacinado.', NULL, '2024-11-09 23:04:59', 1),
(23, 'Luli', 2, 'Persa', 'Pequeno', 'Fêmea', 'Tricolor', 5, 'Vacinada e Vermifugada', NULL, '2024-11-15 15:23:42', 2),
(24, 'PimPim', 1, 'Vira-lata', 'Médio', 'Macho', 'Laranja', 5, 'Vacinado', NULL, '2024-11-15 17:03:58', 2),
(25, 'Pumpi', 1, 'Poddle', 'Médio', 'Macho', 'Branco', 2, 'Vacinado', NULL, '2024-11-15 18:05:22', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `status`
--

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Disponível'),
(2, 'Em adoção'),
(3, 'Adotado'),
(4, 'Em análise');

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
(4, 'Gustavo', 'Junior', '66666666666', '61896458745', 'gustavo@gmail.com', '$2y$10$.mXfTTy/.cCmQ9s053vXQ.jCy.s1meXd/op.CCRuNoTvGytmP9Kcu', '2024-10-12 12:35:32', 1, '2000-12-05'),
(6, 'André', 'Felipe', '44455566611', '61987456321', 'andre@gmail.com', '$2y$10$Z5672VN7Zx.hhuObacYM0.eYHtQoaeHg0nIwUWPN7.O76AhdDKP8G', '2024-10-12 15:22:05', 1, '1982-10-05'),
(8, 'João', 'Robert', '00052314562', '6199913151', 'joao@gmail.com', '123456', '2024-10-12 17:58:14', 1, '1992-02-15'),
(10, 'Aline', 'Lima', '96325874112', '61999666333', 'alinelima@gmail.com', '123456', '2024-10-12 18:35:32', 2, '2005-11-15'),
(11, 'Luana', 'Silva', '78965412363', '61999888555', 'luana@gmail.com', '123456', '2024-10-12 22:01:46', 2, '2005-04-15'),
(14, 'Felipe', 'Miguel', '95142356121', '61987456321', 'felipe@gmail.com', '123456', '2024-10-13 16:21:21', 2, '1985-12-05'),
(18, 'Lucas ', 'Lima', '65412395123', '61999444563', 'lucaslima1@gmail.com', '123456', '2024-10-18 00:26:30', 2, '1992-03-30'),
(19, 'Marcos', 'Vinicius', '95132178965', '61999888546', 'marcosvinicius@gmail.com', '123456', '2024-10-18 16:04:52', 2, '1998-10-25'),
(25, 'Camila', 'Silva', '65478995115', '61999111456', 'camila@gmail.com', '$2y$10$c7qkzUQerqvKP6/GO.cotOYSLHzahsxWmt4ScjoXUt36TotiGnuYW', '2024-10-30 19:27:08', 2, '2000-03-30'),
(39, 'Henrique', 'Miguel', '12385235778', '61896753159', 'henrique@gmail.com', '$2y$10$BtNtk8zfr0vQ0s.i5PHXV.CYPKQ8UMST.gveH./.tt3bPwKYwP4PG', '2024-10-31 20:57:34', 2, '2005-12-15'),
(40, 'Martins', 'Algusto', '98735775321', '61999777548', 'martinsalgusto@gmail.com', '$2y$10$wSyP/OuC7ZhkJcahxYIUpOtFR9.GFy.oR/DhmGwc8PBEqwNzvFD6y', '2024-10-31 21:05:29', 1, '2005-12-20'),
(42, 'André', 'Gustavo', '34786152478', '61987753951', 'andregustavo@gmail.com', '$2y$10$zLI.tZDR.a0csoXwrP1nduZs/hzVO5.dwSwqUVtUnhkrtdfPIIZlm', '2024-11-01 02:35:06', 2, '1982-10-14'),
(45, 'Gabriel', 'Campos', '35425869312', '61999555333', 'gabrielcampos@gmail.com', '$2y$10$3paZ8VYS62O1HZ8RXuaxHuTjzfVrqX/VxVA9CORVCoStByOMmMJJy', '2024-11-01 12:25:20', 2, '2005-10-25'),
(48, 'Glads', 'Mota', '98775335778', '61888777546', 'glads@gmail.com', '$2y$10$zdGHYiyI.MRytEMrVT0WU.UtLveatOD3COvyfo7f9QYTaitb.bTGK', '2024-11-01 12:51:51', 1, '1990-11-17'),
(49, 'Katlyn', 'Maria', '45685123478', '61986547896', 'katlyn@gmail.com', '$2y$10$/BuIPdy3BUG95UfrXzs8xellZ1g6x.Vw4TeCmlq5NeKI.JoVB49yC', '2024-11-01 13:09:01', 1, '2018-04-17'),
(52, 'Mateus', 'Matos', '98775365221', '61896547423', 'mateus@gmail.com', '$2y$10$OjwNfCU.Z3IqyDRxfRhdquIRyiSFPe/EGgLW7JeIOLLlAVnZtlURC', '2024-11-09 22:40:55', 1, '2000-02-10'),
(53, 'Angel', 'Luz', '12385245698', '61986547123', 'angel@gmail.com', '$2y$10$UaRZaNH9/1UN5nz0xYWFAO7w9sy3XhrV.o1vP8S5DHLbXH3SQYE46', '2024-11-11 00:05:44', 2, '1992-03-30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adocoes`
--
ALTER TABLE `adocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Índices de tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_endereco` (`endereco_id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_endereco_usuario` (`usuario_id`);

--
-- Índices de tabela `especie`
--
ALTER TABLE `especie`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pet_id` (`pet_id`);

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
  ADD KEY `pets_especie_FK` (`especie_id`),
  ADD KEY `fk_status` (`status_id`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `adocoes`
--
ALTER TABLE `adocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `especie`
--
ALTER TABLE `especie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `perfis`
--
ALTER TABLE `perfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `adocoes`
--
ALTER TABLE `adocoes`
  ADD CONSTRAINT `adocoes_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `doacoes`
--
ALTER TABLE `doacoes`
  ADD CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `doacoes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doacao_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`),
  ADD CONSTRAINT `fk_doacoes_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`),
  ADD CONSTRAINT `fk_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `fk_endereco_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

--
-- Restrições para tabelas `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_fotos_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pet_foto` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `fotos_pets_FK` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

--
-- Restrições para tabelas `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `fk_especie` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`),
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
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
