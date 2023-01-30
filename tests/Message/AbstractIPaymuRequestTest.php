<?php
	
	namespace Omnipay\iPaymu;

	use Omnipay\Tests\TestCase;
	use Mockery;

	class AbstractIPaymuRequestTest extends TestCase
	{
    	protected $request;
    	protected $options;

    	public function setUp(): void
	    {
	        $this->request = Mockery::mock('Omnipay\iPaymu\Message\AbstractIPaymuRequest')->makePartial();

			$this->options = [
				'va' => 'test_va',
				'apiKey' => 'test_api_key',
				'testMode' => true,
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
		        'transactionId' => 'ID1234'
	        ];

	        $this->request->initialize($this->options);
	    }

	    public function testGetSignature(): void
	    {
	    	$signature = $this->request->createSignature('POST', $this->options);

	    	$this->assertSame('c0ab16c876cf50222a60a6957b30033197f5b2a12bfef5658963e859ca3378af', $signature);
	    }

	    public function testGetBaseEndpoint(): void
	    {
	    	$endpoint = $this->request->getBaseEndpoint('POST', $this->options);

	    	$this->assertSame('https://sandbox.ipaymu.com/api/v2', $endpoint);
	    }

	    public function testApiKey(): void
	    {
	    	$this->request->setApiKey('different_api_key');
        	$this->assertSame('different_api_key', $this->request->getApiKey());
	    }

	    public function testVa(): void
	    {
	    	$this->request->setVa('different_va');
        	$this->assertSame('different_va', $this->request->getVa());
	    }

	    public function testTransactionId(): void
	    {
	    	$this->assertSame('ID1234', $this->request->getTransactionId());

	    	$this->request->setTransactionId('different_transaction_id');
        	$this->assertSame('different_transaction_id', $this->request->getTransactionId());
	    }

	    public function testIsCOD(): void
	    {
	    	$this->request->setPaymentMethod('cod');

        	$this->assertTrue($this->request->isCOD());
	    }
	}