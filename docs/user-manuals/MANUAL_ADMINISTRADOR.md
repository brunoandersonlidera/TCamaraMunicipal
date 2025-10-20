# Manual do Usuário Administrador - TCamaraMunicipal

## Bem-vindo ao Sistema TCamaraMunicipal

Este manual foi desenvolvido para orientar administradores no uso completo do sistema de gestão da Câmara Municipal. Como administrador, você tem acesso total às funcionalidades do sistema e é responsável pela configuração e manutenção da plataforma.

## Índice

1. [Primeiros Passos](#primeiros-passos)
2. [Painel Administrativo](#painel-administrativo)
3. [Gestão de Usuários](#gestão-de-usuários)
4. [Gestão de Notícias](#gestão-de-notícias)
5. [Gestão de Vereadores](#gestão-de-vereadores)
6. [Gestão de Sessões](#gestão-de-sessões)
7. [Gestão de Projetos de Lei](#gestão-de-projetos-de-lei)
8. [Gestão de Documentos](#gestão-de-documentos)
9. [Sistema e-SIC](#sistema-e-sic)
10. [Ouvidoria](#ouvidoria)
11. [Licitações](#licitações)
12. [Relatórios](#relatórios)
13. [Configurações do Sistema](#configurações-do-sistema)
14. [Backup e Segurança](#backup-e-segurança)
15. [Solução de Problemas](#solução-de-problemas)

## Primeiros Passos

### Acesso ao Sistema

1. **URL de Acesso:** `https://seudominio.gov.br/admin`
2. **Credenciais:** Use suas credenciais de administrador
3. **Autenticação em Duas Etapas:** Se habilitada, insira o código do seu aplicativo autenticador

### Primeiro Login

Após o primeiro login, recomendamos:

1. **Alterar a senha padrão**
   - Acesse: `Perfil > Alterar Senha`
   - Use uma senha forte (mínimo 8 caracteres, maiúsculas, minúsculas, números e símbolos)

2. **Configurar 2FA (Recomendado)**
   - Acesse: `Perfil > Segurança > Autenticação em Duas Etapas`
   - Use aplicativos como Google Authenticator ou Authy

3. **Verificar configurações iniciais**
   - Acesse: `Configurações > Geral`
   - Configure informações básicas da câmara

## Painel Administrativo

### Visão Geral do Dashboard

O painel principal apresenta:

#### Métricas Principais
- **Usuários Ativos:** Número de usuários logados nas últimas 24h
- **Notícias Publicadas:** Total de notícias no mês atual
- **Solicitações e-SIC:** Pendentes e em andamento
- **Ouvidoria:** Manifestações recebidas

#### Gráficos e Estatísticas
- **Acessos ao Site:** Visitantes únicos por dia/semana/mês
- **Conteúdo Mais Acessado:** Páginas e notícias populares
- **Atividade dos Usuários:** Login e ações por tipo de usuário

#### Ações Rápidas
- **Nova Notícia:** Criar notícia rapidamente
- **Nova Sessão:** Agendar sessão da câmara
- **Backup Manual:** Executar backup do sistema
- **Relatório Rápido:** Gerar relatórios básicos

### Navegação

#### Menu Principal
```
📊 Dashboard
👥 Usuários
📰 Notícias
🏛️ Vereadores
📋 Sessões
📜 Projetos de Lei
📄 Documentos
🔍 e-SIC
📢 Ouvidoria
💼 Licitações
📊 Relatórios
⚙️ Configurações
```

#### Barra Superior
- **Notificações:** Alertas do sistema e pendências
- **Perfil:** Acesso rápido às configurações pessoais
- **Logout:** Sair do sistema com segurança

## Gestão de Usuários

### Tipos de Usuário

O sistema suporta os seguintes tipos:

1. **Administrador Geral**
   - Acesso total ao sistema
   - Gerencia todos os usuários
   - Configura o sistema

2. **Secretário/Assessor**
   - Gerencia conteúdo
   - Acesso a relatórios
   - Não altera configurações

3. **Responsável e-SIC**
   - Gerencia solicitações de informação
   - Acesso a documentos públicos
   - Relatórios de transparência

4. **Ouvidor**
   - Gerencia ouvidoria
   - Responde manifestações
   - Relatórios de ouvidoria

5. **Vereador**
   - Acesso ao próprio perfil
   - Visualiza sessões e projetos
   - Área restrita

6. **Editor**
   - Cria e edita notícias
   - Gerencia conteúdo público
   - Sem acesso administrativo

### Criando Usuários

1. **Acesse:** `Usuários > Novo Usuário`

2. **Preencha os dados:**
   ```
   Nome Completo: [Nome do usuário]
   Email: [email@dominio.gov.br]
   CPF: [000.000.000-00]
   Tipo de Usuário: [Selecione o tipo]
   Status: [Ativo/Inativo]
   ```

3. **Configurações de Acesso:**
   - **Senha Temporária:** Sistema gera automaticamente
   - **Forçar Troca:** Usuário deve alterar no primeiro login
   - **2FA Obrigatório:** Para usuários administrativos

4. **Permissões Específicas:**
   - Marque módulos específicos que o usuário pode acessar
   - Configure permissões granulares se necessário

### Gerenciando Usuários Existentes

#### Visualizar Lista
- **Filtros:** Por tipo, status, último acesso
- **Busca:** Por nome, email ou CPF
- **Ordenação:** Por qualquer coluna

#### Editar Usuário
1. Clique no ícone de edição (✏️)
2. Modifique os dados necessários
3. Salve as alterações

#### Resetar Senha
1. Acesse o perfil do usuário
2. Clique em "Resetar Senha"
3. Nova senha será enviada por email

#### Desativar/Ativar Usuário
- **Desativar:** Remove acesso sem deletar dados
- **Ativar:** Restaura acesso do usuário

### Auditoria de Usuários

#### Log de Atividades
- **Acessos:** Data/hora de login e logout
- **Ações:** Todas as ações realizadas no sistema
- **IPs:** Endereços de acesso
- **Dispositivos:** Informações do navegador/dispositivo

#### Relatórios de Usuários
- **Usuários Ativos:** Por período
- **Últimos Acessos:** Identificar usuários inativos
- **Ações por Usuário:** Produtividade e uso

## Gestão de Notícias

### Criando Notícias

1. **Acesse:** `Notícias > Nova Notícia`

2. **Informações Básicas:**
   ```
   Título: [Título da notícia]
   Resumo: [Breve descrição - opcional]
   Categoria: [Selecione a categoria]
   Tags: [palavras-chave separadas por vírgula]
   ```

3. **Conteúdo:**
   - Use o editor WYSIWYG para formatação
   - Adicione imagens, links e vídeos
   - Utilize estilos consistentes

4. **Configurações de Publicação:**
   ```
   Status: [Rascunho/Publicado/Agendado]
   Data de Publicação: [Imediata ou agendada]
   Destaque: [Marcar como notícia de destaque]
   Autor: [Selecionado automaticamente]
   ```

5. **Imagem de Destaque:**
   - Tamanho recomendado: 1200x630px
   - Formatos aceitos: JPG, PNG, WebP
   - Tamanho máximo: 2MB

### Editor de Conteúdo

#### Ferramentas Disponíveis
- **Formatação:** Negrito, itálico, sublinhado
- **Listas:** Numeradas e com marcadores
- **Links:** Internos e externos
- **Imagens:** Upload e galeria
- **Tabelas:** Criação e formatação
- **Código:** Blocos de código
- **Citações:** Blocos de citação

#### Boas Práticas
1. **Títulos:** Use hierarquia (H1, H2, H3)
2. **Parágrafos:** Mantenha textos concisos
3. **Imagens:** Sempre adicione texto alternativo
4. **Links:** Use textos descritivos
5. **SEO:** Otimize título e resumo

### Gerenciando Notícias

#### Lista de Notícias
- **Filtros:** Status, categoria, autor, data
- **Busca:** Por título ou conteúdo
- **Ações em Massa:** Publicar, despublicar, deletar

#### Estados das Notícias
1. **Rascunho:** Não visível publicamente
2. **Publicado:** Visível no site
3. **Agendado:** Será publicado automaticamente
4. **Arquivado:** Removido da listagem pública

#### Moderação
- **Revisão:** Antes da publicação
- **Aprovação:** Workflow de aprovação
- **Histórico:** Versões e alterações

### Categorias e Tags

#### Gerenciar Categorias
1. **Acesse:** `Notícias > Categorias`
2. **Criar Nova:**
   ```
   Nome: [Nome da categoria]
   Slug: [url-amigavel]
   Descrição: [Descrição opcional]
   Cor: [Cor para identificação]
   ```

#### Gerenciar Tags
- **Criação Automática:** Ao digitar no campo tags
- **Gerenciamento:** `Notícias > Tags`
- **Fusão:** Unir tags similares

## Gestão de Vereadores

### Cadastro de Vereadores

1. **Acesse:** `Vereadores > Novo Vereador`

2. **Dados Pessoais:**
   ```
   Nome Completo: [Nome do vereador]
   Nome Parlamentar: [Nome usado na câmara]
   CPF: [000.000.000-00]
   RG: [00.000.000-0]
   Data de Nascimento: [DD/MM/AAAA]
   ```

3. **Dados Políticos:**
   ```
   Partido: [Sigla do partido]
   Mandato Início: [DD/MM/AAAA]
   Mandato Fim: [DD/MM/AAAA]
   Situação: [Ativo/Licenciado/Afastado]
   ```

4. **Contato:**
   ```
   Email: [email@camara.gov.br]
   Telefone: [(00) 0000-0000]
   Celular: [(00) 00000-0000]
   Endereço: [Endereço completo]
   ```

5. **Informações Adicionais:**
   ```
   Biografia: [Texto sobre o vereador]
   Foto: [Upload da foto oficial]
   Redes Sociais: [Links para redes sociais]
   ```

### Gestão de Mandatos

#### Situações do Mandato
- **Ativo:** Exercendo o mandato normalmente
- **Licenciado:** Afastado temporariamente
- **Afastado:** Afastado por determinação
- **Suplente:** Assumiu vaga de titular

#### Histórico de Mandatos
- Registre todos os mandatos do vereador
- Mantenha histórico de licenças e afastamentos
- Documente mudanças de partido

### Comissões

#### Criar Comissões
1. **Acesse:** `Vereadores > Comissões > Nova Comissão`
2. **Preencha:**
   ```
   Nome: [Nome da comissão]
   Tipo: [Permanente/Temporária/CPI]
   Objetivo: [Finalidade da comissão]
   Data Criação: [DD/MM/AAAA]
   Data Encerramento: [DD/MM/AAAA - se aplicável]
   ```

#### Gerenciar Membros
- **Presidente:** Vereador que preside
- **Vice-Presidente:** Substituto do presidente
- **Membros:** Lista de vereadores participantes
- **Suplentes:** Vereadores suplentes

## Gestão de Sessões

### Tipos de Sessão

1. **Ordinária:** Sessões regulares da câmara
2. **Extraordinária:** Sessões especiais
3. **Solene:** Sessões comemorativas
4. **Secreta:** Sessões reservadas

### Criando Sessões

1. **Acesse:** `Sessões > Nova Sessão`

2. **Informações Básicas:**
   ```
   Tipo: [Ordinária/Extraordinária/Solene/Secreta]
   Número: [Número sequencial]
   Data: [DD/MM/AAAA]
   Hora Início: [HH:MM]
   Hora Fim: [HH:MM - estimativa]
   ```

3. **Local e Transmissão:**
   ```
   Local: [Plenário/Outro local]
   Transmissão: [Sim/Não]
   Link Transmissão: [URL se aplicável]
   ```

4. **Pauta:**
   - Adicione itens da pauta
   - Ordene por prioridade
   - Anexe documentos relacionados

### Ordem do Dia

#### Estrutura Padrão
1. **Abertura:** Verificação de quórum
2. **Expediente:** Comunicações e correspondências
3. **Ordem do Dia:** Projetos em votação
4. **Explicações Pessoais:** Manifestações dos vereadores
5. **Encerramento:** Fechamento da sessão

#### Gerenciar Pauta
- **Adicionar Item:** Projetos, requerimentos, moções
- **Reordenar:** Arraste itens para reorganizar
- **Anexar Documentos:** PDFs relacionados aos itens
- **Observações:** Notas sobre cada item

### Ata da Sessão

#### Durante a Sessão
1. **Registrar Presença:** Marque vereadores presentes
2. **Anotar Ocorrências:** Eventos importantes
3. **Registrar Votações:** Resultado de cada votação
4. **Tempo Real:** Atualize conforme a sessão acontece

#### Após a Sessão
1. **Revisar Ata:** Verifique todas as informações
2. **Anexar Documentos:** Adicione documentos apresentados
3. **Publicar:** Torne a ata disponível publicamente
4. **Arquivo:** Mantenha cópia em arquivo

### Transmissão ao Vivo

#### Configuração
1. **Plataforma:** YouTube, Facebook, site próprio
2. **Equipamentos:** Câmeras, microfones, streaming
3. **Teste:** Sempre teste antes da sessão
4. **Backup:** Tenha plano B para problemas técnicos

#### Durante a Transmissão
- **Monitor:** Acompanhe qualidade do stream
- **Chat:** Modere comentários se necessário
- **Gravação:** Mantenha gravação local
- **Problemas:** Tenha suporte técnico disponível

## Gestão de Projetos de Lei

### Tipos de Projeto

1. **Projeto de Lei:** Propostas de novas leis
2. **Projeto de Resolução:** Normas internas da câmara
3. **Projeto de Decreto Legislativo:** Atos específicos
4. **Emenda:** Modificações a projetos existentes
5. **Substitutivo:** Substitui projeto original

### Cadastro de Projetos

1. **Acesse:** `Projetos > Novo Projeto`

2. **Identificação:**
   ```
   Tipo: [Projeto de Lei/Resolução/Decreto]
   Número: [Número sequencial do ano]
   Ano: [AAAA]
   Autor: [Vereador autor]
   Data Apresentação: [DD/MM/AAAA]
   ```

3. **Conteúdo:**
   ```
   Ementa: [Resumo do projeto]
   Texto Integral: [Texto completo do projeto]
   Justificativa: [Justificativa do autor]
   ```

4. **Tramitação:**
   ```
   Situação: [Em tramitação/Aprovado/Rejeitado/Retirado]
   Comissão Atual: [Comissão analisando]
   Urgência: [Normal/Urgente/Urgentíssima]
   ```

### Tramitação

#### Fluxo Padrão
1. **Protocolo:** Recebimento e numeração
2. **Distribuição:** Envio para comissões
3. **Análise:** Parecer das comissões
4. **Plenário:** Discussão e votação
5. **Sanção/Veto:** Encaminhamento ao executivo
6. **Promulgação:** Publicação da lei

#### Acompanhamento
- **Timeline:** Histórico de tramitação
- **Prazos:** Controle de prazos regimentais
- **Alertas:** Notificações de vencimento
- **Relatórios:** Status de todos os projetos

### Pareceres

#### Criar Parecer
1. **Acesse:** Projeto > Pareceres > Novo Parecer
2. **Preencha:**
   ```
   Comissão: [Comissão responsável]
   Relator: [Vereador relator]
   Tipo: [Favorável/Contrário/Favorável com emenda]
   Texto: [Parecer completo]
   Data: [DD/MM/AAAA]
   ```

#### Tipos de Parecer
- **Favorável:** Recomenda aprovação
- **Contrário:** Recomenda rejeição
- **Favorável com Emenda:** Aprovação com modificações
- **Pela Retirada:** Recomenda retirada de pauta

## Gestão de Documentos

### Tipos de Documento

1. **Atas:** Registros de sessões
2. **Leis:** Leis municipais aprovadas
3. **Decretos:** Decretos legislativos
4. **Resoluções:** Resoluções da câmara
5. **Portarias:** Atos administrativos
6. **Contratos:** Contratos e convênios
7. **Relatórios:** Relatórios diversos

### Upload de Documentos

1. **Acesse:** `Documentos > Novo Documento`

2. **Informações:**
   ```
   Título: [Título do documento]
   Tipo: [Selecione o tipo]
   Número: [Número do documento]
   Data: [DD/MM/AAAA]
   Autor/Origem: [Quem criou o documento]
   ```

3. **Arquivo:**
   - **Formatos:** PDF (recomendado), DOC, DOCX
   - **Tamanho:** Máximo 10MB
   - **Qualidade:** Documentos legíveis e organizados

4. **Classificação:**
   ```
   Categoria: [Categoria do documento]
   Tags: [Palavras-chave]
   Público: [Sim/Não]
   Confidencial: [Nível de confidencialidade]
   ```

### Organização

#### Estrutura de Pastas
```
📁 Documentos
├── 📁 2024
│   ├── 📁 Atas
│   ├── 📁 Leis
│   ├── 📁 Projetos
│   └── 📁 Relatórios
├── 📁 2023
│   └── [mesma estrutura]
└── 📁 Histórico
```

#### Metadados
- **Título:** Nome descritivo
- **Descrição:** Resumo do conteúdo
- **Palavras-chave:** Para busca
- **Data de criação:** Quando foi criado
- **Última modificação:** Última alteração
- **Versão:** Controle de versões

### Controle de Acesso

#### Níveis de Acesso
1. **Público:** Visível para todos
2. **Restrito:** Apenas usuários logados
3. **Confidencial:** Apenas administradores
4. **Secreto:** Acesso muito restrito

#### Permissões
- **Visualizar:** Pode ver o documento
- **Baixar:** Pode fazer download
- **Editar:** Pode modificar metadados
- **Excluir:** Pode remover documento

### Busca e Filtros

#### Busca Avançada
- **Texto:** Busca no título e conteúdo
- **Tipo:** Filtro por tipo de documento
- **Data:** Período específico
- **Autor:** Documentos de autor específico
- **Tags:** Busca por palavras-chave

#### Indexação
- Sistema indexa automaticamente PDFs
- Busca no conteúdo dos documentos
- Reconhecimento de texto em imagens (OCR)

## Sistema e-SIC

### Configuração Inicial

#### Informações da Câmara
1. **Acesse:** `e-SIC > Configurações`
2. **Preencha:**
   ```
   Nome da Instituição: [Câmara Municipal de...]
   CNPJ: [00.000.000/0000-00]
   Endereço: [Endereço completo]
   Telefone: [Telefone para contato]
   Email: [email@camara.gov.br]
   Horário de Funcionamento: [Horários]
   ```

#### Responsáveis
- **Responsável Principal:** Quem gerencia o e-SIC
- **Substitutos:** Responsáveis alternativos
- **Autoridade Máxima:** Para recursos

### Recebimento de Solicitações

#### Solicitações Automáticas
- Sistema recebe automaticamente via site
- Protocolo gerado automaticamente
- Email de confirmação enviado ao solicitante

#### Solicitações Manuais
1. **Acesse:** `e-SIC > Nova Solicitação`
2. **Dados do Solicitante:**
   ```
   Nome: [Nome completo]
   CPF: [000.000.000-00]
   Email: [email@exemplo.com]
   Telefone: [Opcional]
   ```
3. **Solicitação:**
   ```
   Assunto: [Resumo da solicitação]
   Descrição: [Detalhes do que é solicitado]
   Forma de Recebimento: [Email/Presencial/Correio]
   ```

### Tramitação de Solicitações

#### Status das Solicitações
1. **Recebida:** Aguardando análise
2. **Em Andamento:** Sendo processada
3. **Pendente:** Aguarda informações adicionais
4. **Respondida:** Resposta enviada
5. **Recurso:** Em fase de recurso
6. **Finalizada:** Processo encerrado

#### Prazos Legais
- **Resposta:** 20 dias úteis
- **Prorrogação:** Mais 10 dias (justificada)
- **Recurso 1ª Instância:** 10 dias úteis
- **Recurso 2ª Instância:** 5 dias úteis

#### Processamento
1. **Análise:** Verificar se é competência da câmara
2. **Busca:** Localizar informações solicitadas
3. **Classificação:** Verificar se é pública ou sigilosa
4. **Resposta:** Elaborar resposta completa
5. **Envio:** Enviar por meio escolhido pelo solicitante

### Tipos de Resposta

#### Acesso Concedido
- Informação fornecida integralmente
- Documentos anexados
- Orientações sobre uso

#### Acesso Parcialmente Concedido
- Parte da informação fornecida
- Justificativa para partes negadas
- Indicação de onde obter informações negadas

#### Acesso Negado
- Justificativa legal para negativa
- Indicação de recursos disponíveis
- Orientação sobre procedimentos

#### Não se Aplica
- Solicitação fora da competência
- Indicação do órgão competente
- Orientações ao solicitante

### Recursos

#### Primeira Instância
- **Prazo:** 10 dias úteis após resposta
- **Responsável:** Autoridade hierarquicamente superior
- **Análise:** Revisão da decisão inicial

#### Segunda Instância
- **Prazo:** 5 dias úteis após primeira instância
- **Responsável:** Autoridade máxima do órgão
- **Decisão:** Final no âmbito do órgão

### Relatórios e Estatísticas

#### Relatórios Obrigatórios
- **Mensal:** Estatísticas básicas
- **Anual:** Relatório completo para CGU
- **Sob Demanda:** Relatórios específicos

#### Métricas Importantes
- **Quantidade:** Solicitações recebidas
- **Prazos:** Cumprimento dos prazos legais
- **Tipos:** Classificação das solicitações
- **Recursos:** Quantidade e resultado

## Ouvidoria

### Configuração

#### Canais de Atendimento
1. **Online:** Formulário no site
2. **Presencial:** Atendimento na câmara
3. **Telefone:** Linha direta
4. **Email:** Email específico
5. **Correspondência:** Endereço postal

#### Tipos de Manifestação
- **Denúncia:** Irregularidades ou ilegalidades
- **Reclamação:** Insatisfação com serviços
- **Sugestão:** Propostas de melhoria
- **Elogio:** Reconhecimento de bom atendimento
- **Solicitação:** Pedidos de providências

### Recebimento de Manifestações

#### Manifestações Online
- Formulário padronizado no site
- Protocolo automático gerado
- Email de confirmação enviado

#### Manifestações Presenciais
1. **Acesse:** `Ouvidoria > Nova Manifestação`
2. **Dados do Manifestante:**
   ```
   Nome: [Nome completo - opcional]
   Email: [Para retorno]
   Telefone: [Opcional]
   Identificação: [Anônima/Identificada]
   ```

### Classificação e Triagem

#### Classificação por Assunto
- **Administração:** Questões administrativas
- **Legislativo:** Atividade legislativa
- **Transparência:** Acesso à informação
- **Atendimento:** Qualidade do atendimento
- **Infraestrutura:** Instalações e equipamentos

#### Priorização
1. **Alta:** Denúncias graves, urgências
2. **Média:** Reclamações importantes
3. **Baixa:** Sugestões e elogios

### Investigação e Apuração

#### Processo de Apuração
1. **Análise Inicial:** Verificar procedência
2. **Coleta de Informações:** Buscar dados necessários
3. **Oitiva:** Ouvir envolvidos se necessário
4. **Conclusão:** Elaborar parecer final
5. **Providências:** Implementar medidas necessárias

#### Documentação
- **Registro:** Todas as etapas documentadas
- **Evidências:** Anexar documentos comprobatórios
- **Cronologia:** Timeline das ações
- **Resultado:** Conclusão e providências

### Resposta ao Manifestante

#### Prazos
- **Confirmação:** Imediata (protocolo)
- **Resposta Inicial:** 5 dias úteis
- **Resposta Final:** 30 dias úteis
- **Casos Complexos:** Até 60 dias

#### Tipos de Resposta
- **Procedente:** Manifestação confirmada
- **Improcedente:** Manifestação não confirmada
- **Parcialmente Procedente:** Parte confirmada
- **Arquivada:** Sem elementos para análise

### Acompanhamento

#### Status das Manifestações
- **Recebida:** Aguardando análise
- **Em Apuração:** Sendo investigada
- **Aguardando Informações:** Pendente de dados
- **Concluída:** Apuração finalizada
- **Arquivada:** Processo encerrado

#### Indicadores
- **Tempo Médio:** Tempo de resposta
- **Taxa de Resolução:** Manifestações resolvidas
- **Satisfação:** Avaliação dos manifestantes
- **Reincidência:** Manifestações repetidas

## Licitações

### Cadastro de Licitações

1. **Acesse:** `Licitações > Nova Licitação`

2. **Informações Básicas:**
   ```
   Número: [Número da licitação]
   Modalidade: [Convite/Tomada de Preços/Concorrência/Pregão]
   Tipo: [Menor Preço/Melhor Técnica/Técnica e Preço]
   Objeto: [Descrição do objeto]
   ```

3. **Cronograma:**
   ```
   Data Publicação: [DD/MM/AAAA]
   Data Abertura: [DD/MM/AAAA HH:MM]
   Data Limite Impugnação: [DD/MM/AAAA]
   Data Limite Esclarecimentos: [DD/MM/AAAA]
   ```

4. **Valores:**
   ```
   Valor Estimado: [R$ 0,00]
   Valor Homologado: [R$ 0,00]
   Economia: [Calculada automaticamente]
   ```

### Documentos da Licitação

#### Documentos Obrigatórios
- **Edital:** Documento principal
- **Anexos:** Especificações técnicas
- **Minuta do Contrato:** Modelo de contrato
- **Orçamento:** Planilha de custos

#### Upload de Documentos
1. **Selecione o tipo** de documento
2. **Faça upload** do arquivo PDF
3. **Preencha metadados** (título, descrição)
4. **Publique** para disponibilizar

### Fases da Licitação

#### Preparação
- **Elaboração:** Criação do edital
- **Revisão:** Análise jurídica
- **Aprovação:** Autorização para publicação
- **Publicação:** Divulgação oficial

#### Execução
- **Recebimento:** Propostas dos fornecedores
- **Abertura:** Sessão pública de abertura
- **Julgamento:** Análise das propostas
- **Habilitação:** Verificação de documentos

#### Finalização
- **Homologação:** Aprovação do resultado
- **Adjudicação:** Atribuição ao vencedor
- **Contratação:** Assinatura do contrato
- **Arquivo:** Arquivamento do processo

### Acompanhamento

#### Status da Licitação
- **Em Elaboração:** Preparando documentos
- **Publicada:** Aguardando propostas
- **Em Julgamento:** Analisando propostas
- **Homologada:** Processo finalizado
- **Revogada:** Licitação cancelada
- **Anulada:** Licitação anulada

#### Relatórios
- **Licitações por Período:** Quantidade e valores
- **Modalidades:** Distribuição por modalidade
- **Fornecedores:** Participação de empresas
- **Economia:** Economia obtida

## Relatórios

### Tipos de Relatório

#### Relatórios de Gestão
1. **Atividade Legislativa**
   - Projetos apresentados
   - Leis aprovadas
   - Sessões realizadas
   - Presença dos vereadores

2. **Transparência**
   - Solicitações e-SIC
   - Manifestações de ouvidoria
   - Documentos publicados
   - Acessos ao portal

3. **Administrativo**
   - Usuários do sistema
   - Licitações realizadas
   - Contratos vigentes
   - Despesas por categoria

#### Relatórios Legais
- **Prestação de Contas:** Anual
- **Relatório de Gestão:** Trimestral
- **Transparência:** Mensal
- **Atividade Legislativa:** Semestral

### Gerando Relatórios

#### Relatórios Pré-definidos
1. **Acesse:** `Relatórios > [Tipo de Relatório]`
2. **Selecione o período:** Data inicial e final
3. **Configure filtros:** Se necessário
4. **Gere o relatório:** Clique em "Gerar"
5. **Exporte:** PDF, Excel ou CSV

#### Relatórios Personalizados
1. **Acesse:** `Relatórios > Personalizado`
2. **Selecione dados:** Escolha as informações
3. **Configure filtros:** Defina critérios
4. **Visualize:** Preview do relatório
5. **Salve modelo:** Para uso futuro

### Agendamento de Relatórios

#### Configurar Agendamento
1. **Acesse:** `Relatórios > Agendamentos`
2. **Novo Agendamento:**
   ```
   Nome: [Nome do relatório]
   Tipo: [Tipo de relatório]
   Frequência: [Diária/Semanal/Mensal]
   Destinatários: [Emails para envio]
   Formato: [PDF/Excel/CSV]
   ```

#### Frequências Disponíveis
- **Diária:** Todos os dias úteis
- **Semanal:** Toda segunda-feira
- **Mensal:** Primeiro dia útil do mês
- **Trimestral:** Início de cada trimestre
- **Anual:** Janeiro de cada ano

### Dashboards

#### Dashboard Executivo
- **Métricas Principais:** KPIs importantes
- **Gráficos:** Visualizações interativas
- **Tendências:** Evolução temporal
- **Alertas:** Indicadores críticos

#### Dashboard Operacional
- **Atividades Diárias:** Tarefas do dia
- **Pendências:** Itens em atraso
- **Produtividade:** Métricas de equipe
- **Sistema:** Status dos serviços

## Configurações do Sistema

### Configurações Gerais

#### Informações da Câmara
1. **Acesse:** `Configurações > Geral`
2. **Preencha:**
   ```
   Nome: [Câmara Municipal de...]
   CNPJ: [00.000.000/0000-00]
   Endereço: [Endereço completo]
   Telefone: [(00) 0000-0000]
   Email: [contato@camara.gov.br]
   Site: [www.camara.gov.br]
   ```

#### Configurações de Exibição
```
Logo: [Upload do logo oficial]
Favicon: [Ícone do site]
Cores: [Paleta de cores institucional]
Slogan: [Frase institucional]
```

### Configurações de Email

#### Servidor SMTP
1. **Acesse:** `Configurações > Email`
2. **Configure:**
   ```
   Servidor: [smtp.servidor.com]
   Porta: [587/465/25]
   Usuário: [usuario@servidor.com]
   Senha: [senha_do_email]
   Criptografia: [TLS/SSL]
   ```

#### Templates de Email
- **Boas-vindas:** Para novos usuários
- **Reset de Senha:** Para recuperação
- **Notificações:** Para alertas do sistema
- **e-SIC:** Para solicitações de informação

### Configurações de Segurança

#### Políticas de Senha
```
Tamanho Mínimo: [8 caracteres]
Complexidade: [Maiúsculas, minúsculas, números, símbolos]
Expiração: [90 dias]
Histórico: [Últimas 5 senhas]
Tentativas: [5 tentativas antes de bloquear]
```

#### Autenticação em Duas Etapas
- **Obrigatória:** Para administradores
- **Opcional:** Para outros usuários
- **Aplicativos:** Google Authenticator, Authy
- **Backup:** Códigos de recuperação

#### Logs de Segurança
- **Login/Logout:** Registrar acessos
- **Ações Críticas:** Alterações importantes
- **Tentativas Falhas:** Tentativas de acesso negadas
- **IPs Suspeitos:** Acessos de IPs não usuais

### Configurações de Backup

#### Backup Automático
1. **Acesse:** `Configurações > Backup`
2. **Configure:**
   ```
   Frequência: [Diário/Semanal]
   Horário: [02:00]
   Retenção: [30 dias]
   Local: [Servidor/Nuvem]
   ```

#### Itens do Backup
- **Banco de Dados:** Todos os dados
- **Arquivos:** Documentos e imagens
- **Configurações:** Settings do sistema
- **Logs:** Arquivos de log

### Configurações de Performance

#### Cache
```
Driver: [Redis/File/Database]
TTL Padrão: [3600 segundos]
Cache de Consultas: [Habilitado]
Cache de Views: [Habilitado]
```

#### Otimizações
- **Compressão:** Gzip habilitado
- **Minificação:** CSS e JS minificados
- **CDN:** Content Delivery Network
- **Lazy Loading:** Carregamento sob demanda

## Backup e Segurança

### Estratégia de Backup

#### Tipos de Backup
1. **Completo:** Todos os dados
2. **Incremental:** Apenas alterações
3. **Diferencial:** Mudanças desde último completo

#### Frequência
- **Diário:** Backup incremental
- **Semanal:** Backup completo
- **Mensal:** Backup arquival
- **Anual:** Backup histórico

#### Locais de Armazenamento
- **Local:** Servidor principal
- **Remoto:** Servidor secundário
- **Nuvem:** Serviços cloud
- **Físico:** Mídias removíveis

### Execução de Backup

#### Backup Manual
1. **Acesse:** `Configurações > Backup`
2. **Clique:** "Executar Backup Agora"
3. **Aguarde:** Conclusão do processo
4. **Verifique:** Status do backup

#### Backup Automático
- **Configurado:** Executa automaticamente
- **Monitoramento:** Alertas em caso de falha
- **Logs:** Registro de todas as execuções
- **Notificações:** Email de confirmação

### Restauração

#### Processo de Restauração
1. **Identifique:** Backup a ser restaurado
2. **Prepare:** Ambiente de restauração
3. **Execute:** Processo de restore
4. **Verifique:** Integridade dos dados
5. **Teste:** Funcionamento do sistema

#### Cenários de Restauração
- **Falha de Hardware:** Servidor danificado
- **Corrupção de Dados:** Dados corrompidos
- **Erro Humano:** Exclusão acidental
- **Ataque:** Comprometimento de segurança

### Monitoramento de Segurança

#### Logs de Auditoria
- **Acessos:** Login e logout de usuários
- **Ações:** Todas as operações realizadas
- **Alterações:** Modificações em dados críticos
- **Erros:** Tentativas de acesso negadas

#### Alertas de Segurança
- **Múltiplas Tentativas:** Login com falha
- **Acessos Suspeitos:** IPs não usuais
- **Ações Críticas:** Alterações importantes
- **Falhas de Sistema:** Erros críticos

#### Análise de Logs
1. **Acesse:** `Configurações > Logs`
2. **Filtre:** Por tipo, usuário, data
3. **Analise:** Padrões suspeitos
4. **Exporte:** Para análise externa

## Solução de Problemas

### Problemas Comuns

#### Não Consigo Fazer Login
**Possíveis Causas:**
- Senha incorreta
- Usuário desativado
- Problema de 2FA
- Bloqueio por tentativas

**Soluções:**
1. Verifique se o Caps Lock está ativado
2. Use a função "Esqueci minha senha"
3. Contate o administrador para verificar status
4. Aguarde desbloqueio automático (30 minutos)

#### Sistema Está Lento
**Possíveis Causas:**
- Muitos usuários simultâneos
- Cache desatualizado
- Banco de dados sobrecarregado
- Problemas de rede

**Soluções:**
1. Limpe o cache do navegador
2. Execute limpeza de cache do sistema
3. Verifique conexão de internet
4. Contate suporte técnico

#### Erro ao Fazer Upload
**Possíveis Causas:**
- Arquivo muito grande
- Formato não suportado
- Espaço em disco insuficiente
- Problemas de permissão

**Soluções:**
1. Verifique tamanho máximo permitido
2. Converta para formato suportado
3. Comprima o arquivo
4. Contate administrador

#### Relatório Não Gera
**Possíveis Causas:**
- Período muito extenso
- Muitos dados para processar
- Timeout do servidor
- Erro na consulta

**Soluções:**
1. Reduza o período do relatório
2. Use filtros para limitar dados
3. Tente em horário de menor uso
4. Contate suporte técnico

### Contatos de Suporte

#### Suporte Técnico
- **Email:** suporte@tcamara.gov.br
- **Telefone:** (00) 0000-0000
- **Horário:** Segunda a sexta, 8h às 18h
- **Urgências:** WhatsApp (00) 00000-0000

#### Suporte Funcional
- **Email:** funcional@tcamara.gov.br
- **Telefone:** (00) 0000-0001
- **Horário:** Segunda a sexta, 8h às 17h

#### Emergências
- **24/7:** (00) 00000-0001
- **Apenas para:** Falhas críticas do sistema
- **Critérios:** Sistema fora do ar, vazamento de dados

### Manutenção Preventiva

#### Rotinas Diárias
- [ ] Verificar logs de erro
- [ ] Monitorar performance
- [ ] Verificar backups
- [ ] Acompanhar uso de recursos

#### Rotinas Semanais
- [ ] Limpeza de cache
- [ ] Análise de logs de segurança
- [ ] Verificação de atualizações
- [ ] Teste de backups

#### Rotinas Mensais
- [ ] Análise de performance
- [ ] Revisão de usuários
- [ ] Limpeza de arquivos temporários
- [ ] Relatório de uso do sistema

#### Rotinas Anuais
- [ ] Auditoria de segurança
- [ ] Revisão de políticas
- [ ] Treinamento de usuários
- [ ] Planejamento de melhorias

---

## Conclusão

Este manual fornece uma visão abrangente das funcionalidades administrativas do sistema TCamaraMunicipal. Para dúvidas específicas ou situações não cobertas neste manual, entre em contato com o suporte técnico.

**Lembre-se:** Como administrador, você é responsável pela segurança e integridade dos dados do sistema. Sempre siga as melhores práticas de segurança e mantenha-se atualizado com as novidades do sistema.

**Versão do Manual:** 1.0  
**Última Atualização:** Janeiro 2024  
**Próxima Revisão:** Julho 2024