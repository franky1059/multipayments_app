<?php


class Component_Product {


	public static function calculate_product_option_price($args = array(), Component_Message &$msg)
	{
		$product_option_price = null;

		if(!isset($args['payment_item_id'])) {
			$msg->addError('payment_item_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			// get [product_option] w/ [payment_item_id]->product_option_id
			$payment_item = new Model_Mpm_PaymentItem($args['payment_item_id']);
			$product_option = new Model_Mpm_ProductOption($payment_item->product_option_id);
			// get option processor for [option] and/or [product_option] characteristics. 
			//	TODO: this is where we can create different option processing code based on the way 
			//		different columns are populated in [option] and / or [product_option] record, etc. 
			//		Infinite extendability! 
			// get [option] w/ [product_option]->option_id
			$product_option = new Model_Mpm_Option($product_option->option_id);
			// get [option]->price
			$product_option_price = (float)$product_option->price;
		}

		return $product_option_price;
	}



	public static function cumulate_price_by_payment_id($args = array(), Component_Message &$msg)
	{
		$total_price = null;

		if(!isset($args['payment_id'])) {
			$msg->addError('payment_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			// cycle through each DISTINCT product in [payment_item]'s associated with payment_id
			$distinct_product_ids = Model_Mpm_PaymentItem::get_distinct_product_ids_by_payment_id($args, $msg);
			// foreach product
			foreach($distinct_product_ids as $distinct_product_id) {
				// get all [payment_item]'s associated with product_id and payment_id
				$payment_items_for_product = Model_Mpm_PaymentItem::get_by_product_id_and_payment_id(array('product_id' => $distinct_product_id, 'payment_id' => $args['payment_id']), $msg);
				// cumulate sum of [payment_item]'s
				foreach ($payment_items_for_product as $payment_item) {
					$current_payment_item = new Model_Mpm_PaymentItem($payment_item);
					$total_price += (float)$current_payment_item->price;
				}
				// add product base price
				$current_product = new Model_Mpm_Product($distinct_product_id);
				$total_price += (float)$current_product->price;
			}
		}

		return $total_price;
	}

}