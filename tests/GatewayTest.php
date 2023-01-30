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

	    public function testPurchaseSuccess()
	    {
	    	$this->setMockHttpResponse('PurchaseSuccess.txt');

	        $response = $this->gateway->purchase($this->options)->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\PurchaseResponse', $response);
	        // $this->assertSame('10000', $response->getPrice());
	        $this->assertTrue($response->isSuccessful());
	        $this->assertTrue($response->isRedirect());
	        $this->assertSame(null, $response->getTransactionReference());
	    }

	    public function testPurchaseError()
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

	    public function testCompletePurchaseSuccess()
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

	    public function testCompletePurchaseError()
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

	    public function testCheckTransaction()
	    {
	    	$this->setMockHttpResponse('CheckTransactionSuccess.txt');

	        $request = $this->gateway->checkTransaction(array('transactionReference' => 4719));
	        $this->assertInstanceOf('Omnipay\iPaymu\Message\CheckTransactionRequest', $request);

	        $response = $request->send();

	        $this->assertInstanceOf('Omnipay\iPaymu\Message\IPaymuResponse', $response);
	        $this->assertSame(4719, $response->getTransactionReference());
	        $this->assertSame('success', $response->getMessage());
	    }

	    public function testCheckBalance()
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

	    public function testFetchTransactionHistory()
	    {
	    	$this->setMockHttpResponse('FetchTransactionHistorySuccess.txt');

	    	$params = array(
		        'status' => 1,
		        'date' => 'created_at',
		        'startdate' => '2022-12-01',
		        'enddate' => '2023-01-31',
		        'page' => '1',
		        'type' => '7',
		        'orderBy' => 'created_at',
		        'order' => 'ASC'
		    );

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