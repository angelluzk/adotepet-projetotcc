-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/10/2024 às 19:10
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
  `endereco_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doacoes`
--

INSERT INTO `doacoes` (`id`, `pet_id`, `usuario_id`, `data`, `criado_em`, `endereco_id`) VALUES
(1, 1, 1, '2024-10-09', '2024-10-09 02:30:23', NULL),
(2, 2, 1, '2024-10-09', '2024-10-09 02:34:15', NULL),
(3, 3, 1, '2024-10-09', '2024-10-09 02:35:04', NULL),
(4, 4, 2, '2024-10-09', '2024-10-09 02:59:59', NULL),
(5, 5, 3, '2024-10-09', '2024-10-09 03:09:29', NULL),
(6, 6, 2, '2024-10-09', '2024-10-09 04:16:01', NULL),
(7, 7, 3, '2024-10-09', '2024-10-09 04:17:31', NULL),
(8, 8, 2, '2024-10-12', '2024-10-11 23:55:39', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `localidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `usuario_id`, `cep`, `logradouro`, `bairro`, `localidade`, `uf`) VALUES
(2, 6, '72603-10', 'Quadra 113 Conjunto 2', 'Recanto das Emas', 'Brasília', 'DF'),
(3, 8, '69082-71', 'Rua Capitão Enéas', 'Coroado', 'Manaus', 'AM'),
(4, 9, '72410-23', 'Praça 3 Bloco A', 'Setor Sul (Gama)', 'Brasília', 'DF'),
(5, 10, '57312-02', 'Rua José Valentim dos Santos', 'Santa Esmeralda', 'Arapiraca', 'AL'),
(6, 11, '71697-04', 'Quadra 2 Conjunto 2', 'São Bartolomeu (São Sebastião)', 'Brasília', 'DF'),
(7, 12, '71573-10', 'Quadra 31 Conjunto 23', 'Paranoá', 'Brasília', 'DF'),
(8, 13, '01001-00', 'Praça da Sé', 'Sé', 'São Paulo', 'SP'),
(9, 13, '01001-00', 'Praça da Sé', 'Sé', 'São Paulo', 'SP'),
(11, 16, '88060-39', 'Servidão Luiz Manoel dos Santos', 'São João do Rio Vermelho', 'Florianópolis', 'SC');

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
(4, 'husky siberiano.png', 'uploads/husky siberiano.png', 4),
(5, 'Sphynx.png', 'uploads/Sphynx.png', 2),
(7, 'salsichapreto.png', 'uploads/salsichapreto.png', 3),
(8, 'Balinês - branco com preto.jpeg', 'uploads/Balinês - branco com preto.jpeg', 5),
(9, 'garo Persa.jpg', 'uploads/garo Persa.jpg', 6),
(10, 'pompom - gato laranja.jpg', 'uploads/pompom - gato laranja.jpg', 7),
(11, 'Gato-Bengal.jpg', 'uploads/Gato-Bengal.jpg', 8);

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
(4, 'Luna', 1, 'Husky siberiano', 'Grande', 'Fêmea', 'Preto e Branco', 6, 'Vacinas todas em dia.', NULL, '2024-10-09 02:59:59'),
(5, 'Marie', 2, 'Balinês', 'Pequeno', 'Fêmea', 'Branco com Preto', 6, 'Vacinado.', NULL, '2024-10-09 03:09:29'),
(6, 'Jujuba', 2, 'Persa', 'Pequeno', 'Fêmea', 'laranja', 3, 'Vacinado', NULL, '2024-10-09 04:16:01'),
(7, 'Sem nome definido', 2, 'Viralata', 'Pequeno', 'Macho', 'Laranja', 5, 'Vacinado', NULL, '2024-10-09 04:17:31'),
(8, 'Paçoca', 2, 'Bengal', 'Médio', 'Macho', 'Rajado', 12, 'Vacinado, Dócil, Amigável ', NULL, '2024-10-11 23:55:39');

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
(1, 'Carlos', 'Eduardo', '11111111111', '61985456789', 'carlos@gmail.com', '123456', '2024-10-09 02:28:31', 2, '1995-10-25'),
(2, 'Janes', 'Cleston', '22222222222', '61896547896', 'janes@gmail.com', '$2y$10$LDh8b.SKT7JLEi/OcspqDuxTbqvykEdKj7IQ6oSxONKEJE6yZRBw2', '2024-10-09 02:32:06', 1, '1989-07-11'),
(3, 'Angel', 'Luz', '33333333333', '61987456321', 'angel@gmail.com', '$2y$10$Ej5DBsXSA9CXiu8Rab3g3.G9w2t5pZMpTCUdgvvYqqTAWNFJXvWkK', '2024-10-09 03:05:55', 1, '1992-03-30'),
(4, 'Gustavo', 'Junior', '66666666666', '61896458745', 'gustavo@gmail.com', '123456', '2024-10-12 12:35:32', 1, '2000-12-05'),
(5, 'Lucas', 'Santos', '44444444444', '61896452123', 'lucas@gmail.com', '123456', '2024-10-12 12:47:08', 2, '1982-10-25'),
(6, 'André', 'Felipe', '55555555555', '61987456321', 'andre@gmail.com', '123456', '2024-10-12 15:22:05', 2, '1982-08-01'),
(8, 'João', 'Robert', '00052314562', '6199913151', 'joao@gmail.com', '123456', '2024-10-12 17:58:14', 1, '1992-02-15'),
(9, 'Maria', 'Luiza', '99999999999', '61999555441', 'marialuiza@gmail.com', '123456', '2024-10-12 18:12:42', 1, '1992-10-15'),
(10, 'Aline', 'Lima', '96325874112', '61999666333', 'alinelima@gmail.com', '123456', '2024-10-12 18:35:32', 2, '2005-11-15'),
(11, 'Luana', 'Silva', '78965412363', '61999888555', 'luana@gmail.com', '123456', '2024-10-12 22:01:46', 2, '2005-04-15'),
(12, 'Abigail', 'Santos', '85645212365', '61999888777', 'abigail@gmail.com', '123456', '2024-10-13 00:25:26', 1, '2014-10-25'),
(13, 'SDASDA', 'SDASDSAD', '123123123', '213123213', '123123@GMAIL.COM', '123456', '2024-10-13 00:45:39', 1, '0123-03-12'),
(14, 'Felipe', 'Miguel', '95142356121', '61987456321', 'felipe@gmail.com', '123456', '2024-10-13 16:21:21', 2, '1985-12-05'),
(16, 'sadasd34234', 'asdad23123', '76565656798', '61555444332', '23123666@gmail.com', '1234565', '2024-10-13 16:49:50', 1, '2000-02-12');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `especie`
--
ALTER TABLE `especie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `perfis`
--
ALTER TABLE `perfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
