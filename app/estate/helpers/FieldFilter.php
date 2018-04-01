<?php
namespace module\estate\helpers;

class FieldFilter
{
    public static function money($val)
    {
        if ($unknownVal = self::unknown($val, false)) return $unknownVal;

        if (\WS::$app->language === 'zh-CN') {
            if ($val > 10000) {
                return [number_format($val / 10000.0, 2), null, '万美元'];
            } else {
                return [
                    number_format($val, 0),
                    null,
                    '美元'
                ];
            }
        }
        return [number_format($val, 0), '$', null];
    }

    public static function moneyRmb($val)
    {
        $rmbVal = $val * 6.9506;

        if ($rmbVal > 10000) {
            return [number_format($rmbVal / 10000.0, 2), null, '万元'];
        }

        return [number_format($rmbVal, 0), null, '元'];
    }

    public static function percent($val)
    {
        if ($unknownVal = self::unknown($val, false)) return $unknownVal;

        return [number_format($val * 100, 2), null, '%'];
    }

    public static function square($val)
    {
        if ($unknownVal = self::unknown($val, false)) return $unknownVal;

        if (\WS::$app->language === 'zh-CN') {
            return [intval($val * 0.092903), null, '平方米'];
        }

        return [intval($val), null, 'Sq.Ft'];
    }

    public static function baths($vals)
    {
        if ($unknownVal = self::unknown($vals, false)) return $unknownVal;

        $parts = [];

        if ($vals[0]) {
            $parts[] = \WS::$app->language === 'zh-CN' ? $vals[0] . '全' : $vals[0] . 'F';
        }

        if ($vals[1]) {
            $parts[] = \WS::$app->language === 'zh-CN' ? $vals[1] . '半' : $vals[1] . 'H';
        }

        return [implode('&nbsp;', $parts), null, null];
    }

    public static function listDayDesc($days)
    {
        if ($days === '0' || $days === 0) {
            return tt('New listing', '当日上市');
        }

        return tt("{$days} days on market", "已上市{$days}天");
    }

    public static function statusName($status, $prop)
    {
        if($status === 'NEW') {
            $name = $prop === 'LD' ? '新出售' : '新房源';
            return \WS::$app->language === 'zh-CN' ? $name : 'New';
        }

        $activeCnNm = $prop === 'RN' ? '出租' : '销售';
        if (in_array($status, ['ACT', 'BOM', 'PCG', 'RAC', 'EXT'])) {
            return \WS::$app->language === 'zh-CN' ? $activeCnNm.'中' : 'Active';
        }

        return \WS::$app->language === 'zh-CN' ? '已'.$activeCnNm : 'Sold';
    }

    public static function tags($code)
    {
        $maps = [
            tt('School district', '学区房'),
            tt('More bedrooms', '卧室充足'),
            tt('More parkings', '车位充足'),
            tt('Has garage', '带车库'),
            tt('Luxury house', '高级豪宅')
        ];

        $tagNames = [];
        foreach ($maps as $idx => $tagName) {
            if ($code[$idx] === '1') {
                $tagNames[] = $tagName;
            }
        }

        return $tagNames;
    }

    public static function housePropName($prop)
    {
        $props = [
            'RN' => ['Rental', '租房'],
            'SF' => ['Single Family', '单家庭'],
            'MF' => ['Multi Family', '多家庭'],
            'CC' => ['Condominium', '公寓'],
            'CI' => ['Commercial', '商业用房'],
            'BU' => ['Business Opportunity', '营业用房'],
            'LD' => ['Land', '土地']
        ];

        return tt($props[$prop]);
    }

    public static function photoUrl($data, $idx, $w, $h)
    {
        $areaId = $data['area_id'];
        $mlsId = $data['mls_id'];
        $listNo = $data['id'];

        if ($areaId === 'ma') {
            return "http://media.mlspin.com/Photo.aspx?mls={$listNo}&n={$idx}&w={$w}&h={$h}";
        }

        if (!$mlsId) return null;

        $idx += 1;

        return "http://photos.listhub.net/{$mlsId}/{$listNo}/{$idx}";
    }

    public static function viewUrl($data)
    {
        $language = \WS::$app->language === 'zh-CN' ? '/zh' : '';
        $type = $data['prop'] === 'RN' ? 'lease' : 'purchase';
        return "{$language}/{$type}/{$data['id']}/";
    }

    public static function unknown($val, $returnRaw = true)
    {
        return empty($val) ? tt('Unknown', '未提供') : ($returnRaw ? $val : false);
    }
}
