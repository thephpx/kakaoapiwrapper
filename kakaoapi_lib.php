<?php

/* 
 * @package	PHP
 * @author 	Faisal Ahmed <thephpx@gmail.com>
 */

class kakaoapi{

	private $api_auth_url;
	private $api_url;
	private $redirect_uri;
	private $api_key;
	private $admin_key;
	private $access_token;

	public function __construct()
	{
		$this->api_auth_url = 'https://kauth.kakao.com';
		$this->api_url 		= 'https://kapi.kakao.com';
	}

	public function kakao_setAdminKey($admin_key="")
	{
		if(!$admin_key == "")
		{
			$this->admin_key = $admin_key;
		}
	}

	public function kakao_getAdminKey()
	{
		return $this->admin_key;
	}

	public function kakao_setAccessToken($access_token="")
	{
		if(!$access_token == "")
		{
			$this->access_token = $access_token;
		}
	}

	public function kakao_getAccessToken()
	{
		return $this->access_token;
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

		$url_endpoint = $this->api_auth_url . '/oauth/authorize' . '?' . 'client_id=' . $this->api_key . '&redirect_uri='.$redirect_uri . '&response_type=code';
		
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

		$url_endpoint = $this->api_auth_url . '/oauth/token';

		$fields_string = '';
		foreach($post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url_endpoint);
		curl_setopt($ch,CURLOPT_POST, count($postdata));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		$response = json_decode($result);

		curl_close($ch);

		return $response;
	}

	public function kakao_post($uri="",$postdata=array())
	{
		$url_endpoint = $this->api_url . $uri;

		$fields_string = '';
		foreach($postdata as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url_endpoint);
		curl_setopt($ch,CURLOPT_POST, count($postdata));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		curl_close($ch);

		$array = json_decode($result);

		return $array;
	}

	public function kakao_get($uri="")
	{
		$header 	= array();
		
		$KakaoAK = array(
					"/v1/user/ids",
					"/v1/user/me",
					"/v1/push/register",
					"/v1/push/tokens",
					"/v1/push/deregister",
					"/v1/push/send"
				);

		if(in_array($uri, $KakaoAK))
		{
			$header[] = 'Authorization: KakaoAK '.$this->kakao_getAdminKey();
		}

		$Bearer = array(
					"/v1/user/signup",
					"/v1/user/update_profile",
					"/v1/user/unlink",
					"/v1/user/me",
					"/v1/user/access_token_info",
					"/v1/user/logout",
					"/v1/api/story/isstoryuser",
					"/v1/api/story/profile",
					"/v1/api/story/post/note",
					"/v1/api/story/upload/multi",
					"/v1/api/story/post/photo",
					"/v1/api/story/linkinfo",
					"/v1/api/story/post/link",
					"/v1/api/story/mystory",
					"/v1/api/story/delete/mystory",
					"/v1/api/story/delete/mystory",
					"/v1/api/talk/profile"
				);

		if(in_array($uri, $Bearer)){
		$header[]	= 'Authorization: Bearer '.$this->kakao_getAccessToken();
		}

		$url_endpoint = $this->api_url . $uri;

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url_endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		
		curl_close($ch);

		return json_decode($result);
	}

}
?>