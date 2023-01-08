<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Tests\GatewayTestCase;

	class GatewayTest extends GatewayTestCase
	{
		protected $gateway;
		protected $options;

	    public function setUp()
	    {
	        parent::setUp();

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

	        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	    }

	    public function testPurchase()
	    {
	    	$this->setMockHttpResponse('PurchaseSuccess.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseResponse', $response);
	        // $this->assertSame('10000', $response->getPrice());
	        $this->assertTrue($response->isSuccessful());
	        $this->assertTrue($response->isRedirect());
	    }

	    public function testCompletePurchase()
	    {
	        // $request = $this->gateway->completePurchase(array('amount' => '10.00'));

	        // $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseCompleteRequest', $request);
	        // $this->assertSame('10.00', $request->getAmount());
	    }

	    public function testCheckTransaction()
	    {
	        // $request = $this->gateway->checkTransaction(array('amount' => '10.00'));

	        // $this->assertInstanceOf('Omnipay\iPaymu\Message\CheckTransactionRequest', $request);
	        // $this->assertSame('10.00', $request->getAmount());
	    }

	    public function testCheckBalance()
	    {
	        // $request = $this->gateway->checkBalance(array('amount' => '10.00'));

	        // $this->assertInstanceOf('Omnipay\iPaymu\Message\CheckBalanceRequest', $request);
	        // $this->assertSame('10.00', $request->getAmount());
	    }
	}