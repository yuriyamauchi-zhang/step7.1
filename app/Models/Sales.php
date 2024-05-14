<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用

class Sales extends Model

{
    
    use HasFactory;

    public function getProduct($id)
    {
    $product = DB::table('products')
        
    //どのデータを書き換えるか
    ->where('id', '=', $id)
    //デクリメント（’何を減らすか’）
    ->first();

    }

    public function decProduct($id)
    {
        //プロダクトテーブルを操作します
        $product = DB::table('products')
        
        //どのデータを書き換えるか
        ->where('id', '=', $id)
        //デクリメント（’何を減らすか’）
        ->decrement('stock');

    return $product;
    
}
}

