<?php

namespace KevinEm\LimeLightCRM;

use KevinEm\LimeLightCRM\Exceptions\LimeLightCRMTransactionException;

/**
 * Class Transaction
 */
class Transaction
{
    /**
     * @var LimeLightCRM
     */
    protected $limeLightCRM;

    /**
     * Transaction constructor.
     */
    public function __construct(LimeLightCRM $limeLightCRM)
    {
        $this->limeLightCRM = $limeLightCRM;
    }

    /**
     * @return string
     */
    public function getTransactionUrl()
    {
        return $this->limeLightCRM->getBaseUrl().'/admin/transact.php';
    }

    /**
     * NOTE: Account for LimeLight's inconsistent response camel/snake case
     *
     *
     * @throws LimeLightCRMTransactionException
     */
    public function checkResponse(array $response)
    {
        $exception = $responses = null;

        if (isset($response['responseCode'])) {
            $responses = explode(',', $response['responseCode']);
        }

        if (isset($response['response_code'])) {
            $responses = explode(',', $response['response_code']);
        }

        if (isset($responses)) {
            foreach ($responses as $code) {
                if (! in_array($code, [100])) {
                    $exception = new LimeLightCRMTransactionException($code, $exception, $response);
                }
            }
        }

        if (isset($exception)) {
            throw $exception;
        }
    }

    /**
     * @return array
     */
    public function newOrder(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('NewOrder', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }

    /**
     * @return array
     */
    public function newOrderCardOnFile(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('NewOrderCardOnFile', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }

    /**
     * @return array
     */
    public function newOrderWithProspect(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('NewOrderWithProspect', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }

    /**
     * @return array
     */
    public function authorizePayment(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('authorize_payment', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }

    /**
     * @return array
     */
    public function newProspect(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('NewProspect', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }

    /**
     * @return array
     */
    public function threeDRedirect(array $data)
    {
        $formParams = $this->limeLightCRM->buildFormParams('three_d_redirect', $data);

        $res = $this->limeLightCRM->getResponse('POST', $this->getTransactionUrl(), $formParams);

        $parsed = $this->limeLightCRM->parseResponse($res);

        $this->checkResponse($parsed);

        return $parsed;
    }
}
