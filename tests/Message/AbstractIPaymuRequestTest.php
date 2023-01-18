<?php
	
	namespace Omnipay\iPaymu;

	use Omnipay\Tests\TestCase;

	class AbstractIPaymuRequestTest extends TestCase
	{
    	protected $stub;

    	public function setUp()
	    {
	        // $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->stub = $this->getMockForAbstractClass(
			    'Omnipay\iPaymu\Message\AbstractIPaymuRequest',
			    array($this->getHttpClient(), $this->getHttpRequest())
			);
	    }

	    public function testGetSignature()
	    {
	    	// TODO
	    }
	}