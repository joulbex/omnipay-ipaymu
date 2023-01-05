<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Tests\GatewayTestCase;

	class GatewayTest extends GatewayTestCase
	{
		protected $gateway;

	    public function setUp()
	    {
	        parent::setUp();

	        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	    }

	    public function testPurchase()
	    {
	        $request = $this->gateway->purchase(array('amount' => '10.00'));

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseRequest', $request);
	        $this->assertSame('10.00', $request->getAmount());
	    }
	}