<?php


class Component_Processor_Stripe extends Component_Processor{

	const vendor_slug = 'stripe';

	public function charge_payment($args = array(), Component_Message &$msg)
	{
		$payment_token = null;

		if(!isset($args['session_token'])) {
			//$msg->addError('session_token is a required parameter');
			$args['session_token'] = array(
                'number' => '4242424242424242',
                'exp_month' => 5,
                'exp_year' => date('Y') + 3,
		    );
		    $args['email'] = 'test@mail.com';
		}	

		if(!isset($args['email'])) {
			$msg->addError('email is a required parameter');
		} 

		if(!isset($args['amount'])) {
			$msg->addError('amount is a required parameter');
		}

		$stripe_config = Kohana::$config->load('multipayments')->stripe;	

		include_once Kohana::find_file('vendor/stripe', 'vendor/autoload');

		if(!$msg->hasErrors()) {
			
			if($args['session_token']) {
				$token = $args['session_token'];
			} 		

			\Stripe\Stripe::setApiKey($stripe_config['secret_key']);

			$customer = \Stripe\Customer::create(array(
			  'email' => $args['email'],
			  'card'  => $token
			));

			$capture_results = false;
			try {
			  $charge = \Stripe\Charge::create(array(
			      'customer' => $customer->id,
			      'amount'   => $args['amount']*100,
			      'currency' => 'usd'
			  ));
			  $capture_results = $charge->id;
			} catch ( Exception $e ) {
				$e_body = $e->getJsonBody();
			  	$e_err  = $e_body['error'];		
				$stripe_msg = $e_err['message'];
				$msg->addError($stripe_msg);
			}		  		  

			if($capture_results === false) {
				$msg->addError('An error occured');					
			} else {
				$args['charge'] = $charge;
				$this->record_charge($args, $msg);
				$msg->addSuccess('Process successfull');	
			}
		}		

		return $payment_token;
	}


	public function record_charge($args = array(), Component_Message &$msg)
	{
		if(!isset($args['charge'])) {
			$msg->addError('charge is a required parameter');
		} else {
			$charge = $args['charge'];
		}

		if(isset($args['payment_id'])) {
			$payment_model = new Model_Mpm_Payment($args['payment_id']);
		} else {
			$payment_model = new Model_Mpm_Payment();
		}	

		if(!$msg->hasErrors()) {
			$payment_model->token = $charge->id;
			$payment_model->amount = $charge->amount/100;
			$payment_model->processdate = date("Y-m-d H:i:s", $charge->created);
			$payment_model->save();
		}
	}

}