@extends('layouts.master')

@section('content')

		<section id="page-title" class="page-title-parallax page-title-dark" style="background-image: url('{{ asset("uploads/".$menu->image) }}'); padding: 120px 0;" data-stellar-background-ratio="0.3">
			<div class="container clearfix">
				<h1>Job Openings</h1>
				<span>{{ $menu->description }} Join our Fabulous Team of Intelligent Individuals</span>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li class="active">{{ trans('label.career') }}</li>
				</ol>
			</div>
		</section>
		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<?php
					$i = 1;
					$c = count($careers);
					?>
					<div class="col_three_fifth nobottommargin" id="entry-listing">
						<div class="entry isotope-item">
							@if($c > 0)
								@foreach($careers as $career)
								<div class="fancy-title title-bottom-border">
									<h3>{{ $career->name }} <span class="pull-right"><i class="icon-ok"></i> {{ $career->end_date }}</span></h3>
								</div>
								<p>{{ str_limit($career->description, 500,' [...]')}}</p>
								<div class="accordion accordion-bg clearfix">
									@if ($career->requirement)
									<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Requirements</div>
									<div class="acc_content clearfix">
										{!! $career->requirement !!}
									</div>
									@endif
									@if ($career->responsibility)
									<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Responsibility</div>
									<div class="acc_content clearfix">
										{!! $career->responsibility !!}
									</div>
									@endif
									@if($career->facility)
									<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Facility</div>
									<div class="acc_content clearfix">
										{!! $career->facility !!}
									</div>
									@endif
								</div>
								<a href="#" data-scrollto="#job-apply" class="button button-3d button-black nomargin apply" data-rel="{!! $career->slug !!}">Apply Now</a>
								@if ($i != $c)
									<div class="divider divider-short"><i class="icon-star3"></i></div>
							 	@endif
								<?php $i++ ;?>
								@endforeach

							@else
								<h4>No vacancy at the moment</h4>
							@endif
						</div>
					</div>
					@if($c > 0)
					<div class="col_two_fifth nobottommargin col_last">
						<div id="job-apply" class="heading-block highlight-me">
							<h3>Apply Now</h3>
							<span>And we'll get back to you within 48 hours.</span>
						</div>
						<div class="contact-widget">
							@if (count($errors) > 0)
							<div class="contact-form-result"><span class="alert alert-danger help-block"><i class="icon-exclamation"></i> {{{ trans('label.check_form') }}}</span></div>
							@endif
							{!! Form::model($applicant,
								[
									'route' => ['career.post'],
									'class' => '',
									'name' => 'template-jobform',
									'method' => 'POST',
									'role' => 'form',
									'id' => 'template-jobform',
									'enctype' => 'multipart/form-data',
								])
							!!}
								<div class="form-process"></div>
								<div class="col_half{{ $errors->first('jobform_fname', ' has-error') }}">
									<label for="jobform_fname">First Name </label>
									<input type="text" id="jobform_fname" name="jobform_fname" value="{{{ Request::old('jobform_fname', $applicant->jobform_fname) }}}" class="sm-form-control required" />
									<span class="help-block">{{{ $errors->first('jobform_fname', ':message') }}}</span>
								</div>
								<div class="col_half col_last{{ $errors->first('jobform_lname', ' has-error') }}">
									<label for="jobform_lname">Last Name </label>
									<input type="text" id="jobform_lname" name="jobform_lname" value="{{{ Request::old('jobform_lname', $applicant->jobform_lname) }}}" class="sm-form-control required" />
									<span class="help-block">{{{ $errors->first('jobform_lname', ':message') }}}</span>
								</div>
								<div class="clear"></div>
								<div class="col_full{{ $errors->first('jobform_email', ' has-error') }}">
									<label for="jobform_email">Email </label>
									<input type="email" id="jobform_email" name="jobform_email" value="{{{ Request::old('jobform_email', $applicant->jobform_email) }}}" class="required email sm-form-control" />
									<span class="help-block">{{{ $errors->first('jobform_email', ':message') }}}</span>
								</div>
								<div class="col_half">
									<label for="jobform_phone{{ $errors->first('jobform_phone', ' has-error') }}">Phone </label>
									<input type="text" id="jobform_phone" name="jobform_phone" value="{{{ Request::old('jobform_phone', $applicant->jobform_phone) }}}" class="required sm-form-control" />
									<span class="help-block">{{{ $errors->first('jobform_phone', ':message') }}}</span>
								</div>
								<div class="col_half col_last{{ $errors->first('jobform_birthdate', ' has-error') }}">
									<label for="jobform_birthdate">Birthdate </label>
									<input type="text" name="jobform_birthdate" id="jobform_birthdate" value="{{{ Request::old('jobform_birthdate', $applicant->jobform_birthdate) }}}" size="22" tabindex="4" class="sm-form-control required" placeholder="yyyy-mm-dd"/>
									<span class="help-block">{{{ $errors->first('jobform_birthdate', ':message') }}}</span>
								</div>
								<div class="clear"></div>
								<div class="col_full{{ $errors->first('jobform_position', ' has-error') }}">
									<label for="jobform_position">Position </label>
									<select name="jobform_position" id="jobform_position" tabindex="9" class="sm-form-control required">
										<option value="">-- Select Position --</option>
										@foreach($career_list as $list)
										<option value="{{ $list->slug }}" {{ Request::old('jobform_position') == $list->slug ? 'selected' : '' }}>{{ $list->name }}</option>
										@endforeach
									</select>
									<span class="help-block">{{{ $errors->first('jobform_position', ':message') }}}</span>
								</div>
								<div class="col_half{{ $errors->first('jobform_salary', ' has-error') }}">
									<label for="jobform_salary">Expected Salary </label>
									<input type="text" name="jobform_salary" id="jobform_salary" value="{{{ Request::old('jobform_salary', $applicant->jobform_salary) }}}" size="22" tabindex="6" class="sm-form-control" />
									<span class="help-block">{{{ $errors->first('jobform_salary', ':message') }}}</span>
								</div>
								<div class="col_half col_last{{ $errors->first('jobform_start', ' has-error') }}">
									<label for="jobform_time">Start Date </label>
									<input type="text" name="jobform_start" id="jobform_start" value="{{{ Request::old('jobform_start', $applicant->jobform_start) }}}" size="22" tabindex="7" class="sm-form-control" placeholder="yyyy-mm-dd" />
									<span class="help-block">{{{ $errors->first('jobform_start', ':message') }}}</span>
								</div>
								<div class="clear"></div>
								<div class="col_full{{ $errors->first('jobform_website', ' has-error') }}">
									<label for="jobform_website">Website / Blog (if any) </label>
									<input type="text" name="jobform_website" id="jobform_website" value="{{{ Request::old('jobform_website', $applicant->jobform_website) }}}" size="22" tabindex="8" class="sm-form-control" placeholder="http:// or https://" />
									<span class="help-block">{{{ $errors->first('jobform_website', ':message') }}}</span>
								</div>
								<div class="col_full{{ $errors->first('jobform_experience', ' has-error') }}">
									<label for="jobform_experience">Experience (optional) </label>
									<textarea name="jobform_experience" id="jobform_experience" rows="3" tabindex="10" class="sm-form-control">{{{ Request::old('jobform_experience', $applicant->jobform_experience) }}}</textarea>
									<span class="help-block">{{{ $errors->first('jobform_experience', ':message') }}}</span>
								</div>
								<div class="col_full{{ $errors->first('jobform_application', ' has-error') }}">
									<label for="jobform_application">Application </label>
									<textarea name="jobform_application" id="jobform_application" rows="6" tabindex="11" class="sm-form-control required">{{{ Request::old('jobform_application', $applicant->jobform_application) }}}</textarea>
									<span class="help-block">{{{ $errors->first('jobform_application', ':message') }}}</span>
								</div>
								<div class="col_full{{ $errors->first('jobform_cv', ' has-error') }}">
									<label for="jobform_cv">CV (600KB max)</label>
									<input type="file" name="jobform_cv" id="jobform_cv" tabindex="12" class="sm-form-control" value="{{{ Request::old('jobform_cv', $applicant->jobform_cv) }}}">
									<!--{!! Form::file('jobform_cv', Request::old('jobform_cv', $applicant->jobform_cv),['id'=>'jobform_cv','tabindex'=>'12','class'=>'sm-form-control']) !!}-->
									<span class="help-block">
										{{{ $errors->first('jobform_cv', ':message') }}}
										@if ($errors->first('jobform_cv') == '' && count($errors) > 0)
										<span class="text-danger">Please re-upload your file.</span>
										@endif
									</span>
								</div>
								<div class="col_full hidden">
									<input type="text" id="jobform_botcheck" name="jobform_botcheck" value="" class="sm-form-control" />
								</div>
								<div class="form-group{{ $errors->first('g-recaptcha-response', ' has-error') }}">
									{!! Form::label('captcha', 'Captcha', ['class'=>'control-label']); !!}
									{!! app('captcha')->display(); !!}
									<span class="help-block">{{{ $errors->first('g-recaptcha-response', ':message') }}}</span>
								</div>
								<div class="col_full">
									<button class="button button-3d button-large btn-block nomargin" name="jobform_apply" type="submit" value="apply">Send Application</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
					@endif
				</div>
				{!! $careers->render() !!}
			</div>
		</section>

<!--h1>{{ trans('label.career') }} List</h1>
<p class="lead">Welcome to our {{ $menu->description }}<br/>Here's a list of all our career.</p>
<hr-->
<!--div id="entry-listing" class="container-fluid">
	@if($careers->count())
		@foreach($careers as $career)
		<div class="entry isotope-item">
		    <h3>{{ $career->name }} </h3>
		    <small><span class="fa fa-check"></span> {{ $career->created_at }}</small> -
		    <small><span class="fa fa-lock"></span> {{ $career->end_date }}</small>
		    <p>{{ str_limit($career->description, 400,' [...]')}}</p>
		    <p>
		        <a href="{{-- route('career.show', $career->slug) --}}" class="btn btn-info btn-xs"><span class="fa fa-search"></span> View Career</a>
		        <a href="{{-- route('career.apply', $career->slug) --}}" class="btn btn-primary btn-xs"><span class="fa fa-upload"></span> Apply Career</a>
		    </p>
		    <hr>
		</div>
		@endforeach
	@else
		{!! '<h4>Not Available at the Moment</h4>' !!}
	@endif
</div-->
<!-- {!! $careers->render() !!} -->
@stop
