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
            @if ($message = Session::get('custom_errors'))
                <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <form name="edit_package_frm" id="edit_package_frm" method="post" action="{{ route( 'admin.update_package', [ Hashids::encode( $package->id ) ] ) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="tile">
                    <div class="tile-body">
                    <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="control-label" for="name">Name<span class="required">*</span></label>
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                    <input class="form-control" type="text" id="question" value="{{ old( 'name', $package->name ) }}" placeholder="Enter Package Name" name="name" />
                                    {!! $errors->first('name', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for="durations">Durations<span class="required">*</span></label>
                                <div class="form-group {{ $errors->has('durations') ? 'has-error' : ''}}">
                                    <select class="form-control" id="durations" value="{{ old( 'durations' ) }}" name="durations">
                                        <option value="">Select Durations</option>
                                        @foreach( $durations as $key => $duration )
                                            <option value="{{$key}}" {{ ( old( 'durations', $package->durations ) == $key?' selected': '' ) }}>{{$duration}}</option>
                                        @endforeach
                                    </select>

                                    {!! $errors->first('durations', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                       </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="control-label" for="price">Price<span class="required">*</span></label>
                                <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                    <input class="form-control price" type="text" id="price" value="{{ old( 'price', $package->price ) }}" placeholder="E.g 10.20" name="price" />
                                    {!! $errors->first('price', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has( 'image' ) ? 'has-error' : ''}}">
                                    <label class="control-label" for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">{{ old( 'image', $package->image ) }}
                                    {!! $errors->first(  'image', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="control-label" for="description">Description</label>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                    <textarea class="form-control" id="description" placeholder="Enter Packager Description" name="description">{{ old( 'description', $package->description ) }}</textarea>
                                    {!! $errors->first('description', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.packages') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearix"></div>
    </div>
</main>
  <!-- /.content-wrapper -->
@endsection

@push('after_scripts')
  <script src="{{ asset('assets/admin/js/cms.js') }}"></script>
  <script type="text/javascript">
      var importantObj = {
          listing_url: '{{ route( 'admin.packages_list' ) }}',
          delete_url: '{{ route( 'admin.delete_package' ) }}',
          update_reorder: '{{ route( 'admin.reorder_package' ) }}'
      };
  </script>
  <script src="{{ asset('assets/admin/js/cms/packages/edit.js') }}"></script>
@endpush