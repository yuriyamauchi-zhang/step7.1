<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\Requests\ProductRequest;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Log;

class ProductController extends Controller

{
    //一覧
    public function showList(Request $request){
        $keyword = $request->input('keyword');
        $searchCompany = $request->input('search-company');
        $min_price = $request -> input('min_price');
        $max_price = $request -> input('max_price');
        $min_stock = $request -> input('min_stock');
        $max_stock = $request -> input('max_stock');
        $select = $request -> input('select');





        $model = New product;
        $products = $model->searchList($keyword, $searchCompany, $min_price, $max_price, $min_stock, $max_stock, $select);

        $companies = DB::table('companies')->get();

        return view('Lists',['products' => $products, 'companies' => $companies]);
        
    }
 
    //新規登録
    public function showRegistForm(){
        $companies = DB::table('companies')->get();

        return view('regist', compact('companies'));
    }

    //新規登録の処理
    
    public function registSubmit(Request $request ){
        $model = New product;

        DB::beginTransaction();
        
        try{
            
            $image = $request->file('img_path');
            if($image){
                //画像あり
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $img_path = 'storage/images/'.$filename;
            }else{
                //画像なし
                $img_path = null;
            }
            
            //companiesテーブルから全部持ってきてくださいっていう処理
            $companies = DB::table('companies')->get();
            
            //model新規登録処理の呼び出し、実際の登録処理(product.phpのegistSubmitに飛ぶ)
            $products = $model->registSubmit($request, $img_path);

            
            DB::commit();
            //登録できたらリストに戻る
            return redirect(route('lists'));
        }catch(Exceptiom $e) {
            DB::rollBack();
        }   

        }

    //商品詳細画面
    public function showDetail( $id){
        $model = New product;
        $product = $model->getProductById($id);

        return view ('detail', ['product' => $product]);
    }

    //商品編集画面
    public function showEditForm(Request $request,$id){
        $model = New product;
        $companies = DB::table('companies')->get();
        $product = $model->getProductById($id);

        return view ('edit', ['companies' => $companies, 'product' => $product]);
    }

    //商品編集
    public function registEdit(ProductRequest $request, $id){
        $model = New product;
        DB::beginTransaction();
        try{
            $image = $request->file('img_file');
            if($image){
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images',$filename);
                $img_path = 'storage/images/'.$filename;
                $model->registEdit($request, $img_path, $id);
            }else{
                $model->registEditNoImg($request, $id);
            }

            DB::commit();
            return redirect(route('showDetail', ['id' => $id]));
        }catch(Exceptiom $e) {
            DB::rollBack();
        }    
    }



public function delet(Request $request, $id) {
    $product = product::findOrFail($id);
    $product->delete();
    return redirect()->route('lists');
}





}