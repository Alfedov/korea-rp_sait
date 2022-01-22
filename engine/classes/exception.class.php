<?php
/*
=====================================================
 Copyright (c) © 2017
=====================================================
 Файл: exception.class.php - Вывод ошибок от mysql
=====================================================
*/

class Database_Mysql_Exception extends Exception
{
    /*
     * Строим ошибку от mysql.class.php
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /*
     * Вид сообщение, выводимое пользователям
     */
    public function __toString() {
        return "{$this->message}";
    }
}