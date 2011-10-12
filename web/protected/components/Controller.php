<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	private $_layout = 'column1';
				
	public function getLayout(){
		return $this->layoutDirectory . $this->layoutCore;
	}
	
	/**
	 * Gets the layout name (the very last path segment in the layout path).
	 * @return String The layout name.
	 */
	protected function getLayoutCore(){
		return $this->_layout;
	}
	
	public function setLayout($layout){
		$this->_layout = $layout;
		$this->layout = $this->getLayout();
	}
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * @var array Extended context menu items.
	 */
	public $pageOperations = array();
	/**
	 * @var string Ribbon content. Do not HTML encode.
	 */
	public $ribbon = '';
	/**
	 * Indicates whether the current browser is a "mobile" browser instance.
	 */
	public function getIsMobile(){
		$cookies = Yii::app()->request->cookies;
		$isMobile = Yii::app()->browser->isMobile();
		if(isset($cookies['SUPPRESS_MOBILE']) && $cookies['SUPPRESS_MOBILE']->value == 1){
			$isMobile = false;
		}
		//return true;
		$isMobile = false; //pending redesign of mobile site
		return $isMobile;
	}
	
	protected function beforeAction($action){
		if(parent::beforeAction($action)){
			$this->setLayout('column1');
			if(isset($this->actionParams['mobile'])){
				$cookies = Yii::app()->request->cookies;
				$cookies['SUPPRESS_MOBILE'] = $this->createCookie('SUPPRESS_MOBILE', $this->actionParams['mobile']);
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Creates a cookie. 
	 * @param string $name The name of the cookie.
	 * @param string $value The value of the cookie.
	 * @return CHttpCookie The cookie instance.
	 */
	private function createCookie($name, $value){
		$cookie = new CHttpCookie($name, $value);
		$cookie->secure = false;
		$cookie->httpOnly = true;
		return $cookie;
	}
	
	protected function getLayoutDirectory(){
		$directory = '//layouts/desktop/';
		if($this->isMobile){
			$directory = '//layouts/mobile/';
		}
		return $directory;
	}
	
	public function getStyleDirectory(){
		$directory = '/css/';
		if($this->isMobile){
			$directory = '/css/mobile/';
		}
		$directory = Yii::app()->request->baseUrl . $directory;
		return $directory;
	}
	
	public function getScriptDirectory(){
		return Yii::app()->request->baseUrl . '/assets/';
	}
}