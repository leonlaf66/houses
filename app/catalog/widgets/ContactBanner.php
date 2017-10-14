<?php

namespace module\catalog\widgets;

class ContactBanner extends \yii\base\Widget
{
    public function run()
    {  
        $infos = [
            'cnPhoneNumber' => '15680728360',
            'usPhoneNumber' => '888-610-3288',
            'email' => 'contact@usleju.com',
            'wechat' => 'usleju'
        ];

        return $this->render('contact-banner.phtml', [
            'infos'=>$infos
        ]);
    }
}
