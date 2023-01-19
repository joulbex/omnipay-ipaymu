<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class CheckBalanceRequestTest extends TestCase
	{
		/** @var CheckBalanceRequest */
    	protected $request;
    	protected $options;

    	public function setUp()
	    {
	        $this->request = new CheckBalanceRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = array(
	        	'va' => 'test_va',
		        'apiKey' => 'test_api_key'
	        );
	    }

	    public function testGetData()
	    {
	        $this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame('test_va', $data['account']);
	        $this->assertCount(1, $data);
	    }
	}