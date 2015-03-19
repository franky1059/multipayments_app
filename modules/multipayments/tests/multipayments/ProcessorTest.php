<?php


class ProcessorTest extends Unittest_TestCase {

    public function setUp()
    {

    }


    public function test_processor()
    {
    	$msg = new Component_Message();

    	// instantiate stripe processor
    	$processor = Component_Processor::get_processor(array('type' => 'stripe'), $msg);

    	// charge a payment
    	$charge_token = $processor->charge_payment(array('email' => 'test@email.com', 'amount' => 50), $msg);

    	// display payment token 

    	// check db payment record

    }


} 
