<div class="container-fluid">
  @if ($errors->any())
    <div class="space-6"></div>
    <div class="col-lg-12">
      <div class="alert alert-danger alert-block" role="alert">
        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
        <!--strong>Error</strong-->
        @if ($message = $errors->first(0, ':message'))
        {{ $message }}
        @else
        Please check the form below for errors
        @endif
      </div>
    </div>
    <div class="space-6"></div>
  @endif

    <div class="col-lg-12">
        <div class="space-6"></div>
        @include('Admin::partials.alerts.success')
        <div class="space-6"></div>
    </div>

  @if ($message = Session::get('success'))
  <div class="space-6"></div>
    <div class="col-lg-12">
      <div class="alert alert-block alert-success alert-block" role="alert">
        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
        <strong>Success :</strong> {{ $message }}
      </div>
    </div>
  <div class="space-6"></div>
  @endif

  @if ($message = Session::get('error'))
  <div class="space-6"></div>
    <div class="col-lg-12">
      <div class="alert alert-block alert-warning alert-block" role="alert">
        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
        <strong>Error :</strong> {{ $message }}
      </div>
    </div>
  <div class="space-6"></div>
  @endif

  @if ($message = @$csrf_error)
  <div class="space-6"></div>
    <div class="col-lg-12">
      <div class="alert alert-block alert-danger alert-block" role="alert">
        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
        <strong>Error :</strong> {{ $message }}
      </div>
    </div>
  <div class="space-6"></div>
  @endif
</div>
