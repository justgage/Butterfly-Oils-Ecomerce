<?php 

class PaypalPaymentController extends BaseController {
    /**
    * object to authenticate the call.
    * @param object $_apiContext
    */
    private $_apiContext;

    /**
    * Set the ClientId and the ClientSecret.
    * @param 
    *string $_ClientId
    *string $_ClientSecret
    */
    private $_ClientId='ATgOqhBlVtBHklASxJjIh0W1Vk-uOoUPStsqiLKmzqYqUQ6NA4UxrZihV6KH';
    private $_ClientSecret='EPdcARARnKvt3eooxAfwpx1bZ_7WoiWnAV_SMbCAeIn7qRy9LH6fDfl8gR4g';

    /*
    *   These construct set the SDK configuration dynamiclly, 
    *   If you want to pick your configuration from the sdk_config.ini file
    *   make sure to update you configuration there then grape the credentials using this code :
    *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct(){

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 


        $this->_apiContext = Paypalpayment:: ApiContext(
            Paypalpayment::OAuthTokenCredential(
                $this->_ClientId,
                $this->_ClientSecret
            )
        );

        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));

    }

    public function execute() {

        if(isset($_GET['success']) && $_GET['success'] == 'true') {

            // Get the payment Object by passing paymentId
            // payment id was previously stored in session in
            // CreatePaymentUsingPayPal.php

            $log = PayLog::find( Session::get('log_id') );

            $paymentId = $log->payment_id;
            $payment = Paypalpayment::get($paymentId, $this->_apiContext);

            // PaymentExecution object includes information necessary 
            // to execute a PayPal account payment. 
            // The payer_id is added to the request query parameters
            // when the user is redirected from paypal back to your site
            $execution = Paypalpayment::PaymentExecution();
            $execution->setPayer_id($_GET['PayerID']);


            //Execute the payment
        try {
            $order = $payment->execute($execution, $this->_apiContext)->toArray();
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            var_dump($ex->getData());
            exit(1);
        }

            $payer = $order['payer']['payer_info'];


            $log->state = $order['state'];
            $log->viewed = false;

            $log->paypal_id = $order['id'];
            $log->payer_email = $payer['email'];
            $log->payer_id = $payer['payer_id'];
            $log->payer_first_name = $payer['first_name'];
            $log->payer_last_name = $payer['last_name'];
            $log->shipping_address = json_encode($payer['shipping_address']);

            //note: you'll have to do foreach if you want multiple -v
            $log->item_list = json_encode($order['transactions'][0]);
            $log->total = $order['transactions'][0]['amount']['total'];

            $log->save();

            $cart = Cart::content()->toArray();
            Cart::destroy();

            return View::make('cart.paypalReturn')
                            ->with('title' , 'Payment Sucsess!')
                            ->with('address' ,$payer['shipping_address'])
                            ->with('cart' , $cart)
                            ->with('log' , $log);

        } else {
            echo "User cancelled payment.";
        }
    }

    /*
     * format the number in the right format
     */
    private function money_format($float) {
        return number_format((float) $float, 2, '.', '');
    }

    /*
    * This is a method that usees paypal accounts to pay the payment 
    * 
    * status: working 
    *
    * TODO: test items ability
    * TODO: add cart's items to the paypal purchace
    */
    public function createPaypal() {
        $subtotal = (float) Cart::total();
        $shipping = 5.00;

        // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = Paypalpayment::Payer();
        $payer->setPayment_method("paypal");

        // ### Items
        // These repersent the items in the cart
        $itemsArray = array();
        $cartItems = Cart::content()->toArray();
        Log::info(var_export($cartItems, true));

        //in case their cart is empty
        if (empty($cartItems)) {
            Redirect::route('cart.show');
        }

        foreach ($cartItems as $cartItem){
            $item = Paypalpayment::Item();
            $item->setCurrency( 'USD' );
            $item->setName( $cartItem['name'] );
            $item->setPrice( $this->money_format($cartItem['price']) );
            $item->setQuantity( (string) $cartItem['qty'] );

            $itemsArray[] = $item;
        }

        $itemList = Paypalpayment::ItemList();
        $itemList->setItems( $itemsArray );

        // shipping
        $amountDetails = Paypalpayment::AmountDetails();
        $amountDetails->setShipping($this->money_format($shipping));
        $amountDetails->setSubtotal($this->money_format($subtotal));

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = Paypalpayment::Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($this->money_format($subtotal + $shipping));
        $amount->setDetails($amountDetails);


        $transaction = Paypalpayment::Transaction();
        $transaction->setAmount($amount)
        ->setDescription("Buying from ButterflyOils.com")
        ->setItemList($itemList);

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after 
        // payment approval/ cancellation.
        $redirectUrls = Paypalpayment::RedirectUrls();
        $redirectUrls->setReturnUrl(URL::to("paypal/execute?success=true"));
        $redirectUrls->setCancelUrl(URL::to("paypal/execute?success=false"));

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = Paypalpayment:: Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        Log::info("cool ->". var_export($payment->toArray(), true) );

        // ### Create Payment
        // Create a payment by calling the 'create' method
        // passing it a valid apiContext.
        // (See bootstrap.php for more on `ApiContext`) <- probably not true
        // The return object contains the state and the
        // url to which the buyer must be redirected to
        // for payment approval
        try {
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            var_dump($ex->getData());
            exit(1);
        }

        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $payment->getLinks()
        // method
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
                break;
            }
        }

        // ### Redirect buyer to PayPal website
        // Save the payment id so that you can 'complete' the payment
        // once the buyer approves the payment and is redirected
        // back to your website.
        //
        // It is not a great idea to store the payment id
        // in the session. In a real world app, you may want to 
        // store the payment id in a database.


        $pay_id = $payment->getId();
        // store the payment_id
        $log = PayLog::firstOrNew( array("payment_id" => $pay_id) );
        $log->save();

        Session::put( 'log_id' , $log->id);
        Session::save();

        if(isset($redirectUrl)) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    /*
    * Create payment using credit card
    * url: payment/create-tempate
    * 
    * This will add a payment without the user ever 
    * seeing paypal, the credit card will be processed
    * by paypal and will return the answer.
    */
    public function getCreateTest() {

        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::Address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostal_code("14305");
        $addr->setCountry_code("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = Paypalpayment::CreditCard();
        $card->setType("visa");
        $card->setNumber("4417119669820331");
        $card->setExpire_month("11");
        $card->setExpire_year("2019");
        $card->setCvv2("012");
        $card->setFirst_name("Anouar");
        $card->setLast_name("Abdessalam");
        $card->setBilling_address($addr);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::FundingInstrument();
        $fi->setCredit_card($card);


        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        // ### Amount
        // Let's you specify a payment amount.
        $amount = Paypalpayment:: Amount();
        $amount->setCurrency("USD");
        $amount->setTotal( (string) Cart::total() );

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = Paypalpayment:: Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("This is the payment description.");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = Paypalpayment:: Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        // ### Create Payment
        // Create a payment by posting to the APIService
        // using a valid ApiContext
        // The return object contains the status;
        try {
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            var_dump($ex->getData());
            exit(1);
        }

        $response=$payment->toJson();

        echo"<pre>";
        echo"<p>Responese </p>";
        print_r($response);
        echo"<p>Payment ID: </p>";
        var_dump($payment->getId());
        //print_r($payment->toArray());// or $payment->toJson();
        echo"<p>Payment json: </p>";
        print_r($payment->toJson());// or $payment->toJson();
    }  

    /*
    Use this call to get a list of payments. 
    url:payment/
    */
    public function getIndex(){

        echo "<pre>";

        $payments = Paypalpayment::all(array('count' => 1, 'start_index' => 0),$this->_apiContext);

        print_r($payments);
    }
}
