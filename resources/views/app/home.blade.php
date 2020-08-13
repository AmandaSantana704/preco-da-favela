@extends('app.layout.main')
@section('title', 'Início')
@section('section')
{{-- GEOLOCATION --}}
    <header>
        <span class="ti-location-pin" style="font-size: 22px;"></span>
        <span id="adressUser" class="limit">Sem localização</span>
    </header>
    
    <section class="category">
        <div class="owl-carousel owl-theme owl-loaded owl-drag mt-5 category-carousel">
            <div class="owl-stage-outer">
                <div class="container">
                    <div class="owl-stage" style="transform: translate3d(-594px, 0px, 0px); transition: all 0.25s ease 0s; width: 2376px;">
                        @foreach($categorys as $category)
                        @if($category->name != 'Outro')
                        <div class="owl-item">
                            <a href="{{route('app.storeCategory', ['id'=>$category->id])}}">
                                <div class="item category-item">
                                    <img class="lazy" src="{{asset('images/category/'.$category->img)}}" alt="category">
                                </div>
                                <div class="category-item_info">{{$category->name}}</div>
                            </a>
                        </div>
                        @endif
                        @endforeach
                        
        
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- CROUSEL CATEGORY --}}
    <section class="highlights container">
        <div class="owl-carousel owl-theme owl-loaded owl-drag mt-5 highlights-carousel">
            <div class="owl-stage-outer">
                <div class="owl-stage" style="transform: translate3d(-594px, 0px, 0px); transition: all 0.25s ease 0s; width: 2376px;">
    
                    <div class="owl-item col-12">
                        <a href="{{route('app.offer')}}"><img class="lazy" src="{{asset('images/app/banner-1.jpg')}}" alt="" style="width:100%; border-radius:20px;"></a>
                    </div>
                    <div class="owl-item col-12">
                        <a href="{{route('app.search')}}"><img class="lazy" src="{{asset('images/app/banner-2.jpg')}}" alt="" style="width:100%; border-radius:20px;"></a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    {{-- STORE --}}
    <section class="container store mt-5">
        <h1 class="mb-3">Comércios</h1>
        <form method="POST" action="{{route('app.filter.store')}}">
            @csrf
            <select name="filterCategory" class="form-control filterCategorySearch">
                <option selected>Tipo de comércio</option>
                @foreach($categorys as $category)
                @if($category->name != 'Outro')
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endif
                @endforeach
                <option value="54">Outros...</option>
            </select>
        </form>
        <div class="row">
            @foreach($commerces as $commerce)
            @if($commerce->is_deleted === null)
                <div class="store-all-items mt-4 col-12 col-md-6">
                    <a href="{{route('app.store', ['id'=>$commerce->id])}}">
                    <div class="store-item">
                        {{-- <div class="store-verified-box">
                            <img src="{{asset('images/app/store-verified.svg')}}" alt="verified">
                        </div> --}}
                        <div class="store-item-image">
                            <img class="lazy" src="{{$commerce->cover === null ? asset('images/app/generic-image.svg') : asset('images/commerce/'.$commerce->cover)}}" alt="store-photo">
                        </div>
                        <h2>{{$commerce->name}}</h2>
                        <p>{{$commerce->category_name}}</p>
                        {{-- <div class="store-likes mt-3">
                            <div class="store-liks_box">
                                <span class="ti-heart" style="font-size: 22px; margin-right:5px; color:#8274E6;"></span> 
                                <span style="color:#959595; font-size:14px;">1078 curtidas</span>
                            </div>
                        </div> --}}
                    </div>
                    </a>
                </div>
                @endif
            @endforeach
            
        </div>
    
    </section>
   
@endsection
@section('js')
<script>
    $(".limit").each(function (i) {
      var text = $(this).text();
      var len = text.length;
      if (len > 25) {
        var query = text.split(" ", 3);
        query.push('...');
        res = query.join(' ');
        $(this).text(res);
      }
    });
  </script>
@endsection