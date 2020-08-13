@extends('app.layout.main')
@section('title', 'Comércio')
@section('section')
  {{-- MODAL PRODUCT --}}
<div class="modal fade" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <img class="lazy mb-3 mt-2 currentImg" src="" alt="">
            <h4 class="currentProduct"></h4>
            <p class="mb-2 currentCategory"></p>
            <div class="modal-product-box-price">
                <span class="product-price"></span>
            </div>
            {{-- <span class="product-offer">R$25,00</span> --}}
            <p class="mb-3 mt-3 currentDescription"></p>
            @if($commerce->whatsapp != null)
            <button socialstore="https://api.whatsapp.com/send?phone=55{{str_replace('-', '', preg_replace('/[^0-9\-]/', '', $commerce->whatsapp)).'&text=Bem-vindo'}}" class="btn btn-lg btn-app-success col-12 mb-2 socialstore">WhatsApp</button>
            @endif
            @if($commerce->instagram != null)
            <button socialstore="https://www.instagram.com/{{$commerce->instagram.'/'}}" class="btn btn-lg btn-app-danger col-12 mb-2 socialstore">Instagram</button><br>
            @endif    
        </div>

        </div>
      </div>
    </div>
  </div>
    {{-- END MODAL PRODUCT --}}
<section class="personal-store" onclick="removeAll();">
    <div class="personal-store-cover">
        <div class="personal-store_back">
            <a href="{{ url()->previous() }}" class="ti-angle-left" style="color: #ffffff; font-size: 22px; position: relative; top:3px; padding-right:10px;"></a>
        </div>
        
        <img class="lazy" src="{{$commerce->cover === null ? asset('images/app/generic-image.svg') : asset('images/commerce/'.$commerce->cover)}}" alt="store-photo">
        <div class="personal-store_overlay"></div>
        {{-- <div class="personal-store_verified">
            <img src="{{asset('images/app/store-verified.svg')}}" alt="verified">
        </div> --}}
        <div class="personal-store_logo">
            <a href="{{route('app.store', ['id'=>$commerce->id])}}">
                <img class="lazy" src="{{$commerce->logo === null ? asset('images/app/generic-image.svg') : asset('images/commerce/'.$commerce->logo)}}" alt="store-logo">
            </a>
        </div>
        <div class="personal-store_infos container mb-4">
            <h2>{{$commerce->name}}</h2>
            <p class="mb-3">{{$commerce->category_name}}</p>
            {{-- <span class="ti-heart" style="font-size: 22px; margin-right:5px; color:#8274E6;"></span>  --}}
            {{-- <span style="color:#959595; font-size:14px; position: relative; top: -5px;">1078 curtidas</span> --}}
            <div class="mt-3">
                <a href="#" class="btn btn-sm btn-app-primary-outline bt-info" element="about">Saiba mais</a>
                <a href="#" class="btn btn-sm btn-app-primary bt-info" element="contact">Contato</a>
            </div>
        </div>
        <hr>
    </div>
    <div class="container offer">
        <form method="POST" action="{{route('app.store.search', ['id'=>$commerce->id])}}" class="fixed-search">
            @csrf
            <div class="input-group md-form form-sm form-1 pl-0 mb-4">
                <div class="input-group-prepend">
                <span class="input-group-text" id="basic-text1">
                    <i class="ti-search menu-icon" aria-hidden="true" style="color: #8274E6;"></i></span>
                </div>
            
                <input name="product" class="form-control my-0 py-1" type="text" placeholder="Busque por produto" aria-label="Search">
            </form>
        </div>
        
        @if(isset($searchproducts))
        <div id="items-offer" class="mb-5">
            <h1 class="mb-3 mt-5">Resultado da busca</h1>
            <div class="row">
                @foreach($searchproducts as $product)
                <div class="offer-all-items col-12 col-md-6 mb-3">
                   {{-- <a href="#" class="openModalCompare"> --}}
                    <div class="offer-item openModalCompare" 
                    product="{{$product->name}}"
                    description="{{$product->description}}"
                    price="{{$product->offer === null ? $product->price : $product->offer}}" 
                    categoryproduct="{{$product->category_name}}" 
                    commerce="{{$product->commerce_name}}"
                    photo="{{asset('images/product/'.$product->img)}}"
                    >

                        @if($product->offer != null)
                        <div class="offer-verified-box">
                            <img src="{{asset('images/app/offer.svg')}}" alt="verified">
                        </div>
                        @endif
                        <div class="offer-item-image">
                            <img class="lazy" src="{{asset('images/product/'.$product->img)}}" alt="offer-photo">
                        </div>
                        <h2>{{$product->name}}</h2>
                        <p class="mb-2">{{$product->category_name}}</p>
                        <span class="product-price">{{'R$'.str_replace('.', ',', $product->price)}}</span>
                        <span class="product-offer">{{$product->offer === null ? '---' : 'R$'.str_replace('.', ',', $product->offer)}}</span>
                    </div>
                   {{-- </a> --}}
                </div>
                @endforeach
                    @if(isset($notResult))
                        <div class="exceptions col-12 mt-3">
                            <img src="{{asset('images/app/sad.svg')}}" alt="sad" class="mb-3">
                            <h2>{{$notResult}}</h2>
                            <p>Por favor, busque por outro termo.</p>
                        </div>
                    @endif
            </div>
        </div>
        @else
        <div id="items-offer" class="mb-5">
            @foreach($sessions as $session)
            <h1 class="mb-3 mt-5">{{$session->name}}</h1>
            <div class="row">
                @foreach($products as $product)
                @if($product->session_id == $session->id)
                <div class="offer-all-items col-12 col-md-6 mb-3">
                    {{-- <a href="#" class="openModalCompare"> --}}
                        <div class="offer-item openModalCompare" 
                            product="{{$product->name}}"
                            description="{{$product->description}}"
                            price="{{$product->offer === null ? $product->price : $product->offer}}" 
                            categoryproduct="{{$product->category_name}}" 
                            commerce="{{$product->commerce_name}}"
                            photo="{{asset('images/product/'.$product->img)}}"
                            >
                            @if($product->offer != null)
                            <div class="offer-verified-box">
                                <img src="{{asset('images/app/offer.svg')}}" alt="verified">
                            </div>
                            @endif
                            <div class="offer-item-image">
                                <img class="lazy" src="{{asset('images/product/'.$product->img)}}" alt="offer-photo">
                            </div>
                            <h2>{{$product->name}}</h2>
                            <p class="mb-2">{{$product->category_name}}</p>
                            @if($product->offer != null)
                                <span class="product-price">{{'R$'.str_replace('.', ',', $product->offer)}}</span>
                                <span class="product-offer">{{'R$'.str_replace('.', ',', $product->price)}}</span>
                                @else
                                <span class="product-price">{{'R$'.str_replace('.', ',', $product->price)}}</span>
                                <span class="product-offer">---</span>
                            @endif

                        </div>
                    {{-- </a> --}}
                </div>
                @endif
                @endforeach
            </div>
            @endforeach
        </div>
        @endif


        {{-- SOBRE --}}
        <div class="container remove reveal-element animate__animated animate__fadeIn" target="about">
            <div class="personal-store-about">
                <h1>Sobre</h1>
                <div class="info-close">
                    <div class="info-close_box">
                        <span class="ti-close" style="font-size: 25px; margin-right:5px; color:#8274E6;"></span> 
                    </div>
                </div>
                <p class="mb-4">{{$commerce->description}}</p>
                @if($commerce->telephone != null)
                <div class="personal-store-about_phone mb-3">
                    <span class="ti-mobile" style="font-size: 20px; color: #5C79E4;"></span>
                    <span style="position: relative; top: -3px; left:3px;">{{$commerce->telephone}}</span>
                </div>
                @endif
                @if($commerce->email != null)
                <div class="personal-store-about_email mb-3">
                    <span class="ti-email" style="font-size: 20px; color: #5C79E4;"></span>
                    <span style="position: relative; top: -3px; left:3px;">{{$commerce->email}}</span>
                </div>
                @endif
                @if($commerce->operation != null)
                <div class="personal-store-about_email mb-3">
                    <span class="ti-alarm-clock" style="font-size: 20px; color: #5C79E4;"></span>
                    <span style="position: relative; top: -3px; left:3px;">{{$commerce->operation}}</span>
                </div>
                @endif
                @if($commerce->location != null || $commerce->district != null)
                <div class="personal-store-about_email mb-3">
                    <span class="ti-location-pin" style="font-size: 20px; color: #5C79E4;"></span>
                    <span style="position: relative; top: -3px; left:3px;">{{$commerce->location.' - '.$commerce->district}}</span>
                </div>
                @endif
            </div>
            {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7777.918305652458!2d-38.47055032512691!3d-12.962977505939951!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7161023308cd577%3A0xa6b0535f5989f04c!2sAlto%20do%20Cabrito%2C%20Salvador%20-%20BA%2C%2041301-110!5e0!3m2!1spt-BR!2sbr!4v1592258916253!5m2!1spt-BR!2sbr" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> --}}
        </div>
        {{-- CONTATO --}}
        <div class="container remove reveal-element animate__animated animate__fadeIn" id="contact" target="contact">
            <h1>Contato</h1>
            <div class="info-close">
                <div class="info-close_box">
                    <span class="ti-close" style="font-size: 25px; margin-right:5px; color:#8274E6;"></span> 
                </div>
            </div>
            <div class="personal-store-contact">
                <img class="mb-3" src="{{asset('images/app/store-contact.svg')}}" alt="">
                <h2>Escolha como você deseja entrar em contato</h2>
                <p class="mb-3">Será um enorme prazer atendê-lo(a)!</p>
                <button socialstore="https://www.instagram.com/{{$commerce->instagram.'/'}}" class="btn btn-lg btn-app-danger col-12 mb-2 socialstore">Instagram</button><br>
                <button socialstore="https://api.whatsapp.com/send?phone=55{{str_replace('-', '', preg_replace('/[^0-9\-]/', '', $commerce->whatsapp)).'&text=Bem-vindo'}}" class="btn btn-lg btn-app-success col-12 mb-2 socialstore">WhatsApp</button> <br>
                {{-- <button class="btn btn-lg btn-app-primary col-12 mb-2">Facebook</button><br> --}}
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
    let openModalCompare = document.querySelectorAll('.openModalCompare');
    let currentImg, currentProduct, currentCategory, currentPrice;
        currentImg = document.querySelector('.currentImg');
        currentProduct = document.querySelector('.currentProduct');
        currentDescription = document.querySelector('.currentDescription');
        currentCategory = document.querySelector('.currentCategory');
        currentPrice = document.querySelector('.product-price');
    
        openModalCompare.forEach(element => {
            element.addEventListener('click', function (){
                console.log('ok');
                $('#modal-product').modal('show');
                
                currentImg.setAttribute('src', this.getAttribute('photo'));
                currentProduct.innerHTML = this.getAttribute('product');
                currentDescription.innerHTML = this.getAttribute('description');
                currentCategory.innerHTML = this.getAttribute('categoryproduct');
                currentPrice.innerHTML = 'R$ '+this.getAttribute('price').replace('.', ',');

            });
        });
    </script>
    <script>
        document.querySelectorAll('.socialstore').forEach(element => {
            element.addEventListener('click', function(){
               window.open(this.getAttribute('socialstore'));
            });
        });
    </script>
@endsection