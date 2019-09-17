<?php

class Konekcija
{

    public static $konekcija;
    private static $host;
    private static $user;
    private static $pass;
    private static $dbname;
    private static $stmt;


    public function __construct(string $host, string $user, string $pass, string $dbname)
    {

        self::$host = $host;
        self::$user = $user;
        self::$pass = $pass;
        self::$dbname = $dbname;
        self::napraviKonekciju();
    }

    public static function napraviKonekciju()
    {

        if (self::$konekcija == NULL) {

            try {

                self::$konekcija = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$user,
                    self::$pass
                );
            } catch (PDOException $e) {
                echo  $e->getMessage();
                die('<p>Problem sa  konekcijom</p>');
            }

            return self::$konekcija;
        }
    }

    public static function query($sql)
    {
        self::$stmt = self::$konekcija->prepare($sql);
    }


    public static function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        self::$stmt->bindValue($param, $value, $type);
    }

    public static function bindParam($param)
    { }


    public static function execute()
    {
        return self::$stmt->execute();
    }

    public static function executeArray($data)
    {
        return self::$stmt->execute($data);
    }

    public static function resultSet($fetchType = null)
    {
        self::execute();
        return self::$stmt->fetchAll($fetchType);
    }


    public static function single($fetch = PDO::FETCH_OBJ)
    {
        self::execute();
        return self::$stmt->fetch($fetch);
    }


    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public static function lastInsertId()
    {
        return self::$konekcija->lastInsertId();
    }
}

// Konektovanje
$conn = new Konekcija(DBHOST, DBUSER, DBPASS, DBNAME);
