@extends('admin.layout.main')
@section('title', 'Atualizar comércio')
@section('contain')



    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Edite o seu comércio</h3>
        <div class="d-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item">Campos marcados com <span style="color:#5f76e8;">*</span> são obrigatórios
                    </li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary bt-location mb-5 btn-rounded">Atualizar localização</button>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               
                <div class="alert alert-success alert-dismissible fade show alertGeolocation alertSystem" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    Localização atualizada com sucesso!
                </div>
                <form action="{{route('commerce.update', ['id'=>$infos['id']])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                   <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="nomeDoComercio">Digite o nome do comércio <span style="color:#5f76e8;">*</span></label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Nome do comércio" value="{{$infos['name']}}" maxlength="100">      
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categoriaDoComercio">Selecione a categoria <span style="color:#5f76e8;">*</span></label>
                            <select name="category" class="form-control @error('name')is-invalid @enderror">
                                @foreach($categorys as $category)
                                    @if($infos['category'] == $category['id'])
                                    <option selected value="{{$infos['category']}}">{{$category['name']}}</option>
                                    @endif
                                    @if($infos['category'] != $category['id'] && $category['name'] != 'Outro')
                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                    @endif
                                @endforeach
                                <option value="54">Outro...</option>
                            </select>
                        </div>
                   </div>
                   <div class="row mb-3">
                       <div class="col mb-3">
                        <label for="descritivo">Descreva o seu comércio</label>
                        <textarea name="description" id="" cols="15" rows="3" class="form-control" placeholder="Fale um pouco sobre o seu comércio">{{$infos['description']}}</textarea>
                       </div>
                   </div>
                   <div class="row mb-3">
                       <div class="col-md-4 mb-3">
                            <label for="horario">Horário de funcionamento</label>
                           <input type="text" class="form-control" name="operation"  value="{{$infos['operation']}}" placeholder="Horário de funcionamento">
                           <small id="name1" class="badge badge-default badge-info form-text text-white float-left">          
                            Exemplo: Aberto de segunda à sábado, das 07:00h às 20:30h..
                            </small>
                       </div>
                       <div class="col-md-4 mb-3">
                        <label for="numeroContato">Número de contato</label>
                        <input type="text" class="form-control sp_celphones" name="telephone"  value="{{$infos['telephone']}}" placeholder="Número de contato">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="emailContato">Seu e-mail</label>
                            <input type="email" class="form-control" name="email"  value="{{$infos['email']}}" placeholder="Seu e-mail">
                        </div>
                   </div>
                   <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                         <label for="instagram">Instagram exemplo: ( precodafavela )</label>
                        <input type="text" class="custom-app-input form-control" name="instagram"  value="{{$infos['instagram']}}" placeholder="Instagram">
                    </div>
                    <div class="col-md-6 mb-3">
                     <label for="whatsapp">WhatsApp (insira o DDD)</label>
                     <input type="text" class="custom-app-input form-control sp_celphones" name="whatsapp"  value="{{$infos['whatsapp']}}" placeholder="WhatsApp">
                     </div>
                </div>
                   <div class="row mb-3">
                       <div class="col-md-6 mb-3">
                            <label for="endereco">Endereço <span style="color:#5f76e8;">*</span></label>
                            <input type="text" name="location"  value="{{$infos['location']}}" class="form-control @error('name')is-invalid @enderror" placeholder="Endereço">
                       </div>
                       <div class="col-md-6 mb-3">
                        <label for="bairro">Bairro <span style="color:#5f76e8;">*</span></label>
                        <input type="text" name="district"  value="{{$infos['district']}}" class="form-control @error('name')is-invalid @enderror" placeholder="Bairro">
                        </div>
                   </div>
                   <div class="row mb-3">
                    <div class="col-md-6 col-mb-3">
                         <input type="hidden" name="lat" class="form-control" value="{{$infos['lat']}}">
                    </div>
                    <div class="col-md-6 col-mb-3">
                     <input type="hidden" name="lng" class="form-control" value="{{$infos['lng']}}">
                     </div>
                </div>
                   


                <div class="row">
                    <div class="col-md-6 mb-">
                        <div class="col-md-12 input-custom btn waves-effect waves-light btn-rounded btn-outline-primary btn-lg bt-custom">
                             <span>Logo do seu comércio<i class="fas fa-upload ml-3" aria-hidden="true"></i></span>
                        </div>
                        

                         <div class="input-opacity">
                             <input type="file" name="logo" index="0" value="{{$infos['logo']}}" class="col-md-12 custom-file-input" id="inputGroupFile01" style="position: relative; height: 50px; top:-50px; cursor: pointer;">
                         </div>

                         
                    </div>

                    <div class="col-md-6 mb-">
                     <div class="col-md-12 input-custom btn waves-effect waves-light btn-rounded btn-outline-primary btn-lg bt-custom">
                          <span>Foto do seu comércio<i class="fas fa-upload ml-3" aria-hidden="true"></i></span>
                     </div>
                      <div class="input-opacity">
                          <input type="file" name="cover" index="1" value="{{$infos['cover']}}" class="col-md-12 custom-file-input" id="inputGroupFile01" style="position: relative; height: 50px; top:-50px; cursor: pointer;">
                      </div>
                 </div>
                   </div>



                   <div class="row mb-3">
                        <input type="submit" value="Atualizar comércio" class="col-md-12 btn btn-success btn-rounded btn-lg">
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
        $('.sp_celphones').mask('(00) 0000-00000');
    });
    activeHover('comercio', '#linkCommerce', 'active', '#li-linkCommerce', 'selected');

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