<?php
namespace module\cms\widgets;

class BaiduSubmitor extends\yii\base\Widget
{
    public function run()
    {
        if (YII_ENV === 'dev') return; 
        
        echo <<<EOT
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
EOT;
    }
}