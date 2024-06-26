<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model

{
    use HasFactory;

//データベースの処理の操作

//検索のところ
public function searchList($keyword, $searchCompany, $min_price, $max_price, $min_stock, $max_stock, $select){
    //ID検索
    $query =DB::table('products')
    //(companiesと紐付けます,紐付けるのはプロダクトのカンパニーID,と,カンパニーズのID)
    ->join('companies', 'products.company_id', '=', 'companies.id')
    //プロダクト全部からカンパニーズのカンパニーネームだけ抽出
    ->select('products.*', 'companies.company_name');

    //if文この項目に入力があれば検索される、なければ飛ばされる
    //キーワード検索、プロダクトにプロダクトネームからlike（曖昧検索）
    if($keyword) {
        $query->where('products.product_name', 'like', "%{$keyword}%");
    }
    //メーカー名検索
    if($searchCompany) {
        $query->where('products.company_id', '=', $searchCompany);
    } 
    //価格下限
    //isset.これは変数が宣言されており,null とは異なる値だということ,セットで考えてとのこと、、
    if(isset($min_price)) {
        $query->where('products.price', '>=', $min_price);
    } 
    //価格上限
    if(isset($max_price)) {
        $query->where('products.price', '<=', $max_price);
    } 
    //在庫下限
    if(isset($min_stock)) {
        $query->where('products.stock', '>=', $min_stock);
    }
    //在庫上限
    if(isset($max_stock)) {
        $query->where('products.stock', '<=', $max_stock);
    }


    //$productsから上記$queryの条件に合うデータを取得
    $products = $query->get();
    return $products;
    
}


//ID検索
public function getProductById($id){
    //プロダクトテーブルを操作しますっていう宣言
    $products=DB::table('products')
    //productIDとcompanyIDの紐付け[Step４]
    ->join('companies', 'products.company_id', '=', 'companies.id')
    ->select('products.*', 'companies.company_name')
    //プロダクトテーブルから商品のIDを検索
    ->where('products.id', '=', $id)
    //最終的に表示させる
    ->first();

    return $products;
}

//新規
public function registSubmit($request, $img_path){
    // Step５でやってる
    DB::table('products')->insert([
        'product_name'=> $request->input('product_name'),
        'company_id'=> $request->input('company_id'),
        'price'=> $request->input('price'),
        'comment' => $request->input('comment'),
        'img_path' => $img_path,
        'stock' => $request->input('stock')
        
        
    ]);
    
  
}


//更新、画像あり
public function registEdit($request, $img_path, $id){
    DB::table('products') 
    ->where('products.id', '=', $id)
    ->update([
        'product_name' => $request->input('product_name'),
        'company_id' => $request->input('company_id'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'img_path' => $img_path
    ]);
}

//更新、画像なし
public function registEditNoImg($request, $id){
    DB::table('products')
    ->where('products.id', '=', $id)
    ->update([
        'product_name' => $request->input('product_name'),
        'company_id' => $request->input('company_id'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment')
       
    ]);
}


//削除
public function destroyProduct($id){
    $products = DB::table('products')
    ->where('products.id', '=', $id) ->delete();
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
