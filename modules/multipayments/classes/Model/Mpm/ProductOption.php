<?php


class Model_Mpm_ProductOption extends Model_Mpm
{
	protected $_table_name = 'mp_product_option';
		
	protected $_db_group = 'default';


	public static function get_by_product_id_option_id($args = array(), Component_Message &$msg)
	{
		$model_obj = null;

		if(!isset($args['product_id'])) {
			$msg->addError('product_id is a required parameter');
		}

		if(!isset($args['option_id'])) {
			$msg->addError('option_id is a required parameter');
		}

		if(!$msg->hasErrors()) {
			$tbl = Model_Mpm::get_table_name(array('class_name' => 'Model_Mpm_ProductOption'), $msg);
			$query = DB::query(Database::SELECT, 'SELECT id FROM '.$tbl.' WHERE product_id = :product_id AND option_id = :option_id' )
				->bind(':product_id', $args['product_id'])
				->bind(':option_id', $args['option_id']);
			$query_results = $query->execute();
			
			if(count($query_results) > 0) {
					$model_obj = new Model_Mpm_ProductOption($query_results[0]['id']);
			}
		}

		return $model_obj;	
	}	



}