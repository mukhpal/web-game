@extends('admin.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="crop_frm" id="add_crop_frm" method="post" action="{{ route('admin.savecrop') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <div class="row">
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
						  <label class="control-label">Crop Name <span class="required-fields">*</span></label>
						  <input class="form-control" type="text" value="{{ old('name') }}" placeholder="e.g. Quanby Ltd" name="name" />
						  {!! $errors->first('name', '<p class="validation-errors">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
						  <label class="control-label">Crop For Round <span class="required-fields">*</span></label>
						  <input class="form-control" type="text" value="{{ old('round') }}" placeholder="e.g. 2" name="round" />
						  {!! $errors->first('name', '<p class="validation-errors">:message</p>') !!}
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('cost') ? 'has-error' : ''}}">
						  <label class="control-label">Cost <span class="required-fields">(per lbs)*</span></label>
						  <input class="form-control" type="number" step="0.01" value="{{ old('cost') }}" placeholder="e.g. 5" name="cost" />
						  {!! $errors->first('cost', '<p class="validation-errors">:message</p>') !!}
						</div>
					</div>
				</div>
            </div>
			
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.cropslist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection
