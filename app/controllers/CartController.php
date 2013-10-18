
<?php

class CartController extends BaseController {

   /*
   |--------------------------------------------------------------------------
   | Cart Controller
   |--------------------------------------------------------------------------
   |
   | This is a controller that controlls the cart
   |
    */

   public function show()
   {
      $v = View::make('cart.show');
      $v->cart = Cart::content()->toArray();
      $v->title = "Viewing cart";
      $v->total = Cart::total();

      return $v;
   }

   public function AJAXadd()
   {
      $id = Input::get('id');

      if (isset($id) === false) 
         return json_encode(['error' => true, 'mess' => 'no Id sent']);

      $oil = Oil::find($id);

      if (isset($oil) === false) 
         return json_encode(['error' => true, 'mess' => 'Product no longer exists']);

      Cart::add($oil->id, $oil->name, 1, $oil->price);

      $cart = Cart::content()->toArray();

      $row_id = Cart::search(array('id' => $id));

      $qty = $cart[$row_id[0]]['qty'];
      $total = $cart[$row_id[0]]['price'] * $qty;

      return json_encode(array('error' => false, 'mess' => "$oil->name was added now ". $qty . " items = $$total", 'cart' => $cart));

   }

}
