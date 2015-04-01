<?php

/* 
 * @package	PHP
 * @author 	Faisal Ahmed <thephpx@gmail.com>
 */

class kakaoapi{

	private $api_url;
	private $redirect_uri;
	private $api_key;

	public function __construct()
	{
		$this->api_url = 'https://kauth.kakao.com';
	}

	public function kakao_setApi($api_key="")
	{
		if(!$api_key == "")
		{
			$this->api_key = $api_key;
		}
	}

	public function kakao_getApi()
	{
		return $this->api_key;
	}

	public function kakao_setApiRedirect($uri="")
	{
		if(!$uri == "")
		{
			$this->redirect_uri = urlencode($uri);
		}
	}

	public function kakao_getApiRedirect()
	{
		return $this->redirect_uri;
	}

	public function kakao_authorize()
	{

		$redirect_uri = $this->redirect_uri;

		$url_endpoint = $this->api_url . '/oauth/authorize' . '?' . 'client_id=' . $this->api_key . '&redirect_uri='.$redirect_uri . '&response_type=code';
		
		header('location:'.$url_endpoint);

	}

	public function kakao_token($code="")
	{
		$post 					= array();
		$post['grant_type'] 	= 'authorization_code';
		$post['client_id'] 		= $this->api_key;
		$post['redirect_uri'] 	= $this->redirect_uri;
		$post['code'] 			= $code;

		$response = array();
		$response = $this->kakao_post('/oauth/token',$post);
		
		return $response;
	}

	public function kakao_post($uri="",$postdata=array())
	{
		$url_endpoint 			= $this->api_url . $uri;

		$fields_string = '';
		foreach($postdata as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url_endpoint);
		curl_setopt($ch,CURLOPT_POST, count($postdata));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result);
	}

}
?>