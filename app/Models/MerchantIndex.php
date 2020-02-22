<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MerchantIndex extends Model
{
    protected $table = 'merchant_index';
    protected $guarded = [];

    public static function getIndexContent($user_id)
    {
        $data = DB::select('select `merchant_index`.`cover`,`merchant_index`.`type`,`index_resources`.`content` from `merchant_index`
         left join `index_resources` on `merchant_index`.`id` = `index_resources`.`index_id`
          where (`merchant_index`.`merchant_id` = ? and `index_resources`.`source_type` = `merchant_index`.`type`) limit 1', [$user_id]);
        return $data ? $data[0] : [];
    }
}
