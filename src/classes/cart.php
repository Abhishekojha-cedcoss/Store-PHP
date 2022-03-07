<?php

namespace user ;

class Cart
{

  public $cartArr ;

  public function __construct()
  {
    $this->cartArr = array();
  }
  /**
   * setCart
   * Sets the products in the cart object
   * @param [type] $arr
   * @return void
   */
  public function setCart($arr)
  {
    $this->cartArr = $arr;
  }
  /**
   * addToCart
   * 
   * @param [type] $produc
   * @param [type] $id
   * @return void
   */
  public function addToCart($produc, $id)
  {

    if (!$this->isExist($id)) {
      foreach ($produc as $key => $val) {
        if ($produc[$key]["id"] == $id) {
          $produc[$key]["quantity"] = 1;
          array_push($this->cartArr, $produc[$key]);
        }
      }
    }
  }
  
  /**
   * isExist
   * Checks whether the product is already in the cart.
   * @param [type] $id
   * @return boolean
   */
  public function isExist($id)
  {
    foreach ($this->cartArr as $key => $val) {
      if ($this->cartArr[$key]["id"] == $id) {
        $this->cartArr[$key]["quantity"] += 1;
        return true;
      }
    }
    return false;
  }
 /**
  * updateCart
  * Updates the products
  * @param [type] $prod
  * @param [type] $id
  * @param [type] $value
  * @return void
  */
  public function updateCart($product, $id, $value)
  {
    foreach ($product as $key => $val) {
      if ($product[$key]["id"] == $id) {
        $this->cartArr[$key]["quantity"] = $value;
      }
    }
  }
  /**
   * deleteCart
   * Deletes the products
   * @param [type] $prod
   * @param [type] $id
   * @return void
   */
  public function deleteCart($product, $id)
  {
    for ($i = 0; $i < count($product); $i++) {
      if ($product[$i]["id"] == $id) {
        array_splice($this->cartArr, $i, 1);
      }
    }
  }
  /**
   * getCart
   * Returns the cart to the session
   * @return void
   */
  public function getCart()
  {
    return $this->cartArr;
  }
}