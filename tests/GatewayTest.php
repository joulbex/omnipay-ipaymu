<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Tests\GatewayTestCase;

	class GatewayTest extends GatewayTestCase
	{
		protected $gateway;
		protected $options;

	    public function setUp(): void
	    {
	        parent::setUp();

	        $this->options = [
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
	        ];

	        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	    }

	    public function testPurchaseSuccess(): void
	    {
	    	$this->setMockHttpResponse('PurchaseSuccess.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseResponse', $response);
	        // $this->assertSame('10000', $response->getPrice());
	        $this->assertTrue($response->isSuccessful());
	        $this->assertTrue($response->isRedirect());
	        $this->assertSame(null, $response->getTransactionReference());
	    }

	    public function testPurchaseError(): void
	    {
	    	$this->setMockHttpResponse('PurchaseError.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseResponse', $response);
	        $this->assertFalse($response->isSuccessful());
	        $this->assertFalse($response->isRedirect());

	        $this->assertSame('Total price min Rp 5000 and max Rp 999999999', $response->getMessage());
	        $this->assertSame(400, $response->getCode());
	        $this->assertSame(null, $response->getTransactionReference());
	        // $this->assertSame('10000', $response->getData()); // ?
	    }

	    public function testCompletePurchase(): void
	    {
	        $request = $this->gateway->completePurchase();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CompletePurchaseRequest', $request);
	    }

	    public function testCheckTransaction(): void
	    {
	    	$this->setMockHttpResponse('CheckTransactionSuccess.txt');

	        $request = $this->gateway->checkTransaction(['transactionReference' => 4719]);
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CheckTransactionRequest', $request);

	        $response = $request->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\IPaymuResponse', $response);
	        $this->assertSame(4719, $response->getTransactionReference());
	        $this->assertSame('success', $response->getMessage());
	    }

	    public function testCheckBalance(): void
	    {
	    	$this->setMockHttpResponse('CheckBalanceSuccess.txt');

	        $request = $this->gateway->checkBalance();
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CheckBalanceRequest', $request);

	        $response = $request->send();
	        $data = $response->getData();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\IPaymuResponse', $response);
	        $this->assertSame('51125', $data['Data']['MerchantBalance']);
	        $this->assertSame('success', $response->getMessage());
	    }

	    public function testFetchTransactionHistory(): void
	    {
	    	$this->setMockHttpResponse('FetchTransactionHistorySuccess.txt');

	    	$params = [
		        'status' => 1,
		        'date' => 'created_at',
		        'startdate' => '2022-12-01',
		        'enddate' => '2023-01-31',
		        'page' => '1',
		        'type' => '7',
		        'orderBy' => 'created_at',
		        'order' => 'ASC'
		    ];

	        $request = $this->gateway->fetchTransactionHistory($params);
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\FetchTransactionHistoryRequest', $request);

	        $response = $request->send();
	        $data = $response->getData();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\IPaymuResponse', $response);
	        $this->assertSame(2, $data['Data']['Transaction'][0]['TransactionId']);
	        $this->assertSame('1399.02', $data['Data']['Transaction'][0]['Fee']);
	        $this->assertSame('success', $response->getMessage());
	    }
	}