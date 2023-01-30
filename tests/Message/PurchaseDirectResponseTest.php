<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class PurchaseDirectResponseTest extends TestCase
	{
		/** @var PurchaseDirectResponse */
    	protected $response;

		public function setUp()
	    {
	    	$httpResponse = $this->getMockHttpResponse('PurchaseDirectQrisSuccess.txt');
	        $data = json_decode((string)$httpResponse->getBody(), true);

	        $this->response = new PurchaseDirectResponse($this->getMockRequest(), $data, $httpResponse->getStatusCode());
	    }

		public function testGetQRCodeUrl()
	    {
	        $this->assertSame('https://sandbox.ipaymu.com/qr/86689', $this->response->getQRCodeUrl());
	    }

	    public function testGetQRTemplateUrl()
	    {
	        $this->assertSame('https://sandbox.ipaymu.com/qr/template/86689', $this->response->getQRTemplateUrl());
	    }

	    public function testGetExpiryDate()
	    {
	        $this->assertSame('2023-01-31 19:16:22', $this->response->getExpiryDate());
	    }
	}