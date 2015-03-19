<?php


class Model_Mpm_PaymentItem extends Model_Mpm
{
	protected $_table_name = 'mp_payment_item';
		
	protected $_db_group = 'default';


	public static function get_all_ids_by_payment_id($args = array(), Component_Message &$msg)
	{
		$payment_items = array();

		if(!isset($args['payment_id'])) {
			$msg->addError('payment_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			$tbl = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_PaymentItem'), $msg);
			$query = DB::query(Database::SELECT, 'SELECT id FROM '.$tbl.' WHERE payment_id = :payment_id' )
				->bind(':payment_id', $args['payment_id']);
			$query_results = $query->execute();
			
			if(count($query_results) > 0) {
				foreach($query_results as $query_result_item) {
					$payment_items[] = $query_result_item['id'];
				}
			}
		}

		return $payment_items;	
	}


	public static function get_distinct_product_ids_by_payment_id($args = array(), Component_Message &$msg)
	{
		$product_ids = array();

		if(!isset($args['payment_id'])) {
			$msg->addError('payment_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			$tbl_pi = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_PaymentItem'), $msg);
			$tbl_po = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_ProductOption'), $msg);
			$query_sql = 'SELECT DISTINCT po.product_id FROM  '.$tbl_pi.' pi JOIN  '.$tbl_po.' po ON pi.product_option_id = po.id WHERE pi.payment_id = :payment_id ';

			$query = DB::query(Database::SELECT, $query_sql)
				->bind(':payment_id', $args['payment_id']);
			$query_results = $query->execute();
			
			if(count($query_results) > 0) {			
				foreach($query_results as $query_result_item) {
					$product_ids[] = $query_result_item['product_id'];
				}
			}
		}

		return $product_ids;	
	}


	public static function get_by_product_id_and_payment_id($args = array(), Component_Message &$msg)
	{
		$payment_item_ids = array();

		if(!isset($args['product_id'])) {
			$msg->addError('product_id is a required parameter');
		}

		if(!isset($args['payment_id'])) {
			$msg->addError('payment_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			$tbl_pi = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_PaymentItem'), $msg);
			$tbl_po = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_ProductOption'), $msg);
			$query_sql = 'SELECT pi.id as id FROM '.$tbl_pi.' pi JOIN '.$tbl_po.' po ON pi.product_option_id = po.id WHERE pi.payment_id = :payment_id ';

			$query = DB::query(Database::SELECT, $query_sql)
				->bind(':payment_id', $args['payment_id']);
			$query_results = $query->execute();
			
			if(count($query_results) > 0) {
				foreach($query_results as $query_result_item) {
					$payment_item_ids[] = $query_result_item['id'];
				}
			}
		}

		return $payment_item_ids;	
	}		


}