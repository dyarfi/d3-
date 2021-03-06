@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Images <span class="pull-right"><a href="{{ route('admin.images.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.images.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($rows->count())
<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		{!! Form::open(['route'=>'admin.images.change']) !!}
		<table id="dynamic-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
					<th class="col-lg-3">Participant</th>
					<th class="col-lg-2">File Name</th>
					<th class="col-lg-2">Status</th>
					<th class="col-lg-2">Created At</th>
					<th class="col-lg-6 col-xs-3">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
				<tr class="{{ $row->deleted_at ? ' bg-warning' :'' }}">
					<td class="center">
						<label class="pos-rel">
							<input type="checkbox" class="ace" name="check[]" id="check_<?php echo $row->id; ?>" value="{{ $row->id }}" />
							<span class="lbl"></span>
						</label>
					</td>
					<td>
						{{ $row->participant->username }}
						@if ($row->participant->email)
							{{ '('.$row->participant->email.')' }}
						@endif
					</td>
					<td class="ace-thumbnails">
						@if ($row->file_name)
							<a data-rel="colorbox" href="{{ asset('uploads/'.$row->file_name) }}"> <img src="{{ asset('uploads/'.$row->file_name) }}" class="img-responsive" alt="{{ $row->file_name }}"/> </a>
						@endif
					</td>
					<td>
						<span class="label label-{{ $row->status == 1 ? 'success' : 'warning'}} arrowed-in arrowed-in-right">
							<span class="fa fa-{{ $row->status == 1 ? 'flag' : 'exclamation-circle' }} fa-sm"></span>
							{{ config('setting.status')[$row->status] }}
		                </span>
					</td>
					<td>{{ $row->created_at }}</td>
					<td>
						<div class="btn-group">
							@if (!$row->deleted_at)
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.images.show', $row->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.images.edit', $row->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.images.trash', $row->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a-->
							@else
							<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.images.restored', $row->id)}}" class="btn btn-xs btn-primary tooltip-default">
								<i class="ace-icon fa fa-save bigger-120"></i>
							</a>
							<a title="Permanent Delete!" href="{{route('admin.images.delete', $row->id)}}" class="btn btn-xs btn-danger">
								<i class="ace-icon fa fa-trash bigger-120"></i>
							</a>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tr>
			    <td id="corner"><span class="glyphicon glyphicon-minus"></span></td>
			    <td colspan="8">
				<div id="selection" class="input-group">
				    <div class="form-group form-group-sm">
						<label class="col-xs-6 control-label small grey" for="select_action">Change status :</label>
						<div class="col-xs-6" id="select_action">
						<select id="select_action" class="form-control input-sm" name="select_action">
							<option value="">&nbsp;</option>
							@foreach (config('setting.status') as $config => $val)
								<option value="{{$config}}">{{$val}}</option>
							@endforeach
						</select>
						</div>
				      </div>
				 </div>
			    </td>
			</tr>
		</table>
		{!! Form::close() !!}
	</div>
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
