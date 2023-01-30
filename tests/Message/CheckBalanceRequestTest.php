<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class CheckBalanceRequestTest extends TestCase
	{
		/** @var CheckBalanceRequest */
    	protected $request;
    	protected $options;

    	public function setUp(): void
	    {
	        $this->request = new CheckBalanceRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = [
	        	'va' => 'test_va',
		        'apiKey' => 'test_api_key'
	        ];

	        $this->request->initialize($this->options);
	    }

	    public function testGetData(): void
	    {
	        $data = $this->request->getData();

	        $this->assertSame('test_va', $data['account']);
	        $this->assertCount(1, $data);
	    }
	}