<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class CompletePurchaseRequestTest extends TestCase
	{
		/** @var CompletePurchaseRequest */
    	protected $request;
    	protected $options;

    	public function setUp()
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

	        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
	    }

	    public function testGetData()
	    {
	        $data = $this->request->getData();

	        $this->assertSame(
	        	[
	        		'trx_id' => '1234',
				    'status' => 'berhasil',
				    'status_code' => '1',
				    'sid' => '59A5EF83-406E-42AF-9CC6-73D6B110CE67',
				    'reference_id' => 'merchant_12345'
		        ], 
		        $data
		    );
	    }
	}