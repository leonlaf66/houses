<?php
namespace module\page\widgets;

use models\SiteSetting;

class Footer extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('html/footer.phtml');
    }

    public function getLinks() {
      $linksContent = SiteSetting::get('friended.links');
      $linksContent = str_replace(' ', '', $linksContent);

      $lines = explode("\n", $linksContent);

      $items = [];
      foreach ($lines as $line) {
          if (preg_match('/\[(.*)\](.*)/', $line, $matcheds)) {
            $items[] = [
              'title' => tt(explode(',', $matcheds[1])),
              'url' => $matcheds[2]
            ];
          }
      }

      return $items;
    }
}