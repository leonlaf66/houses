<?php

namespace module\catalog\widgets;

class ContactBanner extends \yii\base\Widget
{
    public function run()
    {  
        $infos = [
            'cnPhoneNumber' => '131 6711 1930',
            'usPhoneNumber' => '888-610-3288',
            'email' => 'contact@usleju.com',
            'wechat' => 'usleju'
        ];

        return $this->render('contact-banner.phtml', [
            'infos'=>$infos
        ]);
    }
}
