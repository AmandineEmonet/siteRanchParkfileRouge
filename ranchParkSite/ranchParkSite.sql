--
-- Base de données :  `ranchpark`
--

-- --------------------------------------------------------
--
-- Structure de la table `user`
--
CREATE DATABASE ranchpark;
USE ranchpark;


DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT primary key,
  `name_user` varchar(50),
  `first_name_user` varchar(50),
  `mail_user` varchar(191),
  `password_user` varchar(100),
  `creation_date_user` datetime,
  `n_pwd_user` int default (0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `attraction` (
  `id_attraction` int NOT NULL AUTO_INCREMENT primary key,
  `name_attraction` varchar(50),
  `detail_attraction` longtext,
  `id_user` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table attraction
add constraint fk_IdUser 
foreign key (id_user) 
references user(id_user);


