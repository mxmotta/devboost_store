<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class OrderProduct extends Model
{
    use ClassName;
    
    public $order_id;
    public $product_id;
    public $qtd;
    public $price;
    public $product;

    protected $hiden = [
        'product'
    ];

    protected $table = 'order_product';

    function __construct($data = [])
    {
        if(isset($data['price']) && !floatval($data['price'])){
            $data['price'] = str_replace('R$ ', '', $data['price']);
            $data['price'] = str_replace('.', '', $data['price']);
            $data['price'] = str_replace(',', '.', $data['price']);
        }
        
        $this->set($data);
        $this->product = $this->getProduct() ?? null;
    }

    public function getProduct() {

        if($this->product_id){
            $product = new Product();
            return $product->find($this->product_id) ?? null;
        }
        
    }

}
