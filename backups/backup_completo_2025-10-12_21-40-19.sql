-- Backup (fallback) gerado via PHP/PDO em 2025-10-12 21:40:19
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

--
-- Tabela: `acesso_rapido`
--
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

INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('1','Vereadores','Conheça os vereadores e suas propostas','/vereadores','fas fa-users','#2563eb','#ffffff','1','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('2','Projetos de Lei','Acompanhe os projetos em tramitação','/projetos-lei','fas fa-gavel','#059669','#ffffff','2','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('3','Sessões','Calendário e atas das sessões plenárias','/sessoes','fas fa-calendar-alt','#dc2626','#ffffff','3','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('4','Transparência','Portal da transparência e acesso à informação','/transparencia','fas fa-eye','#7c3aed','#ffffff','4','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('5','E-SIC','Sistema Eletrônico do Serviço de Informação ao Cidadão','/esic','fas fa-info-circle','#ea580c','#ffffff','5','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('6','Ouvidoria','Canal de comunicação com o cidadão','/ouvidoria','fas fa-comments','#0891b2','#ffffff','6','1','0','2025-09-26 08:24:31','2025-09-26 08:24:31');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('7','Legislação','Consulte leis municipais e regimento interno','/leis','fas fa-book-open','#8b5cf6','#ffffff','7','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('8','Notícias','Últimas notícias e comunicados oficiais','/noticias','fas fa-newspaper','#f59e0b','#ffffff','8','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('9','Documentos','Acesse documentos e publicações oficiais','/documentos','fas fa-file-alt','#10b981','#ffffff','9','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('10','Agenda','Calendário de eventos e atividades','/agenda','fas fa-calendar-check','#ef4444','#ffffff','10','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('11','Comissões','Informações sobre comissões permanentes','/comissoes','fas fa-users-cog','#6366f1','#ffffff','11','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');
INSERT INTO `acesso_rapido` (`id`,`nome`,`descricao`,`url`,`icone`,`cor_botao`,`cor_fonte`,`ordem`,`ativo`,`abrir_nova_aba`,`created_at`,`updated_at`) VALUES ('12','Contato','Entre em contato com a Câmara Municipal','/contato','fas fa-phone','#06b6d4','#ffffff','12','1','0','2025-09-28 00:52:57','2025-09-28 00:52:57');

--
-- Tabela: `assinatura_eletronicas`
--
DROP TABLE IF EXISTS `assinatura_eletronicas`;
CREATE TABLE `assinatura_eletronicas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comite_iniciativa_popular_id` bigint(20) unsigned NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `titulo_eleitor` varchar(12) NOT NULL,
  `zona_eleitoral` varchar(255) DEFAULT NULL,
  `secao_eleitoral` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `data_assinatura` timestamp NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` text NOT NULL,
  `hash_assinatura` varchar(255) NOT NULL,
  `status` enum('pendente','validada','rejeitada') NOT NULL DEFAULT 'pendente',
  `motivo_rejeicao` text DEFAULT NULL,
  `data_validacao` timestamp NULL DEFAULT NULL,
  `validado_por` bigint(20) unsigned DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assinatura_eletronicas_cpf_unique` (`cpf`),
  UNIQUE KEY `assinatura_eletronicas_hash_assinatura_unique` (`hash_assinatura`),
  KEY `assinatura_eletronicas_validado_por_foreign` (`validado_por`),
  KEY `assinatura_eletronicas_comite_iniciativa_popular_id_status_index` (`comite_iniciativa_popular_id`,`status`),
  KEY `assinatura_eletronicas_cpf_comite_iniciativa_popular_id_index` (`cpf`,`comite_iniciativa_popular_id`),
  KEY `assinatura_eletronicas_data_assinatura_index` (`data_assinatura`),
  CONSTRAINT `assinatura_eletronicas_comite_iniciativa_popular_id_foreign` FOREIGN KEY (`comite_iniciativa_popular_id`) REFERENCES `comite_iniciativa_populars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assinatura_eletronicas_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Tabela: `cache`
--
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Tabela: `cache_locks`
--
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Tabela: `carta_servico_avaliacoes`
--
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


--
-- Tabela: `carta_servico_categorias`
--
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


--
-- Tabela: `carta_servicos`
--
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


--
-- Tabela: `comite_iniciativa_populars`
--
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
  `ementa` text DEFAULT NULL,
  `texto_projeto_html` longtext DEFAULT NULL,
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comite_iniciativa_populars` (`id`,`nome`,`cpf`,`email`,`telefone`,`endereco`,`numero_assinaturas`,`minimo_assinaturas`,`data_inicio_coleta`,`data_fim_coleta`,`status`,`observacoes`,`ementa`,`texto_projeto_html`,`documentos`,`created_at`,`updated_at`) VALUES ('1','Comitê Pró-Ciclovias',NULL,'contato@priciclovias.org','(11) 99999-9999',NULL,'1250','1000',NULL,NULL,'ativo',NULL,NULL,NULL,NULL,'2025-09-27 23:27:13','2025-09-27 23:27:13');
INSERT INTO `comite_iniciativa_populars` (`id`,`nome`,`cpf`,`email`,`telefone`,`endereco`,`numero_assinaturas`,`minimo_assinaturas`,`data_inicio_coleta`,`data_fim_coleta`,`status`,`observacoes`,`ementa`,`texto_projeto_html`,`documentos`,`created_at`,`updated_at`) VALUES ('2','Movimento Parques Urbanos',NULL,'contato@parquesurbanos.org','(11) 88888-8888',NULL,'2100','1500',NULL,NULL,'ativo',NULL,NULL,NULL,NULL,'2025-09-27 23:28:22','2025-09-27 23:28:22');
INSERT INTO `comite_iniciativa_populars` (`id`,`nome`,`cpf`,`email`,`telefone`,`endereco`,`numero_assinaturas`,`minimo_assinaturas`,`data_inicio_coleta`,`data_fim_coleta`,`status`,`observacoes`,`ementa`,`texto_projeto_html`,`documentos`,`created_at`,`updated_at`) VALUES ('3','Comitê Teste Automatizado',NULL,'teste@comite.com.br','(11) 99999-9999','Rua Teste, 123 - Centro','0','1000',NULL,NULL,'ativo','Comitê criado para teste automatizado',NULL,NULL,NULL,'2025-09-27 23:49:21','2025-09-27 23:49:21');
INSERT INTO `comite_iniciativa_populars` (`id`,`nome`,`cpf`,`email`,`telefone`,`endereco`,`numero_assinaturas`,`minimo_assinaturas`,`data_inicio_coleta`,`data_fim_coleta`,`status`,`observacoes`,`ementa`,`texto_projeto_html`,`documentos`,`created_at`,`updated_at`) VALUES ('4','Comitê Teste Automatizado','12345678901','teste@comite.com','(11) 99999-9999','Rua Teste, 123','500','1000','2024-01-01','2024-12-31','ativo','Comitê atualizado no teste',NULL,NULL,'\"{\\\"ata\\\":\\\"ata_teste.pdf\\\"}\"','2025-09-27 23:53:14','2025-09-27 23:53:14');

--
-- Tabela: `configuracao_gerais`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('1','brasao_camara','configuracoes/1759667111_Brasão.png','imagem','Brasão da Câmara Municipal exibido no header','1','2025-09-26 07:56:26','2025-10-11 07:59:21');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('2','logo_footer','configuracoes/1759666938_Camara_Exemplolândia_1.png','imagem','Logo da Câmara Municipal exibida no footer','1','2025-09-26 07:56:26','2025-10-11 08:09:10');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('3','endereco_camara','Rua Principal, 123 - Centro - Cidade/UF - CEP: 12345-678','texto','Endereço completo da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('4','telefone_camara','(11) 1234-5678','telefone','Telefone principal da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('5','email_camara','contato@camara.gov.br','email','E-mail principal da Câmara Municipal','1','2025-09-26 07:56:26','2025-09-26 07:56:26');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('6','direitos_autorais','© 2025 Câmara Municipal. Todos os direitos reservados.','texto','Texto de direitos autorais exibido no footer','1','2025-09-26 07:56:26','2025-09-26 07:56:26');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('7','nome_camara','Câmara Municipal de Exemplolândia','texto','Nome oficial da Câmara Municipal','1','2025-09-26 07:56:26','2025-10-05 07:19:05');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('8','nome_municipio','Município Exemplo','texto','Nome oficial do município','1','2025-09-28 16:32:13','2025-09-28 16:32:13');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('9','quantidade_habitantes','50000','numero','Quantidade total de habitantes do município','1','2025-09-28 16:32:13','2025-09-28 16:32:13');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('10','quantidade_eleitores','35000','numero','Quantidade total de eleitores do município','1','2025-09-28 16:32:13','2025-09-28 16:32:13');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('11','percentual_assinaturas','5.0','numero','Percentual de eleitores necessário para iniciativa popular (%)','1','2025-09-28 16:32:13','2025-09-28 16:32:13');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('12','nome_do_estado','Estado de Mato Grosso','texto','Nome oficial do estado','1','2025-10-10 14:24:25','2025-10-10 14:24:25');
INSERT INTO `configuracao_gerais` (`id`,`chave`,`valor`,`tipo`,`descricao`,`ativo`,`created_at`,`updated_at`) VALUES ('13','brasao_header','configuracoes/1759667111_Brasão.png','imagem','Brasão da Câmara Municipal para o cabeçalho','1','2025-10-10 17:09:46','2025-10-11 07:59:45');

--
-- Tabela: `contrato_aditivos`
--
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


--
-- Tabela: `contrato_fiscalizacaos`
--
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


--
-- Tabela: `contratos`
--
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


--
-- Tabela: `despesas`
--
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


--
-- Tabela: `documentos`
--
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


--
-- Tabela: `esic_movimentacoes`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `esic_movimentacoes` (`id`,`esic_solicitacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('1','4','2','aberta','Solicitação registrada no sistema',NULL,'2025-09-30 07:59:26','127.0.0.1','2025-09-30 07:59:26','2025-09-30 07:59:26');
INSERT INTO `esic_movimentacoes` (`id`,`esic_solicitacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('2','5','12','aberta','Solicitação registrada no sistema',NULL,'2025-09-30 08:15:49','201.71.169.153','2025-09-30 08:15:49','2025-09-30 08:15:49');

--
-- Tabela: `esic_solicitacoes`
--
DROP TABLE IF EXISTS `esic_solicitacoes`;
CREATE TABLE `esic_solicitacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data_solicitacao` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `protocolo` varchar(255) NOT NULL,
  `nome_solicitante` varchar(255) NOT NULL,
  `email_solicitante` varchar(255) NOT NULL,
  `telefone_solicitante` varchar(255) DEFAULT NULL,
  `cpf_solicitante` varchar(255) DEFAULT NULL,
  `tipo_pessoa` enum('fisica','juridica') NOT NULL DEFAULT 'fisica',
  `cnpj_solicitante` varchar(255) DEFAULT NULL,
  `endereco_solicitante` text DEFAULT NULL,
  `categoria` varchar(50) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `esic_solicitacoes` (`id`,`data_solicitacao`,`user_id`,`protocolo`,`nome_solicitante`,`email_solicitante`,`telefone_solicitante`,`cpf_solicitante`,`tipo_pessoa`,`cnpj_solicitante`,`endereco_solicitante`,`categoria`,`assunto`,`descricao`,`forma_recebimento`,`endereco_resposta`,`status`,`arquivada`,`arquivada_em`,`data_limite_resposta`,`resposta`,`data_resposta`,`anexos_solicitacao`,`anexos_resposta`,`responsavel_id`,`justificativa_negativa`,`recurso_solicitado`,`recurso_justificativa`,`recurso_resposta`,`tramitacao`,`observacoes_internas`,`prazo_prorrogacao_dias`,`justificativa_prorrogacao`,`created_at`,`updated_at`,`deleted_at`) VALUES ('1','2025-09-30 07:44:17','2','TESTE1759232657','João Silva Santos','secretario@camara.gov.br',NULL,NULL,'fisica',NULL,NULL,'informacao','Teste de solicitação','Esta é uma solicitação de teste.','email',NULL,'pendente','0',NULL,'2025-10-20',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,'0',NULL,'2025-09-30 07:44:17','2025-09-30 07:44:17',NULL);
INSERT INTO `esic_solicitacoes` (`id`,`data_solicitacao`,`user_id`,`protocolo`,`nome_solicitante`,`email_solicitante`,`telefone_solicitante`,`cpf_solicitante`,`tipo_pessoa`,`cnpj_solicitante`,`endereco_solicitante`,`categoria`,`assunto`,`descricao`,`forma_recebimento`,`endereco_resposta`,`status`,`arquivada`,`arquivada_em`,`data_limite_resposta`,`resposta`,`data_resposta`,`anexos_solicitacao`,`anexos_resposta`,`responsavel_id`,`justificativa_negativa`,`recurso_solicitado`,`recurso_justificativa`,`recurso_resposta`,`tramitacao`,`observacoes_internas`,`prazo_prorrogacao_dias`,`justificativa_prorrogacao`,`created_at`,`updated_at`,`deleted_at`) VALUES ('2','2025-09-30 07:52:56','2','ESIC2025000002','João Silva Santos','secretario@camara.gov.br','11999999999','','fisica',NULL,'Rua Teste, 123','transparencia','Teste Controller Direto','Esta é uma descrição de teste para o controller.','email',NULL,'pendente','0',NULL,'2025-10-20',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,'0',NULL,'2025-09-30 07:52:56','2025-09-30 07:52:56',NULL);
INSERT INTO `esic_solicitacoes` (`id`,`data_solicitacao`,`user_id`,`protocolo`,`nome_solicitante`,`email_solicitante`,`telefone_solicitante`,`cpf_solicitante`,`tipo_pessoa`,`cnpj_solicitante`,`endereco_solicitante`,`categoria`,`assunto`,`descricao`,`forma_recebimento`,`endereco_resposta`,`status`,`arquivada`,`arquivada_em`,`data_limite_resposta`,`resposta`,`data_resposta`,`anexos_solicitacao`,`anexos_resposta`,`responsavel_id`,`justificativa_negativa`,`recurso_solicitado`,`recurso_justificativa`,`recurso_resposta`,`tramitacao`,`observacoes_internas`,`prazo_prorrogacao_dias`,`justificativa_prorrogacao`,`created_at`,`updated_at`,`deleted_at`) VALUES ('3','2025-09-30 07:53:27','2','ESIC2025000003','João Silva Santos','secretario@camara.gov.br','11999999999','','fisica',NULL,'Rua Teste, 123','transparencia','Teste Controller Direto','Esta é uma descrição de teste para o controller.','email',NULL,'pendente','0',NULL,'2025-10-20',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,'0',NULL,'2025-09-30 07:53:27','2025-09-30 07:53:27',NULL);
INSERT INTO `esic_solicitacoes` (`id`,`data_solicitacao`,`user_id`,`protocolo`,`nome_solicitante`,`email_solicitante`,`telefone_solicitante`,`cpf_solicitante`,`tipo_pessoa`,`cnpj_solicitante`,`endereco_solicitante`,`categoria`,`assunto`,`descricao`,`forma_recebimento`,`endereco_resposta`,`status`,`arquivada`,`arquivada_em`,`data_limite_resposta`,`resposta`,`data_resposta`,`anexos_solicitacao`,`anexos_resposta`,`responsavel_id`,`justificativa_negativa`,`recurso_solicitado`,`recurso_justificativa`,`recurso_resposta`,`tramitacao`,`observacoes_internas`,`prazo_prorrogacao_dias`,`justificativa_prorrogacao`,`created_at`,`updated_at`,`deleted_at`) VALUES ('4','2025-09-30 07:59:26','2','ESIC2025000004','João Silva Santos','secretario@camara.gov.br','11999999999','','fisica',NULL,'Rua Teste, 123','transparencia','Teste Controller Direto','Esta é uma descrição de teste para o controller.','email',NULL,'pendente','0',NULL,'2025-10-20',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,'0',NULL,'2025-09-30 07:59:26','2025-09-30 07:59:26',NULL);
INSERT INTO `esic_solicitacoes` (`id`,`data_solicitacao`,`user_id`,`protocolo`,`nome_solicitante`,`email_solicitante`,`telefone_solicitante`,`cpf_solicitante`,`tipo_pessoa`,`cnpj_solicitante`,`endereco_solicitante`,`categoria`,`assunto`,`descricao`,`forma_recebimento`,`endereco_resposta`,`status`,`arquivada`,`arquivada_em`,`data_limite_resposta`,`resposta`,`data_resposta`,`anexos_solicitacao`,`anexos_resposta`,`responsavel_id`,`justificativa_negativa`,`recurso_solicitado`,`recurso_justificativa`,`recurso_resposta`,`tramitacao`,`observacoes_internas`,`prazo_prorrogacao_dias`,`justificativa_prorrogacao`,`created_at`,`updated_at`,`deleted_at`) VALUES ('5','2025-09-30 08:15:49','12','ESIC2025000005','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','98765432100','fisica',NULL,NULL,'contratos','Imagem Vetorial sob Encomenda','Imagem Vetorial sob Encomenda','email',NULL,'pendente','0',NULL,'2025-10-20',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,'0',NULL,'2025-09-30 08:15:49','2025-09-30 08:15:49',NULL);

--
-- Tabela: `esic_usuarios`
--
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


--
-- Tabela: `eventos`
--
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

INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('1','Sessão Ordinária - Discussão do Orçamento 2025','Discussão e votação do projeto de lei orçamentária anual para o exercício de 2025.','sessao_plenaria','2025-09-30','14:00:00','18:00:00','Plenário da Câmara Municipal',NULL,'1','#dc3545','1',NULL,'1',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('2','Sessão Extraordinária - Aprovação de Convênios','Sessão extraordinária para aprovação de convênios com o Estado e União.','sessao_plenaria','2025-10-04','09:00:00','12:00:00','Plenário da Câmara Municipal',NULL,'0','#007bff','1',NULL,'2',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('3','Audiência Pública - Plano Diretor Municipal','Audiência pública para discussão das alterações propostas no Plano Diretor Municipal.','audiencia_publica','2025-10-07','19:00:00','21:00:00','Auditório da Câmara Municipal',NULL,'1','#fd7e14','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('4','Audiência Pública - Saúde Municipal','Prestação de contas e discussão sobre os investimentos em saúde pública municipal.','audiencia_publica','2025-10-12','14:30:00','17:00:00','Auditório da Câmara Municipal',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('5','Reunião da Comissão de Finanças','Análise dos projetos de lei relacionados ao orçamento e finanças municipais.','reuniao_comissao','2025-09-29','08:30:00','11:00:00','Sala da Comissão de Finanças',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('6','Reunião da Comissão de Obras e Serviços Públicos','Discussão sobre projetos de infraestrutura e melhorias urbanas.','reuniao_comissao','2025-10-02','14:00:00','16:30:00','Sala da Comissão de Obras',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('7','Atendimento ao Público - Vereador João Silva','Atendimento aos cidadãos para recebimento de demandas e sugestões.','agenda_vereador','2025-09-28','08:00:00','12:00:00','Gabinete do Vereador',NULL,'0','#007bff','1','1',NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('8','Visita Técnica - Escola Municipal','Visita técnica à Escola Municipal para verificação das condições de infraestrutura.','agenda_vereador','2025-10-01','09:00:00','11:00:00','Escola Municipal Centro',NULL,'0','#007bff','1','2',NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('9','Licitação - Aquisição de Equipamentos de Informática','Abertura de licitação para aquisição de equipamentos de informática para a Câmara.','licitacao','2025-10-09','10:00:00','12:00:00','Sala de Licitações',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('10','Dia do Servidor Público Municipal','Homenagem aos servidores públicos municipais pelos serviços prestados à comunidade.','data_comemorativa','2025-10-17','10:00:00','12:00:00','Plenário da Câmara Municipal',NULL,'1','#ffc107','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('11','Semana do Meio Ambiente','Abertura da Semana do Meio Ambiente com palestras e atividades educativas.','data_comemorativa','2025-10-22','14:00:00','17:00:00','Praça Central',NULL,'0','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('12','Votação - Projeto de Lei Complementar nº 001/2024','Votação em segundo turno do Projeto de Lei Complementar sobre o Código Tributário Municipal.','votacao','2025-10-05','15:00:00','17:00:00','Plenário da Câmara Municipal',NULL,'1','#e83e8c','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('13','Sessão Solene - Posse dos Vereadores','Sessão solene de posse dos vereadores eleitos para a legislatura 2021-2024.','sessao_plenaria','2025-08-28','14:00:00','18:00:00','Plenário da Câmara Municipal',NULL,'0','#007bff','1',NULL,'3',NULL,NULL,NULL,'2025-09-27 00:28:01','2025-09-27 00:28:01');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('14','Confraternização Universal','Feriado nacional - Ano Novo','data_comemorativa','2025-01-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:43','2025-09-27 00:38:43');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('15','Aniversário de São Paulo','Fundação da cidade de São Paulo','data_comemorativa','2025-01-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('16','Dia de Iemanjá','Festa popular em homenagem à Rainha do Mar','data_comemorativa','2025-02-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('17','Dia Internacional da Mulher','Celebração dos direitos da mulher','data_comemorativa','2025-03-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('18','Dia da Escola','Valorização da educação','data_comemorativa','2025-03-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('19','Dia Mundial da Água','Conscientização sobre a preservação da água','data_comemorativa','2025-03-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('20','Dia Mundial da Saúde','Promoção da saúde pública','data_comemorativa','2025-04-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('21','Dia Nacional do Livro Infantil','Incentivo à leitura infantil','data_comemorativa','2025-04-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('22','Dia do Índio','Valorização da cultura indígena','data_comemorativa','2025-04-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('23','Tiradentes','Feriado nacional - Inconfidência Mineira','data_comemorativa','2025-04-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('24','Descobrimento do Brasil','Chegada dos portugueses ao Brasil','data_comemorativa','2025-04-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('25','Dia Mundial do Livro','Promoção da leitura e literatura','data_comemorativa','2025-04-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('26','Dia do Trabalhador','Feriado nacional - Dia do Trabalho','data_comemorativa','2025-05-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('27','Dia das Mães','Homenagem às mães (segundo domingo de maio)','data_comemorativa','2025-05-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('28','Abolição da Escravatura','Assinatura da Lei Áurea','data_comemorativa','2025-05-13',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('29','Dia Nacional de Combate ao Abuso Sexual','Proteção de crianças e adolescentes','data_comemorativa','2025-05-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('30','Dia Mundial sem Tabaco','Conscientização sobre os malefícios do tabaco','data_comemorativa','2025-05-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('31','Dia Mundial do Meio Ambiente','Conscientização ambiental','data_comemorativa','2025-06-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('32','Dia dos Namorados','Celebração do amor','data_comemorativa','2025-06-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('33','Festa Junina - São João','Tradição cultural brasileira','data_comemorativa','2025-06-24',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('34','Revolução Constitucionalista','Feriado estadual em São Paulo','data_comemorativa','2025-07-09',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('35','Dia do Amigo','Celebração da amizade','data_comemorativa','2025-07-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('36','Dia do Estudante','Valorização da educação','data_comemorativa','2025-08-11',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('37','Dia do Folclore','Preservação da cultura popular','data_comemorativa','2025-08-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('38','Dia Nacional de Combate ao Fumo','Prevenção ao tabagismo','data_comemorativa','2025-08-29',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('39','Independência do Brasil','Feriado nacional - Grito do Ipiranga','data_comemorativa','2025-09-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('40','Dia da Árvore','Conscientização ambiental','data_comemorativa','2025-09-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('41','Início da Primavera','Equinócio de primavera','data_comemorativa','2025-09-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('42','Dia Nacional de Combate ao Câncer Infantil','Conscientização sobre o câncer infantil','data_comemorativa','2025-09-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('43','Dia Mundial dos Animais','Proteção animal','data_comemorativa','2025-10-04',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('44','Dia Mundial dos Professores','Valorização do magistério','data_comemorativa','2025-10-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('45','Nossa Senhora Aparecida','Feriado nacional - Padroeira do Brasil','data_comemorativa','2025-10-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('46','Dia do Professor','Homenagem aos educadores','data_comemorativa','2025-10-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('47','Dia Mundial da Alimentação','Combate à fome','data_comemorativa','2025-10-16',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('48','Dia da Indústria','Desenvolvimento industrial','data_comemorativa','2025-10-17',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('49','Dia das Bruxas (Halloween)','Tradição internacional','data_comemorativa','2025-10-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('50','Finados','Feriado nacional - Dia dos Mortos','data_comemorativa','2025-11-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('51','Proclamação da República','Feriado nacional - Fim do Império','data_comemorativa','2025-11-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('52','Dia da Bandeira','Símbolo nacional','data_comemorativa','2025-11-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('53','Dia da Consciência Negra','Valorização da cultura afro-brasileira','data_comemorativa','2025-11-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('54','Dia Mundial de Combate à AIDS','Prevenção e conscientização','data_comemorativa','2025-12-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('55','Dia Internacional da Pessoa com Deficiência','Inclusão social','data_comemorativa','2025-12-03',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('56','Dia dos Direitos Humanos','Declaração Universal dos Direitos Humanos','data_comemorativa','2025-12-10',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('57','Natal','Feriado nacional - Nascimento de Jesus Cristo','data_comemorativa','2025-12-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('58','Réveillon','Passagem de ano','data_comemorativa','2025-12-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('59','Aniversário do Município','Fundação da cidade - Ajustar data conforme município','data_comemorativa','2025-01-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('60','Dia do Servidor Municipal','Homenagem aos servidores públicos municipais','data_comemorativa','2025-03-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('61','Dia do Município','Celebração da emancipação política','data_comemorativa','2025-04-23',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('62','Festa do Padroeiro','Celebração religiosa local - Ajustar conforme padroeiro','data_comemorativa','2025-06-29',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:44','2025-09-27 00:38:44');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('63','Semana da Pátria Municipal','Atividades cívicas locais','data_comemorativa','2025-08-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('64','Semana da Criança','Atividades para o público infantil','data_comemorativa','2025-10-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('65','Dia da Música Municipal','Valorização da cultura musical local','data_comemorativa','2025-11-22',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('66','Confraternização Universal','Feriado nacional - Ano Novo','data_comemorativa','2026-01-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('67','Aniversário de São Paulo','Fundação da cidade de São Paulo','data_comemorativa','2026-01-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('68','Dia de Iemanjá','Festa popular em homenagem à Rainha do Mar','data_comemorativa','2026-02-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('69','Dia Internacional da Mulher','Celebração dos direitos da mulher','data_comemorativa','2026-03-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('70','Dia da Escola','Valorização da educação','data_comemorativa','2026-03-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('71','Dia Mundial da Água','Conscientização sobre a preservação da água','data_comemorativa','2026-03-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('72','Dia Mundial da Saúde','Promoção da saúde pública','data_comemorativa','2026-04-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('73','Dia Nacional do Livro Infantil','Incentivo à leitura infantil','data_comemorativa','2026-04-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('74','Dia do Índio','Valorização da cultura indígena','data_comemorativa','2026-04-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('75','Tiradentes','Feriado nacional - Inconfidência Mineira','data_comemorativa','2026-04-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('76','Descobrimento do Brasil','Chegada dos portugueses ao Brasil','data_comemorativa','2026-04-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('77','Dia Mundial do Livro','Promoção da leitura e literatura','data_comemorativa','2026-04-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('78','Dia do Trabalhador','Feriado nacional - Dia do Trabalho','data_comemorativa','2026-05-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('79','Dia das Mães','Homenagem às mães (segundo domingo de maio)','data_comemorativa','2026-05-08',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('80','Abolição da Escravatura','Assinatura da Lei Áurea','data_comemorativa','2026-05-13',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('81','Dia Nacional de Combate ao Abuso Sexual','Proteção de crianças e adolescentes','data_comemorativa','2026-05-18',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('82','Dia Mundial sem Tabaco','Conscientização sobre os malefícios do tabaco','data_comemorativa','2026-05-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('83','Dia Mundial do Meio Ambiente','Conscientização ambiental','data_comemorativa','2026-06-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('84','Dia dos Namorados','Celebração do amor','data_comemorativa','2026-06-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('85','Festa Junina - São João','Tradição cultural brasileira','data_comemorativa','2026-06-24',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('86','Revolução Constitucionalista','Feriado estadual em São Paulo','data_comemorativa','2026-07-09',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('87','Dia do Amigo','Celebração da amizade','data_comemorativa','2026-07-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('88','Dia do Estudante','Valorização da educação','data_comemorativa','2026-08-11',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('89','Dia do Folclore','Preservação da cultura popular','data_comemorativa','2026-08-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('90','Dia Nacional de Combate ao Fumo','Prevenção ao tabagismo','data_comemorativa','2026-08-29',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('91','Independência do Brasil','Feriado nacional - Grito do Ipiranga','data_comemorativa','2026-09-07',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('92','Dia da Árvore','Conscientização ambiental','data_comemorativa','2026-09-21',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('93','Início da Primavera','Equinócio de primavera','data_comemorativa','2026-09-22',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('94','Dia Nacional de Combate ao Câncer Infantil','Conscientização sobre o câncer infantil','data_comemorativa','2026-09-23',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('95','Dia Mundial dos Animais','Proteção animal','data_comemorativa','2026-10-04',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('96','Dia Mundial dos Professores','Valorização do magistério','data_comemorativa','2026-10-05',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('97','Nossa Senhora Aparecida','Feriado nacional - Padroeira do Brasil','data_comemorativa','2026-10-12',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('98','Dia do Professor','Homenagem aos educadores','data_comemorativa','2026-10-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('99','Dia Mundial da Alimentação','Combate à fome','data_comemorativa','2026-10-16',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('100','Dia da Indústria','Desenvolvimento industrial','data_comemorativa','2026-10-17',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('101','Dia das Bruxas (Halloween)','Tradição internacional','data_comemorativa','2026-10-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('102','Finados','Feriado nacional - Dia dos Mortos','data_comemorativa','2026-11-02',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('103','Proclamação da República','Feriado nacional - Fim do Império','data_comemorativa','2026-11-15',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('104','Dia da Bandeira','Símbolo nacional','data_comemorativa','2026-11-19',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('105','Dia da Consciência Negra','Valorização da cultura afro-brasileira','data_comemorativa','2026-11-20',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('106','Dia Mundial de Combate à AIDS','Prevenção e conscientização','data_comemorativa','2026-12-01',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('107','Dia Internacional da Pessoa com Deficiência','Inclusão social','data_comemorativa','2026-12-03',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('108','Dia dos Direitos Humanos','Declaração Universal dos Direitos Humanos','data_comemorativa','2026-12-10',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('109','Natal','Feriado nacional - Nascimento de Jesus Cristo','data_comemorativa','2026-12-25',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','1','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('110','Réveillon','Passagem de ano','data_comemorativa','2026-12-31',NULL,NULL,'Nacional','Data comemorativa nacional inserida automaticamente','0','#28a745','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:45','2025-09-27 00:38:45');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('111','Aniversário do Município','Fundação da cidade - Ajustar data conforme município','data_comemorativa','2026-01-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('112','Dia do Servidor Municipal','Homenagem aos servidores públicos municipais','data_comemorativa','2026-03-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('113','Dia do Município','Celebração da emancipação política','data_comemorativa','2026-04-23',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('114','Festa do Padroeiro','Celebração religiosa local - Ajustar conforme padroeiro','data_comemorativa','2026-06-29',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('115','Semana da Pátria Municipal','Atividades cívicas locais','data_comemorativa','2026-08-15',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('116','Semana da Criança','Atividades para o público infantil','data_comemorativa','2026-10-01',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');
INSERT INTO `eventos` (`id`,`titulo`,`descricao`,`tipo`,`data_evento`,`hora_inicio`,`hora_fim`,`local`,`observacoes`,`destaque`,`cor_destaque`,`ativo`,`vereador_id`,`sessao_id`,`licitacao_id`,`esic_solicitacao_id`,`user_id`,`created_at`,`updated_at`) VALUES ('117','Dia da Música Municipal','Valorização da cultura musical local','data_comemorativa','2026-11-22',NULL,NULL,'Municipal','Data comemorativa municipal - Ajustar conforme necessário','1','#007bff','1',NULL,NULL,NULL,NULL,NULL,'2025-09-27 00:38:46','2025-09-27 00:38:46');

--
-- Tabela: `failed_jobs`
--
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


--
-- Tabela: `folha_pagamento`
--
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


--
-- Tabela: `hero_configurations`
--
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
  `imagem_topo_id` bigint(20) unsigned DEFAULT NULL,
  `imagem_topo_altura_px` int(10) unsigned DEFAULT NULL,
  `centralizar_imagem_topo` tinyint(1) NOT NULL DEFAULT 1,
  `imagem_descricao_id` bigint(20) unsigned DEFAULT NULL,
  `imagem_descricao_altura_px` int(10) unsigned DEFAULT NULL,
  `imagem_descricao_largura_px` int(10) unsigned DEFAULT NULL,
  `centralizar_imagem_descricao` tinyint(1) NOT NULL DEFAULT 0,
  `intervalo` int(11) NOT NULL DEFAULT 5000,
  `transicao` varchar(255) NOT NULL DEFAULT 'slide',
  `autoplay` tinyint(1) NOT NULL DEFAULT 1,
  `pausar_hover` tinyint(1) NOT NULL DEFAULT 1,
  `mostrar_indicadores` tinyint(1) NOT NULL DEFAULT 1,
  `mostrar_controles` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `hero_configurations_imagem_topo_id_foreign` (`imagem_topo_id`),
  KEY `hero_configurations_imagem_descricao_id_foreign` (`imagem_descricao_id`),
  CONSTRAINT `hero_configurations_imagem_descricao_id_foreign` FOREIGN KEY (`imagem_descricao_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hero_configurations_imagem_topo_id_foreign` FOREIGN KEY (`imagem_topo_id`) REFERENCES `media` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hero_configurations` (`id`,`titulo`,`descricao`,`botao_primario_texto`,`botao_primario_link`,`botao_primario_nova_aba`,`botao_secundario_texto`,`botao_secundario_link`,`botao_secundario_nova_aba`,`mostrar_slider`,`ativo`,`created_at`,`updated_at`,`imagem_topo_id`,`imagem_topo_altura_px`,`centralizar_imagem_topo`,`imagem_descricao_id`,`imagem_descricao_altura_px`,`imagem_descricao_largura_px`,`centralizar_imagem_descricao`,`intervalo`,`transicao`,`autoplay`,`pausar_hover`,`mostrar_indicadores`,`mostrar_controles`) VALUES ('1','','Transparência, participação e representação democrática para nossa cidade. Transparência, participação e representação democrática para nossa cidade. Transparência, participação e representação democrática para nossa cidade. Transparência, participação e representação democrática para nossa cidade, participação e representação democrática.','Transparência','/transparencia','0','Vereadores','/vereadores','0','1','1','2025-10-12 15:19:27','2025-10-12 17:15:05','30','130','1','61','70',NULL,'0','5000','slide','1','1','1','1');

--
-- Tabela: `job_batches`
--
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


--
-- Tabela: `jobs`
--
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


--
-- Tabela: `leis`
--
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

INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('1','1485','2025','2025-09-16','Lei Ordinária','Lei Municipal nº 1.485 de 16 de setembro de 2025','Esta lei estabelece diretrizes importantes para o desenvolvimento municipal, abordando aspectos fundamentais da administração pública local e promovendo melhorias na qualidade dos serviços prestados à população.','Câmara Municipal','Dispõe sobre normas gerais para o município e dá outras providências.',NULL,'1','Lei de grande relevância para o município.','lei-municipal-1485-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('2','1486','2025','2025-09-20','Lei Ordinária','Dispõe sobre a criação do Programa Municipal de Meio Ambiente','Esta lei cria o Programa Municipal de Meio Ambiente com o objetivo de promover a sustentabilidade, a educação ambiental e a preservação dos recursos naturais do município. O programa incluirá ações de reflorestamento, coleta seletiva e conscientização da população sobre a importância da preservação ambiental.','Vereador João Silva','Institui o Programa Municipal de Meio Ambiente e estabelece diretrizes para a preservação ambiental no município.',NULL,'1','Aprovada por unanimidade.','programa-municipal-meio-ambiente-1486-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('3','1487','2025','2025-09-25','Lei Ordinária','Altera a Lei Municipal de Trânsito e Transporte','<p class=\"artigo\"><strong>Art. 1&ordm; </strong>Esta lei promove altera&ccedil;&otilde;es na legisla&ccedil;&atilde;o municipal de tr&acirc;nsito, estabelecendo novas regras para o transporte p&uacute;blico, criando ciclovias e melhorando a <span style=\"color: rgb(255, 0, 0);\"><strong>sinaliza&ccedil;&atilde;o urbana</strong></span>.</p>\r\n<p class=\"paragrafo\"><strong>&sect; 1&ordm; </strong>As mudan&ccedil;as visam reduzir o <span style=\"background-color: rgb(0, 255, 0);\">tr&acirc;nsito e promover meios</span> de transporte mais sustent&aacute;veis.</p>','Vereadora Maria Santos','Altera dispositivos da Lei Municipal de Trânsito e Transporte para melhorar a mobilidade urbana.',NULL,'1','Entrada em vigor em 60 dias.','alteracao-lei-transito-1487-2025','2025-09-26 07:33:43','2025-09-26 07:37:05');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('4','45','2025','2025-08-10','Lei Complementar','Código Tributário Municipal','Esta lei complementar estabelece o sistema tributário municipal, definindo os tributos de competência do município, suas bases de cálculo, alíquotas e procedimentos de arrecadação. Inclui disposições sobre IPTU, ISS, taxas municipais e contribuições de melhoria.','Poder Executivo','Institui o Código Tributário Municipal e estabelece normas gerais de direito tributário aplicáveis ao município.',NULL,'1','Substitui a legislação tributária anterior.','codigo-tributario-municipal-45-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('5','46','2025','2025-08-15','Lei Complementar','Plano Diretor Municipal','O Plano Diretor Municipal é o instrumento básico da política de desenvolvimento e expansão urbana. Esta lei estabelece as diretrizes para o crescimento ordenado da cidade, definindo zonas de uso, parâmetros urbanísticos e instrumentos de política urbana.','Comissão Especial','Aprova o Plano Diretor Municipal e estabelece diretrizes para o desenvolvimento urbano.',NULL,'1','Elaborado com participação popular.','plano-diretor-municipal-46-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('6','12','2025','2025-09-05','Resolução','Regimento Interno da Câmara Municipal','Esta resolução estabelece as normas de funcionamento da Câmara Municipal, definindo os procedimentos para as sessões, tramitação de projetos, funcionamento das comissões e demais atividades legislativas.','Mesa Diretora','Aprova o novo Regimento Interno da Câmara Municipal.',NULL,'1','Atualização do regimento anterior.','regimento-interno-camara-12-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('7','13','2025','2025-09-12','Resolução','Criação da Comissão de Ética e Decoro Parlamentar','Esta resolução institui a Comissão de Ética e Decoro Parlamentar, órgão responsável por zelar pela observância dos princípios éticos e das normas de decoro parlamentar pelos membros da Câmara Municipal.','Vereador Carlos Oliveira','Cria a Comissão de Ética e Decoro Parlamentar e estabelece suas competências.',NULL,'1','Comissão permanente.','comissao-etica-decoro-13-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('8','8','2025','2025-08-30','Decreto Legislativo','Concessão de Título de Cidadão Honorário','Este decreto legislativo reconhece os méritos e a contribuição do Sr. José da Silva para o desenvolvimento do município, concedendo-lhe o título de Cidadão Honorário em reconhecimento aos seus serviços prestados à comunidade.','Vereador Pedro Costa','Concede o título de Cidadão Honorário ao Sr. José da Silva pelos relevantes serviços prestados ao município.',NULL,'1','Cerimônia de entrega agendada.','titulo-cidadao-honorario-jose-silva-8-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('9','9','2025','2025-09-02','Decreto Legislativo','Aprovação de Convênio com o Estado','Este decreto legislativo aprova o convênio firmado com o governo estadual para a execução de obras de pavimentação, drenagem e saneamento básico em diversos bairros do município, com investimento total de R$ 2.500.000,00.','Comissão de Finanças','Aprova o convênio celebrado entre o município e o governo estadual para execução de obras de infraestrutura.',NULL,'1','Contrapartida municipal de 20%.','aprovacao-convenio-estado-obras-9-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('10','1','2024','2024-01-15','Lei Orgânica','Lei Orgânica do Município','A Lei Orgânica é a lei fundamental do município, estabelecendo sua organização política, administrativa e territorial. Define os poderes municipais, os direitos e deveres dos cidadãos, as competências do município e os princípios da administração pública local.','Câmara Municipal Constituinte','Lei Orgânica do Município, estabelecendo sua organização política e administrativa.',NULL,'1','Lei fundamental do município.','lei-organica-municipio-1-2024','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('11','3','2025','2025-07-22','Emenda à Lei Orgânica','Emenda à Lei Orgânica nº 03/2025','Esta emenda à Lei Orgânica Municipal modifica o artigo 45, incluindo novos dispositivos sobre transparência pública, acesso à informação e participação popular na gestão municipal, fortalecendo os mecanismos de controle social.','Vereadora Ana Paula','Altera o artigo 45 da Lei Orgânica Municipal para incluir disposições sobre transparência pública.',NULL,'1','Aprovada em dois turnos.','emenda-lei-organica-transparencia-3-2025','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('12','1450','2024','2024-12-10','Lei Ordinária','Lei Orçamentária Anual 2025','A Lei Orçamentária Anual estabelece as previsões de receitas e as autorizações de despesas para o exercício de 2025, contemplando os programas e ações do governo municipal para o próximo ano.','Poder Executivo','Estima a receita e fixa a despesa do município para o exercício financeiro de 2025.',NULL,'1','Orçamento aprovado no prazo legal.','lei-orcamentaria-anual-2025-1450-2024','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('13','1420','2024','2024-06-15','Lei Ordinária','Estatuto do Servidor Público Municipal','Este estatuto estabelece o regime jurídico dos servidores públicos municipais, definindo direitos, deveres, proibições, regime disciplinar e demais aspectos da relação funcional entre o servidor e a administração municipal.','Comissão de Administração','Dispõe sobre o regime jurídico dos servidores públicos municipais.',NULL,'1','Substitui legislação anterior.','estatuto-servidor-publico-municipal-1420-2024','2025-09-26 07:33:43','2025-09-26 07:33:43');
INSERT INTO `leis` (`id`,`numero`,`exercicio`,`data`,`tipo`,`titulo`,`descricao`,`autoria`,`ementa`,`arquivo_pdf`,`ativo`,`observacoes`,`slug`,`created_at`,`updated_at`) VALUES ('14','1380','2023','2023-11-20','Lei Ordinária','Criação do Conselho Municipal de Educação','Esta lei institui o Conselho Municipal de Educação como órgão normativo, consultivo e de controle social do sistema municipal de ensino, definindo sua composição, competências e funcionamento.','Vereadora Lucia Fernandes','Cria o Conselho Municipal de Educação e estabelece suas competências.',NULL,'1','Órgão de controle social da educação.','conselho-municipal-educacao-1380-2023','2025-09-26 07:33:43','2025-09-26 07:33:43');

--
-- Tabela: `licitacao_documentos`
--
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


--
-- Tabela: `licitacoes`
--
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


--
-- Tabela: `manifestacao_anexos`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `manifestacao_anexos` (`id`,`manifestacao_id`,`nome_original`,`nome_arquivo`,`caminho_arquivo`,`tipo_mime`,`extensao`,`tamanho_bytes`,`tipo_anexo`,`publico`,`confidencial`,`hash_arquivo`,`descricao`,`metadados`,`ip_upload`,`uploaded_by`,`created_at`,`updated_at`,`deleted_at`) VALUES ('1','37','Carlos_Gaspar_CV_Executivo_SEM_ATS.pdf','1759963681_oRN70ntR8T.pdf','ouvidoria/anexos/1759963681_oRN70ntR8T.pdf','application/pdf','pdf','476962','documento','0','0','ea5f5a64f565ff354edf0bffb3200c1f7ee9d7b1b24477c981c74cde967c0f42',NULL,NULL,'127.0.0.1',NULL,'2025-10-08 18:48:02','2025-10-08 18:48:02',NULL);

--
-- Tabela: `media`
--
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `size` bigint(20) NOT NULL,
  `path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'outros',
  `uploaded_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL DEFAULT 'default',
  `name` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL DEFAULT 'public',
  `conversions_disk` varchar(255) DEFAULT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`generated_conversions`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_filename_unique` (`file_name`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_category_index` (`category`),
  KEY `media_mime_type_index` (`mime_type`),
  KEY `media_uploaded_by_index` (`uploaded_by`),
  KEY `media_created_at_index` (`created_at`),
  KEY `media_order_column_index` (`order_column`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('1','qr-1756172330-68ad102ad2c04_sIJgmkPF.pdf','qr_1756172330_68ad102ad2c04.pdf','application/pdf','133622','media/documento/qr-1756172330-68ad102ad2c04_sIJgmkPF.pdf',NULL,'qr_1756172330_68ad102ad2c04.pdf',NULL,'documento','11','2025-10-02 07:45:06','2025-10-02 07:45:06','0c465508-7f62-492d-9496-3c0d6eb343a0','documento','qr_1756172330_68ad102ad2c04','public','public','[]','{\"alt_text\":null,\"title\":\"qr_1756172330_68ad102ad2c04.pdf\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('2','test-qr-1756215064_fVPz8GeB.png','test_qr_1756215064.png','image/png','407','media/galeria/test-qr-1756215064_fVPz8GeB.png',NULL,'test_qr_1756215064.png',NULL,'galeria','11','2025-10-02 07:45:24','2025-10-02 07:45:24','ee54d07e-268c-45cf-87f7-69b5f4e4abc1','galeria','test_qr_1756215064','public','public','[]','{\"alt_text\":null,\"title\":\"test_qr_1756215064.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('3','boleto-03_OX13gYmn.pdf','boleto 03.pdf','application/pdf','430745','media/documento/boleto-03_OX13gYmn.pdf',NULL,'boleto 03.pdf',NULL,'documento','11','2025-10-02 07:59:23','2025-10-02 07:59:23','5722c460-ba2c-4d15-a2d2-5af0397e765a','documento','boleto 03','public','public','[]','{\"alt_text\":null,\"title\":\"boleto 03.pdf\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('4','boleto-execucao_uzKJZE0K.pdf','Boleto EXECUÇÃO.pdf','application/pdf','404633','media/documento/boleto-execucao_uzKJZE0K.pdf',NULL,'Boleto EXECUÇÃO.pdf',NULL,'documento','11','2025-10-02 07:59:23','2025-10-02 07:59:23','49182947-3c41-4308-803f-5c18ab8b7150','documento','Boleto EXECUÇÃO','public','public','[]','{\"alt_text\":null,\"title\":\"Boleto EXECU\\u00c7\\u00c3O.pdf\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('5','boleto-plano-05_jvxBJYF0.pdf','BOLETO PLANO 05.pdf','application/pdf','26487','media/documento/boleto-plano-05_jvxBJYF0.pdf',NULL,'BOLETO PLANO 05.pdf',NULL,'documento','11','2025-10-02 07:59:23','2025-10-02 07:59:23','ad639480-d3e1-406c-b3cd-399b1371024f','documento','BOLETO PLANO 05','public','public','[]','{\"alt_text\":null,\"title\":\"BOLETO PLANO 05.pdf\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('6','controle-de-implantacao-de-licencas-do-windows_jQxXFkO8.docx','Controle de implantação de Licenças do Windows.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','14745','media/documento/controle-de-implantacao-de-licencas-do-windows_jQxXFkO8.docx',NULL,'Controle de implantação de Licenças do Windows.docx',NULL,'documento','11','2025-10-02 07:59:23','2025-10-02 07:59:23','13897ad0-8fc6-489b-b875-3529fe3a9df6','documento','Controle de implantação de Licenças do Windows','public','public','[]','{\"alt_text\":null,\"title\":\"Controle de implanta\\u00e7\\u00e3o de Licen\\u00e7as do Windows.docx\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('7','cronograma-para-envio-das-cargas-do-aplic-em-atraso_YBk7TG40.docx','Cronograma para envio das cargas do APLIC em atraso.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','16186','media/documento/cronograma-para-envio-das-cargas-do-aplic-em-atraso_YBk7TG40.docx',NULL,'Cronograma para envio das cargas do APLIC em atraso.docx',NULL,'documento','11','2025-10-02 07:59:23','2025-10-02 07:59:23','39e85faf-4c0f-4fbf-9c09-d2765e174c07','documento','Cronograma para envio das cargas do APLIC em atraso','public','public','[]','{\"alt_text\":null,\"title\":\"Cronograma para envio das cargas do APLIC em atraso.docx\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('8','2_qqkbM0tP.gif','2.gif','image/gif','278548','media/logo/2_qqkbM0tP.gif',NULL,'2.gif',NULL,'logo','11','2025-10-02 07:59:53','2025-10-02 07:59:53','c8654cf3-abf2-4ae2-a230-5e198e97215e','logo','2','public','public','[]','{\"alt_text\":null,\"title\":\"2.gif\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('9','5_gjw4lNu5.gif','5.gif','image/gif','278548','media/logo/5_gjw4lNu5.gif',NULL,'5.gif',NULL,'logo','11','2025-10-02 07:59:53','2025-10-02 07:59:53','e5701aa5-cb9c-40cd-bee3-63e709f5a038','logo','5','public','public','[]','{\"alt_text\":null,\"title\":\"5.gif\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('10','canstockphoto84518016_ja62RkXJ.jpg','canstockphoto84518016.jpg','image/jpeg','27100','media/logo/canstockphoto84518016_ja62RkXJ.jpg',NULL,'canstockphoto84518016.jpg',NULL,'logo','11','2025-10-02 07:59:53','2025-10-02 07:59:53','4c8dedbf-888b-469b-9708-ba05ecaf24c9','logo','canstockphoto84518016','public','public','[]','{\"alt_text\":null,\"title\":\"canstockphoto84518016.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('11','carro001_qJWjyoZQ.jpg','Carro001.jpg','image/jpeg','171170','media/logo/carro001_qJWjyoZQ.jpg',NULL,'Carro001.jpg',NULL,'logo','11','2025-10-02 07:59:53','2025-10-02 07:59:53','59d1ebe5-babf-4d10-a75a-8dabcb2a552e','logo','Carro001','public','public','[]','{\"alt_text\":null,\"title\":\"Carro001.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('12','logopolicon_ZhVFIZIB.png','logoPolicon.png','image/png','8942','media/logo/logopolicon_ZhVFIZIB.png',NULL,'logoPolicon.png',NULL,'logo','11','2025-10-02 07:59:53','2025-10-02 07:59:53','db532750-f408-4aa5-b64d-5e97865e2fef','logo','logoPolicon','public','public','[]','{\"alt_text\":null,\"title\":\"logoPolicon.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('13','8Q6LRUkPubXR4UtQlxKH5hwAAxA31eRVFhba3f00.png','8Q6LRUkPubXR4UtQlxKH5hwAAxA31eRVFhba3f00.png','image/png','1227726','vereadores/8Q6LRUkPubXR4UtQlxKH5hwAAxA31eRVFhba3f00.png',NULL,'8Q6LRUkPubXR4UtQlxKH5hwAAxA31eRVFhba3f00.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','3304efee-8e3e-4897-9d56-3f77a346447a','vereadores','8Q6LRUkPubXR4UtQlxKH5hwAAxA31eRVFhba3f00','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('14','BfHp8yjIt07lJpXgE83kUDLYg39noSveDrqqYYra.png','BfHp8yjIt07lJpXgE83kUDLYg39noSveDrqqYYra.png','image/png','1148723','vereadores/BfHp8yjIt07lJpXgE83kUDLYg39noSveDrqqYYra.png','Vereador Carlos Pereira','Foto do Vereador Vereador Carlos Pereira',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','21dead7b-4cb5-40cd-9586-ae44507074be','vereadores','BfHp8yjIt07lJpXgE83kUDLYg39noSveDrqqYYra','public',NULL,'{}','{}','{}',NULL,'App\\Models\\Vereador','1');
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('15','DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR.png','DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR.png','image/png','1178862','vereadores/DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR.png',NULL,'DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','5b0605dd-36dd-4a4f-9168-5a93758df91b','vereadores','DPxBVaBL3qTycWBKeRbrxaUkmo1MXLenPDcyrZwR','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('16','DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD.png','DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD.png','image/png','1227726','vereadores/DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD.png','Vereador Antônio Carlos','Foto do Vereador Vereador Antônio Carlos',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','99b0f216-a965-4a5d-b18e-74689d933e9e','vereadores','DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD','public',NULL,'{}','{}','{}',NULL,'App\\Models\\Vereador','7');
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('17','HlRbNwF3bctWIdjjUye44a60D7BpJFssp7kEq7sv.png','HlRbNwF3bctWIdjjUye44a60D7BpJFssp7kEq7sv.png','image/png','1159716','vereadores/HlRbNwF3bctWIdjjUye44a60D7BpJFssp7kEq7sv.png',NULL,'HlRbNwF3bctWIdjjUye44a60D7BpJFssp7kEq7sv.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','b1d0ad21-b9ae-4c3e-b03a-8eb9ceaacd36','vereadores','HlRbNwF3bctWIdjjUye44a60D7BpJFssp7kEq7sv','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('18','HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76.png','HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76.png','image/png','1148723','vereadores/HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76.png',NULL,'HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','df6595c3-4f6b-4d06-b082-73bbe50fa2ce','vereadores','HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('19','ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa.png','ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa.png','image/png','1223532','vereadores/ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa.png',NULL,'ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','a013cdb2-348c-44ca-96f5-865978f19dc4','vereadores','ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('20','aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx.png','aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx.png','image/png','1052898','vereadores/aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx.png',NULL,'aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','1a2bdfde-61ef-49ac-8e0c-7e2b6cb5a630','vereadores','aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('21','eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr.png','eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr.png','image/png','1092933','vereadores/eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr.png',NULL,'eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','55a9626b-c261-4fb8-974c-c7777d05dec5','vereadores','eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('22','hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ.png','hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ.png','image/png','1178862','vereadores/hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ.png',NULL,'hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','70f8dc18-1a31-4e00-ac11-a9f245ffe080','vereadores','hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('23','oU4JdbjvIamcB2msv6KPn136gdsVQSxvW9q1S4Rk.png','oU4JdbjvIamcB2msv6KPn136gdsVQSxvW9q1S4Rk.png','image/png','1227726','vereadores/oU4JdbjvIamcB2msv6KPn136gdsVQSxvW9q1S4Rk.png',NULL,'oU4JdbjvIamcB2msv6KPn136gdsVQSxvW9q1S4Rk.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','cb9f0b77-a660-485c-92a9-770d693b2821','vereadores','oU4JdbjvIamcB2msv6KPn136gdsVQSxvW9q1S4Rk','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('24','twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT.png','twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT.png','image/png','1278667','vereadores/twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT.png',NULL,'twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','613508d7-3868-4805-90e6-4858c031311f','vereadores','twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('25','vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w.png','vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w.png','image/png','1238966','vereadores/vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w.png',NULL,'vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w.png',NULL,'foto',NULL,'2025-10-04 16:48:32','2025-10-04 16:48:32','4e095bc9-7136-4a9d-a499-94e63d88c045','vereadores','vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('26','y8qZQcaFxTl8yXKQXHQvCj9a8zARicWCK870DS1g.png','y8qZQcaFxTl8yXKQXHQvCj9a8zARicWCK870DS1g.png','image/png','1227726','vereadores/y8qZQcaFxTl8yXKQXHQvCj9a8zARicWCK870DS1g.png',NULL,'y8qZQcaFxTl8yXKQXHQvCj9a8zARicWCK870DS1g.png',NULL,'foto',NULL,'2025-10-04 16:48:33','2025-10-04 16:48:33','a455d87f-ae09-4952-803a-1701624711cd','vereadores','y8qZQcaFxTl8yXKQXHQvCj9a8zARicWCK870DS1g','public',NULL,'{}','{}','{}',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('27','camara-exemplolandia_lgIO9sEb.png','Camara_Exemplolândia.png','image/png','1421435','media/brasao/camara-exemplolandia_lgIO9sEb.png',NULL,'Camara_Exemplolândia.png',NULL,'brasao','11','2025-10-05 08:09:19','2025-10-05 08:09:19','bdb1fa93-8b07-422c-bc97-de101e383f66','brasao','Camara_Exemplolândia','public','public','[]','{\"alt_text\":null,\"title\":\"Camara_Exemplol\\u00e2ndia.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('28','camara-exemplolandia_T4VCBAAN.svg','Camara_Exemplolândia.svg','image/svg+xml','50854','media/brasao/camara-exemplolandia_T4VCBAAN.svg',NULL,'Camara_Exemplolândia.svg',NULL,'brasao','11','2025-10-05 08:09:21','2025-10-05 08:09:21','b709218f-d5a6-49a8-af2e-fbbb270e22ed','brasao','Camara_Exemplolândia','public','public','[]','{\"alt_text\":null,\"title\":\"Camara_Exemplol\\u00e2ndia.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('29','camara-exemplolandia-01_YYihgNNH.svg','Camara_Exemplolândia_01.svg','image/svg+xml','136459','media/brasao/camara-exemplolandia-01_YYihgNNH.svg',NULL,'Camara_Exemplolândia_01.svg',NULL,'brasao','11','2025-10-05 08:09:21','2025-10-05 08:09:21','450ef513-2d27-4b80-99f8-6c0d8c705192','brasao','Camara_Exemplolândia_01','public','public','[]','{\"alt_text\":null,\"title\":\"Camara_Exemplol\\u00e2ndia_01.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('30','1759666938_Camara_Exemplolândia_1.png','Camara_Exemplolândia_1.png','image/png','303211','configuracoes/1759666938_Camara_Exemplolândia_1.png','Brasão da Câmara Municipal exibido no header','Brasão da Câmara Municipal exibido no header',NULL,'brasao','11','2025-10-05 08:22:18','2025-10-05 08:22:18','302da383-e6a4-4767-be01-2839d14ddedf','configuracoes','Camara_Exemplolândia_1','public',NULL,'{}','{}','{}',NULL,'App\\Models\\ConfiguracaoGeral','1');
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('31','1759667111_Brasão.png','Brasão.png','image/png','1817606','configuracoes/1759667111_Brasão.png','Logo da Câmara Municipal exibida no footer','Logo da Câmara Municipal exibida no footer',NULL,'logo','11','2025-10-05 08:25:11','2025-10-05 08:25:11','e2a63523-e8f9-4370-a108-9d6c816fe276','configuracoes','Brasão','public',NULL,'{}','{}','{}',NULL,'App\\Models\\ConfiguracaoGeral','2');
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('32','ad0ebcac-46be-4368-a2c4-eac66255fbe9_ILvKbJEu.jpg','ad0ebcac-46be-4368-a2c4-eac66255fbe9.jpg','image/jpeg','89080','media/noticias/ad0ebcac-46be-4368-a2c4-eac66255fbe9_ILvKbJEu.jpg',NULL,'ad0ebcac-46be-4368-a2c4-eac66255fbe9.jpg',NULL,'noticias','11','2025-10-06 21:04:01','2025-10-06 21:04:01','0a2fe205-1f19-4368-a936-64e0bcfab2e1','noticias','ad0ebcac-46be-4368-a2c4-eac66255fbe9','public','public','[]','{\"alt_text\":null,\"title\":\"ad0ebcac-46be-4368-a2c4-eac66255fbe9.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('33','24eaf65a-ce29-42c7-92c0-2a8e5c503bf1_phJ3nqtI.jpg','24eaf65a-ce29-42c7-92c0-2a8e5c503bf1.jpg','image/jpeg','74956','media/noticias/24eaf65a-ce29-42c7-92c0-2a8e5c503bf1_phJ3nqtI.jpg',NULL,'24eaf65a-ce29-42c7-92c0-2a8e5c503bf1.jpg',NULL,'noticias','11','2025-10-06 21:07:20','2025-10-06 21:07:20','3e5df5f9-aa60-4109-9cf7-2bf886c194d7','noticias','24eaf65a-ce29-42c7-92c0-2a8e5c503bf1','public','public','[]','{\"alt_text\":null,\"title\":\"24eaf65a-ce29-42c7-92c0-2a8e5c503bf1.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('34','31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4_yCamsBrz.jpg','31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4.jpg','image/jpeg','76846','media/noticias/31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4_yCamsBrz.jpg',NULL,'31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4.jpg',NULL,'noticias','11','2025-10-06 21:07:20','2025-10-06 21:07:20','8556ab1f-1a33-4e57-999d-6926e16324e0','noticias','31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4','public','public','[]','{\"alt_text\":null,\"title\":\"31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('35','3f7dda6f-f80b-4ae9-a5b2-3a55cef86281_cHDqYdpk.jpg','3f7dda6f-f80b-4ae9-a5b2-3a55cef86281.jpg','image/jpeg','81092','media/noticias/3f7dda6f-f80b-4ae9-a5b2-3a55cef86281_cHDqYdpk.jpg',NULL,'3f7dda6f-f80b-4ae9-a5b2-3a55cef86281.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','b84a93ee-34c2-4b30-97db-cfa5f70f6aeb','noticias','3f7dda6f-f80b-4ae9-a5b2-3a55cef86281','public','public','[]','{\"alt_text\":null,\"title\":\"3f7dda6f-f80b-4ae9-a5b2-3a55cef86281.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('36','236bd949-0367-4853-8fed-bc5c15c575f1_krkuSU1Q.jpg','236bd949-0367-4853-8fed-bc5c15c575f1.jpg','image/jpeg','62537','media/noticias/236bd949-0367-4853-8fed-bc5c15c575f1_krkuSU1Q.jpg',NULL,'236bd949-0367-4853-8fed-bc5c15c575f1.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','65cfe3dd-a280-45c6-adc3-07aeda02a853','noticias','236bd949-0367-4853-8fed-bc5c15c575f1','public','public','[]','{\"alt_text\":null,\"title\":\"236bd949-0367-4853-8fed-bc5c15c575f1.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('37','8a815b55-e7de-44c9-b157-66c862878a6a_x9jJjgM7.jpg','8a815b55-e7de-44c9-b157-66c862878a6a.jpg','image/jpeg','63131','media/noticias/8a815b55-e7de-44c9-b157-66c862878a6a_x9jJjgM7.jpg',NULL,'8a815b55-e7de-44c9-b157-66c862878a6a.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','efbe35b1-65f5-435f-a83b-6acfdb9466c5','noticias','8a815b55-e7de-44c9-b157-66c862878a6a','public','public','[]','{\"alt_text\":null,\"title\":\"8a815b55-e7de-44c9-b157-66c862878a6a.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('38','93de999c-ead7-4889-8176-be79cb4a1b4d_s20RNRO8.jpg','93de999c-ead7-4889-8176-be79cb4a1b4d.jpg','image/jpeg','72565','media/noticias/93de999c-ead7-4889-8176-be79cb4a1b4d_s20RNRO8.jpg',NULL,'93de999c-ead7-4889-8176-be79cb4a1b4d.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','fb80374d-5d58-47ee-b033-5aa2c8c4e7e6','noticias','93de999c-ead7-4889-8176-be79cb4a1b4d','public','public','[]','{\"alt_text\":null,\"title\":\"93de999c-ead7-4889-8176-be79cb4a1b4d.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('39','6b0118fa-1c02-4d0c-af58-b0481c36f4e9_2MYuXSql.jpg','6b0118fa-1c02-4d0c-af58-b0481c36f4e9.jpg','image/jpeg','82842','media/noticias/6b0118fa-1c02-4d0c-af58-b0481c36f4e9_2MYuXSql.jpg',NULL,'6b0118fa-1c02-4d0c-af58-b0481c36f4e9.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','fe71d8d6-4b29-4346-b3fb-8c11bcbbf340','noticias','6b0118fa-1c02-4d0c-af58-b0481c36f4e9','public','public','[]','{\"alt_text\":null,\"title\":\"6b0118fa-1c02-4d0c-af58-b0481c36f4e9.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('40','6371e0a3-ada2-4117-83ee-ad78028506be_wvKt56hz.jpg','6371e0a3-ada2-4117-83ee-ad78028506be.jpg','image/jpeg','67753','media/noticias/6371e0a3-ada2-4117-83ee-ad78028506be_wvKt56hz.jpg',NULL,'6371e0a3-ada2-4117-83ee-ad78028506be.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','4faa3b0b-8563-4d16-8865-0d92b3516b9c','noticias','6371e0a3-ada2-4117-83ee-ad78028506be','public','public','[]','{\"alt_text\":null,\"title\":\"6371e0a3-ada2-4117-83ee-ad78028506be.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('41','d78cf34a-0578-47dc-a87d-bc540a942a47_Rfg9hnEl.jpg','d78cf34a-0578-47dc-a87d-bc540a942a47.jpg','image/jpeg','63568','media/noticias/d78cf34a-0578-47dc-a87d-bc540a942a47_Rfg9hnEl.jpg',NULL,'d78cf34a-0578-47dc-a87d-bc540a942a47.jpg',NULL,'noticias','11','2025-10-06 21:36:25','2025-10-06 21:36:25','a4e9b2ac-106a-489b-857c-f391efb729f4','noticias','d78cf34a-0578-47dc-a87d-bc540a942a47','public','public','[]','{\"alt_text\":null,\"title\":\"d78cf34a-0578-47dc-a87d-bc540a942a47.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('42','gemini-generated-image-10x3dn10x3dn10x3_AtFXuyuW.png','Gemini_Generated_Image_10x3dn10x3dn10x3.png','image/png','1701201','media/noticias/gemini-generated-image-10x3dn10x3dn10x3_AtFXuyuW.png',NULL,'Gemini_Generated_Image_10x3dn10x3dn10x3.png',NULL,'noticias','11','2025-10-06 21:39:48','2025-10-06 21:39:48','2bc3c9e1-bf15-478e-a416-f55fbc15d69d','noticias','Gemini_Generated_Image_10x3dn10x3dn10x3','public','public','[]','{\"alt_text\":null,\"title\":\"Gemini_Generated_Image_10x3dn10x3dn10x3.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('43','download_dZSiYife.png','download.png','image/png','3675','media/noticias/download_dZSiYife.png',NULL,'download.png',NULL,'noticias','11','2025-10-06 21:42:30','2025-10-06 21:42:30','5c521ed7-830c-4e94-9b24-7365c7a1e2d9','noticias','download','public','public','[]','{\"alt_text\":null,\"title\":\"download.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('44','screenshot-3_ou6Ruxn4.png','Screenshot_3.png','image/png','27765','media/noticias/screenshot-3_ou6Ruxn4.png',NULL,'Screenshot_3.png',NULL,'noticias','11','2025-10-06 21:44:33','2025-10-06 21:44:33','f0d81f2e-9f93-4381-93a1-f5b7616a753f','noticias','Screenshot_3','public','public','[]','{\"alt_text\":null,\"title\":\"Screenshot_3.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('45','screenshot-1_VxersDsF.png','Screenshot_1.png','image/png','26790','media/noticias/screenshot-1_VxersDsF.png',NULL,'Screenshot_1.png',NULL,'noticias','11','2025-10-06 22:02:56','2025-10-06 22:02:56','b8ef9960-ed57-435b-a6ef-ccc775441559','noticias','Screenshot_1','public','public','[]','{\"alt_text\":null,\"title\":\"Screenshot_1.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('46','screenshot-2_RosFUHKe.png','Screenshot_2.png','image/png','85782','media/noticias/screenshot-2_RosFUHKe.png',NULL,'Screenshot_2.png',NULL,'noticias','11','2025-10-06 22:11:48','2025-10-06 22:11:48','744b71a9-22ba-4d17-8b0e-e58f2da32e02','noticias','Screenshot_2','public','public','[]','{\"alt_text\":null,\"title\":\"Screenshot_2.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('47','2-flat-logo-on-transparent-182x73_RDKqdIvG.png','2_Flat_logo_on_transparent_182x73.png','image/png','3991','media/noticias/2-flat-logo-on-transparent-182x73_RDKqdIvG.png',NULL,'2_Flat_logo_on_transparent_182x73.png',NULL,'noticias','11','2025-10-06 22:14:19','2025-10-06 22:14:19','d067061c-926b-46cf-90c1-358665e29579','noticias','2_Flat_logo_on_transparent_182x73','public','public','[]','{\"alt_text\":null,\"title\":\"2_Flat_logo_on_transparent_182x73.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('48','2-flat-logo-on-transparent-182x73_EUpG2vBk.png','2_Flat_logo_on_transparent_182x73.png','image/png','3991','media/noticias/2-flat-logo-on-transparent-182x73_EUpG2vBk.png',NULL,'2_Flat_logo_on_transparent_182x73.png',NULL,'noticias','11','2025-10-06 22:18:20','2025-10-06 22:18:20','2b5309cb-c00e-43df-87e1-8e61e52858f0','noticias','2_Flat_logo_on_transparent_182x73','public','public','[]','{\"alt_text\":null,\"title\":\"2_Flat_logo_on_transparent_182x73.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('49','58348891-37c8-4419-ac27-82d03f927c69_fBelWcBk.webp','58348891-37c8-4419-ac27-82d03f927c69.webp','image/webp','537282','media/noticias/58348891-37c8-4419-ac27-82d03f927c69_fBelWcBk.webp',NULL,'58348891-37c8-4419-ac27-82d03f927c69.webp',NULL,'noticias','11','2025-10-06 22:19:17','2025-10-06 22:19:17','72309e22-9a16-40d1-b872-bf476b349bf6','noticias','58348891-37c8-4419-ac27-82d03f927c69','public','public','[]','{\"alt_text\":null,\"title\":\"58348891-37c8-4419-ac27-82d03f927c69.webp\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('50','painel-lona-festa-aniversario-bolofofos-200x100cm-desenho_39s4KSIa.jpg','painel-lona-festa-aniversario-bolofofos-200x100cm-desenho.jpg','image/jpeg','108776','media/noticias/painel-lona-festa-aniversario-bolofofos-200x100cm-desenho_39s4KSIa.jpg',NULL,'painel-lona-festa-aniversario-bolofofos-200x100cm-desenho.jpg',NULL,'noticias','11','2025-10-06 22:23:53','2025-10-06 22:23:53','906d8d3f-a4d7-4342-b69f-36686a663136','noticias','painel-lona-festa-aniversario-bolofofos-200x100cm-desenho','public','public','[]','{\"alt_text\":null,\"title\":\"painel-lona-festa-aniversario-bolofofos-200x100cm-desenho.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('51','33f18e9b84d60b380f9b2b8098329484_egllt9ug.jpg','33f18e9b84d60b380f9b2b8098329484.jpg','image/jpeg','177113','media/noticias/33f18e9b84d60b380f9b2b8098329484_egllt9ug.jpg',NULL,'33f18e9b84d60b380f9b2b8098329484.jpg',NULL,'noticias','11','2025-10-06 22:29:01','2025-10-06 22:29:01','64335151-130f-4686-ba7d-cefc0a3eab0c','noticias','33f18e9b84d60b380f9b2b8098329484','public','public','[]','{\"alt_text\":null,\"title\":\"33f18e9b84d60b380f9b2b8098329484.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('52','ab59b4b7615a6d3416a3ff963125a866_ViYN2kMg.jpg','ab59b4b7615a6d3416a3ff963125a866.jpg','image/jpeg','220000','media/noticias/ab59b4b7615a6d3416a3ff963125a866_ViYN2kMg.jpg',NULL,'ab59b4b7615a6d3416a3ff963125a866.jpg',NULL,'noticias','11','2025-10-06 22:29:01','2025-10-06 22:29:01','994cf0cc-57d9-4ff8-a22d-e947993ec4cf','noticias','ab59b4b7615a6d3416a3ff963125a866','public','public','[]','{\"alt_text\":null,\"title\":\"ab59b4b7615a6d3416a3ff963125a866.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('53','28a7d372e283f1804109d5bd72487829_infCRKCS.jpg','28a7d372e283f1804109d5bd72487829.jpg','image/jpeg','123054','media/noticias/28a7d372e283f1804109d5bd72487829_infCRKCS.jpg',NULL,'28a7d372e283f1804109d5bd72487829.jpg',NULL,'noticias','11','2025-10-06 22:34:06','2025-10-06 22:34:06','5a688108-a667-44fd-9daa-cc148cbd6e42','noticias','28a7d372e283f1804109d5bd72487829','public','public','[]','{\"alt_text\":null,\"title\":\"28a7d372e283f1804109d5bd72487829.jpg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('54','chatgpt-image-10-de-out-de-2025-14-53-12_0ZU6iAIE.png','ChatGPT Image 10 de out. de 2025, 14_53_12.png','image/png','1817606','media/noticias/chatgpt-image-10-de-out-de-2025-14-53-12_0ZU6iAIE.png',NULL,'ChatGPT Image 10 de out. de 2025, 14_53_12.png',NULL,'noticias','11','2025-10-10 16:34:59','2025-10-10 16:34:59','2512b950-424a-4895-a968-7c078ad5868b','noticias','ChatGPT Image 10 de out. de 2025, 14_53_12','public','public','[]','{\"alt_text\":null,\"title\":\"ChatGPT Image 10 de out. de 2025, 14_53_12.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('55','brasao_YqFNl6rL.png','Brasao.png','image/png','1817606','media/brasao/brasao_YqFNl6rL.png',NULL,'Brasao.png',NULL,'brasao','11','2025-10-10 17:44:13','2025-10-10 17:44:13','052ecd3a-815b-46e5-a28b-8031e4c91076','brasao','Brasao','public','public','[]','{\"alt_text\":null,\"title\":\"Brasao.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('56','novembroazul_pnoQfyU8.png','NovembroAzul.png','image/png','28271','media/icone/novembroazul_pnoQfyU8.png',NULL,'NovembroAzul.png',NULL,'icone','11','2025-10-12 15:52:55','2025-10-12 15:52:55','b259ebef-9379-4bbd-891c-d7acd834d9e3','icone','NovembroAzul','public','public','[]','{\"alt_text\":null,\"title\":\"NovembroAzul.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('57','novembroazul_cj71yNYC.svg','NovembroAzul.svg','image/svg+xml','4878','media/icone/novembroazul_cj71yNYC.svg',NULL,'NovembroAzul.svg',NULL,'icone','11','2025-10-12 15:52:55','2025-10-12 15:52:55','5d278a73-355b-498a-ad8a-1e61fd8b6f61','icone','NovembroAzul','public','public','[]','{\"alt_text\":null,\"title\":\"NovembroAzul.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('58','novembroazul001_EvQrMlcf.svg','NovembroAzul001.svg','image/svg+xml','4878','media/icone/novembroazul001_EvQrMlcf.svg',NULL,'NovembroAzul001.svg',NULL,'icone','11','2025-10-12 15:52:55','2025-10-12 15:52:55','4476178c-f53e-4b41-8c20-fd9b3cf7d0d0','icone','NovembroAzul001','public','public','[]','{\"alt_text\":null,\"title\":\"NovembroAzul001.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('59','outubrorosa_0KMKmB2c.png','OutubroRosa.png','image/png','24136','media/icone/outubrorosa_0KMKmB2c.png',NULL,'OutubroRosa.png',NULL,'icone','11','2025-10-12 15:52:55','2025-10-12 15:52:55','3404e9e7-bfd0-4bc1-8ff5-565439ccb57b','icone','OutubroRosa','public','public','[]','{\"alt_text\":null,\"title\":\"OutubroRosa.png\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('60','outubrorosa_tqhXJou7.svg','OutubroRosa.svg','image/svg+xml','4505','media/icone/outubrorosa_tqhXJou7.svg',NULL,'OutubroRosa.svg',NULL,'icone','11','2025-10-12 15:52:56','2025-10-12 15:52:56','d711c098-f0e1-4745-9111-ef5d1e3bb568','icone','OutubroRosa','public','public','[]','{\"alt_text\":null,\"title\":\"OutubroRosa.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('61','outubrorosa001_Caiq0CSm.svg','OutubroRosa001.svg','image/svg+xml','4505','media/icone/outubrorosa001_Caiq0CSm.svg',NULL,'OutubroRosa001.svg',NULL,'icone','11','2025-10-12 15:52:56','2025-10-12 15:52:56','231aa3b6-ed68-4756-8484-b42afd5b4e25','icone','OutubroRosa001','public','public','[]','{\"alt_text\":null,\"title\":\"OutubroRosa001.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('62','setembroamarelo_s1JnHc5x.svg','SetembroAmarelo.svg','image/svg+xml','15733','media/icone/setembroamarelo_s1JnHc5x.svg',NULL,'SetembroAmarelo.svg',NULL,'icone','11','2025-10-12 15:52:56','2025-10-12 15:52:56','1829b36a-9ae9-40ef-b3b2-7913a036feda','icone','SetembroAmarelo','public','public','[]','{\"alt_text\":null,\"title\":\"SetembroAmarelo.svg\",\"description\":null}','[]',NULL,NULL,NULL);
INSERT INTO `media` (`id`,`file_name`,`original_name`,`mime_type`,`size`,`path`,`alt_text`,`title`,`description`,`category`,`uploaded_by`,`created_at`,`updated_at`,`uuid`,`collection_name`,`name`,`disk`,`conversions_disk`,`manipulations`,`custom_properties`,`generated_conversions`,`order_column`,`model_type`,`model_id`) VALUES ('63','setembroamarelo001_Oa8HWp6T.svg','SetembroAmarelo001.svg','image/svg+xml','15732','media/icone/setembroamarelo001_Oa8HWp6T.svg',NULL,'SetembroAmarelo001.svg',NULL,'icone','11','2025-10-12 15:52:56','2025-10-12 15:52:56','a0dfa191-b158-447b-8004-7d77076c8c88','icone','SetembroAmarelo001','public','public','[]','{\"alt_text\":null,\"title\":\"SetembroAmarelo001.svg\",\"description\":null}','[]',NULL,NULL,NULL);

--
-- Tabela: `menus`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('1','Início','inicio','/',NULL,'fas fa-home','header','link',NULL,'1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('2','Sobre','sobre',NULL,NULL,'fas fa-info-circle','header','dropdown',NULL,'2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('3','História','historia','/sobre/historia',NULL,'fas fa-book','header','link','2','1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('4','Estrutura','estrutura','/sobre/estrutura',NULL,'fas fa-building','header','link','2','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('5','Regimento Interno','regimento-interno','/sobre/regimento',NULL,'fas fa-gavel','header','link','2','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('6','Missão, Visão e Valores','missao-visao-valores','/sobre/missao',NULL,'fas fa-bullseye','header','link','2','4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('7','Legislativo','legislativo',NULL,NULL,'fas fa-university','header','dropdown',NULL,'3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('8','Vereadores','vereadores',NULL,'vereadores.index','fas fa-users','header','link','7','1','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('9','Projetos de Lei','projetos-lei','/projetos-lei',NULL,'fas fa-file-alt','header','link','7','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-28 00:33:27');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('10','Sessões','sessoes',NULL,'sessoes.index','fas fa-calendar-alt','header','link','7','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('11','Transparência','transparencia',NULL,NULL,'fas fa-eye','header','dropdown',NULL,'4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('12','Portal da Transparência','portal-transparencia','https://sigesp.tce.mt.gov.br/aplictransparencia/tce/#/inicio',NULL,'fas fa-globe','header','link','11','1','1','1',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-28 00:47:37');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('13','Receitas e Despesas','receitas-despesas','/transparencia/financeiro',NULL,'fas fa-dollar-sign','header','link','11','2','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('14','Licitações','licitacoes','/transparencia/licitacoes',NULL,'fas fa-file-contract','header','link','11','3','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('15','Contratos','contratos','/transparencia/contratos',NULL,'fas fa-handshake','header','link','11','4','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('16','Ouvidoria','ouvidoria',NULL,'ouvidoria.index','fas fa-comments','header','link','11','5','1','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('17','Contato','contato','/contato',NULL,'fas fa-envelope','header','link',NULL,'5','0','0',NULL,NULL,NULL,'2025-09-26 07:51:57','2025-09-26 08:07:32');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('18','Entrar','entrar',NULL,'login','fas fa-sign-in-alt','header','link',NULL,'6','0','0',NULL,NULL,'\"{\\\"visibilidade\\\":\\\"guest_only\\\",\\\"classe_css\\\":\\\"nav-link-auth\\\"}\"','2025-09-26 07:51:57','2025-09-26 08:16:10');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('19','Cadastrar','cadastrar',NULL,'register','fas fa-user-plus','header','link',NULL,'7','0','0',NULL,NULL,'\"{\\\"visibilidade\\\":\\\"guest_only\\\",\\\"classe_css\\\":\\\"nav-link-auth\\\"}\"','2025-09-26 07:51:57','2025-09-26 08:16:11');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('20','Vereadores','footer-vereadores',NULL,'vereadores.index',NULL,'footer','link',NULL,'1','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('21','Projetos de Lei','footer-projetos-lei','#',NULL,NULL,'footer','link',NULL,'2','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('22','Sessões','footer-sessoes',NULL,'sessoes.index',NULL,'footer','link',NULL,'3','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('23','Atas','footer-atas','#',NULL,NULL,'footer','link',NULL,'4','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Links R\\\\u00e1pidos\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('24','Portal da Transparência','footer-portal-transparencia','https://sigesp.tce.mt.gov.br/aplictransparencia/tce/#/inicio',NULL,NULL,'footer','link',NULL,'11','1','1',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-28 00:46:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('25','e-SIC','footer-esic',NULL,'esic.public',NULL,'footer','link',NULL,'12','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('26','Lei de Acesso','lei-acesso','https://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm',NULL,'fas fa-balance-scale','ambos','link','7','13','1','1',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-28 00:38:07');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('27','Ouvidoria','footer-ouvidoria',NULL,'ouvidoria.index',NULL,'footer','link',NULL,'14','1','0',NULL,NULL,'\"{\\\"grupo_footer\\\":\\\"Transpar\\\\u00eancia\\\"}\"','2025-09-26 07:51:57','2025-09-26 07:51:57');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('28','Leis','leis','/leis',NULL,'fas fa-gavel','header','link','7','4','1','0',NULL,NULL,NULL,'2025-09-26 08:05:50','2025-09-26 08:07:25');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('29','História de Exemplolândia','histria-de-exemplolandia','/pagina/histria-de-exemplolandia',NULL,'fas fa-book','header','link','2','1','1','0',NULL,NULL,NULL,'2025-10-05 10:24:08','2025-10-05 10:28:11');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('30','Sala de Imprensa','sala_de_imprensa',NULL,'noticias.index','fas fa-newspaper','header','dropdown',NULL,'8','1','0',NULL,NULL,NULL,'2025-10-12 11:03:01','2025-10-12 11:03:01');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('31','Notícias','noticias',NULL,'noticias.index','fas fa-id-card','header','link','30','1','1','0',NULL,NULL,NULL,'2025-10-12 11:05:26','2025-10-12 11:05:26');
INSERT INTO `menus` (`id`,`titulo`,`slug`,`url`,`rota`,`icone`,`posicao`,`tipo`,`parent_id`,`ordem`,`ativo`,`nova_aba`,`permissao`,`descricao`,`configuracoes`,`created_at`,`updated_at`) VALUES ('32','Tv Câmara','tv_camara',NULL,'tv-camara','fas fa-broadcast-tower','header','link','30','2','1','0',NULL,NULL,NULL,'2025-10-12 11:08:56','2025-10-12 11:08:56');

--
-- Tabela: `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('1','0001_01_01_000000_create_users_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('2','0001_01_01_000001_create_cache_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('3','0001_01_01_000002_create_jobs_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('4','2025_09_17_161629_create_vereadores_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('5','2025_09_17_161649_create_noticias_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('6','2025_09_17_161658_create_sessoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('7','2025_09_17_161707_create_projetos_lei_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('8','2025_09_17_161716_create_documentos_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('9','2025_09_17_161726_create_esic_solicitacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('10','2025_09_17_162110_create_permission_tables','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('11','2025_09_18_175819_add_comissoes_to_vereadores_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('12','2025_09_18_190931_update_vereadores_partido_field_size','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('13','2025_09_18_195036_add_role_to_users_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('14','2025_09_19_121900_add_arquivada_fields_to_esic_solicitacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('15','2025_09_19_150105_add_deleted_at_to_esic_solicitacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('16','2025_09_19_151458_add_deleted_at_to_projetos_lei_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('17','2025_09_19_153535_create_sessao_projeto_lei_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('18','2025_09_19_153545_create_projeto_lei_coautor_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('19','2025_09_19_153554_create_sessao_vereador_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('20','2025_09_19_154035_add_deleted_at_to_documentos_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('21','2025_09_19_154211_add_deleted_at_to_sessoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('22','2025_09_19_154221_add_deleted_at_to_noticias_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('23','2025_09_20_122149_add_video_fields_to_sessoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('24','2025_09_20_130244_add_presidente_secretario_to_sessoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('25','2025_09_20_135715_rename_numero_projeto_to_numero_in_projetos_lei_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('26','2025_09_20_144144_create_tipo_sessaos_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('27','2025_09_20_144833_add_tipo_sessao_id_to_sessoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('28','2025_09_20_220409_create_esic_usuarios_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('29','2025_09_20_220418_create_ouvidores_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('30','2025_09_20_220428_create_ouvidoria_manifestacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('31','2025_09_20_220438_create_manifestacao_anexos_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('32','2025_09_20_220705_create_carta_servicos_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('33','2025_09_20_220715_create_notificacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('34','2025_09_20_231843_create_esic_movimentacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('35','2025_09_20_232000_create_ouvidoria_movimentacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('36','2025_09_20_232019_create_carta_servico_categorias_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('37','2025_09_20_232139_create_carta_servico_avaliacoes_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('38','2025_09_21_113657_add_verification_fields_to_users_table','1');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('39','2025_09_21_115359_add_profile_fields_to_users_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('40','2025_09_21_165141_create_menus_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('41','2025_09_21_171752_add_data_resposta_to_esic_solicitacoes_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('42','2025_09_21_235354_create_receitas_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('43','2025_09_21_235404_create_despesas_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('44','2025_09_21_235413_create_licitacoes_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('45','2025_09_21_235422_create_folha_pagamento_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('46','2025_09_22_002014_add_data_publicacao_to_licitacoes_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('47','2025_09_22_123335_create_licitacao_documentos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('48','2025_09_22_141407_create_acesso_rapido_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('49','2025_09_23_112848_add_user_id_to_esic_solicitacoes_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('50','2025_09_23_153842_create_eventos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('51','2025_09_23_162210_fix_eventos_tipo_enum','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('52','2025_09_24_131658_create_paginas_conteudo_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('53','2025_09_24_155007_create_tipo_contratos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('54','2025_09_24_155050_create_contratos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('55','2025_09_24_155153_create_contrato_aditivos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('56','2025_09_24_155248_create_contrato_fiscalizacaos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('57','2025_09_25_004253_add_observacoes_transparencia_to_contratos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('58','2025_09_25_015143_fix_numero_relatorio_field_in_contrato_fiscalizacaos_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('59','2025_09_26_012038_create_configuracao_gerais_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('60','2025_09_26_015517_create_slides_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('61','2025_09_26_020714_create_hero_configurations_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('62','2025_09_26_050741_create_leis_table','2');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('63','2025_09_27_163821_add_escolaridade_endereco_observacoes_to_vereadores_table','3');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('64','2025_09_27_190912_add_slug_to_projetos_lei_table','3');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('65','2025_09_27_195749_add_destaque_to_projetos_lei_table','3');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('66','2025_09_27_205306_add_tipo_autoria_to_projetos_lei_table','3');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('67','2025_09_27_205630_create_comite_iniciativa_populars_table','4');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('68','2025_09_27_212835_add_comite_iniciativa_popular_id_to_projetos_lei_table','5');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('69','2025_09_27_215229_make_autor_id_nullable_in_projetos_lei_table','5');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('72','2025_09_28_105835_add_custom_fields_to_roles_table','6');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('73','2025_09_28_105844_add_custom_fields_to_permissions_table','6');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('74','2025_09_28_152506_add_sli_fields_to_projetos_lei_table_safe','7');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('75','2025_09_28_163534_create_assinatura_eletronicas_table','8');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('76','2025_09_28_163710_create_cidadaos_table','9');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('77','2025_09_28_201023_add_user_id_to_cidadaos_table_temp','10');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('78','2025_09_28_201234_update_users_role_enum_add_cidadao','11');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('79','2025_09_28_200930_refactor_cidadaos_table_remove_auth_fields','12');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('80','2025_09_28_213244_update_cpf_field_size_in_cidadaos_table','13');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('81','2025_12_30_000001_update_users_role_enum_camara_municipal','14');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('82','2025_09_29_122854_add_permissions_to_users_table','15');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('83','2025_09_30_074053_add_data_solicitacao_to_esic_solicitacoes_table','16');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('84','2025_09_30_075208_update_categoria_column_in_esic_solicitacoes_table','17');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('85','2025_09_30_194906_add_cargo_setor_observacoes_to_users_table','18');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('88','2025_10_01_075243_create_media_table','19');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('89','2025_10_01_202000_modify_media_table_for_spatie','19');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('90','2025_10_02_120000_make_media_model_morphs_nullable','20');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('91','2025_10_05_120000_add_mandato_presidente_vice_dates_to_vereadores_table','21');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('92','2025_10_05_121500_add_ementa_texto_to_comite_iniciativa_populars_table','22');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('93','2025_10_07_170758_add_categoria_to_ouvidoria_manifestacoes_table','23');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('94','2025_10_09_152154_update_ouvidoria_manifestacoes_status_enum','24');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('95','2025_10_09_170047_update_ouvidoria_movimentacoes_status_enum','25');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('96','2025_10_11_000000_create_themes_table','26');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('97','2025_10_11_010600_add_extended_theme_variables_to_themes_table','27');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('98','2025_10_12_000000_add_ribbon_fields_to_themes_table','28');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('99','2025_10_12_010000_add_mourning_enabled_to_themes_table','29');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('100','2025_10_12_020000_add_ribbon_label_and_link_to_themes_table','30');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('101','2025_10_12_030000_add_specific_ribbon_fields_to_themes_table','31');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('102','2025_10_12_050500_add_images_to_hero_configurations_table','32');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('103','2025_10_12_151300_add_slider_fields_to_hero_configurations_table','33');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('104','2025_10_12_153500_add_top_image_options_to_hero_configurations_table','34');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('105','2025_10_12_154400_add_desc_image_height_to_hero_configurations_table','35');
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES ('106','2025_10_12_160000_add_desc_image_width_and_center_to_hero_configurations_table','36');

--
-- Tabela: `model_has_permissions`
--
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('32','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('37','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('38','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('39','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('40','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('41','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('44','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('45','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('46','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('48','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('49','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('50','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('52','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('53','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('54','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('56','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('57','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('58','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('61','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('62','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('63','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('72','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('73','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('75','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('77','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('78','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('79','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('80','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('81','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('82','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('83','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('84','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('85','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('86','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('87','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('88','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('89','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('90','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('91','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('92','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('93','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('94','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('95','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('96','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('97','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('98','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('99','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('100','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('101','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('102','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('103','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('104','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('105','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('106','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('107','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('108','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('109','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('110','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('111','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('112','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('113','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('114','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('115','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('116','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('117','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('118','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('119','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('120','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('121','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('122','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('123','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('124','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('125','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('126','App\\Models\\User','11');
INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('127','App\\Models\\User','11');

--
-- Tabela: `model_has_roles`
--
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','2');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','3');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','4');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','5');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','6');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','7');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('7','App\\Models\\User','8');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('10','App\\Models\\User','11');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('11','App\\Models\\User','11');
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES ('1','App\\Models\\User','12');

--
-- Tabela: `noticias`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('1','Câmara Municipal aprova novo projeto de lei para melhorias urbanas','camara-aprova-projeto-melhorias-urbanas','O projeto prevê investimentos em infraestrutura e mobilidade urbana para os próximos dois anos.','<p>A Câmara Municipal aprovou por unanimidade o projeto de lei que destina recursos para melhorias na infraestrutura urbana da cidade. O projeto, de autoria do vereador João Silva, prevê investimentos em pavimentação, iluminação pública e mobilidade urbana.</p><p>As obras devem começar no próximo trimestre e beneficiarão diretamente mais de 50 mil moradores da região central e dos bairros periféricos.</p><p>\"Este é um marco importante para nossa cidade\", declarou o presidente da Câmara durante a sessão.</p>','media/noticias/ad0ebcac-46be-4368-a2c4-eac66255fbe9_ILvKbJEu.jpg','[\"media\\/noticias\\/24eaf65a-ce29-42c7-92c0-2a8e5c503bf1_phJ3nqtI.jpg\",\"media\\/noticias\\/31b9a81b-9fce-4244-b3ca-b5b4eb5f1ea4_yCamsBrz.jpg\"]','11','publicado','1','10','[\"infraestrutura\",\"mobilidade\",\"aprova\\u00e7\\u00e3o\"]','legislativo','2025-09-25 08:24:00','Câmara Municipal aprova projeto para melhorias urbanas com investimentos em infraestrutura.','câmara municipal, projeto de lei, infraestrutura, melhorias urbanas','2025-09-26 08:24:22','2025-10-11 13:58:50',NULL);
INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('2','Sessão extraordinária discutirá orçamento municipal para 2024','sessao-extraordinaria-orcamento-2024','Vereadores se reunirão na próxima semana para debater a proposta orçamentária do município.','<p>A Câmara Municipal convocou uma sessão extraordinária para a próxima terça-feira (15) para discussão e votação da Lei Orçamentária Anual (LOA) de 2024.</p><p>A proposta, enviada pelo Executivo, prevê um orçamento de R$ 120 milhões, com foco em educação, saúde e obras públicas.</p><p>A sessão será aberta ao público e transmitida ao vivo pelos canais oficiais da Câmara.</p>','media/noticias/d78cf34a-0578-47dc-a87d-bc540a942a47_Rfg9hnEl.jpg','[\"media\\/noticias\\/236bd949-0367-4853-8fed-bc5c15c575f1_krkuSU1Q.jpg\",\"media\\/noticias\\/8a815b55-e7de-44c9-b157-66c862878a6a_x9jJjgM7.jpg\"]','11','publicado','1','19','[\"or\\u00e7amento\",\"sess\\u00e3o extraordin\\u00e1ria\",\"LOA\"]','legislativo','2025-09-23 08:24:00','Sessão extraordinária da Câmara discutirá orçamento municipal de 2024.','sessão extraordinária, orçamento municipal, LOA 2024','2025-09-26 08:24:22','2025-10-11 13:33:02',NULL);
INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('3','Câmara promove audiência pública sobre meio ambiente','audiencia-publica-meio-ambiente','Evento debaterá políticas ambientais e sustentabilidade no município.','<p>A Câmara Municipal realizará na próxima sexta-feira (18) uma audiência pública para discutir políticas ambientais e sustentabilidade no município.</p><p>O evento contará com a participação de especialistas, representantes de ONGs ambientais e da sociedade civil organizada.</p><p>Entre os temas abordados estão: gestão de resíduos sólidos, preservação de áreas verdes e políticas de sustentabilidade urbana.</p><p>A audiência será realizada no Plenário da Câmara, às 19h, com entrada gratuita.</p>','media/noticias/gemini-generated-image-10x3dn10x3dn10x3_AtFXuyuW.png','[\"media\\/noticias\\/ad0ebcac-46be-4368-a2c4-eac66255fbe9_ILvKbJEu.jpg\"]','11','publicado','1','10','[\"meio ambiente\",\"audi\\u00eancia p\\u00fablica\",\"sustentabilidade\",\"infraestrutura\"]','eventos','2025-09-21 08:24:00','Câmara promove audiência pública sobre políticas ambientais e sustentabilidade.','audiência pública, meio ambiente, sustentabilidade, políticas ambientais','2025-09-26 08:24:22','2025-10-11 14:37:47',NULL);
INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('4','Transparência: Câmara publica relatório de atividades do 1º semestre','relatorio-atividades-primeiro-semestre','Documento apresenta dados sobre projetos aprovados, sessões realizadas e investimentos.','<p>A Câmara Municipal publicou o relatório de atividades do primeiro semestre de 2024, demonstrando seu compromisso com a transparência pública.</p><p>O documento apresenta dados detalhados sobre:</p><ul><li>25 projetos de lei analisados</li><li>48 sessões ordinárias realizadas</li><li>12 audiências públicas promovidas</li><li>R$ 2,8 milhões em investimentos</li></ul><p>O relatório está disponível no portal da transparência da Câmara e pode ser acessado gratuitamente por todos os cidadãos.</p>','media/noticias/3f7dda6f-f80b-4ae9-a5b2-3a55cef86281_cHDqYdpk.jpg','[\"media\\/noticias\\/58348891-37c8-4419-ac27-82d03f927c69_fBelWcBk.webp\",\"media\\/noticias\\/download_dZSiYife.png\",\"media\\/noticias\\/gemini-generated-image-10x3dn10x3dn10x3_AtFXuyuW.png\"]','11','publicado','1','7','[\"transpar\\u00eancia\",\"relat\\u00f3rio\",\"atividades\"]','transparencia','2025-09-19 08:24:00','Câmara publica relatório de atividades do 1º semestre com dados de transparência.','relatório de atividades, transparência, câmara municipal','2025-09-26 08:24:22','2025-10-11 15:28:35',NULL);
INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('5','Homenagem aos professores marca sessão solene da Câmara','homenagem-professores-sessao-solene','Evento reconheceu o trabalho de educadores que se destacaram no município.','<p>A Câmara Municipal realizou uma sessão solene em homenagem aos professores da rede municipal de ensino. O evento reconheceu o trabalho de 15 educadores que se destacaram por suas práticas inovadoras e dedicação.</p><p>Durante a cerimônia, foram entregues certificados de reconhecimento e medalhas de honra ao mérito educacional.</p><p>\"Os professores são os verdadeiros construtores do futuro da nossa cidade\", destacou o presidente da Câmara durante seu discurso.</p><p>A sessão contou com a presença de familiares, colegas de trabalho e autoridades municipais.</p>','media/noticias/93de999c-ead7-4889-8176-be79cb4a1b4d_s20RNRO8.jpg','[\"media\\/noticias\\/93de999c-ead7-4889-8176-be79cb4a1b4d_s20RNRO8.jpg\",\"media\\/noticias\\/8a815b55-e7de-44c9-b157-66c862878a6a_x9jJjgM7.jpg\"]','11','publicado','1','46','[\"educa\\u00e7\\u00e3o\",\"professores\",\"homenagem\"]','eventos','2025-09-16 08:24:00','Câmara realiza sessão solene em homenagem aos professores municipais.','sessão solene, professores, educação, homenagem','2025-09-26 08:24:22','2025-10-11 14:28:00',NULL);
INSERT INTO `noticias` (`id`,`titulo`,`slug`,`resumo`,`conteudo`,`imagem_destaque`,`galeria_imagens`,`autor_id`,`status`,`destaque`,`visualizacoes`,`tags`,`categoria`,`data_publicacao`,`meta_description`,`meta_keywords`,`created_at`,`updated_at`,`deleted_at`) VALUES ('6','teste','teste','teste','teste',NULL,NULL,'11','rascunho','0','0','[\"teste\"]','teste','2025-10-05 22:20:00','teste','teste','2025-10-05 22:22:12','2025-10-05 22:22:40','2025-10-05 22:22:40');

--
-- Tabela: `notificacoes`
--
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


--
-- Tabela: `ouvidores`
--
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


--
-- Tabela: `ouvidoria_manifestacoes`
--
DROP TABLE IF EXISTS `ouvidoria_manifestacoes`;
CREATE TABLE `ouvidoria_manifestacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(20) NOT NULL,
  `esic_usuario_id` bigint(20) unsigned DEFAULT NULL,
  `ouvidor_responsavel_id` bigint(20) unsigned DEFAULT NULL,
  `tipo` enum('solicitacao_informacao','reclamacao','sugestao','elogio','denuncia','ouvidoria_geral') NOT NULL,
  `categoria` enum('atendimento','legislativo','administrativo','transparencia','infraestrutura','tecnologia','outros') DEFAULT NULL,
  `nome_manifestante` varchar(255) DEFAULT NULL,
  `email_manifestante` varchar(255) DEFAULT NULL,
  `telefone_manifestante` varchar(255) DEFAULT NULL,
  `manifestacao_anonima` tinyint(1) NOT NULL DEFAULT 0,
  `assunto` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `orgao_destinatario` varchar(255) DEFAULT NULL,
  `setor_destinatario` varchar(255) DEFAULT NULL,
  `categoria_esic` enum('acesso_informacao','dados_pessoais','transparencia_ativa','transparencia_passiva','outros') DEFAULT NULL,
  `status` enum('recebida','em_analise_inicial','aguardando_informacoes_complementares','encaminhada','em_investigacao','pendente_de_providencias','aguardando_parecer_tecnico','resposta_parcial','concluida','nao_acatada','arquivada','redirecionada','em_mediacao','aguardando_prazo_legal','reaberta','em_recurso','suspensa','elogio_registrado','sugestao_em_analise','encerrada_sem_resposta','nova','em_analise','em_tramitacao','aguardando_informacoes','respondida','finalizada') DEFAULT 'recebida',
  `justificativa_status` text DEFAULT NULL,
  `data_mudanca_status` timestamp NULL DEFAULT NULL,
  `usuario_mudanca_status` bigint(20) unsigned DEFAULT NULL,
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
  `historico_status_detalhado` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`historico_status_detalhado`)),
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
  KEY `ouvidoria_manifestacoes_status_data_mudanca_status_index` (`status`,`data_mudanca_status`),
  CONSTRAINT `ouvidoria_manifestacoes_esic_usuario_id_foreign` FOREIGN KEY (`esic_usuario_id`) REFERENCES `esic_usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ouvidoria_manifestacoes_ouvidor_responsavel_id_foreign` FOREIGN KEY (`ouvidor_responsavel_id`) REFERENCES `ouvidores` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ouvidoria_manifestacoes_respondida_por_foreign` FOREIGN KEY (`respondida_por`) REFERENCES `ouvidores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('2','OUV2025000002',NULL,NULL,'reclamacao',NULL,'Bruno','bruno@bruno.com',NULL,'0','Teste de manifestação','Esta é uma manifestação de teste para verificar o funcionamento do sistema.',NULL,NULL,NULL,'concluida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,'Sua manifestação foi analisada e as providências necessárias foram tomadas. Esta é uma resposta de teste para validar a exibição de status finais.',NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36',NULL,NULL,'2025-10-07 17:08:23','2025-10-09 18:57:17',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('3','OUV2025000003',NULL,NULL,'denuncia','atendimento','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','0','Imagem Vetorial sob Encomenda','Imagem Vetorial sob Encomenda',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',NULL,NULL,'2025-10-07 17:15:59','2025-10-07 17:15:59',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('4','OUV2025000004',NULL,NULL,'denuncia','legislativo','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','0','Teste de manifestação','Teste de manifestação',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',NULL,NULL,'2025-10-07 18:32:53','2025-10-07 18:32:53',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('5','OUV2025000005',NULL,NULL,'denuncia','legislativo','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','0','Teste de manifestação','Teste de manifestação',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',NULL,NULL,'2025-10-07 18:42:39','2025-10-07 18:42:39',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('6','OUV2025000006',NULL,NULL,'denuncia','transparencia','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','0','Imagem Vetorial sob Encomenda','v\r\nImagem Vetorial sob Encomenda',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',NULL,NULL,'2025-10-07 19:05:08','2025-10-07 19:05:08',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('7','OUV2025000007',NULL,NULL,'denuncia','tecnologia','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5608','0','Teste de manifestação','Encontrei o problema! Há uma inconsistência entre o ID do campo ( anonima ) e o que o JavaScript está tentando acessar ( anonimo ). Vou corrigir isso:',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',NULL,NULL,'2025-10-07 19:08:55','2025-10-07 19:08:55',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('8','OUV2025000008',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de funcionamento',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-07 19:09:58','2025-10-07 19:09:58',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('9','OUV2025000009',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de funcionamento',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-08 13:10:12','2025-10-08 13:10:12',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('10','OUV2025000010',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de funcionamento',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-08 13:11:22','2025-10-08 13:11:22',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('11','OUV2025000011',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de funcionamento',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-08 13:12:52','2025-10-08 13:12:52',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('12','OUV2025000012',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','test',NULL,NULL,'2025-10-08 13:14:08','2025-10-08 13:14:08',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('13','OUV2025000013',NULL,NULL,'reclamacao','atendimento','João Silva','joao.silva@email.com','(11) 99999-9999','0','Teste de formulário','Esta é uma descrição de teste para verificar se o formulário está funcionando corretamente.',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-08 13:15:50','2025-10-08 13:15:50',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('14','TEST002',NULL,NULL,'reclamacao','atendimento',NULL,NULL,NULL,'0','Teste','Teste de inserção',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-10-28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,NULL,NULL,NULL,NULL,'2025-10-08 14:06:09','2025-10-08 14:06:09',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('15','OUV2025836924',NULL,NULL,'reclamacao','atendimento','Joao Silva','joao@teste.com',NULL,'0','Teste','Esta e uma manifestacao de teste.',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584',NULL,NULL,'2025-10-08 14:15:11','2025-10-08 14:15:11',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('16','OUV2025607462',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de descricao',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584','[{\"status\":\"nova\",\"data\":\"2025-10-08T18:17:46.003721Z\",\"descricao\":\"Manifestacao criada pelo cidadao\"}]',NULL,'2025-10-08 14:17:46','2025-10-08 14:17:46',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('17','OUV2025218529',NULL,NULL,'reclamacao','atendimento','Teste','teste@teste.com',NULL,'0','Teste','Teste de descricao',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; pt-BR) WindowsPowerShell/5.1.26100.6584','[{\"status\":\"nova\",\"data\":\"2025-10-08T18:18:27.793224Z\",\"descricao\":\"Manifestacao criada pelo cidadao\"}]',NULL,'2025-10-08 14:18:27','2025-10-08 14:18:27',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('23','OUV-2025-685304',NULL,NULL,'reclamacao',NULL,'João da Silva Teste','joao.teste@exemplo.com',NULL,'0','Teste completo do sistema de ouvidoria','Esta é uma manifestação de teste para verificar se todo o processo está funcionando corretamente, incluindo validação, inserção no banco, geração de protocolo e envio de email.',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,NULL,NULL,NULL,NULL,'2025-10-08 14:30:01','2025-10-08 14:30:01',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('26','OUV-2025-378232',NULL,NULL,'reclamacao',NULL,'João da Silva Teste','joao.teste@exemplo.com',NULL,'0','Teste completo do sistema de ouvidoria','Esta é uma manifestação de teste para verificar se todo o processo está funcionando corretamente, incluindo validação, inserção no banco, geração de protocolo e envio de email.',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,NULL,NULL,NULL,NULL,'2025-10-08 14:31:58','2025-10-08 14:31:58',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('27','OUV2025246438',NULL,NULL,'reclamacao','atendimento','Maria Santos','maria.santos@email.com','11987654321','0','Teste final - Formulário da Ouvidoria','Este é um teste final para verificar se o formulário da ouvidoria está funcionando corretamente após todas as correções implementadas. O teste inclui validação de dados, geração de protocolo, cálculo de prazo de resposta, inserção no banco de dados, criação de movimentação e envio de email de confirmação.','Câmara Municipal','Ouvidoria',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Test Agent','[{\"status\":\"nova\",\"data\":\"2025-10-08T18:35:51.082186Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 14:35:51','2025-10-08 14:35:51',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('28','OUV2025456530',NULL,NULL,'reclamacao','atendimento','Maria Santos','maria.santos@email.com','11987654321','0','Teste final - Formulário da Ouvidoria','Este é um teste final para verificar se o formulário da ouvidoria está funcionando corretamente após todas as correções implementadas. O teste inclui validação de dados, geração de protocolo, cálculo de prazo de resposta, inserção no banco de dados, criação de movimentação e envio de email de confirmação.','Câmara Municipal','Ouvidoria',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Test Agent','[{\"status\":\"nova\",\"data\":\"2025-10-08T18:55:31.699850Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 14:55:31','2025-10-08 14:55:31',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('29','OUV2025650779',NULL,NULL,'reclamacao','atendimento','João Silva','joao@teste.com','(11) 99999-9999','0','Teste direto do formulário','Testando submissão direta para verificar se funciona','Câmara Municipal','Ouvidoria',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,NULL,NULL,'[{\"status\":\"nova\",\"data\":\"2025-10-08T19:04:42.032267Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 15:04:42','2025-10-08 15:04:42',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('30','OUV2025246079',NULL,NULL,'sugestao','transparencia','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','65999205608','0','Teste de envio 003','Teste de envio 003','Prefeitura','Saúde',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T20:07:03.930368Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 16:07:03','2025-10-08 16:07:03',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('31','OUV2025321165',NULL,NULL,'elogio','legislativo','PRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','65999205608','0','Teste de envio 002','Teste de envio 002','Câmara','Vereadores',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T20:22:51.424247Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 16:22:51','2025-10-08 16:22:51',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('32','OUV2025383251',NULL,NULL,'elogio','administrativo','GISELE FERNANDA FRANCO DE ALMEIDA','gisele.fernanda.franco@gmail.com','65999887646','0','Teste de manifestação','Teste de manifestação','Prefeitura','Vereadores',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T20:41:51.761379Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 16:41:51','2025-10-08 16:41:51',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('33','OUV2025327299',NULL,NULL,'elogio','administrativo','GISELE FERNANDA FRANCO DE ALMEIDA','gisele.fernanda.franco@gmail.com','65999887646','0','Teste de manifestação','Teste de manifestação','Prefeitura','Vereadores',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T20:54:07.352307Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 16:54:07','2025-10-08 16:54:07',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('34','TEST-20251008205610',NULL,NULL,'reclamacao',NULL,NULL,NULL,NULL,'1','Teste de inserção','Descrição do teste',NULL,NULL,NULL,'em_investigacao','Resposta fornecida: Estamos investigando','2025-10-09 18:16:52','11','2025-11-07',NULL,NULL,'Estamos investigando',NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Test Agent',NULL,'[{\"status_anterior\":\"concluida\",\"status_novo\":\"reaberta\",\"data_mudanca\":\"2025-10-09T21:04:04.401856Z\",\"usuario_id\":11,\"justificativa\":\"Teste de altera\\u00e7\\u00e3o via script\"},{\"status_anterior\":\"reaberta\",\"status_novo\":\"em_analise_inicial\",\"data_mudanca\":\"2025-10-09T21:32:17.494282Z\",\"usuario_id\":11,\"justificativa\":\"Resposta fornecida: Em an\\u00e1lise\"},{\"status_anterior\":\"em_analise_inicial\",\"status_novo\":\"aguardando_informacoes_complementares\",\"data_mudanca\":\"2025-10-09T21:35:25.913417Z\",\"usuario_id\":11,\"justificativa\":\"Resposta fornecida: Estamos tratando do assunto\"},{\"status_anterior\":\"aguardando_informacoes_complementares\",\"status_novo\":\"em_analise_inicial\",\"data_mudanca\":\"2025-10-09T21:36:20.240645Z\",\"usuario_id\":11,\"justificativa\":\"Resposta fornecida: Em analise\"},{\"status_anterior\":\"em_analise_inicial\",\"status_novo\":\"em_investigacao\",\"data_mudanca\":\"2025-10-09T22:16:52.958668Z\",\"usuario_id\":11,\"justificativa\":\"Resposta fornecida: Estamos investigando\"}]','2025-10-08 20:56:10','2025-10-09 18:16:52',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('35','OUV2025650120',NULL,NULL,'reclamacao',NULL,NULL,NULL,NULL,'1','Teste Anônimo','Esta é uma manifestação anônima de teste',NULL,NULL,NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T21:09:53.103118Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 17:09:53','2025-10-08 17:09:53',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('36','OUV2025470241',NULL,NULL,'denuncia','infraestrutura','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','65999205608','0','Teste de manifestação','Teste de envio 002','Câmara M','Vereadores M',NULL,'recebida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T22:21:17.649188Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 18:21:17','2025-10-08 18:21:17',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('37','OUV2025073460',NULL,NULL,'elogio','administrativo','GISELE FERNANDA FRANCO DE ALMEIDA','gisele.fernanda.franco@gmail.com','65999887646','0','Imagem Vetorial sob Encomenda','Imagem Vetorial sob Encomenda','Câmara M','Vereadores M',NULL,'concluida',NULL,NULL,NULL,'2025-11-05',NULL,NULL,'Em andamento',NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-08T22:48:02.003922Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-08 18:48:02','2025-10-09 15:13:58',NULL);
INSERT INTO `ouvidoria_manifestacoes` (`id`,`protocolo`,`esic_usuario_id`,`ouvidor_responsavel_id`,`tipo`,`categoria`,`nome_manifestante`,`email_manifestante`,`telefone_manifestante`,`manifestacao_anonima`,`assunto`,`descricao`,`orgao_destinatario`,`setor_destinatario`,`categoria_esic`,`status`,`justificativa_status`,`data_mudanca_status`,`usuario_mudanca_status`,`prazo_resposta`,`prazo_prorrogado`,`justificativa_prorrogacao`,`resposta`,`respondida_em`,`respondida_por`,`avaliacao_atendimento`,`comentario_avaliacao`,`avaliada_em`,`prioridade`,`requer_resposta`,`informacao_sigilosa`,`observacoes_internas`,`ip_origem`,`user_agent`,`historico_status`,`historico_status_detalhado`,`created_at`,`updated_at`,`deleted_at`) VALUES ('38','OUV2025440711',NULL,NULL,'reclamacao','administrativo','Bruno Anderson Cruz de Almeida','financeiro@lideratecnologia.com.br','65998163769','0','Reclamação','Reclamação','Atendimento da camara','Secretaria',NULL,'nova',NULL,NULL,NULL,'2025-11-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'media','1','0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','[{\"status\":\"nova\",\"data\":\"2025-10-09T21:15:49.570530Z\",\"descricao\":\"Manifesta\\u00e7\\u00e3o criada pelo cidad\\u00e3o\"}]',NULL,'2025-10-09 17:15:49','2025-10-09 17:15:49',NULL);

--
-- Tabela: `ouvidoria_movimentacoes`
--
DROP TABLE IF EXISTS `ouvidoria_movimentacoes`;
CREATE TABLE `ouvidoria_movimentacoes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ouvidoria_manifestacao_id` bigint(20) unsigned NOT NULL,
  `usuario_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('aberta','em_analise','aguardando_informacoes','em_apuracao','respondida','procedente','improcedente','parcialmente_procedente','finalizada','arquivada','recebida','em_analise_inicial','aguardando_informacoes_complementares','encaminhada','em_investigacao','pendente_de_providencias','aguardando_parecer_tecnico','resposta_parcial','concluida','nao_acatada','redirecionada','em_mediacao','aguardando_prazo_legal','reaberta','em_recurso','suspensa','elogio_registrado','sugestao_em_analise','encerrada_sem_resposta') DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('1','17',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 14:18:27','127.0.0.1','2025-10-08 14:18:27','2025-10-08 14:18:27');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('2','26',NULL,'aberta','Manifestação criada pelo cidadão através do formulário web',NULL,'2025-10-08 14:31:58',NULL,'2025-10-08 14:31:58','2025-10-08 14:31:58');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('3','27',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 14:35:51','127.0.0.1','2025-10-08 14:35:51','2025-10-08 14:35:51');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('4','28',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 14:55:31','127.0.0.1','2025-10-08 14:55:31','2025-10-08 14:55:31');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('5','29',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 15:04:42',NULL,'2025-10-08 15:04:42','2025-10-08 15:04:42');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('6','30',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 16:07:04','127.0.0.1','2025-10-08 16:07:04','2025-10-08 16:07:04');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('7','31',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 16:22:51','127.0.0.1','2025-10-08 16:22:51','2025-10-08 16:22:51');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('8','32',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 16:41:51','127.0.0.1','2025-10-08 16:41:51','2025-10-08 16:41:51');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('9','33',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 16:54:07','127.0.0.1','2025-10-08 16:54:07','2025-10-08 16:54:07');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('10','35',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 17:09:53','127.0.0.1','2025-10-08 17:09:53','2025-10-08 17:09:53');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('11','36',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 18:21:17','127.0.0.1','2025-10-08 18:21:17','2025-10-08 18:21:17');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('12','37',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-08 18:48:02','127.0.0.1','2025-10-08 18:48:02','2025-10-08 18:48:02');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('13','34','11','reaberta','Teste de alteração via script',NULL,'2025-10-09 17:04:04',NULL,'2025-10-09 17:04:04','2025-10-09 17:04:04');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('14','38',NULL,'aberta','Manifestação recebida e registrada no sistema.',NULL,'2025-10-09 17:15:49','127.0.0.1','2025-10-09 17:15:49','2025-10-09 17:15:49');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('15','34','11','em_analise_inicial','Resposta fornecida: Em análise',NULL,'2025-10-09 17:32:17',NULL,'2025-10-09 17:32:17','2025-10-09 17:32:17');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('16','34','11','aguardando_informacoes_complementares','Resposta fornecida: Estamos tratando do assunto',NULL,'2025-10-09 17:35:25',NULL,'2025-10-09 17:35:25','2025-10-09 17:35:25');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('17','34','11','em_analise_inicial','Resposta fornecida: Em analise',NULL,'2025-10-09 17:36:20',NULL,'2025-10-09 17:36:20','2025-10-09 17:36:20');
INSERT INTO `ouvidoria_movimentacoes` (`id`,`ouvidoria_manifestacao_id`,`usuario_id`,`status`,`descricao`,`anexos`,`data_movimentacao`,`ip_usuario`,`created_at`,`updated_at`) VALUES ('18','34','11','em_investigacao','Resposta fornecida: Estamos investigando',NULL,'2025-10-09 18:16:53',NULL,'2025-10-09 18:16:53','2025-10-09 18:16:53');

--
-- Tabela: `paginas_conteudo`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paginas_conteudo` (`id`,`slug`,`titulo`,`descricao`,`conteudo`,`configuracoes`,`ativo`,`ordem`,`template`,`seo`,`created_at`,`updated_at`,`deleted_at`) VALUES ('1','historia','História da Câmara Municipal','Conheça a trajetória e evolução da nossa Câmara Municipal ao longo dos anos.','<div class=\"historia-content\">\n                    <h2>Nossa História</h2>\n                    <p>A Câmara Municipal tem uma rica história de representação democrática e serviço à comunidade. Desde sua fundação, tem sido o centro das decisões legislativas que moldam o desenvolvimento de nossa cidade.</p>\n                    \n                    <h3>Fundação e Primeiros Anos</h3>\n                    <p>Estabelecida com o objetivo de representar os interesses da população local, nossa Câmara Municipal iniciou suas atividades focada na criação de leis que promovessem o bem-estar social e o desenvolvimento econômico sustentável.</p>\n                    \n                    <h3>Marcos Importantes</h3>\n                    <ul>\n                        <li>Criação das primeiras leis municipais</li>\n                        <li>Implementação de políticas públicas inovadoras</li>\n                        <li>Modernização dos processos legislativos</li>\n                        <li>Digitalização e transparência dos dados públicos</li>\n                    </ul>\n                    \n                    <h3>Evolução Institucional</h3>\n                    <p>Ao longo dos anos, a Câmara Municipal evoluiu constantemente, adaptando-se às necessidades da população e incorporando novas tecnologias para melhor servir aos cidadãos.</p>\n                </div>',NULL,'1','1','default','{\"title\":\"Hist\\u00f3ria da C\\u00e2mara Municipal - Conhe\\u00e7a Nossa Trajet\\u00f3ria\",\"description\":\"Descubra a rica hist\\u00f3ria da C\\u00e2mara Municipal, seus marcos importantes e evolu\\u00e7\\u00e3o institucional ao longo dos anos.\",\"keywords\":\"hist\\u00f3ria, c\\u00e2mara municipal, trajet\\u00f3ria, evolu\\u00e7\\u00e3o, marcos hist\\u00f3ricos\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL);
INSERT INTO `paginas_conteudo` (`id`,`slug`,`titulo`,`descricao`,`conteudo`,`configuracoes`,`ativo`,`ordem`,`template`,`seo`,`created_at`,`updated_at`,`deleted_at`) VALUES ('2','estrutura','Estrutura Organizacional','Conheça a organização institucional e a estrutura administrativa da Câmara Municipal.','<div class=\"estrutura-content\">\n                    <h2>Estrutura Organizacional</h2>\n                    <p>A Câmara Municipal está organizada de forma a garantir eficiência, transparência e representatividade em todas as suas atividades legislativas e administrativas.</p>\n                    \n                    <h3>Mesa Diretora</h3>\n                    <p>Responsável pela direção dos trabalhos legislativos e pela administração da Câmara Municipal.</p>\n                    <ul>\n                        <li>Presidente da Câmara</li>\n                        <li>Vice-Presidente</li>\n                        <li>1º Secretário</li>\n                        <li>2º Secretário</li>\n                    </ul>\n                    \n                    <h3>Comissões Permanentes</h3>\n                    <p>Órgãos técnicos especializados que analisam as matérias de sua competência:</p>\n                    <ul>\n                        <li>Comissão de Constituição, Justiça e Redação</li>\n                        <li>Comissão de Finanças e Orçamento</li>\n                        <li>Comissão de Obras, Serviços Públicos e Meio Ambiente</li>\n                        <li>Comissão de Educação, Cultura e Assistência Social</li>\n                    </ul>\n                    \n                    <h3>Estrutura Administrativa</h3>\n                    <p>Setor responsável pelo apoio técnico e administrativo às atividades legislativas:</p>\n                    <ul>\n                        <li>Secretaria Geral</li>\n                        <li>Departamento Legislativo</li>\n                        <li>Departamento Administrativo</li>\n                        <li>Assessoria Jurídica</li>\n                        <li>Departamento de Comunicação</li>\n                    </ul>\n                </div>',NULL,'1','2','default','{\"title\":\"Estrutura Organizacional - C\\u00e2mara Municipal\",\"description\":\"Conhe\\u00e7a a organiza\\u00e7\\u00e3o institucional, mesa diretora, comiss\\u00f5es e estrutura administrativa da C\\u00e2mara Municipal.\",\"keywords\":\"estrutura, organiza\\u00e7\\u00e3o, mesa diretora, comiss\\u00f5es, administra\\u00e7\\u00e3o\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL);
INSERT INTO `paginas_conteudo` (`id`,`slug`,`titulo`,`descricao`,`conteudo`,`configuracoes`,`ativo`,`ordem`,`template`,`seo`,`created_at`,`updated_at`,`deleted_at`) VALUES ('3','regimento','Regimento Interno','Consulte as normas internas que regem o funcionamento da Câmara Municipal.','<div class=\"regimento-content\">\n                    <h2>Regimento Interno</h2>\n                    <p>O Regimento Interno estabelece as normas e procedimentos que regem o funcionamento da Câmara Municipal, garantindo ordem, transparência e eficiência nos trabalhos legislativos.</p>\n                    \n                    <h3>Disposições Gerais</h3>\n                    <p>O Regimento Interno da Câmara Municipal disciplina a organização, a direção dos trabalhos, a ordem dos debates e o processo de votação, bem como a polícia interna da Casa.</p>\n                    \n                    <h3>Principais Capítulos</h3>\n                    <ul>\n                        <li><strong>Capítulo I:</strong> Da Câmara Municipal e suas atribuições</li>\n                        <li><strong>Capítulo II:</strong> Da Mesa Diretora</li>\n                        <li><strong>Capítulo III:</strong> Das Comissões</li>\n                        <li><strong>Capítulo IV:</strong> Das Sessões</li>\n                        <li><strong>Capítulo V:</strong> Dos Projetos e Proposições</li>\n                        <li><strong>Capítulo VI:</strong> Da Votação</li>\n                        <li><strong>Capítulo VII:</strong> Da Disciplina e Polícia Interna</li>\n                    </ul>\n                    \n                    <h3>Sessões Ordinárias</h3>\n                    <p>As sessões ordinárias realizam-se conforme calendário estabelecido, seguindo a seguinte ordem:</p>\n                    <ol>\n                        <li>Abertura da sessão</li>\n                        <li>Verificação de presença</li>\n                        <li>Leitura da ata da sessão anterior</li>\n                        <li>Expediente</li>\n                        <li>Ordem do dia</li>\n                        <li>Explicações pessoais</li>\n                        <li>Encerramento</li>\n                    </ol>\n                    \n                    <h3>Acesso ao Regimento Completo</h3>\n                    <p>O texto completo do Regimento Interno está disponível para consulta pública e pode ser acessado através da Secretaria da Câmara ou solicitado via Lei de Acesso à Informação.</p>\n                </div>',NULL,'1','3','default','{\"title\":\"Regimento Interno - Normas da C\\u00e2mara Municipal\",\"description\":\"Consulte o regimento interno com as normas e procedimentos que regem o funcionamento da C\\u00e2mara Municipal.\",\"keywords\":\"regimento interno, normas, procedimentos, funcionamento, legislativo\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL);
INSERT INTO `paginas_conteudo` (`id`,`slug`,`titulo`,`descricao`,`conteudo`,`configuracoes`,`ativo`,`ordem`,`template`,`seo`,`created_at`,`updated_at`,`deleted_at`) VALUES ('4','missao','Missão, Visão e Valores','Conheça os princípios fundamentais que orientam as ações da Câmara Municipal.','<div class=\"missao-content\">\n                    <h2>Nossos Princípios Institucionais</h2>\n                    <p>A Câmara Municipal pauta suas ações em princípios sólidos que garantem uma atuação ética, transparente e comprometida com o bem-estar da população.</p>\n                    \n                    <div class=\"principio-box missao-box\">\n                        <h3>🎯 Nossa Missão</h3>\n                        <p>Exercer com excelência a função legislativa municipal, representando os interesses da população através da elaboração de leis justas e eficazes, fiscalizando o Poder Executivo e promovendo o desenvolvimento sustentável e a qualidade de vida dos cidadãos.</p>\n                    </div>\n                    \n                    <div class=\"principio-box visao-box\">\n                        <h3>🔭 Nossa Visão</h3>\n                        <p>Ser reconhecida como uma instituição legislativa moderna, transparente e eficiente, referência em participação democrática e inovação nos processos legislativos, contribuindo para o desenvolvimento de uma cidade próspera, justa e sustentável.</p>\n                    </div>\n                    \n                    <div class=\"principio-box valores-box\">\n                        <h3>⭐ Nossos Valores</h3>\n                        <ul>\n                            <li><strong>Transparência:</strong> Atuamos com clareza e abertura em todos os processos</li>\n                            <li><strong>Ética:</strong> Pautamos nossas ações pela integridade e honestidade</li>\n                            <li><strong>Responsabilidade:</strong> Assumimos o compromisso com o bem público</li>\n                            <li><strong>Participação:</strong> Valorizamos o envolvimento da sociedade nas decisões</li>\n                            <li><strong>Inovação:</strong> Buscamos constantemente melhorar nossos processos</li>\n                            <li><strong>Respeito:</strong> Tratamos todos com dignidade e consideração</li>\n                            <li><strong>Eficiência:</strong> Otimizamos recursos para maximizar resultados</li>\n                            <li><strong>Sustentabilidade:</strong> Promovemos o desenvolvimento responsável</li>\n                        </ul>\n                    </div>\n                    \n                    <h3>Compromisso com a Sociedade</h3>\n                    <p>Estes princípios orientam todas as nossas ações e decisões, garantindo que a Câmara Municipal cumpra seu papel constitucional de forma exemplar, sempre priorizando o interesse público e o bem-estar da comunidade.</p>\n                </div>',NULL,'1','4','default','{\"title\":\"Miss\\u00e3o, Vis\\u00e3o e Valores - C\\u00e2mara Municipal\",\"description\":\"Conhe\\u00e7a a miss\\u00e3o, vis\\u00e3o e valores que orientam as a\\u00e7\\u00f5es da C\\u00e2mara Municipal em prol da sociedade.\",\"keywords\":\"miss\\u00e3o, vis\\u00e3o, valores, princ\\u00edpios, \\u00e9tica, transpar\\u00eancia\"}','2025-09-26 07:52:04','2025-09-26 07:52:04',NULL);
INSERT INTO `paginas_conteudo` (`id`,`slug`,`titulo`,`descricao`,`conteudo`,`configuracoes`,`ativo`,`ordem`,`template`,`seo`,`created_at`,`updated_at`,`deleted_at`) VALUES ('5','histria-de-exemplolandia','História do Município de Exemplolândia','História do Município de Exemplolândia','<h2>🏞️ <strong>História e Geografia do Município de Exemplolândia</strong></h2><h3>🌅 <strong>História de Exemplolândia</strong></h3><p>O Município de <strong>Exemplolândia</strong> nasceu do espírito trabalhador e da união de seus primeiros habitantes, que chegaram à região no início do século XX em busca de terras férteis e novas oportunidades. Conta-se que o nome “Exemplolândia” foi escolhido por um grupo de colonos que desejavam fundar uma comunidade modelo — um <strong>exemplo</strong> de cooperação, progresso e harmonia entre os povos.</p><p>Os primeiros registros datam de <strong>1912</strong>, quando famílias vindas de várias regiões do país — sobretudo do interior de Minas Gerais e São Paulo — se estabeleceram às margens do <strong>Rio Esperança</strong>, atraídas pela abundância de água e pelas terras férteis. Com o passar dos anos, o pequeno povoado cresceu em torno de uma capela dedicada a <strong>São Benedito</strong>, santo padroeiro do município.</p><p>Durante a década de <strong>1940</strong>, Exemplolândia tornou-se um importante ponto comercial da região, graças à produção de café, milho e leite. Em <strong>1955</strong>, foi oficialmente elevada à categoria de município, emancipando-se do antigo distrito de Aurora das Veredas. Desde então, o município tem se destacado pela agricultura diversificada, pela hospitalidade de seu povo e pelo forte compromisso com a educação e o meio ambiente.</p><p>Hoje, Exemplolândia é reconhecida como uma cidade acolhedora, com qualidade de vida exemplar e um patrimônio cultural que mescla tradição e modernidade. Seu brasão, símbolo de orgulho municipal, representa a força do trabalho, a fertilidade da terra e a fé que une seus cidadãos.</p><p><br></p><h3>🌎 <strong>Geografia do Município de Exemplolândia</strong></h3><p>Exemplolândia está situada no <strong>centro-sul do estado de [coloque o estado fictício ou real, se desejar]</strong>, ocupando uma área aproximada de <strong>420 km²</strong>. O território é caracterizado por <strong>colinas suaves</strong>, <strong>vales férteis</strong> e uma <strong>vegetação de transição entre o cerrado e a mata atlântica</strong>, formando paisagens de rara beleza.</p><p>O município é banhado por dois importantes cursos d’água — o <strong>Rio Esperança</strong> e o <strong>Córrego das Flores</strong> — que, além de embelezarem a região, são fundamentais para o abastecimento e a irrigação agrícola. O clima predominante é o <strong>tropical de altitude</strong>, com verões chuvosos e invernos amenos e secos, apresentando temperatura média anual de <strong>21 °C</strong>.</p><p>As atividades econômicas principais são a <strong>agricultura familiar</strong>, com destaque para o cultivo de milho, café, soja e hortaliças, e a <strong>pecuária leiteira</strong>, além de um setor de <strong>turismo rural</strong> em expansão. A região também abriga pequenas indústrias de laticínios, móveis e produtos artesanais.</p><p>O município faz divisa com:</p><ul><li><strong>Norte:</strong> Santa Esperança</li><li><strong>Sul:</strong> Vale Verde</li><li><strong>Leste:</strong> Nova Harmonia</li><li><strong>Oeste:</strong> Campo Sereno</li></ul><p>A sede municipal está localizada a <strong>780 metros de altitude</strong>, oferecendo belas vistas panorâmicas da região. Entre seus pontos turísticos destacam-se o <strong>Mirante do Sol Dourado</strong>, a <strong>Cachoeira da Amizade</strong>, o <strong>Museu Histórico Municipal</strong> e a tradicional <strong>Feira da Colheita</strong>, realizada anualmente no mês de julho.</p><p><br></p><h3>🌻 <strong>Identidade e Orgulho</strong></h3><p>Mais que um nome, <strong>Exemplolândia</strong> representa o ideal de uma comunidade que valoriza o trabalho, a educação e o respeito à natureza. Seus moradores têm orgulho de preservar as tradições e, ao mesmo tempo, investir em inovação e desenvolvimento sustentável.</p><p>Com suas ruas arborizadas, praças bem cuidadas e um povo acolhedor, o município é, de fato, um <strong>exemplo de prosperidade e união</strong> — fiel ao seu nome e à sua história.</p>',NULL,'1','1','default','{\"title\":\"Hist\\u00f3ria e Geografia de Exemplol\\u00e2ndia \\u2013 Cultura, Natureza e Desenvolvimento do Munic\\u00edpio\",\"description\":\"Descubra a hist\\u00f3ria e a geografia de Exemplol\\u00e2ndia, um munic\\u00edpio acolhedor conhecido pela agricultura, belezas naturais e tradi\\u00e7\\u00e3o cultural. Saiba tudo sobre sua origem, clima, rios, economia e pontos tur\\u00edsticos.\",\"keywords\":\"Exemplol\\u00e2ndia, hist\\u00f3ria de Exemplol\\u00e2ndia, geografia de Exemplol\\u00e2ndia, munic\\u00edpio de Exemplol\\u00e2ndia, turismo, cultura, economia, clima, natureza\"}','2025-10-05 10:19:42','2025-10-05 10:19:42',NULL);

--
-- Tabela: `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Tabela: `permission_role`
--
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Tabela: `permission_user`
--
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_user_id_foreign` (`user_id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('116','11','11','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('117','11','12','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('118','11','13','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('119','11','14','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('120','11','15','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('121','11','16','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('122','11','17','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('123','11','18','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('124','11','19','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('125','11','20','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('126','11','29','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('127','11','30','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('128','11','31','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('129','11','32','2025-09-30 20:39:05','2025-09-30 20:39:05');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('130','11','33','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('131','11','34','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('132','11','35','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('133','11','36','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('134','11','37','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('135','11','38','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('136','11','39','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('137','11','40','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('138','11','41','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('139','11','42','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('140','11','43','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('141','11','44','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('142','11','45','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('143','11','46','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('144','11','47','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('145','11','48','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('146','11','49','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('147','11','50','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('148','11','51','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('149','11','52','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('150','11','53','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('151','11','54','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('152','11','55','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('153','11','56','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('154','11','57','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('155','11','58','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('156','11','59','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('157','11','60','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('158','11','61','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('159','11','62','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('160','11','63','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('161','11','64','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('162','11','65','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('163','11','66','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('164','11','67','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('165','11','68','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('166','11','69','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('167','11','70','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('168','11','71','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('169','11','72','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('170','11','73','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('171','11','74','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('172','11','75','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('173','11','76','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('174','11','77','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('175','11','78','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('176','11','79','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('177','11','80','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('178','11','81','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('179','11','82','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('180','11','83','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('181','11','84','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('182','11','85','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('183','11','86','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('184','11','87','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('185','11','88','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('186','11','89','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('187','11','90','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('188','11','91','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('189','11','92','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('190','11','93','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('191','11','94','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('192','11','95','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('193','11','96','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('194','11','97','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('195','11','98','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('196','11','99','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('197','11','100','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('198','11','101','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('199','11','102','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('200','11','103','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('201','11','104','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('202','11','105','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('203','11','106','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('204','11','107','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('205','11','108','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('206','11','109','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('207','11','110','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('208','11','111','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('209','11','112','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('210','11','113','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('211','11','114','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('212','11','115','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('213','11','116','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('214','11','117','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('215','11','118','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('216','11','119','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('217','11','120','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('218','11','121','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('219','11','122','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('220','11','123','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('221','11','124','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('222','11','125','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('223','11','126','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('224','11','127','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('225','11','128','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('226','11','129','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('227','11','130','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('228','11','131','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('229','11','132','2025-09-30 20:39:06','2025-09-30 20:39:06');
INSERT INTO `permission_user` (`id`,`user_id`,`permission_id`,`created_at`,`updated_at`) VALUES ('230','11','133','2025-09-30 20:39:07','2025-09-30 20:39:07');

--
-- Tabela: `permissions`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('11','esic.view',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('12','esic.respond',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('13','esic.manage',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('14','ouvidoria.view',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('15','ouvidoria.respond',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('16','ouvidoria.manage',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:19','2025-09-28 11:07:19');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('17','legislacao.view',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('18','legislacao.create',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('19','legislacao.edit',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('20','legislacao.approve',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('29','protocolo.view',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('30','protocolo.create',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('31','protocolo.manage',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('32','admin.dashboard',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('33','admin.config',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('34','admin.logs',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('35','system.roles',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('36','system.permissions',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('37','usuarios.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('38','usuarios.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('39','usuarios.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('40','usuarios.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('41','usuarios.impersonificar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('42','usuarios.gerenciar_roles',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('43','roles.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('44','roles.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('45','roles.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('46','roles.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('47','permissoes.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('48','permissoes.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('49','permissoes.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('50','permissoes.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('51','vereadores.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('52','vereadores.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('53','vereadores.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('54','vereadores.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('55','noticias.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('56','noticias.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('57','noticias.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('58','noticias.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('59','noticias.publicar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('60','sessoes.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('61','sessoes.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('62','sessoes.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('63','sessoes.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('64','documentos.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:22','2025-09-28 12:17:22');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('65','documentos.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('66','documentos.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('67','documentos.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('68','transparencia.listar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('69','transparencia.criar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('70','transparencia.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('71','transparencia.excluir',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('72','configuracoes.visualizar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('73','configuracoes.editar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('74','dashboard.acessar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('75','usuarios.visualizar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:40','2025-09-30 20:32:40');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('76','usuarios.gerenciar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:41','2025-09-30 20:32:41');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('77','admin.acesso',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:41','2025-09-30 20:32:41');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('78','admin.usuarios',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:41','2025-09-30 20:32:41');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('79','admin.configuracoes',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:41','2025-09-30 20:32:41');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('80','admin.relatorios',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:41','2025-09-30 20:32:41');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('81','permissoes.visualizar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:42','2025-09-30 20:32:42');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('82','permissoes.gerenciar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:42','2025-09-30 20:32:42');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('83','roles.visualizar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:42','2025-09-30 20:32:42');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('84','roles.gerenciar',NULL,NULL,NULL,NULL,'0','1','0','web','2025-09-30 20:32:42','2025-09-30 20:32:42');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('85','relatorios.visualizar','Visualizar relatórios','Visualizar relatórios',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('86','relatorios.gerar','Gerar relatórios','Gerar relatórios',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('87','noticias.visualizar','Visualizar notícias','Visualizar notícias',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('88','eventos.visualizar','Visualizar eventos','Visualizar eventos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('89','eventos.criar','Criar eventos','Criar eventos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('90','eventos.editar','Editar eventos','Editar eventos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('91','eventos.excluir','Excluir eventos','Excluir eventos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('92','leis.visualizar','Visualizar leis','Visualizar leis',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('93','leis.criar','Criar leis','Criar leis',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('94','leis.editar','Editar leis','Editar leis',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('95','leis.excluir','Excluir leis','Excluir leis',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('96','projetos_lei.visualizar','Visualizar projetos de lei','Visualizar projetos de lei',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('97','projetos_lei.criar','Criar projetos de lei','Criar projetos de lei',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('98','projetos_lei.editar','Editar projetos de lei','Editar projetos de lei',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('99','projetos_lei.excluir','Excluir projetos de lei','Excluir projetos de lei',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('100','vereadores.visualizar','Visualizar vereadores','Visualizar vereadores',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('101','sessoes.visualizar','Visualizar sessões','Visualizar sessões',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('102','contratos.visualizar','Visualizar contratos','Visualizar contratos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('103','contratos.criar','Criar contratos','Criar contratos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('104','contratos.editar','Editar contratos','Editar contratos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:31','2025-09-30 20:35:31');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('105','contratos.excluir','Excluir contratos','Excluir contratos',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('106','licitacoes.visualizar','Visualizar licitações','Visualizar licitações',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('107','licitacoes.criar','Criar licitações','Criar licitações',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('108','licitacoes.editar','Editar licitações','Editar licitações',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('109','licitacoes.excluir','Excluir licitações','Excluir licitações',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('110','receitas.visualizar','Visualizar receitas','Visualizar receitas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('111','receitas.criar','Criar receitas','Criar receitas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('112','receitas.editar','Editar receitas','Editar receitas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('113','receitas.excluir','Excluir receitas','Excluir receitas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('114','despesas.visualizar','Visualizar despesas','Visualizar despesas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('115','despesas.criar','Criar despesas','Criar despesas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('116','despesas.editar','Editar despesas','Editar despesas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('117','despesas.excluir','Excluir despesas','Excluir despesas',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('118','esic.visualizar','Visualizar solicitações ESIC','Visualizar solicitações ESIC',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('119','esic.responder','Responder solicitações ESIC','Responder solicitações ESIC',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('120','esic.gerenciar','Gerenciar ESIC','Gerenciar ESIC',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('121','ouvidoria.visualizar','Visualizar ouvidoria','Visualizar ouvidoria',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('122','ouvidoria.responder','Responder ouvidoria','Responder ouvidoria',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('123','ouvidoria.gerenciar','Gerenciar ouvidoria','Gerenciar ouvidoria',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('124','sistema.backup','Fazer backup do sistema','Fazer backup do sistema',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('125','sistema.logs','Visualizar logs do sistema','Visualizar logs do sistema',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('126','sistema.manutencao','Modo manutenção','Modo manutenção',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('127','*','Acesso total ao sistema','Acesso total ao sistema',NULL,NULL,'0','1','0','web','2025-09-30 20:35:32','2025-09-30 20:35:32');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('128','admin.acesso','Acesso à área administrativa','Acesso à área administrativa',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('129','admin.dashboard','Acesso ao dashboard','Acesso ao dashboard',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('130','usuarios.visualizar','Visualizar usuários','Visualizar usuários',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('131','usuarios.impersonificar','Impersonificar usuários','Impersonificar usuários',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('132','admin.usuarios','Gerenciar usuários','Gerenciar usuários',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `permissions` (`id`,`name`,`display_name`,`description`,`module`,`action`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('133','*','Acesso total','Acesso total',NULL,NULL,'0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');

--
-- Tabela: `projeto_lei_coautor`
--
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

INSERT INTO `projeto_lei_coautor` (`id`,`projeto_lei_id`,`vereador_id`,`created_at`,`updated_at`) VALUES ('1','1','2','2025-09-27 23:13:44','2025-09-27 23:13:44');
INSERT INTO `projeto_lei_coautor` (`id`,`projeto_lei_id`,`vereador_id`,`created_at`,`updated_at`) VALUES ('2','1','3','2025-09-27 23:13:44','2025-09-27 23:13:44');

--
-- Tabela: `projetos_lei`
--
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
  `protocolo_numero` varchar(255) DEFAULT NULL,
  `protocolo_ano` int(11) DEFAULT NULL,
  `protocolo_sequencial` int(11) DEFAULT NULL,
  `data_distribuicao` date DEFAULT NULL,
  `data_primeira_votacao` date DEFAULT NULL,
  `data_segunda_votacao` date DEFAULT NULL,
  `data_envio_executivo` date DEFAULT NULL,
  `data_retorno_executivo` date DEFAULT NULL,
  `data_veto` date DEFAULT NULL,
  `data_promulgacao` date DEFAULT NULL,
  `prazo_consulta_publica` int(11) DEFAULT NULL,
  `data_inicio_consulta` date DEFAULT NULL,
  `data_fim_consulta` date DEFAULT NULL,
  `participacao_cidada` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`participacao_cidada`)),
  `termometro_popular` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`termometro_popular`)),
  `impacto_orcamentario` decimal(15,2) DEFAULT NULL,
  `relatorio_impacto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`relatorio_impacto`)),
  `quorum_necessario` int(11) DEFAULT NULL,
  `votos_favoraveis` int(11) DEFAULT NULL,
  `votos_contrarios` int(11) DEFAULT NULL,
  `abstencoes` int(11) DEFAULT NULL,
  `ausencias` int(11) DEFAULT NULL,
  `resultado_primeira_votacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resultado_primeira_votacao`)),
  `resultado_segunda_votacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resultado_segunda_votacao`)),
  `motivo_veto` text DEFAULT NULL,
  `fundamentacao_veto` text DEFAULT NULL,
  `urgencia` tinyint(1) NOT NULL DEFAULT 0,
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `parecer_juridico` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `comite_iniciativa_popular_id` bigint(20) unsigned DEFAULT NULL,
  `parecer_tecnico` text DEFAULT NULL,
  `audiencias_publicas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`audiencias_publicas`)),
  `emendas_apresentadas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emendas_apresentadas`)),
  `substitutivos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`substitutivos`)),
  `historico_tramitacao` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`historico_tramitacao`)),
  `documentos_anexos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos_anexos`)),
  `consulta_publica_ativa` tinyint(1) NOT NULL DEFAULT 0,
  `permite_participacao_cidada` tinyint(1) NOT NULL DEFAULT 1,
  `exige_audiencia_publica` tinyint(1) NOT NULL DEFAULT 0,
  `exige_maioria_absoluta` tinyint(1) NOT NULL DEFAULT 0,
  `exige_dois_turnos` tinyint(1) NOT NULL DEFAULT 0,
  `bypass_executivo` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projetos_lei_numero_projeto_ano_tipo_unique` (`numero`,`ano`,`tipo`),
  UNIQUE KEY `projetos_lei_slug_unique` (`slug`),
  KEY `projetos_lei_autor_id_foreign` (`autor_id`),
  KEY `projetos_lei_status_legislatura_index` (`status`,`legislatura`),
  KEY `projetos_lei_tipo_ano_index` (`tipo`,`ano`),
  KEY `projetos_lei_categoria_index` (`categoria`),
  KEY `projetos_lei_comite_iniciativa_popular_id_foreign` (`comite_iniciativa_popular_id`),
  KEY `idx_protocolo_ano_tipo` (`protocolo_ano`,`tipo`),
  KEY `idx_status_data_protocolo` (`status`,`data_protocolo`),
  KEY `idx_consulta_publica_ativa` (`consulta_publica_ativa`),
  CONSTRAINT `projetos_lei_autor_id_foreign` FOREIGN KEY (`autor_id`) REFERENCES `vereadores` (`id`),
  CONSTRAINT `projetos_lei_comite_iniciativa_popular_id_foreign` FOREIGN KEY (`comite_iniciativa_popular_id`) REFERENCES `comite_iniciativa_populars` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('1','101','2024','projeto_lei','Institui o Programa Municipal de Coleta Seletiva','1012024-dispoe-sobre-a-criacao-do-programa-municipal-de-co','Dispõe sobre a criação do Programa Municipal de Coleta Seletiva de resíduos sólidos e dá outras providências.','Art. 1º Fica instituído o Programa Municipal de Coleta Seletiva...','1','vereador',NULL,NULL,NULL,'protocolado','2025-08-28',NULL,NULL,NULL,'A implementação da coleta seletiva é fundamental para a preservação do meio ambiente e para o desenvolvimento sustentável do município.',NULL,NULL,NULL,'Projeto em análise pela Comissão de Meio Ambiente',NULL,'\"meio ambiente,sustentabilidade,coleta seletiva\"','2024','PL101/2025','2025','101',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'2025-09-27 23:13:44','2025-09-28 15:49:00',NULL,NULL,NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-07-10 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"}]\"',NULL,'0','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('3','102','2024','projeto_lei','Cria o Programa de Auxílio Alimentar para Famílias em Situação de Vulnerabilidade','1022024-institui-o-programa-municipal-de-auxilio-alimentar','Institui o Programa Municipal de Auxílio Alimentar destinado às famílias em situação de vulnerabilidade social.','Art. 1º Fica instituído o Programa Municipal de Auxílio Alimentar...',NULL,'prefeito','Prefeito Municipal',NULL,NULL,'em_tramitacao','2025-07-29','2025-09-17',NULL,NULL,'É necessário criar mecanismos de apoio às famílias que se encontram em situação de insegurança alimentar.',NULL,NULL,NULL,'Projeto aprovado por unanimidade',NULL,'\"assist\\u00eancia social,alimenta\\u00e7\\u00e3o,vulnerabilidade\"','2024','PL102/2025','2025','102','2025-06-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-10','2025-07-07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0',NULL,'2025-09-27 23:27:13','2025-09-28 15:49:00',NULL,NULL,NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-05-22 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"},{\\\"data\\\":\\\"2025-06-21 15:49:00\\\",\\\"evento\\\":\\\"Em Tramita\\\\u00e7\\\\u00e3o\\\",\\\"descricao\\\":\\\"Projeto em tramita\\\\u00e7\\\\u00e3o nas comiss\\\\u00f5es\\\",\\\"responsavel\\\":\\\"Comiss\\\\u00e3o Competente\\\",\\\"status\\\":\\\"em_tramitacao\\\"}]\"',NULL,'1','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('4','103','2024','projeto_resolucao','Regulamenta o Funcionamento das Sessões Virtuais da Câmara Municipal','1032024-estabelece-normas-para-a-realizacao-de-sessoes-ord','Estabelece normas para a realização de sessões ordinárias e extraordinárias em formato virtual.','Art. 1º As sessões da Câmara Municipal poderão ser realizadas virtualmente...',NULL,'comissao','Comissão de Constituição e Justiça',NULL,NULL,'aprovado','2025-09-12','2025-08-01',NULL,NULL,'A modernização dos processos legislativos requer a regulamentação das sessões virtuais.',NULL,NULL,NULL,'Em análise pela Mesa Diretora',NULL,'\"moderniza\\u00e7\\u00e3o,tecnologia,sess\\u00f5es virtuais\"','2024','PL103/2025','2025','103',NULL,'2025-07-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'2025-09-27 23:27:13','2025-09-28 15:49:00',NULL,NULL,NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-07-29 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"},{\\\"data\\\":\\\"2025-08-01 15:49:00\\\",\\\"evento\\\":\\\"Aprovado\\\",\\\"descricao\\\":\\\"Projeto aprovado pelo plen\\\\u00e1rio\\\",\\\"responsavel\\\":\\\"Plen\\\\u00e1rio\\\",\\\"status\\\":\\\"aprovado\\\"}]\"',NULL,'0','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('5','104','2024','projeto_lei','Dispõe sobre a Criação de Ciclovias no Município','1042024-institui-o-plano-municipal-de-mobilidade-urbana-su','Institui o Plano Municipal de Mobilidade Urbana Sustentável com foco na criação de ciclovias.','Art. 1º Fica instituído o Plano Municipal de Mobilidade Urbana Sustentável...',NULL,'iniciativa_popular',NULL,NULL,NULL,'rejeitado','2025-08-13',NULL,NULL,NULL,'A mobilidade urbana sustentável é essencial para reduzir a poluição e melhorar a qualidade de vida.',NULL,NULL,NULL,'Projeto de iniciativa popular com 1.250 assinaturas válidas',NULL,'\"mobilidade urbana,ciclovias,sustentabilidade\"','2024','PL104/2025','2025','104',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'2025-09-27 23:28:22','2025-09-28 15:49:00',NULL,'1',NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-08-03 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"},{\\\"data\\\":\\\"2025-08-18 15:49:00\\\",\\\"evento\\\":\\\"Rejeitado\\\",\\\"descricao\\\":\\\"Projeto rejeitado pelos vereadores\\\",\\\"responsavel\\\":\\\"Plen\\\\u00e1rio\\\",\\\"status\\\":\\\"rejeitado\\\"}]\"',NULL,'0','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('6','105','2024','indicacao','Solicita Melhorias na Iluminação Pública do Bairro Centro','1052024-indica-ao-poder-executivo-a-necessidade-de-melhori','Indica ao Poder Executivo a necessidade de melhorias na iluminação pública do Bairro Centro.','Considerando a necessidade de melhorar a segurança pública...','2','vereador',NULL,NULL,NULL,'arquivado','2025-09-07',NULL,NULL,NULL,'A iluminação inadequada compromete a segurança dos munícipes.',NULL,NULL,NULL,'Encaminhado ao Executivo',NULL,'\"ilumina\\u00e7\\u00e3o p\\u00fablica,seguran\\u00e7a,infraestrutura\"','2024','PL105/2025','2025','105',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','0',NULL,'2025-09-27 23:28:22','2025-09-28 15:49:00',NULL,NULL,NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-05-01 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"},{\\\"data\\\":\\\"2025-05-17 15:49:00\\\",\\\"evento\\\":\\\"Arquivado\\\",\\\"descricao\\\":\\\"Projeto arquivado\\\",\\\"responsavel\\\":\\\"Mesa Diretora\\\",\\\"status\\\":\\\"arquivado\\\"}]\"',NULL,'0','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('7','106','2024','projeto_lei','Institui a Semana Municipal de Conscientização sobre Autismo','1062024-cria-a-semana-municipal-de-conscientizacao-sobre-o','Cria a Semana Municipal de Conscientização sobre o Transtorno do Espectro Autista.','Art. 1º Fica instituída a Semana Municipal de Conscientização sobre Autismo...',NULL,'comissao','Comissão de Saúde e Assistência Social',NULL,NULL,'protocolado','2025-06-29','2025-08-28',NULL,NULL,'É importante promover a conscientização e inclusão das pessoas com autismo.',NULL,NULL,NULL,'Lei sancionada pelo Prefeito',NULL,'\"inclus\\u00e3o,autismo,conscientiza\\u00e7\\u00e3o\"','2024','PL106/2025','2025','106',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'2025-09-27 23:28:22','2025-09-28 15:49:00',NULL,NULL,NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-04-21 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"}]\"',NULL,'0','1','0','0','0','0');
INSERT INTO `projetos_lei` (`id`,`numero`,`ano`,`tipo`,`titulo`,`slug`,`ementa`,`texto_integral`,`autor_id`,`tipo_autoria`,`autor_nome`,`dados_iniciativa_popular`,`coautores`,`status`,`data_protocolo`,`data_aprovacao`,`comissao_atual`,`tramitacao`,`justificativa`,`arquivo_original`,`arquivo_aprovado`,`votacoes`,`observacoes`,`categoria`,`tags`,`legislatura`,`protocolo_numero`,`protocolo_ano`,`protocolo_sequencial`,`data_distribuicao`,`data_primeira_votacao`,`data_segunda_votacao`,`data_envio_executivo`,`data_retorno_executivo`,`data_veto`,`data_promulgacao`,`prazo_consulta_publica`,`data_inicio_consulta`,`data_fim_consulta`,`participacao_cidada`,`termometro_popular`,`impacto_orcamentario`,`relatorio_impacto`,`quorum_necessario`,`votos_favoraveis`,`votos_contrarios`,`abstencoes`,`ausencias`,`resultado_primeira_votacao`,`resultado_segunda_votacao`,`motivo_veto`,`fundamentacao_veto`,`urgencia`,`destaque`,`parecer_juridico`,`created_at`,`updated_at`,`deleted_at`,`comite_iniciativa_popular_id`,`parecer_tecnico`,`audiencias_publicas`,`emendas_apresentadas`,`substitutivos`,`historico_tramitacao`,`documentos_anexos`,`consulta_publica_ativa`,`permite_participacao_cidada`,`exige_audiencia_publica`,`exige_maioria_absoluta`,`exige_dois_turnos`,`bypass_executivo`) VALUES ('8','107','2024','projeto_lei','Cria o Sistema Municipal de Parques Urbanos','1072024-institui-o-sistema-municipal-de-parques-urbanos-pa','Institui o Sistema Municipal de Parques Urbanos para preservação de áreas verdes e lazer.','Art. 1º Fica instituído o Sistema Municipal de Parques Urbanos...',NULL,'iniciativa_popular',NULL,NULL,NULL,'em_tramitacao','2025-09-02',NULL,NULL,NULL,'A criação de parques urbanos é fundamental para a qualidade de vida e preservação ambiental.',NULL,NULL,NULL,'Projeto de iniciativa popular com 2.100 assinaturas válidas',NULL,'\"parques,meio ambiente,lazer,qualidade de vida\"','2024','PL107/2025','2025','107','2025-08-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-05','2025-08-29',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'2025-09-27 23:28:22','2025-09-28 15:49:00',NULL,'2',NULL,NULL,NULL,NULL,'\"[{\\\"data\\\":\\\"2025-07-24 15:49:00\\\",\\\"evento\\\":\\\"Protocolo\\\",\\\"descricao\\\":\\\"Projeto de lei protocolado na C\\\\u00e2mara Municipal\\\",\\\"responsavel\\\":\\\"Secretaria Legislativa\\\",\\\"status\\\":\\\"protocolado\\\"},{\\\"data\\\":\\\"2025-08-16 15:49:00\\\",\\\"evento\\\":\\\"Em Tramita\\\\u00e7\\\\u00e3o\\\",\\\"descricao\\\":\\\"Projeto em tramita\\\\u00e7\\\\u00e3o nas comiss\\\\u00f5es\\\",\\\"responsavel\\\":\\\"Comiss\\\\u00e3o Competente\\\",\\\"status\\\":\\\"em_tramitacao\\\"}]\"',NULL,'1','1','0','0','0','0');

--
-- Tabela: `receitas`
--
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


--
-- Tabela: `role_has_permissions`
--
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('11','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('12','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('14','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('15','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('55','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','2');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('11','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('12','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('13','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('68','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('69','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('70','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('71','3');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('14','4');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('15','4');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('16','4');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','4');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('17','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('18','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('19','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('51','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('53','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('60','5');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('17','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('18','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('19','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('20','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('51','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('52','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('53','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('54','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('55','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('59','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('60','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('61','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('62','6');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','7');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('55','7');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','7');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','7');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('59','7');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('29','8');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('30','8');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('31','8');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','8');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('55','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('68','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('69','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('70','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('71','9');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('38','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('39','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('40','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('41','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('44','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('45','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('46','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('48','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('49','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('50','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('52','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('53','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('54','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('58','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('61','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('62','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('63','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('72','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('73','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('75','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('77','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('78','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('79','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('80','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('81','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('82','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('83','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('84','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('85','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('86','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('87','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('88','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('89','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('90','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('91','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('92','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('93','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('94','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('95','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('96','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('97','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('98','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('99','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('100','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('101','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('102','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('103','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('104','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('105','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('106','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('107','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('108','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('109','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('110','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('111','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('112','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('113','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('114','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('115','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('116','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('117','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('118','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('119','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('120','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('121','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('122','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('123','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('124','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('125','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('126','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('127','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('131','10');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('32','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('38','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('39','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('40','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('41','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('44','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('45','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('46','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('48','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('49','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('50','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('52','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('53','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('54','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('56','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('57','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('58','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('61','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('62','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('63','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('72','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('73','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('75','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('77','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('78','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('79','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('80','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('81','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('82','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('83','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('84','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('85','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('86','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('87','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('88','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('89','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('90','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('91','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('92','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('93','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('94','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('95','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('96','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('97','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('98','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('99','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('100','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('101','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('102','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('103','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('104','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('105','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('106','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('107','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('108','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('109','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('110','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('111','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('112','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('113','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('114','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('115','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('116','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('117','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('118','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('119','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('120','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('121','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('122','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('123','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('124','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('125','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('126','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('127','11');
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES ('131','11');

--
-- Tabela: `role_user`
--
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_user` (`id`,`user_id`,`role_id`,`created_at`,`updated_at`) VALUES ('3','11','12','2025-09-30 20:39:05','2025-09-30 20:39:05');

--
-- Tabela: `roles`
--
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('1','cidadao',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('2','secretario',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('3','responsavel_esic',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('4','ouvidor',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('5','vereador',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('6','presidente',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('7','editor',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('8','protocolo',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('9','contador',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 11:07:20','2025-09-28 11:07:20');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('10','admin','admin',NULL,'#6B7280','0','1','1','web','2025-09-28 11:07:20','2025-09-28 17:54:47');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('11','super-admin',NULL,NULL,'#6B7280','0','1','0','web','2025-09-28 12:17:23','2025-09-28 12:17:23');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('12','super-admin','Super Administrador','Acesso total ao sistema','#6B7280','0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');
INSERT INTO `roles` (`id`,`name`,`display_name`,`description`,`color`,`is_system`,`is_active`,`priority`,`guard_name`,`created_at`,`updated_at`) VALUES ('13','admin','Administrador','Administrador do sistema','#6B7280','0','1','0','','2025-09-30 20:37:28','2025-09-30 20:37:28');

--
-- Tabela: `sessao_projeto_lei`
--
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


--
-- Tabela: `sessao_vereador`
--
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


--
-- Tabela: `sessions`
--
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

INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('3uFSvGhxaYcZ3yV2PFS0fEbNLJYbYLJP8JLEuLvR',NULL,'186.194.48.218','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR0NGTENCMTRGbDg4SEZxc1hqU0xhRFE4aDZscm1FQlFXYzk0UzRxZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovL2xpZGVyYS5hcHAuYnIvYWRtaW4vaGVyby1jb25maWcvZWRpdCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vbGlkZXJhLmFwcC5ici90aGVtZS5jc3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19','1760303564');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('3YWEKuJHiBETTxCXhXwI31w4gmjs5AV6d6ILFG3a',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWhvN0RXaG5CWThoWDRJSDBYVEl0ZnQ1Y3pNMEtkZnp0T043Y0RPTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760300777');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('4hJXsoxhYzGWjsjgw22nvQGYIFwheGx8bx6QroAY',NULL,'87.120.191.84','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiV1FHVHh2TkFPazd3UGZpQ2hTUmZjT3dEMDM4MFNteEdub0t5Z3UwNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760298496');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('bQm2qSHfllvWAZkOUWVqZMJy11PPynnQcduDcRaI',NULL,'3.130.96.91','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiemoxNXl4RkJ2YmpNa0piVTIxYkZsbFVNb3BKS2JVSEJHWjdyZ1ZxdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760298342');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('DAl4taB1P2hQaFHjc6MlzVBkUculXUkvfAZusZGj',NULL,'87.120.191.84','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiRVYzTlk0WmZFNFhNZ2E0aktpTVNGbG1aN29MQnNqeDFRVlZDWTliZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760297231');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('Fzq1Z3kAyKc7tcgiBG0pSLTcgL2QwyCestksE5s1',NULL,'167.94.138.179','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiakVqMW1jWUNhYk5oV0lqd2R3b3VOaWJpZXNRRWJEUkNRRXR4enFqVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760302544');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('GEKIMVm6TdfdQb7iiU2eTLPG36Ue9Dox7jnvNVWx',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUURtNXlla3hyUWZHYTRhOE5MQk9ST3pWWW5WY0p1WU5vR21BRjdKTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760298462');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('HsnYc6EqQZwvcmbkFcShu9f6xfA16ND4T0v5Cubv',NULL,'87.120.191.91','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiWE5qeUU0OHNVcGxSSVpDT0szeG5WcHBUZ3BTbkFiNHR4RXNYSmVGNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760298447');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('KA0LNTSOkDEHnLFJ8ERiEiE7Tzh8NlQyo5ptHnVX',NULL,'198.199.79.166','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0ZDWFpYVUE0WWRNRlpqd09hSTJSQVFFNk9Ydnp0eENFMFRUaVEyUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760298596');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('ni0BxUQzO5PAJ8wAsC6RsvUGHC5XIcrUN2pPrl45',NULL,'87.120.191.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoia3RnblRXTU93SnN5aWNtZkRvN01YRUF4UkhRbXVpQlNQWmwyWEVnaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760305113');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('oNCsqpuWglXnVsl9EqiIF680NsF7PjjToRJ6e3xA',NULL,'204.76.203.212','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoidkU5SzBCajQ3QmlobFV3VmpkSFhoZFBESnFTMURHMEYzajJ0T1BsVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760302075');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('pnQe8JIhpFJhTH0Zk8dO7DIFpC6zGoki4XMs4CxB',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUY0WEl6VFhWamNZU2hnVWZBR2NmZHYwYXpPZ0F2ajR5Qmt4QjRUbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760303177');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('PXJpeFytHXClvt7FoVttoUI8MzL9no8Ph70JKHFY',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieThIOXNlVDV4WlZIVUVMb0U2eEJOa3M0bWIzdUowVklpUHZET2ZxTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760293766');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('QSelaFz0NY0MgWE16Dmitk01kuke1koYZgsnPiV8',NULL,'147.185.132.189','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHZaS1BZNG9XV09xQ3paTHVmMWFrS1VFMWFFTFNpbnRsOWhvVXFKZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTQ6Imh0dHA6Ly8wLjAuMC4wIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760303096');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('WEgiqkARVCZYbeD5K7zhb220ay3BXNR1iypfL4Wg',NULL,'192.159.99.162','Hello World','YTozOntzOjY6Il90b2tlbiI7czo0MDoiemd1S2ZxbVVCQXJDc09xRFQ4MW5DZzUyTWJiY2Z5SjFmbkhFVzFjeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760297974');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('WM6TkvOwfQ8m8CHZdzF3rUj2XC1drN4jHE372zDi',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.100.3 Chrome/132.0.6834.210 Electron/34.5.1 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnppanJDSVBYT3A5aENLdmNsY0g3UVltc2RseWl6cUIwbENvUTVUVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODA5Mi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Nzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODA5Mi9hZG1pbi9oZXJvLWNvbmZpZz9pZGVfd2Vidmlld19yZXF1ZXN0X3RpbWU9MTc2MDMwMjQzNzY1MCI7fX0=','1760302439');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('xHCVAbxq1Q5mCHdayaCK4xPsVjA5uClYyZH6E4gO','11','201.71.169.240','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSnFtWXRRazhnaFVjRjZITkRVRnpobjVqWUtmUkNrTEc3aWVaeTBidSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9saWRlcmEuYXBwLmJyL2NhbGVuZGFyaW8vbWluaT9hbm89MjAyNSZtZXM9MTAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==','1760303715');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('XU7Ro0gNbztbV446OqOzC5ouP7uGBF0pyAMX6AlU',NULL,'87.121.84.101','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVc0eFpqU2VUTDFFMTNndGh3UzA3dUg0VTltSE80Q3ZPRGRpT3FKcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760296109');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('Y26eb3PzygQVfzeY2zqyZ0fefy0nikb9tzr9Q6a6',NULL,'204.76.203.219','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiMjkyVXdjMjNMdTJwYTZrWTM2UENpNTdpWWxHcDhZRGlheVlkZUdtayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==','1760300371');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('Zgg1LVbMmIMQrp4UJQ3I6DYB2m4ebC6BcV3h81og',NULL,'134.209.86.24','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/118.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRllaQXZDQU5qaEtFdWN6WjNiQWxqT1FGMnY3M3VERzlCMDFldGxpNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760300327');
INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('znSo36K6zcZkSUGn66q07w0RJ58giFor9ESUkBNf',NULL,'204.76.203.211','Hello World/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNllvTWZYaktDcGFmSUV4MnlRbEhUa1FXY1dIZFJtcFhucHJRNEl3QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xODYuMTk0LjQ4LjIxOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=','1760296100');

--
-- Tabela: `sessoes`
--
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

INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('1','001/2024','ordinaria','1','2024-02-05','19:00:00','21:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Primeira sessão do ano legislativo de 2024','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example1','youtube','https://img.youtube.com/vi/example1/maxresdefault.jpg',NULL,'1ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-02-05 19:00:00',NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('2','002/2024','ordinaria','1','2024-02-19','19:00:00','20:45:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão de projetos de lei municipais','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example2','youtube','https://img.youtube.com/vi/example2/maxresdefault.jpg',NULL,'2ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-02-19 19:00:00',NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('3','003/2024','extraordinaria','2','2024-03-01','14:00:00','16:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Sessão especial para aprovação do orçamento','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example3','youtube','https://img.youtube.com/vi/example3/maxresdefault.jpg',NULL,'Sessão Extraordinária - Orçamento Municipal 2024','1','2024-03-01 14:00:00',NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('4','004/2024','ordinaria','1','2024-03-18','19:00:00','21:15:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Votação de projetos em segunda discussão','2024','0',NULL,'2025-09-26 08:29:43','2025-09-26 08:29:43',NULL,'https://www.youtube.com/watch?v=example4','youtube','https://img.youtube.com/vi/example4/maxresdefault.jpg',NULL,'4ª Sessão Ordinária de 2024 - Câmara Municipal','1','2024-03-18 19:00:00',NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('5','005/2024','solene','3','2024-04-22','10:00:00','12:00:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Sessão comemorativa ao Dia do Descobrimento do Brasil','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('6','006/2024','ordinaria','1','2024-05-06','19:00:00','20:30:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão sobre obras públicas municipais','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('7','007/2024','ordinaria','1','2024-05-20','19:00:00','21:45:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Prestação de contas do primeiro quadrimestre','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL);
INSERT INTO `sessoes` (`id`,`numero_sessao`,`tipo`,`tipo_sessao_id`,`data_sessao`,`hora_inicio`,`hora_fim`,`status`,`pauta`,`ata`,`local`,`presencas`,`votacoes`,`arquivo_ata`,`arquivo_audio`,`arquivo_video`,`observacoes`,`legislatura`,`transmissao_online`,`link_transmissao`,`created_at`,`updated_at`,`deleted_at`,`video_url`,`plataforma_video`,`thumbnail_url`,`duracao_video`,`descricao_video`,`video_disponivel`,`data_gravacao`,`presidente_id`,`secretario_id`) VALUES ('8','008/2024','extraordinaria','2','2024-06-10','15:00:00','17:20:00','finalizada',NULL,NULL,'Plenário da Câmara Municipal',NULL,NULL,NULL,NULL,NULL,'Discussão e votação do novo Plano Diretor','2024','0',NULL,'2025-09-26 08:29:44','2025-09-27 13:17:06',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL);

--
-- Tabela: `slides`
--
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

INSERT INTO `slides` (`id`,`titulo`,`descricao`,`imagem`,`link`,`nova_aba`,`ordem`,`ativo`,`velocidade`,`transicao`,`direcao`,`created_at`,`updated_at`) VALUES ('1','Transparência e Participação','Acompanhe as atividades da Câmara Municipal e participe das decisões que afetam nossa cidade.','https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/transparencia','0','1','1','5','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');
INSERT INTO `slides` (`id`,`titulo`,`descricao`,`imagem`,`link`,`nova_aba`,`ordem`,`ativo`,`velocidade`,`transicao`,`direcao`,`created_at`,`updated_at`) VALUES ('2','Conheça Nossos Vereadores','Representantes eleitos trabalhando pelo desenvolvimento e bem-estar da população.','https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/vereadores','0','2','1','4','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');
INSERT INTO `slides` (`id`,`titulo`,`descricao`,`imagem`,`link`,`nova_aba`,`ordem`,`ativo`,`velocidade`,`transicao`,`direcao`,`created_at`,`updated_at`) VALUES ('3','Sessões da Câmara','Assista às sessões ao vivo e acompanhe as discussões sobre projetos de lei e políticas públicas.','https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/sessoes','0','3','1','6','fade','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');
INSERT INTO `slides` (`id`,`titulo`,`descricao`,`imagem`,`link`,`nova_aba`,`ordem`,`ativo`,`velocidade`,`transicao`,`direcao`,`created_at`,`updated_at`) VALUES ('4','Portal da Transparência','Acesse informações sobre gastos públicos, contratos e prestação de contas da administração.','https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=400&fit=crop&crop=center','#','1','4','1','5','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');
INSERT INTO `slides` (`id`,`titulo`,`descricao`,`imagem`,`link`,`nova_aba`,`ordem`,`ativo`,`velocidade`,`transicao`,`direcao`,`created_at`,`updated_at`) VALUES ('5','Ouvidoria Municipal','Canal direto para sugestões, reclamações e elogios. Sua voz é importante para nós.','https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=400&fit=crop&crop=center','https://camara.lidera.srv.br/ouvidoria','0','5','1','4','slide','ltr','2025-09-26 07:52:24','2025-09-26 07:52:24');

--
-- Tabela: `themes`
--
DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `primary_color` varchar(255) NOT NULL DEFAULT '#6f42c1',
  `secondary_color` varchar(255) NOT NULL DEFAULT '#e83e8c',
  `accent_color` varchar(255) DEFAULT NULL,
  `primary_dark` varchar(255) DEFAULT NULL,
  `light` varchar(255) DEFAULT NULL,
  `border` varchar(255) DEFAULT NULL,
  `text_muted` varchar(255) DEFAULT NULL,
  `success_bg` varchar(255) DEFAULT NULL,
  `success_text` varchar(255) DEFAULT NULL,
  `info_bg` varchar(255) DEFAULT NULL,
  `info_text` varchar(255) DEFAULT NULL,
  `warning_bg` varchar(255) DEFAULT NULL,
  `warning_text` varchar(255) DEFAULT NULL,
  `danger_bg` varchar(255) DEFAULT NULL,
  `danger_text` varchar(255) DEFAULT NULL,
  `secondary_bg` varchar(255) DEFAULT NULL,
  `secondary_text` varchar(255) DEFAULT NULL,
  `menu_bg` varchar(255) DEFAULT NULL,
  `footer_bg` varchar(255) DEFAULT NULL,
  `section_bg` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_scheduled` tinyint(1) NOT NULL DEFAULT 0,
  `ribbon_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `ribbon_variant` varchar(255) DEFAULT NULL,
  `ribbon_campaign_label` varchar(255) DEFAULT NULL,
  `ribbon_campaign_link_url` varchar(255) DEFAULT NULL,
  `ribbon_campaign_link_external` tinyint(1) NOT NULL DEFAULT 0,
  `ribbon_label` varchar(255) DEFAULT NULL,
  `ribbon_link_url` varchar(255) DEFAULT NULL,
  `ribbon_link_external` tinyint(1) NOT NULL DEFAULT 0,
  `ribbon_primary` varchar(255) DEFAULT NULL,
  `ribbon_base` varchar(255) DEFAULT NULL,
  `ribbon_stroke` varchar(255) DEFAULT NULL,
  `mourning_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `ribbon_mourning_label` varchar(255) DEFAULT NULL,
  `ribbon_mourning_link_url` varchar(255) DEFAULT NULL,
  `ribbon_mourning_link_external` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('1','Outubro Rosa','outubro-rosa','#e83e8c','#ff6fa8','#d63384','#1e3a5f','#f8f9fa','#e9ecef','#6c757d','#d1e7dd','#0f5132','#cff4fc','#055160','#fff3cd','#664d03','#f8d7da','#842029','#e2e3e5','#41464b','linear-gradient(135deg, #e83e8c 0%, #ff6fa8 100%)','linear-gradient(135deg, #e83e8c 0%, #ff6fa8 100%)','#fff0f6','2025-10-01','2025-10-31','0','1','1',NULL,'Outubro Rosa',NULL,'0',NULL,NULL,'0','#000000','#000000','#000000','1','Luto Oficial por Luiz da Silva',NULL,'0','2025-10-11 09:47:05','2025-10-12 13:46:38');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('2','Novembro Azul','novembro-azul','#007bff','#0056b3','#0d6efd','#1e3a5f','#f8f9fa','#e9ecef','#6c757d','#d1e7dd','#0f5132','#cff4fc','#055160','#fff3cd','#664d03','#f8d7da','#842029','#e2e3e5','#41464b','linear-gradient(135deg, #007bff 0%, #0056b3 100%)','linear-gradient(135deg, #007bff 0%, #0056b3 100%)','#f0f7ff','2025-11-01','2025-11-30','0','1','1',NULL,NULL,NULL,'0',NULL,NULL,'0','#000000','#000000','#000000','0',NULL,NULL,'0','2025-10-11 09:47:05','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('3','Setembro Amarelo','setembro-amarelo','#ffc107','#e0a800','#ffcd39','#1e3a5f','#f8f9fa','#e9ecef','#6c757d','#d1e7dd','#0f5132','#cff4fc','#055160','#fff3cd','#664d03','#f8d7da','#842029','#e2e3e5','#41464b','linear-gradient(135deg, #ffc107 0%, #e0a800 100%)','linear-gradient(135deg, #ffc107 0%, #e0a800 100%)','#fff9e6','2025-09-01','2025-09-30','0','1','1',NULL,NULL,NULL,'0',NULL,NULL,'0','#000000','#000000','#000000','0',NULL,NULL,'0','2025-10-11 09:47:05','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('4','Natal','natal','#dc3545','#28a745','#c82333','#1e3a5f','#f8f9fa','#e9ecef','#6c757d','#d1e7dd','#0f5132','#cff4fc','#055160','#fff3cd','#664d03','#f8d7da','#842029','#e2e3e5','#41464b','linear-gradient(135deg, #dc3545 0%, #28a745 100%)','linear-gradient(135deg, #dc3545 0%, #28a745 100%)','#fff5f5','2025-12-01','2025-12-31','0','1','1',NULL,NULL,NULL,'0',NULL,NULL,'0','#000000','#000000','#000000','0',NULL,NULL,'0','2025-10-11 09:47:05','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('5','Padrão Verde','padrao-verde','#28a745','#20c997','#2ecc71',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'linear-gradient(135deg, #28a745 0%, #20c997 100%)','linear-gradient(135deg, #28a745 0%, #20c997 100%)','#f3fff6',NULL,NULL,'0','0','0',NULL,NULL,NULL,'0',NULL,NULL,'0',NULL,NULL,NULL,'0',NULL,NULL,'0','2025-10-12 10:26:56','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('6','Padrão Vermelho','padrao-vermelho','#dc3545','#c82333','#ff4d4f',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'linear-gradient(135deg, #dc3545 0%, #c82333 100%)','linear-gradient(135deg, #dc3545 0%, #c82333 100%)','#fff5f5',NULL,NULL,'0','0','0',NULL,NULL,NULL,'0',NULL,NULL,'0',NULL,NULL,NULL,'0',NULL,NULL,'0','2025-10-12 10:26:56','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('7','Padrão Azul','padrao-azul','#0d6efd','#0b5ed7','#1e90ff',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%)','linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%)','#f0f7ff',NULL,NULL,'0','0','0',NULL,NULL,NULL,'0',NULL,NULL,'0',NULL,NULL,NULL,'0',NULL,NULL,'0','2025-10-12 10:26:56','2025-10-12 10:26:56');
INSERT INTO `themes` (`id`,`name`,`slug`,`primary_color`,`secondary_color`,`accent_color`,`primary_dark`,`light`,`border`,`text_muted`,`success_bg`,`success_text`,`info_bg`,`info_text`,`warning_bg`,`warning_text`,`danger_bg`,`danger_text`,`secondary_bg`,`secondary_text`,`menu_bg`,`footer_bg`,`section_bg`,`start_date`,`end_date`,`is_active`,`is_scheduled`,`ribbon_enabled`,`ribbon_variant`,`ribbon_campaign_label`,`ribbon_campaign_link_url`,`ribbon_campaign_link_external`,`ribbon_label`,`ribbon_link_url`,`ribbon_link_external`,`ribbon_primary`,`ribbon_base`,`ribbon_stroke`,`mourning_enabled`,`ribbon_mourning_label`,`ribbon_mourning_link_url`,`ribbon_mourning_link_external`,`created_at`,`updated_at`) VALUES ('8','Padrão Luto','padrao-luto','#000000','#343a40','#212529',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'linear-gradient(135deg, #000000 0%, #343a40 100%)','linear-gradient(135deg, #000000 0%, #343a40 100%)','#f8f9fa',NULL,NULL,'0','0','1','mourning_black',NULL,NULL,'0',NULL,NULL,'0',NULL,NULL,NULL,'0',NULL,NULL,'0','2025-10-12 10:26:56','2025-10-12 10:26:56');

--
-- Tabela: `tipo_contratos`
--
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


--
-- Tabela: `tipo_sessaos`
--
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

INSERT INTO `tipo_sessaos` (`id`,`nome`,`slug`,`descricao`,`cor`,`icone`,`ativo`,`ordem`,`created_at`,`updated_at`,`deleted_at`) VALUES ('1','Sessão Ordinária','sessao-ordinaria','Sessões regulares realizadas conforme calendário oficial da Câmara Municipal.','#3b82f6','fas fa-calendar-alt','1','1','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);
INSERT INTO `tipo_sessaos` (`id`,`nome`,`slug`,`descricao`,`cor`,`icone`,`ativo`,`ordem`,`created_at`,`updated_at`,`deleted_at`) VALUES ('2','Sessão Extraordinária','sessao-extraordinaria','Sessões especiais convocadas para tratar de assuntos urgentes ou específicos.','#ef4444','fas fa-exclamation-triangle','1','2','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);
INSERT INTO `tipo_sessaos` (`id`,`nome`,`slug`,`descricao`,`cor`,`icone`,`ativo`,`ordem`,`created_at`,`updated_at`,`deleted_at`) VALUES ('3','Sessão Solene','sessao-solene','Sessões cerimoniais para homenagens, outorga de títulos e eventos especiais.','#8b5cf6','fas fa-award','1','3','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);
INSERT INTO `tipo_sessaos` (`id`,`nome`,`slug`,`descricao`,`cor`,`icone`,`ativo`,`ordem`,`created_at`,`updated_at`,`deleted_at`) VALUES ('4','Audiência Pública','audiencia-publica','Sessões abertas para participação e manifestação da população sobre temas específicos.','#10b981','fas fa-users','1','4','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);
INSERT INTO `tipo_sessaos` (`id`,`nome`,`slug`,`descricao`,`cor`,`icone`,`ativo`,`ordem`,`created_at`,`updated_at`,`deleted_at`) VALUES ('5','Sessão Especial','sessao-especial','Sessões temáticas ou comemorativas sobre assuntos de interesse público.','#f59e0b','fas fa-star','1','5','2025-09-26 07:52:14','2025-09-26 07:52:14',NULL);

--
-- Tabela: `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','cidadao','secretario','vereador','presidente','funcionario') DEFAULT 'cidadao',
  `cargo` varchar(255) DEFAULT NULL,
  `setor` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(255) DEFAULT NULL,
  `terms_accepted_at` timestamp NULL DEFAULT NULL,
  `privacy_accepted_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `rg` varchar(255) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `profissao` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `titulo_eleitor` varchar(255) DEFAULT NULL,
  `zona_eleitoral` varchar(255) DEFAULT NULL,
  `secao_eleitoral` varchar(255) DEFAULT NULL,
  `status_verificacao` varchar(255) DEFAULT NULL,
  `motivo_rejeicao` text DEFAULT NULL,
  `verificado_em` datetime DEFAULT NULL,
  `verificado_por` bigint(20) unsigned DEFAULT NULL,
  `pode_assinar` tinyint(1) NOT NULL DEFAULT 0,
  `pode_criar_comite` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`),
  UNIQUE KEY `users_titulo_eleitor_unique` (`titulo_eleitor`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('2','Teste Cidadão Atualizado','secretario@camara.gov.br','(11) 88888-8888','1990-01-01','Rua Teste Atualizada, 456',NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:52',NULL,NULL,NULL,'$2y$12$v6v04JXI0DUH7CfCiNC2G.AhKTEM5f9xiZt8uKaCiU5jyPrTLd7We',NULL,'2025-09-26 07:12:31','2025-09-30 12:36:21','12345678900','12.345.678-9',NULL,'M','solteiro','Desenvolvedor',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('3','Maria Oliveira Costa','editor@camara.gov.br',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:53',NULL,NULL,NULL,'$2y$12$aNMhTd2FfMREIpaevs.Rj.ufiozjicgaoh/d.PNIcKc6NMtwzzS4W',NULL,'2025-09-26 07:12:32','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('4','Carlos Eduardo Pereira','carlos.pereira@camara.gov.br',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:54',NULL,NULL,NULL,'$2y$12$0ib07maSdnrEzDm4IdRlru3WdlmAOSevXgd12noRJsU.eBJYQ0P8u',NULL,'2025-09-26 07:12:33','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('5','Ana Paula Rodrigues','ana.rodrigues@camara.gov.br',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:54',NULL,NULL,NULL,'$2y$12$RPmXMQ2GfePbxlN7YGOly.8mhEsOcOcxqFqijPhHQOX6EpbNdb3NK',NULL,'2025-09-26 07:12:33','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('6','José da Silva','jose.silva@email.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:55',NULL,NULL,NULL,'$2y$12$21cg74RenX9Rnbjs/bHklOXGCmMRqVsZCM7uOuRGNyQylSS1xYwq6',NULL,'2025-09-26 07:12:34','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('7','Pedro Santos Oliveira','pedro.santos@email.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:56',NULL,NULL,NULL,'$2y$12$SNptL/uqFzqnP3BnTqIrV.ARqKIboeFbj4rNJgUNz0qZJACxJJ7Vi',NULL,'2025-09-26 07:12:35','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('8','Fernanda Lima Costa','esic@camara.gov.br',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-26 07:51:57',NULL,NULL,NULL,'$2y$12$O.IpGVBEWC0ND9fo8cPkTe5emZigWfCZj9zTQk/pUsDog7.4EGwki',NULL,'2025-09-26 07:12:36','2025-09-28 20:41:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('11','Administrador do Sistema','admin@camara.gov.br',NULL,NULL,NULL,NULL,'admin',NULL,NULL,NULL,'1','2025-09-26 07:51:51',NULL,NULL,NULL,'$2y$12$Y7G6UzpbYUaPIiYNb./h.OHwrsFSx1w0HN4a78A3FpWEsgG0AaEj2',NULL,'2025-09-26 07:20:44','2025-09-30 10:36:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('12','BRUNO ANDERSON CRUZ DE ALMEIDA','brunoanderson1@gmail.com','(65) 99920-5908','1986-05-10','Condomínio Rio Cachoeirinha, 480, Condomínio Rio Cachoeirinha - Jardim Imperial, Cuiabá/MT - CEP: 78075905',NULL,'cidadao','Professor Licenciatura','Educação','Professor Licenciatura','1','2025-09-28 09:12:15',NULL,'2025-09-28 09:11:21','2025-09-28 09:11:21','$2y$12$Y7G6UzpbYUaPIiYNb./h.OHwrsFSx1w0HN4a78A3FpWEsgG0AaEj2','ryj961P2O5beNiZwdPWAzI3B9WkXfhoB1qzyUB9kIpnXumaxWq0sO301MDEe','2025-09-28 09:11:21','2025-09-30 19:59:08','00807569135','15801462',NULL,'M','casado','Lenhador','6599205608','(65) 99920-5908','78075905','Condomínio Rio Cachoeirinha','480','Condomínio Rio Cachoeirinha','Jardim Imperial','Cuiabá','MT','560000000012','0034','0012','verificado',NULL,'2025-09-30 05:45:50','12','1','1');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('14','Teste Usuario','teste@teste.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1','2025-09-29 11:33:45',NULL,NULL,NULL,'$2y$12$7JavCfcoUih39V4LSZiJEuvNHqMmu7/a6bFGmGZW5BDoofwYGNodW',NULL,'2025-09-29 11:33:46','2025-09-29 11:59:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('15','João Silva Santos','cidadao_6@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$YECb5RWKMEqLZoB2p5tUCuBC.jxW4Fz08OKSfnkxjh67JXh2anYra',NULL,'2025-09-29 11:48:17','2025-09-29 11:48:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('16','Maria Oliveira Costa','cidadao_14@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$AHAzxXsBYQA6zqKzmKmDoujvwoN7u48ImvdqKb3V4pttEKaLN4Uqm',NULL,'2025-09-29 11:48:18','2025-09-29 11:48:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('17','Carlos Eduardo Pereira','cidadao_15@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$vpvu6PwzR/9Ikv7ntVimEeUurKLgpUStC1bT2NTpI7.m//th7Rh5K',NULL,'2025-09-29 11:48:19','2025-09-29 11:48:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('18','Ana Paula Rodrigues','cidadao_16@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$N1qId6VjBk3qy1146AANSOUGeiIL72CNTrr3YrrJ.JAnNVf/aKhwe',NULL,'2025-09-29 11:48:20','2025-09-29 11:48:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('19','José da Silva','cidadao_17@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$dm215YN34dOOEUaS9x/t/u6cGCrrpmAoZxBJke.C0YgL4wNm9TUvO',NULL,'2025-09-29 11:48:21','2025-09-29 11:48:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('20','Pedro Santos Oliveira','cidadao_18@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$tjQqaRRR6xF/EUUvgDqIZOqCcbvfWSikl3lXTdSI52KAkrbXvk7BC',NULL,'2025-09-29 11:48:21','2025-09-29 11:48:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('21','Fernanda Lima Costa','cidadao_19@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$WwUEECttEz/IP9eLgv1/Reh.n1wI7rgNpRB.TjKtMW2cEOZXcyQG2',NULL,'2025-09-29 11:48:23','2025-09-29 11:48:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('22','BRUNO ANDERSON CRUZ DE ALMEIDA','cidadao_20@temp.com',NULL,NULL,NULL,NULL,'cidadao',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,'$2y$12$wu4fHJNk9uu1iTGfonfNw./VqjWrxdz.G6mSq9Re4tLNJeAwm7NDu',NULL,'2025-09-29 11:48:24','2025-09-29 11:48:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('24','Secretário Teste','secretario@teste.com',NULL,NULL,NULL,NULL,'secretario',NULL,NULL,NULL,'1','2025-09-29 12:01:44',NULL,NULL,NULL,'$2y$12$ePH1R9QiLdLCZVn8ieu0zebf.DNipE2P133XquskB7jmZs5wQPw0K',NULL,'2025-09-29 12:01:44','2025-09-29 12:01:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('25','Vereador Teste','vereador@teste.com',NULL,NULL,NULL,NULL,'vereador',NULL,NULL,NULL,'1','2025-09-29 12:01:44',NULL,NULL,NULL,'$2y$12$VtcZc3MiU0nM2FE7XIT6SOd/A04wnlC8wW7yFAp2ajvLA6fBbXIVC',NULL,'2025-09-29 12:01:44','2025-09-29 12:01:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('26','Presidente Teste','presidente@teste.com',NULL,NULL,NULL,NULL,'presidente',NULL,NULL,NULL,'1','2025-09-29 12:01:45',NULL,NULL,NULL,'$2y$12$3PKfE9tNYyepqFw3ccMSOuw./iJ7w06iG4kaH73/B1nqNc3SE5Toe',NULL,'2025-09-29 12:01:45','2025-09-29 12:01:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('27','Funcionário Teste','funcionario@teste.com',NULL,NULL,NULL,NULL,'funcionario',NULL,NULL,NULL,'1','2025-09-29 12:01:45',NULL,NULL,NULL,'$2y$12$JT5B3SjNQQJTysiRt5py0uUth86ccqo.Yxz55EptiwcNkRbARXxTK',NULL,'2025-09-29 12:01:45','2025-09-29 12:01:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('29','Admin Teste','admin@teste.com',NULL,NULL,NULL,NULL,'admin',NULL,NULL,NULL,'1','2025-10-01 08:05:45',NULL,NULL,NULL,'$2y$12$.zm40Av4XLF9UBYoHiaXSu3Dk7AsixBFzgkBSIvIUyizW3nF5xj2y',NULL,'2025-10-01 08:05:45','2025-10-01 08:05:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');
INSERT INTO `users` (`id`,`name`,`email`,`phone`,`birth_date`,`address`,`last_login_at`,`role`,`cargo`,`setor`,`observacoes`,`active`,`email_verified_at`,`email_verification_token`,`terms_accepted_at`,`privacy_accepted_at`,`password`,`remember_token`,`created_at`,`updated_at`,`cpf`,`rg`,`data_nascimento`,`sexo`,`estado_civil`,`profissao`,`telefone`,`celular`,`cep`,`endereco`,`numero`,`complemento`,`bairro`,`cidade`,`estado`,`titulo_eleitor`,`zona_eleitoral`,`secao_eleitoral`,`status_verificacao`,`motivo_rejeicao`,`verificado_em`,`verificado_por`,`pode_assinar`,`pode_criar_comite`) VALUES ('30','Admin','admin@test.com',NULL,NULL,NULL,NULL,'admin',NULL,NULL,NULL,'1','2025-10-03 10:32:32',NULL,NULL,NULL,'$2y$12$DIj0AxkOzOfWVKChhDa35eRdyUBZKx2EFszJhHhRh2g53otCTEaF2',NULL,'2025-10-03 10:32:32','2025-10-03 10:32:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0');

--
-- Tabela: `vereadores`
--
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
  `presidente_inicio` date DEFAULT NULL,
  `presidente_fim` date DEFAULT NULL,
  `vice_inicio` date DEFAULT NULL,
  `vice_fim` date DEFAULT NULL,
  `redes_sociais` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`redes_sociais`)),
  `proposicoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vereadores_email_unique` (`email`),
  KEY `vereadores_status_legislatura_index` (`status`,`legislatura`),
  KEY `vereadores_partido_index` (`partido`),
  KEY `vereadores_presidente_index` (`presidente`,`presidente_inicio`,`presidente_fim`),
  KEY `vereadores_vice_index` (`vice_presidente`,`vice_inicio`,`vice_fim`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('1','Carlos Eduardo Pereira','Vereador Carlos Pereira','PSDB','carlos.pereira@camara.gov.br','11966666666','Formado em Administração Pública, Carlos Eduardo Pereira tem 15 anos de experiência em gestão municipal. Durante seu mandato, tem focado em projetos de educação, saúde pública e desenvolvimento urbano sustentável. Atualmente exerce a função de Presidente da Câmara Municipal.','vereadores/twETWBqZyEcmw1JaovfPbUajo0pnjvcgqafV0JuT.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-educacao\"]','1','0','2023-01-01',NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorcarlospereira\",\"instagram\":\"@vereadorcarlospereira\",\"twitter\":\"@carlospereira_vr\"}','PL 001/2021 - Programa Municipal de Alfabetização Digital; PL 015/2022 - Criação de Centros de Saúde Comunitários; PL 028/2023 - Incentivo ao Transporte Sustentável','2025-09-26 07:51:57','2025-10-04 20:56:52');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('2','Ana Paula Rodrigues','Vereadora Ana Paula','PT','ana.rodrigues@camara.gov.br','11955555555','Assistente Social com mestrado em Políticas Sociais, Ana Paula Rodrigues é uma defensora incansável dos direitos das mulheres e das políticas de inclusão social. Atua há 12 anos no terceiro setor.','vereadores/hej8WnkXcxY14JBJY9ARAJttomrF8wsTtck322RZ.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-direitos-humanos\",\"comissao-saude\"]','0','1',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadoraanapaula\",\"instagram\":\"@vereadoraanapaula\",\"linkedin\":\"ana-paula-rodrigues-vereadora\"}','PL 008/2021 - Casa de Apoio à Mulher Vítima de Violência; PL 022/2022 - Programa Municipal de Capacitação Profissional Feminina; PL 035/2023 - Creches Noturnas para Mães Trabalhadoras','2025-09-26 07:51:57','2025-10-04 19:45:15');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('3','Roberto Silva Mendes','Vereador Roberto Mendes','MDB','roberto.mendes@camara.gov.br','11911111111','Empresário do setor de construção civil, Roberto Silva Mendes dedica-se às questões de infraestrutura urbana e desenvolvimento econômico do município.','vereadores/DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-obras\",\"comissao-financas\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorrobertomendes\",\"instagram\":\"@robertomendes_vereador\"}','PL 012/2021 - Modernização da Infraestrutura Viária; PL 025/2022 - Incentivos para Pequenas Empresas Locais; PL 031/2023 - Programa de Construção Sustentável','2025-09-26 07:51:57','2025-10-04 19:44:48');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('4','Maria José Santos','Vereadora Maria José','PDT','maria.santos@camara.gov.br','11922222222','Professora aposentada com 30 anos de magistério, Maria José Santos é especialista em educação infantil e políticas educacionais. Dedica seu mandato à melhoria da qualidade do ensino público municipal.','vereadores/HmhYgfIQsJWWRnqPQCEwpYwjmNFpZqd2kfHPKx76.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-educacao\",\"comissao-cultura\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadoramariajose\",\"instagram\":\"@mariajose_vereadora\"}','PL 005/2021 - Ampliação do Ensino Integral; PL 018/2022 - Biblioteca Comunitária em Cada Bairro; PL 029/2023 - Programa de Alfabetização de Adultos','2025-09-26 07:51:57','2025-10-04 19:46:08');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('5','João Batista Lima','Vereador João Batista','PP','joao.lima@camara.gov.br','11933333333','Agricultor familiar e líder comunitário, João Batista Lima representa os interesses da zona rural do município. Atua na defesa da agricultura sustentável e do desenvolvimento rural.','vereadores/vBGzozsuYtHK9iBt2AVGUMpXPqKgPzQ7ODYIWx5w.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-agricultura\",\"comissao-meio-ambiente\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorjoaobatista\",\"instagram\":\"@joaobatista_rural\"}','PL 007/2021 - Incentivo à Agricultura Familiar; PL 020/2022 - Programa de Reflorestamento Municipal; PL 033/2023 - Centro de Comercialização de Produtos Rurais','2025-09-26 07:51:57','2025-10-04 17:18:46');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('6','Fernanda Costa','Vereadora Fernanda','PSOL','fernanda.costa@camara.gov.br','11944444444','Advogada especializada em direitos humanos e ativista social. Fernanda Costa luta pelos direitos da juventude, LGBTQIA+ e pela transparência na gestão pública.','vereadores/eKP4DKFR6QpbI7aAHf8hBYvzbe7r1yvhzQKjvhsr.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-direitos-humanos\",\"comissao-juventude\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorafernanda\",\"instagram\":\"@fernanda_vereadora\",\"twitter\":\"@fernandacosta_vr\"}','PL 010/2021 - Centro de Referência LGBTQIA+; PL 024/2022 - Programa Jovem Empreendedor; PL 037/2023 - Portal da Transparência Cidadã','2025-09-26 07:51:57','2025-10-04 19:45:43');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('7','Antônio Carlos Oliveira','Vereador Antônio Carlos','PL','antonio.oliveira@camara.gov.br','11977777777','Ex-policial militar e especialista em segurança pública. Antônio Carlos Oliveira dedica seu mandato às questões de segurança urbana, trânsito e proteção civil.','vereadores/DdDzgBV2pOe9MjSEwpLI5yzigKKtauH1zN0EiTvD.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-seguranca\",\"comissao-transito\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorantoniocarlos\",\"instagram\":\"@antoniocarlos_seguranca\",\"linkedin\":\"antonio-carlos-oliveira-vereador\"}','PL 003/2021 - Ampliação do Sistema de Videomonitoramento; PL 016/2022 - Programa Ronda Escolar; PL 030/2023 - Central de Emergências Integrada','2025-09-26 07:51:57','2025-10-04 12:33:38');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('8','Patrícia Almeida','Vereadora Patrícia','REPUBLICANOS','patricia.almeida@camara.gov.br','11988888888','Enfermeira com especialização em saúde pública. Patrícia Almeida atua na defesa da saúde municipal, com foco na atenção básica e na saúde da mulher e da criança.','vereadores/aALyKggvX2gsx2luzFLCUOOrlcW9pytjIU9kPDZx.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-saude\",\"comissao-assistencia-social\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadorapatricia\",\"instagram\":\"@patricia_saude\"}','PL 006/2021 - Ampliação das UBS; PL 019/2022 - Programa Saúde da Mulher; PL 032/2023 - Centro de Especialidades Médicas','2025-09-26 07:51:57','2025-10-04 19:46:33');
INSERT INTO `vereadores` (`id`,`nome`,`nome_parlamentar`,`partido`,`email`,`telefone`,`biografia`,`foto`,`data_nascimento`,`profissao`,`escolaridade`,`endereco`,`observacoes`,`status`,`inicio_mandato`,`fim_mandato`,`legislatura`,`comissoes`,`presidente`,`vice_presidente`,`presidente_inicio`,`presidente_fim`,`vice_inicio`,`vice_fim`,`redes_sociais`,`proposicoes`,`created_at`,`updated_at`) VALUES ('9','Marcos Vinícius Silva','Vereador Marcos Vinícius','UNIÃO','marcos.silva@camara.gov.br','11999999999','Jovem empreendedor e especialista em tecnologia. Marcos Vinícius Silva trabalha pela modernização da gestão pública e pelo desenvolvimento da economia digital no município.','vereadores/ULdkMYGZM7lGCgQ0pm4ai487lTsqFVQlarGODusa.png',NULL,NULL,NULL,NULL,NULL,'ativo','2021-01-01','2024-12-31','2021','[\"comissao-tecnologia\",\"comissao-desenvolvimento-economico\"]','0','0',NULL,NULL,NULL,NULL,'{\"facebook\":\"https:\\/\\/facebook.com\\/vereadormarcosvinicius\",\"instagram\":\"@marcosvinicius_tech\",\"twitter\":\"@marcosvinicius_vr\",\"linkedin\":\"marcos-vinicius-silva-vereador\"}','PL 004/2021 - Cidade Inteligente Digital; PL 017/2022 - Hub de Inovação Municipal; PL 034/2023 - Programa de Inclusão Digital para Idosos','2025-09-26 07:51:57','2025-10-04 17:23:21');

SET FOREIGN_KEY_CHECKS=1;
