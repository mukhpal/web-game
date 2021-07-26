@extends('layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="email_frm" id="edit_email_frm" method="post" action="{{ route('admin.updateemail') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <input type="hidden" name="templateid" value="{{$template_detail['id']}}" />
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email Subject <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('subject')!='' ? old('subject') : $template_detail['subject'] }}" placeholder="Enter email subject" name="subject" />
                  {!! $errors->first('subject', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Template <span class="required-fields">*</span></label>
                  <textarea name="email_template" >{{ old('email_template')!='' ? old('email_template') : $template_detail['email_template'] }}</textarea>
                  {!! $errors->first('email_template', '<p class="validation-errors">:message</p>') !!}
                </div>

               
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.emailslist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection