<?php


class Component_Processor {

	static public $handler_types = array(
			'stripe' => 'Component_Processor_Stripe',
		);


	// payment handler instantiator
	public static function get_processor($args = array(), Component_Message &$msg)
	{
		$processor_handler = null;

		if(!isset($args['type'])) {
			$msg->addError('type is a required parameter');
		}

		if(!$msg->hasErrors()) {
			$handler_type = $args['type'];
			if(isset(self::$handler_types[$handler_type])) 
			{
				$handler_class = self::$handler_types[$handler_type];
				$processor_handler = new $handler_class($args);			
			} else {
				$msg->addError('processor handler not found');
			}
		}

		return $processor_handler;
	}


	public function charge_payment($args = array(), Component_Message &$msg)
	{
		$payment_token = null;

		return $payment_token;
	}

	public function record_charge($charge, Component_Message &$msg)
	{
	}


	public function create_payment_item($args = array(), Component_Message &$msg)
	{
	}


	public function process_payment($args = array(), Component_Message &$msg)
	{
		$payment_token = null;

		if(!isset($args['payment_id'])) {
			$msg->addError('payment_id is a required parameter');
		}	

		if(!$msg->hasErrors()) {		
			// cycle through all [payment_item]'s associated  and payment_id -- TODO: move to Component_Product
			$payment_item_ids = Model_Mpm_PaymentItem::get_all_ids_by_payment_id($args, $msg);
			foreach($payment_item_ids as $payment_item_id) {
				// process price effect of each product_option_id on product price
				$args_calculate_product_option_price = array_merge($args, array('payment_item_id' => $payment_item_id));
				$product_option_price = Component_Product::calculate_product_option_price($args_calculate_product_option_price, $msg);
				// save price for each [payment_item]
				$payment_item = new Model_Mpm_PaymentItem($payment_item_id);
				$payment_item->price = $product_option_price;
				$payment_item->save();
			}

			// add up cumulative price of [payment_item]'s for each DISTINCT product
			$total_price = Component_Product::cumulate_price_by_payment_id($args, $msg);

			// $this->charge_payment w/ cumulative price 
			$args_charge_payment = array_merge($args, array('amount' => $total_price));				
			$payment_token = $this->charge_payment($args_charge_payment, $msg);
				// for STRIPE - update invoice api record with [payment_item]'s info (line items)
		}

		return $payment_token;
	}


}