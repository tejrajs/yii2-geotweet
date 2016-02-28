<?php
namespace app\components;

use yii\authclient\OAuthToken;
use yii\authclient\clients\Twitter;
use app\models\Setting;

class CTwitter extends Twitter
{
	public $token;
	public $tokenSecret;
	public $consumerKey;
	public $consumerSecret;
	
	public function init(){
		$token = new OAuthToken([
				'token' => Setting::getValue('token'),
				'tokenSecret' => Setting::getValue('tokenSecret')
		]);
		 
		$this->accessToken = $token;
		$this->consumerKey =  Setting::getValue('consumerKey');
		$this->consumerSecret = Setting::getValue('consumerSecret');
	}
	
}