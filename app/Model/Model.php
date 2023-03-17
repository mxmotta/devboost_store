<?php

namespace App\Model;

class Model
{

    protected $hiden = [];
    private $model_hiden = [
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

    /**
     * Faz o get dos atributos da classe
     * @return array
     */
    public function get()
    {
        $this->hideAtributes();

        $attributes = get_class_vars($this->className);
        foreach ($attributes as $key => $attribute) {
            $attributes[$key] = $this->{$key};
        }

        foreach ($this->model_hiden as $hiden) {
            unset($attributes[$hiden]);
        }
        return $attributes;
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
        return $this->get();
    }
}
