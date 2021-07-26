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
              <div class="clear">&nbsp;</div>
              <div class="table-responsive">
              <table class="table table-hover table-bordered tbl-reorder" id="datatable">
                <thead>
                  <tr>
                    <th class="cms_manage">Sr.</th>
                    <th>Page Title</th>
                    <th class="cms_manage">Action</th>
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
  <script src="{{ asset('assets/admin/js/cms.js') }}"></script>
  <script type="text/javascript">
      var pageDataObj = {
          listing_url: '{{ route( 'admin.pages_list' ) }}', 
          orderable: { orderable: false, targets: [ 0, 2 ] },
          order: [ 1, "desc" ]
      };
	</script>
  <script src="{{ asset('assets/admin/js/cms/pages/index.js') }}"></script>
@endpush