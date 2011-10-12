<?php
class CMobileSelectorWidget extends CWidget {
	public function init(){
		echo 'Switch Mode: ';
		$cookies = Yii::app()->request->cookies;
		if(isset($cookies['SUPPRESS_MOBILE']) && $cookies['SUPPRESS_MOBILE']->value == 1){
			echo 'Normal ';
			$params = $this->controller->actionParams;
			$params['mobile'] = '0';
			$url = $this->controller->createUrl($this->controller->route, $params);
			echo CHtml::link('Mobile', $url);
		} else {
			$params = $this->controller->actionParams;
			$params['mobile'] = '1';
			$url = $this->controller->createUrl($this->controller->route, $params);
			echo CHtml::link('Normal', $url);
			echo ' Mobile';
		}
		echo '<br/>';
	}
}