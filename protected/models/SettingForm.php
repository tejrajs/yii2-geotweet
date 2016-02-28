<?php

namespace app\models;

use yii\base\Model;
use yii\base\Object;

class SettingForm extends Model
{
	public $token;
	public $tokenSecret;
	public $consumerKey;
	public $consumerSecret;
	public $tweetArea;
	
	public function init(){
		$this->token = Setting::getValue('token');
		$this->tokenSecret = Setting::getValue('tokenSecret');
		$this->consumerKey = Setting::getValue('consumerKey');
		$this->consumerSecret = Setting::getValue('consumerSecret');
		$this->tweetArea = Setting::getValue('tweetArea');
	}
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['token','tokenSecret','consumerKey','consumerSecret','tweetArea'], 'required'],
		];
	}
	
	public function save(){
		$connection = \Yii::$app->db;
		if ($this->validate()) {
			$connection->createCommand()->update(Setting::tableName(), ['value' => $this->token],"name = 'token'")->execute();
			$connection->createCommand()->update(Setting::tableName(), ['value' => $this->tokenSecret],"name = 'tokenSecret'")->execute();
			$connection->createCommand()->update(Setting::tableName(), ['value' => $this->consumerKey],"name = 'consumerKey'")->execute();
			$connection->createCommand()->update(Setting::tableName(), ['value' => $this->consumerSecret],"name = 'consumerSecret'")->execute();
			$connection->createCommand()->update(Setting::tableName(), ['value' => $this->tweetArea],"name = 'tweetArea'")->execute();
			return true;
		}	
		return null;
	}
}