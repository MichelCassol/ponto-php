<?php 

class Database
{
    public static function getConnection()
    {
        $envPath = realpath(dirname(__FILE__).'/../../.env');
        $env = parse_ini_file($envPath);
        $conn = new mysqli($env['DB_HOST'], $env['DB_USER'], $env['DB_PASSWORD'], $env['DB_DATABASE']);

        if ($conn->connect_error) {
            die('Erro: '.$conn->connect_error);
        }

        return $conn;
    }
	
	public static function getResultFromQuery($sql)
	{
		$conn = self::getConnection();
		$result = $conn->query($sql);
		$conn->close();
		return $result;
	}
}
