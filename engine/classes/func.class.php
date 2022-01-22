<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: func.class.php - Файл с нужными функциями сайта
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

class func{

    public $servers;
    public $online = 0;

    /*
     * Конструктор, ничего интересного
     */
    public function __construct(){
        global $servers;
        $this->servers = $servers;
    }

    /*
     * Устанавливаем всплывающее окно, если $type == success - окно зелёное
     * если $type == error - окно красное
     */
    public function setPopUp($type,$title,$message){
        $popup['title'] = $title;
        $popup['message'] = $message;
        $_SESSION[$type] = $popup;
    }

    /*
     * Очистка строки от грязи и SQL Injection
     */
    public function clearQuery($db,$string){
        if($db == null || $string == null || !is_scalar($string)){
            return "";
        }
        return $db->getMysqli()->real_escape_string(htmlentities(htmlspecialchars(strip_tags($string))));
    }

    /*
     * Срань господня, да это же пизд*ц
     */
    public function getTempBase($server){
        return Database_Mysql::create($this->servers[$server]["MYSQL_HOST"], $this->servers[$server]["MYSQL_LOGIN"], $this->servers[$server]["MYSQL_PASSWORD"])->setDatabaseName($this->servers[$server]["MYSQL_DB"]);
    }

    /*
     * Получаем класс дома
     */
    public function getHouseClass($id,$ev = false){
        switch($id){
            case 1:{
                ($ev == true) ? $class = "Эконом" : $class = "Эконом";
                break;
            }
            case 2:{
                ($ev == true) ? $class = "Среднего" : $class = "Средний";
                break;
            }
            case 3:{
                ($ev == true) ? $class = "Высшего" : $class = "Высший";
                break;
            }
            case 4:{
                ($ev == true) ? $class = "Элитного" : $class = "Элитный";
                break;
            }
            default:{
                ($ev == true) ? $class = "Эконом" : $class = "Эконом";
            }
        }
        return $class;
    }

    /*
     * Получение онлайна со всех серверов
     */
    public function getOnlineFromAllServers(){
        if($this->servers == null)
            return;

        foreach($this->servers as $key=>$value) {
            $info = $this->query_live('samp',$this->servers[$key]{"IP"},$this->servers[$key]["PORT"],'s');
            $this->servers[$key]["ONLINE"] = $info['s']["players"];
            $this->servers[$key]["MAXPLAYERS"] = $info['s']["playersmax"];
            $this->online = $this->online+$this->servers[$key]["ONLINE"];
        }
    }

    /*
     * Получение дату в формате Часов:минут:секунд / день-месяц-год
     */
	public function getTime($time){
		return date('H:i:s / j-n-Y ',$time);
	}

	/*
	 * Форматируем число до формата 100 000 (Ставим пробел)
	 */
	public function formatNumber($number){
	    return number_format($number, 0, '.', ' ');
    }


    /*
     * Получение ip пользователя
     */
    public function getIp()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    /*
     * Получение браузера пользователя
     */
    public function getBrowser() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/MSIE/i',$agent) && !preg_match('/Opera/i',$agent)) $browser = 'Internet Explorer';
        elseif(preg_match('/Firefox/i',$agent)) $browser = 'Mozilla Firefox';
        elseif(preg_match('/Chrome/i',$agent)) $browser = 'Google Chrome';
        elseif(preg_match('/Safari/i',$agent)) $browser = 'Apple Safari';
        elseif(preg_match('/Opera/i',$agent)) $browser = 'Opera';
        elseif(preg_match('/Opera Mini/i',$agent)) $browser = 'Opera Mini';
        elseif(preg_match('/Netscape/i',$agent)) $browser = 'Netscape';
        else $browser = 'Неизвестно';
        return $browser;
    }

    /*
     * Получаем организацию по айдишнику
     */
    public function getOrgan($id){
        switch($id){
            default:{
                $organ = "Отсутсвует";
            }
        }
        return $organ;
    }

    /*
     * Получаем подразделение по айдишнику
     */
    public function getUnit($id){
        switch($id){
            default:{
                $unit = "Отсутсвует";
            }
        }
        return $unit;
    }

    /*
     * Получаем работу по айдишнику
     */
    public function getWork($id){
        switch($id){
            case 1:{
                $work = "Водитель мусоровоза";
                break;
            }
            case 2:{
                $work = "Рыбак";
                break;
            }
            case 3:{
                $work = "Водитель автобуса";
                break;
            }
            case 4:{
                $work = "Таксист";
                break;
            }
            case 5:{
                $work = "Ремонтник дорог";
                break;
            }
            case 6:{
                $work = "Механик";
                break;
            }
            case 7:{
                $work = "Развозчик продуктов/топлива";
                break;
            }
            case 8:{
                $work = "Дальнобойщик";
                break;
            }
            default:{
                $work = "Отсутсвует";
            }
        }
        return $work;
    }

    /*
     * Вывод шаблона под пользователя
     * Нужен для определения, в одной ли ячейке оружие/лицензии
     */
    public function getWals($wal = "weapons"){
	    global $tableconf,$user;
	    if($wal == "lics"){
            if($tableconf['LICS_IN_ONE']){
                sscanf($user->player[$tableconf['TABLE_LICS']], "%d,%d,%d,%d,%d",$clic,$fly,$water,$weapon,$biz);
                $template = '<p><i class=" ' . ($clic == 1 ? "yes" : "no") . ' "><i class="fa fa-times" aria-hidden="true"></i></i>Наземный транспорт</p>
                                    <p><i class=" '. ($fly == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Воздушный транспорт</p>
                                    <p><i class=" '. ($water == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Водный транспорт</p>
                                    <p><i class=" '. ($weapon == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Оружие</p>
                                    <p><i class=" '. ($biz == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Бизнес</p>';
            }else{
                $template = '<p><i class=" '. ($user->player[$tableconf["TABLE_CLIC"]] == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Наземный транспорт</p>
                                    <p><i class="'. ($user->player[$tableconf["TABLE_FLYLIC"]] == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Воздушный транспорт</p>
                                    <p><i class="'. ($user->player[$tableconf["TABLE_WATLIC"]] == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Водный транспорт</p>
                                    <p><i class="'. ($user->player[$tableconf["TABLE_WEAPLIC"]] == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Оружие</p>
                                    <p><i class="'. ($user->player[$tableconf["TABLE_BIZLIC"]] == 1 ? "yes" : "no") .' "><i class="fa fa-times" aria-hidden="true"></i></i>Бизнес</p>';
            }
        }else {
            if ($tableconf['WEAPON_IN_ONE']) {
                sscanf($user->player[$tableconf['TABLE_WEAPONS']], "%d,%d,%d,%d,%d,%d",$spistol,$pistol,$shotgun,$mp5,$ak47,$m4);
                $template = "
                            <div class='oneGun'>
                                <img src='/assets/img/spistol.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$spistol."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$spistol."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/pistol.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$pistol."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$pistol."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/shotgun.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$shotgun."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$shotgun."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/mp5.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$mp5."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$mp5."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/ak47.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$ak47."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$ak47."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/m4.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$m4."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$m4."%'></div></div>
                            </div>
                ";
            } else {
                $template = "
                            <div class='oneGun'>
                                <img src='/assets/img/spistol.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_SPISTOL']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_SPISTOL']]."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/pistol.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_PISTOL']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_PISTOL']]."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/shotgun.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_SHOTGUN']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_SHOTGUN']]."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/mp5.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_MP5']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_MP5']]."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/ak47.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_AK47']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_AK47']]."%'></div></div>
                            </div>
                            <div class='oneGun'>
                                <img src='/assets/img/m4.png'>
                                <p><span class='right'>100<b>%</b></span><span><span class='spincrement'>".$user->player[$tableconf['TABLE_M4']]."</span><b>%</b></span></p>
                                <div id='progress'><div style='width:".$user->player[$tableconf['TABLE_M4']]."%'></div></div>
                            </div>
                ";
            }
        }
        return $template;
    }

    /*
     * Получение онлайна с серверов, дальше не трогать!
     */
	private function query_live($type,$ip,$q_port,$request)
	{
		if(preg_match("/[^0-9a-z\.\-\[\]\:]/i",$ip))
			return;

		if (!intval($q_port))
			return;
			
		$server = array('b'=>array('type'=>$type,'ip'=>$ip,'q_port'=>$q_port,'status'=>1), 's'=>array('game'=>'','name'=>'','map'=>'','players'=>0,'playersmax'=>0,'password'=>''));
		$response = $this->query_direct($server,$request,'udp');
		if (!$response) 
		{
			$server['b']['status'] = 0;
		}
		else
		{
			if (empty($server['s']['game']))
				$server['s']['game'] = $type;
			
			if (empty($server['s']['map']))
				$server['s']['map']  = '-';
		
			if (($pos = strrpos($server['s']['map'],'/'))  !== FALSE)
				$server['s']['map'] = substr($server['s']['map'],$pos +1);
			
			if (($pos = strrpos($server['s']['map'],'\\')) !== FALSE)
				$server['s']['map'] = substr($server['s']['map'],$pos +1);
			
			$server['s']['players'] = intval($server['s']['players']);
			$server['s']['playersmax'] = intval($server['s']['playersmax']);
			
			if (isset($server['s']['password'][0]))
				$server['s']['password'] = (strtolower($server['s']['password'][0]) == 't') ?1 : 0;
			else
				$server['s']['password'] = intval($server['s']['password']);
			
			if (strpos($request,'e') === FALSE &&empty($server['e']))
				unset($server['e']);
			
			if (strpos($request,'s') === FALSE &&empty($server['s']['name']))
				unset($server['s']);
		}
		return $server;
	}
	
	private function query_direct(&$server,$request,$scheme)
	{
		$fp = @fsockopen($scheme.'://'.$server['b']['ip'],$server['b']['q_port'],$errno,$errstr,1);
		
		if (!$fp)
			return FALSE;
		
		$config['timeout'] = 0;
		stream_set_timeout($fp,$config['timeout'],$config['timeout'] ?0 : 500000);
		stream_set_blocking($fp,TRUE);
		
		$need = array();
		$need['s'] = strpos($request,'s') !== FALSE ?TRUE : FALSE;
		$need['e'] = strpos($request,'e') !== FALSE ?TRUE : FALSE;
		$need['p'] = strpos($request,'p') !== FALSE ?TRUE : FALSE;
		
		if ($need['e'] &&!$need['s']) $need['s'] = TRUE;
		do
		{
			$need_check = $need;
			$response = $this->query_12($server,$need,$fp);
			
			if (!$response)
				break;
			
			if ($need_check == $need)
				break;
			
			if ($need['p'] &&$server['s']['players'] == '0')
				$need['p'] = FALSE;
		}
		while ($need['s'] == TRUE ||$need['e'] == TRUE ||$need['p'] == TRUE);
		
		@fclose($fp);
		return $response;
	}
	
	private function query_12(&$server, &$need, &$fp)
	{
		if($server['b']['type'] == "samp")
			$challenge_packet = "SAMP\x21\x21\x21\x21\x00\x00";
		
		if($need['s'])
			$challenge_packet.="i";
		elseif($need['e'])
			$challenge_packet.="r";
		elseif($need['p'])
			$challenge_packet.="d";

		fwrite($fp,$challenge_packet);

		$buffer=fread($fp,4096);

		if(!$buffer)
			return $need['s']?false:true;

		$buffer=substr($buffer,10);

		$response_type = $this->cutByte($buffer,1);

		if($response_type=="i")
		{
			$need['s'] = false;

			$server['s']['password']   = ord($this->cutByte($buffer, 1));
			$server['s']['players']    = $this->lektingUnpack($this->cutByte($buffer, 2), "S");
			$server['s']['playersmax'] = $this->lektingUnpack($this->cutByte($buffer, 2), "S");
			$server['s']['name']       = $this->cutPascal($buffer, 4);
			$server['e']['gamemode']   = $this->cutPascal($buffer, 4);
			$server['s']['map']        = $this->cutPascal($buffer, 4);
			
		}
		elseif($response_type == "r")
		{
			$need['e'] = false;

			$item_total = $this->lektingUnpack($this->cutByte($buffer, 2), "S");

			for($i=0; $i<$item_total; $i++)
			{
				if(!$buffer)
					return false;

				$data_key   = strtolower($this->cutPascal($buffer));
				$data_value = $this->cutPascal($buffer);

				$server['e'][$data_key] = $data_value;
			}
		}
		elseif($response_type == "d")
		{
			$need['p'] = false;

			$player_total = $this->lektingUnpack($this->cutByte($buffer, 2), "S");

			for ($i=0; $i<$player_total; $i++)
			{
				$server['p'][$i]['pid']   = ord($this->cutByte($buffer, 1));
				$server['p'][$i]['name']  = $this->cutPascal($buffer);
				$server['p'][$i]['score'] = $this->lektingUnpack($this->cutByte($buffer, 4), "S");
				$server['p'][$i]['ping']  = $this->lektingUnpack($this->cutByte($buffer, 4), "S");
			}
		}
		return true;
	}
	
	private function lektingUnpack($string,$format)
	{
		list(,$string)=@unpack($format,$string);
		return $string;
	}
	
	
	private function cutByte(&$buffer,$length)
	{
		$string=substr($buffer,0,$length);
		$buffer=substr($buffer,$length);
		return $string;
	}
	
	private function cutPascal(&$buffer,$start_byte=1,$length_adjust=0,$end_byte=0)
	{
		$length=ord(substr($buffer,0,$start_byte))+$length_adjust;
		$string=substr($buffer,$start_byte,$length);
		$buffer=substr($buffer,$start_byte+$length+$end_byte);
		return $string;
	}

}