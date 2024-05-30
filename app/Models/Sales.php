<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Product; // Productモデルを使用
use Illuminate\Support\Facades\DB;


class Sales extends Model

{


 // fillableかguardedのどちらかを指定する必要あり,下記or protected $guarded = [''];
protected $fillable = ['product_id'];

//insertを使用するときは日付データを追加してあげないとNULLになってしまう
public function registsales($id){
    DB::table('sales')
    ->insert([
        'product_id' => $id,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}
}

