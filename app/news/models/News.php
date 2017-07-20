<?php
namespace module\news\models;

class News extends \common\news\News
{
    public static function search($typeId=1)
    {
        $query = self::find();
        if ($typeId) {
            $query->andWhere('type_id='.intval($typeId));
        }
        $query->andWhere('status=1');
        //$query->orderBy('id', 'DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '10',
            ]
        ]);

        return $dataProvider;
    }

    public static function find()
    {
        $query = parent::find();

        $query->andWhere('(is_public=true or towns @> :towns)', [
            ':towns' => '{'.\WS::$app->stateCode.'}'
        ]);

        return $query;
    }

    public function getUrl()
    {
        return \WS::$app->urlManager->createUrl(['news/default/view', 'id'=>$this->id]);
    }
}