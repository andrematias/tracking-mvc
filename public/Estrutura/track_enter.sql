SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `track_enter` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `track_enter`;

CREATE TABLE `tr_base` (
  `id_base` int(11) NOT NULL,
  `id_source` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_session` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `empresa` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `ramo` varchar(50) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `uf` varchar(3) DEFAULT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `lead_type` varchar(20) DEFAULT 'Indireto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tr_cliente` (
  `id_cliente` int(11) NOT NULL,
  `cliente` varchar(50) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_coment` (
  `id_coment` int(11) NOT NULL,
  `id_url` int(11) NOT NULL,
  `coment` text COLLATE latin1_general_ci,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_login` (
  `id_login` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `type_user` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_session` (
  `id_session` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_url` int(11) NOT NULL,
  `session_date` date DEFAULT NULL,
  `session_hour` time DEFAULT NULL,
  `session_start` time DEFAULT NULL,
  `session_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_source` (
  `id_source` int(11) NOT NULL,
  `source` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `default_score` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_type` (
  `id_type` int(11) NOT NULL,
  `type_interest` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `type_bl` varchar(100) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_url` (
  `id_url` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_source` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `short_url` varchar(200) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tr_user` (
  `id_user` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `user` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `cliente` varchar(50) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


ALTER TABLE `tr_base`
  ADD PRIMARY KEY (`id_base`),
  ADD KEY `id_base_source` (`id_source`),
  ADD KEY `id_base_user` (`id_user`),
  ADD KEY `id_base_session` (`id_session`),
  ADD KEY `fk_cliente_base` (`id_cliente`);

ALTER TABLE `tr_cliente`
  ADD PRIMARY KEY (`id_cliente`);

ALTER TABLE `tr_coment`
  ADD PRIMARY KEY (`id_coment`),
  ADD KEY `fk_url` (`id_url`);

ALTER TABLE `tr_login`
  ADD PRIMARY KEY (`id_login`);

ALTER TABLE `tr_session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `id_session_user` (`id_user`),
  ADD KEY `id_session_url` (`id_url`);

ALTER TABLE `tr_source`
  ADD PRIMARY KEY (`id_source`);

ALTER TABLE `tr_type`
  ADD PRIMARY KEY (`id_type`);

ALTER TABLE `tr_url`
  ADD PRIMARY KEY (`id_url`),
  ADD KEY `id_source_url` (`id_source`),
  ADD KEY `id_type_url` (`id_type`),
  ADD KEY `fk_url_id_cliente` (`id_cliente`);

ALTER TABLE `tr_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `user` (`user`),
  ADD KEY `fk_cliente` (`id_cliente`);


ALTER TABLE `tr_base`
  MODIFY `id_base` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_coment`
  MODIFY `id_coment` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_session`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_source`
  MODIFY `id_source` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_url`
  MODIFY `id_url` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tr_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tr_base`
  ADD CONSTRAINT `fk_cliente_base` FOREIGN KEY (`id_cliente`) REFERENCES `tr_cliente` (`id_cliente`),
  ADD CONSTRAINT `id_base_session` FOREIGN KEY (`id_session`) REFERENCES `tr_session` (`id_session`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `id_base_source` FOREIGN KEY (`id_source`) REFERENCES `tr_source` (`id_source`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `id_base_user` FOREIGN KEY (`id_user`) REFERENCES `tr_user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tr_coment`
  ADD CONSTRAINT `fk_url` FOREIGN KEY (`id_url`) REFERENCES `tr_url` (`id_url`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tr_session`
  ADD CONSTRAINT `id_session_url` FOREIGN KEY (`id_url`) REFERENCES `tr_url` (`id_url`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_session_user` FOREIGN KEY (`id_user`) REFERENCES `tr_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tr_url`
  ADD CONSTRAINT `fk_url_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tr_cliente` (`id_cliente`),
  ADD CONSTRAINT `id_source_url` FOREIGN KEY (`id_source`) REFERENCES `tr_source` (`id_source`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `id_type_url` FOREIGN KEY (`id_type`) REFERENCES `tr_type` (`id_type`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tr_user`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tr_cliente` (`id_cliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
