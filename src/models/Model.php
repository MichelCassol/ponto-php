<?php 

class Model
{
    protected static $tableName = '';
    protected static $coluns = [];
    protected $values = [];

    function __construct(array $arr, bool $sanatize = true)
    {
        $this->loadFromArray($arr, $sanatize);
    }

    public function loadFromArray(array $arr, bool $sanatize)
    {
        if ($arr) {
			$conn = Database::getConnection();
            foreach ($arr as $key => $value) {
				$cleanValue = $value;
				if ($sanatize && isset($value)) {
					$cleanValue = strip_tags(trim($cleanValue));
					$cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
					$cleanValue = mysqli_real_escape_string($conn, $cleanValue);
				}
               $this->$key = $cleanValue; 
            }
			$conn->close();
        }
    }

    public function __get($key) 
    {
        return $this->values[$key];
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

	public static function getOne(array $filters = [], $coluns = '*')
	{
		$class = get_called_class();
		$result = static::getResultSetFromSelect($filters, $coluns);
		return $result ? new $class($result->fetch_assoc()) : null;
	}

	public static function get(array $filters = [], $coluns = '*')
	{
		$objects = [];
		$result = static::getResultSetFromSelect($filters, $coluns);
		if ($result) {
			$class = get_called_class();
			while ($row = $result->fetch_array()) {
				array_push($objects, new $class($row));
			}
		}
		return $objects;
	}

	public static function getResultSetFromSelect(array $filters = [], string $coluns = '*')
	{
		$sql = "SELECT $coluns FROM " . static::$tableName . static::getFilters($filters);
		$result = Database::getResultFromQuery($sql);
		if ($result->num_rows === 0) {
			return null;
		} else {
			return $result;
		}
	}

	public function insert()
	{
		$sql = "INSERT INTO "  . static::$tableName . " (" . implode(",", static::$coluns) . ") VALUES (";
		foreach (static::$coluns as $col)
		{
			$sql .= static::getFormatedValue($this->$col) . ",";
		}
		$sql[strlen($sql) - 1] = ")";

		$id = Database::executeSQL($sql);
		$this->id = $id;
	}

	public function update()
	{
		$sql = "UPDATE " . static::$tableName . " SET ";
		foreach (static::$coluns as $col) {
			$sql .= "$col = " . static::getFormatedValue($this->$col) . ",";
		}
		$sql[strlen($sql) - 1] = " ";
		$sql .= "WHERE id = $this->id";
		Database::executeSQL($sql);
	}

    public static function getCount($filters = [])
    {
        $result = static::getResultSetFromSelect($filters, 'COUNT(*) AS count');
        return $result->fetch_assoc()['count'];
    }

	public static function deleteById($id)
	{
		$sql = "DELETE FROM " . static::$tableName . " WHERE id = $id";
		Database::executeSQL($sql);
	}

	private static function getFilters(array $filters)
	{
		$sql = "";

		if (count($filters) > 0) {
			$sql .= " WHERE 1 + 1";
			foreach ($filters as $column => $value) {
				if ($column == 'raw') {
					$sql .= " AND $value";
				} else {
					$sql .= " AND $column = " . static::getFormatedValue($value);
				}
			}
		}
		return $sql;
	}

	private static function getFormatedValue($value)
	{
		if (is_null($value)) {
			return "null";
		} elseif (gettype($value) === "string") {
			return "'$value'";
		} else {
			return $value;
		}
	}
}
