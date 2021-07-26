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

            <form name="add_faq_frm" id="add_faq_frm" method="post" action="{{ route( 'admin.add_faq' ) }}">
                {{ csrf_field() }}
                <div class="tile">
                    <div class="tile-body">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="control-label" for="question">Question?</label>
                                <div class="form-group {{ $errors->has('question') ? 'has-error' : ''}}">
                                    <input class="form-control" type="text" id="question" value="{{ old( 'question' ) }}" placeholder="e.g. How to play?" name="question" required />
                                    {!! $errors->first('question', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="control-label" for="answer">Answer</label>
                                <div class="form-group {{ $errors->has('answer') ? 'has-error' : ''}}">
                                    <textarea class="form-control" id="answer" placeholder="e.g. Explain Process..." name="answer" required >{{ old( 'answer' ) }}</textarea>
                                    {!! $errors->first('answer', '<p class="validation-errors">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.faqs') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearix"></div>
    </div>
</main>
  <!-- /.content-wrapper -->
@endsection