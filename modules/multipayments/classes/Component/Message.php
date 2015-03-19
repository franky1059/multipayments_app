<?php



class Component_Message {
	private $messages_success = array();
	private $messages_error = array();


	public function addSuccess($msg = null)
	{
		$this->messages_success[] = $msg;
	}


	public function addError($msg = null)
	{
		$this->messages_error[] = $msg;
	}


	public function countSuccess()
	{
		return count($this->messages_success);
	}


	public function countError()
	{
		return count($this->messages_error);
	}


	public function getSuccess()
	{
		return $this->messages_success;
	}


	public function getError()
	{
		return $this->messages_error;
	}

	public function hasErrors()
	{
		return ($this->countError() > 0);
	}

	public function mergeMessage(Component_Message &$msg) 
	{
		$this->messages_success = array_merge($this->messages_success, $msg->messages_success);
		$this->messages_error = array_merge($this->messages_error, $msg->messages_error);
	}


}