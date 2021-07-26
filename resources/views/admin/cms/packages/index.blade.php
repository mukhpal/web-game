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
          @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif

          <div class="tile">
            <div class="tile-body" id="pages-list">
              <div class="row">
                <div class="col-md-2">
                    <!--select class="form-control" name="select_action" id="action"-->
                    <select class="form-control" name="select_action" id="actionDropdown">
                      <option value="">Select Action</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option> 
                      <!--option value="1">Delete</option-->
                    </select>       
                </div>
                <!--div class="col-md-1 text-left"><button class="btn btn-primary" id="apply-action">Go</button></div-->
                <div class="col-md-1 text-left"><button class="btn btn-primary" id="goBtt">Go</button></div>
                <div class="col-md-9 text-right"><a class="btn btn-primary icon-btn" href="{{ route('admin.create_package')}}"><i class="fa fa-plus"></i>Add Package  </a></div>
              </div>
              <div class="clear">&nbsp;</div>
              <input type="hidden" id="setActiveInactiveUrl" url="{{ route('admin.setactiveinactive') }}" />
              <input type="hidden" id="data_model" value="packages" />
              {{ csrf_field() }}
              <div class="table-responsive">
              <table class="table table-hover table-bordered tbl-reorder" id="datatable">
                <thead>
                  <tr>
                    <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th>
                    <th>Package Name</th>
                    <th>Durations</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection

@push('after_scripts')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css" />

  <script src="{{ asset('assets/admin/js/cms.js') }}"></script>
  <script type="text/javascript">
      var importantObj = {
          listing_url: '{{ route( 'admin.packages_list' ) }}',
          delete_url: '{{ route( 'admin.delete_package' ) }}',
          update_reorder: '{{ route( 'admin.reorder_package' ) }}'
      };
  </script>
  <style>
    .table td:nth-child(2){cursor: grab;}
  </style>
  <script src="{{ asset('assets/admin/js/cms/packages/index.js') }}"></script>
@endpush