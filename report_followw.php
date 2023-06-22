<html>
    <meta charset="UTF-8">
</html>
<?php

class Connection
{
    private static $instance = null;

    public static function connect()
    {
        if (is_null(static::$instance)) {
            include "config.inc.php";
            static::$instance = $conn;
            $conn->set_charset('');
        }

        return static::$instance;
    }
}


class Model {
    protected $table = 'default';
    protected $column = ['*'];
    protected $_data = [];

    public function __get($name)
    {
        if (!property_exists($this->_data, $name))
            return $this->_data[$name];
        return '';
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __toString()
    {
        return json_encode($this->_data);
    }

    public function toArray()
    {
        return $this->_data;
    }

    public function toJson()
    {
        return (string)$this;
    }

    public function fill(array $data)
    {
        foreach($data as $k => $v) {
            $this->$k = $v;
        }
        return $this;
    }

    public function quote($value)
    {
        if (is_numeric($value))
            return $value;
        else if (is_string($value))
            return "\"$value\"";
        else return $value;
    }

    public function toSql(array $opt = [])
    {       
        $sql = sprintf("select %s from %s ", implode(', ', $this->column), $this->table);
        if (!empty($opt)) {
            $cond = [];
            foreach($opt as $k => $v) {
                array_push($cond, " $k = ".$this->quote($v)." ");
            }
            $sql .= sprintf(" where %s ", implode(', ', $cond));
        }
        return $sql;
    }

    public function get($opt = [])
    {
        $sql = $this->toSql($opt);
        $conn = Connection::connect();
        $result = $conn->query($sql);
        
        $collec = [];
        if ($result) {
            while($row = $result->fetch_assoc()) {
                array_push($collec, (new static())->fill($row));
            }
        }

        if (count($collec) == 1)
            return $collec[0];
        else
            return $collec;
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }
}




class Student extends Model {
    protected $table = 'tbl_student';

    public function getDisplay()
    {
        return "$this->student_id $this->student_name";
    }

}

class StudentOnlyName extends Model {
    protected $table = 'tbl_student';
    protected $column = [
        'student_id',
        'student_name'
    ];
}


// fetch
//$yes = (new Model())
//        ->table('tbl_student')
//        ->get(['student_id' => '6110810002']);

//$std = (new Student())
//            ->get(['student_id' => '6110810002']);

//var_dump($std->toArray());

