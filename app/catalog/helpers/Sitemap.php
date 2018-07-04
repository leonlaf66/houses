<?php
namespace module\catalog\helpers;

use WS;

class Sitemap
{
    public static function getAreas()
    {
        return [
          'ma' => tt('Boston', '波士顿'),
          'ny' => tt('New York', '纽约'),
          'ga' => tt('Atlanta', '亚特兰大'),
          'ca' => tt('Los Angel', '洛杉矶'),
          'il' => tt('Chicago', '芝加哥')
        ];
    }

    public static function getSchoolDistricts()
    {
        $items = (new \yii\db\Query())
            ->from('schooldistrict')
            ->select(['id', 'code', 'json'])
            ->orderBy('sort_order', 'asc')
            ->all();

        $rs = [];
        foreach ($items as $item) {
          $d = json_decode($item['json'], true);

          if (strpos($item['code'], '/')) {
            $item['code'] = str_replace('/', '|', $item['code']);
          }
          $rs[$item['id']] = [
            'code' => $item['code'],
            'name' => $d['name']
          ];
        }

        return $rs;
    }

    public static function getHousePropNames()
    {
        return [
            // 'RN' => ['Rental', '租房'],
            'SF' => ['Single Family', '单家庭'],
            'MF' => ['Multi Family', '多家庭'],
            'CC' => ['Condominium', '公寓'],
            'CI' => ['Commercial', '商业用房'],
            'BU' => ['Business Opportunity', '营业用房'],
            'LD' => ['Land', '土地']
        ];
    }

    public static function getSubwayLines()
    {
        return [
            '1' => ['Orange Line', '地铁线 - 橙线'],
            '2' => ['Redline Ashmont', '地铁线 - 红线阿什莫特'],
            '3' => ['Redline Braintree', '地铁线 - 红线布雷茵特里'],
            '4' => ['Blue Line', '地铁线 - 蓝线'],
            '5' => ['Green Line B', '地铁线 - 绿线B'],
            '6' => ['Green Line C', '地铁线 - 绿线C'],
            '7' => ['Green Line D', '地铁线 - 绿线D'],
            '8' => ['Green Line E', '地铁线 - 绿线E']
        ];
    }

    public static function getRetalPrices()
    {
        return [
            '1' => ['0-$1000', '0-1000美元'],
            '2' => ['$1000-$1500', '1000-1500美元'],
            '3' => ['$1500-$2000', '1500-2000美元'],
            '4' => ['$2000+', '2000+美元']
        ];
    }

    public static function getYpTypes()
    {
        $items = (new \yii\db\Query())
            ->from('taxonomy_term')
            ->select(['id', 'name', 'name_zh'])
            ->where(['taxonomy_id' => 2])
            ->orderBy('sort_order', 'asc')
            ->all();

        $rs = [];
        foreach ($items as $d) {
            $nameEn = explode('[', $d['name'])[0];
            $rs[$d['id']] = [$nameEn, $d['name_zh']];
        }

        return $rs;
    }

    public static function getNewsTypes()
    {
        $items = (new \yii\db\Query())
            ->from('taxonomy_term')
            ->select(['id', 'name', 'name_zh'])
            ->where(['taxonomy_id' => 3])
            ->orderBy('sort_order', 'asc')
            ->all();

        $rs = [];
        foreach ($items as $d) {
            $rs[$d['id']] = [$d['name'], $d['name_zh']];
        }

        return $rs;
    }
}