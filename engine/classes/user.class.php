<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: user.class.php - Файл для работы с игроками
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

class user{

    //Соль для генерации токена, можно сменить на другую!
    const salt = "ÞA×ú6eýE7GT½Ñ÷ØuÒõÊ°Ûñ¶ßÖÉ´ê»";

    public $conn;
    protected $servers;
    public $player;

    /*
     * Подключение к базе сервера
     */
    public function tryConnect($server){
        if(!$this->servers && !$this->conn && $server != null) {
            global $servers;
            $this->servers = $servers;
            $this->conn = Database_Mysql::create($servers[$server]["MYSQL_HOST"], $servers[$server]["MYSQL_LOGIN"], $servers[$server]["MYSQL_PASSWORD"])->setDatabaseName($servers[$server]["MYSQL_DB"]);
        }
    }

    /*
     * Деструктор, уничтожаем текущее подключение к базе
     */
    public function __destruct(){
        if($this->conn) $this->conn->__destruct();
        $this->servers = null;
        $this->conn = null;
    }

    /*
     * Проверяем авторизован ли пользователь, если да вернёт true если нет false
     */
    public function isAuthorized(){
        global $tableconf;
        if(isset($_SESSION["token"]) && isset($_SESSION["server"])){
            $this->tryConnect($_SESSION["server"]);
            if(!$this->player) $this->player = $this->conn->query("SELECT * FROM ".$this->servers[$_SESSION["server"]]["MYSQL_TABLE"]." WHERE `". $tableconf['TABLE_TOKEN'] ."` = '".$_SESSION["token"]."' ")->fetch_assoc();
            if($this->player[$tableconf['TABLE_TOKEN']] == $_SESSION["token"]) return true;
            else return false;
        }
        else return false;
    }

    /*
     * Получаем игрока с базы
     */
    public function getUser($name){
        global $func,$tableconf;
        $name = $func->clearQuery($this->conn,$name);
        return $this->conn->query("SELECT * FROM `".$func->servers[$_SESSION['server']]['MYSQL_TABLE']."` WHERE `".$tableconf['TABLE_NAME']."`='".$name."' ")->fetch_assoc();
    }

    /*
     * Изменяем параметр $what игрока на $onwhat
     */
    public function changeSettings($what,$onwhat){
        global $tableconf, $func;
        $this->tryConnect($_SESSION["server"]);
        $what = $func->clearQuery($this->conn,$what);
        $onwhat = $func->clearQuery($this->conn,$onwhat);
        $this->conn->query("UPDATE `".$this->servers[$_SESSION["server"]]["MYSQL_TABLE"]."` SET `".$what."` = '".$onwhat."' WHERE `".$tableconf['TABLE_NAME']."` = '".$this->player[$tableconf['TABLE_NAME']]."';");
    }

    /*
     * Отправка письма на почту игрока
     */
    public function sendMail($title, $message,$headers = ""){
        global $tableconf;
        mail($this->player[$tableconf['TABLE_MAIL']], $title, $message,$headers);
    }

    /*
     * Берём список игроков чтобы выводить на страницу
     */
    public function getListUsers($server,$page,$per_page = 3){
        global $func;
        $page = $func->clearQuery($this->conn,$page-1);
        return $this->conn->query("SELECT * FROM `".$func->servers[$server]['MYSQL_TABLE']."` ORDER BY `id` DESC LIMIT ".abs($page*$per_page).",".$per_page." ")->fetch_assoc_array();
    }

    /*
     * Удаляем игрока с базы
     */
    public function removeUser($id){
        global $func;
        $id = $func->clearQuery($this->conn,$id);
        $this->conn->query("DELETE FROM `".$func->servers[$_SESSION['server']]['MYSQL_TABLE']."` WHERE `id`=".$id." ");
    }

    /*
     * Получаем логи захода в ЛК игрока
     */
    public function getUserLog(){
        global $tableconf;
        return $this->conn->query("SELECT * FROM `log_auth` WHERE `name` = '".$this->player[$tableconf['TABLE_NAME']]."' ORDER BY `date` LIMIT 20")->fetch_assoc_array();
    }

    /*
     * Логируем пользователя в базу
     */
    private function logUser($login,$server){
        global $func;
        $this->conn->query("INSERT INTO `log_auth` VALUES('".$login."','".$server."','".strtotime(date('Y-m-d H:i:s'))."','".$func->getIp()."','".$func->getBrowser()."')");
    }

    /*
     * Авторизация пользователя на сайте
     * Идёт генерация токена для безопасности
     */
    public function authorizeUser($login, $password, $server){
        global $tableconf, $func;
        $this->tryConnect($server);
        $login = $func->clearQuery($this->conn,$login);
        $password = $func->clearQuery($this->conn,$password);
        //$secpass = $func->clearQuery($this->conn);
        $user = $this->conn->query("SELECT * FROM ".$this->servers[$server]["MYSQL_TABLE"]." WHERE `".$tableconf['TABLE_NAME']."` = '".$login."'; ")->fetch_assoc();
        if($user != null && $password == $user[$tableconf['TABLE_PASSWORD']]) {
            $this->logUser($login, $server);
            $_SESSION["server"] = $server;
            $_SESSION["token"] = md5($login.$password.self::salt.time());
            $this->conn->query("UPDATE `".$this->servers[$server]["MYSQL_TABLE"]."` SET `".$tableconf['TABLE_TOKEN']."` = '".$_SESSION["token"]."' WHERE `".$tableconf['TABLE_NAME']."` = '".$login."';");
            return true;
        }else return false;
    }
}