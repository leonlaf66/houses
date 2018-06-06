<?php
namespace module\estate\helpers;

class Summary
{
    public static function totals($areaId)
    {
        $rows = (new \yii\db\Query())
            ->select('prop_type, count(*) as total')
            ->from('house_index_v2')
            ->where(['area_id' => $areaId])
            ->andWhere(['is_online_abled' => true])
            ->andWhere(['>', 'list_price', 0])
            ->groupBy('prop_type')
            ->all();

        $results = [0=>0, 1=>0];
        foreach($rows as $row) {
            $isRental = $row['prop_type'] === 'RN' ? 1 : 0;
            $results[$isRental] += $row['total'];
        }

        return $results;
    }
}