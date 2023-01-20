<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class PurchaseDirectRequestTest extends TestCase
	{
		/** @var PurchaseDirectRequest */
    	protected $request;
    	protected $options;

    	public function setUp(): void
	    {
	        $this->request = new PurchaseDirectRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = [
	        	'product' => 'Test product',
		        'qty' => '1',
		        'price' => '15000.00',
		        'description' => 'Test description',
		        'notifyUrl' => 'http://localhost:8000/notify.php',
		        'paymentMethod' => 'cstore',
		        'paymentChannel' => 'indomaret',
		        'name' => 'John Doe',
		        'email' => 'johndoe@example.com', 
		        'phone' => '123456789', 
		        'transactionId' => 'ABC1234'
	        ];
	    }

	    public function testGetData(): void
	    {
	        $this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame('Test product', $data['product'][0]);
	        $this->assertSame(1, $data['qty'][0]);
	        $this->assertSame(15000.00, $data['price'][0]);
	        $this->assertSame('Test description', $data['description'][0]);
	        $this->assertSame('http://localhost:8000/notify.php', $data['notifyUrl']);
	        $this->assertSame('cstore', $data['paymentMethod']);
	        $this->assertSame('indomaret', $data['paymentChannel']);
	        $this->assertSame('John Doe', $data['name']);
	        $this->assertSame('johndoe@example.com', $data['email']);
	        $this->assertSame('123456789', $data['phone']);
	        $this->assertSame('ABC1234', $data['referenceId']);
	        $this->assertCount(12, $data);
	    }
	}