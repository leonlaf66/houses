<?php
namespace module\yellowpage\models;

class YellowPageType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'yellow_page_type';
    }

    public function getTerm()
    {
    	return $this->hasOne(\module\core\models\TaxonomyTerm::className(), ['id' => 'type_id']);
    }

    public function getName()
    {
    	if($term = $this->term) {
    		return $this->term->name;
    	}
    	return '';
    }
}