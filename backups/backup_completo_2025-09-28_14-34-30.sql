-- Backup do banco de dados: u700101648_wrcXd
-- Data: 2025-09-28 14:34:31

SET FOREIGN_KEY_CHECKS=0;

-- Estrutura da tabela `acesso_rapido`
DROP TABLE IF EXISTS `acesso_rapido`;
CREATE TABLE `acesso_rapido` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL DEFAULT 'fas fa-link',
  `cor_botao` varchar(255) NOT NULL DEFAULT '#007bff',
  `cor_fonte` varchar(255) NOT NULL DEFAULT '#ffffff',
  `ordem` int(11) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `abrir_nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `acesso_rapido`
INSERT INTO `acesso_rapido` VALUES
('1','Vereadores','Conheça os vereadores e suas propostas','/vereadores','fas fa-users','#2563eb','#ffffff','1','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('2','Projetos de Lei','Acompanhe os projetos em tramitação','/projetos-lei','fas fa-gavel','#059669','#ffffff','2','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('3','Sessões','Calendário e atas das sessões plenárias','/sessoes','fas fa-calendar-alt','#dc2626','#ffffff','3','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('4','Transparência','Portal da transparência e acesso à informação','/transparencia','fas fa-eye','#7c3aed','#ffffff','4','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('5','E-SIC','Sistema Eletrônico do Serviço de Informação ao Cidadão','/esic','fas fa-info-circle','#ea580c','#ffffff','5','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('6','Ouvidoria','Canal de comunicação com o cidadão','/ouvidoria','fas fa-comments','#0891b2','#ffffff','6','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31'),
('7','Legislação','Consulte leis municipais e regimento interno','/leis','fas fa-book-open','#8b5cf6','#ffffff','7','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57'),
('8','Notícias','Últimas notícias e comunicados oficiais','/noticias','fas fa-newspaper','#f59e0b','#ffffff','8','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57'),
('9','Documentos','Acesse documentos e publicações oficiais','/documentos','fas fa-file-alt','#10b981','#ffffff','9','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57'),
('10','Agenda','Calendário de eventos e atividades','/agenda','fas fa-calendar-check','#ef4444','#ffffff','10','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57'),
('11','Comissões','Informações sobre comissões permanentes','/comissoes','fas fa-users-cog','#6366f1','#ffffff','11','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57'),
('12','Contato','Entre em contato com a Câmara Municipal','/contato','fas fa-phone','#06b6d4','#ffffff','12','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');

-- Estrutura da tabela `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `cache`
INSERT INTO `cache` VALUES
('camara_municipal_de_exemplolandia_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:12:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:12:\"display_name\";s:1:\"d\";s:11:\"description\";s:1:\"e\";s:6:\"module\";s:1:\"f\";s:6:\"action\";s:1:\"g\";s:9:\"is_system\";s:1:\"h\";s:9:\"is_active\";s:8:\"priority\";s:8:\"priority\";s:10:\"guard_name\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:5:\"color\";}s:11:\"permissions\";a:74:{i:0;a:11:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"noticias.view\";s:1:\"c\";s:20:\"Visualizar Notícias\";s:1:\"d\";s:25:\"Pode visualizar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:2;i:1;i:6;i:2;i:7;i:3;i:9;i:4;i:11;}}i:1;a:11:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"noticias.create\";s:1:\"c\";s:15:\"Criar Notícias\";s:1:\"d\";s:26:\"Pode criar novas notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:6:\"create\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:2;i:1;i:6;i:2;i:7;i:3;i:9;i:4;i:11;}}i:2;a:11:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"noticias.edit\";s:1:\"c\";s:16:\"Editar Notícias\";s:1:\"d\";s:32:\"Pode editar notícias existentes\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:2;i:1;i:6;i:2;i:7;i:3;i:9;i:4;i:11;}}i:3;a:11:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"noticias.delete\";s:1:\"c\";s:17:\"Excluir Notícias\";s:1:\"d\";s:22:\"Pode excluir notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:6:\"delete\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:4;a:11:{s:1:\"a\";i:5;s:1:\"b\";s:16:\"noticias.publish\";s:1:\"c\";s:18:\"Publicar Notícias\";s:1:\"d\";s:35:\"Pode publicar/despublicar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:7:\"publish\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:6;i:1;i:7;i:2;i:11;}}i:5;a:11:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:20:\"Visualizar Usuários\";s:1:\"d\";s:34:\"Pode visualizar lista de usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:6;a:11:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:15:\"Criar Usuários\";s:1:\"d\";s:26:\"Pode criar novos usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:6:\"create\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:7;a:11:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"users.edit\";s:1:\"c\";s:16:\"Editar Usuários\";s:1:\"d\";s:30:\"Pode editar dados de usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:8;a:11:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:17:\"Excluir Usuários\";s:1:\"d\";s:22:\"Pode excluir usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:6:\"delete\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:9;a:11:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"users.permissions\";s:1:\"c\";s:21:\"Gerenciar Permissões\";s:1:\"d\";s:39:\"Pode gerenciar permissões de usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:10;a:11:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"esic.view\";s:1:\"c\";s:16:\"Visualizar e-SIC\";s:1:\"d\";s:36:\"Pode visualizar solicitações e-SIC\";s:1:\"e\";s:4:\"esic\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:3;i:2;i:11;}}i:11;a:11:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"esic.respond\";s:1:\"c\";s:15:\"Responder e-SIC\";s:1:\"d\";s:35:\"Pode responder solicitações e-SIC\";s:1:\"e\";s:4:\"esic\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:3;i:2;i:11;}}i:12;a:11:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"esic.manage\";s:1:\"c\";s:15:\"Gerenciar e-SIC\";s:1:\"d\";s:35:\"Pode gerenciar todo o sistema e-SIC\";s:1:\"e\";s:4:\"esic\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:11;}}i:13;a:11:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"ouvidoria.view\";s:1:\"c\";s:20:\"Visualizar Ouvidoria\";s:1:\"d\";s:44:\"Pode visualizar manifestações da ouvidoria\";s:1:\"e\";s:9:\"ouvidoria\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:4;i:2;i:11;}}i:14;a:11:{s:1:\"a\";i:15;s:1:\"b\";s:17:\"ouvidoria.respond\";s:1:\"c\";s:19:\"Responder Ouvidoria\";s:1:\"d\";s:43:\"Pode responder manifestações da ouvidoria\";s:1:\"e\";s:9:\"ouvidoria\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:4;i:2;i:11;}}i:15;a:11:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"ouvidoria.manage\";s:1:\"c\";s:19:\"Gerenciar Ouvidoria\";s:1:\"d\";s:42:\"Pode gerenciar todo o sistema de ouvidoria\";s:1:\"e\";s:9:\"ouvidoria\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:11;}}i:16;a:11:{s:1:\"a\";i:17;s:1:\"b\";s:15:\"legislacao.view\";s:1:\"c\";s:23:\"Visualizar Legislação\";s:1:\"d\";s:31:\"Pode visualizar projetos e leis\";s:1:\"e\";s:10:\"legislacao\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:17;a:11:{s:1:\"a\";i:18;s:1:\"b\";s:17:\"legislacao.create\";s:1:\"c\";s:18:\"Criar Legislação\";s:1:\"d\";s:26:\"Pode criar projetos de lei\";s:1:\"e\";s:10:\"legislacao\";s:1:\"f\";s:6:\"create\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:18;a:11:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"legislacao.edit\";s:1:\"c\";s:19:\"Editar Legislação\";s:1:\"d\";s:27:\"Pode editar projetos e leis\";s:1:\"e\";s:10:\"legislacao\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:19;a:11:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"legislacao.approve\";s:1:\"c\";s:20:\"Aprovar Legislação\";s:1:\"d\";s:28:\"Pode aprovar projetos de lei\";s:1:\"e\";s:10:\"legislacao\";s:1:\"f\";s:7:\"approve\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:11;}}i:20;a:11:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"vereadores.view\";s:1:\"c\";s:21:\"Visualizar Vereadores\";s:1:\"d\";s:36:\"Pode visualizar dados dos vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:21;a:11:{s:1:\"a\";i:22;s:1:\"b\";s:15:\"vereadores.edit\";s:1:\"c\";s:17:\"Editar Vereadores\";s:1:\"d\";s:32:\"Pode editar dados dos vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:22;a:11:{s:1:\"a\";i:23;s:1:\"b\";s:17:\"vereadores.manage\";s:1:\"c\";s:20:\"Gerenciar Vereadores\";s:1:\"d\";s:37:\"Pode gerenciar cadastro de vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:11;}}i:23;a:11:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"sessoes.view\";s:1:\"c\";s:19:\"Visualizar Sessões\";s:1:\"d\";s:35:\"Pode visualizar sessões da câmara\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:5;i:1;i:6;i:2;i:11;}}i:24;a:11:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"sessoes.create\";s:1:\"c\";s:14:\"Criar Sessões\";s:1:\"d\";s:25:\"Pode criar novas sessões\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:6:\"create\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:11;}}i:25;a:11:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"sessoes.edit\";s:1:\"c\";s:15:\"Editar Sessões\";s:1:\"d\";s:31:\"Pode editar sessões existentes\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:4:\"edit\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:11;}}i:26;a:11:{s:1:\"a\";i:27;s:1:\"b\";s:18:\"transparencia.view\";s:1:\"c\";s:25:\"Visualizar Transparência\";s:1:\"d\";s:39:\"Pode visualizar dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:9;i:2;i:11;}}i:27;a:11:{s:1:\"a\";i:28;s:1:\"b\";s:20:\"transparencia.manage\";s:1:\"c\";s:24:\"Gerenciar Transparência\";s:1:\"d\";s:38:\"Pode gerenciar dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:9;i:2;i:11;}}i:28;a:11:{s:1:\"a\";i:29;s:1:\"b\";s:14:\"protocolo.view\";s:1:\"c\";s:21:\"Visualizar Protocolos\";s:1:\"d\";s:26:\"Pode visualizar protocolos\";s:1:\"e\";s:9:\"protocolo\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:11;}}i:29;a:11:{s:1:\"a\";i:30;s:1:\"b\";s:16:\"protocolo.create\";s:1:\"c\";s:16:\"Criar Protocolos\";s:1:\"d\";s:27:\"Pode criar novos protocolos\";s:1:\"e\";s:9:\"protocolo\";s:1:\"f\";s:6:\"create\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:11;}}i:30;a:11:{s:1:\"a\";i:31;s:1:\"b\";s:16:\"protocolo.manage\";s:1:\"c\";s:20:\"Gerenciar Protocolos\";s:1:\"d\";s:35:\"Pode gerenciar sistema de protocolo\";s:1:\"e\";s:9:\"protocolo\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:11;}}i:31;a:11:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"admin.dashboard\";s:1:\"c\";s:15:\"Dashboard Admin\";s:1:\"d\";s:37:\"Pode acessar dashboard administrativo\";s:1:\"e\";s:5:\"admin\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:9:{i:0;i:2;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:6;i:5;i:7;i:6;i:8;i:7;i:9;i:8;i:11;}}i:32;a:11:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"admin.config\";s:1:\"c\";s:15:\"Configurações\";s:1:\"d\";s:39:\"Pode alterar configurações do sistema\";s:1:\"e\";s:5:\"admin\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:33;a:11:{s:1:\"a\";i:34;s:1:\"b\";s:10:\"admin.logs\";s:1:\"c\";s:15:\"Visualizar Logs\";s:1:\"d\";s:31:\"Pode visualizar logs do sistema\";s:1:\"e\";s:5:\"admin\";s:1:\"f\";s:4:\"view\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:34;a:11:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"system.roles\";s:1:\"c\";s:15:\"Gerenciar Roles\";s:1:\"d\";s:33:\"Pode gerenciar tipos de usuários\";s:1:\"e\";s:7:\"sistema\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:35;a:11:{s:1:\"a\";i:36;s:1:\"b\";s:18:\"system.permissions\";s:1:\"c\";s:21:\"Gerenciar Permissões\";s:1:\"d\";s:37:\"Pode gerenciar permissões do sistema\";s:1:\"e\";s:7:\"sistema\";s:1:\"f\";s:6:\"manage\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:0;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:36;a:11:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"usuarios.listar\";s:1:\"c\";s:16:\"Listar usuários\";s:1:\"d\";s:32:\"Permissão para Listar usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:37;a:11:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"usuarios.criar\";s:1:\"c\";s:15:\"Criar usuários\";s:1:\"d\";s:31:\"Permissão para Criar usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:38;a:11:{s:1:\"a\";i:39;s:1:\"b\";s:15:\"usuarios.editar\";s:1:\"c\";s:16:\"Editar usuários\";s:1:\"d\";s:32:\"Permissão para Editar usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:39;a:11:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"usuarios.excluir\";s:1:\"c\";s:17:\"Excluir usuários\";s:1:\"d\";s:33:\"Permissão para Excluir usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:40;a:11:{s:1:\"a\";i:41;s:1:\"b\";s:23:\"usuarios.impersonificar\";s:1:\"c\";s:31:\"Fazer login como outro usuário\";s:1:\"d\";s:47:\"Permissão para Fazer login como outro usuário\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:14:\"impersonificar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:41;a:11:{s:1:\"a\";i:42;s:1:\"b\";s:24:\"usuarios.gerenciar_roles\";s:1:\"c\";s:28:\"Gerenciar roles de usuários\";s:1:\"d\";s:44:\"Permissão para Gerenciar roles de usuários\";s:1:\"e\";s:8:\"usuarios\";s:1:\"f\";s:15:\"gerenciar_roles\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:42;a:11:{s:1:\"a\";i:43;s:1:\"b\";s:12:\"roles.listar\";s:1:\"c\";s:12:\"Listar roles\";s:1:\"d\";s:28:\"Permissão para Listar roles\";s:1:\"e\";s:5:\"roles\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:43;a:11:{s:1:\"a\";i:44;s:1:\"b\";s:11:\"roles.criar\";s:1:\"c\";s:11:\"Criar roles\";s:1:\"d\";s:27:\"Permissão para Criar roles\";s:1:\"e\";s:5:\"roles\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:44;a:11:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"roles.editar\";s:1:\"c\";s:12:\"Editar roles\";s:1:\"d\";s:28:\"Permissão para Editar roles\";s:1:\"e\";s:5:\"roles\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:45;a:11:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"roles.excluir\";s:1:\"c\";s:13:\"Excluir roles\";s:1:\"d\";s:29:\"Permissão para Excluir roles\";s:1:\"e\";s:5:\"roles\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:46;a:11:{s:1:\"a\";i:47;s:1:\"b\";s:17:\"permissoes.listar\";s:1:\"c\";s:18:\"Listar permissões\";s:1:\"d\";s:34:\"Permissão para Listar permissões\";s:1:\"e\";s:10:\"permissoes\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:47;a:11:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"permissoes.criar\";s:1:\"c\";s:17:\"Criar permissões\";s:1:\"d\";s:33:\"Permissão para Criar permissões\";s:1:\"e\";s:10:\"permissoes\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:48;a:11:{s:1:\"a\";i:49;s:1:\"b\";s:17:\"permissoes.editar\";s:1:\"c\";s:18:\"Editar permissões\";s:1:\"d\";s:34:\"Permissão para Editar permissões\";s:1:\"e\";s:10:\"permissoes\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:49;a:11:{s:1:\"a\";i:50;s:1:\"b\";s:18:\"permissoes.excluir\";s:1:\"c\";s:19:\"Excluir permissões\";s:1:\"d\";s:35:\"Permissão para Excluir permissões\";s:1:\"e\";s:10:\"permissoes\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:50;a:11:{s:1:\"a\";i:51;s:1:\"b\";s:17:\"vereadores.listar\";s:1:\"c\";s:17:\"Listar vereadores\";s:1:\"d\";s:33:\"Permissão para Listar vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:51;a:11:{s:1:\"a\";i:52;s:1:\"b\";s:16:\"vereadores.criar\";s:1:\"c\";s:16:\"Criar vereadores\";s:1:\"d\";s:32:\"Permissão para Criar vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:52;a:11:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"vereadores.editar\";s:1:\"c\";s:17:\"Editar vereadores\";s:1:\"d\";s:33:\"Permissão para Editar vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:53;a:11:{s:1:\"a\";i:54;s:1:\"b\";s:18:\"vereadores.excluir\";s:1:\"c\";s:18:\"Excluir vereadores\";s:1:\"d\";s:34:\"Permissão para Excluir vereadores\";s:1:\"e\";s:10:\"vereadores\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:54;a:11:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"noticias.listar\";s:1:\"c\";s:16:\"Listar notícias\";s:1:\"d\";s:32:\"Permissão para Listar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:55;a:11:{s:1:\"a\";i:56;s:1:\"b\";s:14:\"noticias.criar\";s:1:\"c\";s:15:\"Criar notícias\";s:1:\"d\";s:31:\"Permissão para Criar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:56;a:11:{s:1:\"a\";i:57;s:1:\"b\";s:15:\"noticias.editar\";s:1:\"c\";s:16:\"Editar notícias\";s:1:\"d\";s:32:\"Permissão para Editar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:57;a:11:{s:1:\"a\";i:58;s:1:\"b\";s:16:\"noticias.excluir\";s:1:\"c\";s:17:\"Excluir notícias\";s:1:\"d\";s:33:\"Permissão para Excluir notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:58;a:11:{s:1:\"a\";i:59;s:1:\"b\";s:17:\"noticias.publicar\";s:1:\"c\";s:30:\"Publicar/despublicar notícias\";s:1:\"d\";s:46:\"Permissão para Publicar/despublicar notícias\";s:1:\"e\";s:8:\"noticias\";s:1:\"f\";s:8:\"publicar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:59;a:11:{s:1:\"a\";i:60;s:1:\"b\";s:14:\"sessoes.listar\";s:1:\"c\";s:15:\"Listar sessões\";s:1:\"d\";s:31:\"Permissão para Listar sessões\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:60;a:11:{s:1:\"a\";i:61;s:1:\"b\";s:13:\"sessoes.criar\";s:1:\"c\";s:14:\"Criar sessões\";s:1:\"d\";s:30:\"Permissão para Criar sessões\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:61;a:11:{s:1:\"a\";i:62;s:1:\"b\";s:14:\"sessoes.editar\";s:1:\"c\";s:15:\"Editar sessões\";s:1:\"d\";s:31:\"Permissão para Editar sessões\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:62;a:11:{s:1:\"a\";i:63;s:1:\"b\";s:15:\"sessoes.excluir\";s:1:\"c\";s:16:\"Excluir sessões\";s:1:\"d\";s:32:\"Permissão para Excluir sessões\";s:1:\"e\";s:7:\"sessoes\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:63;a:11:{s:1:\"a\";i:64;s:1:\"b\";s:17:\"documentos.listar\";s:1:\"c\";s:17:\"Listar documentos\";s:1:\"d\";s:33:\"Permissão para Listar documentos\";s:1:\"e\";s:10:\"documentos\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:64;a:11:{s:1:\"a\";i:65;s:1:\"b\";s:16:\"documentos.criar\";s:1:\"c\";s:16:\"Criar documentos\";s:1:\"d\";s:32:\"Permissão para Criar documentos\";s:1:\"e\";s:10:\"documentos\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:65;a:11:{s:1:\"a\";i:66;s:1:\"b\";s:17:\"documentos.editar\";s:1:\"c\";s:17:\"Editar documentos\";s:1:\"d\";s:33:\"Permissão para Editar documentos\";s:1:\"e\";s:10:\"documentos\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:66;a:11:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"documentos.excluir\";s:1:\"c\";s:18:\"Excluir documentos\";s:1:\"d\";s:34:\"Permissão para Excluir documentos\";s:1:\"e\";s:10:\"documentos\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:67;a:11:{s:1:\"a\";i:68;s:1:\"b\";s:20:\"transparencia.listar\";s:1:\"c\";s:30:\"Listar dados de transparência\";s:1:\"d\";s:46:\"Permissão para Listar dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:6:\"listar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:68;a:11:{s:1:\"a\";i:69;s:1:\"b\";s:19:\"transparencia.criar\";s:1:\"c\";s:29:\"Criar dados de transparência\";s:1:\"d\";s:45:\"Permissão para Criar dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:5:\"criar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:69;a:11:{s:1:\"a\";i:70;s:1:\"b\";s:20:\"transparencia.editar\";s:1:\"c\";s:30:\"Editar dados de transparência\";s:1:\"d\";s:46:\"Permissão para Editar dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:70;a:11:{s:1:\"a\";i:71;s:1:\"b\";s:21:\"transparencia.excluir\";s:1:\"c\";s:31:\"Excluir dados de transparência\";s:1:\"d\";s:47:\"Permissão para Excluir dados de transparência\";s:1:\"e\";s:13:\"transparencia\";s:1:\"f\";s:7:\"excluir\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:71;a:11:{s:1:\"a\";i:72;s:1:\"b\";s:24:\"configuracoes.visualizar\";s:1:\"c\";s:26:\"Visualizar configurações\";s:1:\"d\";s:42:\"Permissão para Visualizar configurações\";s:1:\"e\";s:13:\"configuracoes\";s:1:\"f\";s:10:\"visualizar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}i:72;a:11:{s:1:\"a\";i:73;s:1:\"b\";s:20:\"configuracoes.editar\";s:1:\"c\";s:33:\"Editar configurações do sistema\";s:1:\"d\";s:49:\"Permissão para Editar configurações do sistema\";s:1:\"e\";s:13:\"configuracoes\";s:1:\"f\";s:6:\"editar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:11;}}i:73;a:11:{s:1:\"a\";i:74;s:1:\"b\";s:17:\"dashboard.acessar\";s:1:\"c\";s:29:\"Acessar painel administrativo\";s:1:\"d\";s:45:\"Permissão para Acessar painel administrativo\";s:1:\"e\";s:9:\"dashboard\";s:1:\"f\";s:7:\"acessar\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:10;i:1;i:11;}}}s:5:\"roles\";a:10:{i:0;a:9:{s:1:\"a\";i:2;s:1:\"b\";s:10:\"secretario\";s:1:\"c\";s:20:\"Secretário/Assessor\";s:1:\"d\";s:51:\"Pode gerenciar conteúdo e responder solicitações\";s:1:\"j\";s:7:\"#3B82F6\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:5;s:10:\"guard_name\";s:3:\"web\";}i:1;a:9:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"presidente\";s:1:\"c\";s:21:\"Presidente da Câmara\";s:1:\"d\";s:31:\"Presidente da câmara municipal\";s:1:\"j\";s:7:\"#DC2626\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:10;s:10:\"guard_name\";s:3:\"web\";}i:2;a:9:{s:1:\"a\";i:7;s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:19:\"Editor de Conteúdo\";s:1:\"d\";s:37:\"Pode criar e editar conteúdo do site\";s:1:\"j\";s:7:\"#06B6D4\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:4;s:10:\"guard_name\";s:3:\"web\";}i:3;a:9:{s:1:\"a\";i:9;s:1:\"b\";s:8:\"contador\";s:1:\"c\";s:19:\"Contador/Financeiro\";s:1:\"d\";s:51:\"Responsável por dados financeiros e transparência\";s:1:\"j\";s:7:\"#EF4444\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:7;s:10:\"guard_name\";s:3:\"web\";}i:4;a:9:{s:1:\"a\";i:11;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:19:\"Super Administrador\";s:1:\"d\";s:23:\"Acesso total ao sistema\";s:1:\"j\";s:7:\"#DC2626\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:1;s:10:\"guard_name\";s:3:\"web\";}i:5;a:9:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"responsavel_esic\";s:1:\"c\";s:18:\"Responsável e-SIC\";s:1:\"d\";s:55:\"Especialista em transparência e acesso à informação\";s:1:\"j\";s:7:\"#10B981\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:6;s:10:\"guard_name\";s:3:\"web\";}i:6;a:9:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"ouvidor\";s:1:\"c\";s:7:\"Ouvidor\";s:1:\"d\";s:45:\"Responsável por manifestações da ouvidoria\";s:1:\"j\";s:7:\"#F59E0B\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:6;s:10:\"guard_name\";s:3:\"web\";}i:7;a:9:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"vereador\";s:1:\"c\";s:8:\"Vereador\";s:1:\"d\";s:29:\"Vereador da câmara municipal\";s:1:\"j\";s:7:\"#8B5CF6\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:8;s:10:\"guard_name\";s:3:\"web\";}i:8;a:9:{s:1:\"a\";i:8;s:1:\"b\";s:9:\"protocolo\";s:1:\"c\";s:9:\"Protocolo\";s:1:\"d\";s:41:\"Responsável pelo protocolo de documentos\";s:1:\"j\";s:7:\"#84CC16\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:3;s:10:\"guard_name\";s:3:\"web\";}i:9;a:9:{s:1:\"a\";i:10;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:19:\"Administrador Geral\";s:1:\"d\";s:23:\"Acesso total ao sistema\";s:1:\"j\";s:7:\"#1F2937\";s:1:\"g\";i:1;s:1:\"h\";i:1;s:8:\"priority\";i:100;s:10:\"guard_name\";s:3:\"web\";}}}','1759169796');

-- Estrutura da tabela `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `carta_servico_avaliacoes`
DROP TABLE IF EXISTS `carta_servico_avaliacoes`;
CREATE TABLE `carta_servico_avaliacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `carta_servico_id` bigint(20) unsigned NOT NULL,
  `nome_avaliador` varchar(255) DEFAULT NULL,
  `email_avaliador` varchar(255) DEFAULT NULL,
  `nota` int(10) unsigned NOT NULL,
  `comentario` text DEFAULT NULL,
  `ip_avaliador` varchar(255) DEFAULT NULL,
  `aprovado` tinyint(1) NOT NULL DEFAULT 0,
  `data_aprovacao` datetime DEFAULT NULL,
  `aprovado_por` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carta_servico_avaliacoes_aprovado_por_foreign` (`aprovado_por`),
  KEY `carta_servico_avaliacoes_carta_servico_id_aprovado_index` (`carta_servico_id`,`aprovado`),
  KEY `carta_servico_avaliacoes_nota_index` (`nota`),
  CONSTRAINT `carta_servico_avaliacoes_aprovado_por_foreign` FOREIGN KEY (`aprovado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carta_servico_avaliacoes_carta_servico_id_foreign` FOREIGN KEY (`carta_servico_id`) REFERENCES `carta_servicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `carta_servico_categorias`
DROP TABLE IF EXISTS `carta_servico_categorias`;
CREATE TABLE `carta_servico_categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `cor` varchar(7) NOT NULL DEFAULT '#007bff',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `ordem_exibicao` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carta_servico_categorias_ativo_index` (`ativo`),
  KEY `carta_servico_categorias_ordem_exibicao_index` (`ordem_exibicao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `carta_servicos`
DROP TABLE IF EXISTS `carta_servicos`;
CREATE TABLE `carta_servicos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_servico` varchar(20) NOT NULL,
  `nome_servico` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `categoria` enum('acesso_informacao','ouvidoria','transparencia','participacao_social','servicos_administrativos') NOT NULL,
  `base_legal` text NOT NULL,
  `requisitos` text NOT NULL,
  `documentos_necessarios` text NOT NULL,
  `prazo_atendimento_dias` int(11) NOT NULL,
  `custo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `forma_prestacao` text NOT NULL,
  `canais_atendimento` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`canais_atendimento`)),
  `horario_funcionamento` text NOT NULL,
  `endereco_atendimento` text DEFAULT NULL,
  `telefone_contato` varchar(255) DEFAULT NULL,
  `email_contato` varchar(255) DEFAULT NULL,
  `orgao_responsavel` varchar(255) NOT NULL,
  `setor_responsavel` varchar(255) NOT NULL,
  `responsavel_tecnico` varchar(255) NOT NULL,
  `responsavel_aprovacao` varchar(255) NOT NULL,
  `compromissos_qualidade` text NOT NULL,
  `mecanismos_comunicacao` text NOT NULL,
  `procedimentos_reclamacao` text NOT NULL,
  `outras_informacoes` text DEFAULT NULL,
  `legislacao_aplicavel` text NOT NULL,
  `versao` varchar(10) NOT NULL DEFAULT '1.0',
  `data_vigencia` date NOT NULL,
  `data_revisao` date DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `criado_por` bigint(20) unsigned DEFAULT NULL,
  `atualizado_por` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carta_servicos_codigo_servico_unique` (`codigo_servico`),
  KEY `carta_servicos_criado_por_foreign` (`criado_por`),
  KEY `carta_servicos_atualizado_por_foreign` (`atualizado_por`),
  KEY `carta_servicos_categoria_ativo_index` (`categoria`,`ativo`),
  KEY `carta_servicos_codigo_servico_index` (`codigo_servico`),
  KEY `carta_servicos_publicado_ativo_index` (`publicado`,`ativo`),
  CONSTRAINT `carta_servicos_atualizado_por_foreign` FOREIGN KEY (`atualizado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carta_servicos_criado_por_foreign` FOREIGN KEY (`criado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `comite_iniciativa_populars`
DROP TABLE IF EXISTS `comite_iniciativa_populars`;
CREATE TABLE `comite_iniciativa_populars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `numero_assinaturas` int(11) NOT NULL DEFAULT 0,
  `minimo_assinaturas` int(11) NOT NULL DEFAULT 1000,
  `data_inicio_coleta` date DEFAULT NULL,
  `data_fim_coleta` date DEFAULT NULL,
  `status` enum('ativo','validado','rejeitado','arquivado') NOT NULL DEFAULT 'ativo',
  `observacoes` text DEFAULT NULL,
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `comite_iniciativa_populars`
INSERT INTO `comite_iniciativa_populars` VALUES
('1','Comitê Pró-Ciclovias',NULL,'contato@priciclovias.org','(11) 99999-9999',NULL,'1250','1000',NULL,NULL,'ativo',NULL,NULL,'2025-09-27 23:27:13','2025-09-27 23:27:13'),
('2','Movimento Parques Urbanos',NULL,'contato@parquesurbanos.org','(11) 88888-8888',NULL,'2100','1500',NULL,NULL,'ativo',NULL,NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22'),
('3','Comitê Teste Automatizado',NULL,'teste@comite.com.br','(11) 99999-9999','Rua Teste, 123 - Centro','0','1000',NULL,NULL,'ativo','Comitê criado para teste automatizado',NULL,'2025-09-27 23:49:21','2025-09-27 23:49:21'),
('4','Comitê Teste Automatizado','12345678901','teste@comite.com','(11) 99999-9999','Rua Teste, 123','500','1000','2024-01-01','2024-12-31','ativo','Comitê atualizado no teste','\"{\\\"ata\\\":\\\"ata_teste.pdf\\\"}\"','2025-09-27 23:53:14','2025-09-27 23:53:14');

-- Estrutura da tabela `configuracao_gerais`
DROP TABLE IF EXISTS `configuracao_gerais`;
CREATE TABLE `configuracao_gerais` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chave` varchar(255) NOT NULL,
  `valor` text DEFAULT NULL,
  `tipo` varchar(255) NOT NULL DEFAULT 'texto',
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuracao_gerais_chave_unique` (`chave`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `configuracao_gerais`
INSERT INTO `configuracao_gerais` VALUES
('1','brasao_camara','images/brasao-teste.svg','imagem','Brasão da Câmara Municipal exibido no header','1','2025-09-26 07:56:26','2025-09-26 07:57:01'),
('2','logo_footer','images/logo-footer-teste.svg','imagem','Logo da Câmara Municipal exibida no footer','1','2025-09-26 07:56:26','2025-09-26 07:57:12'),
('3','endereco_camara','Rua Principal, 123 - Centro - Cidade/UF - CEP: 12345-678','texto','Endereço completo da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26'),
('4','telefone_camara','(11) 1234-5678','telefone','Telefone principal da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26'),
('5','email_camara','contato@camara.gov.br','email','E-mail principal da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26'),
('6','direitos_autorais','© 2025 Câmara Municipal. Todos os direitos reservados.','texto','Texto de direitos autorais exibido no footer','1','2025-09-26 07:56:26','2025-09-26 07:56:26'),
('7','nome_camara','Câmara Municipal','texto','Nome oficial da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26');

-- Estrutura da tabela `contrato_aditivos`
DROP TABLE IF EXISTS `contrato_aditivos`;
CREATE TABLE `contrato_aditivos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contrato_id` bigint(20) unsigned NOT NULL,
  `numero` varchar(255) NOT NULL,
  `tipo` enum('prazo','valor','prazo_valor','objeto') NOT NULL,
  `objeto` text NOT NULL,
  `valor_aditivo` decimal(15,2) NOT NULL DEFAULT 0.00,
  `prazo_adicional_dias` int(11) NOT NULL DEFAULT 0,
  `data_assinatura` date NOT NULL,
  `data_inicio_vigencia` date NOT NULL,
  `data_fim_vigencia` date DEFAULT NULL,
  `justificativa` text NOT NULL,
  `observacoes` text DEFAULT NULL,
  `arquivo_aditivo` varchar(255) DEFAULT NULL,
  `arquivo_aditivo_original` varchar(255) DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contrato_aditivos_contrato_id_numero_index` (`contrato_id`,`numero`),
  KEY `contrato_aditivos_tipo_index` (`tipo`),
  KEY `contrato_aditivos_data_assinatura_index` (`data_assinatura`),
  CONSTRAINT `contrato_aditivos_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `contrato_fiscalizacaos`
DROP TABLE IF EXISTS `contrato_fiscalizacaos`;
CREATE TABLE `contrato_fiscalizacaos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contrato_id` bigint(20) unsigned NOT NULL,
  `numero_relatorio` varchar(255) DEFAULT NULL,
  `data_fiscalizacao` date NOT NULL,
  `data_fim_vigencia` date DEFAULT NULL,
  `fiscal_responsavel` varchar(255) NOT NULL,
  `numero_portaria` varchar(255) DEFAULT NULL,
  `data_portaria` date DEFAULT NULL,
  `tipo_fiscalizacao` enum('rotina','especial','denuncia','auditoria') NOT NULL,
  `objeto_fiscalizacao` text NOT NULL,
  `observacoes_encontradas` text NOT NULL,
  `status_execucao` enum('conforme','nao_conforme','parcialmente_conforme') NOT NULL,
  `recomendacoes` text DEFAULT NULL,
  `providencias_adotadas` text DEFAULT NULL,
  `prazo_regularizacao` date DEFAULT NULL,
  `status_regularizacao` enum('pendente','em_andamento','regularizado','nao_aplicavel') NOT NULL DEFAULT 'nao_aplicavel',
  `arquivo_relatorio` varchar(255) DEFAULT NULL,
  `arquivo_relatorio_original` varchar(255) DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `arquivo_pdf_original` varchar(255) DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contrato_fiscalizacaos_contrato_id_data_fiscalizacao_index` (`contrato_id`,`data_fiscalizacao`),
  KEY `contrato_fiscalizacaos_tipo_fiscalizacao_index` (`tipo_fiscalizacao`),
  KEY `contrato_fiscalizacaos_status_execucao_index` (`status_execucao`),
  KEY `contrato_fiscalizacaos_status_regularizacao_index` (`status_regularizacao`),
  CONSTRAINT `contrato_fiscalizacaos_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `contratos`
DROP TABLE IF EXISTS `contratos`;
CREATE TABLE `contratos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_contrato_id` bigint(20) unsigned NOT NULL,
  `numero` varchar(255) NOT NULL,
  `processo` varchar(255) DEFAULT NULL,
  `objeto` text NOT NULL,
  `contratado` varchar(255) NOT NULL,
  `cnpj_cpf_contratado` varchar(255) DEFAULT NULL,
  `valor_inicial` decimal(15,2) NOT NULL,
  `valor_atual` decimal(15,2) NOT NULL,
  `data_assinatura` date NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `data_fim_atual` date DEFAULT NULL,
  `status` enum('ativo','suspenso','encerrado','rescindido') NOT NULL DEFAULT 'ativo',
  `observacoes` text DEFAULT NULL,
  `observacoes_transparencia` text DEFAULT NULL,
  `arquivo_contrato` varchar(255) DEFAULT NULL,
  `arquivo_contrato_original` varchar(255) DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `ano_referencia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contratos_numero_unique` (`numero`),
  KEY `contratos_tipo_contrato_id_foreign` (`tipo_contrato_id`),
  KEY `contratos_status_publico_index` (`status`,`publico`),
  KEY `contratos_ano_referencia_index` (`ano_referencia`),
  KEY `contratos_data_inicio_data_fim_index` (`data_inicio`,`data_fim`),
  CONSTRAINT `contratos_tipo_contrato_id_foreign` FOREIGN KEY (`tipo_contrato_id`) REFERENCES `tipo_contratos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `despesas`
DROP TABLE IF EXISTS `despesas`;
CREATE TABLE `despesas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero_empenho` varchar(255) NOT NULL,
  `codigo_despesa` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `funcao` varchar(255) NOT NULL,
  `subfuncao` varchar(255) DEFAULT NULL,
  `programa` varchar(255) DEFAULT NULL,
  `elemento_despesa` varchar(255) NOT NULL,
  `favorecido` varchar(255) NOT NULL,
  `cnpj_cpf_favorecido` varchar(255) DEFAULT NULL,
  `valor_empenhado` decimal(15,2) NOT NULL,
  `valor_liquidado` decimal(15,2) NOT NULL DEFAULT 0.00,
  `valor_pago` decimal(15,2) NOT NULL DEFAULT 0.00,
  `data_empenho` date NOT NULL,
  `data_liquidacao` date DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `mes_referencia` int(11) NOT NULL,
  `ano_referencia` int(11) NOT NULL,
  `modalidade_licitacao` varchar(255) DEFAULT NULL,
  `numero_processo` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('empenhado','liquidado','pago','cancelado') NOT NULL DEFAULT 'empenhado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `despesas_numero_empenho_unique` (`numero_empenho`),
  KEY `despesas_ano_referencia_mes_referencia_index` (`ano_referencia`,`mes_referencia`),
  KEY `despesas_categoria_index` (`categoria`),
  KEY `despesas_favorecido_index` (`favorecido`),
  KEY `despesas_status_index` (`status`),
  KEY `despesas_data_empenho_index` (`data_empenho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `documentos`
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` enum('ata','lei','decreto','resolucao','portaria','edital','contrato','balancete','relatorio','outros') NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `arquivo_path` varchar(255) NOT NULL,
  `arquivo_nome_original` varchar(255) NOT NULL,
  `arquivo_mime_type` varchar(255) NOT NULL,
  `arquivo_tamanho` bigint(20) NOT NULL,
  `numero_documento` varchar(255) DEFAULT NULL,
  `data_documento` date NOT NULL,
  `data_publicacao` date DEFAULT NULL,
  `status` enum('rascunho','publicado','arquivado') NOT NULL DEFAULT 'publicado',
  `usuario_upload_id` bigint(20) unsigned NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `observacoes` text DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `hash_arquivo` varchar(255) DEFAULT NULL,
  `legislatura` int(11) DEFAULT NULL,
  `metadados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadados`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documentos_usuario_upload_id_foreign` (`usuario_upload_id`),
  KEY `documentos_tipo_status_index` (`tipo`,`status`),
  KEY `documentos_data_documento_publico_index` (`data_documento`,`publico`),
  KEY `documentos_categoria_index` (`categoria`),
  KEY `documentos_numero_documento_index` (`numero_documento`),
  CONSTRAINT `documentos_usuario_upload_id_foreign` FOREIGN KEY (`usuario_upload_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `esic_movimentacoes`
DROP TABLE IF EXISTS `esic_movimentacoes`;
CREATE TABLE `esic_movimentacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `esic_solicitacao_id` bigint(20) unsigned NOT NULL,
  `usuario_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('aberta','em_analise','aguardando_informacoes','respondida','negada','parcialmente_atendida','recurso_solicitado','recurso_em_analise','recurso_deferido','recurso_indeferido','finalizada','arquivada') NOT NULL,
  `descricao` text NOT NULL,
  `anexos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anexos`)),
  `data_movimentacao` datetime NOT NULL,
  `ip_usuario` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `esic_movimentacoes_usuario_id_foreign` (`usuario_id`),
  KEY `esic_movimentacoes_esic_solicitacao_id_data_movimentacao_index` (`esic_solicitacao_id`,`data_movimentacao`),
  KEY `esic_movimentacoes_status_index` (`status`),
  CONSTRAINT `esic_movimentacoes_esic_solicitacao_id_foreign` FOREIGN KEY (`esic_solicitacao_id`) REFERENCES `esic_solicitacoes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `esic_movimentacoes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `esic_solicitacoes`
DROP TABLE IF EXISTS `esic_solicitacoes`;
CREATE TABLE `esic_solicitacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `protocolo` varchar(255) NOT NULL,
  `nome_solicitante` varchar(255) NOT NULL,
  `email_solicitante` varchar(255) NOT NULL,
  `telefone_solicitante` varchar(255) DEFAULT NULL,
  `cpf_solicitante` varchar(255) DEFAULT NULL,
  `tipo_pessoa` enum('fisica','juridica') NOT NULL DEFAULT 'fisica',
  `cnpj_solicitante` varchar(255) DEFAULT NULL,
  `endereco_solicitante` text DEFAULT NULL,
  `categoria` enum('informacao','documento','dados','outros') NOT NULL,
  `assunto` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `forma_recebimento` enum('email','presencial','correios') NOT NULL DEFAULT 'email',
  `endereco_resposta` text DEFAULT NULL,
  `status` enum('pendente','em_analise','respondida','negada','parcialmente_atendida','recurso','finalizada') NOT NULL DEFAULT 'pendente',
  `arquivada` tinyint(1) NOT NULL DEFAULT 0,
  `arquivada_em` timestamp NULL DEFAULT NULL,
  `data_limite_resposta` date NOT NULL,
  `resposta` longtext DEFAULT NULL,
  `data_resposta` timestamp NULL DEFAULT NULL,
  `anexos_solicitacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anexos_solicitacao`)),
  `anexos_resposta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anexos_resposta`)),
  `responsavel_id` bigint(20) unsigned DEFAULT NULL,
  `justificativa_negativa` text DEFAULT NULL,
  `recurso_solicitado` tinyint(1) NOT NULL DEFAULT 0,
  `recurso_justificativa` text DEFAULT NULL,
  `recurso_resposta` longtext DEFAULT NULL,
  `tramitacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tramitacao`)),
  `observacoes_internas` text DEFAULT NULL,
  `prazo_prorrogacao_dias` int(11) NOT NULL DEFAULT 0,
  `justificativa_prorrogacao` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `esic_solicitacoes_protocolo_unique` (`protocolo`),
  KEY `esic_solicitacoes_responsavel_id_foreign` (`responsavel_id`),
  KEY `esic_solicitacoes_status_data_limite_resposta_index` (`status`,`data_limite_resposta`),
  KEY `esic_solicitacoes_categoria_status_index` (`categoria`,`status`),
  KEY `esic_solicitacoes_tipo_pessoa_index` (`tipo_pessoa`),
  KEY `esic_solicitacoes_user_id_foreign` (`user_id`),
  CONSTRAINT `esic_solicitacoes_responsavel_id_foreign` FOREIGN KEY (`responsavel_id`) REFERENCES `users` (`id`),
  CONSTRAINT `esic_solicitacoes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `esic_usuarios`
DROP TABLE IF EXISTS `esic_usuarios`;
CREATE TABLE `esic_usuarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `token_ativacao` varchar(255) DEFAULT NULL,
  `token_ativacao_expires_at` timestamp NULL DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires_at` timestamp NULL DEFAULT NULL,
  `aceite_termos` tinyint(1) NOT NULL DEFAULT 0,
  `aceite_termos_at` timestamp NULL DEFAULT NULL,
  `aceite_lgpd` tinyint(1) NOT NULL DEFAULT 0,
  `aceite_lgpd_at` timestamp NULL DEFAULT NULL,
  `ultimo_acesso` timestamp NULL DEFAULT NULL,
  `ip_cadastro` varchar(45) DEFAULT NULL,
  `user_agent_cadastro` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `esic_usuarios_email_unique` (`email`),
  UNIQUE KEY `esic_usuarios_cpf_unique` (`cpf`),
  KEY `esic_usuarios_email_ativo_index` (`email`,`ativo`),
  KEY `esic_usuarios_cpf_ativo_index` (`cpf`,`ativo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `eventos`
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE `eventos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` enum('sessao_plenaria','audiencia_publica','reuniao_comissao','votacao','licitacao','agenda_vereador','ato_vereador','data_comemorativa','prazo_esic','outro') NOT NULL,
  `data_evento` date NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fim` time DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `cor_destaque` varchar(7) NOT NULL DEFAULT '#007bff',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `vereador_id` bigint(20) unsigned DEFAULT NULL,
  `sessao_id` bigint(20) unsigned DEFAULT NULL,
  `licitacao_id` bigint(20) unsigned DEFAULT NULL,
  `esic_solicitacao_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventos_data_evento_index` (`data_evento`),
  KEY `eventos_tipo_index` (`tipo`),
  KEY `eventos_data_evento_tipo_index` (`data_evento`,`tipo`),
  KEY `eventos_ativo_data_evento_index` (`ativo`,`data_evento`),
  KEY `eventos_vereador_id_foreign` (`vereador_id`),
  KEY `eventos_sessao_id_foreign` (`sessao_id`),
  KEY `eventos_licitacao_id_foreign` (`licitacao_id`),
  KEY `eventos_esic_solicitacao_id_foreign` (`esic_solicitacao_id`),
  KEY `eventos_user_id_foreign` (`user_id`),
  CONSTRAINT `eventos_esic_solicitacao_id_foreign` FOREIGN KEY (`esic_solicitacao_id`) REFERENCES `esic_solicitacoes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_licitacao_id_foreign` FOREIGN KEY (`licitacao_id`) REFERENCES `licitacoes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_sessao_id_foreign` FOREIGN KEY (`sessao_id`) REFERENCES `sessoes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_vereador_id_foreign` FOREIGN KEY (`vereador_id`) REFERENCES `vereadores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `eventos`
INSERT INTO `eventos` VALUES
('1','Sessão Ordinária - Discussão do Orçamento 2025','Discussão e votação do projeto de lei orçamentária anual para o exercício de 2025.','sessao_plenaria','2025-09-30','14:00:00','18:00:00','Plenário da Câmara Municipal',NULL,'1','#dc3545','1',NULL,'1',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('2','Sessão Extraordinária - Aprovação de Convênios','Sessão extraordinária para aprovação de convênios com o Estado e União.','sessao_plenaria','2025-10-04','09:00:00','12:00:00','Plenário da Câmara Municipal',NULL,'0','#007bff','1',NULL,'2',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('3','Audiência Pública - Plano Diretor Municipal','Audiência pública para discussão das alterações propostas no Plano Diretor Municipal.','audiencia_publica','2025-10-07','19:00:00','21:00:00','Auditório da Câmara Municipal',NULL,'1','#fd7e14','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('4','Audiência Pública - Saúde Municipal','Prestação de contas e discussão sobre os investimentos em saúde pública municipal.','audiencia_publica','2025-10-12','14:30:00','17:00:00','Auditório da Câmara Municipal',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('5','Reunião da Comissão de Finanças','Análise dos projetos de lei relacionados ao orçamento e finanças municipais.','reuniao_comissao','2025-09-29','08:30:00','11:00:00','Sala da Comissão de Finanças',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('6','Reunião da Comissão de Obras e Serviços Públicos','Discussão sobre projetos de infraestrutura e melhorias urbanas.','reuniao_comissao','2025-10-02','14:00:00','16:30:00','Sala da Comissão de Obras',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('7','Atendimento ao Público - Vereador João Silva','Atendimento aos cidadãos para recebimento de demandas e sugestões.','agenda_vereador','2025-09-28','08:00:00','12:00:00','Gabinete do Vereador',NULL,'0','#007bff','1','1',NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('8','Visita Técnica - Escola Municipal','Visita técnica à Escola Municipal para verificação das condições de infraestrutura.','agenda_vereador','2025-10-01','09:00:00','11:00:00','Escola Municipal Centro',NULL,'0','#007bff','1','2',NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('9','Licitação - Aquisição de Equipamentos de Informática','Abertura de licitação para aquisição de equipamentos de informática para a Câmara.','licitacao','2025-10-09','10:00:00','12:00:00','Sala de Licitações',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('10','Dia do Servidor Público Municipal','Homenagem aos servidores públicos municipais pelos serviços prestados à comunidade.','data_comemorativa','2025-10-17','10:00:00','12:00:00','Plenário da Câmara Municipal',NULL,'1','#ffc107','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('11','Semana do Meio Ambiente','Abertura da Semana do Meio Ambiente com palestras e atividades educativas.','data_comemorativa','2025-10-22','14:00:00','17:00:00','Praça Central',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('12','Votação - Projeto de Lei Complementar nº 001/2024','Votação em segundo turno do Projeto de Lei Complementar sobre o Código Tributário Municipal.','votacao','2025-10-05','15:00:00','17:00:00','Plenário da Câmara Municipal',NULL,'1','#e83e8c','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('13','Sessão Solene - Posse dos Vereadores','Sessão solene de posse dos vereadores eleitos para a legislatura 2021-2024.','sessao_plenaria','2025-08-28','14:00:00','18:00:00','Plenário da Câmara Municipal',NULL,'0','#007bff','1',NULL,'3',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01'),
('14','Confraternização Universal','Feriado nacional - Ano Novo','data_comemorativa','2025-01-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:43','2025-09-27 00:38:43'),
('15','Aniversário de São Paulo','Fundação da cidade de São Paulo','data_comemorativa','2025-01-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('16','Dia de Iemanjá','Festa popular em homenagem à Rainha do Mar','data_comemorativa','2025-02-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('17','Dia Internacional da Mulher','Celebração dos direitos da mulher','data_comemorativa','2025-03-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('18','Dia da Escola','Valorização da educação','data_comemorativa','2025-03-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('19','Dia Mundial da Água','Conscientização sobre a preservação da água','data_comemorativa','2025-03-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('20','Dia Mundial da Saúde','Promoção da saúde pública','data_comemorativa','2025-04-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('21','Dia Nacional do Livro Infantil','Incentivo à leitura infantil','data_comemorativa','2025-04-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('22','Dia do Índio','Valorização da cultura indígena','data_comemorativa','2025-04-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('23','Tiradentes','Feriado nacional - Inconfidência Mineira','data_comemorativa','2025-04-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('24','Descobrimento do Brasil','Chegada dos portugueses ao Brasil','data_comemorativa','2025-04-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('25','Dia Mundial do Livro','Promoção da leitura e literatura','data_comemorativa','2025-04-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('26','Dia do Trabalhador','Feriado nacional - Dia do Trabalho','data_comemorativa','2025-05-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('27','Dia das Mães','Homenagem às mães (segundo domingo de maio)','data_comemorativa','2025-05-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('28','Abolição da Escravatura','Assinatura da Lei Áurea','data_comemorativa','2025-05-13',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('29','Dia Nacional de Combate ao Abuso Sexual','Proteção de crianças e adolescentes','data_comemorativa','2025-05-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('30','Dia Mundial sem Tabaco','Conscientização sobre os malefícios do tabaco','data_comemorativa','2025-05-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('31','Dia Mundial do Meio Ambiente','Conscientização ambiental','data_comemorativa','2025-06-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('32','Dia dos Namorados','Celebração do amor','data_comemorativa','2025-06-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('33','Festa Junina - São João','Tradição cultural brasileira','data_comemorativa','2025-06-24',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('34','Revolução Constitucionalista','Feriado estadual em São Paulo','data_comemorativa','2025-07-09',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('35','Dia do Amigo','Celebração da amizade','data_comemorativa','2025-07-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('36','Dia do Estudante','Valorização da educação','data_comemorativa','2025-08-11',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('37','Dia do Folclore','Preservação da cultura popular','data_comemorativa','2025-08-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('38','Dia Nacional de Combate ao Fumo','Prevenção ao tabagismo','data_comemorativa','2025-08-29',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('39','Independência do Brasil','Feriado nacional - Grito do Ipiranga','data_comemorativa','2025-09-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('40','Dia da Árvore','Conscientização ambiental','data_comemorativa','2025-09-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('41','Início da Primavera','Equinócio de primavera','data_comemorativa','2025-09-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('42','Dia Nacional de Combate ao Câncer Infantil','Conscientização sobre o câncer infantil','data_comemorativa','2025-09-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('43','Dia Mundial dos Animais','Proteção animal','data_comemorativa','2025-10-04',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('44','Dia Mundial dos Professores','Valorização do magistério','data_comemorativa','2025-10-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('45','Nossa Senhora Aparecida','Feriado nacional - Padroeira do Brasil','data_comemorativa','2025-10-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('46','Dia do Professor','Homenagem aos educadores','data_comemorativa','2025-10-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('47','Dia Mundial da Alimentação','Combate à fome','data_comemorativa','2025-10-16',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('48','Dia da Indústria','Desenvolvimento industrial','data_comemorativa','2025-10-17',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('49','Dia das Bruxas (Halloween)','Tradição internacional','data_comemorativa','2025-10-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('50','Finados','Feriado nacional - Dia dos Mortos','data_comemorativa','2025-11-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('51','Proclamação da República','Feriado nacional - Fim do Império','data_comemorativa','2025-11-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('52','Dia da Bandeira','Símbolo nacional','data_comemorativa','2025-11-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('53','Dia da Consciência Negra','Valorização da cultura afro-brasileira','data_comemorativa','2025-11-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('54','Dia Mundial de Combate à AIDS','Prevenção e conscientização','data_comemorativa','2025-12-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('55','Dia Internacional da Pessoa com Deficiência','Inclusão social','data_comemorativa','2025-12-03',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('56','Dia dos Direitos Humanos','Declaração Universal dos Direitos Humanos','data_comemorativa','2025-12-10',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('57','Natal','Feriado nacional - Nascimento de Jesus Cristo','data_comemorativa','2025-12-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('58','Réveillon','Passagem de ano','data_comemorativa','2025-12-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('59','Aniversário do Município','Fundação da cidade - Ajustar data conforme município','data_comemorativa','2025-01-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('60','Dia do Servidor Municipal','Homenagem aos servidores públicos municipais','data_comemorativa','2025-03-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('61','Dia do Município','Celebração da emancipação política','data_comemorativa','2025-04-23',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('62','Festa do Padroeiro','Celebração religiosa local - Ajustar conforme padroeiro','data_comemorativa','2025-06-29',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44'),
('63','Semana da Pátria Municipal','Atividades cívicas locais','data_comemorativa','2025-08-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('64','Semana da Criança','Atividades para o público infantil','data_comemorativa','2025-10-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('65','Dia da Música Municipal','Valorização da cultura musical local','data_comemorativa','2025-11-22',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('66','Confraternização Universal','Feriado nacional - Ano Novo','data_comemorativa','2026-01-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('67','Aniversário de São Paulo','Fundação da cidade de São Paulo','data_comemorativa','2026-01-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('68','Dia de Iemanjá','Festa popular em homenagem à Rainha do Mar','data_comemorativa','2026-02-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('69','Dia Internacional da Mulher','Celebração dos direitos da mulher','data_comemorativa','2026-03-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('70','Dia da Escola','Valorização da educação','data_comemorativa','2026-03-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('71','Dia Mundial da Água','Conscientização sobre a preservação da água','data_comemorativa','2026-03-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('72','Dia Mundial da Saúde','Promoção da saúde pública','data_comemorativa','2026-04-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('73','Dia Nacional do Livro Infantil','Incentivo à leitura infantil','data_comemorativa','2026-04-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('74','Dia do Índio','Valorização da cultura indígena','data_comemorativa','2026-04-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('75','Tiradentes','Feriado nacional - Inconfidência Mineira','data_comemorativa','2026-04-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('76','Descobrimento do Brasil','Chegada dos portugueses ao Brasil','data_comemorativa','2026-04-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('77','Dia Mundial do Livro','Promoção da leitura e literatura','data_comemorativa','2026-04-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('78','Dia do Trabalhador','Feriado nacional - Dia do Trabalho','data_comemorativa','2026-05-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('79','Dia das Mães','Homenagem às mães (segundo domingo de maio)','data_comemorativa','2026-05-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('80','Abolição da Escravatura','Assinatura da Lei Áurea','data_comemorativa','2026-05-13',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('81','Dia Nacional de Combate ao Abuso Sexual','Proteção de crianças e adolescentes','data_comemorativa','2026-05-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('82','Dia Mundial sem Tabaco','Conscientização sobre os malefícios do tabaco','data_comemorativa','2026-05-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('83','Dia Mundial do Meio Ambiente','Conscientização ambiental','data_comemorativa','2026-06-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('84','Dia dos Namorados','Celebração do amor','data_comemorativa','2026-06-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('85','Festa Junina - São João','Tradição cultural brasileira','data_comemorativa','2026-06-24',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('86','Revolução Constitucionalista','Feriado estadual em São Paulo','data_comemorativa','2026-07-09',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('87','Dia do Amigo','Celebração da amizade','data_comemorativa','2026-07-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('88','Dia do Estudante','Valorização da educação','data_comemorativa','2026-08-11',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('89','Dia do Folclore','Preservação da cultura popular','data_comemorativa','2026-08-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('90','Dia Nacional de Combate ao Fumo','Prevenção ao tabagismo','data_comemorativa','2026-08-29',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('91','Independência do Brasil','Feriado nacional - Grito do Ipiranga','data_comemorativa','2026-09-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('92','Dia da Árvore','Conscientização ambiental','data_comemorativa','2026-09-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('93','Início da Primavera','Equinócio de primavera','data_comemorativa','2026-09-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('94','Dia Nacional de Combate ao Câncer Infantil','Conscientização sobre o câncer infantil','data_comemorativa','2026-09-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('95','Dia Mundial dos Animais','Proteção animal','data_comemorativa','2026-10-04',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('96','Dia Mundial dos Professores','Valorização do magistério','data_comemorativa','2026-10-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('97','Nossa Senhora Aparecida','Feriado nacional - Padroeira do Brasil','data_comemorativa','2026-10-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('98','Dia do Professor','Homenagem aos educadores','data_comemorativa','2026-10-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('99','Dia Mundial da Alimentação','Combate à fome','data_comemorativa','2026-10-16',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('100','Dia da Indústria','Desenvolvimento industrial','data_comemorativa','2026-10-17',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('101','Dia das Bruxas (Halloween)','Tradição internacional','data_comemorativa','2026-10-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('102','Finados','Feriado nacional - Dia dos Mortos','data_comemorativa','2026-11-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('103','Proclamação da República','Feriado nacional - Fim do Império','data_comemorativa','2026-11-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('104','Dia da Bandeira','Símbolo nacional','data_comemorativa','2026-11-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('105','Dia da Consciência Negra','Valorização da cultura afro-brasileira','data_comemorativa','2026-11-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('106','Dia Mundial de Combate à AIDS','Prevenção e conscientização','data_comemorativa','2026-12-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('107','Dia Internacional da Pessoa com Deficiência','Inclusão social','data_comemorativa','2026-12-03',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('108','Dia dos Direitos Humanos','Declaração Universal dos Direitos Humanos','data_comemorativa','2026-12-10',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('109','Natal','Feriado nacional - Nascimento de Jesus Cristo','data_comemorativa','2026-12-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('110','Réveillon','Passagem de ano','data_comemorativa','2026-12-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45'),
('111','Aniversário do Município','Fundação da cidade - Ajustar data conforme município','data_comemorativa','2026-01-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('112','Dia do Servidor Municipal','Homenagem aos servidores públicos municipais','data_comemorativa','2026-03-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('113','Dia do Município','Celebração da emancipação política','data_comemorativa','2026-04-23',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('114','Festa do Padroeiro','Celebração religiosa local - Ajustar conforme padroeiro','data_comemorativa','2026-06-29',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('115','Semana da Pátria Municipal','Atividades cívicas locais','data_comemorativa','2026-08-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('116','Semana da Criança','Atividades para o público infantil','data_comemorativa','2026-10-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46'),
('117','Dia da Música Municipal','Valorização da cultura musical local','data_comemorativa','2026-11-22',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');

-- Estrutura da tabela `failed_jobs`
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `folha_pagamento`
DROP TABLE IF EXISTS `folha_pagamento`;
CREATE TABLE `folha_pagamento` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_servidor` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `lotacao` varchar(255) NOT NULL,
  `vinculo` varchar(255) NOT NULL,
  `regime_juridico` varchar(255) DEFAULT NULL,
  `remuneracao_basica` decimal(10,2) NOT NULL,
  `vantagens_pessoais` decimal(10,2) NOT NULL DEFAULT 0.00,
  `funcao_cargo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gratificacoes` decimal(10,2) NOT NULL DEFAULT 0.00,
  `adicionais` decimal(10,2) NOT NULL DEFAULT 0.00,
  `indenizacoes` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descontos_obrigatorios` decimal(10,2) NOT NULL DEFAULT 0.00,
  `outros_descontos` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remuneracao_liquida` decimal(10,2) NOT NULL,
  `diarias` decimal(10,2) NOT NULL DEFAULT 0.00,
  `auxilios` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vantagens_indenizatorias` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mes_referencia` int(11) NOT NULL,
  `ano_referencia` int(11) NOT NULL,
  `data_admissao` date DEFAULT NULL,
  `situacao` varchar(255) NOT NULL DEFAULT 'ativo',
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `folha_pagamento_ano_referencia_mes_referencia_index` (`ano_referencia`,`mes_referencia`),
  KEY `folha_pagamento_cargo_index` (`cargo`),
  KEY `folha_pagamento_lotacao_index` (`lotacao`),
  KEY `folha_pagamento_vinculo_index` (`vinculo`),
  KEY `folha_pagamento_situacao_index` (`situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `hero_configurations`
DROP TABLE IF EXISTS `hero_configurations`;
CREATE TABLE `hero_configurations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL DEFAULT 'Câmara Municipal',
  `descricao` text NOT NULL DEFAULT 'Transparência, participação e representação democrática para nossa cidade.',
  `botao_primario_texto` varchar(255) NOT NULL DEFAULT 'Transparência',
  `botao_primario_link` varchar(255) NOT NULL DEFAULT '/transparencia',
  `botao_primario_nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `botao_secundario_texto` varchar(255) NOT NULL DEFAULT 'Vereadores',
  `botao_secundario_link` varchar(255) NOT NULL DEFAULT '/vereadores',
  `botao_secundario_nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `mostrar_slider` tinyint(1) NOT NULL DEFAULT 1,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `job_batches`
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `jobs`
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `leis`
DROP TABLE IF EXISTS `leis`;
CREATE TABLE `leis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `exercicio` year(4) NOT NULL,
  `data` date NOT NULL,
  `tipo` enum('Lei Ordinária','Lei Complementar','Resolução','Decreto Legislativo','Lei Orgânica','Emenda à Lei Orgânica') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `autoria` varchar(255) DEFAULT NULL,
  `ementa` text DEFAULT NULL,
  `arquivo_pdf` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `observacoes` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `leis_slug_unique` (`slug`),
  KEY `leis_tipo_exercicio_index` (`tipo`,`exercicio`),
  KEY `leis_numero_exercicio_index` (`numero`,`exercicio`),
  KEY `leis_data_index` (`data`),
  KEY `leis_ativo_index` (`ativo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `leis`
INSERT INTO `leis` VALUES
('1','1485','2025','2025-09-16','Lei Ordinária','Lei Municipal nº 1.485 de 16 de setembro de 2025','Esta lei estabelece diretrizes importantes para o desenvolvimento municipal, abordando aspectos fundamentais da administração pública local e promovendo melhorias na qualidade dos serviços prestados à população.','Câmara Municipal','Dispõe sobre normas gerais para o município e dá outras providências.',NULL,'1','Lei de grande relevância para o município.','lei-municipal-1485-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('2','1486','2025','2025-09-20','Lei Ordinária','Dispõe sobre a criação do Programa Municipal de Meio Ambiente','Esta lei cria o Programa Municipal de Meio Ambiente com o objetivo de promover a sustentabilidade, a educação ambiental e a preservação dos recursos naturais do município. O programa incluirá ações de reflorestamento, coleta seletiva e conscientização da população sobre a importância da preservação ambiental.','Vereador João Silva','Institui o Programa Municipal de Meio Ambiente e estabelece diretrizes para a preservação ambiental no município.',NULL,'1','Aprovada por unanimidade.','programa-municipal-meio-ambiente-1486-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('3','1487','2025','2025-09-25','Lei Ordinária','Altera a Lei Municipal de Trânsito e Transporte','<p class=\"artigo\"><strong>Art. 1&ordm; </strong>Esta lei promove altera&ccedil;&otilde;es na legisla&ccedil;&atilde;o municipal de tr&acirc;nsito, estabelecendo novas regras para o transporte p&uacute;blico, criando ciclovias e melhorando a <span style=\"color: rgb(255, 0, 0);\"><strong>sinaliza&ccedil;&atilde;o urbana</strong></span>.</p>
<p class=\"paragrafo\"><strong>&sect; 1&ordm; </strong>As mudan&ccedil;as visam reduzir o <span style=\"background-color: rgb(0, 255, 0);\">tr&acirc;nsito e promover meios</span> de transporte mais sustent&aacute;veis.</p>','Vereadora Maria Santos','Altera dispositivos da Lei Municipal de Trânsito e Transporte para melhorar a mobilidade urbana.',NULL,'1','Entrada em vigor em 60 dias.','alteracao-lei-transito-1487-2025','2025-09-26 07:33:43','2025-09-26 07:37:05'),
('4','45','2025','2025-08-10','Lei Complementar','Código Tributário Municipal','Esta lei complementar estabelece o sistema tributário municipal, definindo os tributos de competência do município, suas bases de cálculo, alíquotas e procedimentos de arrecadação. Inclui disposições sobre IPTU, ISS, taxas municipais e contribuições de melhoria.','Poder Executivo','Institui o Código Tributário Municipal e estabelece normas gerais de direito tributário aplicáveis ao município.',NULL,'1','Substitui a legislação tributária anterior.','codigo-tributario-municipal-45-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('5','46','2025','2025-08-15','Lei Complementar','Plano Diretor Municipal','O Plano Diretor Municipal é o instrumento básico da política de desenvolvimento e expansão urbana. Esta lei estabelece as diretrizes para o crescimento ordenado da cidade, definindo zonas de uso, parâmetros urbanísticos e instrumentos de política urbana.','Comissão Especial','Aprova o Plano Diretor Municipal e estabelece diretrizes para o desenvolvimento urbano.',NULL,'1','Elaborado com participação popular.','plano-diretor-municipal-46-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('6','12','2025','2025-09-05','Resolução','Regimento Interno da Câmara Municipal','Esta resolução estabelece as normas de funcionamento da Câmara Municipal, definindo os procedimentos para as sessões, tramitação de projetos, funcionamento das comissões e demais atividades legislativas.','Mesa Diretora','Aprova o novo Regimento Interno da Câmara Municipal.',NULL,'1','Atualização do regimento anterior.','regimento-interno-camara-12-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('7','13','2025','2025-09-12','Resolução','Criação da Comissão de Ética e Decoro Parlamentar','Esta resolução institui a Comissão de Ética e Decoro Parlamentar, órgão responsável por zelar pela observância dos princípios éticos e das normas de decoro parlamentar pelos membros da Câmara Municipal.','Vereador Carlos Oliveira','Cria a Comissão de Ética e Decoro Parlamentar e estabelece suas competências.',NULL,'1','Comissão permanente.','comissao-etica-decoro-13-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('8','8','2025','2025-08-30','Decreto Legislativo','Concessão de Título de Cidadão Honorário','Este decreto legislativo reconhece os méritos e a contribuição do Sr. José da Silva para o desenvolvimento do município, concedendo-lhe o título de Cidadão Honorário em reconhecimento aos seus serviços prestados à comunidade.','Vereador Pedro Costa','Concede o título de Cidadão Honorário ao Sr. José da Silva pelos relevantes serviços prestados ao município.',NULL,'1','Cerimônia de entrega agendada.','titulo-cidadao-honorario-jose-silva-8-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('9','9','2025','2025-09-02','Decreto Legislativo','Aprovação de Convênio com o Estado','Este decreto legislativo aprova o convênio firmado com o governo estadual para a execução de obras de pavimentação, drenagem e saneamento básico em diversos bairros do município, com investimento total de R$ 2.500.000,00.','Comissão de Finanças','Aprova o convênio celebrado entre o município e o governo estadual para execução de obras de infraestrutura.',NULL,'1','Contrapartida municipal de 20%.','aprovacao-convenio-estado-obras-9-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('10','1','2024','2024-01-15','Lei Orgânica','Lei Orgânica do Município','A Lei Orgânica é a lei fundamental do município, estabelecendo sua organização política, administrativa e territorial. Define os poderes municipais, os direitos e deveres dos cidadãos, as competências do município e os princípios da administração pública local.','Câmara Municipal Constituinte','Lei Orgânica do Município, estabelecendo sua organização política e administrativa.',NULL,'1','Lei fundamental do município.','lei-organica-municipio-1-2024','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('11','3','2025','2025-07-22','Emenda à Lei Orgânica','Emenda à Lei Orgânica nº 03/2025','Esta emenda à Lei Orgânica Municipal modifica o artigo 45, incluindo novos dispositivos sobre transparência pública, acesso à informação e participação popular na gestão municipal, fortalecendo os mecanismos de controle social.','Vereadora Ana Paula','Altera o artigo 45 da Lei Orgânica Municipal para incluir disposições sobre transparência pública.',NULL,'1','Aprovada em dois turnos.','emenda-lei-organica-transparencia-3-2025','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('12','1450','2024','2024-12-10','Lei Ordinária','Lei Orçamentária Anual 2025','A Lei Orçamentária Anual estabelece as previsões de receitas e as autorizações de despesas para o exercício de 2025, contemplando os programas e ações do governo municipal para o próximo ano.','Poder Executivo','Estima a receita e fixa a despesa do município para o exercício financeiro de 2025.',NULL,'1','Orçamento aprovado no prazo legal.','lei-orcamentaria-anual-2025-1450-2024','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('13','1420','2024','2024-06-15','Lei Ordinária','Estatuto do Servidor Público Municipal','Este estatuto estabelece o regime jurídico dos servidores públicos municipais, definindo direitos, deveres, proibições, regime disciplinar e demais aspectos da relação funcional entre o servidor e a administração municipal.','Comissão de Administração','Dispõe sobre o regime jurídico dos servidores públicos municipais.',NULL,'1','Substitui legislação anterior.','estatuto-servidor-publico-municipal-1420-2024','2025-09-26 07:33:43','2025-09-26 07:33:43'),
('14','1380','2023','2023-11-20','Lei Ordinária','Criação do Conselho Municipal de Educação','Esta lei institui o Conselho Municipal de Educação como órgão normativo, consultivo e de controle social do sistema municipal de ensino, definindo sua composição, competências e funcionamento.','Vereadora Lucia Fernandes','Cria o Conselho Municipal de Educação e estabelece suas competências.',NULL,'1','Órgão de controle social da educação.','conselho-municipal-educacao-1380-2023','2025-09-26 07:33:43','2025-09-26 07:33:43');

-- Estrutura da tabela `licitacao_documentos`
DROP TABLE IF EXISTS `licitacao_documentos`;
CREATE TABLE `licitacao_documentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `licitacao_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `arquivo` varchar(255) NOT NULL,
  `arquivo_original` varchar(255) NOT NULL,
  `tipo_mime` varchar(255) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `tipo_documento` enum('edital','anexo_edital','ata_abertura','ata_julgamento','resultado','contrato','termo_referencia','projeto_basico','outros') NOT NULL DEFAULT 'outros',
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `licitacao_documentos_licitacao_id_publico_index` (`licitacao_id`,`publico`),
  KEY `licitacao_documentos_tipo_documento_index` (`tipo_documento`),
  CONSTRAINT `licitacao_documentos_licitacao_id_foreign` FOREIGN KEY (`licitacao_id`) REFERENCES `licitacoes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `licitacoes`
DROP TABLE IF EXISTS `licitacoes`;
CREATE TABLE `licitacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero_processo` varchar(255) NOT NULL,
  `numero_edital` varchar(255) DEFAULT NULL,
  `modalidade` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `objeto` varchar(255) NOT NULL,
  `descricao_detalhada` text DEFAULT NULL,
  `valor_estimado` decimal(15,2) DEFAULT NULL,
  `valor_homologado` decimal(15,2) DEFAULT NULL,
  `data_abertura` date NOT NULL,
  `data_publicacao` date DEFAULT NULL,
  `data_hora_abertura` datetime DEFAULT NULL,
  `data_homologacao` date DEFAULT NULL,
  `local_abertura` varchar(255) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL,
  `vencedor` varchar(255) DEFAULT NULL,
  `cnpj_vencedor` varchar(255) DEFAULT NULL,
  `valor_vencedor` decimal(15,2) DEFAULT NULL,
  `arquivo_edital` varchar(255) DEFAULT NULL,
  `arquivo_resultado` varchar(255) DEFAULT NULL,
  `ano_referencia` int(11) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('publicado','em_andamento','homologado','deserto','fracassado','cancelado') NOT NULL DEFAULT 'publicado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licitacoes_numero_processo_unique` (`numero_processo`),
  KEY `licitacoes_ano_referencia_index` (`ano_referencia`),
  KEY `licitacoes_modalidade_index` (`modalidade`),
  KEY `licitacoes_status_index` (`status`),
  KEY `licitacoes_data_abertura_index` (`data_abertura`),
  KEY `licitacoes_data_publicacao_index` (`data_publicacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `manifestacao_anexos`
DROP TABLE IF EXISTS `manifestacao_anexos`;
CREATE TABLE `manifestacao_anexos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `manifestacao_id` bigint(20) unsigned NOT NULL,
  `nome_original` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `tipo_mime` varchar(255) NOT NULL,
  `extensao` varchar(10) NOT NULL,
  `tamanho_bytes` bigint(20) NOT NULL,
  `tipo_anexo` enum('documento','imagem','comprovante','evidencia','outros') NOT NULL DEFAULT 'documento',
  `publico` tinyint(1) NOT NULL DEFAULT 0,
  `confidencial` tinyint(1) NOT NULL DEFAULT 0,
  `hash_arquivo` varchar(64) NOT NULL,
  `descricao` text DEFAULT NULL,
  `metadados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadados`)),
  `ip_upload` varchar(45) DEFAULT NULL,
  `uploaded_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manifestacao_anexos_uploaded_by_foreign` (`uploaded_by`),
  KEY `manifestacao_anexos_manifestacao_id_tipo_anexo_index` (`manifestacao_id`,`tipo_anexo`),
  KEY `manifestacao_anexos_nome_arquivo_index` (`nome_arquivo`),
  KEY `manifestacao_anexos_hash_arquivo_index` (`hash_arquivo`),
  CONSTRAINT `manifestacao_anexos_manifestacao_id_foreign` FOREIGN KEY (`manifestacao_id`) REFERENCES `ouvidoria_manifestacoes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `manifestacao_anexos_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `esic_usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `menus`
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `rota` varchar(255) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `posicao` enum('header','footer','ambos') NOT NULL DEFAULT 'header',
  `tipo` enum('link','dropdown','divider') NOT NULL DEFAULT 'link',
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `permissao` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `configuracoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuracoes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_slug_unique` (`slug`),
  KEY `menus_posicao_ativo_ordem_index` (`posicao`,`ativo`,`ordem`),
  KEY `menus_parent_id_ordem_index` (`parent_id`,`ordem`),
  CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `menus`
INSERT INTO `menus` VALUES
('1','Início','inicio','/',NULL,'fas fa-home','header','link',NULL,'1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('2','Sobre','sobre',NULL,NULL,'fas fa-info-circle','header','dropdown',NULL,'2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('3','História','historia','/sobre/historia',NULL,'fas fa-book','header','link','2','1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('4','Estrutura','estrutura','/sobre/estrutura',NULL,'fas fa-building','header','link','2','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('5','Regimento Interno','regimento-interno','/sobre/regimento',NULL,'fas fa-gavel','header','link','2','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('6','Missão, Visão e Valores','missao-visao-valores','/sobre/missao',NULL,'fas fa-bullseye','header','link','2','4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('7','Legislativo','legislativo',NULL,NULL,'fas fa-university','header','dropdown',NULL,'3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('8','Vereadores','vereadores',NULL,'vereadores.index','fas fa-users','header','link','7','1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('9','Projetos de Lei','projetos-lei','/projetos-lei',NULL,'fas fa-file-alt','header','link','7','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-28 00:33:27'),
('10','Sessões','sessoes',NULL,'sessoes.index','fas fa-calendar-alt','header','link','7','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('11','Transparência','transparencia',NULL,NULL,'fas fa-eye','header','dropdown',NULL,'4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('12','Portal da Transparência','portal-transparencia','https://sigesp.tce.mt.gov.br/aplictransparencia/tce/#/inicio',NULL,'fas fa-globe','header','link','11','1','1','1',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-28 00:47:37'),
('13','Receitas e Despesas','receitas-despesas','/transparencia/financeiro',NULL,'fas fa-dollar-sign','header','link','11','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('14','Licitações','licitacoes','/transparencia/licitacoes',NULL,'fas fa-file-contract','header','link','11','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('15','Contratos','contratos','/transparencia/contratos',NULL,'fas fa-handshake','header','link','11','4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('16','Ouvidoria','ouvidoria',NULL,'ouvidoria.index','fas fa-comments','header','link','11','5','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57'),
('17','Contato','contato','/contato',NULL,'fas fa-envelope','header','link',NULL,'5','0','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 08:07:32'),
('18','Entrar','entrar',NULL,'login','fas fa-sign-in-alt','header','link',NULL,'6','0','0',NULL,NULL,'\"{\\\"visibilidade\\\":\\\"guest_only\\\",\\\"classe_css\\\":\\\"nav-link-auth\\\"}\"','2025-09-26 07:51:57','2025-09-26 08:16:10'),
('19','Cadastrar','cadastrar',NULL,'register','fas fa-user-plus','header','link',NULL,'7','0','0',NULL,NULL,'\"{\\\"visibilidade\\\":\\\"guest_only\\\",\\\"classe_css\\\":\\\"nav-link-auth\\\"}\"','2025-09-26 07:51:57','2025-09-26 08:16:11'),
('20','Vereadores','footer-vereadores',NULL,'vereadores.index',NULL,'footer','link',NULL,'1','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('21','Projetos de Lei','footer-projetos-lei','#',NULL,NULL,'footer','link',NULL,'2','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('22','Sessões','footer-sessoes',NULL,'sessoes.index',NULL,'footer','link',NULL,'3','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('23','Atas','footer-atas','#',NULL,NULL,'footer','link',NULL,'4','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('24','Portal da Transparência','footer-portal-transparencia','https://sigesp.tce.mt.gov.br/aplictransparencia/tce/#/inicio',NULL,NULL,'footer','link',NULL,'11','1','1',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-28 00:46:57'),
('25','e-SIC','footer-esic',NULL,'esic.public',NULL,'footer','link',NULL,'12','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('26','Lei de Acesso','lei-acesso','https://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm',NULL,'fas fa-balance-scale','ambos','link','7','13','1','1',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-28 00:38:07'),
('27','Ouvidoria','footer-ouvidoria',NULL,'ouvidoria.index',NULL,'footer','link',NULL,'14','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('28','Leis','leis','/leis',NULL,'fas fa-gavel','header','link','7','4','1','0',NULL,NULL,NULL,'2025-09-26 08:05:50','2025-09-26 08:07:25');

-- Estrutura da tabela `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `migrations`
INSERT INTO `migrations` VALUES
('1','0001_01_01_000000_create_users_table','1'),
('2','0001_01_01_000001_create_cache_table','1'),
('3','0001_01_01_000002_create_jobs_table','1'),
('4','2025_09_17_161629_create_vereadores_table','1'),
('5','2025_09_17_161649_create_noticias_table','1'),
('6','2025_09_17_161658_create_sessoes_table','1'),
('7','2025_09_17_161707_create_projetos_lei_table','1'),
('8','2025_09_17_161716_create_documentos_table','1'),
('9','2025_09_17_161726_create_esic_solicitacoes_table','1'),
('10','2025_09_17_162110_create_permission_tables','1'),
('11','2025_09_18_175819_add_comissoes_to_vereadores_table','1'),
('12','2025_09_18_190931_update_vereadores_partido_field_size','1'),
('13','2025_09_18_195036_add_role_to_users_table','1'),
('14','2025_09_19_121900_add_arquivada_fields_to_esic_solicitacoes_table','1'),
('15','2025_09_19_150105_add_deleted_at_to_esic_solicitacoes_table','1'),
('16','2025_09_19_151458_add_deleted_at_to_projetos_lei_table','1'),
('17','2025_09_19_153535_create_sessao_projeto_lei_table','1'),
('18','2025_09_19_153545_create_projeto_lei_coautor_table','1'),
('19','2025_09_19_153554_create_sessao_vereador_table','1'),
('20','2025_09_19_154035_add_deleted_at_to_documentos_table','1'),
('21','2025_09_19_154211_add_deleted_at_to_sessoes_table','1'),
('22','2025_09_19_154221_add_deleted_at_to_noticias_table','1'),
('23','2025_09_20_122149_add_video_fields_to_sessoes_table','1'),
('24','2025_09_20_130244_add_presidente_secretario_to_sessoes_table','1'),
('25','2025_09_20_135715_rename_numero_projeto_to_numero_in_projetos_lei_table','1'),
('26','2025_09_20_144144_create_tipo_sessaos_table','1'),
('27','2025_09_20_144833_add_tipo_sessao_id_to_sessoes_table','1'),
('28','2025_09_20_220409_create_esic_usuarios_table','1'),
('29','2025_09_20_220418_create_ouvidores_table','1'),
('30','2025_09_20_220428_create_ouvidoria_manifestacoes_table','1'),
('31','2025_09_20_220438_create_manifestacao_anexos_table','1'),
('32','2025_09_20_220705_create_carta_servicos_table','1'),
('33','2025_09_20_220715_create_notificacoes_table','1'),
('34','2025_09_20_231843_create_esic_movimentacoes_table','1'),
('35','2025_09_20_232000_create_ouvidoria_movimentacoes_table','1'),
('36','2025_09_20_232019_create_carta_servico_categorias_table','1'),
('37','2025_09_20_232139_create_carta_servico_avaliacoes_table','1'),
('38','2025_09_21_113657_add_verification_fields_to_users_table','1'),
('39','2025_09_21_115359_add_profile_fields_to_users_table','2'),
('40','2025_09_21_165141_create_menus_table','2'),
('41','2025_09_21_171752_add_data_resposta_to_esic_solicitacoes_table','2'),
('42','2025_09_21_235354_create_receitas_table','2'),
('43','2025_09_21_235404_create_despesas_table','2'),
('44','2025_09_21_235413_create_licitacoes_table','2'),
('45','2025_09_21_235422_create_folha_pagamento_table','2'),
('46','2025_09_22_002014_add_data_publicacao_to_licitacoes_table','2'),
('47','2025_09_22_123335_create_licitacao_documentos_table','2'),
('48','2025_09_22_141407_create_acesso_rapido_table','2'),
('49','2025_09_23_112848_add_user_id_to_esic_solicitacoes_table','2'),
('50','2025_09_23_153842_create_eventos_table','2'),
('51','2025_09_23_162210_fix_eventos_tipo_enum','2'),
('52','2025_09_24_131658_create_paginas_conteudo_table','2'),
('53','2025_09_24_155007_create_tipo_contratos_table','2'),
('54','2025_09_24_155050_create_contratos_table','2'),
('55','2025_09_24_155153_create_contrato_aditivos_table','2'),
('56','2025_09_24_155248_create_contrato_fiscalizacaos_table','2'),
('57','2025_09_25_004253_add_observacoes_transparencia_to_contratos_table','2'),
('58','2025_09_25_015143_fix_numero_relatorio_field_in_contrato_fiscalizacaos_table','2'),
('59','2025_09_26_012038_create_configuracao_gerais_table','2'),
('60','2025_09_26_015517_create_slides_table','2'),
('61','2025_09_26_020714_create_hero_configurations_table','2'),
('62','2025_09_26_050741_create_leis_table','2'),
('63','2025_09_27_163821_add_escolaridade_endereco_observacoes_to_vereadores_table','3'),
('64','2025_09_27_190912_add_slug_to_projetos_lei_table','3'),
('65','2025_09_27_195749_add_destaque_to_projetos_lei_table','3'),
('66','2025_09_27_205306_add_tipo_autoria_to_projetos_lei_table','3'),
('67','2025_09_27_205630_create_comite_iniciativa_populars_table','4'),
('68','2025_09_27_212835_add_comite_iniciativa_popular_id_to_projetos_lei_table','5'),
('69','2025_09_27_215229_make_autor_id_nullable_in_projetos_lei_table','5'),
('70','2025_09_28_105835_add_custom_fields_to_roles_table','6'),
('71','2025_09_28_105844_add_custom_fields_to_permissions_table','6');

-- Estrutura da tabela `model_has_permissions`
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `model_has_roles`
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `model_has_roles`
INSERT INTO `model_has_roles` VALUES
('1','App\\Models\\User','2'),
('1','App\\Models\\User','3'),
('1','App\\Models\\User','4'),
('1','App\\Models\\User','5'),
('1','App\\Models\\User','6'),
('1','App\\Models\\User','7'),
('1','App\\Models\\User','8'),
('10','App\\Models\\User','11'),
('11','App\\Models\\User','11'),
('1','App\\Models\\User','12');

-- Estrutura da tabela `noticias`
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE `noticias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `resumo` text NOT NULL,
  `conteudo` longtext NOT NULL,
  `imagem_destaque` varchar(255) DEFAULT NULL,
  `galeria_imagens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`galeria_imagens`)),
  `autor_id` bigint(20) unsigned NOT NULL,
  `status` enum('rascunho','publicado','arquivado') NOT NULL DEFAULT 'rascunho',
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `visualizacoes` int(11) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `categoria` varchar(255) DEFAULT NULL,
  `data_publicacao` timestamp NULL DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `noticias_slug_unique` (`slug`),
  KEY `noticias_autor_id_foreign` (`autor_id`),
  KEY `noticias_status_data_publicacao_index` (`status`,`data_publicacao`),
  KEY `noticias_destaque_status_index` (`destaque`,`status`),
  KEY `noticias_categoria_index` (`categoria`),
  CONSTRAINT `noticias_autor_id_foreign` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `noticias`
INSERT INTO `noticias` VALUES
('1','Câmara Municipal aprova novo projeto de lei para melhorias urbanas','camara-aprova-projeto-melhorias-urbanas','O projeto prevê investimentos em infraestrutura e mobilidade urbana para os próximos dois anos.','<p>A Câmara Municipal aprovou por unanimidade o projeto de lei que destina recursos para melhorias na infraestrutura urbana da cidade. O projeto, de autoria do vereador João Silva, prevê investimentos em pavimentação, iluminação pública e mobilidade urbana.</p><p>As obras devem começar no próximo trimestre e beneficiarão diretamente mais de 50 mil moradores da região central e dos bairros periféricos.</p><p>\"Este é um marco importante para nossa cidade\", declarou o presidente da Câmara durante a sessão.</p>',NULL,NULL,'11','publicado','1','1','[\"infraestrutura\",\"mobilidade\",\"aprova\\u00e7\\u00e3o\"]','legislativo','2025-09-25 08:24:22','Câmara Municipal aprova projeto para melhorias urbanas com investimentos em infraestrutura.','câmara municipal, projeto de lei, infraestrutura, melhorias urbanas','2025-09-26 08:24:22','2025-09-28 04:49:35',NULL),
('2','Sessão extraordinária discutirá orçamento municipal para 2024','sessao-extraordinaria-orcamento-2024','Vereadores se reunirão na próxima semana para debater a proposta orçamentária do município.','<p>A Câmara Municipal convocou uma sessão extraordinária para a próxima terça-feira (15) para discussão e votação da Lei Orçamentária Anual (LOA) de 2024.</p><p>A proposta, enviada pelo Executivo, prevê um orçamento de R$ 120 milhões, com foco em educação, saúde e obras públicas.</p><p>A sessão será aberta ao público e transmitida ao vivo pelos canais oficiais da Câmara.</p>',NULL,NULL,'11','publicado','0','2','[\"or\\u00e7amento\",\"sess\\u00e3o extraordin\\u00e1ria\",\"LOA\"]','legislativo','2025-09-23 08:24:22','Sessão extraordinária da Câmara discutirá orçamento municipal de 2024.','sessão extraordinária, orçamento municipal, LOA 2024','2025-09-26 08:24:22','2025-09-28 08:57:18',NULL),
('3','Câmara promove audiência pública sobre meio ambiente','audiencia-publica-meio-ambiente','Evento debaterá políticas ambientais e sustentabilidade no município.','<p>A Câmara Municipal realizará na próxima sexta-feira (18) uma audiência pública para discutir políticas ambientais e sustentabilidade no município.</p><p>O evento contará com a participação de especialistas, representantes de ONGs ambientais e da sociedade civil organizada.</p><p>Entre os temas abordados estão: gestão de resíduos sólidos, preservação de áreas verdes e políticas de sustentabilidade urbana.</p><p>A audiência será realizada no Plenário da Câmara, às 19h, com entrada gratuita.</p>',NULL,NULL,'11','publicado','1','1','[\"meio ambiente\",\"audi\\u00eancia p\\u00fablica\",\"sustentabilidade\"]','eventos','2025-09-21 08:24:22','Câmara promove audiência pública sobre políticas ambientais e sustentabilidade.','audiência pública, meio ambiente, sustentabilidade, políticas ambientais','2025-09-26 08:24:22','2025-09-28 04:38:46',NULL),
('4','Transparência: Câmara publica relatório de atividades do 1º semestre','relatorio-atividades-primeiro-semestre','Documento apresenta dados sobre projetos aprovados, sessões realizadas e investimentos.','<p>A Câmara Municipal publicou o relatório de atividades do primeiro semestre de 2024, demonstrando seu compromisso com a transparência pública.</p><p>O documento apresenta dados detalhados sobre:</p><ul><li>25 projetos de lei analisados</li><li>48 sessões ordinárias realizadas</li><li>12 audiências públicas promovidas</li><li>R$ 2,8 milhões em investimentos</li></ul><p>O relatório está disponível no portal da transparência da Câmara e pode ser acessado gratuitamente por todos os cidadãos.</p>',NULL,NULL,'11','publicado','0','1','[\"transpar\\u00eancia\",\"relat\\u00f3rio\",\"atividades\"]','transparencia','2025-09-19 08:24:22','Câmara publica relatório de atividades do 1º semestre com dados de transparência.','relatório de atividades, transparência, câmara municipal','2025-09-26 08:24:22','2025-09-28 07:25:30',NULL),
('5','Homenagem aos professores marca sessão solene da Câmara','homenagem-professores-sessao-solene','Evento reconheceu o trabalho de educadores que se destacaram no município.','<p>A Câmara Municipal realizou uma sessão solene em homenagem aos professores da rede municipal de ensino. O evento reconheceu o trabalho de 15 educadores que se destacaram por suas práticas inovadoras e dedicação.</p><p>Durante a cerimônia, foram entregues certificados de reconhecimento e medalhas de honra ao mérito educacional.</p><p>\"Os professores são os verdadeiros construtores do futuro da nossa cidade\", destacou o presidente da Câmara durante seu discurso.</p><p>A sessão contou com a presença de familiares, colegas de trabalho e autoridades municipais.</p>',NULL,NULL,'11','publicado','0','2','[\"educa\\u00e7\\u00e3o\",\"professores\",\"homenagem\"]','eventos','2025-09-16 08:24:22','Câmara realiza sessão solene em homenagem aos professores municipais.','sessão solene, professores, educação, homenagem','2025-09-26 08:24:22','2025-09-28 07:57:13',NULL);

-- Estrutura da tabela `notificacoes`
DROP TABLE IF EXISTS `notificacoes`;
CREATE TABLE `notificacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notificavel_type` varchar(255) NOT NULL,
  `notificavel_id` bigint(20) unsigned NOT NULL,
  `manifestacao_id` bigint(20) unsigned DEFAULT NULL,
  `tipo` enum('nova_manifestacao','resposta_manifestacao','prazo_vencendo','prazo_vencido','manifestacao_avaliada','status_alterado','confirmacao_email','recuperacao_senha','sistema_geral') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `dados_extras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dados_extras`)),
  `canal` enum('sistema','email','sms','push') NOT NULL DEFAULT 'sistema',
  `lida` tinyint(1) NOT NULL DEFAULT 0,
  `lida_em` timestamp NULL DEFAULT NULL,
  `enviada` tinyint(1) NOT NULL DEFAULT 0,
  `enviada_em` timestamp NULL DEFAULT NULL,
  `erro_envio` text DEFAULT NULL,
  `tentativas_envio` int(11) NOT NULL DEFAULT 0,
  `prioridade` enum('baixa','normal','alta','urgente') NOT NULL DEFAULT 'normal',
  `agendada_para` timestamp NULL DEFAULT NULL,
  `acoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`acoes`)),
  `url_acao` varchar(255) DEFAULT NULL,
  `expira_em` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notificacoes_notificavel_type_notificavel_id_index` (`notificavel_type`,`notificavel_id`),
  KEY `notificacoes_notificavel_type_notificavel_id_lida_index` (`notificavel_type`,`notificavel_id`,`lida`),
  KEY `notificacoes_tipo_enviada_index` (`tipo`,`enviada`),
  KEY `notificacoes_agendada_para_enviada_index` (`agendada_para`,`enviada`),
  KEY `notificacoes_manifestacao_id_index` (`manifestacao_id`),
  CONSTRAINT `notificacoes_manifestacao_id_foreign` FOREIGN KEY (`manifestacao_id`) REFERENCES `ouvidoria_manifestacoes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `ouvidores`
DROP TABLE IF EXISTS `ouvidores`;
CREATE TABLE `ouvidores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `setor` varchar(255) NOT NULL,
  `tipo` enum('ouvidor_geral','ouvidor_setorial','responsavel_esic','equipe_ouvidoria') NOT NULL,
  `pode_gerenciar_esic` tinyint(1) NOT NULL DEFAULT 0,
  `pode_gerenciar_ouvidoria` tinyint(1) NOT NULL DEFAULT 0,
  `pode_visualizar_relatorios` tinyint(1) NOT NULL DEFAULT 1,
  `pode_responder_manifestacoes` tinyint(1) NOT NULL DEFAULT 1,
  `telefone` varchar(20) DEFAULT NULL,
  `ramal` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `recebe_notificacao_email` tinyint(1) NOT NULL DEFAULT 1,
  `recebe_notificacao_sistema` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ouvidores_email_unique` (`email`),
  UNIQUE KEY `ouvidores_cpf_unique` (`cpf`),
  KEY `ouvidores_user_id_foreign` (`user_id`),
  KEY `ouvidores_tipo_ativo_index` (`tipo`,`ativo`),
  KEY `ouvidores_email_ativo_index` (`email`,`ativo`),
  CONSTRAINT `ouvidores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `ouvidoria_manifestacoes`
DROP TABLE IF EXISTS `ouvidoria_manifestacoes`;
CREATE TABLE `ouvidoria_manifestacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(20) NOT NULL,
  `esic_usuario_id` bigint(20) unsigned DEFAULT NULL,
  `ouvidor_responsavel_id` bigint(20) unsigned DEFAULT NULL,
  `tipo` enum('solicitacao_informacao','reclamacao','sugestao','elogio','denuncia','ouvidoria_geral') NOT NULL,
  `nome_manifestante` varchar(255) DEFAULT NULL,
  `email_manifestante` varchar(255) DEFAULT NULL,
  `telefone_manifestante` varchar(255) DEFAULT NULL,
  `manifestacao_anonima` tinyint(1) NOT NULL DEFAULT 0,
  `assunto` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `orgao_destinatario` varchar(255) DEFAULT NULL,
  `setor_destinatario` varchar(255) DEFAULT NULL,
  `categoria_esic` enum('acesso_informacao','dados_pessoais','transparencia_ativa','transparencia_passiva','outros') DEFAULT NULL,
  `status` enum('nova','em_analise','em_tramitacao','aguardando_informacoes','respondida','finalizada','arquivada') NOT NULL DEFAULT 'nova',
  `prazo_resposta` date NOT NULL,
  `prazo_prorrogado` date DEFAULT NULL,
  `justificativa_prorrogacao` text DEFAULT NULL,
  `resposta` text DEFAULT NULL,
  `respondida_em` timestamp NULL DEFAULT NULL,
  `respondida_por` bigint(20) unsigned DEFAULT NULL,
  `avaliacao_atendimento` int(11) DEFAULT NULL,
  `comentario_avaliacao` text DEFAULT NULL,
  `avaliada_em` timestamp NULL DEFAULT NULL,
  `prioridade` enum('baixa','media','alta','urgente') NOT NULL DEFAULT 'media',
  `requer_resposta` tinyint(1) NOT NULL DEFAULT 1,
  `informacao_sigilosa` tinyint(1) NOT NULL DEFAULT 0,
  `observacoes_internas` text DEFAULT NULL,
  `ip_origem` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `historico_status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`historico_status`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ouvidoria_manifestacoes_protocolo_unique` (`protocolo`),
  KEY `ouvidoria_manifestacoes_ouvidor_responsavel_id_foreign` (`ouvidor_responsavel_id`),
  KEY `ouvidoria_manifestacoes_respondida_por_foreign` (`respondida_por`),
  KEY `ouvidoria_manifestacoes_protocolo_index` (`protocolo`),
  KEY `ouvidoria_manifestacoes_tipo_status_index` (`tipo`,`status`),
  KEY `ouvidoria_manifestacoes_status_prazo_resposta_index` (`status`,`prazo_resposta`),
  KEY `ouvidoria_manifestacoes_esic_usuario_id_status_index` (`esic_usuario_id`,`status`),
  KEY `ouvidoria_manifestacoes_created_at_tipo_index` (`created_at`,`tipo`),
  CONSTRAINT `ouvidoria_manifestacoes_esic_usuario_id_foreign` FOREIGN KEY (`esic_usuario_id`) REFERENCES `esic_usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ouvidoria_manifestacoes_ouvidor_responsavel_id_foreign` FOREIGN KEY (`ouvidor_responsavel_id`) REFERENCES `ouvidores` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ouvidoria_manifestacoes_respondida_por_foreign` FOREIGN KEY (`respondida_por`) REFERENCES `ouvidores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `ouvidoria_movimentacoes`
DROP TABLE IF EXISTS `ouvidoria_movimentacoes`;
CREATE TABLE `ouvidoria_movimentacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ouvidoria_manifestacao_id` bigint(20) unsigned NOT NULL,
  `usuario_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('aberta','em_analise','aguardando_informacoes','em_apuracao','respondida','procedente','improcedente','parcialmente_procedente','finalizada','arquivada') NOT NULL,
  `descricao` text NOT NULL,
  `anexos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`anexos`)),
  `data_movimentacao` datetime NOT NULL,
  `ip_usuario` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ouvidoria_movimentacoes_usuario_id_foreign` (`usuario_id`),
  KEY `idx_ouv_mov_manifest_data` (`ouvidoria_manifestacao_id`,`data_movimentacao`),
  KEY `idx_ouv_mov_status` (`status`),
  CONSTRAINT `ouvidoria_movimentacoes_ouvidoria_manifestacao_id_foreign` FOREIGN KEY (`ouvidoria_manifestacao_id`) REFERENCES `ouvidoria_manifestacoes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ouvidoria_movimentacoes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `paginas_conteudo`
DROP TABLE IF EXISTS `paginas_conteudo`;
CREATE TABLE `paginas_conteudo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `configuracoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuracoes`)),
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `template` varchar(255) NOT NULL DEFAULT 'default',
  `seo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`seo`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `paginas_conteudo_slug_unique` (`slug`),
  KEY `paginas_conteudo_slug_index` (`slug`),
  KEY `paginas_conteudo_ativo_index` (`ativo`),
  KEY `paginas_conteudo_ordem_index` (`ordem`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `paginas_conteudo`
INSERT INTO `paginas_conteudo` VALUES
('1','historia','História da Câmara Municipal','Conheça a trajetória e evolução da nossa Câmara Municipal ao longo dos anos.','<div class=\"historia-content\">
                    <h2>Nossa História</h2>
                    <p>A Câmara Municipal tem uma rica história de representação democrática e serviço à comunidade. Desde sua fundação, tem sido o centro das decisões legislativas que moldam o desenvolvimento de nossa cidade.</p>
                    
                    <h3>Fundação e Primeiros Anos</h3>
                    <p>Estabelecida com o objetivo de representar os interesses da população local, nossa Câmara Municipal iniciou suas atividades focada na criação de leis que promovessem o bem-estar social e o desenvolvimento econômico sustentável.</p>
                    
                    <h3>Marcos Importantes</h3>
                    <ul>
                        <li>Criação das primeiras leis municipais</li>
                        <li>Implementação de políticas públicas inovadoras</li>
                        <li>Modernização dos processos legislativos</li>
                        <li>Digitalização e transparência dos dados públicos</li>
                    </ul>
                    
                    <h3>Evolução Institucional</h3>
                    <p>Ao longo dos anos, a Câmara Municipal evoluiu constantemente, adaptando-se às necessidades da população e incorporando novas tecnologias para melhor servir aos cidadãos.</p>
                </div>',NULL,'1','1','default','{\"title\":\"Hist\\u00f3ria da C\\u00e2mara Municipal - Conhe\\u00e7a Nossa Trajet\\u00f3ria\",\"description\":\"Descubra a rica hist\\u00f3ria da C\\u00e2mara Municipal, seus marcos importantes e evolu\\u00e7\\u00e3o institucional ao longo dos anos.\",\"keywords\":\"hist\\u00f3ria, c\\u00e2mara municipal, trajet\\u00f3ria, evolu\\u00e7\\u00e3o, marcos hist\\u00f3ricos\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL),
('2','estrutura','Estrutura Organizacional','Conheça a organização institucional e a estrutura administrativa da Câmara Municipal.','<div class=\"estrutura-content\">
                    <h2>Estrutura Organizacional</h2>
                    <p>A Câmara Municipal está organizada de forma a garantir eficiência, transparência e representatividade em todas as suas atividades legislativas e administrativas.</p>
                    
                    <h3>Mesa Diretora</h3>
                    <p>Responsável pela direção dos trabalhos legislativos e pela administração da Câmara Municipal.</p>
                    <ul>
                        <li>Presidente da Câmara</li>
                        <li>Vice-Presidente</li>
                        <li>1º Secretário</li>
                        <li>2º Secretário</li>
                    </ul>
                    
                    <h3>Comissões Permanentes</h3>
                    <p>Órgãos técnicos especializados que analisam as matérias de sua competência:</p>
                    <ul>
                        <li>Comissão de Constituição, Justiça e Redação</li>
                        <li>Comissão de Finanças e Orçamento</li>
                        <li>Comissão de Obras, Serviços Públicos e Meio Ambiente</li>
                        <li>Comissão de Educação, Cultura e Assistência Social</li>
                    </ul>
                    
                    <h3>Estrutura Administrativa</h3>
                    <p>Setor responsável pelo apoio técnico e administrativo às atividades legislativas:</p>
                    <ul>
                        <li>Secretaria Geral</li>
                        <li>Departamento Legislativo</li>
                        <li>Departamento Administrativo</li>
                        <li>Assessoria Jurídica</li>
                        <li>Departamento de Comunicação</li>
                    </ul>
                </div>',NULL,'1','2','default','{\"title\":\"Estrutura Organizacional - C\\u00e2mara Municipal\",\"description\":\"Conhe\\u00e7a a organiza\\u00e7\\u00e3o institucional, mesa diretora, comiss\\u00f5es e estrutura administrativa da C\\u00e2mara Municipal.\",\"keywords\":\"estrutura, organiza\\u00e7\\u00e3o, mesa diretora, comiss\\u00f5es, administra\\u00e7\\u00e3o\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL),
('3','regimento','Regimento Interno','Consulte as normas internas que regem o funcionamento da Câmara Municipal.','<div class=\"regimento-content\">
                    <h2>Regimento Interno</h2>
                    <p>O Regimento Interno estabelece as normas e procedimentos que regem o funcionamento da Câmara Municipal, garantindo ordem, transparência e eficiência nos trabalhos legislativos.</p>
                    
                    <h3>Disposições Gerais</h3>
                    <p>O Regimento Interno da Câmara Municipal disciplina a organização, a direção dos trabalhos, a ordem dos debates e o processo de votação, bem como a polícia interna da Casa.</p>
                    
                    <h3>Principais Capítulos</h3>
                    <ul>
                        <li><strong>Capítulo I:</strong> Da Câmara Municipal e suas atribuições</li>
                        <li><strong>Capítulo II:</strong> Da Mesa Diretora</li>
                        <li><strong>Capítulo III:</strong> Das Comissões</li>
                        <li><strong>Capítulo IV:</strong> Das Sessões</li>
                        <li><strong>Capítulo V:</strong> Dos Projetos e Proposições</li>
                        <li><strong>Capítulo VI:</strong> Da Votação</li>
                        <li><strong>Capítulo VII:</strong> Da Disciplina e Polícia Interna</li>
                    </ul>
                    
                    <h3>Sessões Ordinárias</h3>
                    <p>As sessões ordinárias realizam-se conforme calendário estabelecido, seguindo a seguinte ordem:</p>
                    <ol>
                        <li>Abertura da sessão</li>
                        <li>Verificação de presença</li>
                        <li>Leitura da ata da sessão anterior</li>
                        <li>Expediente</li>
                        <li>Ordem do dia</li>
                        <li>Explicações pessoais</li>
                        <li>Encerramento</li>
                    </ol>
                    
                    <h3>Acesso ao Regimento Completo</h3>
                    <p>O texto completo do Regimento Interno está disponível para consulta pública e pode ser acessado através da Secretaria da Câmara ou solicitado via Lei de Acesso à Informação.</p>
                </div>',NULL,'1','3','default','{\"title\":\"Regimento Interno - Normas da C\\u00e2mara Municipal\",\"description\":\"Consulte o regimento interno com as normas e procedimentos que regem o funcionamento da C\\u00e2mara Municipal.\",\"keywords\":\"regimento interno, normas, procedimentos, funcionamento, legislativo\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL),
('4','missao','Missão, Visão e Valores','Conheça os princípios fundamentais que orientam as ações da Câmara Municipal.','<div class=\"missao-content\">
                    <h2>Nossos Princípios Institucionais</h2>
                    <p>A Câmara Municipal pauta suas ações em princípios sólidos que garantem uma atuação ética, transparente e comprometida com o bem-estar da população.</p>
                    
                    <div class=\"principio-box missao-box\">
                        <h3>🎯 Nossa Missão</h3>
                        <p>Exercer com excelência a função legislativa municipal, representando os interesses da população através da elaboração de leis justas e eficazes, fiscalizando o Poder Executivo e promovendo o desenvolvimento sustentável e a qualidade de vida dos cidadãos.</p>
                    </div>
                    
                    <div class=\"principio-box visao-box\">
                        <h3>🔭 Nossa Visão</h3>
                        <p>Ser reconhecida como uma instituição legislativa moderna, transparente e eficiente, referência em participação democrática e inovação nos processos legislativos, contribuindo para o desenvolvimento de uma cidade próspera, justa e sustentável.</p>
                    </div>
                    
                    <div class=\"principio-box valores-box\">
                        <h3>⭐ Nossos Valores</h3>
                        <ul>
                            <li><strong>Transparência:</strong> Atuamos com clareza e abertura em todos os processos</li>
                            <li><strong>Ética:</strong> Pautamos nossas ações pela integridade e honestidade</li>
                            <li><strong>Responsabilidade:</strong> Assumimos o compromisso com o bem público</li>
                            <li><strong>Participação:</strong> Valorizamos o envolvimento da sociedade nas decisões</li>
                            <li><strong>Inovação:</strong> Buscamos constantemente melhorar nossos processos</li>
                            <li><strong>Respeito:</strong> Tratamos todos com dignidade e consideração</li>
                            <li><strong>Eficiência:</strong> Otimizamos recursos para maximizar resultados</li>
                            <li><strong>Sustentabilidade:</strong> Promovemos o desenvolvimento responsável</li>
                        </ul>
                    </div>
                    
                    <h3>Compromisso com a Sociedade</h3>
                    <p>Estes princípios orientam todas as nossas ações e decisões, garantindo que a Câmara Municipal cumpra seu papel constitucional de forma exemplar, sempre priorizando o interesse público e o bem-estar da comunidade.</p>
                </div>',NULL,'1','4','default','{\"title\":\"Miss\\u00e3o, Vis\\u00e3o e Valores - C\\u00e2mara Municipal\",\"description\":\"Conhe\\u00e7a a miss\\u00e3o, vis\\u00e3o e valores que orientam as a\\u00e7\\u00f5es da C\\u00e2mara Municipal em prol da sociedade.\",\"keywords\":\"miss\\u00e3o, vis\\u00e3o, valores, princ\\u00edpios, \\u00e9tica, transpar\\u00eancia\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL);

-- Estrutura da tabela `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `permissions`
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(100) DEFAULT NULL COMMENT 'Nome para exibição (ex: Criar Notícias)',
  `description` text DEFAULT NULL COMMENT 'Descrição detalhada da permissão',
  `module` varchar(50) DEFAULT NULL COMMENT 'Módulo da permissão (ex: noticias, usuarios, esic)',
  `action` varchar(20) DEFAULT NULL COMMENT 'Ação da permissão (view, create, edit, delete, manage)',
  `is_system` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Permissão do sistema (não pode ser excluída)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Permissão ativa/inativa',
  `priority` int(11) NOT NULL DEFAULT 0 COMMENT 'Prioridade para ordenação dentro do módulo',
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  KEY `permissions_module_action_index` (`module`,`action`),
  KEY `permissions_is_active_module_index` (`is_active`,`module`),
  KEY `permissions_is_system_index` (`is_system`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `permissions`
INSERT INTO `permissions` VALUES
('1','noticias.view','Visualizar Notícias','Pode visualizar notícias','noticias','view','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('2','noticias.create','Criar Notícias','Pode criar novas notícias','noticias','create','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('3','noticias.edit','Editar Notícias','Pode editar notícias existentes','noticias','edit','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('4','noticias.delete','Excluir Notícias','Pode excluir notícias','noticias','delete','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('5','noticias.publish','Publicar Notícias','Pode publicar/despublicar notícias','noticias','publish','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('6','users.view','Visualizar Usuários','Pode visualizar lista de usuários','usuarios','view','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('7','users.create','Criar Usuários','Pode criar novos usuários','usuarios','create','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('8','users.edit','Editar Usuários','Pode editar dados de usuários','usuarios','edit','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('9','users.delete','Excluir Usuários','Pode excluir usuários','usuarios','delete','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('10','users.permissions','Gerenciar Permissões','Pode gerenciar permissões de usuários','usuarios','manage','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('11','esic.view','Visualizar e-SIC','Pode visualizar solicitações e-SIC','esic','view','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('12','esic.respond','Responder e-SIC','Pode responder solicitações e-SIC','esic','edit','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('13','esic.manage','Gerenciar e-SIC','Pode gerenciar todo o sistema e-SIC','esic','manage','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('14','ouvidoria.view','Visualizar Ouvidoria','Pode visualizar manifestações da ouvidoria','ouvidoria','view','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('15','ouvidoria.respond','Responder Ouvidoria','Pode responder manifestações da ouvidoria','ouvidoria','edit','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('16','ouvidoria.manage','Gerenciar Ouvidoria','Pode gerenciar todo o sistema de ouvidoria','ouvidoria','manage','1','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19'),
('17','legislacao.view','Visualizar Legislação','Pode visualizar projetos e leis','legislacao','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('18','legislacao.create','Criar Legislação','Pode criar projetos de lei','legislacao','create','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('19','legislacao.edit','Editar Legislação','Pode editar projetos e leis','legislacao','edit','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('20','legislacao.approve','Aprovar Legislação','Pode aprovar projetos de lei','legislacao','approve','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('21','vereadores.view','Visualizar Vereadores','Pode visualizar dados dos vereadores','vereadores','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('22','vereadores.edit','Editar Vereadores','Pode editar dados dos vereadores','vereadores','edit','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('23','vereadores.manage','Gerenciar Vereadores','Pode gerenciar cadastro de vereadores','vereadores','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('24','sessoes.view','Visualizar Sessões','Pode visualizar sessões da câmara','sessoes','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('25','sessoes.create','Criar Sessões','Pode criar novas sessões','sessoes','create','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('26','sessoes.edit','Editar Sessões','Pode editar sessões existentes','sessoes','edit','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('27','transparencia.view','Visualizar Transparência','Pode visualizar dados de transparência','transparencia','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('28','transparencia.manage','Gerenciar Transparência','Pode gerenciar dados de transparência','transparencia','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('29','protocolo.view','Visualizar Protocolos','Pode visualizar protocolos','protocolo','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('30','protocolo.create','Criar Protocolos','Pode criar novos protocolos','protocolo','create','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('31','protocolo.manage','Gerenciar Protocolos','Pode gerenciar sistema de protocolo','protocolo','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('32','admin.dashboard','Dashboard Admin','Pode acessar dashboard administrativo','admin','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('33','admin.config','Configurações','Pode alterar configurações do sistema','admin','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('34','admin.logs','Visualizar Logs','Pode visualizar logs do sistema','admin','view','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('35','system.roles','Gerenciar Roles','Pode gerenciar tipos de usuários','sistema','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('36','system.permissions','Gerenciar Permissões','Pode gerenciar permissões do sistema','sistema','manage','1','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('37','usuarios.listar','Listar usuários','Permissão para Listar usuários','usuarios','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('38','usuarios.criar','Criar usuários','Permissão para Criar usuários','usuarios','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('39','usuarios.editar','Editar usuários','Permissão para Editar usuários','usuarios','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('40','usuarios.excluir','Excluir usuários','Permissão para Excluir usuários','usuarios','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('41','usuarios.impersonificar','Fazer login como outro usuário','Permissão para Fazer login como outro usuário','usuarios','impersonificar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('42','usuarios.gerenciar_roles','Gerenciar roles de usuários','Permissão para Gerenciar roles de usuários','usuarios','gerenciar_roles','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('43','roles.listar','Listar roles','Permissão para Listar roles','roles','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('44','roles.criar','Criar roles','Permissão para Criar roles','roles','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('45','roles.editar','Editar roles','Permissão para Editar roles','roles','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('46','roles.excluir','Excluir roles','Permissão para Excluir roles','roles','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('47','permissoes.listar','Listar permissões','Permissão para Listar permissões','permissoes','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('48','permissoes.criar','Criar permissões','Permissão para Criar permissões','permissoes','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('49','permissoes.editar','Editar permissões','Permissão para Editar permissões','permissoes','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('50','permissoes.excluir','Excluir permissões','Permissão para Excluir permissões','permissoes','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('51','vereadores.listar','Listar vereadores','Permissão para Listar vereadores','vereadores','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('52','vereadores.criar','Criar vereadores','Permissão para Criar vereadores','vereadores','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('53','vereadores.editar','Editar vereadores','Permissão para Editar vereadores','vereadores','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('54','vereadores.excluir','Excluir vereadores','Permissão para Excluir vereadores','vereadores','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('55','noticias.listar','Listar notícias','Permissão para Listar notícias','noticias','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('56','noticias.criar','Criar notícias','Permissão para Criar notícias','noticias','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('57','noticias.editar','Editar notícias','Permissão para Editar notícias','noticias','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('58','noticias.excluir','Excluir notícias','Permissão para Excluir notícias','noticias','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('59','noticias.publicar','Publicar/despublicar notícias','Permissão para Publicar/despublicar notícias','noticias','publicar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('60','sessoes.listar','Listar sessões','Permissão para Listar sessões','sessoes','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('61','sessoes.criar','Criar sessões','Permissão para Criar sessões','sessoes','criar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('62','sessoes.editar','Editar sessões','Permissão para Editar sessões','sessoes','editar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('63','sessoes.excluir','Excluir sessões','Permissão para Excluir sessões','sessoes','excluir','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('64','documentos.listar','Listar documentos','Permissão para Listar documentos','documentos','listar','1','1','1','web','2025-09-28 12:17:22','2025-09-28 12:17:22'),
('65','documentos.criar','Criar documentos','Permissão para Criar documentos','documentos','criar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('66','documentos.editar','Editar documentos','Permissão para Editar documentos','documentos','editar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('67','documentos.excluir','Excluir documentos','Permissão para Excluir documentos','documentos','excluir','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('68','transparencia.listar','Listar dados de transparência','Permissão para Listar dados de transparência','transparencia','listar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('69','transparencia.criar','Criar dados de transparência','Permissão para Criar dados de transparência','transparencia','criar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('70','transparencia.editar','Editar dados de transparência','Permissão para Editar dados de transparência','transparencia','editar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('71','transparencia.excluir','Excluir dados de transparência','Permissão para Excluir dados de transparência','transparencia','excluir','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('72','configuracoes.visualizar','Visualizar configurações','Permissão para Visualizar configurações','configuracoes','visualizar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('73','configuracoes.editar','Editar configurações do sistema','Permissão para Editar configurações do sistema','configuracoes','editar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23'),
('74','dashboard.acessar','Acessar painel administrativo','Permissão para Acessar painel administrativo','dashboard','acessar','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23');

-- Estrutura da tabela `projeto_lei_coautor`
DROP TABLE IF EXISTS `projeto_lei_coautor`;
CREATE TABLE `projeto_lei_coautor` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `projeto_lei_id` bigint(20) unsigned NOT NULL,
  `vereador_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projeto_lei_coautor_projeto_lei_id_vereador_id_unique` (`projeto_lei_id`,`vereador_id`),
  KEY `projeto_lei_coautor_vereador_id_foreign` (`vereador_id`),
  CONSTRAINT `projeto_lei_coautor_projeto_lei_id_foreign` FOREIGN KEY (`projeto_lei_id`) REFERENCES `projetos_lei` (`id`) ON DELETE CASCADE,
  CONSTRAINT `projeto_lei_coautor_vereador_id_foreign` FOREIGN KEY (`vereador_id`) REFERENCES `vereadores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `projeto_lei_coautor`
INSERT INTO `projeto_lei_coautor` VALUES
('1','1','2','2025-09-27 23:13:44','2025-09-27 23:13:44'),
('2','1','3','2025-09-27 23:13:44','2025-09-27 23:13:44');

-- Estrutura da tabela `projetos_lei`
DROP TABLE IF EXISTS `projetos_lei`;
CREATE TABLE `projetos_lei` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `ano` int(11) NOT NULL,
  `tipo` enum('projeto_lei','projeto_resolucao','projeto_decreto','emenda','indicacao','mocao','requerimento') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `ementa` text NOT NULL,
  `texto_integral` longtext NOT NULL,
  `autor_id` bigint(20) unsigned DEFAULT NULL,
  `tipo_autoria` enum('vereador','prefeito','comissao','iniciativa_popular') NOT NULL DEFAULT 'vereador',
  `autor_nome` varchar(255) DEFAULT NULL,
  `dados_iniciativa_popular` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dados_iniciativa_popular`)),
  `coautores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`coautores`)),
  `status` enum('protocolado','em_tramitacao','aprovado','rejeitado','arquivado','retirado') NOT NULL DEFAULT 'protocolado',
  `data_protocolo` date NOT NULL,
  `data_aprovacao` date DEFAULT NULL,
  `comissao_atual` varchar(255) DEFAULT NULL,
  `tramitacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tramitacao`)),
  `justificativa` text DEFAULT NULL,
  `arquivo_original` varchar(255) DEFAULT NULL,
  `arquivo_aprovado` varchar(255) DEFAULT NULL,
  `votacoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`votacoes`)),
  `observacoes` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `legislatura` int(11) NOT NULL,
  `urgencia` tinyint(1) NOT NULL DEFAULT 0,
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `parecer_juridico` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `comite_iniciativa_popular_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projetos_lei_numero_projeto_ano_tipo_unique` (`numero`,`ano`,`tipo`),
  UNIQUE KEY `projetos_lei_slug_unique` (`slug`),
  KEY `projetos_lei_autor_id_foreign` (`autor_id`),
  KEY `projetos_lei_status_legislatura_index` (`status`,`legislatura`),
  KEY `projetos_lei_tipo_ano_index` (`tipo`,`ano`),
  KEY `projetos_lei_categoria_index` (`categoria`),
  KEY `projetos_lei_comite_iniciativa_popular_id_foreign` (`comite_iniciativa_popular_id`),
  CONSTRAINT `projetos_lei_autor_id_foreign` FOREIGN KEY (`autor_id`) REFERENCES `vereadores` (`id`),
  CONSTRAINT `projetos_lei_comite_iniciativa_popular_id_foreign` FOREIGN KEY (`comite_iniciativa_popular_id`) REFERENCES `comite_iniciativa_populars` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `projetos_lei`
INSERT INTO `projetos_lei` VALUES
('1','101','2024','projeto_lei','Institui o Programa Municipal de Coleta Seletiva','1012024-dispoe-sobre-a-criacao-do-programa-municipal-de-co','Dispõe sobre a criação do Programa Municipal de Coleta Seletiva de resíduos sólidos e dá outras providências.','Art. 1º Fica instituído o Programa Municipal de Coleta Seletiva...','1','vereador',NULL,NULL,NULL,'em_tramitacao','2025-08-28',NULL,NULL,NULL,'A implementação da coleta seletiva é fundamental para a preservação do meio ambiente e para o desenvolvimento sustentável do município.',NULL,NULL,NULL,'Projeto em análise pela Comissão de Meio Ambiente',NULL,'\"meio ambiente,sustentabilidade,coleta seletiva\"','2024','0','0',NULL,'2025-09-27 23:13:44','2025-09-27 23:13:44',NULL,NULL),
('3','102','2024','projeto_lei','Cria o Programa de Auxílio Alimentar para Famílias em Situação de Vulnerabilidade','1022024-institui-o-programa-municipal-de-auxilio-alimentar','Institui o Programa Municipal de Auxílio Alimentar destinado às famílias em situação de vulnerabilidade social.','Art. 1º Fica instituído o Programa Municipal de Auxílio Alimentar...',NULL,'prefeito','Prefeito Municipal',NULL,NULL,'aprovado','2025-07-29','2025-09-17',NULL,NULL,'É necessário criar mecanismos de apoio às famílias que se encontram em situação de insegurança alimentar.',NULL,NULL,NULL,'Projeto aprovado por unanimidade',NULL,'\"assist\\u00eancia social,alimenta\\u00e7\\u00e3o,vulnerabilidade\"','2024','1','0',NULL,'2025-09-27 23:27:13','2025-09-27 23:27:13',NULL,NULL),
('4','103','2024','projeto_resolucao','Regulamenta o Funcionamento das Sessões Virtuais da Câmara Municipal','1032024-estabelece-normas-para-a-realizacao-de-sessoes-ord','Estabelece normas para a realização de sessões ordinárias e extraordinárias em formato virtual.','Art. 1º As sessões da Câmara Municipal poderão ser realizadas virtualmente...',NULL,'comissao','Comissão de Constituição e Justiça',NULL,NULL,'em_tramitacao','2025-09-12',NULL,NULL,NULL,'A modernização dos processos legislativos requer a regulamentação das sessões virtuais.',NULL,NULL,NULL,'Em análise pela Mesa Diretora',NULL,'\"moderniza\\u00e7\\u00e3o,tecnologia,sess\\u00f5es virtuais\"','2024','0','0',NULL,'2025-09-27 23:27:13','2025-09-27 23:27:13',NULL,NULL),
('5','104','2024','projeto_lei','Dispõe sobre a Criação de Ciclovias no Município','1042024-institui-o-plano-municipal-de-mobilidade-urbana-su','Institui o Plano Municipal de Mobilidade Urbana Sustentável com foco na criação de ciclovias.','Art. 1º Fica instituído o Plano Municipal de Mobilidade Urbana Sustentável...',NULL,'iniciativa_popular',NULL,NULL,NULL,'em_tramitacao','2025-08-13',NULL,NULL,NULL,'A mobilidade urbana sustentável é essencial para reduzir a poluição e melhorar a qualidade de vida.',NULL,NULL,NULL,'Projeto de iniciativa popular com 1.250 assinaturas válidas',NULL,'\"mobilidade urbana,ciclovias,sustentabilidade\"','2024','0','0',NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22',NULL,'1'),
('6','105','2024','indicacao','Solicita Melhorias na Iluminação Pública do Bairro Centro','1052024-indica-ao-poder-executivo-a-necessidade-de-melhori','Indica ao Poder Executivo a necessidade de melhorias na iluminação pública do Bairro Centro.','Considerando a necessidade de melhorar a segurança pública...','2','vereador',NULL,NULL,NULL,'em_tramitacao','2025-09-07',NULL,NULL,NULL,'A iluminação inadequada compromete a segurança dos munícipes.',NULL,NULL,NULL,'Encaminhado ao Executivo',NULL,'\"ilumina\\u00e7\\u00e3o p\\u00fablica,seguran\\u00e7a,infraestrutura\"','2024','1','0',NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22',NULL,NULL),
('7','106','2024','projeto_lei','Institui a Semana Municipal de Conscientização sobre Autismo','1062024-cria-a-semana-municipal-de-conscientizacao-sobre-o','Cria a Semana Municipal de Conscientização sobre o Transtorno do Espectro Autista.','Art. 1º Fica instituída a Semana Municipal de Conscientização sobre Autismo...',NULL,'comissao','Comissão de Saúde e Assistência Social',NULL,NULL,'aprovado','2025-06-29','2025-08-28',NULL,NULL,'É importante promover a conscientização e inclusão das pessoas com autismo.',NULL,NULL,NULL,'Lei sancionada pelo Prefeito',NULL,'\"inclus\\u00e3o,autismo,conscientiza\\u00e7\\u00e3o\"','2024','0','0',NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22',NULL,NULL),
('8','107','2024','projeto_lei','Cria o Sistema Municipal de Parques Urbanos','1072024-institui-o-sistema-municipal-de-parques-urbanos-pa','Institui o Sistema Municipal de Parques Urbanos para preservação de áreas verdes e lazer.','Art. 1º Fica instituído o Sistema Municipal de Parques Urbanos...',NULL,'iniciativa_popular',NULL,NULL,NULL,'em_tramitacao','2025-09-02',NULL,NULL,NULL,'A criação de parques urbanos é fundamental para a qualidade de vida e preservação ambiental.',NULL,NULL,NULL,'Projeto de iniciativa popular com 2.100 assinaturas válidas',NULL,'\"parques,meio ambiente,lazer,qualidade de vida\"','2024','0','0',NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22',NULL,'2');

-- Estrutura da tabela `receitas`
DROP TABLE IF EXISTS `receitas`;
CREATE TABLE `receitas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_receita` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `fonte_recurso` varchar(255) DEFAULT NULL,
  `valor_previsto` decimal(15,2) NOT NULL,
  `valor_arrecadado` decimal(15,2) NOT NULL DEFAULT 0.00,
  `data_arrecadacao` date DEFAULT NULL,
  `mes_referencia` int(11) NOT NULL,
  `ano_referencia` int(11) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('previsto','arrecadado','cancelado') NOT NULL DEFAULT 'previsto',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receitas_codigo_receita_unique` (`codigo_receita`),
  KEY `receitas_ano_referencia_mes_referencia_index` (`ano_referencia`,`mes_referencia`),
  KEY `receitas_categoria_index` (`categoria`),
  KEY `receitas_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `role_has_permissions`
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `role_has_permissions`
INSERT INTO `role_has_permissions` VALUES
('1','2'),
('2','2'),
('3','2'),
('11','2'),
('12','2'),
('14','2'),
('15','2'),
('32','2'),
('11','3'),
('12','3'),
('13','3'),
('27','3'),
('28','3'),
('32','3'),
('14','4'),
('15','4'),
('16','4'),
('32','4'),
('17','5'),
('18','5'),
('19','5'),
('21','5'),
('22','5'),
('24','5'),
('32','5'),
('1','6'),
('2','6'),
('3','6'),
('5','6'),
('17','6'),
('18','6'),
('19','6'),
('20','6'),
('21','6'),
('22','6'),
('23','6'),
('24','6'),
('25','6'),
('26','6'),
('32','6'),
('1','7'),
('2','7'),
('3','7'),
('5','7'),
('32','7'),
('29','8'),
('30','8'),
('31','8'),
('32','8'),
('1','9'),
('2','9'),
('3','9'),
('27','9'),
('28','9'),
('32','9'),
('37','10'),
('38','10'),
('39','10'),
('42','10'),
('43','10'),
('47','10'),
('51','10'),
('52','10'),
('53','10'),
('55','10'),
('56','10'),
('57','10'),
('59','10'),
('60','10'),
('61','10'),
('62','10'),
('64','10'),
('65','10'),
('66','10'),
('68','10'),
('72','10'),
('74','10'),
('1','11'),
('2','11'),
('3','11'),
('4','11'),
('5','11'),
('6','11'),
('7','11'),
('8','11'),
('9','11'),
('10','11'),
('11','11'),
('12','11'),
('13','11'),
('14','11'),
('15','11'),
('16','11'),
('17','11'),
('18','11'),
('19','11'),
('20','11'),
('21','11'),
('22','11'),
('23','11'),
('24','11'),
('25','11'),
('26','11'),
('27','11'),
('28','11'),
('29','11'),
('30','11'),
('31','11'),
('32','11'),
('33','11'),
('34','11'),
('35','11'),
('36','11'),
('37','11'),
('38','11'),
('39','11'),
('40','11'),
('41','11'),
('42','11'),
('43','11'),
('44','11'),
('45','11'),
('46','11'),
('47','11'),
('48','11'),
('49','11'),
('50','11'),
('51','11'),
('52','11'),
('53','11'),
('54','11'),
('55','11'),
('56','11'),
('57','11'),
('58','11'),
('59','11'),
('60','11'),
('61','11'),
('62','11'),
('63','11'),
('64','11'),
('65','11'),
('66','11'),
('67','11'),
('68','11'),
('69','11'),
('70','11'),
('71','11'),
('72','11'),
('73','11'),
('74','11');

-- Estrutura da tabela `roles`
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(100) DEFAULT NULL COMMENT 'Nome para exibição (ex: Administrador, Secretário)',
  `description` text DEFAULT NULL COMMENT 'Descrição detalhada do tipo de usuário',
  `color` varchar(7) NOT NULL DEFAULT '#6B7280' COMMENT 'Cor para identificação visual (hex)',
  `is_system` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Role do sistema (não pode ser excluído)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Role ativo/inativo',
  `priority` int(11) NOT NULL DEFAULT 0 COMMENT 'Prioridade para ordenação (maior = mais importante)',
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  KEY `roles_is_active_priority_index` (`is_active`,`priority`),
  KEY `roles_is_system_index` (`is_system`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `roles`
INSERT INTO `roles` VALUES
('1','cidadao','Cidadão','Usuário comum do sistema, pode fazer solicitações e acompanhar processos','#6B7280','1','1','1','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('2','secretario','Secretário/Assessor','Pode gerenciar conteúdo e responder solicitações','#3B82F6','1','1','5','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('3','responsavel_esic','Responsável e-SIC','Especialista em transparência e acesso à informação','#10B981','1','1','6','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('4','ouvidor','Ouvidor','Responsável por manifestações da ouvidoria','#F59E0B','1','1','6','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('5','vereador','Vereador','Vereador da câmara municipal','#8B5CF6','1','1','8','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('6','presidente','Presidente da Câmara','Presidente da câmara municipal','#DC2626','1','1','10','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('7','editor','Editor de Conteúdo','Pode criar e editar conteúdo do site','#06B6D4','1','1','4','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('8','protocolo','Protocolo','Responsável pelo protocolo de documentos','#84CC16','1','1','3','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('9','contador','Contador/Financeiro','Responsável por dados financeiros e transparência','#EF4444','1','1','7','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('10','admin','Administrador Geral','Acesso total ao sistema','#1F2937','1','1','100','web','2025-09-28 11:07:20','2025-09-28 11:07:20'),
('11','super-admin','Super Administrador','Acesso total ao sistema','#DC2626','1','1','1','web','2025-09-28 12:17:23','2025-09-28 12:17:23');

-- Estrutura da tabela `sessao_projeto_lei`
DROP TABLE IF EXISTS `sessao_projeto_lei`;
CREATE TABLE `sessao_projeto_lei` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sessao_id` bigint(20) unsigned NOT NULL,
  `projeto_lei_id` bigint(20) unsigned NOT NULL,
  `ordem_pauta` int(11) DEFAULT NULL,
  `resultado_votacao` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessao_projeto_lei_sessao_id_projeto_lei_id_unique` (`sessao_id`,`projeto_lei_id`),
  KEY `sessao_projeto_lei_projeto_lei_id_foreign` (`projeto_lei_id`),
  KEY `sessao_projeto_lei_ordem_pauta_index` (`ordem_pauta`),
  CONSTRAINT `sessao_projeto_lei_projeto_lei_id_foreign` FOREIGN KEY (`projeto_lei_id`) REFERENCES `projetos_lei` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sessao_projeto_lei_sessao_id_foreign` FOREIGN KEY (`sessao_id`) REFERENCES `sessoes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `sessao_vereador`
DROP TABLE IF EXISTS `sessao_vereador`;
CREATE TABLE `sessao_vereador` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sessao_id` bigint(20) unsigned NOT NULL,
  `vereador_id` bigint(20) unsigned NOT NULL,
  `presente` tinyint(1) NOT NULL DEFAULT 1,
  `justificativa_ausencia` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessao_vereador_sessao_id_vereador_id_unique` (`sessao_id`,`vereador_id`),
  KEY `sessao_vereador_vereador_id_foreign` (`vereador_id`),
  KEY `sessao_vereador_presente_index` (`presente`),
  CONSTRAINT `sessao_vereador_sessao_id_foreign` FOREIGN KEY (`sessao_id`) REFERENCES `sessoes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sessao_vereador_vereador_id_foreign` FOREIGN KEY (`vereador_id`) REFERENCES `vereadores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `sessions`
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `sessions`
INSERT INTO `sessions` VALUES
('0qQclAe5k3nNKkOkYRxJMz6JQDoi6u0pzOSrtAnm','11','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidHd1NmVJSWZVMzd3MllzaFQyNnJacHdlTUpSSzdZdHY1UGdJMUt6ZiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ3OiJodHRwOi8vMTI3LjAuMC4xL2NhbGVuZGFyaW8vbWluaT9hbm89MjAyNSZtZXM9OSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExO30=','1759083472'),
('4CrufdHtV5NZmcgZz6Xok4plps8oDaWhiwplMHpY',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidDVPdVhPejlydGNkSWRoNFY3NURMRnpJaDJXMFhwWkswV25ueFlWUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjEvY2FsZW5kYXJpby9taW5pP2Fubz0yMDI1Jm1lcz05Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759078579'),
('5dfOdshlJHN4Pad6qB17xb5TuPhRl1XfG3Fi2goT',NULL,'49.51.253.26','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUNzcVNzTEtXOGQ5MWdyczRLUTZJZWxrbWRLekZkYjBYbmk1a3dycCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC92ZXJlYWRvcmVzLzciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759077768'),
('5ESyhidNCP1izPDg4wN5aCmFtK0mOPIjGknTblH5',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoicVc4ZEJVaXNLbnMzTUNRVHczdjFMMXpqN3BqWW54dXJRd3E1bndEaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759080965'),
('7Knm30m0Rfcga4P5VUINGkonMtFnihm5RKNNMCVp',NULL,'204.76.203.219','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiVG1NeFRVV2VFUWFjY0N2c2NVRm1lbUxDMDZoT1ZMaExyMUJIUTBlSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759076353'),
('BrweJ3sY19e6X1GW0sDAIfgIyNBPdhgFnMRfn7ZI',NULL,'43.152.72.247','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWkxTnE3NDN5ZUpka3p0bE5mWmw5bHFmTm50aXBXeEtwS3VTUGFnNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9jYWxlbmRhcmlvL2V4cG9ydGFyLmljcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759080845'),
('C5SPu0r7koJz1yTyJyH8PHtL67yswKOkLBpwDsQl',NULL,'37.60.141.156','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnZTYmx3OWpNbFNzUnpJbDZ2WWdsV203ZkR4clJVRm1zQW5mTHBMbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759082656'),
('DslpQKX8hna2FbuugrPaabmdxeozXxhRlXGsjO79',NULL,'45.156.128.126','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36 ','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWVPOXhYaWk4bmtQaW5nZUZvTEs2aHZWbmVjSFZnTW5GVm96emlyRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759078525'),
('fPavJ7HiBlmaM1fKxY29IItkKkHn4FA8q48rTVw4',NULL,'204.76.203.219','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ21waFJHeDd3ZlZITEtjRFg1R2dpenZzTVZMeTZqdzRzanIwVVIyUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759077104'),
('Frv8du5sP0y7s8yLT2v8Ltnd73vHB4wYOuC6gQGD',NULL,'43.153.79.218','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoib0NMYk9YV3RWcGNNVlMxcVdIT2VvVzdKU1BkNmc0N0JXTkpDNDZLYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC92ZXJlYWRvcmVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759075996'),
('GOD2I5yk5BN37GYIuxOqulKwL8njJTbeNYn41VjC',NULL,'170.106.140.110','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnlDcTAwdzh2RXNnbERwQzQ0cEs1THlQdktTMmY2cjV5aXh6eEZ3QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9jYWxlbmRhcmlvL2FnZW5kYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759081463'),
('HeAVC8qqcEYvuhqdlUY2A02PspO8OKKiDpwm0s0B',NULL,'43.135.133.241','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoicG1RbWQ3Y0FuaERCS3pJY1Ztc1dYYzM0czVIV3VNZ25ReWM4TzZlMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC92ZXJlYWRvcmVzLzMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759079644'),
('HjTLbykyDZUWFU9OuETgx6vyYYMHBTYL9mrDscHX',NULL,'101.32.52.164','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmFMS2dHWU1md3VwbXpaUlJQYUg4b3I0VlNxUDVScVFmTFo4MEp5ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759074429'),
('HnoOLtL8DyGHsHIRTaHItnLtRd8wMgaH3NNbWMca',NULL,'20.65.195.57','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUhqTnJmbnY1T1FqcXVTQnNmYUNYdmVOTFptR3BvQ1dJdmdQOWxBYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759079456'),
('IkHsLjUl1pCdDCY0APRrwf6lFIiyJD2K8RKCGWw1',NULL,'91.148.248.36','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUdtUWJtUnN6azRGVEFUQkR2STJIekFDbEhmbWo5WERSRHQ5Z0V3TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759074581'),
('JNOBvuveCNBD62xWMNPskP4AUufu4YfnTT9i1s1l',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYm5YallEZlVldU82cEg3bHZ3REZabFFDOWFZd1JQUkdHWWRZeXVVNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759078541'),
('JUI9VwkszjX2XNdM1t6gFFAfGCPT0BkrQIg7w1n6',NULL,'43.153.76.247','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWJyMGtHaWNzdE1jVlZqdlhtblVDdXJ2bDBxUFJqMXMzcnNjeXNuViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9zb2JyZS9oaXN0b3JpYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759080287'),
('jXE4hZ911xye92SHihu1GFekvkEDsFPD9EhiRoWY',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicE0xeGxNM2xnZ0M5VVJpZkVWcThTaUNDamI5V0lPbTR0MUx5ZlB1dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3QvY2FsZW5kYXJpby9taW5pP2Fubz0yMDI1Jm1lcz05Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759078582'),
('l87cIiiEa07EzjcQEMYELjYrkO2Raw5G2OB8kCNI',NULL,'43.159.128.247','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0hZdnppeDFVOVd0VDdGWTlGWEY4NXVWRWlJM0lVNzM2QzB6UGpvUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9sZWlzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759075339'),
('lnz1qZdHl0TSa4YLKNbS1CXW7Ezyusy3QZ1m4l2d',NULL,'176.65.132.155','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRERRWlRUYlU3OEl3cnl1Q2diNjRPSlUyeWZQbkpCb1ZxTDd1OTd3VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759077908'),
('mjCxUuniQZnG2bS8hWCw3ojsl4hURtpEfZJ7dODX',NULL,'43.159.141.150','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzZxdmVnSEh5OHo1RGJPTGNPNGRaN1RJSTNEMEVnTjhMWkpqU3FMQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9sZWlzL2NvbWlzc2FvLWV0aWNhLWRlY29yby0xMy0yMDI1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759082623'),
('NPxH931MbwnJ6kgYGw4fPweL1lB9bds6XUynm1LP',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3VFVnB6M2FtYTJhdGg3NGZ2bVdJakZkQWFNWHpwSVpJbWppb1BFTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3QvY2FsZW5kYXJpby9taW5pP2Fubz0yMDI1Jm1lcz05Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759079448'),
('oeClHs5XKE4oAUib5MF1OQSuePJDhf70adZ0iLJM',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibFN2dDlpdW1lc1Y1OGQ2SE40SUllSDJrWTVDcUxWV1Ywc3g5QnM5SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759076185'),
('OP9DhlPPUlu7yhhjv9f7zBCqoJ9jnsCHfIzTpxOa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicEhITXB1ek9SczR2TlA2M2dGSldMaFdkN2NhT1ZGQWo1V0dzb3l1SiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cDovLzEyNy4wLjAuMS9hZG1pbi9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMjoiaHR0cDovLzEyNy4wLjAuMS9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759075804'),
('OUvIQf1kn1elLK1NTpZuHzSDENKiqT86BLMlrkCu',NULL,'49.51.36.179','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUpaV04zNGk2NlJzVGh4S1d5YW5mZTNLMEpsdUtlUVowMHlBR0IwTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9sZWlzL2Fwcm92YWNhby1jb252ZW5pby1lc3RhZG8tb2JyYXMtOS0yMDI1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759081912'),
('P0frWOvXDyEPhuYhfPGBl9sVyR7CIgylFzllhirP',NULL,'79.124.58.198','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieU9xQlB6R0k1Z2x0SGZzR2RIZWdHV014UnRiYXFCNDllNWFSeHFXRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC8/WERFQlVHX1NFU1NJT05fU1RBUlQ9cGhwc3Rvcm0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759073617'),
('P8SFrJj2Kg21yAANGPwaeEolapo5VCwcfbFzL2n6',NULL,'43.159.128.247','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoibzQ4MjBLUmlQenNKR2x4dmNWTVF1bmd5ek84dktkQ05jd285VmttWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9jYWxlbmRhcmlvL2FnZW5kYT92ZXJlYWRvcj0zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759078380'),
('prTKrW2ajh2Dc4XLDHeUiuNgJOF9bx1Ehzkylimk',NULL,'43.152.72.247','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVm9nenVRcnVhY21vSFlhdlZTUnZYcXRsT3VCcVVnOW9CYWRoN0EyaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC90cmFuc3BhcmVuY2lhL2xpY2l0YWNvZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759076604'),
('PrYB9N6dOJz6kUmo9L9IkvMwB5B43tJJG0j7POJg',NULL,'43.154.140.188','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXVaamlENFFqN3dMRGpuVlFYcXRkSm9GdHFRMkp2cVBqUms4VFl3cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9wcm9qZXRvcy1sZWkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1759083879'),
('qlsZDT89hNwalx282suVCFUyllLl6w3pwaMHK0va',NULL,'43.135.144.126','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNDJyR29JUDJrYmt4dU9yYzVFdVNPNVRsNFJKVGZZMDZxaUs0Q0RVdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9sZWlzL2xlaS1tdW5pY2lwYWwtMTQ4NS0yMDI1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759078955'),
('RHoLqkiYy0zhYbqShrhRCNg8I6dw64eUXfzVvJ6B',NULL,'43.152.72.244','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTG9ZUTI3Y2hZWWdkSmJVZk9kOU5OQVV2OUtwN2p1M2Q5djRWMVNXdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC90cmFuc3BhcmVuY2lhL2NvbnRyYXRvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759083903'),
('RlvxP3MHOZVEhJHX3VpVJSbLJQPxCUMQkWvPS4O0',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzVOM0l3ZjNRUEtSREM5eTNoZXk3MExaRERXUzhwZDdwVDJ2Rjd5YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759083319'),
('ROYvb7tqkAb1Y3WLM4zUpkqUUgemoVn590XFdHcP',NULL,'37.60.141.156','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUVMcDFCaEt1a2R4OU9vekJUTUtqSjF1WTF3OThMcmM5Q2dnS09iZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759075961'),
('rXgtyA4jIFfzlI799dfBz7rhD93BfZKZMVZZnzCL',NULL,'204.76.203.219','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSmNtVnd5UVBEc2czalpWZkloQVU0bGxZem80bHV2R2NadGhIUmJ3bCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759079205'),
('scDxmSodGjryRhNbZ6fky2SH8Nl34PX3pRUnv4tw',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGE4Um9nN1hlZWo4TnBuaDNucnVRQVhCNVBSdUw1WGd5V0FCdzVtUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759073912'),
('sWlGXezw5dX9o8u6TZCvfpoY90CUREvBGbYMyZni',NULL,'43.157.20.63','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoienFiZ2cwQnllb0hCQ3pGWnVLT010V0JXWUpNdHZ0TlhqMHNmeHYxTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOC9jb250YXRvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759077185'),
('t0rQZFPuewXQWxGZmYDjG8V1aGMjCCwklC41VcO9',NULL,'170.83.199.105','ivre-masscan/1.3 https://github.com/robertdavidgraham/','YTozOntzOjY6Il90b2tlbiI7czo0MDoiakZDS2hTTFVJdXFTV3JRQzlJdmtWNjhrVHVsbFhaR3J6ZExrTGtBNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTQ6Imh0dHA6Ly8wLjAuMC4wIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1759081320'),
('xLQ5UJjdFflyHVsFw0wx45To62WX6l6U0wpsMpYm',NULL,'201.71.169.153','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkxkNnZ3bmE2WmxYSW5hWndCOWZNU29VUzR1Y1l0dXdwZmxiNlR1ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9saWRlcmEuYXBwLmJyL2NhbGVuZGFyaW8vbWluaT9hbm89MjAyNSZtZXM9OSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1759084126');

-- Estrutura da tabela `sessoes`
DROP TABLE IF EXISTS `sessoes`;
CREATE TABLE `sessoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero_sessao` varchar(255) NOT NULL,
  `tipo` enum('ordinaria','extraordinaria','solene','especial') NOT NULL,
  `tipo_sessao_id` bigint(20) unsigned DEFAULT NULL,
  `data_sessao` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time DEFAULT NULL,
  `status` enum('agendada','em_andamento','finalizada','cancelada') NOT NULL DEFAULT 'agendada',
  `pauta` text DEFAULT NULL,
  `ata` longtext DEFAULT NULL,
  `local` varchar(255) NOT NULL DEFAULT 'Plenário da Câmara Municipal',
  `presencas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`presencas`)),
  `votacoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`votacoes`)),
  `arquivo_ata` varchar(255) DEFAULT NULL,
  `arquivo_audio` varchar(255) DEFAULT NULL,
  `arquivo_video` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `legislatura` int(11) NOT NULL,
  `transmissao_online` tinyint(1) NOT NULL DEFAULT 0,
  `link_transmissao` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `video_url` text DEFAULT NULL COMMENT 'URL do vídeo gravado (YouTube, Vimeo, Facebook)',
  `plataforma_video` enum('youtube','vimeo','facebook','outro') DEFAULT NULL COMMENT 'Plataforma do vídeo',
  `thumbnail_url` text DEFAULT NULL COMMENT 'URL da thumbnail do vídeo',
  `duracao_video` int(11) DEFAULT NULL COMMENT 'Duração do vídeo em segundos',
  `descricao_video` text DEFAULT NULL COMMENT 'Descrição do vídeo gravado',
  `video_disponivel` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Se o vídeo está disponível para visualização',
  `data_gravacao` timestamp NULL DEFAULT NULL COMMENT 'Data e hora da gravação',
  `presidente_id` bigint(20) unsigned DEFAULT NULL,
  `secretario_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessoes_numero_sessao_legislatura_unique` (`numero_sessao`,`legislatura`),
  KEY `sessoes_data_sessao_tipo_index` (`data_sessao`,`tipo`),
  KEY `sessoes_status_legislatura_index` (`status`,`legislatura`),
  KEY `sessoes_presidente_id_foreign` (`presidente_id`),
  KEY `sessoes_secretario_id_foreign` (`secretario_id`),
  KEY `sessoes_tipo_sessao_id_index` (`tipo_sessao_id`),
  CONSTRAINT `sessoes_presidente_id_foreign` FOREIGN KEY (`presidente_id`) REFERENCES `vereadores` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sessoes_secretario_id_foreign` FOREIGN KEY (`secretario_id`) REFERENCES `vereadores` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sessoes_tipo_sessao_id_foreign` FOREIGN KEY (`tipo_sessao_id`) REFERENCES `tipo_sessaos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `sessoes`
INSERT INTO `sessoes` VALUES
('1','001/2024','ordinaria','1','2024-02-05','19:00:00','21:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Primeira sessão do ano legislativo de 2024','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example1','youtube','https://img.youtube.com/vi/example1/maxresdefault.jpg',NULL,'1ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-02-05 19:00:00',NULL,NULL),
('2','002/2024','ordinaria','1','2024-02-19','19:00:00','20:45:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão de projetos de lei municipais','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example2','youtube','https://img.youtube.com/vi/example2/maxresdefault.jpg',NULL,'2ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-02-19 19:00:00',NULL,NULL),
('3','003/2024','extraordinaria','2','2024-03-01','14:00:00','16:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Sessão especial para aprovação do orçamento','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example3','youtube','https://img.youtube.com/vi/example3/maxresdefault.jpg',NULL,'Sessão Extraordinária - Orçamento Municipal 2024','1','2024-03-01 14:00:00',NULL,NULL),
('4','004/2024','ordinaria','1','2024-03-18','19:00:00','21:15:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Votação de projetos em segunda discussão','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example4','youtube','https://img.youtube.com/vi/example4/maxresdefault.jpg',NULL,'4ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-03-18 19:00:00',NULL,NULL),
('5','005/2024','solene','3','2024-04-22','10:00:00','12:00:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Sessão comemorativa ao Dia do Descobrimento do Brasil','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL),
('6','006/2024','ordinaria','1','2024-05-06','19:00:00','20:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão sobre obras públicas municipais','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL),
('7','007/2024','ordinaria','1','2024-05-20','19:00:00','21:45:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Prestação de contas do primeiro quadrimestre','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL),
('8','008/2024','extraordinaria','2','2024-06-10','15:00:00','17:20:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão e votação do novo Plano Diretor','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL);

-- Estrutura da tabela `slides`
DROP TABLE IF EXISTS `slides`;
CREATE TABLE `slides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `nova_aba` tinyint(1) NOT NULL DEFAULT 0,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `velocidade` int(11) NOT NULL DEFAULT 5000,
  `transicao` varchar(255) NOT NULL DEFAULT 'fade',
  `direcao` varchar(255) NOT NULL DEFAULT 'left',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `slides`
INSERT INTO `slides` VALUES
('1','Transparência e Participação','Acompanhe as atividades da Câmara Municipal e participe das decisões que afetam nossa cidade.','https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/transparencia','0','1','1','5','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24'),
('2','Conheça Nossos Vereadores','Representantes eleitos trabalhando pelo desenvolvimento e bem-estar da população.','https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/vereadores','0','2','1','4','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24'),
('3','Sessões da Câmara','Assista às sessões ao vivo e acompanhe as discussões sobre projetos de lei e políticas públicas.','https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/sessoes','0','3','1','6','fade','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24'),
('4','Portal da Transparência','Acesse informações sobre gastos públicos, contratos e prestação de contas da administração.','https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=400&fit=crop&crop=center','#','1','4','1','5','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24'),
('5','Ouvidoria Municipal','Canal direto para sugestões, reclamações e elogios. Sua voz é importante para nós.','https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/ouvidoria','0','5','1','4','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');

-- Estrutura da tabela `tipo_contratos`
DROP TABLE IF EXISTS `tipo_contratos`;
CREATE TABLE `tipo_contratos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estrutura da tabela `tipo_sessaos`
DROP TABLE IF EXISTS `tipo_sessaos`;
CREATE TABLE `tipo_sessaos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `cor` varchar(7) NOT NULL DEFAULT '#007bff',
  `icone` varchar(50) NOT NULL DEFAULT 'fas fa-gavel',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo_sessaos_nome_unique` (`nome`),
  UNIQUE KEY `tipo_sessaos_slug_unique` (`slug`),
  KEY `tipo_sessaos_ativo_ordem_index` (`ativo`,`ordem`),
  KEY `tipo_sessaos_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `tipo_sessaos`
INSERT INTO `tipo_sessaos` VALUES
('1','Sessão Ordinária','sessao-ordinaria','Sessões regulares realizadas conforme calendário oficial da Câmara Municipal.','#3b82f6','fas fa-calendar-alt','1','1','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL),
('2','Sessão Extraordinária','sessao-extraordinaria','Sessões especiais convocadas para tratar de assuntos urgentes ou específicos.','#ef4444','fas fa-exclamation-triangle','1','2','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL),
('3','Sessão Solene','sessao-solene','Sessões cerimoniais para homenagens, outorga de títulos e eventos especiais.','#8b5cf6','fas fa-award','1','3','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL),
('4','Audiência Pública','audiencia-publica','Sessões abertas para participação e manifestação da população sobre temas específicos.','#10b981','fas fa-users','1','4','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL),
('5','Sessão Especial','sessao-especial','Sessões temáticas ou comemorativas sobre assuntos de interesse público.','#f59e0b','fas fa-star','1','5','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);

-- Estrutura da tabela `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(255) DEFAULT NULL,
  `terms_accepted_at` timestamp NULL DEFAULT NULL,
  `privacy_accepted_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `users`
INSERT INTO `users` VALUES
('2','João Silva Santos','secretario@camara.gov.br',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:52',NULL,NULL,NULL,'$2y$12$r3YDo7A76uhjwurhzypK6uJVoJP6ZTwXBsRgTBuRIsfg7mWW3DcYS',NULL,'2025-09-26 07:12:31','2025-09-26 07:51:52'),
('3','Maria Oliveira Costa','editor@camara.gov.br',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:53',NULL,NULL,NULL,'$2y$12$aNMhTd2FfMREIpaevs.Rj.ufiozjicgaoh/d.PNIcKc6NMtwzzS4W',NULL,'2025-09-26 07:12:32','2025-09-26 07:51:53'),
('4','Carlos Eduardo Pereira','carlos.pereira@camara.gov.br',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:54',NULL,NULL,NULL,'$2y$12$0ib07maSdnrEzDm4IdRlru3WdlmAOSevXgd12noRJsU.eBJYQ0P8u',NULL,'2025-09-26 07:12:33','2025-09-26 07:51:54'),
('5','Ana Paula Rodrigues','ana.rodrigues@camara.gov.br',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:54',NULL,NULL,NULL,'$2y$12$RPmXMQ2GfePbxlN7YGOly.8mhEsOcOcxqFqijPhHQOX6EpbNdb3NK',NULL,'2025-09-26 07:12:33','2025-09-26 07:51:55'),
('6','José da Silva','jose.silva@email.com',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:55',NULL,NULL,NULL,'$2y$12$21cg74RenX9Rnbjs/bHklOXGCmMRqVsZCM7uOuRGNyQylSS1xYwq6',NULL,'2025-09-26 07:12:34','2025-09-26 07:51:56'),
('7','Pedro Santos Oliveira','pedro.santos@email.com',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:56',NULL,NULL,NULL,'$2y$12$SNptL/uqFzqnP3BnTqIrV.ARqKIboeFbj4rNJgUNz0qZJACxJJ7Vi',NULL,'2025-09-26 07:12:35','2025-09-26 07:51:56'),
('8','Fernanda Lima Costa','esic@camara.gov.br',NULL,NULL,NULL,NULL,'user','1','2025-09-26 07:51:57',NULL,NULL,NULL,'$2y$12$O.IpGVBEWC0ND9fo8cPkTe5emZigWfCZj9zTQk/pUsDog7.4EGwki',NULL,'2025-09-26 07:12:36','2025-09-26 07:51:57'),
('11','Administrador do Sistema','admin@camara.gov.br',NULL,NULL,NULL,NULL,'admin','1','2025-09-26 07:51:51',NULL,NULL,NULL,'$2y$12$76PEXilbH1pjk5trWrb8J.Fefu9BrUGHqLrAEU3LOidlYXASFfwd.',NULL,'2025-09-26 07:20:44','2025-09-26 08:14:45'),
('12','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com',NULL,NULL,NULL,NULL,'user','1','2025-09-28 09:12:15',NULL,'2025-09-28 09:11:21','2025-09-28 09:11:21','$2y$12$Oj9ybR4ad22yb48T5PW0tuBjy/LsmzJACZ9Pk9ql.ob9hPSDxBdym','rgsQz4AwfiWlz2yJFesE1yTl9XUsqTAuTcLg8mHsYfc7RpPTF7oSohOdV1w0','2025-09-28 09:11:21','2025-09-28 10:08:30');

-- Estrutura da tabela `vereadores`
DROP TABLE IF EXISTS `vereadores`;
CREATE TABLE `vereadores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `nome_parlamentar` varchar(255) DEFAULT NULL,
  `partido` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `profissao` varchar(255) DEFAULT NULL,
  `escolaridade` varchar(255) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativo','inativo','licenciado') NOT NULL DEFAULT 'ativo',
  `inicio_mandato` date NOT NULL,
  `fim_mandato` date NOT NULL,
  `legislatura` int(11) NOT NULL,
  `comissoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`comissoes`)),
  `presidente` tinyint(1) NOT NULL DEFAULT 0,
  `vice_presidente` tinyint(1) NOT NULL DEFAULT 0,
  `redes_sociais` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`redes_sociais`)),
  `proposicoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vereadores_email_unique` (`email`),
  KEY `vereadores_status_legislatura_index` (`status`,`legislatura`),
  KEY `vereadores_partido_index` (`partido`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados da tabela `vereadores`
INSERT INTO `vereadores` VALUES
('1','Carlos Eduardo Pereira','Vereador Carlos Pereira','PSDB','carlos.pereira@camara.gov.br','11966666666','Formado em Administração Pública, Carlos Eduardo Pereira tem 15 anos de experiência em gestão municipal. Durante seu mandato, tem focado em projetos de educação, saúde pública e desenvolvimento urbano sustentável. Atualmente exerce a função de Presidente da Câmara Municipal.','vereadores/DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"presidente\",\"comissao-educacao\"]','0','0','{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorcarlospereira\",\"instagram\":\"@vereadorcarlospereira\",\"twitter\":\"@carlospereira_vr\"}','PL 001/2021 - Programa Municipal de Alfabetização Digital; PL 015/2022 - Criação de Centros de Saúde Comunitários; PL 028/2023 - Incentivo ao Transporte Sustentável','2025-09-26 07:51:57','2025-09-28 13:10:08'),
('2','Ana Paula Rodrigues','Vereadora Ana Paula','PT','ana.rodrigues@camara.gov.br','11955555555','Assistente Social com mestrado em Políticas Sociais, Ana Paula Rodrigues é uma defensora incansável dos direitos das mulheres e das políticas de inclusão social. Atua há 12 anos no terceiro setor.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-direitos-humanos\\\",\\\"comissao-saude\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadoraanapaula\\\",\\\"instagram\\\":\\\"@vereadoraanapaula\\\",\\\"linkedin\\\":\\\"ana-paula-rodrigues-vereadora\\\"}\"','PL 008/2021 - Casa de Apoio à Mulher Vítima de Violência; PL 022/2022 - Programa Municipal de Capacitação Profissional Feminina; PL 035/2023 - Creches Noturnas para Mães Trabalhadoras','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('3','Roberto Silva Mendes','Vereador Roberto Mendes','MDB','roberto.mendes@camara.gov.br','11911111111','Empresário do setor de construção civil, Roberto Silva Mendes dedica-se às questões de infraestrutura urbana e desenvolvimento econômico do município.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-obras\\\",\\\"comissao-financas\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadorrobertomendes\\\",\\\"instagram\\\":\\\"@robertomendes_vereador\\\"}\"','PL 012/2021 - Modernização da Infraestrutura Viária; PL 025/2022 - Incentivos para Pequenas Empresas Locais; PL 031/2023 - Programa de Construção Sustentável','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('4','Maria José Santos','Vereadora Maria José','PDT','maria.santos@camara.gov.br','11922222222','Professora aposentada com 30 anos de magistério, Maria José Santos é especialista em educação infantil e políticas educacionais. Dedica seu mandato à melhoria da qualidade do ensino público municipal.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-educacao\\\",\\\"comissao-cultura\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadoramariajose\\\",\\\"instagram\\\":\\\"@mariajose_vereadora\\\",\\\"youtube\\\":\\\"Vereadora Maria Jos\\\\u00e9 Santos\\\"}\"','PL 005/2021 - Ampliação do Ensino Integral; PL 018/2022 - Biblioteca Comunitária em Cada Bairro; PL 029/2023 - Programa de Alfabetização de Adultos','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('5','João Batista Lima','Vereador João Batista','PP','joao.lima@camara.gov.br','11933333333','Agricultor familiar e líder comunitário, João Batista Lima representa os interesses da zona rural do município. Atua na defesa da agricultura sustentável e do desenvolvimento rural.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-agricultura\\\",\\\"comissao-meio-ambiente\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadorjoaobatista\\\",\\\"instagram\\\":\\\"@joaobatista_rural\\\",\\\"whatsapp\\\":\\\"11933333333\\\"}\"','PL 007/2021 - Incentivo à Agricultura Familiar; PL 020/2022 - Programa de Reflorestamento Municipal; PL 033/2023 - Centro de Comercialização de Produtos Rurais','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('6','Fernanda Costa','Vereadora Fernanda','PSOL','fernanda.costa@camara.gov.br','11944444444','Advogada especializada em direitos humanos e ativista social. Fernanda Costa luta pelos direitos da juventude, LGBTQIA+ e pela transparência na gestão pública.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-direitos-humanos\\\",\\\"comissao-juventude\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadorafernanda\\\",\\\"instagram\\\":\\\"@fernanda_vereadora\\\",\\\"twitter\\\":\\\"@fernandacosta_vr\\\",\\\"tiktok\\\":\\\"@vereadorafernanda\\\"}\"','PL 010/2021 - Centro de Referência LGBTQIA+; PL 024/2022 - Programa Jovem Empreendedor; PL 037/2023 - Portal da Transparência Cidadã','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('7','Antônio Carlos Oliveira','Vereador Antônio Carlos','PL','antonio.oliveira@camara.gov.br','11977777777','Ex-policial militar e especialista em segurança pública. Antônio Carlos Oliveira dedica seu mandato às questões de segurança urbana, trânsito e proteção civil.','vereadores/JwWNW2GpoXCjGDZid0BNSAYh1r4e2R0XIRVuGni9.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-seguranca\",\"comissao-transito\"]','0','0','{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorantoniocarlos\",\"instagram\":\"@antoniocarlos_seguranca\",\"linkedin\":\"antonio-carlos-oliveira-vereador\"}','PL 003/2021 - Ampliação do Sistema de Videomonitoramento; PL 016/2022 - Programa Ronda Escolar; PL 030/2023 - Central de Emergências Integrada','2025-09-26 07:51:57','2025-09-28 11:09:51'),
('8','Patrícia Almeida','Vereadora Patrícia','REPUBLICANOS','patricia.almeida@camara.gov.br','11988888888','Enfermeira com especialização em saúde pública. Patrícia Almeida atua na defesa da saúde municipal, com foco na atenção básica e na saúde da mulher e da criança.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-saude\\\",\\\"comissao-assistencia-social\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadorapatricia\\\",\\\"instagram\\\":\\\"@patricia_saude\\\",\\\"youtube\\\":\\\"Vereadora Patr\\\\u00edcia Almeida\\\"}\"','PL 006/2021 - Ampliação das UBS; PL 019/2022 - Programa Saúde da Mulher; PL 032/2023 - Centro de Especialidades Médicas','2025-09-26 07:51:57','2025-09-26 07:51:57'),
('9','Marcos Vinícius Silva','Vereador Marcos Vinícius','UNIÃO','marcos.silva@camara.gov.br','11999999999','Jovem empreendedor e especialista em tecnologia. Marcos Vinícius Silva trabalha pela modernização da gestão pública e pelo desenvolvimento da economia digital no município.',NULL,NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','\"[\\\"comissao-tecnologia\\\",\\\"comissao-desenvolvimento-economico\\\"]\"','0','0','\"{\\\"facebook\\\":\\\"https:\\\\\\/\\\\\\/facebook.com\\\\\\/vereadormarcosvinicius\\\",\\\"instagram\\\":\\\"@marcosvinicius_tech\\\",\\\"twitter\\\":\\\"@marcosvinicius_vr\\\",\\\"linkedin\\\":\\\"marcos-vinicius-silva-vereador\\\",\\\"tiktok\\\":\\\"@vereadormarcos\\\"}\"','PL 004/2021 - Cidade Inteligente Digital; PL 017/2022 - Hub de Inovação Municipal; PL 034/2023 - Programa de Inclusão Digital para Idosos','2025-09-26 07:51:57','2025-09-26 07:51:57');

SET FOREIGN_KEY_CHECKS=1;
