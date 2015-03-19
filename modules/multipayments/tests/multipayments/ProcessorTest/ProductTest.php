<?php


class ProcessorTest_ProductTest extends Unittest_TestCase {
    protected $product_id = null;
    protected $option_id = null;
    protected $product_option_id = null;
    protected $payment_product_option_id = null;


    public function setUp()
    {
        // populate product
        $this->_create_test_product();

        // populate option
        $this->_create_test_option();

        // assign product option relationship
        $this->_create_test_product_option();

    }


    public function test_processor()
    {
        $msg = new Component_Message();

        // instantiate stripe processor
        $processor = Component_Processor::get_processor(array('type' => 'stripe'), $msg);

        // apply product/option to payment invoice
        $this->create_payment_product_option();

        // charge a payment for product
        //      resolve price for product
        $args_purchase_product = array(
                'payment_product_option_id' = $this->payment_product_option_id,
            );
        $charge_token = $processor->purchase_product($args_purchase_product, $msg);

        // display payment token 

        // check db payment record

    }


} 
