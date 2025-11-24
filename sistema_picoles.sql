-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2025 às 03:53
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
-- Banco de dados: `sistema_picolés`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aditivo_nutritivo`
--

CREATE TABLE `aditivo_nutritivo` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `aditivo_nutritivo`
--

INSERT INTO `aditivo_nutritivo` (`id`, `nome`) VALUES
(1, 'Vitamina C'),
(2, 'Cálcio'),
(3, 'Ferro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conservante`
--

CREATE TABLE `conservante` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `conservante`
--

INSERT INTO `conservante` (`id`, `nome`) VALUES
(1, 'Benzoato de Sódio'),
(2, 'Sorbato de Potássio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `embalagem`
--

CREATE TABLE `embalagem` (
  `id` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `embalagem`
--

INSERT INTO `embalagem` (`id`, `tipo`) VALUES
(1, 'Plástica'),
(2, 'Papel'),
(3, 'Biodegradável');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nome`) VALUES
(1, 'Água'),
(2, 'Açúcar'),
(3, 'Leite'),
(4, 'Corante'),
(5, 'Aroma Natural'),
(6, 'Fruta');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lote`
--

CREATE TABLE `lote` (
  `id` int(11) NOT NULL,
  `data_producao` date DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `id_picole` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `lote`
--

INSERT INTO `lote` (`id`, `data_producao`, `quantidade`, `id_picole`) VALUES
(1, '2025-01-10', 500, 1),
(2, '2025-01-15', 300, 2),
(3, '2025-01-20', 450, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_fiscal`
--

CREATE TABLE `nota_fiscal` (
  `id` int(11) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `id_revendedor` int(11) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `nota_fiscal`
--

INSERT INTO `nota_fiscal` (`id`, `numero`, `data`, `id_revendedor`, `valor_total`) VALUES
(1, 'NF0001', '2025-02-01', 1, 400.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_lote`
--

CREATE TABLE `nota_lote` (
  `id_nota` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `quantidade_vendida` int(11) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `nota_lote`
--

INSERT INTO `nota_lote` (`id_nota`, `id_lote`, `quantidade_vendida`, `valor_unitario`) VALUES
(1, 1, 100, 2.50),
(1, 2, 50, 3.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `picole`
--

CREATE TABLE `picole` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `tipo` enum('normal','ao leite') DEFAULT NULL,
  `id_sabor` int(11) DEFAULT NULL,
  `id_embalagem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `picole`
--

INSERT INTO `picole` (`id`, `nome`, `tipo`, `id_sabor`, `id_embalagem`) VALUES
(1, 'Picolé de Morango', 'normal', 1, 1),
(2, 'Picolé de Chocolate', 'ao leite', 2, 1),
(3, 'Picolé de Limão', 'normal', 4, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `picole_ingrediente`
--

CREATE TABLE `picole_ingrediente` (
  `id_picole` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `picole_ingrediente`
--

INSERT INTO `picole_ingrediente` (`id_picole`, `id_ingrediente`) VALUES
(1, 1),
(1, 2),
(1, 6),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `revendedor`
--

CREATE TABLE `revendedor` (
  `id` int(11) NOT NULL,
  `razão social` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `revendedor`
--

INSERT INTO `revendedor` (`id`, `razão social`, `cnpj`, `endereco`) VALUES
(1, 'Gelados Ltda', '11.222.333/0001-44', 'Rua das Flores, 123'),
(2, 'Frio & Cia', '55.666.777/0001-88', 'Av. Central, 456');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sabor`
--

CREATE TABLE `sabor` (
  `id` int(11) NOT NULL,
  `nome` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sabor`
--

INSERT INTO `sabor` (`id`, `nome`) VALUES
(1, 'Morango'),
(2, 'Chocolate'),
(3, 'Uva'),
(4, 'Limão'),
(5, 'Coco');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `senha`, `perfil`) VALUES
(1, 'admin', '123456', 'admin'),
(2, 'vendedor', '123456', 'vendedor');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aditivo_nutritivo`
--
ALTER TABLE `aditivo_nutritivo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conservante`
--
ALTER TABLE `conservante`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `embalagem`
--
ALTER TABLE `embalagem`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_picole` (`id_picole`);

--
-- Índices de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_revendedor` (`id_revendedor`);

--
-- Índices de tabela `nota_lote`
--
ALTER TABLE `nota_lote`
  ADD PRIMARY KEY (`id_nota`,`id_lote`),
  ADD KEY `id_lote` (`id_lote`);

--
-- Índices de tabela `picole`
--
ALTER TABLE `picole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sabor` (`id_sabor`),
  ADD KEY `id_embalagem` (`id_embalagem`);

--
-- Índices de tabela `picole_ingrediente`
--
ALTER TABLE `picole_ingrediente`
  ADD PRIMARY KEY (`id_picole`,`id_ingrediente`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Índices de tabela `revendedor`
--
ALTER TABLE `revendedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sabor`
--
ALTER TABLE `sabor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aditivo_nutritivo`
--
ALTER TABLE `aditivo_nutritivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `conservante`
--
ALTER TABLE `conservante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `embalagem`
--
ALTER TABLE `embalagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `picole`
--
ALTER TABLE `picole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `revendedor`
--
ALTER TABLE `revendedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `sabor`
--
ALTER TABLE `sabor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`id_picole`) REFERENCES `picole` (`id`);

--
-- Restrições para tabelas `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD CONSTRAINT `nota_fiscal_ibfk_1` FOREIGN KEY (`id_revendedor`) REFERENCES `revendedor` (`id`);

--
-- Restrições para tabelas `nota_lote`
--
ALTER TABLE `nota_lote`
  ADD CONSTRAINT `nota_lote_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota_fiscal` (`id`),
  ADD CONSTRAINT `nota_lote_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id`);

--
-- Restrições para tabelas `picole`
--
ALTER TABLE `picole`
  ADD CONSTRAINT `picole_ibfk_1` FOREIGN KEY (`id_sabor`) REFERENCES `sabor` (`id`),
  ADD CONSTRAINT `picole_ibfk_2` FOREIGN KEY (`id_embalagem`) REFERENCES `embalagem` (`id`);

--
-- Restrições para tabelas `picole_ingrediente`
--
ALTER TABLE `picole_ingrediente`
  ADD CONSTRAINT `picole_ingrediente_ibfk_1` FOREIGN KEY (`id_picole`) REFERENCES `picole` (`id`),
  ADD CONSTRAINT `picole_ingrediente_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;