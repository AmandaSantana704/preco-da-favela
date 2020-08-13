@extends('admin.layout.main')
@section('title', 'Seções')
@section('contain')

    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Lista de seções</h3>
        <p>Os produtos são dividos por seções, você precisará criar uma seção para cadastrar os seus produtos. <br>
            <span style="color:#5f76e8;">Para visualizar os produtos, clique em uma seção.</span>
        </p>
        <div class="d-flex align-items-center">
        </div>
        <a href="{{route('session.register')}}" class="btn btn-success mb-5 btn-rounded">Nova seção</a>
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
                                <th>Comércio</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($sessions as $session)
                            @if($session->is_deleted === null)
                            <tr>
                              <td>{{$session->id}}</td>
                              <td><a href="{{route('panel.product', ['id'=>$session->id])}}">{{$session->name}}</a></td>
                              <td>{{$session->commerce_name}}</td>
                              <td>
                                  <a href="{{route('product.register', ['id'=>$session->id])}}" class="btn btn-success text-white btn-circle-lg font-20">+</a>
                                  <a class="btn btn-primary text-white btn-circle-lg" href="{{route('session.edit', ['id'=>$session->id])}}"><i class="fas fa-pencil-alt"></i></a>
                                  <a class="btn btn-light btn-circle-lg btDelSession" href="{{route('session.delete', ['id'=>$session->id])}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"></i></a>
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
        delAction('btDelSession', 'Deletar seção', 'Tem certeza que deseja deletar essa seção?');
        limit('limitNameCommerce', 12, 2);
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

  @if(session('limit'))
     @component('component.alert')
         {{session('limit')}}
     @endcomponent
  @endif
@endsection