<?php
namespace module\estate\helpers;

use yii\helpers\ArrayHelper;

class RetsHtml
{
    public static function parseValueHtml($result)
    {
        $prefixHtml = '';
        $suffixHtml = '';

        if($result['value'] === '') {
            $result['value'] = 'Unknown';
        }
        else {
            if(isset($result['prefix'])) {
                $prefixHtml = "<span class=\"attr-prefix\">{$result['prefix']}</span>";
            }
            if(isset($result['suffix'])) {
                $suffixHtml = "<span class=\"attr-suffix\">{$result['suffix']}</span>";
            }
        }

        return "
            <span class=\"attr-value-box attr-{$result['id']}-box\">
                {$prefixHtml}
                <span class=\"attr-value\">{$result['value']}</span>
                {$suffixHtml}
            </span>
        ";
    }

    public static function parseFieldHtml($result)
    {
        $formatedValueHtml = self::parseValueHtml($result);
        $containerTag = 'div';

        $result['title'] = t('rets', $result['title']);

        return "<{$containerTag} class=\"attr-field attr-field-{$result['id']}\">
                    <label class=\"attr-label\">{$result['title']}</label>{$formatedValueHtml}
                </{$containerTag}>";
    }

    public static function getValueHtml($rets, $attribute, $options=[])
    {
        $prefixHtml = '';
        $suffixHtml = '';

        $data = $rets->render()->get($attribute, $options);

        return self::parseValueHtml($data);
    }

    public static function getFieldHtml($rets, $attribute, $options=[])
    {
        $data = $rets->render()->get($attribute);
        $data = array_merge($data, $options);

        return self::parseFieldHtml($data);
    }
}