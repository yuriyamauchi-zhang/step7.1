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
public function searchList($keyword, $searchCompany){
    $query =DB::table('products')
    ->join('companies', 'products.company_id', '=', 'companies.id')
    ->select('products.*', 'companies.company_name');

    if($keyword) {
        $query->where('products.product_name', 'like', "%{$keyword}%");
    }

    if($searchCompany) {
        $query->where('products.company_id', '=', $searchCompany);

    }

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
    ->first();

    return $products;
}

//新規
public function registSubmit($request, $img_path){
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


}