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
	    public function getApiKey(): string
	    {
	        return $this->getParameter('apiKey');
	    }

	    /**
	     * @return $this
	     */
	    public function setApiKey(string $apiKey): self
	    {
	        return $this->setParameter('apiKey', $apiKey);
	    }

	    /**
	     * @return string
	     */
	    public function getVa(): string
	    {
	        return $this->getParameter('va');
	    }

	    /**
	     * @param string $va
	     * @return $this
	     */
	    public function setVa(string $va): self
	    {
	        return $this->setParameter('va', $va);
	    }

	    /**
	     * @return string
	     */
	    public function getProduct(): string
	    {
	        return $this->getParameter('product');
	    }

	    public function setProduct(string $product): self
	    {
	        return $this->setParameter('product', $product);
	    }

	    public function getPrice(): float
	    {
	        return (float)$this->getParameter('price');
	    }

	    public function setPrice(float $price): self
	    {
	        return $this->setParameter('price', $price);
	    }

	    public function getQty(): int
	    {
	        return $this->getParameter('qty');
	    }

	    public function setQty(int $qty): self
	    {
	        return $this->setParameter('qty', $qty);
	    }

	    public function getBuyerName(): string
	    {
	        return $this->getParameter('buyerName');
	    }

	    public function setBuyerName(string $buyerName): self
	    {
	        return $this->setParameter('buyerName', $buyerName);
	    }

	    public function getBuyerEmail(): string
	    {
	        return $this->getParameter('buyerEmail');
	    }

	    public function setBuyerEmail(string $buyerEmail): self
	    {
	        return $this->setParameter('buyerEmail', $buyerEmail);
	    }

	    public function getBuyerPhone(): string
	    {
	        return $this->getParameter('buyerPhone');
	    }

	    public function setBuyerPhone(string $buyerPhone): self
	    {
	        return $this->setParameter('buyerPhone', $buyerPhone);
	    }

	    public function getName(): string
	    {
	        return $this->getParameter('name');
	    }

	    public function setName(string $name): self
	    {
	        return $this->setParameter('name', $name);
	    }

	    public function getEmail(): string
	    {
	        return $this->getParameter('email');
	    }

	    public function setEmail(string $email): self
	    {
	        return $this->setParameter('email', $email);
	    }

	 	public function getPhone(): string
	    {
	        return $this->getParameter('phone');
	    }

	    public function setPhone(string $phone): self
	    {
	        return $this->setParameter('phone', $phone);
	    }

	    public function getTransactionId()
	    {
	        return $this->getParameter('transactionId');
	    }

	    public function setTransactionId($transactionId)
	    {
	        return $this->setParameter('transactionId', $transactionId);
	    }

	    public function getWeight(): float
	    {
	        return (float)$this->getParameter('weight');
	    }

	    public function setWeight($weight): self
	    {
	        return $this->setParameter('weight', $weight);
	    }

	    public function getDimension(): string
	    {
	        return $this->getParameter('dimension');
	    }

	    public function setDimension(string $dimension): self
	    {
	        return $this->setParameter('dimension', $dimension);
	    }

	    public function getPickupArea(): string
	    {
	        return $this->getParameter('pickupArea');
	    }

	    public function setPickupArea(string $pickupArea): self
	    {
	        return $this->setParameter('pickupArea', $pickupArea);
	    }

	    public function getPickupAddress(): string
	    {
	        return $this->getParameter('pickupAddress');
	    }

	    public function setPickupAddress(string $pickupAddress): self
	    {
	        return $this->setParameter('pickupAddress', $pickupAddress);
	    }

	    public function getPaymentChannel(): string
	    {
	        return $this->getParameter('paymentChannel');
	    }

	    public function setPaymentChannel(string $paymentChannel): self
	    {
	        return $this->setParameter('paymentChannel', strtolower($paymentChannel));
	    }

	    public function setPaymentMethod($paymentMethod): self
	    {
	        return $this->setParameter('paymentMethod', strtolower($paymentMethod));
	    }

	    public function isCOD(): bool
	    {
	        if ($this->getPaymentMethod()){
	        	return $this->getPaymentMethod() == 'cod';
	        }

	        return false;
	    }

	    public function getBaseEndpoint(): string
	    {
	    	$base = $this->getTestMode() ? $this->baseSandboxEndpoint : $this->baseLiveEndpoint;

	    	return $base . $this->apiVersion;
	    }

		/**
		 * Generates request signature.
		 * @see https://github.com/ipaymu/ipaymu-php-api/blob/master/iPaymu/Traits/CurlTrait.php
		 * @see https://ipaymu-storage.s3.amazonaws.com/fdoc/api/payment-api-v2.pdf
		 * @return string
 		 */
		protected function createSignature(string $method, array $data): string
		{
			$body = json_encode($data, JSON_UNESCAPED_SLASHES);
			$requestBody = strtolower(hash('sha256', $body));
			$va = $this->getVa();
	        $apiKey = $this->getApiKey();
	        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $apiKey;
	        $signature = hash_hmac('sha256', $stringToSign, $apiKey);

	        return $signature;
		}

		/**
	     * @param string $method
	     * @param string $endpoint
	     * @param array $data
	     * @return array
	     */
	    protected function sendRequest(string $method, string $endpoint, array $data = null)
	    {
	    	$signature = $this->createSignature($method, $data);

	        $headers = [
	        	'Content-Type' => 'application/json',
	            'va' => $this->getVa(),
	            'signature' => $signature,
	            'timestamp' => date('YmdHis')
	        ];

	        $response = $this->httpClient->request(
	            $method,
	            $this->getBaseEndpoint() . $endpoint,
	            $headers,
	            ($data === null || $data === []) ? null : json_encode($data)
	        );

	        return json_decode($response->getBody(), true);
	    }
	}