<?php
    class CartItem {
        public $id;
        public $quantity;

        public function __construct($id){
            $this->id = $id;
            $this->quantity = 1;
        }
        
        public function addQuantity($count){
            $this->quantity = $this->quantity + $count;
        }

        public function getId(){
            return $this->id;
        }

        public function getQuantity(){
            return $this->quantity;
        }
    }
?>