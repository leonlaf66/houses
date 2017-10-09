<?php
namespace module\yellowpage\models;

use module\core\helpers\Image;

class YellowPagePhoto extends \yii\db\ActiveRecord 
{  
    const IMAGE_TYPE_NAME = 'yellowpage';
    const PLACEHOLDER = 'placeholder.jpg';

    public static function tableName()  
    {  
        return 'yellow_page_photo';
    }

    public function getStorage()
    {
        return $this->hasOne(\module\core\models\Storage::className(), ['id' => 'storage_id']);
    }
}