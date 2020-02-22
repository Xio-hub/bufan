<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];

    public function getUserCategories($category_ids, $user_id)
    {
        $category_ids = implode(',',$category_ids);
        $categories = DB::select('select categories.id,categories.name,category_alias.alias from categories left join 
        (select * from category_alias where merchant_id=?)category_alias ON `categories`.`id` = `category_alias`.`category_id` 
        WHERE `categories`.`id` IN ('.$category_ids.')', [$user_id]);

        $data = [];
        foreach($categories as $i => $v){
            $data[$i]['id'] = $v->id;
            if(!empty($v->alias)){
                $data[$i]['name'] = $v->alias;
            }else{
                $data[$i]['name'] = $v->name;
            }
        }

        return $data;
    }
}
