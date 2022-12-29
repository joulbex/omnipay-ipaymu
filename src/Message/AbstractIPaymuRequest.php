<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractRequest;

	/**
	 * This class holds all the common things for all of Ipaymu requests.
	 *
	 * @see https://ipaymu-storage.s3.amazonaws.com/fdoc/api/payment-api-v2.pdf
	 */
	abstract class AbstractIPaymuRequest extends AbstractRequest
	{
		/**
	     * @var string
	     */
	    protected $apiVersion = 'v2';

	    protected $baseLiveEndpoint = 'https://my.ipaymu.com/api/'; // base/version/endpoint
    	protected $baseSandboxEndpoint = 'https://sandbox.ipaymu.com/api/'; // base/version/endpoint

		/**
		 * NOTE: Maybe not needed. For check.
	     * @return string
	     */
	    public function getAccountId()
	    {
	        return $this->getParameter('accountId');
	    }

	    /**
	     * NOTE: Maybe not needed. For check.
	     * @param string $accountId
	     * @return $this
	     */
	    public function setAccountId(string $accountId)
	    {
	        return $this->setParameter('accountId', $accountId);
	    }

	    public function getProduct()
	    {
	        return $this->getParameter('product');
	    }

	    public function setProduct(string $product)
	    {
	        return $this->setParameter('product', $product);
	    }

	    public function getPrice()
	    {
	        return $this->getParameter('price');
	    }

	    public function setPrice(float $price)
	    {
	        return $this->setParameter('price', $price);
	    }

	    public function getQty()
	    {
	        return $this->getParameter('qty');
	    }

	    public function setQty(int $qty)
	    {
	        return $this->setParameter('qty', $qty);
	    }

	    public function getBaseEndpoint()
	    {
	    	$base = $this->getTestMode() ? $this->baseSandboxEndpoint : $this->baseLiveEndpoint;

	    	return $base . $this->apiVersion;
	    }

		/**
		 * Generates request signature.
		 * @return string
 		 */
		protected function createSignature()
		{
			// @see: https://github.com/ipaymu/ipaymu-php-api/blob/master/iPaymu/Traits/CurlTrait.php
			// @see: https://ipaymu-storage.s3.amazonaws.com/fdoc/api/payment-api-v2.pdf
			return 'wrong signature';
		}

		/**
	     * @param string $method
	     * @param string $endpoint
	     * @param array $data
	     * @return array
	     */
	    protected function sendRequest($method, $endpoint, array $data = null)
	    {
	    	$signature = $this->createSignature();

	    	$headers = [
	            'Content-Type: application/json',
	            'va: ' . $this->getAccountId(), // va == accountId
	            'signature: ' . $signature,
	            'timestamp: ' . Date('YmdHis') // TODO: check this part
	        ];

	        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
	            /**
	             * @var \Guzzle\Http\Message\Response $response
	             */
	            $response = $event['response'];

	            if ($response->isError()) {
	                $event->stopPropagation();
	            }
	        });

	        // var_dump($headers);
	        // var_dump($data);
	        // var_dump($this->getBaseEndpoint() . $endpoint);
	        // exit;

	        $httpRequest = $this->httpClient->createRequest(
	            $method,
	            $this->getBaseEndpoint() . $endpoint,
	            $headers,
	            $data
	        );

	        return $httpRequest->send();
	    }
	}