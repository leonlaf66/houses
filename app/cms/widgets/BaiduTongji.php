<?php
namespace module\cms\widgets;

class BaiduTongji extends\yii\base\Widget
{
    const SITES = [
        'www' => '4d0d9ad874d5a3191ba35eb4a1d6615f',
        'ma' => '5a473bb36d48517a68e3ed045a03824a',
        'ny' => '0e551836ce91d9b1ae5f7e011b102fff',
        'ca' => 'eafa8a567eb6a60cf634a20cf7d117ee',
        'ga' => 'd18f376726dc5c30c32db6dff993830d',
        'il' => '22720a677cfa075d4dd671ec14439ff2'
    ];

    public function run()
    {
        //$siteKey = self::SITES[$this->getSiteId()];
        $siteKey = '4d0d9ad874d5a3191ba35eb4a1d6615f';

        echo <<<EOT
<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?{$siteKey}";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
</script>
EOT;
    }

    protected function getSiteId()
    {
        $areaId = \WS::$app->request->cookies->get('area_id')->value;
        if (!in_array($areaId, array_keys(self::SITES))) {
            return 'www';
        }
        return $areaId;
    }
}