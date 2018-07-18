<?php
namespace module\estate\helpers;

use WS;

class SearchSimilar
{
    public static function all($q)
    {
        $stateId = WS::$app->area->stateId;

        if ($stateId === 'MA') {
            return self::forMA();
        }

        return \models\City::getSearchList($stateId, function ($query) use ($isLease) {
            if ($isLease) {
                $query->innerJoin('listhub_index i', "e.id=i.city_id and i.prop_type='RN'");
            } else {
                $query->innerJoin('listhub_index i', "e.id=i.city_id and i.prop_type<>'RN'");
            }
        });
    }

    public static function forMA($q)
    {
        
    }
}

/*
select * 
from town
where similarity(encode("name_cn"::bytea, 'base64')::text, encode('顿'::bytea, 'base64'))>0.3
order by similarity(encode("name_cn"::bytea, 'base64')::text, encode('顿'::bytea, 'base64')) desc
*/