@extends('admin.layout.main')
@section('title', 'Comércio')
@section('contain')

    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Lista de comércios</h3>
        <p>Veja todos os comércios cadastrados</p>
        <div class="d-flex align-items-center">
        </div>
        <a href="{{route('commerce.register')}}" class="btn btn-success btn-rounded mb-5">Novo comércio</a>
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
                                <th>Categoria</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($commerces as $commerce)
                            @if($commerce->is_deleted === null)
                        <tr>
                            <td>{{$commerce->id}}</td>
                            <td class="limitNameCommerce">{{$commerce->name}}</td>
                            <td>{{$commerce->category_name}}</td>
                            <td>
                                <a href="{{route('commerce.update', ['id'=>$commerce->id])}}" class="btn btn-primary text-white btn-circle-lg"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{route('app.store', ['id'=>$commerce->id])}}" class="btn btn-success text-white btn-circle-lg" target="blank"><i class="fas fa-eye"></i></a>
                                @if($permission == 1)
                                <a href="{{route('commerce.manage', ['id'=>$commerce->id])}}" class="btn btn-danger text-white btn-circle-lg"><i class="fa fa-heart"></i></a>
                                @endif
                                @if($permission == 1 || $permission == 2)
                                <a href="{{route('commerce.delete', ['id'=>$commerce->id])}}" class="btn btn-light btn-circle-lg btDelCommerce" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"></i></a>
                                @endif
                            </td>
                        </tr>
                            @endif
                        @endforeach
                        
                    
                        </tbody>
                    </table>
                </div>
                 
                {{-- <div class="table-responsive">
                    <table id="multi_col_order"
                        class="table table-striped table-bordered display no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commerces as $commerce):
                                @if($commerce->is_deleted === null)
                            <tr>
                                <td>{{$commerce->id}}</td>
                                <td class="limitNameCommerce">{{$commerce->name}}</td>
                                <td>{{$commerce->category_name}}</td>
                                <td>
                                    <a href="{{route('commerce.update', ['id'=>$commerce->id])}}" class="btn btn-primary text-white btn-circle-lg"><i class="fas fa-pencil-alt"></i></a>
                                    @if($permission == 1 || $permission == 2)
                                    <a href="{{route('commerce.manage', ['id'=>$commerce->id])}}" class="btn btn-danger text-white btn-circle-lg"><i class="fa fa-heart"></i></a>
                                    <a href="{{route('commerce.delete', ['id'=>$commerce->id])}}" class="btn btn-light btn-circle-lg btDelCommerce" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                            </tr>
                                @endif
                            @endforeach
                            
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript">    
        delAction('btDelCommerce', 'Deletar comércio', 'Tem certeza que deseja deletar esse comércio?');
        limit('limitNameCommerce', 12, 3);
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
 @if(session('limit'))
    @component('component.alert')
        {{session('limit')}}
    @endcomponent
 @endif
@endsection