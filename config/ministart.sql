-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Maio-2020 às 00:46
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ministart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `sm_newsletter`
--

DROP TABLE IF EXISTS `sm_newsletter`;
CREATE TABLE IF NOT EXISTS `sm_newsletter`
(
    `newsletter_id`    int(11)      NOT NULL AUTO_INCREMENT,
    `newsletter_email` varchar(255) NOT NULL,
    `newsletter_user`  int(11)           DEFAULT NULL,
    `created_at`       timestamp    NULL DEFAULT NULL,
    `updated_at`       timestamp    NULL DEFAULT NULL,
    PRIMARY KEY (`newsletter_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Essa tabela recebe os e-mail para boletim de noticias';

-- --------------------------------------------------------

--
-- Estrutura da tabela `sm_views`
--

DROP TABLE IF EXISTS `sm_views`;
CREATE TABLE IF NOT EXISTS `sm_views`
(
    `siteviews_id`    int(11)        NOT NULL AUTO_INCREMENT,
    `siteviews_date`  date           NOT NULL,
    `siteviews_users` decimal(10, 0) NOT NULL,
    `siteviews_views` decimal(10, 0) NOT NULL,
    `siteviews_pages` decimal(10, 0) NOT NULL,
    PRIMARY KEY (`siteviews_id`),
    KEY `idx_1` (`siteviews_date`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sm_views_agent`
--

DROP TABLE IF EXISTS `sm_views_agent`;
CREATE TABLE IF NOT EXISTS `sm_views_agent`
(
    `agent_id`       int(11)        NOT NULL AUTO_INCREMENT,
    `agent_name`     varchar(255)   NOT NULL,
    `agent_views`    decimal(10, 0) NOT NULL,
    `agent_lastview` timestamp      NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`agent_id`),
    KEY `idx_1` (`agent_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sm_views_online`
--

DROP TABLE IF EXISTS `sm_views_online`;
CREATE TABLE IF NOT EXISTS `sm_views_online`
(
    `online_id`        int(11)      NOT NULL AUTO_INCREMENT,
    `online_session`   varchar(255) NOT NULL,
    `online_startview` timestamp    NOT NULL DEFAULT current_timestamp(),
    `online_endview`   timestamp    NOT NULL DEFAULT '2019-01-01 02:00:00' ON UPDATE current_timestamp(),
    `online_ip`        varchar(255) NOT NULL,
    `online_url`       varchar(255) NOT NULL,
    `online_agent`     varchar(255) NOT NULL,
    `agent_name`       varchar(255)          DEFAULT NULL,
    PRIMARY KEY (`online_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
