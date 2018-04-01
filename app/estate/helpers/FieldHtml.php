<?php
namespace module\estate\helpers;

use module\estate\helpers\FieldFilter;

class FieldHtml
{
    public static function render($value, $title = '', $id = null, $filterId = null)
    {
        $valueHtml = self::valueHtml($value, $filterId);

        return "<div class=\"attr-field attr-field-{$id}\">
                    <label class=\"attr-label\">{$title}</label>
                    {$valueHtml}
                </div>";
    }

    public static function valueHtml($data, $filterId = null)
    {
        if ($filterId) {
            $data = FieldFilter::$filterId($data);
        }

        $value = is_array($data) ? $data[0] : $data;
        $prefix = is_array($data) ? $data[1] : '';
        $suffix = is_array($data) ? $data[2] : '';

        $parts = [];

        if ($prefix) {
            $parts[] = "<span class=\"attr-prefix\">{$prefix}</span>";
        }

        $parts[] = "<span class=\"attr-value\">{$value}</span>";

        if ($suffix) {
            $parts[] = "<span class=\"attr-suffix\">{$suffix}</span>";
        }

        $value = implode('', $parts);

        return "
            <span class=\"attr-value-box\">
                {$value}
            </span>
        ";
    }
}
