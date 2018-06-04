<?php
namespace module\cms\widgets;

class BaiduTongji extends\yii\base\Widget
{
    public function run()
    {
        echo <<<EOT
<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?4d0d9ad874d5a3191ba35eb4a1d6615f";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
</script>
EOT;
    }
}