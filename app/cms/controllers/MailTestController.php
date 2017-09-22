<?php
namespace module\cms\controllers;

use WS;
use common\customer\Account;

class MailTestController extends \yii\web\Controller
{
    public function actionConfirmEmail()
    {
        WS::$app->params['mailDebug'] = true;

        $userId = 24;
        $account = Account::findOne(24);
        $account->sendConfirmEmail('http://www.usleju.com/email-confirm/');
    }

    public function actionSubscription()
    {
        WS::$app->params['mailDebug'] = true;
        WS::$app->params['frontendBaseUrl'] = 'http://ma.usleju.local';
        $userId = 24;

        $search = \common\estate\RetsIndex::search();
        $retsItems = \common\estate\helpers\Rets::result($search);

        $account = \common\customer\Account::findOne($userId);
        $account->sendNewslatterEmail('Usleju Newsletter', 'rets/subscription', [
            'retsItems'=>$retsItems
        ]);
    }
}