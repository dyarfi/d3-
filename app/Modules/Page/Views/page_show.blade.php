@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
    @if($row->name)
    <h4 class="red">Name</h4>
    <ul class="list-unstyled"><li>{{ $row->name }}</li></ul>
    @endif
    @if($row->slug)
    <h4 class="red">Slug</h4>
    <div class="row-fluid">
        {{ $row->slug }}
    </div>
    @endif
    @if($row->menu)
    <h4 class="red">Menu</h4>
    <div class="row-fluid">
        {{ $row->menu->name }}
    </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
    <div class="row-fluid" style="overflow-x:auto;overflow-y:auto">
        {!! $row->description !!}
    </div>
    @endif
    @if($row->address)
    <h4 class="red">Address</h4>
    <div class="row-fluid">
        {{ $row->address }}
    </div>
    @endif
    @if($row->about)    
    <h4 class="red">About</h4>
    <div class="row-fluid">
        {{ $row->about }}
    </div>
    @endif
    @if($row->status)
    <h4 class="red">Status</h4>
    <div class="row-fluid">
        {{ config('setting.status')[$row->status] }}
    </div>
    @endif
    @if($row->created_at)
    <h4 class="red">Created At</h4>
    <div class="row-fluid">
        {{ $row->created_at }}
    </div>
    @endif
    <hr/>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-info btn-xs">Back to all pages</a>
            <a href="{{ route('admin.pages.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Page</a>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-warning btn-xs">Create Page</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.pages.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this page?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
