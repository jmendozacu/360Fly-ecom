<?php
 
class Fly_RestConnect_RestapiController extends Mage_Core_Controller_Front_Action
{
	// Get Base url
	public function getActurl()
	{
		return $acturl  =  Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
	}
	
	// Get consumer key and consumer secret key
	public function getconsumerDetails()
	{
		try{
				// Cusumer created at admin with name: mobileapp
				$consumerdata = Mage::getModel('oauth/consumer')->getCollection()->addFieldToFilter('name','mobileapp');
				foreach ($consumerdata as $consumer) {
				$consumer['key'] = $consumer->getKey();
				$consumer['secret'] = $consumer->getSecret();
				return $consumer;
				}
			}
			catch(Exception $e){
				$message['error'] = 'Invalid consumer data.';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
			
	}
	
	// Get Customer Id using token key
	public function getcustomerid($token){
		$oauthCollection = Mage::getModel('oauth/token')->getCollection()->addFieldToFilter('token',$token)->addFieldToFilter('revoked','0')->getFirstItem();
		if($oauthCollection->getCustomerId())
		{
			return $customerid = $oauthCollection->getCustomerId(); //For customer type account
		}
	}
  
	// Get Access token 
    public function getOauthAccessKeyAndSecret($oauthConsumerKey,$oauthConsumerSecret,$username,$password,$baseurl){

		//initiate
		$realm = $baseurl;
		$endpointUrl = $realm."oauth/initiate";
		$oauthCallback = $baseurl;
		$oauthNonce = uniqid(mt_rand(1, 1000));
		$oauthSignatureMethod = "HMAC-SHA1";
		$oauthTimestamp = time();
		$oauthVersion = "1.0";
		$oauthMethod = "POST";
		
		
		$params = array(
			"oauth_callback" => $oauthCallback,
			"oauth_consumer_key" => $oauthConsumerKey,
			"oauth_nonce" => $oauthNonce,
			"oauth_signature_method" => $oauthSignatureMethod,
			"oauth_timestamp" => $oauthTimestamp,
			"oauth_version" => $oauthVersion,
			
		);
		
		$data = http_build_query($params);

		$encodedData = $oauthMethod."&".urlencode($endpointUrl)."&".urlencode($data);
		$key = $oauthConsumerSecret."&"; 
		$signature = hash_hmac("sha1",$encodedData, $key, 1); 
		$oauthSignature = base64_encode($signature);

		$header = "Authorization: OAuth realm=\"$realm\",";
		foreach ($params as $key=>$value){
			$header .=  $key.'="'.$value."\", ";
		}
		$header .= "oauth_signature=\"".$oauthSignature.'"';

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array($header));
		curl_setopt($curl, CURLOPT_URL, $endpointUrl);

		$response = curl_exec($curl);
		curl_close($curl);

		$response = explode('&',$response);
		$key = explode('=',$response[0]);
		$secret = explode('=',$response[1]);
		$oauthkey = $key[1];
		$oauthsecret = $secret[1];

		
		//authorize 
		$url = $baseurl.'oauth/authorize?oauth_token='.$oauthkey.'&username='.serialize($username).'&password='.serialize($password);

		
		$curl = curl_init();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$a = curl_exec($ch); // $a will contain all headers

		$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		
		$url = explode('&',$url);
		$url = explode('=',$url[1]);
		$verifier = $url[1];
		

		//oauth access
		$endpointUrl = $realm."oauth/token";
		$params2 = array(
			'oauth_consumer_key' => $oauthConsumerKey,
			'oauth_nonce' => uniqid(mt_rand(1, 1000)),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0',
			'oauth_token' => $oauthkey,
			'oauth_verifier' => $verifier,
		);

		$method = 'POST';
		// this is the url to get Request Token according to Magento doc
		$url = $endpointUrl;

		// start making the signature
		ksort($params2); // @see Zend_Oauth_Signature_SignatureAbstract::_toByteValueOrderedQueryString() for more accurate sorting, including array params 
		$sortedParamsByKeyEncodedForm = array();
		foreach ($params2 as $key => $value) {
			$sortedParamsByKeyEncodedForm[] = rawurlencode($key) . '=' . rawurlencode($value);
		}
		$strParams = implode('&', $sortedParamsByKeyEncodedForm);
		$signatureData = strtoupper($method) // HTTP method (POST/GET/PUT/...)
				. '&'
				. rawurlencode($url) // base resource url - without port & query params & anchors, @see how Zend extracts it in Zend_Oauth_Signature_SignatureAbstract::normaliseBaseSignatureUrl()
				. '&'
				. rawurlencode($strParams);

		$key = rawurlencode($oauthConsumerSecret) . '&' . rawurlencode($oauthsecret); 
		$oauthSignature = base64_encode(hash_hmac('SHA1', $signatureData, $key, 1));

		$header = "Authorization: OAuth realm=\"$realm\",";
		foreach ($params2 as $key=>$value){
			$header .=  $key.'="'.$value."\", ";
		}
		$header .= "oauth_signature=\"".$oauthSignature.'"';

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array($header));
		curl_setopt($curl, CURLOPT_URL, $endpointUrl);

		$response = curl_exec($curl);
		curl_close($curl);
		
		
		$response = explode('&',$response);
		$access_key = explode('=',$response[0]);
		$access_key = $access_key[1];
		$access_secret = explode('=',$response[1]);
		$access_secret = $access_secret[1];
		
		// get customer id
		$customerId = $this->getcustomerid($access_key);
		
		$token['uuid'] = $customerId;
		$token['token'] = $access_key;
		$token['token_secret'] = $access_secret;
		return $token;

	}
	
	// get user access token and secret key
	public function authorizeAction()
	{

		$postdata = json_decode(file_get_contents('php://input'), true);
		
			
		if($postdata['username'] && $postdata['password'])
		{
		$consumer = $this->getconsumerDetails();
				
		$access_token = $this->getOauthAccessKeyAndSecret($consumer['key'], $consumer['secret'], $postdata['username'], $postdata['password'], $this->getActurl());
		echo Mage::helper('core')->jsonEncode($access_token);
		}
		else
		{
			$message['error'] = 'Invalid username or password';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
		
	}
	
	// Get Request/Post data 
	public function getReqeustData()
	{
		$headers = apache_request_headers();
		$postdata = json_decode(file_get_contents('php://input'), true);
		
		if($headers && $headers['uuid'])
		{
			if(isset($headers['Authorization'])){
				$matches = array();
				preg_match('/oauth_token="(.*)"/', $headers['Authorization'], $matches);
				if(isset($matches[1])){
				  $header_request['token'] = substr($matches[1],0,32);
				}
				
			} 
			if(isset($headers['uuid']))
			{
				$header_request['uuid'] = $headers['uuid'];
			}
			if(isset($headers['action']))
			{
				$header_request['action'] = $headers['action'];
			}
			if(isset($headers['planid']))
			{
				$header_request['planid'] = $headers['planid'];
			}
			
			
			return $header_request;
			
		}
		else
		{
		
			if(isset($postdata))
			{
				return $postdata;
			}
			
			return false;
		}
	}
	
	// Get customer information
	public function validateCustomer($params){
	
		$header_request = $params;
		
		if($header_request)
		{
			$tokens = Mage::getModel('oauth/token')->getCollection()->addFieldToFilter('token', $header_request['token']);
			foreach ($tokens as $token) {
			$token_secret = $token->getSecret();
			$customerid = $token->getCustomerId();
			}
						
			if($header_request['uuid'] != $customerid)
			{
				$message['error'] = 'Invalid token or Invalid customer';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
			
			// Get consumer details
			$consumer = $this->getconsumerDetails();
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}

		$params = array(
				
			'siteUrl' => $this->getActurl().'oauth',
            'requestTokenUrl' => $this->getActurl().'oauth/initiate',
            'accessTokenUrl' => $this->getActurl().'oauth/token',
            'consumerKey' => $consumer['key'], //Consumer key registered in server administration
            'consumerSecret' => $consumer['secret'], //Consumer secret registered in server administration
			'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER
			
		);
 
		// Initiate oAuth consumer
		$consumer = new Zend_Oauth_Consumer($params);
		// Using oAuth parameters and request Token we got, get access token
		$acessToken = new Zend_Oauth_Token_Access;
		$acessToken->setParams(array(
			'oauth_token' => $header_request['token'],
			'oauth_token_secret' => $token_secret
		));

		
		// do a request
		$restClient = $acessToken->getHttpClient($params);
		$restClient->setUri($this->getActurl().'api/rest/customers/'.$customer_id);
		$restClient->setHeaders('Accept', 'application/json');
		$restClient->setMethod(Zend_Http_Client::GET);
		$response = $restClient->request();

		return json_decode($response->getBody());
		
	}
	
	// Get customer information
	public function customerinfoAction(){
	
		$header_request = $this->getReqeustData();
		
		if($header_request)
		{
			$tokens = Mage::getModel('oauth/token')->getCollection()->addFieldToFilter('token', $header_request['token']);
			foreach ($tokens as $token) {
			$token_secret = $token->getSecret();
			$customerid = $token->getCustomerId();
			}
						
			if($header_request['uuid'] != $customerid)
			{
				$message['error'] = 'Invalid token or Invalid customer';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
			
			// Get consumer details
			$consumer = $this->getconsumerDetails();
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}

		$params = array(
				
			'siteUrl' => $this->getActurl().'oauth',
            'requestTokenUrl' => $this->getActurl().'oauth/initiate',
            'accessTokenUrl' => $this->getActurl().'oauth/token',
            'consumerKey' => $consumer['key'], //Consumer key registered in server administration
            'consumerSecret' => $consumer['secret'], //Consumer secret registered in server administration
			'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER
			
		);
 
		// Initiate oAuth consumer
		$consumer = new Zend_Oauth_Consumer($params);
		// Using oAuth parameters and request Token we got, get access token
		$acessToken = new Zend_Oauth_Token_Access;
		$acessToken->setParams(array(
			'oauth_token' => $header_request['token'],
			'oauth_token_secret' => $token_secret
		));

		
		// do a request
		$restClient = $acessToken->getHttpClient($params);
		$restClient->setUri($this->getActurl().'api/rest/customers/'.$customer_id);
		$restClient->setHeaders('Accept', 'application/json');
		$restClient->setMethod(Zend_Http_Client::GET);
		$response = $restClient->request();

		echo ($response->getBody());
		
	}
		
	// Get subscription plans
	public function productsAction(){
		
		$header_request = $this->getReqeustData();
		
		  
		if($header_request)
		{
		  $tokens = Mage::getModel('oauth/token')->getCollection()->addFieldToFilter('token', $header_request['token']);
			foreach ($tokens as $token) {
			$token_secret = $token->getSecret();
			$customerid = $token->getCustomerId();
			}
						
			if($header_request['uuid'] != $customerid)
			{
				$message['error'] = 'Invalid token or Invalid customer';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
			
			// Get consumer details
			$consumer = $this->getconsumerDetails();
 
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}

		$params = array(
				
			'siteUrl' => $this->getActurl().'oauth',
            'requestTokenUrl' => $this->getActurl().'oauth/initiate',
            'accessTokenUrl' => $this->getActurl().'oauth/token',
            'consumerKey' => $consumer['key'], //Consumer key registered in server administration
            'consumerSecret' => $consumer['secret'], //Consumer secret registered in server administration
			'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER
			
		);

		// Initiate oAuth consumer
		$consumer = new Zend_Oauth_Consumer($params);
		// Using oAuth parameters and request Token we got, get access token
		$acessToken = new Zend_Oauth_Token_Access;
		$acessToken->setParams(array(
			'oauth_token' => $header_request['token'],
			'oauth_token_secret' => $token_secret
		));


		// do a request
		$restClient = $acessToken->getHttpClient($params);
		$restClient->setUri($this->getActurl().'api/rest/products');
		$restClient->setHeaders('Accept', 'application/json');
		$restClient->setMethod(Zend_Http_Client::GET);
		
		// Filters
		
		$restClient->setParameterGet('filter[1][attribute]', 'storage');
		$restClient->setParameterGet('filter[1][neq]', 0);
		$restClient->setParameterGet('filter[2][attribute]', 'bandwidth');
		$restClient->setParameterGet('filter[2][neq]', 0);
		
		$response = $restClient->request();
		// Here we can see that response body contains json list of products
		

		$flag = 0;
		foreach(json_decode($response->getBody()) as $prod)
		{
		
		$product_data = Mage::getModel('catalog/product')->load($prod->entity_id);
		if ($product_data->isRecurring() && $profile = $product_data->getRecurringProfile()) {
                $prod->recurring_profile = ($profile);
            }
		
		if($prod->storage)
		{
			$storage = $prod->storage;
			$attributes = Mage::getModel('catalogsearch/advanced')->getAttributes();
			$attributeArray=array();
			foreach($attributes as $a){
			  if($a->getAttributeCode() == 'storage'){
				foreach($a->getSource()->getAllOptions(false) as $option){
				
				  if($option['value'] == $storage)
				  {
					$prod->storage = $option['label'];
					//break;
				  }
				}
			  }
			}
		}	
			
		if($prod->bandwidth)
		{
			$bandwidth = $prod->bandwidth;
			$attributes = Mage::getModel('catalogsearch/advanced')->getAttributes();
			$attributeArray=array();
			foreach($attributes as $a){
			  if($a->getAttributeCode() == 'bandwidth'){
				foreach($a->getSource()->getAllOptions(false) as $option){
				  
				  if($option['value'] == $bandwidth)
				  {
					$prod->bandwidth = $option['label'];
					//break;
				  }
				}
			  }
			}
		}
		
		if($prod->entity_id){
			$i = $prod->entity_id;
			$products->$i = $prod;
			$flag = 1;
		}
		
		
		}
		
		if($flag != 1)
		{			
			$message['error'] = 'No any subscription plan found.';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
		else
		{
			echo (json_encode((array)$products));
		}


	}
	
	// 	Add subscription package/recurring product to customer cart
	public function subscribeAction()
	{
		$header_request = $this->getReqeustData();
		
		$validateCustomer = $this->validateCustomer($header_request);
	
		if(isset($validateCustomer)){
			
		if($header_request['planid'])
		{
		
			$sub_req_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'subscribe.php';
			//exit;
			$ch = curl_init($sub_req_url);
			$encoded = '';
			foreach($header_request as $name => $value) {
			  $encoded .= urlencode($name).'='.urlencode($value).'&';
			}
			
			// chop off last ampersand
			$encoded = substr($encoded, 0, strlen($encoded)-1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$response =  curl_exec($ch);
			
			curl_close($ch);
		}
		else
		{
			$message['success'] = 'Invalid action or profile id';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
		}
		else
		{
			$message['error'] = 'Invalid customer.';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}	
		
	}
	
	// 	Create login session of customer and redirect to checkout page of ecomm site/magento site
	public function placeorderAction()
	{
	
		$header_request = $this->getReqeustData();
		
		$validateCustomer = $this->validateCustomer($header_request);
	
		if(isset($validateCustomer)){
		
				$customer = Mage::getModel('customer/customer');
				$session = Mage::getSingleton('customer/session');
				$customer->load($customerid);
				
				$session->setCustomerAsLoggedIn($customer);
				$url = Mage::getBaseurl().'checkout/onepage';
				header('Location:'.$url);
				exit;
		}
		else
		{
			$message['error'] = 'Invalid customer.';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
	}
	
	// Get list of subscribed plan by customer with their details
	public function mysubscriptionsAction()
	{
	
		$header_request = $this->getReqeustData();
		
		$validateCustomer = $this->validateCustomer($header_request);
	
		if(isset($validateCustomer)){
		
			$collection = Mage::getModel('sales/recurring_profile')->getCollection()
            ->addFieldToFilter('customer_id', array('eq' => $header_request['uuid']));
			
			foreach ($collection as $profile) {
				
			$profiledata = Mage::getModel('sales/recurring_profile')->load($profile->getId());
				$id = $profiledata['profile_id'];
				$profiles->$id  = $profiledata->getOrderItemInfo();
			}
			echo Mage::helper('core')->jsonEncode($profiles);
			exit;
			
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
	}
	
	
	// Update subscribed profile status to activate, suspend or cancel.
	function profileactAction()
	{
		$header_request = $this->getReqeustData();
		
		$validateCustomer = $this->validateCustomer($header_request);
	
		if(isset($validateCustomer)){
			
			if($header_request['action'] && $header_request['profile'])
			{
			
			$sub_req_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'action.php';
			
			$ch = curl_init($sub_req_url);
			$encoded = '';
			foreach($header_request as $name => $value) {
			  $encoded .= urlencode($name).'='.urlencode($value).'&';
			}
			
			// chop off last ampersand
			$encoded = substr($encoded, 0, strlen($encoded)-1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			$response =  curl_exec($ch);
			
			curl_close($ch);
			}
			else
			{
				$message['success'] = 'Invalid action or profile id';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
		
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}

	}
	
	// Get list of subscribed plan by customer with their details
	public function subscriptiondetailsAction()
	{
	
		$header_request = $this->getReqeustData();
		
		$validateCustomer = $this->validateCustomer($header_request);
	
		if(isset($validateCustomer)){
		
		
			if($header_request['profile'])
			{
				$profiledata = Mage::getModel('sales/recurring_profile')->load($header_request['profile']);
				
				if($header_request['uuid'] == $profiledata['customer_id'])
				{
					$id = $profiledata['profile_id'];
					$profiles->$id  = $profiledata->getOrderItemInfo();
					echo Mage::helper('core')->jsonEncode($profiles);
					exit;
				}
				else
				{
					$message['success'] = 'Invalid customer or profile id';
					echo Mage::helper('core')->jsonEncode($message);
					exit;
				}
			}
			else
			{
				$message['success'] = 'Invalid action or profile id';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
		
			
			
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
	}
}
?>