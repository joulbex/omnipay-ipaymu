<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class CheckTransactionRequestTest extends TestCase
	{
		/** @var CheckTransactionRequest */
    	protected $request;
    	protected $options;

    	public function setUp(): void
	    {
	        $this->request = new CheckTransactionRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = [
		        'transactionReference' => '9974623'
	        ];

	        $this->request->initialize($this->options);
	    }

	    public function testGetData(): void
	    {
	        $data = $this->request->getData();

	        $this->assertSame('9974623', $data['transactionId']);
	        $this->assertCount(1, $data);
	    }
	}