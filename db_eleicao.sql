-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `db_eleicao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bloqueio`
--

CREATE TABLE IF NOT EXISTS `bloqueio` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `bloqueio`
--

INSERT INTO `bloqueio` (`id`, `password`) VALUES
(1, '123456');

-- --------------------------------------------------------

--
-- Estrutura da tabela `candidatos`
--

CREATE TABLE IF NOT EXISTS `candidatos` (
  `id_candidato` int(2) NOT NULL AUTO_INCREMENT,
  `chapa` varchar(50) NOT NULL,
  `numero` int(10) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_candidato`),
  UNIQUE KEY `id_candidato` (`id_candidato`),
  UNIQUE KEY `chapa` (`chapa`),
  UNIQUE KEY `numero` (`numero`),
  UNIQUE KEY `foto` (`foto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `eleicao_tipo`
--

CREATE TABLE IF NOT EXISTS `eleicao_tipo` (
  `id_tipo` int(2) NOT NULL AUTO_INCREMENT,
  `eleicao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo`),
  UNIQUE KEY `id_tipo` (`id_tipo`),
  KEY `id_tipo_2` (`id_tipo`),
  KEY `id_tipo_3` (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `eleicao_tipo`
--

INSERT INTO `eleicao_tipo` (`id_tipo`, `eleicao`) VALUES
(1, 'ELEIÃ‡Ã•ES 2022');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(2) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(10) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `usuario`, `senha`) VALUES
(1, 'admin', 'qwe@1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `votacao`
--

CREATE TABLE IF NOT EXISTS `votacao` (
  `id_votos` int(3) NOT NULL AUTO_INCREMENT,
  `chapa` varchar(20) DEFAULT NULL,
  `numero` int(10) DEFAULT NULL,
  `Qtd` varchar(3) NOT NULL,
  PRIMARY KEY (`id_votos`),
  UNIQUE KEY `id_votos` (`id_votos`),
  KEY `id_votos_2` (`id_votos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Extraindo dados da tabela `votacao`
--

INSERT INTO `votacao` (`id_votos`, `chapa`, `numero`, `Qtd`) VALUES
(33, NULL, NULL, ''),
(34, NULL, NULL, ''),
(35, NULL, NULL, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
