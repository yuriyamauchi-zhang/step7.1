@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h1>商品情報詳細画面</h1>
                </div>
      
              
                <div id="id-area">
                    <label for="" class="form-label">ID</label>
                    {{$product->id}}

                </div>

                <div id="img-area">
                    <label for="" class="form-label">商品画像</label>
                    {{$product->img_path}}

                </div>


                <div id="name-area">
                    <label for="" class="form-label">商品名</label>                    
                    {{$product->product_name}}
                </div>

                <div id="company-area">
                <label for="" class="form-label">メーカー名</label>
                {{$product->company_name}}

                </div>

                <div id="price-area">
                    <label for="" class="form-label">価格</label>
                    {{$product->img_path}}

                    
                </div>

                <div id="stock-area">
                    <label for="" class="form-label">在庫数</label>
                    {{$product->stock}}

                </div>

                <div id="comment-are">
                    <label for="" class="form-label">コメント</label>
                    {{$product->comment}}

                </div>



                <button onclick="location.href='{{ route('edit',['id'=>$product->id]) }}'" class="btn btn-warning">編集</button>
                <button onclick="location.href='{{ route('lists') }}'" class="btn btn-warning">戻る</button>

            
        </div>
    </div>
@endsection
