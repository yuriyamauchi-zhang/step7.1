@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">
        <button onclick="location.href='{{ route('lists') }}'" class="btn btn-warning">戻る</button>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h1>商品情報編集画面</h1>
                </div>

            <form action="{{ route('registEdit', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="regist-form">
                    <div id="id-araa">
                        <label for="" class="form-label">ID</label>
                        {{$product->id}}
                </div>

                <div id="name-araa">
                    
                    <label for="" class="form-label">商品名 ※</label>
                    <input type="text" name="product_name" value="{{ $product->product_name }}">
                    @if( $errors->has('product_name'))
                    <p>{{ $errors->first('product_name') }}</p>
                    @endif
                   </div>
                   
                   <div id="company-area">
                    <label for="" class="form-label">メーカー名 ※</label>
                    <select name="company_id" id="">
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $company->company_name) == $company->id? 'selected' : '' }}> {{ $company->company_name}}
                    
                        </option>
                         @endforeach
                        </select>
                    </div>

            <div id="price-area">
                <label for="" class="form-label">価格 ※</label>
                <input type="text" name="price" value="{{ $product->price }}">
                @if( $errors->has('price'))
                <p>{{ $errors->first('price') }}</p>
                @endif
            </div>
            <div id="stock-area">
                 <label for="" class="form-label">在庫 ※</label>
                 <input type="text" name="stock" value="{{ $product->stock }}">
                 @if( $errors->has('stock'))
                 <p>{{ $errors->first('stock') }}</p>
                @endif
            </div>
            <div id="comment-area">
                <label for="" class="form-label">コメント</label>
                <textarea name="comment" id="" >{{$product->comment}}</textarea>
                @if( $errors->has('comment'))
                <p>{{ $errors->first('comment') }}</p>
                @endif
            </div>
            
            <div id="img-area">
            <label for="" class="form-label">画像</label>
            <input type="file" name="img_file"> 
            <img src="{{ asset($product->img_path) }}">

            </div>

            <input type="submit" value="更新" class="btn btn-success">
               
            </form>
        </div>
    </div>
@endsection