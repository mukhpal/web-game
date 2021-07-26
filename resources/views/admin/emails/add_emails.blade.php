@extends('layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="email_frm" id="add_email_frm" method="post" action="{{ route('admin.saveemail') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
              
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email Subject <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('subject') }}" placeholder="Enter email subject" name="subject" />
                  {!! $errors->first('subject', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Template <span class="required-fields">*</span></label>
                  <textarea name="email_template" >{{ old('email_template') }}</textarea>
                  {!! $errors->first('email_template', '<p class="validation-errors">:message</p>') !!}
                </div>
                            
              
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.emailslist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection
