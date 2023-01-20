<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\iPaymu\Message\AbstractIPaymuRequest;

	class FetchTransactionHistoryRequest extends AbstractIPaymuRequest
	{
		public function getStatus()
	    {
	        return $this->getParameter('status');
	    }

	    public function setStatus(int $status)
	    {
	        return $this->setParameter('status', $status);
	    }

	    public function getDate()
	    {
	        return $this->getParameter('date');
	    }

	    public function setDate($date)
	    {
	        return $this->setParameter('date', $date);
	    }

	    public function getStartDate()
	    {
	        return $this->getParameter('startDate');
	    }

	    public function setStartDate(string $startDate)
	    {
	        return $this->setParameter('startDate', $startDate);
	    }

	    public function getEndDate()
	    {
	        return $this->getParameter('endDate');
	    }

	    public function setEndDate(string $endDate)
	    {
	        return $this->setParameter('endDate', $endDate);
	    }

	    public function getPage()
	    {
	        return $this->getParameter('page');
	    }

	    public function setPage(int $page)
	    {
	        return $this->setParameter('page', $page);
	    }

	    public function getType()
	    {
	        return $this->getParameter('type');
	    }

	    public function setType(int $type)
	    {
	        return $this->setParameter('type', $type);
	    }

	    public function getOrderBy()
	    {
	        return $this->getParameter('orderBy');
	    }

	    public function setOrderBy(string $orderBy)
	    {
	        return $this->setParameter('orderBy', $orderBy);
	    }

	    public function getOrder()
	    {
	        return $this->getParameter('order');
	    }

	    public function setOrder(string $order)
	    {
	        return $this->setParameter('order', $order);
	    }

		/**
	     * Get the raw data array for this message. The format of this varies from gateway to
	     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	     *
	     * @return mixed
	     */
	    public function getData()
	    {
	    	$data = [];

	    	if ($this->getStatus()) 
	        {
	            $data['status'] = $this->getStatus();
	        }

	        if ($this->getDate()) 
	        {
	            $data['date'] = $this->getDate();
	        }

	        if ($this->getStartDate()) 
	        {
	            $data['startdate'] = $this->getStartDate();
	        }

	        if ($this->getEndDate()) 
	        {
	            $data['enddate'] = $this->getEndDate();
	        }

	        if ($this->getPage()) 
	        {
	            $data['page'] = $this->getPage();
	        }

	        if ($this->getType()) 
	        {
	            $data['type'] = $this->getType();
	        }

	        if ($this->getOrderBy()) 
	        {
	            $data['orderBy'] = $this->getOrderBy();
	        }

	        if ($this->getOrder()) 
	        {
	            $data['order'] = $this->getOrder();
	        }

	    	return $data;
	    }
	    
	    /**
	     * Send the request with specified data
	     *
	     * @param  mixed $data The data to send
	     * @return ResponseInterface
	     */
	    public function sendData($data)
	    {
	    	$httpResponse = $this->sendRequest('POST', '/history', $data);

        	return $this->response = new IPaymuResponse($this, $httpResponse);
	    }
	}