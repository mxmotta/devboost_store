<?php

namespace App\Model;

use App\Config\Database;
use Exception;
use ReflectionClass;

class Model
{

    // @TODO - Verificar melhor forma de recuperar o nome da classe
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
        'where' => []
    ))
    {

        $this->hideAtributes();
        $attributes = get_class_vars($this->className);

        $connection = Database::connect();

        $sql = "SELECT * FROM `$this->table`";

        if (isset($options['where']) && count($options['where']) > 0) {
            $sql .= " WHERE ";
            foreach ($options['where'] as $key => $where) {
                $where = explode(',', $where);
                if ($key > 0) {
                    $sql .= " AND ";
                }
                $sql .= "$where[0] $where[1] '$where[2]'";
            }
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

    public function find($id = null)
    {
        $this->hideAtributes();
        $attributes = get_class_vars($this->className);
        $connection = Database::connect();

        $sql = "SELECT * FROM `$this->table` WHERE `id`= $id LIMIT 1";
        $result = mysqli_query($connection, $sql);

        $reflect = new ReflectionClass($this->className);
        $class = $reflect->newInstanceWithoutConstructor();

        while ($row = mysqli_fetch_assoc($result)) {
            foreach (array_keys($row) as $column) {
                $attributes[$column] = $row[$column];
            }
            foreach ($this->model_hiden as $hiden) {
                unset($attributes[$hiden]);
            }

            $class->set($attributes);
        }

        return $reflect->newInstance($attributes);
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

        // var_dump($this->model_hiden);die;

        foreach ($attributes as $key => $attribute) {
            if ($key != 'id' && $this->{$key} != null) {
                array_push($values, $this->{$key});
                array_push($fields, $key);
            }
        }

        $sql = "INSERT INTO `$this->table` (`" . implode("`,`", $fields) . "`) 
            VALUES ('" . implode("','", $values) . "')";

        $result = mysqli_query($connection, $sql);

        if ($result) {
            $this->id = $connection->insert_id;
            return $this;
        }

        Database::close($connection);
    }

    public function update()
    {
        $connection = Database::connect();

        $this->hideAtributes();
        $attributes = get_class_vars($this->className);

        foreach ($this->model_hiden as $hiden) {
            unset($attributes[$hiden]);
        }

        $fields = [];

        foreach ($attributes as $key => $attribute) {
            if ($this->{$key} != null) {
                array_push($fields, "`" . $key . "`='" . $this->{$key} . "'");
            }
        }

        $sql = "UPDATE `$this->table` SET " . implode(",", $fields) . " WHERE `id`= $this->id;";

        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $this;
        }

        Database::close($connection);
    }

    public function updateOrCreate($data = [])
    {
        $where = [];
        if (is_array($data)) {
            foreach ($data as $field => $value) {
                array_push($where, $field . ',=,' . $value);
            }
        }
        $reflect = new ReflectionClass($this->className);
        $class = $reflect->newInstanceWithoutConstructor();

        $found = $class->get(['where' => $where]);

        if (count($found) == 0) {
            $this->create();
        } else {
            $this->update();
        }
    }

    public function delete()
    {
        try {

            if (!$this->id) {
                throw new Exception('ID não localizado');
            }

            $connection = Database::connect();

            $sql = "DELETE FROM `$this->table` WHERE `id`= $this->id;";

            $result = mysqli_query($connection, $sql);

            if ($result) {
                return true;
            }

            Database::close($connection);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return $exception->getMessage();
        }
    }

    public function deleteWhere($where = [])
    {
        try {

            $reflect = new ReflectionClass($this->className);
            $class = $reflect->newInstanceWithoutConstructor();

            $found = $class->get($where);

            if (count($found) == 0) {
                throw new Exception('Item não localizado');
            }

            $connection = Database::connect();

            $sql = "DELETE FROM `$this->table` ";

            if (isset($where) && count($where) > 0) {
                $sql .= " WHERE ";
                foreach ($where['where'] as $key => $where) {
                    $where = explode(',', $where);
                    if ($key > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= "$where[0] $where[1] '$where[2]'";
                }
            }

            $result = mysqli_query($connection, $sql);

            if ($result) {
                return true;
            }

            Database::close($connection);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return $exception->getMessage();
        }
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
