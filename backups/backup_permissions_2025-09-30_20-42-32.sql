-- Backup das permissões - 2025-09-30_20-42-32
-- NÃO EXECUTAR EM PRODUÇÃO SEM VERIFICAR

-- Tabela: users
DROP TABLE IF EXISTS `users_backup`;
CREATE TABLE `users_backup` AS SELECT * FROM `users`;

-- Tabela: roles
DROP TABLE IF EXISTS `roles_backup`;
CREATE TABLE `roles_backup` AS SELECT * FROM `roles`;

-- Tabela: permissions
DROP TABLE IF EXISTS `permissions_backup`;
CREATE TABLE `permissions_backup` AS SELECT * FROM `permissions`;

-- Tabela: role_user
DROP TABLE IF EXISTS `role_user_backup`;
CREATE TABLE `role_user_backup` AS SELECT * FROM `role_user`;

-- Tabela: permission_user
DROP TABLE IF EXISTS `permission_user_backup`;
CREATE TABLE `permission_user_backup` AS SELECT * FROM `permission_user`;

-- Tabela: permission_role
DROP TABLE IF EXISTS `permission_role_backup`;
CREATE TABLE `permission_role_backup` AS SELECT * FROM `permission_role`;

-- Tabela: model_has_roles
DROP TABLE IF EXISTS `model_has_roles_backup`;
CREATE TABLE `model_has_roles_backup` AS SELECT * FROM `model_has_roles`;

-- Tabela: model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions_backup`;
CREATE TABLE `model_has_permissions_backup` AS SELECT * FROM `model_has_permissions`;

-- Tabela: role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions_backup`;
CREATE TABLE `role_has_permissions_backup` AS SELECT * FROM `role_has_permissions`;

