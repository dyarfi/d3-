@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Client' : 'Update Client' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.clients.create' : ['admin.clients.update', $row->id],
	'files' => true
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $row->name),[
			'placeholder'=>'Enter the Client Name.',
			'name'=>'name',
			'id'=>'name',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description'); !!}
		{!! Form::textarea('description',Input::old('description', $row->description),[
			'placeholder'=>'Enter the Client Description.',
			'name'=>'description',
			'id'=>'description',
			'class'=>'form-control ckeditor']); !!}
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('image', ' has-error') }}">
		{!! Form::label('image', 'Client Image:'); !!}
		@if ($row->image)
			{!! Form::label('image', ($row->image) ? 'Replace Image ?' : 'Client Image:', ['class' => 'control-label center-block ace-file-input']) !!}
			<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt" style="max-width:300px"/>
			<div class="clearfix space-6"></div>
		@endif
		<div class="row">
			<div class="col-xs-6">
				<label class="ace-file-input">
					{!! Form::file('image','',['class'=>'form-controls','id'=>'id-input-file-2']) !!}
					<span class="ace-file-container" data-title="Choose">
						<span class="ace-file-name" data-title="No File ...">
							<i class=" ace-icon fa fa-upload"></i>
						</span>
					</span>
				</label>
			</div>
		</div>
		<span class="help-block red">{{{ $errors->first('image', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('index', ' has-error') }}">
		{!! Form::label('index', 'Index'); !!}
		{!! Form::text('index',($row->index ? Input::old('index', $row->index) : $model->max('index') + 1),[
			'placeholder'=>'Enter the Client Index.',
			'name'=>'index',
			'id'=>'index',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('index', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('status', ' has-error') }}">
		<label for="status">Status</label>
		<select id="status" name="status" class="form-control input-sm">
			<option value="">&nbsp;</option>
			@foreach (config('setting.status') as $config => $val)
				<option value="{{ $config ? $config : Input::old('status', $row->status) }}" {{ $config == $row->status ? 'selected' : '' }}>{{$val}}</option>
			@endforeach
		</select>
		<span class="help-block">{{{ $errors->first('status', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
