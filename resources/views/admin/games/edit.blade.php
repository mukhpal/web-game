@extends('admin.layouts.admin')
@section('content')
  
  <main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="crop_frm" id="edit_game_frm" method="post" action="{{route('admin.update_game', [ 'key'=> Hashids::encode( $data['id'] ) ] ) }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <input type="hidden" name="id" id="game_id" value="{{$data['id']}}" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
              <label class="control-label">Game Name <span class="required-fields">*</span></label>
              <input class="form-control" type="text" value="{{ old('name')!='' ? old('name') : $data['name'] }}" placeholder="e.g. Quanby Ltd" name="name" />
              {!! $errors->first('name', '<p class="validation-errors">:message</p>') !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                  <label class="control-label">Select Game Type <span class="required-fields">*</span></label>
                  <select name="game_type" class="form-control" required="required">
                      <option {{ $data['game_type'] == 0 ? 'selected' : '' }} value="0">Introductory</option>
                      <option {{ $data['game_type'] == 1 ? 'selected' : '' }} value="1">Main Game</option>
                  </select>
                  {!! $errors->first('game_type', '<p class="validation-errors">:message</p>') !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                <label class="control-label">Price $<!-- <span class="required-fields">*</span> --></label>
                <input class="form-control" type="number" step="0.01" value="{{ old('price')!='' ? old('price') : $data['price'] }}" placeholder="e.g. $12" name="price" />
                {!! $errors->first('price', '<p class="validation-errors">:message</p>') !!}
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group {{ $errors->has('link') ? 'has-error' : ''}}">
              <label class="control-label">Tutorials Link <!-- <span class="required-fields">*</span> --></label>
              <input class="form-control" type="text" value="{{ old('link')!='' ? old('link') : $data['link'] }}" placeholder="e.g. https//" name="link" />
              {!! $errors->first('link', '<p class="validation-errors">:message</p>') !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
              <label class="control-label">Description </label>
              <textarea placeholder="Enter description" class="form-control" rows="5" name="description" >{{ old('description')!='' ? old('description') : $data['description'] }}</textarea>
              {!! $errors->first('description', '<p class="validation-errors">:message</p>') !!}
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