@extends('admin.layouts.admin')
@section('content')

	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <h3>Email Template Content Management</h3>

          <ul>
            <li><a href="{{route('admin.callouts')}}">Manage team building event template callouts</a></li>
          </ul>
          
        </div>
      </div>
    </main>

 <!-- /.content-wrapper -->
@endsection
