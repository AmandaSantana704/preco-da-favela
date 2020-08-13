@extends('admin.layout.main')
@section('title', 'Cadastrar produto')
@section('contain')



    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Cadastre o seu produto</h3>
        <div class="d-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item">Campos marcados com <span style="color:#5f76e8;">*</span> são obrigatórios
                    </li>
                </ol>
            </nav>
        </div>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <form action="{{route('product.save', ['id'=>$sessionId])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                   <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="nome">Digite o nome do produto/serviço <span style="color:#5f76e8;">*</span></label>
                        <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Nome do produto/serviço" value="{{old('name')}}" maxlength="100">
                    </div>
                        <div class="col-md-6 mb-3">
                            <label for="categoria">Selecione uma categoria <span style="color:#5f76e8;">*</span></label>
                            <select name="category" class="form-control @error('category')is-invalid @enderror">
                                <option disabled selected>Selecione uma categoria</option>
                                @foreach($categorys as $category)
                                @if($category->name != 'Outro')
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                                @endforeach
                                <option value="36">Outro...</option>
                            </select>
                        </div>
                   </div>
                   
                   <div class="row mb-3">
                       <div class="col mb-3">
                        <label for="descritivo">Detalhes do produto/serviço</label>
                        <textarea name="description" id="" cols="15" rows="3" class="form-control @error('description')is-invalid @enderror" placeholder="Fale um pouco sobre o produto/serviço">{{old('description')}}</textarea>
                       </div>
                   </div>
                   <div class="row mb-3">
                       <div class="col-md-6 mb-3">
                            <label for="valor">Valor do produto <span style="color:#5f76e8;">*</span></label>
                           <input type="text" class="form-control money @error('price')is-invalid @enderror" name="price"  value="{{old('price')}}" placeholder="Valor do produto">
                       </div>
                       <div class="col-md-6 mb-3">
                            <label for="offer">Valor promocional</label>
                            <input type="text" class="form-control money @error('offer')is-invalid @enderror" name="offer" value="{{old('offer')}}" placeholder="Valor promocional">
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12 mb-">
                            <div class="col-md-12 input-custom btn waves-effect waves-light btn-rounded btn-outline-primary btn-lg bt-custom">
                                 <span>Foto do produto<i class="fas fa-upload ml-3" aria-hidden="true"></i></span>
                            </div>
                            
                             <div class="input-opacity">
                                 <input type="file" name="img" index="0" value="{{old('img')}}" class="col-md-12 custom-file-input @error('img')is-invalid @enderror" id="inputGroupFile01" style="position: relative; height: 50px; top:-50px; cursor: pointer;">
                             </div>
                        </div>

                       </div>


                   <div class="row mb-3">
                        <input type="submit" value="Cadastrar produto" class="col-md-12 btn btn-success btn-rounded btn-lg">
                   </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{asset('js/geolocation.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    });
    activeHover('produto', '#linkProduct', 'active', '#li-linkProduct', 'selected');

    let input = document.querySelectorAll('.custom-file-input');
    input.forEach((el) => {
        el.addEventListener('change', function(){
            let index = this.getAttribute('index');
            let btCustom = document.querySelectorAll('.bt-custom');
                btCustom[index].classList.remove('btn-outline-primary');
                btCustom[index].classList.add('btn-outline-success');
        });
    });
    </script>
      @if($errors->any())
      @foreach($errors->all() as $error)
          @component('component.alert')
          {{$error}}
          @endcomponent
      @endforeach
  @endif
@endsection