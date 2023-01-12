<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class PurchaseResponseTest extends TestCase
	{
		public function testPurchaseResponseSuccess()
	    {
	        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
	        $data = json_decode((string)$httpResponse->getBody(), true);

	        $response = new PurchaseResponse($this->getMockRequest(), $data, $httpResponse->getStatusCode());

	        $this->assertTrue($response->isSuccessful());
	        // $this->assertSame('PAY-3TJ47806DA028052TKTQGVYI', $response->getTransactionReference());
	        $this->assertSame('success', $response->getMessage());

	        $this->assertSame(array(), $response->getRedirectData());
	        $this->assertSame('GET', $response->getRedirectMethod());
	        $this->assertSame('https://sandbox.ipaymu.com/payment/91538218-5158-459B-8716-DD97FFE3EDAB', $response->getRedirectUrl());
	    }
	}