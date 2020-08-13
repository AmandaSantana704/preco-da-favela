@extends('admin.layout.main')
@section('title', 'Gerenciar Comércio')
@section('contain')

    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Gerencie o comércio</h3>
        <div class="d-flex align-items-center mb-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item">Comércio
                    </li>
                </ol>
            </nav>
        </div>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="card-group">
                 <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$count}}</h2>
                                    <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                                        {{$count == 1 ? 'Usuário' : 'Usuários'}}
                                    </span>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total de usuários</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$count}}</h2>
                                    <span class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                                        {{$count == 1 ? 'Produto' : 'Produtos'}}
                                    </span>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total de produtos</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$count}}</h2>
                                    <span class="badge bg-warning font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                                        {{$count == 1 ? 'Sessão' : 'Sessões'}}
                                    </span>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total de sessões</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$count}}</h2>
                                    <span class="badge bg-success font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                                        {{$count == 1 ? 'Curtida' : 'Curtidas'}}
                                    </span>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total de curtidas</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
        
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('commerce.add', ['id'=>$commerce_id])}}" method="POST">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="categoriaDoComercio">Selecione um usuário<span style="color:#5f76e8;">*</span></label>
                                <select name="user" class="form-control @error('name')is-invalid @enderror">
                                    <option disabled selected>Selecione uma usuário</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <input type="submit" class="form-control btn btn-success" value="Autorizar usuário">
                            </div>
                        </form>
                    </div>
                       
                </div>
               
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Usuários com autorização</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item">Usuários associados ao comércio
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>   
                
                <div class="table-responsive">
                    <table id="multi_col_order"
                        class="table table-striped table-bordered display no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Usuário</th>
                                <th width="150">Permissão</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commerces as $commerce)
                            <tr>
                                <td>{{$commerce->id}}</td>
                                <td class="limitNameCommerce">{{$commerce->user_name}}</td>
                                <td>
                                    <form action="{{route('commerce.unlink', ['id'=>$commerce->id])}}" method="POST">
                                        @csrf
                                        <div class="col-md-12 mb-3">
                                            <input type="hidden" name="commerce_id" class="form-control">
                                        </div>
                                        <input type="submit" value="Desvincular" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              
              
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript">    
        delAction('btDelCommerce', 'Deletar comércio', 'Tem certeza que deseja deletar esse comércio?');
        limit('limitNameCommerce', 12, 2);
        activeHover('comercio', '#linkCommerce', 'active', '#li-linkCommerce', 'selected');

        let link = window.location.href;
        let matches = link.match(/\d+$/);
        let number;
        if (matches){
            number = matches[0];
        }
        let commerceId = document.querySelector('input[name="commerce_id"]');
            commerceId.value = number;
    </script>
    @if(session('unique'))
    @component('component.alert')
        {{session('unique')}}
    @endcomponent
@endif
@if(session('success'))
    @component('component.success')
        {{session('success')}}
    @endcomponent
@endif
@if(session('warning'))
    @component('component.alert')
        {{session('warning')}}
    @endcomponent
@endif
@endsection
