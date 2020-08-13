@extends('admin.layout.main')
@section('title', 'Planos')
@section('contain')

    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Lista de planos</h3>
        <div class="d-flex align-items-center">
        </div>
        <a href="{{route('commerce.register')}}" class="btn btn-primary">Novo plano</a>
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
                                <th>Criação</th>
                                <th>Atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($plans as $plan)
                            <tr>
                               <td>{{$plan->id}}</td>
                               <td>{{$plan->display_name}}</td>
                               <td>{{date('d/m/Y H:i:s', strtotime($plan->created_at))}}</td>
                               <td>{{$plan->updated_at === null ? '--- ' : date('d/m/Y H:i:s', strtotime($plan->updated_at))}}</td>
                               <td>
                                   <a href="#" class="btn btn-primary">Editar</a>
                                   <a href="#" class="btn btn-success">Gerenciar</a>
                                   <a href="#" class="btn btn-danger">Excluir</a>
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