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

	    public function testCompletePurchaseSuccess(): void
	    {
	    	$this->getHttpRequest()->request->replace(
	            [
	                'trx_id' => '1234',
				    'status' => 'berhasil',
				    'status_code' => '1',
				    'sid' => '59A5EF83-406E-42AF-9CC6-73D6B110CE67',
				    'reference_id' => 'merchant_12345'
	            ]
	        );

	        $request = $this->gateway->completePurchase();
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CompletePurchaseRequest', $request);

	        $response = $request->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CompletePurchaseResponse', $response);
	        $this->assertTrue($response->isSuccessful());
	        $this->assertFalse($response->isPending());
	        $this->assertFalse($response->isCancelled());
	        $this->assertSame('1234', $response->getTransactionReference());
	        $this->assertSame('59A5EF83-406E-42AF-9CC6-73D6B110CE67', $response->getSessionId());
	        $this->assertSame('berhasil', $response->getMessage());
	        $this->assertSame('1', $response->getCode());
	        $this->assertSame('merchant_12345', $response->getTransactionId());
	    }

	    public function testCompletePurchaseError(): void
	    {
	    	$this->getHttpRequest()->request->replace(
	            [
	                'wrong_post_data' => '1'
	            ]
	        );

	        $request = $this->gateway->completePurchase();
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CompletePurchaseRequest', $request);

	        $response = $request->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CompletePurchaseResponse', $response);
	        $this->assertFalse($response->isSuccessful());
	        $this->assertFalse($response->isPending());
	        $this->assertFalse($response->isCancelled());
	        $this->assertSame(null, $response->getTransactionReference());
	        $this->assertSame(null, $response->getSessionId());
	        $this->assertSame(null, $response->getMessage());
	        $this->assertSame(null, $response->getCode());
	        $this->assertSame(null, $response->getTransactionId());
	    }
	}