@extends('app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-primary" style="text-align: center;">Create order</h1>
    </div>
</div>

@if (session()->has('successful'))
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="alert alert-success"><strong>{{session()->get('successful')}}</strong></div>
      </div>
    </div>
@endif

<div class="row">
  <div class="col-md-6 col-md-offset-3">
      {!! Form::open() !!}
      {{ csrf_field() }}
      {!! Form::imageField('Image upload', 'image') !!}
      {!! Form::close() !!}



  </div>

  {{-- Show $request errors after back-end validation --}}
  <div class="col-md-6 col-md-offset-3">
      @if($errors->has())
          <div class="alert alert-danger fade in">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4>The following errors occurred</h4>
              <ul>
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
  </div>

</div>

@endsection
