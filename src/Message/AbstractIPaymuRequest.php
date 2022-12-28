<?php

	namespace Omnipay\iPaymu;

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

		/**
		 * Generates request signature.
		 * @return string
 		 */
		protected function createSignature()
		{
			// @see: https://github.com/ipaymu/ipaymu-php-api/blob/master/iPaymu/Traits/CurlTrait.php
			// @see: https://ipaymu-storage.s3.amazonaws.com/fdoc/api/payment-api-v2.pdf
		}

		/**
		 * NOTE: This method name taken from Mollie. Should be named send() like in base class? Or differently?
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

	        // then pass headers to the http client
	    }
	}