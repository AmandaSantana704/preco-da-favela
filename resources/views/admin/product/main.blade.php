@extends('admin.layout.main')
@section('title', 'Produtos')
@section('contain')

    <div class="col-12 align-self-center">
        <h3 class="page-title text-dark font-weight-medium mb-1">Lista de produtos</h3>
        <div class="d-flex align-items-center">
        </div>
        <p>Veja abaixo todos os produtos cadastrados nessa seção</p>
        <a href="{{route('product.register', ['id'=>$id_session])}}" class="btn btn-success mb-5 btn-rounded">Novo produto</a>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                

                 <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$count}}</h2>
                                    <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
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
                 
                <div class="table-responsive">
                    <table id="multi_col_order"
                        class="table table-striped table-bordered display no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Oferta</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($products as $product)
                            @if($product->is_deleted === null)
                            <tr>
                              <td>
                                <div class="mr-3"><img src="{{asset('images/product/'.$product->img)}}" alt="user" class="rounded-circle" width="45" height="45"></div>
                              </td>
                              <td>{{$product->id}}</td>
                              <td>{{$product->name}}</td>
                              <td>{{$product->category_name}}</td>
                              <td>R$ {{str_replace('.', ',', $product->price)}}</td>
                              <td>{{$product->offer === null ? '---' : 'R$ '.str_replace('.', ',', $product->offer)}}</td>
                              <td>
                                <a class="btn btn-primary text-white btn-circle-lg" href="{{route('product.edit', ['id'=>$product->id])}}"><i class="fas fa-pencil-alt"></i></a>
                                <form class="d-inline formDelete" action="{{route('product.delete', ['id'=>$product->id])}}" method="POST" data-toggle="modal" data-target="#exampleModal">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="sessionId" value="{{$id_session}}">
                                    <button class="btn btn-light btn-circle-lg btDelProduct"><i class="fa fa-times"></i></button>
                                </form>
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
        delActionForm('formDelete', 'Deletar produto', 'Tem certeza que deseja deletar esse produto?');
        limit('limitNameCommerce', 12, 2);
        activeHover('produto', '#linkProduct', 'active', '#li-linkProduct', 'selected');
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