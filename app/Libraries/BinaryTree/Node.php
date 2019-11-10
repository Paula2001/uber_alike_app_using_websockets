<?php
namespace App\Libraries\BinaryTree;

class Node{
    public $data;
    public $driver_id ;
    public $leftChild;
    public $rightChild;

    public function __construct($data ,$driver_id)
    {
        $this->data = $data;
        $this->driver_id = $driver_id;
        $this->leftChild = null;
        $this->rightChild = null;
    }

}
