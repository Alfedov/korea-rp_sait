<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: index.php - Главный файл сайта
=====================================================
*/
session_start();

/*
 * Обьявляем переменные, нужные для работы сайта
 */
define('GRANDRULZ', true);
define('SERVER_DIR', dirname ( __FILE__ ));
define('ENGINE_DIR', SERVER_DIR.'/engine');
define('PUBLIC_DIR', SERVER_DIR.'/public');

/*
 * Подключения файла конфигурации
 */
require_once ENGINE_DIR.'/config.php';

/*
 * Подключение классов для работы сайта
 */
require_once ENGINE_DIR.'/classes/exception.class.php';
require_once ENGINE_DIR.'/classes/mysql.class.php';
require_once ENGINE_DIR.'/classes/statement.class.php';
require_once ENGINE_DIR.'/classes/func.class.php';
require_once ENGINE_DIR.'/classes/user.class.php';

/*
 * Иницилизация функций
 */
$func = new func();
$user = new user();

/*
 * Узнаем онлайн со всех серверов, если сервер не отвечают онлайн = 0
 */
$func->getOnlineFromAllServers();

/*
 * Подключения ядра сайта
 */
require_once ENGINE_DIR.'/core/main.php';

/*
 * Подключение главной страницы, если $stop == true то она не загружается - это нужно для скриптов
 */
if(!$stop) require_once PUBLIC_DIR.'/pages/index.php';

