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

        $result = [
            'EST_ROI_CASH' => null,
            'EST_ANNUAL_INCOME_CASH' => null
        ];

        $estimation = WS::$app->mlsdb->createCommand('select estimation from mls_rets where "list_no"=:id', [
                ':id' => $listNo
            ])->queryScalar();

        if ($estimation) {
            $estimation = json_decode($estimation);
            if ($estimation->est_roi) {
                $result['EST_ROI_CASH'] = $estimation->est_roi * 100;
            }
            if ($estimation->est_rental) {
                $result['EST_ANNUAL_INCOME_CASH'] = $estimation->est_rental * 12;
            }
        }

        $aveResult = WS::$app->db->createCommand('select * from zipcode_roi_ave where "ZIP_CODE"=:zip', [
                ':zip' => $zipCode
            ])->queryOne();
        if (! $aveResult) {
            $aveResult = [
                'AVE_ROI_CASH' => null,
                'AVE_ANNUAL_INCOME_CASH' => null
            ];
        }

        $result = array_merge($result, $aveResult);

        return $this->render('roi.phtml', [
            'result'=>$result
        ]);
    }
}