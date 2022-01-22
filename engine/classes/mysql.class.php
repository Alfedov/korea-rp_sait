<?php
/*
=====================================================
 Copyright (c) © 2022
=====================================================
 Файл: mysql.class.php - Файл для работы с базой
=====================================================
*/
if(!defined("GRANDRULZ")) exit("HACKING ATTEMPT!");

class Database_Mysql
{
    /**
     * Строгий режим типизации.
     * Если тип заполнителя не совпадает с типом аргумента, то будет выброшено исключение.
     * Пример такой ситуации:
     *
     * $db->query('SELECT * FROM `table` WHERE `id` = ?i', '2+мусор');
     *
     * - в данной ситуации тип заполнителя ?i - число или числовая строка,
     *   а в качестве аргумента передаётся строка '2+мусор' не являющаяся ни числом, ни числовой строкой.
     *
     * @var int
     */
    const MODE_STRICT = 1;

    /**
     * Режим преобразования.
     * Если тип заполнителя не совпадает с типом аргумента, аргумент принудительно будет приведён
     * к нужному типу - к типу заполнителя.
     * Пример такой ситуации:
     *
     * $db->query('SELECT * FROM `table` WHERE `id` = ?i', '2+мусор');
     *
     * - в данной ситуации тип заполнителя ?i - число или числовая строка,
     *   а в качестве аргумента передаётся строка '2+мусор' не являющаяся ни числом, ни числовой строкой.
     *   Строка '2+мусор' будет принудительно приведена к типу int согласно правилам преобразования типов в PHP.
     *
     * @var int
     */
    const MODE_TRANSFORM = 2;

    /**
     * Режим работы инстанцированного объекта.
     * См. описание констант self::MODE_STRICT и self::MODE_TRANSFORM.
     *
     * @var int
     */
    protected $type_mode = self::MODE_TRANSFORM;

    protected $server;

    protected $user;

    protected $password;

    protected $port;

    protected $socket;

    /**
     * Имя текущей БД.
     *
     * @var string
     */
    protected $database_name;

    /**
     * Стандартный объект соединения сервером MySQL.
     *
     * @var mysqli
     */
    protected $mysqli;

    /**
     * Строка последнего SQL-запроса до преобразования.
     *
     * @var string
     */
    private $original_query;

    /**
     * Строка последнего SQL-запроса после преобразования.
     *
     * @var string
     */
    private $query;

    /**
     * Массив со всеми запросами, которые были выполнены объектом.
     * Ключи - SQL после преобразования, значения - SQL до преобразования.
     *
     * @var array
     */
    private $queries = array();

    /**
     * Накапливать ли в хранилище $this->queries исполненные запросы.
     *
     * @var bool
     */
    private $store_queries = true;

    /**
     * Создает инстанс данного класса.
     *
     * @param string $server имя сервера
     * @param string $username имя пользователя
     * @param string $password пароль
     * @param string $port порт
     * @param string $socket сокет
     */
    public static function create($server, $username, $password, $port=null, $socket=null)
    {
        return new self($server, $username, $password, $port, $socket);
    }

    /**
     * Задает набор символов по умолчанию.
     * Вызов данного метода эквивалентен следующей установки конфигурации MySql-сервера:
     * SET character_set_client = charset_name;
     * SET character_set_results = charset_name;
     * SET character_set_connection = charset_name;
     *
     * @param string $charset
     * @return Database_Mysql
     */
    public function setCharset($charset)
    {
        if (!$this->mysqli->set_charset($charset)) {
            throw new Database_Mysql_Exception(__METHOD__ . ': ' . $this->mysqli->error);
        }

        return $this;
    }

    /**
     * Возвращает кодировку по умолчанию, установленную для соединения с БД.
     *
     * @param void
     * @return string
     */
    public function getCharset()
    {
        return $this->mysqli->character_set_name();
    }

    /**
     * Устанавливает имя используемой СУБД.
     *
     * @param string имя базы данных
     * @return Database_Mysql
     */
    public function setDatabaseName($database_name)
    {
        if (!$database_name) {
            throw new Database_Mysql_Exception(__METHOD__ . ': Не указано имя базы данных');
        }

        $this->database_name = $database_name;

        if (!$this->mysqli->select_db($this->database_name)) {
            throw new Database_Mysql_Exception(__METHOD__ . ': ' . $this->mysqli->error);
        }

        return $this;
    }

    /**
     * Возвращает имя текущей БД.
     *
     * @param void
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    /**
     * Устанавливает режим поведения при несовпадении типа заполнителя и типа аргумента.
     *
     * @param $value int
     * @return Database_Mysql
     */
    public function setTypeMode($value)
    {
        if (!in_array($value, array(self::MODE_STRICT, self::MODE_TRANSFORM))) {
            throw new Database_Mysql_Exception(__METHOD__ . ': Указан неизвестный тип режима');
        }

        $this->type_mode = $value;

        return $this;
    }

    /**
     * Устанавливает свойство $this->store_queries, отвечающее за накопление исполненных запросов в
     * хранилище $this->queries.
     *
     * @param bool $value
     * @return Database_Mysql
     */
    public function setStoreQueries($value)
    {
        $this->store_queries = (bool) $value;

        return $this;
    }

    /**
     * Выполняет SQL-запрос.
     * Принимает обязательный параметр - SQL-запрос и, в случае наличия,
     * любое количество аргументов - значения заполнителей.
     *
     * @param string строка SQL-запроса
     * @param mixed аргументы для заполнителей
     * @return bool|Database_Mysql_Statement false в случае ошибки, в обратном случае объект результата
     */
    public function query()
    {
        if (!func_num_args()) {
            return false;
        }

        $args = func_get_args();

        $query = $this->original_query = array_shift($args);

        $this->query = $this->parse($query, $args);

        $result = $this->mysqli->query($this->query);

        if ($this->store_queries) {
            $this->queries[$this->query] = $this->original_query;
        }

        if ($result === false) {
           print_r(__METHOD__ . ': ' . $this->mysqli->error . '; SQL: ' . $this->query);
        }

        if (is_object($result) && $result instanceof mysqli_result) {
            return new Database_Mysql_Statement($result);
        }

        return $result;
    }

    /**
     * Поведение аналогично методу self::query(), только метод принимает только два параметра -
     * SQL запрос $query и массив аргументов $arguments, которые и будут заменены на заменители в той
     * последовательности, в которой они представленны в массиве $arguments.
     *
     * @param string
     * @param array
     * @return bool|Database_Mysql_Statement
     */
    public function queryArguments($query, array $arguments=array())
    {
        array_unshift($arguments, $query);

        return call_user_func_array(array($this, 'query'), $arguments);
    }

    /**
     * Обёртка над методом $this->parse().
     * Применяется для случаев, когда SQL-запрос формируется частями.
     *
     * Пример:
     *     $db->prepare('WHERE `name` = "?s" OR `id` IN(?ai)', 'Василий', array(1, 2));
     * Результат:
     *     WHERE `name` = "Василий" OR `id` IN(1, 2)
     *
     * @param string SQL-запрос или его часть
     * @param mixed аргументы заполнителей
     * @return boolean|string
     */
    public function prepare()
    {
        if (!func_num_args()) {
            return false;
        }

        $args = func_get_args();
        $query = array_shift($args);

        return $this->parse($query, $args);
    }

    /**
     * Получает количество рядов, задействованных в предыдущей MySQL-операции.
     * Возвращает количество рядов, задействованных в последнем запросе INSERT, UPDATE или DELETE.
     * Если последним запросом был DELETE без оператора WHERE,
     * все записи таблицы будут удалены, но функция возвратит ноль.
     *
     * @see mysqli_affected_rows
     * @param void
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->mysqli->affected_rows;
    }

    /**
     * Возвращает последний оригинальный SQL-запрос до преобразования.
     *
     * @param void
     * @return string
     */
    public function getOriginalQueryString()
    {
        return $this->original_query;
    }

    /**
     * Возвращает последний выполненный MySQL-запрос (после преобразования).
     *
     * @param void
     * @return string
     */
    public function getQueryString()
    {
        return $this->query;
    }

    /**
     * Возвращает массив со всеми исполненными SQL-запросами в рамках текущего объекта.
     *
     * @param void
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * Возвращает id, сгенерированный предыдущей операцией INSERT.
     *
     * @param void
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->mysqli->insert_id;
    }

    /**
     * Возвращает оригинальный объект mysqli.
     *
     * @param void
     * @return mysqli
     */
    public function getMysqli()
    {
        return $this->mysqli;
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * @param string $server
     * @param string $user
     * @param string $password
     * @param string $port
     * @param string $socket
     */
    private function __construct($server, $user, $password, $port, $socket)
    {
        $this->server   = $server;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->socket = $socket;

        $this->connect();
    }

    /**
     * Устанавливает соеденение с базой данных.
     */
    private function connect()
    {
        if (!is_object($this->mysqli) || !$this->mysqli instanceof mysqli) {
            $this->mysqli = @new mysqli($this->server, $this->user, $this->password, null, $this->port, $this->socket);

            if ($this->mysqli->connect_error) {
                throw new Database_Mysql_Exception(__METHOD__ . ': ' . $this->mysqli->connect_error);
            }
        }
    }

    /**
     * Закрывает MySQL-соединение.
     *
     * @return Database_Mysql
     */
    private function close()
    {
        if (is_object($this->mysqli) && $this->mysqli instanceof mysqli) {
            @$this->mysqli->close();
        }

        return $this;
    }

    /**
     * Возвращает экранированную строку для placeholder-а поиска LIKE (?S).
     *
     * @param string $var строка в которой необходимо экранировать спец. символы
     * @param string $chars набор символов, которые так же необходимо экранировать.
     *                      По умолчанию экранируются следующие символы: `'"%_`.
     * @return string
     */
    private function escapeLike($var, $chars = "%_")
    {
        $var = str_replace('\\', '\\\\', $var);
        $var = $this->mysqlRealEscapeString($var);

        if ($chars) {
            $var = addCslashes($var, $chars);
        }

        return $var;
    }

    /**
     * Экранирует специальные символы в строке для использования в SQL выражении,
     * используя текущий набор символов соединения.
     *
     * @see mysqli_real_escape_string
     * @param string
     * @return string
     */
    public function mysqlRealEscapeString($value)
    {
        return $this->mysqli->real_escape_string($value);
    }

    /**
     * Возвращает строку описания ошибки при несовпадении типов заполнителей и аргументов.
     *
     * @param string $type тип заполнителя
     * @param mixed $value значение аргумента
     * @param string $original_query оригинальный SQL-запрос
     * @return string
     */
    private function createErrorMessage($type, $value, $original_query)
    {
        return "Попытка указать для заполнителя типа $type значение типа " . gettype($value) . " в шаблоне запроса $original_query";
    }

    /**
     * Парсит запрос $query и подставляет в него аргументы из $args.
     *
     * @param string $query SQL запрос или его часть (в случае парсинга условия в скобках [])
     * @param array $args аргументы заполнителей
     * @param string $original_query "оригинальный", полный SQL-запрос
     * @return string SQL запрос для исполнения
     */
    private function parse($query, array $args, $original_query=null)
    {
        $original_query = $original_query ? $original_query : $query;

        $offset = 0;

        while (($posQM = mb_strpos($query, '?', $offset)) !== false) {
            $offset = $posQM;

            $placeholder_type = mb_substr($query, $posQM + 1, 1);

            // Любые ситуации с нахождением знака вопроса, который не явялется заполнителем.
            if ($placeholder_type == '' || !in_array($placeholder_type, array('i', 'd', 's', 'S', 'n', 'A', 'a', 'f'))) {
                $offset += 1;
                continue;
            }

            if (!$args) {
                throw new Database_Mysql_Exception(
                    __METHOD__ . ': количество заполнителей в запросе ' . $original_query .
                    ' не соответствует переданному количеству аргументов'
                );
            }

            $value = array_shift($args);

            switch ($placeholder_type) {
                // `LIKE` search escaping
                case 'S':
                    $is_like_escaping = true;

                // Simple string escaping
                // В случае установки MODE_TRANSFORM режима, преобразование происходит согласно правилам php типизации
                // http://php.net/manual/ru/language.types.string.php#language.types.string.casting
                // для bool, null и numeric типа.
                case 's':
                    $value = $this->getValueStringType($value, $original_query);
                    $value = !empty($is_like_escaping) ? $this->escapeLike($value) : $this->mysqlRealEscapeString($value);
                    $query = $this->mb_substr_replace($query, $value, $posQM, 2);
                    $offset += mb_strlen($value);
                    break;

                // Integer
                // В случае установки MODE_TRANSFORM режима, преобразование происходит согласно правилам php типизации
                // http://php.net/manual/ru/language.types.integer.php#language.types.integer.casting
                // для bool, null и string типа.
                case 'i':
                    $value = $this->getValueIntType($value, $original_query);
                    $query = $this->mb_substr_replace($query, $value, $posQM, 2);
                    $offset += mb_strlen($value);
                    break;

                // Floating point
                case 'd':
                    $value = $this->getValueFloatType($value, $original_query);
                    $query = $this->mb_substr_replace($query, $value, $posQM, 2);
                    $offset += mb_strlen($value);
                    break;

                // NULL insert
                case 'n':
                    $value = $this->getValueNullType($value, $original_query);
                    $query = $this->mb_substr_replace($query, $value, $posQM, 2);
                    $offset += mb_strlen($value);
                    break;

                // field or table name
                case 'f':
                    $value = $this->escapeFieldName($value, $original_query);
                    $query = $this->mb_substr_replace($query, $value, $posQM, 2);
                    $offset += mb_strlen($value);
                    break;

                // Парсинг массивов.

                // Associative array
                case 'A':
                    $is_associative_array = true;

                // Simple array
                case 'a':
                    $value = $this->getValueArrayType($value, $original_query);

                    $next_char = mb_substr($query, $posQM + 2, 1);

                    if ($next_char != '' && preg_match('#[sid\[]#u', $next_char, $matches)) {
                        // Парсим выражение вида ?a[?i, "?s", "?s"]
                        if ($next_char == '[' and ($close = mb_strpos($query, ']', $posQM+3)) !== false) {
                            // Выражение между скобками [ и ]
                            $array_parse = mb_substr($query, $posQM+3, $close - ($posQM+3));
                            $array_parse = trim($array_parse);
                            $placeholders = array_map('trim', explode(',', $array_parse));

                            if (count($value) != count($placeholders)) {
                                throw new Database_Mysql_Exception('Несовпадение количества аргументов и заполнителей в массиве, запрос ' . $original_query);
                            }

                            reset($value);
                            reset($placeholders);

                            $replacements = array();

                            foreach ($placeholders as $placeholder) {
                                list($key, $val) = each($value);
                                $replacements[$key] = $this->parse($placeholder, array($val), $original_query);
                            }

                            if (!empty($is_associative_array)) {
                                foreach ($replacements as $key => $val) {
                                    $values[] = $this->escapeFieldName($key, $original_query) . ' = ' . $val;
                                }

                                $value = implode(',', $values);
                            } else {
                                $value = implode(', ', $replacements);
                            }

                            $query = $this->mb_substr_replace($query, $value, $posQM, 4 + mb_strlen($array_parse));
                            $offset += mb_strlen($value);
                        }
                        // Выражение вида ?ai, ?as, ?ap
                        else if (preg_match('#[sid]#u', $next_char, $matches)) {
                            $sql = '';
                            $parts = array();

                            foreach ($value as $key => $val) {
                                switch ($matches[0]) {
                                    case 's':
                                        $val = $this->getValueStringType($val, $original_query);
                                        $val = $this->mysqlRealEscapeString($val);
                                        break;
                                    case 'i':
                                        $val = $this->getValueIntType($val, $original_query);
                                        break;
                                    case 'd':
                                        $val = $this->getValueFloatType($val, $original_query);
                                        break;
                                }

                                if (!empty($is_associative_array)) {
                                    $parts[] = $this->escapeFieldName($key, $original_query) . ' = "' . $val . '"';
                                } else {
                                    $parts[] = '"' . $val . '"';
                                }
                            }

                            $value = implode(', ', $parts);
                            $value = $value !== '' ? $value : 'NULL';

                            $query = $this->mb_substr_replace($query, $value, $posQM, 3);
                            $offset += mb_strlen($value);
                        }
                    } else {
                        throw new Database_Mysql_Exception('Попытка воспользоваться заполнителем массива без указания типа данных его элементов');
                    }

                    break;
            }
        }

        return $query;
    }

    /**
     * В зависимости от типа режима возвращает либо строковое значение $value,
     * либо кидает исключение.
     *
     * @param mixed $value
     * @param string $original_query оригинальный SQL запрос
     * @throws Exception
     * @return string
     */
    private function getValueStringType($value, $original_query)
    {
        if (!is_string($value) && $this->type_mode == self::MODE_STRICT) {
            // Если это числовой string, меняем его тип для вывода в тексте исключения его типа.
            if ($this->isInteger($value) || $this->isFloat($value)) {
                $value += 0;
            }

            throw new Database_Mysql_Exception($this->createErrorMessage('string', $value, $original_query));
        }

        // меняем поведение PHP в отношении приведения bool к string
        if (is_bool($value)) {
            return (string) (int) $value;
        }

        if (!is_string($value) && !(is_numeric($value) || is_null($value))) {
            throw new Database_Mysql_Exception($this->createErrorMessage('string', $value, $original_query));
        }

        return (string) $value;
    }

    /**
     * В зависимости от типа режима возвращает либо строковое значение числа $value,
     * приведенного к типу int, либо кидает исключение.
     *
     * @param mixed $value
     * @param string $original_query оригинальный SQL запрос
     * @throws Exception
     * @return string
     */
    private function getValueIntType($value, $original_query)
    {
        if ($this->isInteger($value)) {
            return $value;
        }

        switch ($this->type_mode) {
            case self::MODE_TRANSFORM:
                if ($this->isFloat($value) || is_null($value) || is_bool($value)) {
                    return (int) $value;
                }

            case self::MODE_STRICT:
                // Если это числовой string, меняем его тип для вывода в тексте исключения его типа.
                if ($this->isFloat($value)) {
                    $value += 0;
                }
                throw new Database_Mysql_Exception($this->createErrorMessage('integer', $value, $original_query));
        }
    }

    /**
     * В зависимости от типа режима возвращает либо строковое значение числа $value,
     * приведенного к типу float, либо кидает исключение.
     *
     * Внимание! Разделитель целой и дробной части, возвращаемый float, может не совпадать с разделителем СУБД.
     * Для установки необходимого разделителя дробной части используйте setlocale().
     *
     * @param mixed $value
     * @param string $original_query оригинальный SQL запрос
     * @throws Exception
     * @return string
     */
    private function getValueFloatType($value, $original_query)
    {
        if ($this->isFloat($value)) {
            return $value;
        }

        switch ($this->type_mode) {
            case self::MODE_TRANSFORM:
                if ($this->isInteger($value) || is_null($value) || is_bool($value)) {
                    return (float) $value;
                }

            case self::MODE_STRICT:
                // Если это числовой string, меняем его тип на int для вывода в тексте исключения.
                if ($this->isInteger($value)) {
                    $value += 0;
                }
                throw new Database_Mysql_Exception($this->createErrorMessage('double', $value, $original_query));
        }
    }

    /**
     * В зависимости от типа режима возвращает либо строковое значение 'NULL',
     * либо кидает исключение.
     *
     * @param mixed $value
     * @param string $original_query оригинальный SQL запрос
     * @throws Exception
     * @return string
     */
    private function getValueNullType($value, $original_query)
    {
        if ($value !== null && $this->type_mode == self::MODE_STRICT) {
            // Если это числовой string, меняем его тип для вывода в тексте исключения его типа.
            if ($this->isInteger($value) || $this->isFloat($value)) {
                $value += 0;
            }

            throw new Database_Mysql_Exception($this->createErrorMessage('NULL', $value, $original_query));
        }

        return 'NULL';
    }

    /**
     * Всегда генерирует исключение, если $value не является массивом.
     * Первоначально была идея в режиме self::MODE_TRANSFORM приводить к типу array
     * скалярные данные, но на данный момент я считаю это излишним послаблением для клиентов,
     * которые будут использовать данный класс.
     *
     * @param mixed $value
     * @param string $original_query
     * @throws Exception
     * @return array
     */
    private function getValueArrayType($value, $original_query)
    {
        if (!is_array($value)) {
            throw new Database_Mysql_Exception($this->createErrorMessage('array', $value, $original_query));
        }

        return $value;
    }

    /**
     * Экранирует имя поля таблицы или столбца.
     *
     * @param string $value
     * @return string $value
     */
    private function escapeFieldName($value, $original_query)
    {
        if (!is_string($value)) {
            throw new Database_Mysql_Exception($this->createErrorMessage('field', $value, $original_query));
        }

        $new_value = '';

        $replace = function($value){
            return '`' . str_replace("`", "``", $value) . '`';
        };

        // Признак обнаружения символа текущей базы данных
        $dot = false;

        if ($values = explode('.', $value)) {
            foreach ($values as $value) {
                if ($value === '') {
                    if (!$dot) {
                        $dot = true;
                        $new_value .= '.';
                    } else {
                        throw new Database_Mysql_Exception('Два символа `.` идущие подряд в имени столбца или таблицы');
                    }
                } else {
                    $new_value .= $replace($value) . '.';
                }
            }

            return rtrim($new_value, '.');
        } else {
            return $replace($value);
        }
    }

    /**
     * Проверяет, является ли значение целым числом, умещающимся в диапазон PHP_INT_MAX.
     *
     * @param mixed $input
     * @return boolean
     */
    private function isInteger($val)
    {
        if (!is_scalar($val) || is_bool($val)) {
            return false;
        }

        if (is_float($val + 0) && ($val + 0) > PHP_INT_MAX) {
            return false;
        }

        return is_float($val) ? false : preg_match('~^((?:\+|-)?[0-9]+)$~', $val);
    }

    /**
     * Проверяет, является ли значение числом с плавающей точкой.
     *
     * @param mixed $input
     * @return boolean
     */
    private function isFloat($val)
    {
        if (!is_scalar($val)) {
            return false;
        }

        return is_float($val + 0);
    }

    /**
     * Заменяет часть строки string, начинающуюся с символа с порядковым номером start
     * и (необязательной) длиной length, строкой replacement и возвращает результат.
     *
     * @param string $string
     * @param string $replacement
     * @param string $start
     * @param string $length
     * @param string $encoding
     * @return string
     */
    public function mb_substr_replace($string, $replacement, $start, $length=null, $encoding=null)
    {
        if ($encoding == null) {
            $encoding = mb_internal_encoding();
        }

        if ($length == null) {
            return mb_substr($string, 0, $start, $encoding) . $replacement;
        } else {
            if ($length < 0) {
                $length = mb_strlen($string, $encoding) - $start + $length;
            }

            return
                mb_substr($string, 0, $start, $encoding) .
                $replacement .
                mb_substr($string, $start + $length, mb_strlen($string, $encoding), $encoding);
        }
    }
}