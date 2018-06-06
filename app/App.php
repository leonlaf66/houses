<?php
class App extends \common\supports\SiteApp
{
    public $autoLanguage = true;
    public $baseUrl = '/';
    public $loginUrl = '';
    public $logoutUrl = '';
    public $memberUrl = '';
    public $pageMetas = [];

    public function bootstrap()
    {
        $this->initSite();
        parent::bootstrap();
    }

    protected function initSite()
    {
        $cookies = \WS::$app->response->cookies;

        $areaId = null;

        if (isset($cookies['area_id'])) {
            $areaId = $cookies->getValue('area_id');
            $this->area->initArea($areaId);
        } else {
            $parts = explode('.', $_SERVER["HTTP_HOST"]);
            $areaId = $parts[0];

            $this->area->initArea($areaId);

            if ($this->area->id) {
                // 记录区域
                \WS::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'area_id',
                    'value' => $areaId,
                    'expire' => 0,
                    'domain' => domain()
                ]));

                \WS::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'house_base_url',
                    'value' => $this->request->getHostInfo().'/',
                    'expire' => 0,
                    'domain' => domain()
                ]));
            }
        }
    }

    protected function initLanguage()
    {
        if ($this->isSeoCrawlerAccess()) {
            $this->language = 'zh-CN';
            return;
        }
        parent::initLanguage();
    }

    public function beforeAction($action)
    {
        $isSelfRote = $action->id === 'area' && $action->controller->id === 'default' && $action->controller->module->id === 'home';

        $this->page->bindParams([
            'area' => tt($this->area->getName())
        ]);

        if (! $isSelfRote && ! \WS::$app->area->isAreaSite) {
            return $action->controller->redirect(['/home/default/area']);
        }

        return parent::beforeAction($action);
    }

    public function fetchCache($key)
    {
        $key = \WS::$app->area->id.'-'.\WS::$app->language.'.'.$key;
        return \WS::$app->cache->get($key);
    }

    public function saveCache($key, $data, $time = 0)
    {
        $key = \WS::$app->area->id.'-'.\WS::$app->language.'.'.$key;
        if (\WS::$app->cache->exists($key)) {
            return \WS::$app->cache->set($key, $data, $time);
        }
        return \WS::$app->cache->add($key, $data, $time);
    }

    public function isSeoCrawlerAccess ()
    {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $spiderSite= [ 
            "Googlebot",
            "TencentTraveler", 
            "Baiduspider+", 
            "BaiduGame", 
            "Googlebot", 
            "msnbot", 
            "Sosospider+", 
            "Sogou web spider", 
            "ia_archiver", 
            "Yahoo! Slurp", 
            "YoudaoBot", 
            "Yahoo Slurp", 
            "MSNBot", 
            "Java (Often spam bot)", 
            "BaiDuSpider", 
            "Voila", 
            "Yandex bot", 
            "BSpider", 
            "twiceler", 
            "Sogou Spider", 
            "Speedy Spider", 
            "Google AdSense", 
            "Heritrix", 
            "Python-urllib", 
            "Alexa (IA Archiver)", 
            "Ask", 
            "Exabot", 
            "Custo", 
            "OutfoxBot/YodaoBot", 
            "yacy", 
            "SurveyBot", 
            "legs", 
            "lwp-trivial", 
            "Nutch", 
            "StackRambler", 
            "The web archive (IA Archiver)", 
            "Perl tool", 
            "MJ12bot", 
            "Netcraft", 
            "MSIECrawler", 
            "WGet tools", 
            "larbin", 
            "Fish search"
        ];

        foreach($spiderSite as $val) { 
            $str = strtolower($val); 
            if (strpos($userAgent, $str) !== false) { 
                return true; 
            } 
        }

        return false;
    }
}
