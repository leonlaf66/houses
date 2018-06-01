<?php
namespace module\cms\components;

use WS;

class Page extends \yii\base\Component
{
    public $id = '';
    public $name = ['', ''];
    public $metas = null;
    public $params = [];

    public function init()
    {
        $this->name = tt($this->name);

        $this->setId(WS::$app->controller->module->id.'/'.WS::$app->controller->id.'/'.WS::$app->controller->action->id);

        return parent::init();
    }

    // 由app bootstrap中调用
    public function end()
    {
        if (is_mobile_request()) {
            $this->rewriteToMobilePage();
        }
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // 支持webapp跳转
    protected function rewriteToMobilePage()
    {
        $rewrites = include(APP_ROOT.'/config/mobile.rewrites.php');

        $targetUrl = '';
        if (isset($rewrites[$this->id])) {
            $webAppPath = ($rewrites[$this->id])(WS::$app->request);
            if (is_string($webAppPath)) {
                $webAppPath = [$webAppPath];
            }
            $webAppPath['language'] = WS::$app->language;

            $targetUrl = '/'.WS::$app->area->id.$webAppPath[0];
            unset($webAppPath[0]);
            if (count($webAppPath) > 0) {
                $targetUrl .= '?'.http_build_query($webAppPath);
            }
        } else {
            $targetUrl = '/';
        }

        WS::$app->controller->redirect(WS::$app->params['webApp']['baseUrl'].$targetUrl);
        WS::$app->end();
    }

    public function bindParams($params)
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function title()
    {
        return $this->getMeta('title');
    }

    public function metaKeywords()
    {
        return $this->getMeta('keywords');
    }

    public function metaDescription()
    {
        return $this->getMeta('description');
    }

    public function getMeta($field)
    {
        if(! $this->id || $this->id === '') return '';

        static $metasCache = [
            'home/default/area' => [
                'title' => ['Home - Housing for sale', '首页 - 美国买房'],
                'keywords' => '海外房产,海外购房,美国房产网,北美房产网,海外买房,美国置业,海外置业,海外投资,美国投资,美国炒房,海外炒房,美国房地产,美国房产,美国购房,美国买房,北美房地产,美国房产咨询,北美房产咨询,波士顿房产咨询,波士顿买房,波士顿租房,波士顿房产,波士顿购房,波士顿房产网,波士顿房产网,波士顿置业,波士顿投资,波士顿炒房,波士顿房地产',
                'description' => '米乐居是美国房地产网络平台，本站为用户提供最新、最全的实时房源，提供国内用户一条龙房产服务。让您不再为海外置业选房、看房、买房、养房发愁。'
            ]
        ];
        if (! isset($metasCache[$this->id])) {
            $metasCache[$this->id] = \models\SiteSeoMeta::find()->where(['area_id' => \WS::$app->area->id, 'path' => $this->id])->one();
        }

        $metas = $metasCache[$this->id];
        if (! $metas) return '';

        if (isset($metas[$field])) {
            $text = is_array($metas[$field]) ? tt($metas[$field]) : $metas[$field];
            if (preg_match_all('/%([a-z_\-0-9]+)%/', $text, $matches)) {
                foreach ($matches[1] as $paramId) {
                    if (isset($this->params[$paramId])) {
                        $text = str_replace('%'.$paramId.'%', $this->params[$paramId], $text);
                    }
                }
            }
            return $text;
        }

        return '';
    }
}