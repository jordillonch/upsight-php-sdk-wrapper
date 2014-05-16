<?php

namespace Akamon\Library\Upsight;

/**
 * @method bool trackNotificationEmailResponse($uniqueTrackingTag, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool genUniqueTrackingTag();
 * @method bool trackInviteResponse($uniqueTrackingTag, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackNotificationEmailSent($userId, $recipientUserIds, $uniqueTrackingTag, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackStreamPostResponse($uniqueTrackingTag, $type, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackEvent($userId, $eventName, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool genShortUniqueTrackingTag();
 * @method bool trackThirdPartyCommClick($type, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackRevenue($userId, $value, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackStreamPost($userId, $uniqueTrackingTag, $type, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackInviteSent($userId, $recipientUserIds, $uniqueTrackingTag, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackApplicationRemoved($userId, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool sendHttpRequest($url);
 * @method bool trackGoalCount($userId, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackApplicationAdded($userId, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool sendMessage($messageType, $params, &$validationErrorMsg = null);
 * @method bool trackPageRequest($userId, $optionalParams = array(), &$validationErrorMsg = null);
 * @method bool trackUserInformation($userId, $optionalParams = array(), &$validationErrorMsg = null);
 */
class UpsightApi
{
    private $apiProd;
    private $apiTest;

    public function __construct($apiKey, $optionalParams = array())
    {
        $this->initializeApis($apiKey, $optionalParams);
    }

    public function __call($name, array $arguments)
    {
        $prodResponse = $this->apiProd ? call_user_func_array(array($this->apiProd, $name), $arguments) : true;
        $testResponse = $this->apiTest ? call_user_func_array(array($this->apiTest, $name), $arguments) : true;

        return $prodResponse && $testResponse;
    }

    private function initializeApis($apiKey, array $optionalParams)
    {
        if ($this->isDebug($optionalParams)) {
            $this->initializeApisForDebug($apiKey, $optionalParams);
        } else {
            $this->initializeApisForNormal($apiKey, $optionalParams);
        }
    }

    private function isDebug(array $optionalParams)
    {
        return isset($optionalParams['debug']) && $optionalParams['debug'];
    }

    private function getOptionalParamsForProdAndTest(array $optionalParams)
    {
        $optionalParamsProd                  = $optionalParams;
        $optionalParamsProd['useTestServer'] = false;
        $optionalParamsTest                  = $optionalParams;
        $optionalParamsTest['useTestServer'] = true;

        return array($optionalParamsProd, $optionalParamsTest);
    }

    private function initializeApisForNormal($apiKey, array $optionalParams)
    {
        list($optionalParamsProd, $optionalParamsTest) = $this->getOptionalParamsForProdAndTest($optionalParams);
        $this->apiProd = !$optionalParams['useTestServer'] ? new \KontagentApi($apiKey, $optionalParamsProd) : null;
        $this->apiTest = $optionalParams['useTestServer'] ? new \KontagentApi($apiKey, $optionalParamsTest) : null;
    }

    private function initializeApisForDebug($apiKey, array $optionalParams)
    {
        list($optionalParamsProd, $optionalParamsTest) = $this->getOptionalParamsForProdAndTest($optionalParams);
        $this->apiProd = new \KontagentApi($apiKey, $optionalParamsProd);
        $this->apiTest = new \KontagentApi($apiKey, $optionalParamsTest);
    }
}
 