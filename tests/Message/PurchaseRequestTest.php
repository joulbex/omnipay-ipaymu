<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class PurchaseRequestTest extends TestCase
	{
		/** @var PurchaseRequest */
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
		        'referenceId' => 'ID1234'
	        );
	    }

	    public function testGetData()
	    {
	        $this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame('Baju', $data['product'][0]);
	        $this->assertSame('1', $data['qty'][0]);
	        $this->assertSame('10000', $data['price'][0]);
	        $this->assertSame('Baju1', $data['description'][0]);
	        $this->assertSame('https://ipaymu.com/notify', $data['notifyUrl']);
	        $this->assertSame('https://ipaymu.com/return', $data['returnUrl']);
	        $this->assertSame('https://ipaymu.com/cancel', $data['cancelUrl']);
	        $this->assertSame('putu', $data['buyerName']);
	        $this->assertSame('putu@mail.com', $data['buyerEmail']);
	        $this->assertSame('08123456789', $data['buyerPhone']);
	        $this->assertSame('ID1234', $data['referenceId']);
	        $this->assertCount(11, $data);
	    }

	    public function testGetDataWithCOD()
	    {
	    	$this->options = array_merge($this->options, array(
	    		'paymentMethod' => 'cod',
		        'weight' => '1',
		        'dimension' => '1:1:1',
		        'pickupArea' => '80117',
		        'pickupAddress' => 'Jakarta'
	    	));

	    	$this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame('Baju', $data['product'][0]);
	        $this->assertSame('1', $data['qty'][0]);
	        $this->assertSame('10000', $data['price'][0]);
	        $this->assertSame('Baju1', $data['description'][0]);
	        $this->assertSame('https://ipaymu.com/notify', $data['notifyUrl']);
	        $this->assertSame('https://ipaymu.com/return', $data['returnUrl']);
	        $this->assertSame('https://ipaymu.com/cancel', $data['cancelUrl']);
	        $this->assertSame('putu', $data['buyerName']);
	        $this->assertSame('putu@mail.com', $data['buyerEmail']);
	        $this->assertSame('08123456789', $data['buyerPhone']);
	        $this->assertSame('ID1234', $data['referenceId']);

	        $this->assertSame('cod', $data['paymentMethod']);
	        $this->assertSame('1', $data['weight'][0]);
	        $this->assertSame('1:1:1', $data['dimension'][0]);
	        $this->assertSame('80117', $data['pickupArea']);
	        $this->assertSame('Jakarta', $data['pickupAddress']);

	        $this->assertCount(16, $data);
	    }
	}