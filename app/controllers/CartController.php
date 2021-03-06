
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

    public function getShow()
    {
        $v = View::make('cart.show');
        $v->cart = Cart::content()->toArray();
        $v->title = "Viewing cart";
        $v->total = Cart::total();

        return $v;
    }

    public function postAdd()
    {
        $id = Input::get('id');

        if (isset($id) === false) 
            return json_encode(['error' => true, 'mess' => 'no Id sent']);

        $oil = Oil::find($id);

        if (isset($oil) === false) 
            return json_encode(['error' => true, 'mess' => 'Product no longer exists']);

        Cart::add($oil->id, $oil->prefix.$oil->name." ".$oil->type, 1, $oil->price);

        $cart = Cart::content()->toArray();

        $row_id = Cart::search(array('id' => $id));

        $qty = $cart[$row_id[0]]['qty'];
        $total = $cart[$row_id[0]]['price'] * $qty;
        $count = Cart::count();

        return json_encode(array('error' => false, 'total' => $total, 'count' => $count, 'qty' => $qty, 'mess' => "$oil->name was added now ". $qty . " items = $$total", 'cart' => $cart));

    }

    public function postClear()
    {
        if( Cart::destroy() ) {
            return json_encode(array('error' => false, 'mess' => 'Cart was cleared'));
        } else {
            return json_encode(array('error' => true, 'mess' => 'Cart clear failed! please try again'));
        }
    }

    public function getRemove($id)
    {
        if( Cart::remove($id) ) {
            return json_encode(array('error' => false, 'mess' => 'Item was removed'));
        } else {
            return json_encode(array('error' => true, 'mess' => 'Item was NOT removed'));
        }
    }

    public function missingMethod ($errors = array()) {

        return Redirect::to('cart/show')
            ->with('message', "404 the page " . URL::to('/') . "/cart/$errors[0], was NOT FOUND!");

    }

    public function postUpdate () {

        $input = Input::get('items');


        foreach ($input as $item){
            Cart::update($item['id'], $item['qty']);
        }

        return array("worked" => true);

    }

}
