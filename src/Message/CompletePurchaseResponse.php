<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractResponse;

	class CompletePurchaseResponse extends AbstractResponse
	{
		public function isSuccessful()
	    {
	        var_dump($this->data);
	    }
	}