<?php 

	include('kakaoapi_lib.php');

	$kakao = new kakaoapi();
	$kakao->kakao_setApi("YOUR_API_KEY");

	//make sure the $_SERVER['HTTP_HOST'] domain is added to the kakao api developer panel as well along-with the given redirect uri
	$kakao->kakao_setApiRedirect("http://".$_SERVER['HTTP_HOST']."/index.php?step=two");

	if(!isset($_GET['code']) AND !isset($_GET['access_token'])){
		$kakao->kakao_authorize();	
	}else if(isset($_GET['code']) AND !isset($_GET['access_token'])){
		$kakao->kakao_token($_GET['code']);	
	}else{
		echo '<pre>';
		print_r($_GET);
		print_r($_POST);
	}

?>