<?php
    class CartManager {
        public $cart = array();

        public function addOneItem($id){
            include_once("CartItem.php");

            $key = $this->findItem($id);

            if($key === false){
                $item = new CartItem($id);

                array_push($this->cart, $item);
            }else{
                $this->cart[$key]->addQuantity(1);
            }
        }

        public function removeOneItem($id){
            include_once("CartItem.php");

            $key = $this->findItem($id);
            
            if($key == false){
                if($this->cart[$key]->getQuantity() > 1){
                    $this->cart[$key]->removeQuantity(1);
                }
            }
        }

        public function removeItem($id){
            $key = $this->findItem($id);

            if($key !== false){
                array_splice($this->cart, $key, 1);
            }
        }

        function findItem($id){
            include_once("CartItem.php");

            return array_search($id, array_column($this->cart, "id"));
        }

        public function getCart(){
            return $this->cart;
        }
    }
?>