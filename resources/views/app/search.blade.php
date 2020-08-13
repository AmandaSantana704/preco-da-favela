@extends('app.layout.main')
@section('title', 'Busca')
@section('section')
<section class="container page-search">
    <form method="POST" action="{{route('app.search.product')}}" class="fixed-search">
        @csrf
        <div class="input-group md-form form-sm form-1 pl-0">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-text1">
                  <i class="ti-search menu-icon" aria-hidden="true" style="color: #8274E6;"></i></span>
            </div>
           
            <input name="product" class="form-control my-0 py-1" type="text" placeholder="Busque por produto" aria-label="Search">
          </div>
    </form>
      <div class="page-serach-result">
        <h1 class="mt-4 mb-4"><a href="{{ url()->previous() }}" class="ti-angle-left" style="color: #333333; font-size: 22px; position: relative; top:3px; padding-right:10px;"></a>Busque por categoria</h1>
        <div class="page-search-categorys">
            
            <div class="row">
                @foreach($categorys as $category)
                @if($category->name != 'Outro')
                <div class="page-search-categorys_items mb-3 col-6">
                    <a href="{{route('app.storeCategory', ['id' => $category->id])}}">
                    <h5>{{$category->name}}</h5>
                    <img class="lazy" src="{{asset('images/category/'.$category->img)}}" alt="">
                    <div class="page-search-categorys_overlay"></div>
                    </a>
                </div>
                @endif
                @endforeach
                <div class="page-search-categorys_items col-6">
                    <a href="{{route('app.storeCategory', '54')}}">
                    <h5>Outros</h5>
                    <img class="lazy" src="{{asset('images/category/outro.jpg')}}" alt="">
                    <div class="page-search-categorys_overlay"></div>
                    </a>
                </div>

            </div>
            
        </div>
    </div>
</section>

@endsection