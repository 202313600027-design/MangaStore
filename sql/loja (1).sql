-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/12/2025 às 03:32
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
-- Banco de dados: `loja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(500) NOT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `estoque` int(11) DEFAULT 0,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `imagem`, `descricao`, `categoria`, `estoque`, `data_cadastro`) VALUES
(1, 'Attack on Titan - Vol. 1', 24.90, '../fotos/Attack on Titan - Vol. 1.jpg', NULL, 'Ação', 10, '2025-12-10 02:24:45'),
(2, 'One Piece - Vol. 1', 19.90, '../fotos/Volume 1 One Piece.png', NULL, 'Aventura', 15, '2025-12-10 02:24:45'),
(3, 'Naruto - Vol. 1', 22.90, '../fotos/naruto-vol-1.jpg', NULL, 'Aventura', 12, '2025-12-10 02:24:45'),
(4, 'My Hero Academia - Vol. 1', 21.90, '../fotos/my hero academia - vol.1.jpg', NULL, 'Ação', 8, '2025-12-10 02:24:45'),
(5, 'Demon Slayer - Vol. 1', 23.90, '../fotos/demon slayer - vol.1.jpg', NULL, 'Ação', 10, '2025-12-10 02:24:45'),
(6, 'Tokyo Ghoul - Vol. 1', 25.90, '../fotos/tokyo ghoul - vol.1.jpg', NULL, 'Sobrenatural', 7, '2025-12-10 02:24:45'),
(10, 'Bleach - Vol. 1', 20.90, '../fotos/bleach_vol1.jpg', NULL, 'Ação', 6, '2025-12-10 02:24:45'),
(11, 'Dragon Ball - Vol. 1', 18.90, '../fotos/dragon_ball_vol1.jpg', NULL, 'Aventura', 9, '2025-12-10 02:24:45'),
(12, 'Death Note - Vol. 1', 26.90, '../fotos/death_note_vol1.jpg', NULL, 'Suspense', 4, '2025-12-10 02:24:45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
