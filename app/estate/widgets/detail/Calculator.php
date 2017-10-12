<?php
namespace module\estate\widgets\detail;

use models\SiteSetting;

class Calculator extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        return $this->render('calculator.phtml', [
            'dataParams' => [
                'ma' => $this->rets->list_price,
                'dp' => 20,
                'mt' => 30,
                'ir' => SiteSetting::get('purchase.mortgage-calculator.interest-rate.default', 4.5),
                'pt' => $this->rets->taxes
            ]
        ]);  
    }
}