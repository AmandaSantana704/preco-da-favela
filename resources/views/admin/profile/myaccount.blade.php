@extends('admin.layout.main')
@section('title', 'Minha conta')
@section('contain')

    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Seu plano atual</h3>
        <div class="d-flex align-items-center mb-3">
        </div>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               
                    <section class="row">
                        <div class="col-md-12" style="margin-top: 12px;">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                  <div class="text-center mb-3 cropped-profile" style="width: 150px; height:150px;">
                                      {{-- <img src="{{asset('images/users/'.$user->photo)}}" alt="user"> --}}
                                  </div>
                  
                                  <h3 class="profile-username text-center"></h3>
                                
                                  <p class="text-muted text-center mb-3"></p>
                                

                                  <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                      <b>Comércio:</b> <a class="float-right">asda</a>
                                    </li>
                                    <li class="list-group-item">
                                      <b>Atualização</b> <a class="float-right"></a>
                                    </li>
                                  </ul>
                  
                                  {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                                </div>
                                
                              </div>
                        </div>
                   
                    </section>

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        activeHover('minha-conta', '#linkPanel', 'active', '#li-linkPanel', 'selected');
    </script>
      @if($errors->any())
      @foreach($errors->all() as $error)
          @component('component.alert')
          {{$error}}
          @endcomponent
      @endforeach
  @endif
@endsection