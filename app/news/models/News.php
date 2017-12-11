<?php
namespace module\news\models;

class News extends \models\News
{
    public static function find()
    {
        $query = parent::find();

        $query->where('(is_public=true or area_id @> :area_id)', [
            ':area_id' => '{'.\WS::$app->area->id.'}'
        ]);

        return $query;
    }

    public function getUrl()
    {
        return \WS::$app->urlManager->createUrl(['news/default/view', 'id'=>$this->id]);
    }
}