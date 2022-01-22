<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: news.class.php - Файл для работы с новостями
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

class news{

    private $conn;

    /*
     * Конструктор, создаем подключение к базе новостей
     */
    public function __construct($host, $login, $password, $database){
        $this->conn = Database_Mysql::create($host, $login, $password)->setCharset("utf8")->setDatabaseName($database);
    }

    /*
     * Деструктор, уничтожаем текущее подключение к базе
     */
    public function __destruct(){
        if($this->conn != null) $this->conn->__destruct();
        $this->conn = null;
    }

    /*
     * Получаем кол-во новостей в базе
     */
    public function getCountNews(){
        return $this->conn->query("SELECT * FROM `news`")->getNumRows();
    }

    /*
     * Обновление новости
     */
    public function updateNews($id,$title,$thumbnail,$html_preview){
        global $func;
        $id = $func->clearQuery($this->conn,$id);
        $title = $func->clearQuery($this->conn,$title);
        $thumbnail = $func->clearQuery($this->conn,$thumbnail);
        $html_preview = $this->conn->getMysqli()->real_escape_string($html_preview);
        $this->conn->query("UPDATE `news` SET `title` = '".$title."', `thumbnail` = '".$thumbnail."', `html_preview`='".$html_preview."' WHERE `id`=".$id." ");

    }

    /*
     * Берём новость с базы
     */
    public function getNews($id){
        global $func;
        $id = $func->clearQuery($this->conn,$id);
        return $this->conn->query("SELECT * FROM `news` WHERE `id`=".$id." ")->fetch_assoc();
    }

    /*
     * Добавление новости на сайт
     */
    public function addNews($title,$html_preview,$thumbnail){
        global $func;
        $title = $func->clearQuery($this->conn,$title);
        $html_preview = $this->conn->getMysqli()->real_escape_string($html_preview);
        $thumbnail = $func->clearQuery($this->conn,$thumbnail);
        $this->conn->query("INSERT INTO `news` VALUES(NULL,'".$title."', '".$html_preview."','".$thumbnail."',".time().") ");
    }

    /*
     * Удаляем новость с базы
     */
    public function removeNews($id){
        global $func;
        $id = $func->clearQuery($this->conn,$id);
        $this->conn->query("DELETE FROM `news` WHERE `id`=".$id." ");
    }

    /*
     * Получение списка новостей
     */
    public function getListNews($page,$per_page = 3){
        global $func;
        $page = $func->clearQuery($this->conn,$page-1);
        return $this->conn->query("SELECT * FROM `news` ORDER BY `created_at` DESC LIMIT ".abs($page*$per_page).",".$per_page." ")->fetch_assoc_array();
    }
}