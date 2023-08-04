<?php

namespace App\Model;

use App\Model\Trait\ClassName;
use Carbon\Carbon;

class Product extends Model
{
    use ClassName;

    public $id;
    public $name;
    public $description;
    public $price;
    public $photo;

    protected $table = "products";

    function __construct($data = [])
    {

        if(isset($data['price']) && !floatval($data['price'])){
            $data['price'] = str_replace('R$ ', '', $data['price']);
            $data['price'] = str_replace('.', '', $data['price']);
            $data['price'] = str_replace(',', '.', $data['price']);
        }
        
        $this->set($data);
        $this->photo = $this->getPhoto() ?? null;

    }

    public function getPhoto() {

        if($this->id){
            $photo = new Photo();
            $photos = $photo->get([
                'where' => ['product_id,=,' . $this->id]
            ]);

            if(count($photos) > 0) {
                return $photos[0];
            }

            return null;
        }
        
    }

    public function createPhoto($file){

        $target_dir = "uploads/product/" . $this->id . "/";
        $file_ = explode('.', $file["name"]);
        $extension = end($file_);
        $target_file = $target_dir . Carbon::now()->format('YmdHis') . '.' . $extension;

        // Garantindo a existencia do diretorio
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Deletar arquivos existentes
        $files = array_diff(scandir($target_dir), array('.', '..'));
        foreach ($files as $file) {
            unlink($target_dir . $file);
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {

            $product_photo = new Photo();

            $has_photos = $product_photo->get([
                'where' => ['product_id,=,' . $this->id]
            ]);

            foreach ($has_photos as $photo) {
                $photo->delete();
            }

            $product_photo->set([
                'name'          =>  $file["name"],
                'path'          =>  $target_file,
                'product_id'    =>  $this->id
            ]);

            $product_photo->create();
        }

    }

    public function deletePhoto() {
        if($this->getPhoto()){
            unlink($this->getPhoto()->path);
            $this->getPhoto()->delete();
        }
    }
}
