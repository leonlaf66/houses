<?php
namespace module\estate\widgets\search;

use module\estate\helpers\SearchUrl;

class Sort extends \yii\base\Widget 
{
    public $search = null;

    public function run()
    {
        $priceTypeName = \WS::$app->share('rets.property') === 'purchase' ? '售价' : '租金';

        $options = [
            '1'=>tt('Price up', $priceTypeName.'由低到高'),
            '2'=>tt('Price down', $priceTypeName.'由高到低'),
            '3'=>tt('Bedrooms down', '卧室由多到少'),
            '4'=>tt('Bedrooms up', '卧室由少到多')
        ];
        $map = [
            '1'=>'list_price ASC, list_no DESC',
            '2'=>'list_price DESC, list_no DESC',
            '3'=>'no_bedrooms DESC, list_no DESC',
            '4'=>'no_bedrooms ASC, list_no DESC'
        ];

        return $this->render('sort.phtml', [
            'self'=>$this,
            'options'=>$options,
            'selectedValue'=>isset($_GET['sort']) ? $_GET['sort'] : null
        ]);  
    }

    public function createUrl($name, $value)
    {
        return SearchUrl::to($name, $value);
    }
}