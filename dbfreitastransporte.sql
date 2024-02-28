use dbfreitastransporte;

DROP TABLE IF EXISTS `caminhao`;
CREATE TABLE IF NOT EXISTS `caminhao` (
  `placa` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `modelo` varchar(40) NOT NULL,
  `renavam` int NOT NULL,
  `chassi` char(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `anofabricacao` year NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `datacompra` date DEFAULT NULL,
  `valorcompra` double(9,2) DEFAULT NULL,
  `cor` varchar(30) DEFAULT NULL,
  `tipocaminhao` int NOT NULL,
  `tipocombustivel` enum('Diesel','Gasolina','Etanol') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alturaIN` double(9,2) DEFAULT NULL,
  `larguraIN` double(9,2) DEFAULT NULL,
  `comprimentoIN` double(9,2) DEFAULT NULL,
  `alturaEX` double(9,2) DEFAULT NULL,
  `larguraEX` decimal(9,2) DEFAULT NULL,
  `comprimentoEX` double(9,2) DEFAULT NULL,
  PRIMARY KEY (`placa`),
  foreign key (tipocaminhao) references id(tipocaminhao)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE IF NOT EXISTS `documentos` (
  `id_documentos` int NOT NULL AUTO_INCREMENT,
  `arquivos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `cpf_documentos` char(14) NOT NULL,
  PRIMARY KEY (`id_documentos`),
  KEY `cpf_documentos` (`cpf_documentos`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `documento_caminhao`;
CREATE TABLE IF NOT EXISTS `documento_caminhao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arquivos` varchar(200) NOT NULL,
  `descricao` varchar(60) NOT NULL,
  `placa_documento` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `placa_documento` (`placa_documento`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `cpf` char(14) NOT NULL,
  `registro` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome_funcionarios` varchar(100) NOT NULL,
  `tipo` int not null,
  `rua` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` char(9) NOT NULL,
  `uf` enum('AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PI','PB','PR','PE','PA','RJ','RN','RS','RO','RR','SC','SP','SE','TO') NOT NULL,
  `foto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`cpf`),
  foreign key (tipo) references id(profissoes)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `motoristas`;
CREATE TABLE IF NOT EXISTS `motoristas` (
  `registro_habilitacao` int NOT NULL,
  `data_primeira_habilitacao` date NOT NULL,
  `tipo_habilitacao` varchar(5) NOT NULL,
  `data_validade_habilitacao` date NOT NULL,
  `cpf_motoristas` char(14) NOT NULL,
  PRIMARY KEY (`registro_habilitacao`),
  KEY `cpf_motoristas` (`cpf_motoristas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `profissoes`;
CREATE TABLE IF NOT EXISTS `profissoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `profissoes` (`id`, `tipo`) VALUES
(1, 'Motorista');

DROP TABLE IF EXISTS `ref_comerciais`;
CREATE TABLE IF NOT EXISTS `ref_comerciais` (
  `id_comerciais` int NOT NULL AUTO_INCREMENT,
  `nome_comercial` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefone_comercial` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cpf_comercial` char(14) NOT NULL,
  PRIMARY KEY (`id_comerciais`),
  KEY `cpf_comercial` (`cpf_comercial`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `ref_profissionais`;
CREATE TABLE IF NOT EXISTS `ref_profissionais` (
  `id_profissional` int NOT NULL AUTO_INCREMENT,
  `telefone` varchar(20) NOT NULL,
  `nome_empresa` varchar(45) NOT NULL,
  `cpf_empresa` char(14) NOT NULL,
  PRIMARY KEY (`id_profissional`),
  KEY `cpf_empresa` (`cpf_empresa`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `tipocaminhao`;
CREATE TABLE IF NOT EXISTS `tipocaminhao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tipocaminhao` (`id`, `tipo`) VALUES
(2, 'Baú');