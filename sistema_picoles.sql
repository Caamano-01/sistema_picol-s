-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 14/11/2025 às 17:39
-- Versão do servidor: 8.0.43-0ubuntu0.24.04.2
-- Versão do PHP: 8.4.13

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
  `id` int NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conservante`
--

CREATE TABLE `conservante` (
  `id` int NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `embalagem`
--

CREATE TABLE `embalagem` (
  `id` int NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` int NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lote`
--

CREATE TABLE `lote` (
  `id` int NOT NULL,
  `data_producao` date DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `id_picole` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_fiscal`
--

CREATE TABLE `nota_fiscal` (
  `id` int NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `id_revendedor` int DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_lote`
--

CREATE TABLE `nota_lote` (
  `id_nota` int NOT NULL,
  `id_lote` int NOT NULL,
  `quantidade_vendida` int DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `picole`
--

CREATE TABLE `picole` (
  `id` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `tipo` enum('normal','ao leite') DEFAULT NULL,
  `id_sabor` int DEFAULT NULL,
  `id_embalagem` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `picole_ingrediente`
--

CREATE TABLE `picole_ingrediente` (
  `id_picole` int NOT NULL,
  `id_ingrediente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `revendedor`
--

CREATE TABLE `revendedor` (
  `id` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sabor`
--

CREATE TABLE `sabor` (
  `id` int NOT NULL,
  `nome` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aditivo_nutritivo`
--
ALTER TABLE `aditivo_nutritivo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conservante`
--
ALTER TABLE `conservante`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `embalagem`
--
ALTER TABLE `embalagem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `picole`
--
ALTER TABLE `picole`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `revendedor`
--
ALTER TABLE `revendedor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sabor`
--
ALTER TABLE `sabor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
