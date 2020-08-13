@extends('app.layout.main')
@section('title', 'Buscar produto em promoção')
@section('section')
<section class="container page-offer">
    <form method="POST" action="{{route('app.search.product.offer')}}" class="fixed-search">
        @csrf
        <div class="input-group md-form form-sm form-1 pl-0">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-text1">
                  <i class="ti-search menu-icon" aria-hidden="true" style="color: #8274E6;"></i></span>
            </div>
           
            <input name="product" class="form-control my-0 py-1" type="text" placeholder="Busque produtos em promoção" aria-label="Search">
          </div>
    </form>

      <div class="page-offer-result">
        <h1 class="mt-4 mb-4"><a href="{{ url()->previous() }}" class="ti-angle-left" style="color: #333333; font-size: 22px; position: relative; top:3px; padding-right:10px;"></a>Resultado da busca</h1>
       
    </div>
</section>

<section class="container offer">
    <div class="row">
        @foreach($productsoffer as $product)
        <div class="offer-all-items col-12 col-md-6 mb-3">
            <a href="{{route('app.store', ['id' => $product->commerce_id])}}">
                <div class="offer-item">
                    @if($product->offer != null)
                    <div class="offer-verified-box">
                        <img src="{{asset('images/app/offer.svg')}}" alt="verified">
                    </div>
                    @endif
                    <div class="offer-item-image">
                        <img class="lazy" src="{{asset('images/product/'.$product->img)}}" alt="offer-photo">
                    </div>
                    <h2>{{$product->name}}</h2>
                    {{-- <p class="mb-2">Depósito Duca Brito</p> --}}
                    <p class="mb-2 product-description">{{$product->description}}</p>
                    <p class="mb-2 product-store">{{$product->commerce_name}}</p>
                    <span class="product-price">{{'R$'.str_replace('.', ',', $product->offer)}}</span>
                    <span class="product-offer">{{'R$'.str_replace('.', ',', $product->price)}}</span>
                </div>
            </a>
        </div>
        @endforeach
        @if(isset($notResult))
        <div class="exceptions col-12">
            <img src="{{asset('images/app/sad.svg')}}" alt="sad" class="mb-3">
            <h2>{{$notResult}}</h2>
            <p>Por favor, busque por outro termo.</p>
        </div>
        @endif
    </div>

</section>

@endsection