<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: func.class.php - Файл с нужными функциями сайта
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

class payment{
    public $payid;
    private $payment_isset,$value,$paymentdb,$account,$server;

    /*
     * Проверяем платёж
     */
    public function checkPayment($paymentID, $summ = "-")
    {

        $row = $this->paymentdb->query("SELECT * FROM `payments` WHERE `id` = '{$paymentID}'");

        if (empty($row['acc'])) {
            return "Payment not found!";
        }

        if ($summ != '-' && (int) $summ != (int) $row['value']) {
            return "Not valid cost! Gived: {$summ}, Valid: {$row['value']}";
        }

        $this->payment_isset = true;
        $this->value = $row['value'];
        $this->server = $row['server'];
        $this->account = $row['acc'];
        $this->payid = $paymentID;

        return true;
    }

    /*
     * Выдаём бабло
     */
    public function givePayment()
    {
        global $tableconf;
        if (!$this->payment_isset) {
            return "Платёж не найден!";
        }

        if($tableconf['X2_DONATE']){
            $this->value *= $this->value;
        }

        $this->paymentdb->query("UPDATE `".$this->servers[$this->server]['MYSQL_TABLE']."` SET `".$tableconf['TABLE_DONATE']."`=".$tableconf['TABLE_DONATE']."+".$this->value." WHERE `".$tableconf['TABLE_ID']."`=".$this->account." ");

        $this->paymentdb->query("UPDATE `payments` SET `status` = 1, `log` = 'Успешно выдали {$this->value}' WHERE `id` = '{$this->payid}'");

        $this->payment_isset = false;
        $this->paymentdb = null;
        $this->payid = null;

        return true;
    }

    /*
     * Создаем платёж
     */
    public function createPayment($acc,$val,$server){
        global $func;
        $db = $func->getTempBase($server);
        $db->query("INSERT INTO `payments` (`acc`, `value`, `time`, `status`, `server`) VALUES ({$acc}, {$val}, '".time()."', 0, '{$server}')");
        $this->payid = $db->getLastInsertId();
        $this->paymentdb = $db;
    }

}