<?php
namespace module\estate\widgets\search;

class InputAll extends \yii\base\Widget 
{
    public $types = [
        [
            'id'=>'q-purchase',
            'name'=>'Buy & Sell', 
            'requestUrl'=>'/house/search/autocomplete/',
            'resultUrl'=>'/house/purchase/',
            'active'=>true
        ],
        [
            'id'=>'q-lease',
            'name'=>'Rental',
            'requestUrl'=>'/estate/search/autocomplete/',
            'resultUrl'=>'/house/lease/',
            'active'=>false
        ]
    ];

    public function run()
    {  
    	return $this->render('input-all.phtml', [
            'types'=>$this->types
        ]);  
    }
}