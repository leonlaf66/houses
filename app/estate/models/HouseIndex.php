<?php
namespace module\estate\models;

class HouseIndex extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'house_index_v2';
    }

    public static function primaryKey()
    {
        return ['list_no'];
    }
}