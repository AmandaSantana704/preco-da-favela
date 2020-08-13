@extends('admin.layout.main')
@section('title', 'Suporte')
@section('contain')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              


                <div class="text-center mb-3">
                    <img src="{{asset('images/support.svg')}}" alt="" width="550">
                    <h2 class="mt-3">Ocorreu algum problema? Tem alguma dúvida?</h2>
                    <h3 class="mb-4">Entre em contato com o nosso suporte</h3>
                    <a class="btn btn-success btn-lg btn-rounded" href="https://api.whatsapp.com/send?phone=5571992547765&text=Bem-vindo%20ao%20suporte%20do%20Guia%2C%20ser%C3%A1%20um%20prazer%20ajudar." target="blank">
                    Fale pelo whatsapp
                    </a>
                </div>
                    


                    
                   
                    

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        activeHover('suporte', '#linkPanel', 'active', '#li-linkPanel', 'selected');
    </script>
@endsection