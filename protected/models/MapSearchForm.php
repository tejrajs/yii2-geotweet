<?php
namespace app\models;

use yii\base\Model;
use Yii;

class MapSearchForm extends Model
{
	public $city;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				['city', 'required'],
		];
	}
}