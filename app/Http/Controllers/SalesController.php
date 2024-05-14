<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用

class SalesController extends Controller
{
    public function buy(Request $request){
     $id = $request->input('product');
     
     //リクエストから必要なデータを取得する、商品情報取得
    $model = new product();
    $product = $model->getProductById($id);    


    // 商品が存在しない、または在庫が不足している場合
    if (!$product) {
        return response()->json(['message' => '商品が存在しません'], 404);
    }
    if ($product->stock <=0) {
        return response()->json(['message' => '商品が在庫不足です'], 400);
    }
    
    try {
        

          //データベース処理を記述
          DB::beginTransaction();

          // モデルの記述を読み込む
          $model -> getProductById($id);
  
          //上記成功したら登録するための記述
          DB::commit();
  
    }catch(Exception $e){
          DB::rollback();
        
    }

 }
}
    