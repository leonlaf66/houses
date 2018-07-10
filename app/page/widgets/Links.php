<?php
namespace module\page\widgets;

use models\SiteSetting;

class Links extends \yii\base\Widget
{
    public function run()
    {
        // $friendedLinks = \Yii::$app->cache->get('friended.links');

        $linksContent = SiteSetting::get('friended.links');
        $linksContent = str_replace(' ', '', $linksContent);

        $items = explode("\n", $linksContent);
        $items = array_map(function ($line) {
            if (preg_match('/\[(.*)\](.*)/', $line, $matcheds)) {
              return [
                'title' => tt(explode(',', $matcheds[1])),
                'url' => $matcheds[2]
              ];
            }
        }, $items);

        return $this->render('html/links.phtml', [
          'items' => $items
        ]);
    }
}