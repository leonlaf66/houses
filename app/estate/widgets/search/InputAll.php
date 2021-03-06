<?php
namespace module\estate\widgets\search;

class InputAll extends \yii\base\Widget 
{
    public $types = [
        [
            'id'=>'q-purchase',
            'name'=>'Buy & Sell', 
            'requestUrl'=>'estate/autocomplete/index',
            'resultUrl'=>['estate/house/index', 'type' => 'purchase'],
            'active'=>true,
            'type' => 'purchase'
        ],
        [
            'id'=>'q-lease',
            'name'=>'Rental',
            'requestUrl'=>'estate/autocomplete/index',
            'resultUrl'=>['estate/house/index', 'type' => 'lease'],
            'active'=>false,
            'type' => 'lease'
        ]
    ];

    public function run()
    {  
        $types = $this->types;

        return $this->render('input-all.phtml', [
            'types'=>$types
        ]);  
    }
}