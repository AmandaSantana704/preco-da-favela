@extends('admin.layout.main')
@section('title', 'Usuários')
@section('contain')


    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Lista de usuários</h3>
        <div class="d-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item">Usuários
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{route('user.register')}}" class="btn btn-success mb-5">Novo usuário</a>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="multi_col_order"
                        class="table table-striped table-bordered display no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Permissão</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                @if($user->is_deleted === null)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td class="limitNameUser">{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->display_name}}</td>
                                <td>
                                    <a href="{{route('user.edit', ['id'=>$user->id])}}" class="btn btn-primary text-white btn-circle-lg"><i class="fas fa-pencil-alt"></i></a>
                                    @if($isLogged != $user->id)
                                    <a href="{{route('user.delete', ['id'=>$user->id])}}" class="btn btn-light btn-circle-lg btDelUser" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                            </tr>
                                @endif
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
        delAction('btDelUser', 'Deletar usuário', 'Tem certeza que deseja deletar esse usuário?');
        limit('limitNameUser', 12, 2);
    </script>
    @if(session('warning'))
    @component('component.alert')
        {{session('warning')}}
    @endcomponent
@endif
@if(session('success'))
    @component('component.success')
        {{session('success')}}
    @endcomponent
@endif
@if(session('delMsg'))
    @component('component.success')
        {{session('delMsg')}}
    @endcomponent
@endif
@if(session('successRegister'))
    @component('component.success')
        {{session('successRegister')}}
    @endcomponent
 @endif
@endsection