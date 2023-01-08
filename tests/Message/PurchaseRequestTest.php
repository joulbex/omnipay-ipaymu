<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Tests\TestCase;

	class PurchaseRequestTest extends TestCase
	{
		/** @var RestPurchaseRequest */
    	protected $request;
    	protected $options;

    	public function setUp()
	    {
	        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = array(
	        	'product' => 'Baju',
		        'qty' => '1',
		        'price' => '10000',
		        'description' => 'Baju1',
		        'notifyUrl' => 'https://ipaymu.com/notify',
		        'returnUrl' => 'https://ipaymu.com/return',
		        'cancelUrl' => 'https://ipaymu.com/cancel',
		        'buyerName' => 'putu',
		        'buyerEmail' => 'putu@mail.com',
		        'buyerPhone' => '08123456789',
		        'referenceId' => 'ID1234', 
		        'paymentMethod' => 'cod',
		        'weight' => '1',
		        'dimension' => '1:1:1',
		        'pickupArea' => '80117',
		        'pickupAddress' => 'Jakarta'
	        );
	    }

	    public function testGetData()
	    {
	        $this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame('10000', $data['price'][0]);
	        // $this->assertSame('Description', $data['description']);
	        // $this->assertCount(6, $data);
	    }
	}