-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: 2017-12-10 01:25:17
-- 服务器版本： 8.0.3-rc-log
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Index', 'fa-bar-chart', '/', NULL, NULL),
(2, 0, 2, 'Admin', 'fa-tasks', '', NULL, NULL),
(3, 2, 3, 'Users', 'fa-users', 'auth/users', NULL, NULL),
(4, 2, 4, 'Roles', 'fa-user', 'auth/roles', NULL, NULL),
(5, 2, 5, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL),
(6, 2, 6, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL),
(7, 2, 7, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL),
(8, 11, 0, '用户', 'fa-bars', 'users', '2017-12-07 14:17:37', '2017-12-07 19:37:19'),
(9, 11, 0, '帖子', 'fa-bars', 'topics', '2017-12-07 14:18:00', '2017-12-07 19:37:38'),
(10, 11, 0, '回复', 'fa-bars', 'replies', '2017-12-07 14:18:15', '2017-12-07 19:37:52'),
(11, 0, 0, '内容管理', 'fa-building-o', '/topics', '2017-12-07 19:37:01', '2017-12-10 08:51:42'),
(12, 0, 7, 'Helpers', 'fa-gears', '', '2017-12-07 19:57:47', '2017-12-07 19:57:47'),
(13, 12, 8, 'Scaffold', 'fa-keyboard-o', 'helpers/scaffold', '2017-12-07 19:57:48', '2017-12-07 19:57:48'),
(14, 12, 9, 'Database terminal', 'fa-database', 'helpers/terminal/database', '2017-12-07 19:57:48', '2017-12-07 19:57:48'),
(15, 12, 10, 'Laravel artisan', 'fa-terminal', 'helpers/terminal/artisan', '2017-12-07 19:57:48', '2017-12-07 19:57:48'),
(16, 12, 11, 'Routes', 'fa-list-alt', 'helpers/routes', '2017-12-07 19:57:48', '2017-12-07 19:57:48'),
(17, 0, 12, 'Api tester', 'fa-sliders', 'api-tester', '2017-12-07 22:18:32', '2017-12-07 22:18:32'),
(18, 0, 13, 'Scheduling', 'fa-clock-o', 'scheduling', '2017-12-07 22:39:30', '2017-12-07 22:39:30'),
(19, 11, 0, '推荐资源', 'fa-link', '/links', '2017-12-10 09:21:24', '2017-12-10 09:21:24');

--
-- 转存表中的数据 `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
(1, 'All permission', '*', '', '*', NULL, NULL),
(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL),
(6, '内容管理', 'content.manage', '', '/topics\r\n/users\r\n/replies', '2017-12-07 19:39:00', '2017-12-07 19:39:00'),
(7, 'Admin helpers', 'ext.helpers', NULL, '/helpers/*', '2017-12-07 19:57:48', '2017-12-07 19:57:48'),
(8, 'Api tester', 'ext.api-tester', NULL, '/api-tester*', '2017-12-07 22:18:32', '2017-12-07 22:18:32'),
(9, 'Scheduling', 'ext.scheduling', NULL, '/scheduling*', '2017-12-07 22:39:30', '2017-12-07 22:39:30');

--
-- 转存表中的数据 `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2017-12-07 14:13:18', '2017-12-07 14:13:18'),
(2, '管理员', 'manager', '2017-12-07 19:42:09', '2017-12-07 19:42:09');

--
-- 转存表中的数据 `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL),
(1, 8, NULL, NULL),
(1, 9, NULL, NULL),
(1, 10, NULL, NULL),
(1, 11, NULL, NULL),
(1, 19, NULL, NULL),
(2, 19, NULL, NULL);

--
-- 转存表中的数据 `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 6, NULL, NULL);

--
-- 转存表中的数据 `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 2, NULL, NULL);

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$GCqx.0e34ZkA/HbDUfjx5ujfgMIOmiL23gELUdubSc7waYK.sKNie', 'Administrator', NULL, NULL, '2017-12-07 14:13:18', '2017-12-07 14:13:18'),
(2, 'useradmin', '$2y$10$j3BDWHf0VBTELVk8shqGxu288SbRypPp6fjni9d.RJQoDDX4NaaLK', '内容管理员', 'admin/images/472309f790529822c5ba70d9dcca7bcb0a46d41b.jpg', NULL, '2017-12-07 19:40:21', '2017-12-07 19:40:21');

--
-- 转存表中的数据 `admin_user_permissions`
--

INSERT INTO `admin_user_permissions` (`user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(2, 6, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
