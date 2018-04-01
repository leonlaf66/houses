<?php
namespace module\estate\widgets\detail;

use models\SiteSetting;

class Calculator extends \yii\base\Widget 
{  
    public $price = null;
    public $taxes = null;

    public function run()
    {  
        return $this->render('calculator.phtml', [
            'dataParams' => [
                'ma' => $this->price,
                'dp' => 20,
                'mt' => 30,
                'ir' => SiteSetting::get('purchase.mortgage-calculator.interest-rate.default', \WS::$app->area->id),
                'pt' => $this->taxes
            ]
        ]);  
    }
}