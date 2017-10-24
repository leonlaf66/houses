<?php
namespace module\news\models;

class News extends \models\News
{
    public static function search($typeId=1)
    {
        $query = self::find();
        if ($typeId) {
            $query->andWhere('type_id='.intval($typeId));
        }
        $query->andWhere('status=1');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '10',
            ],
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        return $dataProvider;
    }

    public static function find()
    {
        $query = parent::find();

        $query->andWhere('(is_public=true or area_id @> :area_id)', [
            ':area_id' => '{'.\WS::$app->area->id.'}'
        ]);

        return $query;
    }

    public function getUrl()
    {
        return \WS::$app->urlManager->createUrl(['news/default/view', 'id'=>$this->id]);
    }
}