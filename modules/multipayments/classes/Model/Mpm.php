<?php


class Model_Mpm extends ORM
{
	protected $_db_group = 'default';


	public static function get_by_slug($args = array(), Component_Message &$msg)
	{
		$model_obj = null;			

		if(!isset($args['slug'])) {
			$msg->addError('slug is a required parameter');
		}


		$class_name = '';		
		if(isset($args['class_name'])) {
			$class_name = $args['class_name'];
		} else {
			$class_name = get_class();
		}	

		if(!$msg->hasErrors()) {
			$tbl = Model_Mpm::get_table_name(array('class_name' => $class_name), $msg);
			$slug_query = DB::query(Database::SELECT, 'SELECT id FROM '.$tbl.' WHERE slug = :slug')
				->bind(':slug', $args['slug']);
			$slug_query_results = $slug_query->execute();
			
			if(count($slug_query_results) > 0) {
					$model_obj = new $class_name($slug_query_results[0]['id']);
			}
		}

		return $model_obj;	
	}


	public static function get_by_id($args = array(), Component_Message &$msg)
	{
		$model_obj = null;

		if(!isset($args['id'])) {
			$msg->addError('id is a required parameter');
		}

		
		$class_name = '';
		if(isset($args['class_name'])) {
			$class_name = $args['class_name'];
		} else {
			$class_name = get_class();
		}		

		if(!$msg->hasErrors()) {
			$tbl = Model_Mpm::get_table_name(array('class_name' => $class_name), $msg);
			$query = DB::query(Database::SELECT, 'SELECT id FROM '.$tbl.' WHERE id = :id')
				->bind(':id', $args['id']);
			$query_results = $query->execute();
			
			if(count($query_results) > 0) {
					$model_obj = new $class_name($query_results[0]['id']);
			}
		}

		return $model_obj;	
	}


	public static function get_table_name($args = array(), Component_Message &$msg)
	{
		if(!isset($args['class_name'])) {
			$msg->addError('class_name is a required parameter');
		}			

		$class_name = $args['class_name'];	
		//$model_obj = new ReflectionClass($class_name);
		$model_obj = new $class_name();

		return $model_obj->return_table_name();
	}	

	public function return_table_name()
	{
		return $this->_table_name;
	}

}