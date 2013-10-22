
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

        Cart::add($oil->id, $oil->name, 1, $oil->price);

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

    public function postDestroy($id)
    {
        if( Cart::destroy() ) {
            return json_encode(array('error' => false, 'mess' => 'Cart was cleared'));
        } else {
            return json_encode(array('error' => true, 'mess' => 'Cart clear failed! please try again'));
        }
    }

    public function missingMethod ($errors) {

        return Redirect::to('cart/show')
            ->with('message', "404 the page " . URL::to('/') . "/cart/$errors[0], was NOT FOUND!");

    }

}
