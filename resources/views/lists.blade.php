

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            
            <h1>商品一覧画面</h1>
            <!--検索するところ-->
            <form action="{{ route('lists')}}" method="GET" id="search-forms">
                <div class="seach">
                    <div class="row">
                    
                        
                           <input type="text" placeholder='検索キーワード' name='keyword' class="form-control search-input col-auto" width="40%" >
                           <span class="col-auto">&nbsp; &nbsp; </span>
                       
                            <select name="search-company"class="form-control search-input col-auto" width="40%">
                            <option value=""> メーカー名</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name}}</option>
                            @endforeach
                            </select>
                        
                    </div>


                    <div class="row">
                           <input type="number" placeholder="在庫下限" name="min_stock" class="form-control search-input col-auto" id=“search-btn”>
                           <span class="col-auto">~</span>
                           <input type="number" placeholder="在庫上限" name="max_stock" class="form-control search-input col-auto" id=“search-btn”>
                    </div>

                </div>
                        <div>
                         <input type="submit" class="btn btn-into search-btn" value="検索" id=“search-btn”>
                        </div>

            </form>
        </div>
    </div>


                <!--商品の一覧-->
                <div id="products-table">
                    <table border="1" class="table table-striped" id="pr-table">
                                                                   <!--↑idのところをsort.jsに-->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>メーカー名</th>
                                
                        <!--onclick:このボタンを押すとregistっていうrouteに飛んでくださいっていう指示-->
                                <button onclick="location.href='{{ route('regist') }}'" class="btn btn-primary">新規登録</button>
                            </tr>
                        </thead>
                        <tbody>
                               @foreach ($products as $product)
                               <tr>
                               <td>{{ $product->id }}</td>
                              
                               <td>
                              <!--altは画像がない時に代わりに表示するもの-->
                               <img src="{{ asset($product->img_path) }}"  alt=" " class="imgsize" >
                               
                               </td>

                    

                       

                               <td>{{ $product->product_name }}</td>
                               <td>{{ $product->price }}</td>
                               <td>{{ $product->stock }}</td>
                               <td>{{ $product->company_name }}</td>
                               <td><input type="button" value="詳細" onclick="location.href='{{ route('showDetail', ['id' => $product->id]) }}'"class="btn btn-primary"></td>
                                <td>
                                    <form action="{{ route('destroy',['id' => $product->id ])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <!--クラスの所は１つに見えてスペースで区切られているので３つのクラスになっている-->
                                    <input type="submit" class="btn btn-danger delet-btn" value="削除" data-delete-id="{{ $product->id }}"></td>
                                    </form>

                                   


                              </tr>
                              @endforeach
                            </tbody>
                    </table>
                </div>
                
                

@endsection