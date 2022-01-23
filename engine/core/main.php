<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: main.php - Ядро сайта отвечающий за все скрипты
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

/*
 * Очистка строк для массива
 */
$action = stripslashes(htmlspecialchars(trim($_GET['action'])));

/*
 * Массив который вмещает в себя все запросы типа /url[0]/url[1]/.../url[n]
 */
$url = explode('/', $action);

/*
 * Массив со стилями для сайта (Можно указать для каждой страницы свой)
 */
$styles = array(
    "/assets/css/reset.css",
    "/assets/fonts/bloggersans/bloggersans.css",
    "/assets/fonts/intro/intro.css",
    "/assets/fonts/roboto/roboto.css",
    "/assets/fonts/fontawesome/css/font-awesome.css",
    "/assets/bootstrap/css/bootstrap.min.css",
    "/assets/css/animate.css",
    "/assets/css/style.css",
    "/assets/css/responsive.css"
);

/*
 * Массив со скриптами для сайта (Можно указать для каждой страницы свой)
 */
$scripts = array(
    "/assets/js/jquery.min.js",
    "/assets/js/wow.js",
    "/assets/js/jquery.spincrement.js",
    "/assets/js/jquery.viewportchecker.min.js",
    "/assets/bootstrap/js/bootstrap.min.js",
    "/assets/js/totop.js"
);

/*
 * Переменная отвечающая за работу шаблона!
 * Если поставить на true сайт не будет загружать шаблон
 * Нужно для скриптов не требующих шаблона
 */
$stop = false;

$ucp = false;

/*
 * Переменная, отвечающая за показ мониторинга при значении true
 * При значении false не показывает
 */
$need = false;

/*
 * Стиль для <body>, ничего интересного
 */
$bodyclass = "mainer";

/*
 * Название сайта, в любом скрипте можно поставить любое значение
 */
$title = 'SAMP: Korea Role Play - Играй в GTA: SA по сети!';

/*
 * Дальше разбор каждой страницы, и там же скрипты
 */
if(empty($url[0])) {
    $description = "Korea Role Play - игровой проект захватывающего мультиплеера GTA: San Andreas. На нашем проекте Вы сможете попробовать себя в разных ролях игрового процесса.";
    $page = PUBLIC_DIR.'/pages/main.php';
    $need = true;
}
else {
    switch ($url[0]) {
        case 'transfer':{
            header("Location: /");
            break;
        }
        case 'lottery':{
            header("Location: /");
            break;
        }
        case 'unitpay':{
            require_once ENGINE_DIR.'/classes/payment.class.php';
            require_once ENGINE_DIR.'/lib/unitpay.php';
            break;
        }
        case 'map':{
            if($url[1] != null && !is_array($url[1]) && $func->servers[ucfirst($url[1])] != null){
                $db = $func->getTempBase(ucfirst($url[1]));
                $row = $db->query("SELECT * FROM `".$tableconf['TABLE_HOUSES']."`")->fetch_assoc_array();
                $biz = $db->query("SELECT * FROM `".$tableconf['TABLE_BIZ']."`")->fetch_assoc_array();
                require_once PUBLIC_DIR.'/pages/map.php';
                $stop = true;
            }
            $page = PUBLIC_DIR.'/pages/404.php';
            $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
            break;
        }
        case 'donate':{
            if(isset($_POST['donate'])){
                require_once ENGINE_DIR.'/classes/payment.class.php';
                $acc = $_POST['donat_id'];
                $server = $_POST['server'];
                if($server == null || empty($server) || is_array($server) || $func->servers[ucfirst($server)] == null){
                    $func->setPopUp("error","Ошибка","Вы не выбрали сервер!");
                }else{
                    $val = $_POST['donat_value'];
                    $payment = new payment();
                    $payment->createPayment($acc,$val,$server);
                    $payid = $payment->payid;
                    $sign = hash('sha256', "ID_{$payid}{up}Grand+RolePlay+|+{$server}{up}{$server}{up}{$cost}{up}{$tableconf['unitpay']['secret_key']}");
                    exit(header("Location: https://unitpay.ru/pay/{$tableconf['unitpay']['shop_id']}?sum={$val}&account={$payid}&server={$server}&desc=Grand+RolePlay+|+{$server}&signature={$sign}"));
                    break;
                }
            }
            $footscripts = array(
                "/assets/js/jquery.spincrement.js",
                "/assets/js/jquery.viewportchecker.min.js",
                "/assets/bootstrap/js/bootstrap.min.js",
                "/assets/js/changerServer.js",
                "/assets/js/totop.js"
            );
            $scripts = array(
                "/assets/js/jquery.min.js",
                "/assets/js/wow.js"
            );
            $bodyclass = "donate no-account aller";
            $title = "Пополнение счёта | SAMP: Grand Role Play - Играй в GTA: SA по сети!";
            $page = PUBLIC_DIR.'/pages/donate.php';
            break;
        }
        case 'auth':{
            if($user->isAuthorized()) header("Location: /account");
            if(isset($_POST['login']) && isset($_POST['password'])){
                $login = $_POST['login'];
                is_scalar($_POST['password']) ? $password = md5($_POST['password']) : $password = null;
                $server = $_POST['server'];
                if(!empty($login) && !empty($password)){
                    if($server == null || empty($server) || is_array($server) || $func->servers[ucfirst($server)] == null) {
                        $func->setPopUp("error", "Ошибка", "Вы не указали сервер!");
                    }else{
                        $userka = $user->authorizeUser($login,$password,$server);
                        if(!$userka){
                            $func->setPopUp("error","Ошибка","Неверная комбинация ника и пароля!");
                        }else{
                            header("Location: /account");
                        }
                    }
                }else{
                    $func->setPopUp("error","Ошибка","Вы указали не все данные!");
                }
            }
            $bodyclass = "loginer no-account aller";
            $footscripts = array(
                "/assets/js/jquery.spincrement.js",
                "/assets/js/jquery.viewportchecker.min.js",
                "/assets/bootstrap/js/bootstrap.min.js",
                "/assets/js/changerServer.js",
                "/assets/js/totop.js"
            );
            $scripts = array(
                "/assets/js/jquery.min.js",
                "/assets/js/wow.js"
            );
            if($url[1] != null){
                if($url[1] == "recovery"){
                    if(isset($_POST['recovery'])){
                        if($_POST['server'] == null || empty($_POST['server']) || is_array($_POST['server']) || $func->servers[ucfirst($_POST['server'])] == null){
                            $func->setPopUp("error", "Ошибка", "Сервер не указан.");
                        }else {
                            $db = $func->getTempBase($_POST['server']);
                            $login = $func->clearQuery($db, $_POST['login']);
                            $mail = $func->clearQuery($db, $_POST['mail']);
                            $userka = $db->query("SELECT * FROM `" . $func->servers[ucfirst($_POST['server'])]['MYSQL_TABLE'] . "` WHERE `" . $tableconf['TABLE_NAME'] . "`='" . $login . "' AND `" . $tableconf['TABLE_MAIL'] . "`='" . $mail . "' ");
                            if ($userka->getNumRows() == 0) {
                                $func->setPopUp("error", "Ошибка", "Аккаунт " . $login . " не связан с указанной почтой.");
                            } else {
                                function generate_password($number)
                                {
                                    $arr = array('a', 'b', 'c', 'd', 'e', 'f',
                                        'g', 'h', 'i', 'j', 'k', 'l',
                                        'm', 'n', 'o', 'p', 'r', 's',
                                        't', 'u', 'v', 'x', 'y', 'z',
                                        'A', 'B', 'C', 'D', 'E', 'F',
                                        'G', 'H', 'I', 'J', 'K', 'L',
                                        'M', 'N', 'O', 'P', 'R', 'S',
                                        'T', 'U', 'V', 'X', 'Y', 'Z',
                                        '1', '2', '3', '4', '5', '6',
                                        '7', '8', '9', '0');
                                    $pass = "";
                                    for ($i = 0; $i < $number; $i++) {
                                        $index = rand(0, count($arr) - 1);
                                        $pass .= $arr[$index];
                                    }
                                    return $pass;

                                }

                                ;
                                $getpass = generate_password(15);
                                $newpass = md5($getpass);

                                $db->query("UPDATE `" . $func->servers[ucfirst($_POST['server'])]['MYSQL_TABLE'] . "` SET `" . $tableconf['TABLE_PASSWORD'] . "`='" . $newpass . "' WHERE `" . $tableconf['TABLE_NAME'] . "`='" . $login . "' AND `" . $tableconf['TABLE_MAIL'] . "`='" . $email . "'");

                                $subj = "=?utf-8?B?" . base64_encode("Восстановление пароля") . "?=";
                                $message = '
                                Аккаунт: ' . $login . '<br>
                                Игровой сервер: ' . $_POST['server'] . ' -> ' . $func->servers[ucfirst($_POST['server'])]['IP'] . ':' . $func->servers[ucfirst($_POST['server'])]['PORT'] . ' <br>
                                Новый пароль: ' . $getpass . '<br>
                                * после прочтения удалите письмо
                                ';
                                $headers = "Mime-Version: 1.0\n";
                                $headers .= "Content-type: text/html; charset=charset=utf-8\n";
                                $headers .= "Content-Transfer-Encoding: 8bit\n";
                                mail($email, $subj, $message, $headers);
                                $func->setPopUp("success", "Успешно", "На почту " . $mail . " отправлено письмо с новым паролем!");
                            }
                        }
                    }
                    $title = 'Восстановить доступ | SAMP: Korea Role Play - Играй в GTA: SA по сети!';
                    $page = PUBLIC_DIR.'/pages/recovery.php';
                    break;
                }
            }
            $title = 'Авторизация | SAMP: Korea Role Play - Играй в GTA: SA по сети!';
            $page = PUBLIC_DIR.'/pages/auth.php';
            break;
        }
        case 'captcha';{
            $stop = true;
            $string = "";
            for ($i = 0; $i < 5; $i++)
                $string .= chr(rand(97, 122));

            $_SESSION['rand_code'] = $string;

            $font = "assets/fonts/bloggersans/Bloggersans.ttf";

            $image = imagecreatetruecolor(100, 50);
            $color = imagecolorallocate($image, 94, 94, 94);
            $white = imagecolorallocate($image, 255, 255, 255);

            imagefilledrectangle($image,0,0,399,99,$white);
            imagettftext ($image, 29, 0, 11, 40, $color, $font, $_SESSION['rand_code']);

            header("Content-type: image/png");
            imagepng($image);
            break;
        }
        case 'email':{
            if(!$user->isAuthorized()) header("Location: /auth");
            if(isset($_POST['change'])){
                if($_SESSION['temp_mail'] != null && $_SESSION['temp_code'] != null && $_SESSION['temp_code'] == $url[2]){
                    $user->changeSettings($tableconf['TABLE_MAIL'], $_SESSION['temp_mail']);
                    $func->setPopUp("success","Успешно","Почта изменена!");
                    unset($_SESSION['temp_code']);
                    unset($_SESSION['temp_mail']);
                    header("Location: /account/settings");
                }else{
                    $func->setPopUp("error","Ошибка","Данный hash не найден!");
                    unset($_SESSION['temp_code']);
                    unset($_SESSION['temp_mail']);
                    header("Location: /account/settings");
                }
                break;
            }
            if($url[1] != null){
                if($url[1] != "confirm" || $url[2] == null || strlen($url[2]) < 15){
                    $page = PUBLIC_DIR.'/pages/404.php';
                    $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                    break;
                }
                $page = PUBLIC_DIR.'/pages/emailconfirm.php';
                break;
            }
            $page = PUBLIC_DIR.'/pages/404.php';
            $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
            break;
        }
        case 'security':{
            if($url[1] != null){
                if($url[1] == "google"){
                    require_once ENGINE_DIR.'/lib/GoogleAuthenticator.php';
                    $ga = new GoogleAuthenticator;
                    $_SESSION['ga_secret'] = $ga->createSecret();
                    $page = PUBLIC_DIR.'/pages/google.php';
                    $bodyclass = "userCab no-account aller";
                    $title = "Безопасность | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                    break;
                }
            }
            $page = PUBLIC_DIR.'/pages/404.php';
            $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
            break;
        }
        case 'account':{
            if(!$user->isAuthorized()) header("Location: /auth");
            $bodyclass = "userCab account aller";
            $title = "Профиль ".$user->player[$tableconf['TABLE_NAME']]." | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
            $footscripts = array(
                "/assets/js/jquery.spincrement.js",
                "/assets/js/jquery.viewportchecker.min.js",
                "/assets/bootstrap/js/bootstrap.min.js",
                "/assets/js/totop.js"
            );
            $scripts = array(
                "/assets/js/jquery.min.js",
                "/assets/js/wow.js"
            );
            if($url[1] != null){
                if($url[1] == "house"){
                    if(!$user->isAuthorized()) header("Location: /auth");
                    if($user->player[$tableconf["TABLE_HOUSE"]] == 9999){
                        $func->setPopUp("error","Ошибка","Отказано. У вас нет дома!");
                        header("Location: /account");
                    }else{
                        if(isset($_POST['house'])){
                            $func->setPopUp("error","Ошибка","В разработке!");
                        }
                        $bodyclass = "userCab no-account aller";
                        $title = "Мой дом | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                        $page = PUBLIC_DIR.'/pages/home.php';
                        $db = $func->getTempBase($_SESSION['server']);
                        $house = $db->query("SELECT * FROM `".$tableconf['TABLE_HOUSES']."` WHERE `id`=".$user->player[$tableconf['TABLE_HOUSE']]." LIMIT 1 ")->fetch_assoc();
                    }
                    break;
                }
                elseif($url[1] == "business"){
                    if(!$user->isAuthorized()) header("Location: /auth");
                    if($user->player[$tableconf["TABLE_BUSINESS"]] == 9999){
                        $func->setPopUp("error","Ошибка","Отказано. У вас нет Бизнеса!");
                        header("Location: /account");
                    }else{
                        if(isset($_POST['biz'])){
                            $func->setPopUp("error","Ошибка","В разработке!");
                        }
                        $bodyclass = "userCab no-account aller";
                        $title = "Мой Бизнес | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                        $page = PUBLIC_DIR.'/pages/business.php';
                        $db = $func->getTempBase($_SESSION['server']);
                        $biz = $db->query("SELECT * FROM `bizzes` WHERE `id`=".$user->player[$tableconf['TABLE_BUSINESS']]." LIMIT 1 ")->fetch_assoc();
                    }
                    break;
                }
                elseif($url[1] == "board"){
                    if(!$user->isAuthorized()) header("Location: /auth");
                    if($url[2] == null || $url[2] != "leader"){
                        $page = PUBLIC_DIR.'/pages/404.php';
                        $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                        break;
                    }
                    elseif($user->player[$tableconf['TABLE_LEADER']] == 0){
                        $func->setPopUp("error","Ошибка","Отказано. Вы не лидер!");
                        header("Location: /account");
                    }else{
                        if(isset($_POST['uninvite'])){
                            $name = $func->clearQuery($user->conn, $_POST['uninvite']);
                            if($name == $user->player[$tableconf['TABLE_NAME']]){
                                $func->setPopUp("error","Ошибка","Вы не можете уволить себя");
                            }else {
                                $uninvite = $user->getUser($name);
                                if ($uninvite[$tableconf['TABLE_MEMBER']] != $user->player[$tableconf['TABLE_MEMBER']]) {
                                    $func->setPopUp("error", "Ошибка", "Игрок не в вашей организации");
                                } else {
                                    $func->setPopUp("success", "Успех", "Игрок " . $name . " успешно уволен!");
                                    $user->conn->query("UPDATE `" . $func->servers[$_SESSION['server']]['MYSQL_TABLE'] . "` SET `" . $tableconf['TABLE_MEMBER'] . "` = 0 WHERE `" . $tableconf['TABLE_NAME'] . "`='" . $name . "'");
                                }
                            }
                        }
                        $bodyclass = "userCab no-account aller";
                        $title = "Моя организация | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                        $page = PUBLIC_DIR.'/pages/leader.php';
                        $db = $func->getTempBase($_SESSION['server']);
                        $leader = $db->query("SELECT * FROM `".$func->servers[$_SESSION['server']]['MYSQL_TABLE']."` WHERE `".$tableconf['TABLE_MEMBER']."`= ".$user->player[$tableconf['TABLE_MEMBER']]." ")->fetch_assoc_array();
                    }
                    break;
                }
                elseif($url[1] == "logout"){
                    if(!$user->isAuthorized()) header("Location: /auth");
                    session_unset();
                    session_destroy();
                    header("Location: /");
                    break;
                }
                elseif($url[1] == "settings"){
                    if(isset($_POST['setpass'])){
                        $lastpass = $func->clearQuery($user->conn,$_POST['lastpass']);
                        $newpass = $func->clearQuery($user->conn,$_POST['newpass']);
                        if(md5($lastpass) != $user->player[$tableconf['TABLE_PASSWORD']]){
                            $func->setPopUp("error","Отказано","Старый пароль не совпадает!");
                        }elseif(md5($newpass) == $user->player[$tableconf['TABLE_PASSWORD']]){
                            $func->setPopUp("error","Отказано","Новый и старый пароль одинаковы!");
                        }elseif(strlen($newpass) < 4 || strlen($newpass) > 16){
                            $func->setPopUp("error","Отказано","Пароль должен состоять от 4-ёх до 16 символов!");
                        }else{
                            $user->changeSettings($tableconf['TABLE_PASSWORD'],md5($newpass));
                            $func->setPopUp("success","Успешно","Пароль изменён!");
                        }
                    }
                    elseif(isset($_POST['setemail'])){
                        $lastemail = $func->clearQuery($user->conn,$_POST['lastemail']);
                        $newemail = $func->clearQuery($user->conn,$_POST['newemail']);
                        if($lastemail != $user->player[$tableconf['TABLE_MAIL']])
                            $func->setPopUp("error","Отказано","Старая почта не совпадает!");
                        elseif($newemail == $user->player[$tableconf['TABLE_MAIL']])
                            $func->setPopUp("error","Отказано","Новый и старый Email одинаковы!");
                        else{
                            $_SESSION['temp_mail'] = $newemail;
                            $code = "";

                            for ($i = 0; $i < 15; $i++)
                                $code .= chr(rand(97, 122));

                            $_SESSION['temp_code'] = $code;
                            $subj = "=?utf-8?B?" . base64_encode("Смена Email") . "?=";

                            $message = 'Вы запросили изменение почты.<br>
                            Аккаунт: '.$user->player[$tableconf['TABLE_NAME']].'<br>
                            Перейдите по ссылке, что бы закончить смену Email: <a href="http://'.$_SERVER['HTTP_HOST'].'/email/confirm/'.$code.'/" target="_blank">Перейти</a><br>
                            * после прочтения удалите письмо';

                            $headers = "Mime-Version: 1.0\n";
                            $headers .= "Content-type: text/html; charset=charset=utf-8\n";
                            $headers .= "Content-Transfer-Encoding: 8bit\n";
                            $user->sendMail($subj,$message,$headers);
                            $func->setPopUp("success","Успешно","На вашу почту, отправлена инструкция по изменению Email!");
                        }
                    }
                    $bodyclass = "userCab no-account aller";
                    $title = "Моя Безопасность | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
                    $page = PUBLIC_DIR.'/pages/settings.php';
                    break;
                }
            }
            $ucp = true;
            $page = PUBLIC_DIR.'/pages/account.php';
            break;
        }
        default: {
            $page = PUBLIC_DIR.'/pages/404.php';
            $title = "Оффлайн Страница | SAMP: Korea Role Play - Играй в GTA: SA по сети!";
        }
    }
}