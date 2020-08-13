@extends('admin.layout.main')
@section('title', 'Cadastrar seção')
@section('contain')



    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Cadastre uma seção</h3>
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

                <form action="{{route('session.save')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                   <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="commerce">Selecione um comércio <span style="color:#5f76e8;">*</span></label>
                        <select name="commerce" class="form-control @error('commerce')is-invalid @enderror">
                            <option disabled selected>Selecione um comércio</option>
                            @foreach($commerces as $commerce)
                                <option value="{{$commerce->id}}">{{$commerce->name}}</option>
                            @endforeach
                        </select>
                    </div>
                   </div>

                   <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                            <label for="secao">Digite o nome da seção <span style="color:#5f76e8;">*</span></label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Digite o nome da seção" value="{{old('name')}}" maxlength="100">
                    </div>
                   </div>
                   
                   <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <input type="submit" value="Cadastrar seção" class="col-md-12 btn btn-success btn-rounded btn-lg">
                        </div>
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
    </script>
        @if($errors->any())
        @foreach($errors->all() as $error)
            @component('component.alert')
            {{$error}}
            @endcomponent
        @endforeach
    @endif
@endsection