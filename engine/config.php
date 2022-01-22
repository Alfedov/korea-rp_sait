<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: config.php - Файл конфигураций
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

//Для работы с аккаунтами
$tableconf = array(

    'TABLE_ID' => 'ID', // Таблица с id игрока
    'TABLE_NAME' => 'Name', // Таблица с логинами
    'TABLE_PASSWORD' => 'pKey', //Таблица с паролями
    'TABLE_MAIL' => 'pEmail', //Таблица с почтой
    'TABLE_MONEY' => 'Money', //Таблица с кол-вом денег
    'TABLE_SCHADMONEY' => 'schadmoney', //Таблица с кол-вом пожертвованием
    'TABLE_REPUTATION' => 'reputation', //Таблица с кол-вом репутации
    'TABLE_TOKEN' => 'token', //Таблица с токеном
    'TABLE_LEVEL' => 'Level', //Таблица с уровнем
    'TABLE_EXP' => 'Exp', //Таблица с кол-вом опыта
    'TABLE_EAT' => 'Eat', //Таблица с кол-вом еды
    'TABLE_ADMIN' => 'Admin', //Таблица с админкой
    'TABLE_PHONE' => 'Phone', //Таблица с телефоном
    'TABLE_PHONEMONEY' => 'phonemoney', //Таблица с кол-вом денег на телефоне
    'TABLE_CASH' => 'cash', //Таблица с кол-вом денег в банке
    'TABLE_DONATE' => 'VirMoney', //Таблица с кол-вом доната
    'TABLE_PATRONS' => 'patrons', //Таблица с кол-вом патронов
    'TABLE_DRUGS' => 'drugs', //Таблица с кол-вом наркотиков
    'TABLE_ZVEZD' => 'zvezd',  //Таблица с кол-вом звёзд
    'TABLE_AUTHORITY' => 'authority', //Таблица с Преступным авторитетом
    'TABLE_BUSINESS' => 'BizKey', //Таблица с бизнесом
    'TABLE_HOUSE' => 'HouseKey', //Таблица с домом
    'TABLE_RANG' => 'Rang', //Таблица с рангом
    'TABLE_LEADER' => 'Leader', //Таблица с лидеркой
    'TABLE_MEMBER' => 'Member', //Таблица с фракцией
    'TABLE_CLIC' => 'CarLic', //Таблица с лицензией на вод. права
    'TABLE_BLIC' => 'bizlic', //Таблица с лицензией на бизнес
    'TABLE_FLYLIC' => 'FlyLic', //Таблица с лицензией на воздушный трансп.
    'TABLE_WATLIC' => 'BoatLic', //Таблица с лицензией на водяной трансп.
    'TABLE_WEAPLIC' => 'GunLic', //Таблица с лицензией на оружие
    'TABLE_REPUTLEAD' => 'reputlead', //Таблица с репутацией лидера
    'TABLE_SPISTOL' => 'Eagle_Skill', //Таблица с кол-во прокачки SPISTOL
    'TABLE_PISTOL' => 'SDPistol_Skill', //Таблица с кол-во прокачки PISTOL
    'TABLE_MP5' => 'MP5_Skill', //Таблица с кол-во прокачки MP5
    'TABLE_SHOTGUN' => 'ShotGun_Skill', //Таблица с кол-во прокачки SHOTGUN
    'TABLE_AK47' => 'AK47_Skill', //Таблица с кол-во прокачки AK47
    'TABLE_M4' => 'M4_Skill', //Таблица с кол-во прокачки M4
    //'TABLE_PIN' => 'pincode', //Таблица с пинкодом игрока
    'TABLE_WORK' => 'work', //Таблица с id работы игрока
    'TABLE_ONLINE' => 'LastLogin', //Таблица с временем, когда игрок последний раз заходил
    'TABLE_GASECRET' => 'GoogleCode', //Таблица с секретным ключом Google Authenticator

    'WEAPON_IN_ONE' => true,
    "TABLE_WEAPONS" => 'weapons',

    'LICS_IN_ONE' => true,
    'TABLE_LICS' => 'lics',

    'unitpay' => array(
        'shop_id' => '60203-83cdf',
        'secret_key' => ''
    ),

    'X2_DONATE' => true,

    'TABLE_HOUSES' => 'houses',
    'TABLE_HOUSE_ID' => 'ID',
    'TABLE_HOUSE_OWNER' => 'Owner',
    'TABLE_HOUSE_OWNED' => 'Owned',
    'TABLE_HOUSE_COST' => 'Value',
    'TABLE_HOUSE_LOCK' => 'Lock',
    'TABLE_HOUSE_CLASS' => 'Klass',
    'TABLE_HOUSE_ENTER_X' => 'Enter_X',
    'TABLE_HOUSE_ENTER_Y' => 'Enter_Y',
    'TABLE_HOUSE_DAYS' => 'Nalog',
    'TABLE_HOUSE_DRUGS' => 'Drugs',
    'TABLE_HOUSE_CASH' => 'Money',

    'TABLE_BIZ' => 'businesses',
    'TABLE_BIZ_ID' => 'ID',
    'TABLE_BIZ_OWNER' => 'Owner',
    'TABLE_BIZ_OWNED' => 'Owned',
    'TABLE_BIZ_COST' => 'Cost',
    'TABLE_BIZ_LOCK' => 'Lock',
    'TABLE_BIZ_ENTER_X' => 'Enter_X',
    'TABLE_BIZ_ENTER_Y' => 'Enter_Y',
    'TABLE_BIZ_ENTER_COST' => 'Vxod',
    'TABLE_BIZ_DAYS' => 'Days',
    'TABLE_BIZ_CASH' => 'Money',
    'TABLE_BIZ_NAME' => 'Name',
    'TABLE_BIZ_PRICEPROD' => 'ProdPrice',
);

$servers = array(
     "Seoul" => array(
        "IP" => "176.32.37.19",
        "PORT" => "7777",
        "MYSQL_HOST" => "localhost",
        "MYSQL_LOGIN" => "root",
        "MYSQL_PASSWORD" => "root",
        "MYSQL_DB" => "korearp",
        "MYSQL_TABLE" => "accounts"
    )
);