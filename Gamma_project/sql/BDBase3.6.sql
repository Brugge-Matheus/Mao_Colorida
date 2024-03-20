-- --------------------------------------------------------
-- Servidor:                     web.agencia.red
-- Versão do servidor:           5.6.51 - MySQL Community Server (GPL)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela web_Base_2021.area_pretendida
CREATE TABLE IF NOT EXISTS `area_pretendida` (
  `idarea_pretendida` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ididiomas` int(11) DEFAULT NULL,
  PRIMARY KEY (`idarea_pretendida`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.area_pretendida: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `area_pretendida` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_pretendida` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.banner
CREATE TABLE IF NOT EXISTS `banner` (
  `idbanner` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `subtitulo` text,
  `status` char(1) DEFAULT NULL,
  `ordem` int(10) DEFAULT NULL,
  `banner_full` varchar(255) DEFAULT NULL,
  `banner_mobile` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `titulo_botao` varchar(50) DEFAULT NULL,
  `dinamico` int(11) DEFAULT NULL,
  `home` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idbanner`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.banner: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.blog_categoria
CREATE TABLE IF NOT EXISTS `blog_categoria` (
  `idblog_categoria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `urlrewrite` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idblog_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.blog_categoria: 0 rows
/*!40000 ALTER TABLE `blog_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_categoria` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.blog_comentarios
CREATE TABLE IF NOT EXISTS `blog_comentarios` (
  `idblog_comentarios` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `comentario` text,
  `idblog_post` int(10) unsigned DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `data` timestamp NULL DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`idblog_comentarios`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.blog_comentarios: 0 rows
/*!40000 ALTER TABLE `blog_comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_comentarios` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.blog_post
CREATE TABLE IF NOT EXISTS `blog_post` (
  `idblog_post` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `idblog_categoria` int(11) DEFAULT NULL,
  `resumo` text,
  `descricao` text,
  `imagem` varchar(255) DEFAULT NULL,
  `urlrewrite` varchar(160) DEFAULT NULL,
  `keywords` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `m2y` varchar(60) DEFAULT NULL,
  `data_hora` timestamp NULL DEFAULT NULL,
  `contador` int(11) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `link_video` varchar(250) NOT NULL,
  `status` char(1) DEFAULT NULL,
  PRIMARY KEY (`idblog_post`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.blog_post: 0 rows
/*!40000 ALTER TABLE `blog_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_post` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.blog_post_imagem
CREATE TABLE IF NOT EXISTS `blog_post_imagem` (
  `idblog_post_imagem` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idblog_post` int(11) DEFAULT NULL,
  `descricao_imagem` text,
  `urlrewrite_imagem` varchar(255) DEFAULT NULL,
  `m2y_imagem` varchar(255) DEFAULT NULL,
  `nome_imagem` text,
  `posicao_imagem` int(11) DEFAULT NULL,
  `is_default` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`idblog_post_imagem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.blog_post_imagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `blog_post_imagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_post_imagem` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.contatos
CREATE TABLE IF NOT EXISTS `contatos` (
  `idcontatos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `mensagem` varchar(255) DEFAULT NULL,
  `assunto` varchar(255) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `ididiomas` int(10) unsigned NOT NULL,
  `observacao` text NOT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `idservicos` int(10) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `abandonado` tinyint(4) DEFAULT '0',
  `notificado` tinyint(4) DEFAULT '2',
  PRIMARY KEY (`idcontatos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.contatos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `contatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contatos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.depoimento
CREATE TABLE IF NOT EXISTS `depoimento` (
  `iddepoimento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `depoimento` text,
  `subtitulo` varchar(100) DEFAULT NULL,
  `ordem` int(10) unsigned DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddepoimento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.depoimento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `depoimento` DISABLE KEYS */;
/*!40000 ALTER TABLE `depoimento` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.diferenciais
CREATE TABLE IF NOT EXISTS `diferenciais` (
  `iddiferenciais` int(10) NOT NULL AUTO_INCREMENT,
  `idservicos` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `imagem` varchar(250) NOT NULL,
  `icone` varchar(250) NOT NULL,
  `nome_icone` varchar(255) NOT NULL,
  PRIMARY KEY (`iddiferenciais`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Copiando dados para a tabela web_Base_2021.diferenciais: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `diferenciais` DISABLE KEYS */;
/*!40000 ALTER TABLE `diferenciais` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.equipe
CREATE TABLE IF NOT EXISTS `equipe` (
  `idequipe` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text,
  `imagem` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `especialidade` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  PRIMARY KEY (`idequipe`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.equipe: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `equipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipe` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.faq
CREATE TABLE IF NOT EXISTS `faq` (
  `idfaq` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` text,
  `resposta` text,
  `status` char(1) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idfaq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.faq: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.features
CREATE TABLE IF NOT EXISTS `features` (
  `idfeatures` int(11) NOT NULL AUTO_INCREMENT,
  `icone` varchar(50) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `ordem` smallint(2) DEFAULT NULL,
  `sufixo` varchar(255) NOT NULL,
  `prefixo` varchar(255) NOT NULL,
  `icone_name` varchar(255) NOT NULL,
  `home` tinyint(1) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idfeatures`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.features: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
/*!40000 ALTER TABLE `features` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.galeria
CREATE TABLE IF NOT EXISTS `galeria` (
  `idgaleria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  PRIMARY KEY (`idgaleria`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.galeria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `galeria` DISABLE KEYS */;
INSERT IGNORE INTO `galeria` (`idgaleria`, `nome`, `status`) VALUES
	(1, 'Galeria 1', 'A');
/*!40000 ALTER TABLE `galeria` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.galeria_imagem
CREATE TABLE IF NOT EXISTS `galeria_imagem` (
  `idgaleria_imagem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idgaleria` int(10) unsigned NOT NULL,
  `descricao_imagem` text,
  `urlrewrite_imagem` varchar(255) DEFAULT NULL,
  `m2y_imagem` varchar(255) DEFAULT NULL,
  `nome_imagem` text,
  `posicao_imagem` int(11) DEFAULT NULL,
  `is_default` int(1) unsigned DEFAULT NULL COMMENT '1 -> É padrão. qualquer valor diferente de 1 pode ser considerado como "não padrão"',
  PRIMARY KEY (`idgaleria_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.galeria_imagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `galeria_imagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `galeria_imagem` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.idiomas
CREATE TABLE IF NOT EXISTS `idiomas` (
  `ididiomas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idioma` varchar(255) DEFAULT NULL,
  `bandeira` varchar(255) DEFAULT NULL,
  `urlamigavel` varchar(255) DEFAULT NULL,
  `status` int(1) unsigned DEFAULT NULL,
  `principal` int(1) DEFAULT NULL,
  PRIMARY KEY (`ididiomas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.idiomas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `idiomas` DISABLE KEYS */;
/*!40000 ALTER TABLE `idiomas` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.idiomas_traducao
CREATE TABLE IF NOT EXISTS `idiomas_traducao` (
  `ididiomas_traducao` int(11) NOT NULL AUTO_INCREMENT,
  `ididiomas` int(10) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL DEFAULT '',
  `texto` mediumtext,
  PRIMARY KEY (`ididiomas_traducao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela web_Base_2021.idiomas_traducao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `idiomas_traducao` DISABLE KEYS */;
/*!40000 ALTER TABLE `idiomas_traducao` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.idiomas_traducao_meses
CREATE TABLE IF NOT EXISTS `idiomas_traducao_meses` (
  `ididiomas_traducao_meses` int(11) NOT NULL AUTO_INCREMENT,
  `ididiomas` int(10) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL DEFAULT '',
  `texto` mediumtext,
  PRIMARY KEY (`ididiomas_traducao_meses`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela web_Base_2021.idiomas_traducao_meses: ~36 rows (aproximadamente)
/*!40000 ALTER TABLE `idiomas_traducao_meses` DISABLE KEYS */;
INSERT IGNORE INTO `idiomas_traducao_meses` (`ididiomas_traducao_meses`, `ididiomas`, `tag`, `texto`) VALUES
	(2, 1, 'January', 'Janeiro'),
	(3, 1, 'February', 'Fevereiro'),
	(4, 1, 'March', 'Março'),
	(5, 1, 'April', 'Abril'),
	(6, 1, 'May', 'Maio'),
	(7, 1, 'June', 'Junho'),
	(8, 1, 'July', 'Julho'),
	(9, 1, 'August', 'Agosto'),
	(10, 1, 'September', 'Setembro'),
	(11, 1, 'October', 'Outubro'),
	(12, 1, 'November', 'Novembro'),
	(13, 1, 'December', 'Dezembro'),
	(14, 2, 'January', 'January'),
	(15, 2, 'February', 'February'),
	(16, 2, 'March', 'March'),
	(17, 2, 'April', 'April'),
	(18, 2, 'May', 'May'),
	(19, 2, 'June', 'June'),
	(20, 2, 'July', 'July'),
	(21, 2, 'August', 'August'),
	(22, 2, 'September', 'September'),
	(23, 2, 'October', 'October'),
	(24, 2, 'November', 'November'),
	(25, 2, 'December', 'December'),
	(26, 3, 'January', 'Enero'),
	(27, 3, 'February', 'Febrero'),
	(28, 3, 'March', 'Marzo'),
	(29, 3, 'April', 'Abril'),
	(30, 3, 'May', 'Mayo'),
	(31, 3, 'June', 'Junio'),
	(32, 3, 'July', 'Julio'),
	(33, 3, 'August', 'Agosto'),
	(34, 3, 'September', 'Septiembre'),
	(35, 3, 'October', 'Octubre'),
	(36, 3, 'November', 'Noviembre'),
	(37, 3, 'December', 'Diciembre');
/*!40000 ALTER TABLE `idiomas_traducao_meses` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.integracoes
CREATE TABLE IF NOT EXISTS `integracoes` (
  `idintegracoes` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` text NOT NULL,
  `senha` text NOT NULL,
  `token` text NOT NULL,
  `integracao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idintegracoes`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela web_Base_2021.integracoes: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `integracoes` DISABLE KEYS */;
INSERT IGNORE INTO `integracoes` (`idintegracoes`, `usuario`, `senha`, `token`, `integracao`) VALUES
	(1, '', '', '', 'Google API'),
	(2, '', '', '', 'Google Maps'),
	(3, '', '', '', 'TinyPNG ');
/*!40000 ALTER TABLE `integracoes` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.log
CREATE TABLE IF NOT EXISTS `log` (
  `idlog` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` int(10) unsigned DEFAULT NULL,
  `idcliente` int(10) unsigned DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `request` text NOT NULL,
  PRIMARY KEY (`idlog`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.log: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT IGNORE INTO `log` (`idlog`, `idusuario`, `idcliente`, `datahora`, `modulo`, `descricao`, `request`) VALUES
	(1, 1, NULL, '2022-04-12 10:16:44', 'login', 'Usuario (suporte.red) acessou admin. Usando IP(189.114.234.157)', '[usuario] => suporte.red\r\n[senha] => RedMoney55\r\n');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.logs_acessos
CREATE TABLE IF NOT EXISTS `logs_acessos` (
  `idlogs_acessos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idacessos` int(10) unsigned DEFAULT NULL,
  `idcliente` int(10) unsigned DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `request` text NOT NULL,
  PRIMARY KEY (`idlogs_acessos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.logs_acessos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `logs_acessos` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs_acessos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.log_acessos
CREATE TABLE IF NOT EXISTS `log_acessos` (
  `idlog_acessos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idacessos` int(10) unsigned NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY (`idlog_acessos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.log_acessos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `log_acessos` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_acessos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.newsletter
CREATE TABLE IF NOT EXISTS `newsletter` (
  `idnewsletter` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idnewsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.newsletter: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.parceiros
CREATE TABLE IF NOT EXISTS `parceiros` (
  `idparceiros` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `status` char(1) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idparceiros`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.parceiros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `parceiros` DISABLE KEYS */;
/*!40000 ALTER TABLE `parceiros` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.permissoes
CREATE TABLE IF NOT EXISTS `permissoes` (
  `idpermissao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `apelido` varchar(100) NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`idpermissao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.permissoes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT IGNORE INTO `permissoes` (`idpermissao`, `apelido`, `tags`) VALUES
	(3, 'administrador', 'area_pretendida_criar area_pretendida_editar area_pretendida_visualizar area_pretendida_deletar banner_criar banner_editar banner_visualizar banner_deletar blog_categoria_criar blog_categoria_editar blog_categoria_visualizar blog_categoria_deletar blog_comentarios_criar blog_comentarios_editar blog_comentarios_visualizar blog_comentarios_deletar blog_post_criar blog_post_editar blog_post_visualizar blog_post_deletar contatos_criar contatos_editar contatos_visualizar contatos_deletar depoimento_criar depoimento_editar depoimento_visualizar depoimento_deletar equipe_criar equipe_editar equipe_visualizar equipe_deletar faq_criar faq_editar faq_visualizar faq_deletar features_criar features_editar features_visualizar features_deletar galeria_criar galeria_editar galeria_visualizar galeria_deletar idiomas_criar idiomas_editar idiomas_visualizar idiomas_deletar idiomas_traducao_criar idiomas_traducao_editar idiomas_traducao_visualizar idiomas_traducao_deletar log_criar log_editar log_visualizar log_deletar newsletter_criar newsletter_editar newsletter_visualizar newsletter_deletar parceiros_criar parceiros_editar parceiros_visualizar parceiros_deletar permissao_criar permissao_editar permissao_visualizar permissao_deletar servico_criar servico_editar servico_visualizar servico_deletar solucoes_criar solucoes_editar solucoes_visualizar solucoes_deletar timeline_criar timeline_editar timeline_visualizar timeline_deletar trabalhe_conosco_criar trabalhe_conosco_editar trabalhe_conosco_visualizar trabalhe_conosco_deletar usuario_criar usuario_editar usuario_visualizar usuario_deletar');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.recursos
CREATE TABLE IF NOT EXISTS `recursos` (
  `idrecursos` int(10) NOT NULL AUTO_INCREMENT,
  `idtratamentos` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `imagem` varchar(250) NOT NULL,
  `icone` varchar(250) NOT NULL,
  `nome_icone` varchar(255) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idrecursos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.recursos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `recursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `recursos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.relatorios
CREATE TABLE IF NOT EXISTS `relatorios` (
  `idrelatorios` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `imagem` varchar(250) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `data` date NOT NULL,
  `texto` varchar(255) NOT NULL,
  `ano` int(4) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `m_arquivos` text,
  PRIMARY KEY (`idrelatorios`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Copiando dados para a tabela web_Base_2021.relatorios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `relatorios` DISABLE KEYS */;
/*!40000 ALTER TABLE `relatorios` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.seo
CREATE TABLE IF NOT EXISTS `seo` (
  `idseo` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `urlrewrite` varchar(255) NOT NULL,
  PRIMARY KEY (`idseo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.seo: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT IGNORE INTO `seo` (`idseo`, `title`, `description`, `keywords`, `urlrewrite`) VALUES
	(1, 'Home', 'Description', 'Keywords', 'home'),
	(2, 'STATUS CODE 404', 'STATUS CODE 404', 'STATUS CODE 404', '404'),
	(3, 'Blog', 'Blog', 'Blog', 'blog');
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.servicos
CREATE TABLE IF NOT EXISTS `servicos` (
  `idservicos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `resumo` text NOT NULL,
  `descricao` text NOT NULL,
  `urlamigavel` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(150) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `thumbs` varchar(250) NOT NULL,
  `banner_topo` varchar(255) NOT NULL,
  `slogan_faq` varchar(150) NOT NULL,
  `resumo_faq` varchar(255) NOT NULL,
  `icone_name` varchar(255) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `tipo_thumb` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idservicos`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Copiando dados para a tabela web_Base_2021.servicos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.testes
CREATE TABLE IF NOT EXISTS `testes` (
  `idtestes` int(10) NOT NULL AUTO_INCREMENT,
  `idtratamentos` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `imagem` varchar(250) NOT NULL,
  `icone` varchar(250) NOT NULL,
  `nome_icone` varchar(255) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtestes`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela web_Base_2021.testes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `testes` DISABLE KEYS */;
/*!40000 ALTER TABLE `testes` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.timeline
CREATE TABLE IF NOT EXISTS `timeline` (
  `idtimeline` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `imagem` varchar(250) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `data` date NOT NULL,
  `texto` varchar(255) NOT NULL,
  `ano` int(4) NOT NULL,
  `imagem_2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtimeline`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.timeline: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.trabalhe_conosco
CREATE TABLE IF NOT EXISTS `trabalhe_conosco` (
  `idtrabalhe_conosco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `idarea_pretendida` int(11) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `mensagem` varchar(255) NOT NULL,
  PRIMARY KEY (`idtrabalhe_conosco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.trabalhe_conosco: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `trabalhe_conosco` DISABLE KEYS */;
/*!40000 ALTER TABLE `trabalhe_conosco` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.tratamentos
CREATE TABLE IF NOT EXISTS `tratamentos` (
  `idtratamentos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `urlrewrite` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `resumo` varchar(255) DEFAULT NULL,
  `descricao` text,
  `banner_topo` varchar(255) DEFAULT NULL,
  `icone_name` varchar(255) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtratamentos`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Copiando dados para a tabela web_Base_2021.tratamentos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tratamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tratamentos` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.tratamentos_imagem
CREATE TABLE IF NOT EXISTS `tratamentos_imagem` (
  `idtratamentos_imagem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idtratamentos` int(10) unsigned NOT NULL,
  `descricao_imagem` text,
  `urlrewrite_imagem` varchar(255) DEFAULT NULL,
  `m2y_imagem` varchar(255) DEFAULT NULL,
  `nome_imagem` text,
  `posicao_imagem` int(11) DEFAULT NULL,
  `is_default` int(1) unsigned DEFAULT NULL COMMENT '1 -> É padrão. qualquer valor diferente de 1 pode ser considerado como "não padrão"',
  PRIMARY KEY (`idtratamentos_imagem`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela web_Base_2021.tratamentos_imagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tratamentos_imagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `tratamentos_imagem` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL DEFAULT '',
  `sobrenome` varchar(20) NOT NULL DEFAULT '',
  `usuario` varchar(50) NOT NULL,
  `senha` binary(16) NOT NULL,
  `email` varchar(60) NOT NULL DEFAULT '',
  `foto` varchar(250) DEFAULT NULL,
  `ultimaacao` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `proximotime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `permissoes` text,
  `status` varchar(1) DEFAULT '1',
  `expiracao` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.usuario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT IGNORE INTO `usuario` (`idusuario`, `nome`, `sobrenome`, `usuario`, `senha`, `email`, `foto`, `ultimaacao`, `proximotime`, `permissoes`, `status`, `expiracao`) VALUES
	(1, 'suporte', 'red', 'suporte.red', _binary 0xA7B15BCF8F1466DA6212410B9BDC23AA, 'atendimento@agencia.red', '5741b893a31602e948484ba5c6564be3.png', '2022-04-12 10:16:44', '2022-04-12 10:21:44', 'area_pretendida_criar area_pretendida_editar area_pretendida_visualizar area_pretendida_deletar banner_criar banner_editar banner_visualizar banner_deletar blog_categoria_criar blog_categoria_editar blog_categoria_visualizar blog_categoria_deletar blog_comentarios_criar blog_comentarios_editar blog_comentarios_visualizar blog_comentarios_deletar blog_post_criar blog_post_editar blog_post_visualizar blog_post_deletar contatos_criar contatos_editar contatos_visualizar contatos_deletar depoimento_criar depoimento_editar depoimento_visualizar depoimento_deletar equipe_criar equipe_editar equipe_visualizar equipe_deletar faq_criar faq_editar faq_visualizar faq_deletar features_criar features_editar features_visualizar features_deletar galeria_criar galeria_editar galeria_visualizar galeria_deletar idiomas_criar idiomas_editar idiomas_visualizar idiomas_deletar idiomas_traducao_criar idiomas_traducao_editar idiomas_traducao_visualizar idiomas_traducao_deletar integracoes_criar integracoes_editar integracoes_visualizar integracoes_deletar log_criar log_editar log_visualizar log_deletar newsletter_criar newsletter_editar newsletter_visualizar newsletter_deletar parceiros_criar parceiros_editar parceiros_visualizar parceiros_deletar permissao_criar permissao_editar permissao_visualizar permissao_deletar relatorios_criar relatorios_editar relatorios_visualizar relatorios_deletar seo_criar seo_editar seo_visualizar seo_deletar solucoes_criar solucoes_editar solucoes_visualizar solucoes_deletar timeline_criar timeline_editar timeline_visualizar timeline_deletar trabalhe_conosco_criar trabalhe_conosco_editar trabalhe_conosco_visualizar trabalhe_conosco_deletar tratamentos_criar tratamentos_editar tratamentos_visualizar tratamentos_deletar usuario_criar usuario_editar usuario_visualizar usuario_deletar configuracoes_listagem_usuarios configuracoes_cadastro_usuarios configuracoes_permissao configuracoes_log', '1', NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Copiando estrutura para tabela web_Base_2021.usuario_acesso
CREATE TABLE IF NOT EXISTS `usuario_acesso` (
  `idacesso` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) unsigned NOT NULL DEFAULT '0',
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY (`idacesso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela web_Base_2021.usuario_acesso: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario_acesso` DISABLE KEYS */;
INSERT IGNORE INTO `usuario_acesso` (`idacesso`, `idusuario`, `data`, `ip`) VALUES
	(1, 1, '2022-04-12 10:16:44', '189.114.234.');
/*!40000 ALTER TABLE `usuario_acesso` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
