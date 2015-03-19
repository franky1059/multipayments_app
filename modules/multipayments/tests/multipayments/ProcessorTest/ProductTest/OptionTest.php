<?php


class ProcessorTest_ProductTest_OptionTest extends Unittest_TestCase {
    protected $msg = null;
    protected $product_id = null;
    protected $option_id = null;
    protected $product_option_id = null;
    protected $payment_id = null;


    public function setUp()
    {      
        $this->msg = new Component_Message();

        // populate product
        $this->_create_test_product();

        // populate option
        $this->_create_test_option();

        // assign product option relationship
        $this->_create_test_product_option();
    }


    public function test_processor()
    {
        // instantiate stripe processor
        $processor = Component_Processor::get_processor(array('type' => 'stripe'), $this->msg);

        // apply product/option to payment invoice
        $this->_create_payment_and_items();

        // charge a payment for product and option
        //      resolve option applied price for product
        $args_process_payment = array(
            'payment_id' => $this->payment_id,
            );
        $charge_token = $processor->process_payment($args_process_payment, $this->msg);        

        // display payment token

        // display line items ([mp_payment_item]'s) grouped by product for payment_id

        // check db payment record

    }


    public function _create_test_product()
    {
        // find by slug
        $product = Model_Mpm_Product::get_by_slug(array('slug' => 'TEST_PRODUCT', 'class_name' => 'Model_Mpm_Product'), $this->msg);

        // if doesn't exist then create it
        if(is_null($product)) {
            $product = new Model_Mpm_Product();
            $product->slug = 'TEST_PRODUCT';
            $product->name = 'Test Product';
            $product->description = 'Test Product Description';
            $product->price = 12.45;
            $product->save();
        }

        $this->product_id = $product->id;
    }


    public function _create_test_option()
    {
        // find by slug
        $option = Model_Mpm_Option::get_by_slug(array('slug' => 'TEST_OPTION', 'class_name' => 'Model_Mpm_Option'), $this->msg);

        // if doesn't exist then create it
        if(is_null($option)) {
            $option = new Model_Mpm_Option();
            $option->slug = 'TEST_OPTION';
            $option->name = 'Test Option';
            $option->description = 'Test Option Description';
            $option->price = 5.85;
            $option->save();
        }

        $this->option_id = $option->id;
    }


    public function _create_test_product_option()
    {
        // find by product_id and option_id
        $product_option = Model_Mpm_ProductOption::get_by_product_id_option_id(array('product_id' => $this->product_id, 'option_id' => $this->option_id), $this->msg);

        // if doesn't exist then create it
        if(is_null($product_option)) {
            $product_option = new Model_Mpm_ProductOption();
            $product_option->product_id = $this->product_id;
            $product_option->option_id = $this->option_id;
            $product_option->save();
        }

        $this->product_option_id = $product_option->id;
    }

    public function _create_payment_and_items()
    {
        // create new [mp_payment]
        $payment = new Model_Mpm_Payment();
        $payment->save();
        $this->payment_id = $payment->id;

        // assign [mp_product_option]'s to [mp_payment_item]'s
        $payment_item = new Model_Mpm_PaymentItem();
        $payment_item->payment_id = $this->payment_id;
        $payment_item->product_option_id = $this->product_option_id;
        $payment_item->save();   

    }


    public function tearDown()
    {
    }


    public function isInIsolation()
    {
        return true;
    }



} 
