<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractRequest;
	use Guzzle\Common\Event;

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

	    protected $baseLiveEndpoint = 'https://my.ipaymu.com/api/';
    	protected $baseSandboxEndpoint = 'https://sandbox.ipaymu.com/api/';

		/**
	     * @return string
	     */
	    public function getApiKey()
	    {
	        return $this->getParameter('apiKey');
	    }

	    /**
	     * @return string
	     */
	    public function setApiKey($apiKey)
	    {
	        return $this->setParameter('apiKey', $apiKey);
	    }

	    /**
	     * @return string
	     */
	    public function getVa()
	    {
	        return $this->getParameter('va');
	    }

	    /**
	     * @param string $va
	     * @return $this
	     */
	    public function setVa($va)
	    {
	        return $this->setParameter('va', $va);
	    }

	    /**
	     * @return string
	     */
	    public function getProduct()
	    {
	        return $this->getParameter('product');
	    }

	    public function setProduct($product)
	    {
	        return $this->setParameter('product', $product);
	    }

	    public function getPrice()
	    {
	        return $this->getParameter('price');
	    }

	    public function setPrice($price)
	    {
	        return $this->setParameter('price', $price);
	    }

	    public function getQty()
	    {
	        return $this->getParameter('qty');
	    }

	    public function setQty($qty)
	    {
	        return $this->setParameter('qty', $qty);
	    }

	    public function getBuyerName()
	    {
	        return $this->getParameter('buyerName');
	    }

	    public function setBuyerName($buyerName)
	    {
	        return $this->setParameter('buyerName', $buyerName);
	    }

	    public function getBuyerEmail()
	    {
	        return $this->getParameter('buyerEmail');
	    }

	    public function setBuyerEmail($buyerEmail)
	    {
	        return $this->setParameter('buyerEmail', $buyerEmail);
	    }

	    public function getBuyerPhone()
	    {
	        return $this->getParameter('buyerPhone');
	    }

	    public function setBuyerPhone($buyerPhone)
	    {
	        return $this->setParameter('buyerPhone', $buyerPhone);
	    }

	    public function getName()
	    {
	        return $this->getParameter('name');
	    }

	    public function setName($name)
	    {
	        return $this->setParameter('name', $name);
	    }

	    public function getEmail()
	    {
	        return $this->getParameter('email');
	    }

	    public function setEmail($email)
	    {
	        return $this->setParameter('email', $email);
	    }

	 	public function getPhone()
	    {
	        return $this->getParameter('phone');
	    }

	    public function setPhone($phone)
	    {
	        return $this->setParameter('phone', $phone);
	    }

	    public function getReferenceId()
	    {
	        return $this->getParameter('referenceId');
	    }

	    public function setReferenceId($referenceId)
	    {
	        return $this->setParameter('referenceId', $referenceId);
	    }

	    public function getWeight()
	    {
	        return $this->getParameter('weight');
	    }

	    public function setWeight($weight)
	    {
	        return $this->setParameter('weight', $weight);
	    }

	    public function getDimension()
	    {
	        return $this->getParameter('dimension');
	    }

	    public function setDimension($dimension)
	    {
	        return $this->setParameter('dimension', $dimension);
	    }

	    public function getPickupArea()
	    {
	        return $this->getParameter('pickupArea');
	    }

	    public function setPickupArea($pickupArea)
	    {
	        return $this->setParameter('pickupArea', $pickupArea);
	    }

	    public function getPickupAddress()
	    {
	        return $this->getParameter('pickupAddress');
	    }

	    public function setPickupAddress($pickupAddress)
	    {
	        return $this->setParameter('pickupAddress', $pickupAddress);
	    }

	    public function getPaymentChannel()
	    {
	        return $this->getParameter('paymentChannel');
	    }

	    public function setPaymentChannel($paymentChannel)
	    {
	        return $this->setParameter('paymentChannel', $paymentChannel);
	    }

	    public function isCOD()
	    {
	        if ($this->getPaymentMethod()){
	        	return $this->getPaymentMethod() == 'cod';
	        }

	        return false;
	    }

	    public function getBaseEndpoint()
	    {
	    	$base = $this->getTestMode() ? $this->baseSandboxEndpoint : $this->baseLiveEndpoint;

	    	return $base . $this->apiVersion;
	    }

		/**
		 * Generates request signature.
		 * @see: https://github.com/ipaymu/ipaymu-php-api/blob/master/iPaymu/Traits/CurlTrait.php
		 * @see: https://ipaymu-storage.s3.amazonaws.com/fdoc/api/payment-api-v2.pdf
		 * @return string
 		 */
		protected function createSignature($method, $data)
		{
			$body = json_encode($data, JSON_UNESCAPED_SLASHES);
			$requestBody = strtolower(hash('sha256', $body));
			$va = $this->getVa();
	        $apiKey = $this->getApiKey();
	        $stringToSign = $method . ':' . $va . ':' . $requestBody . ':' . $apiKey;
	        $signature = hash_hmac('sha256', $stringToSign, $apiKey);

	        return $signature;
		}

		/**
	     * @param string $method
	     * @param string $endpoint
	     * @param array $data
	     * @return array
	     */
	    protected function sendRequest($method, $endpoint, array $data = null)
	    {
	    	$signature = $this->createSignature($method, $data);

	        $headers = array(
	        	'Content-Type' => 'application/json',
	            'va' => $this->getVa(),
	            'signature' => $signature,
	            'timestamp' => date('YmdHis')
	        );

	        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
	            /**
	             * @var \Guzzle\Http\Message\Response $response
	             */
	            $response = $event['response'];

	            if ($response->isError()) {
	                $event->stopPropagation();
	            }
	        });

	        $httpRequest = $this->httpClient->createRequest(
	            $method,
	            $this->getBaseEndpoint() . $endpoint,
	            $headers,
	            $data
	        );

	        // NOTE: Guzzle 3 sets Content-Type to application/x-www-form-urlencoded even if different is given in $headers
	        // https://stackoverflow.com/questions/61933825/guzzle-3-x-how-to-set-content-type-application-json
	        // https://guzzle3.readthedocs.io/http-client/request.html
	        $httpRequest->setBody(json_encode($data), 'application/json');

	        return $httpRequest->send();
	    }
	}