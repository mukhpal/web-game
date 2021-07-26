@extends('admin.layouts.admin')
@section('content')
  
  <main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif
          
        </div>
        <div class="col-md-12">
          <form name="crop_frm" id="edit_game_frm" method="post" action="{{route('admin.update_callout') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group {{ $errors->has('callouts_heading') ? 'has-error' : ''}}">
              <label class="control-label">Callout Heading </label>
              <textarea placeholder="Enter callout heading.." class="form-control" rows="3" name="callouts_heading" >{{ old('callouts_heading')!='' ? old('callouts_heading') : $callouts_heading }}</textarea>
              {!! $errors->first('callouts_heading', '<p class="validation-errors">:message</p>') !!}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group {{ $errors->has('callouts') ? 'has-error' : ''}}">
              <label class="control-label">First Callout </label>
              <textarea placeholder="Enter first callout details.." class="form-control" rows="3" name="callouts" >{{ old('callouts')!='' ? old('callouts') : $callouts }}</textarea>
              {!! $errors->first('callouts', '<p class="validation-errors">:message</p>') !!}
            </div>
          </div>
        </div>

            </div>
      
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.games') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection