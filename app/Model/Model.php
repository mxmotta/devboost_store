<?php

namespace App\Model;

use App\Config\Database;
use ReflectionClass;

class Model
{

    protected $hiden = [];

    protected $table = "";

    private $model_hiden = [
        'table',
        'className',
        'hiden',
        'model_hiden'
    ];

    private function hideAtributes()
    {
        $this->model_hiden = [
            ...$this->model_hiden,
            ...$this->hiden
        ];
    }

    private function getTable()
    {
        return $this->table;
    }

    /**
     * Faz o get dos atributos da classe
     * @return array
     */
    public function get($options = array(
        'order' => 'id,asc',
        'where' => ''
    ))
    {
        $this->hideAtributes();
        $attributes = get_class_vars($this->className);

        $connection = Database::connect();

        $sql = "SELECT * FROM `$this->table`";


        if (isset($options['where']) && strlen($options['where']) > 0) {
            $where = explode(',', $options['where']);
            $sql .= " WHERE $where[0] $where[1] $where[2]";
        }

        if (isset($options['order'])) {
            $order = explode(',', $options['order']);
            $sql .= " ORDER BY $order[0] $order[1]";
        }

        $result = mysqli_query($connection, $sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            foreach (array_keys($row) as $column) {
                $attributes[$column] = $row[$column];
            }
            foreach ($this->model_hiden as $hiden) {
                unset($attributes[$hiden]);
            }
            $reflect = new ReflectionClass($this->className);
            $class = $reflect->newInstance($attributes);
            array_push($data, $class);
        }

        Database::close($connection);

        return $data;
    }

    public function create()
    {
        $connection = Database::connect();

        $this->hideAtributes();
        $attributes = get_class_vars($this->className);

        foreach ($this->model_hiden as $hiden) {
            unset($attributes[$hiden]);
        }

        $values = [];
        $fields = [];

        foreach ($attributes as $key => $attribute) {
            if ($key != 'id' && $this->{$key} != null) {
                array_push($values, $this->{$key});
                array_push($fields, $key);
            }
        }

        $sql = "INSERT INTO `$this->table` (`" . implode("`,`", $fields) . "`) 
            VALUES ('" . implode("','", $values) . "')";

        $result = mysqli_query($connection, $sql);

        if($result) {
            $this->id = $connection->insert_id;
            return $this;
        }

        Database::close($connection);
    }

    /**
     * Faz o set dos atributos da classe
     * @param array $data
     * @return array
     */
    public function set(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        // return $this->get();
    }

    public function toArray()
    {

        $this->hideAtributes();
        $attributes = get_class_vars($this->className);

        foreach ($this->model_hiden as $hiden) {
            unset($attributes[$hiden]);
        }
        foreach ($attributes as $key => $attribute) {
            $attributes[$key] = $this->{$key};
        }

        return $attributes;
    }
}
