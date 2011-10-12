<?php
class Requestor extends CComponent {
	//sends the request and returns the response EXACTLY as it is returned from the server
	//error handling is done within this function. header should be an array, content should
	//be a JSON-encoded string. If a get is preferred, the value of $content should be false.
	//This function returns an array containing the response and any error string.
	public static function sendRequest($url, $header, $content){
		Yii::trace('sendRequest: url: ' . $url, 'application.components.Requestor');
		Yii::trace('sendRequest: header: ' . CJSON::encode($header), 'application.components.Requestor');
		Yii::trace('sendRequest: content: ' . CJSON::encode($content), 'application.components.Requestor');
		$header[] = 'Content-Length: ' . strlen($content);
		$curl = curl_init();		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_HEADER, false);
		if($content){
			curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
			curl_setopt($curl, CURLOPT_POST, true);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //for test only
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		$error = curl_error($curl);
		if($response === false && $error == ''){
			$error = 'Unknown error occurred loading external page';
		}
		Yii::trace('sendRequest: response' . CJSON::encode($response), 'application.components.Requestor');
		curl_close($curl);
		return array('error'=>$error, 'response'=>$response);
	}
}