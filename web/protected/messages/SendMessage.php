<?php
class SendMessage {
	/**
	 * @param mixed $vars A key-value array of variables to send to the email view.
	 * @param string $message The name of the message view to send, e.g. "altDeny".
	 */
	public static function send($vars, $message){
		$mailMessage = new YiiMailMessage();
		$mailMessage->view = $message;
		$mailMessage->from = Yii::app()->params['adminEmail'];
		$mailMessage->setBody($vars, 'text/html');
		Yii::app()->mail->send($mailMessage);
	}	
}