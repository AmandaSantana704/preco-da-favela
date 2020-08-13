@extends('app.layout.main')
@section('title', 'Comércio')
@section('section')
<section class="container page-search">
    <form method="POST" action="{{route('app.search.store')}}" class="fixed-search">
        @csrf
        <div class="input-group md-form form-sm form-1 pl-0">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-text1">
                  <i class="ti-search menu-icon" aria-hidden="true" style="color: #8274E6;"></i></span>
            </div>
           
            <input name="commerce" class="form-control my-0 py-1" type="text" placeholder="Busque por comércio" aria-label="Search">
          </div>
    </form>
      <div class="page-serach-result">
        <h1 class="mt-4 mb-3"><a href="{{ url()->previous() }}" class="ti-angle-left" style="color: #333333; font-size: 22px; position: relative; top:3px; padding-right:10px;"></a>{{$category['name']}}</h1>
        <section class="container store mt-3">
            <form method="POST" action="{{route('app.filter.store')}}">
                @csrf
                <select name="filterCategory" class="form-control filterCategorySearch">
                    <option selected>Tipo de comércio</option>
                    @foreach($Allcategorys as $category)
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
                                <div class="store-likes mt-3">
                                    {{-- <div class="store-liks_box">
                                        <span class="ti-heart" style="font-size: 22px; margin-right:5px; color:#8274E6;"></span> 
                                        <span style="color:#959595; font-size:14px;">1078 curtidas</span>
                                    </div> --}}
                                </div>
                            </div>
                            </a>
                        </div>
                        @endif
                        @endforeach

                        @if(isset($notResult))
                        <div class="exceptions col-12 mt-5">
                            <img src="{{asset('images/app/sad.svg')}}" alt="sad" class="mb-3">
                            <h2>{{$notResult}}</h2>
                            <p>Por favor, filtre por outra categoria.</p>
                        </div>
                        @endif
            </div>
        
        </section>
    </div>
</section>

@endsection