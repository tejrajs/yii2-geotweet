<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\components\CTwitter;
use yii\base\Object;
use app\libs\Coordinate;
use app\models\MapSearchForm;
use app\models\Setting;
use app\models\SettingForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
    	$model = new MapSearchForm();
    	if($model->load(Yii::$app->request->post())){
    		return $this->redirect(['/site/map','city'=>$model->city]);
    	}
    	return $this->render('index', [
    			'model' => $model,
    	]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionSearch()
    {
    	$model = new MapSearchForm();
    	if($model->load(Yii::$app->request->post())){
    		return $this->redirect(['/site/map','city'=>$model->city]);
    	}
    	return $this->render('search', [
    			'model' => $model,
    	]);
    }
    public function actionSetting()
    {
    	$model = new SettingForm();
    	if($model->load(Yii::$app->request->post()) && $model->save()){
    		return $this->redirect(['/site/index']);
    	}
    	return $this->render('setting', [
    			'model' => $model,
    	]);
    }
    
    public function actionMap($city)
    {
    	$coordinat = new Coordinate($city);
    
    	$twitter = new CTwitter();
    	 
    	$responce = $twitter->api('search/tweets.json', 'GET', ['geocode' => $coordinat->lat.','.$coordinat->lng.','.Setting::getValue('tweetArea')]);
    	 
    	//echo '<pre>';print_r($responce);
    	return $this->render('map', [
    			'responces' => $responce['statuses'],
    			'coordinat' => $coordinat
    	]);
    }
    public function actionTest(){
    	$coordinat = new Coordinate('kathmandu');
    	$twitter = new CTwitter();
    	 
    	$responce = $twitter->api('search/tweets.json', 'GET', ['geocode' => $coordinat->lat.','.$coordinat->lng.','.Setting::getValue('tweetArea')]);
    	 
    	echo '<pre>';print_r($responce);die;
    	return $this->render('map', [
    			'responces' => $responce['statuses'],
    			'coordinat' => $coordinat
    	]);
    }
}
