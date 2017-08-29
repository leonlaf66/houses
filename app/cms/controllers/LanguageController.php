<?php
namespace module\cms\controllers;

use WS;
use yii\db\Query;

class LanguageController extends \yii\web\Controller
{
    public function actionSwitcher($lang)
    {
        
        \Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'language',
            'value' => $lang,
            'domain' => domain(),
            'expire'=>0,
        ]));

        $url = \Yii::$app->request->headers['referer'];
        if (strpos($url, '/cn/') !== false) {
            $url = str_replace('/cn/', '/en/', $url);
        } elseif(strpos($url, '/en/') !== false) {
            $url = str_replace('/en/', '/cn/', $url);
        }

        $this->goBack($url);  
    }

    public function actionSave($category, $source, $translation, $lang='zh-CN')
    {
        if (! WS::$app->translationStatus) return false;

        \common\support\Language::submit($category, $source, $translation, $lang);

        echo 1;
        WS::$app->end();
    }
}