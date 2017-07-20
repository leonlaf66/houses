<?php
namespace module\estate\widgets\view;

use WS;

class Recommends extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        return $this->render('recommends.phtml', [
            'rets'=>$this->rets,
            'nearbyHouses'=>\common\estate\RetsIndex::findOne($this->rets->list_no)->nearbyHouses()
        ]);
    }
}