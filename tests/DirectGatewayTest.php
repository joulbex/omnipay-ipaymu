<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Tests\GatewayTestCase;

	class DirectGatewayTest extends GatewayTestCase
	{
		protected $gateway;
		protected $options;

	    public function setUp(): void
	    {
	        parent::setUp();

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
		        'phone' => '123456789'
	        ];

	        $this->gateway = new DirectGateway($this->getHttpClient(), $this->getHttpRequest());
	    }

	    public function testPurchaseSuccess(): void
	    {
	    	$this->setMockHttpResponse('PurchaseDirectSuccess.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseDirectResponse', $response);
	        $this->assertTrue($response->isSuccessful());
	        $this->assertSame(3084673, $response->getTransactionReference());
	    }

	    public function testPurchaseError(): void
	    {
	    	$this->setMockHttpResponse('PurchaseDirectError.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseDirectResponse', $response);
	        $this->assertFalse($response->isSuccessful());

	        $this->assertSame('Format isian notify url tidak valid.', $response->getMessage());
	        $this->assertSame(400, $response->getCode());
	        $this->assertSame(null, $response->getTransactionReference());
	    }
	}