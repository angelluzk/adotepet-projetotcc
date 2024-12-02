SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `adocoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `adocoes` (`id`, `nome`, `telefone`, `email`, `pet_id`, `criado_em`) VALUES
(1, 'Miguel Campos', '61999887453', 'miguelcampos@gmail.com', 8, '2024-12-01 23:44:29');

CREATE TABLE `doacoes` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `endereco_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `doacoes` (`id`, `pet_id`, `usuario_id`, `data`, `criado_em`, `endereco_id`) VALUES
(1, 1, 2, '2024-12-02', '2024-12-02 01:45:34', 2),
(2, 2, 3, '2024-12-02', '2024-12-02 01:47:00', 3),
(3, 3, 4, '2024-12-02', '2024-12-02 01:50:24', 4),
(4, 4, 5, '2024-12-02', '2024-12-02 01:52:29', 5),
(5, 5, 6, '2024-12-02', '2024-12-02 01:54:25', 6),
(6, 6, 7, '2024-12-02', '2024-12-02 01:56:20', 7),
(7, 7, 8, '2024-12-02', '2024-12-02 01:57:41', 8),
(8, 8, 9, '2024-12-02', '2024-12-02 01:59:16', 9),
(9, 9, 10, '2024-12-02', '2024-12-02 02:00:39', 10),
(10, 10, 11, '2024-12-02', '2024-12-02 02:01:45', 11),
(11, 11, 11, '2024-12-02', '2024-12-02 02:02:50', 11),
(12, 12, 11, '2024-12-02', '2024-12-02 02:04:26', 11);

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

INSERT INTO `enderecos` (`id`, `usuario_id`, `cep`, `logradouro`, `bairro`, `localidade`, `uf`, `estado`) VALUES
(1, 1, '72240-807', 'Quadra QNP 9 Conjunto G', 'Ceilândia Norte (Ceilândia)', 'Brasília', 'DF', 'Distrito Federal'),
(2, 2, '70745-530', 'Quadra CLN 306 Bloco C', 'Asa Norte', 'Brasília', 'DF', 'Distrito Federal'),
(3, 3, '70862-400', 'Quadra EQN 210/211', 'Asa Norte', 'Brasília', 'DF', 'Distrito Federal'),
(4, 4, '72335-501', 'Quadra QS 629 Conjunto A Comércio', 'Samambaia Norte (Samambaia)', 'Brasília', 'DF', 'Distrito Federal'),
(5, 5, '71740-003', 'Quadra SMPW Quadra 13 Conjunto 7', 'Park Way', 'Brasília', 'DF', 'Distrito Federal'),
(6, 6, '70648-123', 'Quadra SRES Quadra 4 Bloco L', 'Cruzeiro Velho', 'Brasília', 'DF', 'Distrito Federal'),
(7, 7, '70648-190', 'Quadra SRES Quadra 2 Bloco S', 'Cruzeiro Velho', 'Brasília', 'DF', 'Distrito Federal'),
(8, 8, '71725-044', 'Condomínio Residencial', 'Candangolândia', 'Brasília', 'DF', 'Distrito Federal'),
(9, 9, '71675-040', 'Quadra SHIS QI 27 Conjunto 4', 'Setor de Habitações Individuais Sul', 'Brasília', 'DF', 'Distrito Federal'),
(10, 10, '72325-208', 'Quadra QR 423 Conjunto 7', 'Samambaia Norte (Samambaia)', 'Brasília', 'DF', 'Distrito Federal'),
(11, 11, '72502-400', 'Quadra QR 202', 'Santa Maria', 'Brasília', 'DF', 'Distrito Federal');

CREATE TABLE `especie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `especie` (`id`, `nome`) VALUES
(1, 'Cachorro'),
(2, 'Gato');

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `favoritos` (`id`, `usuario_id`, `pet_id`, `criado_em`) VALUES
(1, 11, 1, '2024-12-02 02:16:36'),
(2, 11, 2, '2024-12-02 02:16:41'),
(3, 11, 7, '2024-12-02 02:16:47'),
(4, 11, 8, '2024-12-02 02:16:52');

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `fotos` (`id`, `nome`, `url`, `pet_id`) VALUES
(1, 'Gato-laranja-filhote-1.jpg', 'uploads/Gato-laranja-filhote-1.jpg', 1),
(2, 'Gato-laranja-filhote-2.jpg', 'uploads/Gato-laranja-filhote-2.jpg', 1),
(3, 'Gato-laranja-filhote-3.jpg', 'uploads/Gato-laranja-filhote-3.jpg', 1),
(4, 'gatopreto1.jpg', 'uploads/gatopreto1.jpg', 2),
(5, 'gatopreto2.png', 'uploads/gatopreto2.png', 2),
(6, 'gatopreto3.png', 'uploads/gatopreto3.png', 2),
(7, 'pastor-alemao-1.jpg', 'uploads/pastor-alemao-1.jpg', 3),
(8, 'pastor-alemao-2.jpg', 'uploads/pastor-alemao-2.jpg', 3),
(9, 'pastor-alemao-3.png', 'uploads/pastor-alemao-3.png', 3),
(10, 'siames-p1.jpg', 'uploads/siames-p1.jpg', 4),
(11, 'siames-p2.jpg', 'uploads/siames-p2.jpg', 4),
(12, 'siames-p3.jpg', 'uploads/siames-p3.jpg', 4),
(13, 'husky siberiano.png', 'uploads/husky siberiano.png', 5),
(14, 'rusky2.jpeg', 'uploads/rusky2.jpeg', 5),
(15, 'rusky3.jpg', 'uploads/rusky3.jpg', 5),
(16, 'Sphynx 1.jpg', 'uploads/Sphynx 1.jpg', 6),
(17, 'Sphynx 2.jpg', 'uploads/Sphynx 2.jpg', 6),
(18, 'Sphynx 3.jpg', 'uploads/Sphynx 3.jpg', 6),
(19, 'Cachorro caramelo fiapo de manda 1.png', 'uploads/Cachorro caramelo fiapo de manda 1.png', 7),
(20, 'Cachorro caramelo fiapo de manda 2.png', 'uploads/Cachorro caramelo fiapo de manda 2.png', 7),
(21, 'Cachorro caramelo fiapo de manda 3.png', 'uploads/Cachorro caramelo fiapo de manda 3.png', 7),
(22, 'poddle.jpg', 'uploads/poddle.jpg', 8),
(23, 'podle medio.jpg', 'uploads/podle medio.jpg', 8),
(24, 'poodle-caracteristicas-guia-racas.jpg', 'uploads/poodle-caracteristicas-guia-racas.jpg', 8),
(25, 'cachorro filhote 1.png', 'uploads/cachorro filhote 1.png', 9),
(26, 'cachorro filhote 2.png', 'uploads/cachorro filhote 2.png', 9),
(27, 'cachorro filhote 3.png', 'uploads/cachorro filhote 3.png', 9),
(28, 'cachorro caramelo piado de manga 1.png', 'uploads/cachorro caramelo piado de manga 1.png', 10),
(29, 'cachorro caramelo piado de manga 2.jpeg', 'uploads/cachorro caramelo piado de manga 2.jpeg', 10),
(30, 'cachorro caramelo piado de manga 3.jpg', 'uploads/cachorro caramelo piado de manga 3.jpg', 10),
(31, 'Gato-persa-tricolor1.jpg', 'uploads/Gato-persa-tricolor1.jpg', 11),
(32, 'Gato-persa-tricolor2.jpg', 'uploads/Gato-persa-tricolor2.jpg', 11),
(33, 'Gato-persa-tricolor3.jpg', 'uploads/Gato-persa-tricolor3.jpg', 11),
(34, 'gato preto bombaim1.jpg', 'uploads/gato preto bombaim1.jpg', 12),
(35, 'gato preto bombaim2.jpg', 'uploads/gato preto bombaim2.jpg', 12),
(36, 'gato preto bombaim3.jpg', 'uploads/gato preto bombaim3.jpg', 12);

CREATE TABLE `perfis` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `perfis` (`id`, `nome`) VALUES
(1, 'Funcionario'),
(2, 'Usuario');

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

INSERT INTO `pets` (`id`, `nome`, `especie_id`, `raca`, `porte`, `sexo`, `cor`, `idade`, `descricao`, `foto`, `criado_em`, `status_id`) VALUES
(1, 'Simba', 2, 'Viralata', 'Pequeno', 'Macho', 'Laranja', 1, 'Vacinado e Vermifugado.', NULL, '2024-12-02 01:45:34', 1),
(2, 'Luna', 2, 'Viralata', 'Médio', 'Fêmea', 'Preto', 2, 'Vacinado e Vermifugado.', NULL, '2024-12-02 01:47:00', 1),
(3, 'Oliver', 1, 'Pastor Alemão', 'Grande', 'Macho', 'Preto com Marrom', 5, 'Vacinado, vermifugado e castrado.', NULL, '2024-12-02 01:50:24', 1),
(4, 'Nina', 2, 'Siames', 'Médio', 'Fêmea', 'Preto com Branco', 6, 'Vacinada, vermifugada, castrada.', NULL, '2024-12-02 01:52:29', 1),
(5, 'Thor', 1, 'Husky siberiano', 'Grande', 'Macho', 'Branco e Cinza', 10, 'Vacinado, vermifugado e castrado. ', NULL, '2024-12-02 01:54:25', 1),
(6, 'Chico', 2, 'Sphynx', 'Médio', 'Macho', 'Preto', 12, 'Vacinado, vermifugado, castrado, independente.', NULL, '2024-12-02 01:56:20', 1),
(7, 'Pitoco', 1, 'Viralata', 'Médio', 'Macho', 'Caramelo', 7, 'Vacinado, Vermifugado, Castrado, Dócil, Amigável. ', NULL, '2024-12-02 01:57:41', 3),
(8, 'Lola', 1, 'Poddle', 'Médio', 'Fêmea', 'Branco', 4, 'Vacinada, Vermifugada, Castrada, Dócil.', NULL, '2024-12-02 01:59:16', 2),
(9, 'Biscoito', 1, 'Labrador', 'Pequeno', 'Macho', 'Marrom', 1, 'Vacinado e Vermifugado.', NULL, '2024-12-02 02:00:39', 1),
(10, 'Marley', 1, 'Viralata', 'Médio', 'Macho', 'Caramelo', 6, 'Vacinado, Vermifugado, Castrado, Dócil.', NULL, '2024-12-02 02:01:45', 3),
(11, 'Jade', 2, 'Persa', 'Médio', 'Fêmea', 'Tricolor', 9, 'Vacinada e Vermifugada.', NULL, '2024-12-02 02:02:50', 4),
(12, 'Loki', 2, 'Bombaim', 'Médio', 'Macho', 'Preto', 11, 'Vacinado e Vermifugado', NULL, '2024-12-02 02:04:26', 4);

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Disponível'),
(2, 'Em adoção'),
(3, 'Adotado'),
(4, 'Em análise');

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

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `cpf`, `telefone`, `email`, `senha`, `criado_em`, `perfil_id`, `data_nascimento`) VALUES
(1, 'Angel', 'Luz', '111.111.111-11', '(61) 99999-9999', 'angel@gmail.com', '$2y$10$VTOZeBIaGWV4lGfyE6/7Iuv/Ln7PmvtSsnzegfHdgM0xChuJwOcXS', '2024-12-02 01:26:02', 1, '2000-03-30'),
(2, 'João', 'Silva', '222.222.222-22', '(61) 99965-4222', 'joao@gmail.com', '$2y$10$sXjRdpHtjJmK2TXfvB8dfuqIN3glD2coU4Ht4H6SKGcvzwRDRfcky', '2024-12-02 01:30:51', 2, '1962-10-25'),
(3, 'Maria', 'Oliveira', '333.333.333-33', '(61) 99955-5472', 'maria@gmail.com', '$2y$10$U7k8x8iDl4T3azyHM00r5u7xRiHy7U/aow6Q1K.abj/6wa0eKba1W', '2024-12-02 01:33:10', 2, '2005-12-11'),
(4, 'Pedro', 'Souza', '444.444.444-44', '(61) 98854-7563', 'pedro@gmail.com', '$2y$10$5P1RfTidb1bZDfrxUejDVeh6n.k1rp2iRBt9FG3DwoBRyYkyUQkPS', '2024-12-02 01:34:56', 2, '1968-02-05'),
(5, 'Ana', 'Lima', '545.654.654-65', '(61) 99945-6322', 'ana@gmail.com', '$2y$10$uM00gV4gbCdOq7b98x0zluyP.hdyVfhCPd9EOZmnNDMyrZGY4Y.M.', '2024-12-02 01:36:15', 2, '2010-10-03'),
(6, 'Carlos', 'Ferreira', '564.654.564-98', '(61) 99964-6546', 'carlos@gmail.com', '$2y$10$4fGy1kIQO6bLfsVDDORZl.AK6BLsechpzl7UhsL2TfAyEGymB.96u', '2024-12-02 01:37:05', 2, '2005-05-05'),
(7, 'Laura', 'Costa', '685.649.684-84', '(61) 98985-6564', 'laura@gmail.com', '$2y$10$7.Agl1uyH4MjnIeZ09CXzuHQtQE2jd38YpZ7bILCiIvlj3EKxhNfW', '2024-12-02 01:38:14', 2, '1983-12-11'),
(8, 'Felipe', 'Mendes', '309.472.139-84', '(61) 92198-2131', 'felipe@gmail.com', '$2y$10$kMfPMoCNUqGMvcX90Wox8uLyxC58VXoV5uWYjrfwaWjhhKVRiaOjq', '2024-12-02 01:39:20', 2, '1992-09-04'),
(9, 'Juliana', 'Almeida', '218.967.319-28', '(61) 91298-3712', 'juliana@gmail.com', '$2y$10$gPAgyEiPJUuZqYpuCPZHe.skvK9hK4uekZfIkdhSb8fm1aHVtyoY2', '2024-12-02 01:40:19', 2, '1984-10-06'),
(10, 'Ricardo', 'Babosa', '221.073.410-28', '(61) 81092-8381', 'ricardo@gmail.com', '$2y$10$TGTgjWofBY0aeiHBKzAB7eoMHZdqdvKAmMAQAbl5r6do6QMCodCUC', '2024-12-02 01:41:36', 2, '1994-06-07'),
(11, 'Beatriz', 'Rocha', '094.812.093-81', '(61) 99894-9846', 'beatriz@gmail.com', '$2y$10$iKsXanRZuxhGsjiu5c.5bOcfTtzUyVrIlGde.L2OAsNgrAGYCBOKq', '2024-12-02 01:42:33', 2, '1987-12-15');


ALTER TABLE `adocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_endereco` (`endereco_id`);

ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_endereco_usuario` (`usuario_id`);

ALTER TABLE `especie`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pet_id` (`pet_id`);

ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fotos_pets_FK` (`pet_id`);

ALTER TABLE `perfis`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pets_especie_FK` (`especie_id`),
  ADD KEY `fk_status` (`status_id`);

ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_cpf` (`cpf`),
  ADD KEY `usuarios_perfis_FK` (`perfil_id`);


ALTER TABLE `adocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `doacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `especie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `perfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `adocoes`
  ADD CONSTRAINT `adocoes_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE;

ALTER TABLE `doacoes`
  ADD CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `doacoes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doacao_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`),
  ADD CONSTRAINT `fk_doacoes_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`),
  ADD CONSTRAINT `fk_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `enderecos`
  ADD CONSTRAINT `fk_endereco_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_fotos_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pet_foto` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `fotos_pets_FK` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

ALTER TABLE `pets`
  ADD CONSTRAINT `fk_especie` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`),
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `pets_especie_FK` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`);

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_perfis_FK` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
