<?php
namespace module\estate\widgets\view;

use WS;

class Roi extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        $listNo = $this->rets->list_no;
        $zipCode = $this->rets->zip_code;

        $result = WS::$app->db->createCommand('select * from rets_roi where "LIST_NO"=:id', [
                ':id' => $listNo
            ])->queryOne();
        if (! $result) {
            $result = [
                'EST_ROI_CASH' => 0,
                'EST_ANNUAL_INCOME_CASH' => 0
            ];
        }

        $aveResult = WS::$app->db->createCommand('select * from rets_ave_roi where "ZIP_CODE"=:zip', [
                ':zip' => $zipCode
            ])->queryOne();

        $result = array_merge($result, $aveResult);

        return $this->render('roi.phtml', [
            'result'=>$result
        ]);
    }
}