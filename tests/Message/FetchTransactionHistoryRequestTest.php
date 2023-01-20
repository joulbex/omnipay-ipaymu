<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Tests\TestCase;

	class FetchTransactionHistoryRequestTest extends TestCase
	{
		/** @var FetchTransactionHistoryRequest */
    	protected $request;
    	protected $options;

    	public function setUp(): void
	    {
	        $this->request = new FetchTransactionHistoryRequest($this->getHttpClient(), $this->getHttpRequest());

	        $this->options = array(
		        'status' => 1,
		        'date' => 'created_at',
		        'startDate' => '2022-12-01',
		        'endDate' => '2023-01-31',
		        'page' => '1',
		        'type' => '7',
		        'orderBy' => 'created_at',
		        'order' => 'ASC'
	        );
	    }

	    public function testGetData()
	    {
	        $this->request->initialize($this->options);

	        $data = $this->request->getData();

	        $this->assertSame(1, $data['status']);
	        $this->assertSame('created_at', $data['date']);
	        $this->assertSame('2022-12-01', $data['startdate']);
	        $this->assertSame('2023-01-31', $data['enddate']);
	        $this->assertSame('1', $data['page']);
	        $this->assertSame('7', $data['type']);
	        $this->assertSame('created_at', $data['orderBy']);
	        $this->assertSame('ASC', $data['order']);
	        $this->assertCount(8, $data);
	    }
	}