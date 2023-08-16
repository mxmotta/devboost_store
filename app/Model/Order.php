<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Order extends Model
{
    use ClassName;

    public $id;
    public $date;
    public $customer_id;
    public $status;
    public $customer;
    public $products;

    protected $hiden = [
        'customer',
        'products'
    ];

    protected $table = 'orders';

    function __construct($data = [])
    {
        if (isset($data['price']) && !floatval($data['price'])) {
            $data['price'] = str_replace('R$ ', '', $data['price']);
            $data['price'] = str_replace('.', '', $data['price']);
            $data['price'] = str_replace(',', '.', $data['price']);
        }

        $this->set($data);
        $this->customer = $this->getCustomer() ?? null;
        $this->products = $this->getProducts() ?? [];
    }

    public function getCustomer()
    {

        if ($this->id) {
            $customer = new Customer();
            return $customer->find($this->customer_id) ?? null;
        }
    }

    public function getProducts()
    {

        if ($this->id) {

            $order_product = new OrderProduct();

            $order_products = $order_product->get([
                'where' => ['order_id,=,' . $this->id]
            ]);

            if (count($order_products) > 0) {
                return $order_products;
            }

            return [];
        }
    }
}
