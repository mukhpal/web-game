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

        <form name="edit_page_frm" id="edit_page_frm" method="post" action="{{ route('admin.update_page', [ base64_encode( $page->page_key ) ] ) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
              

                <fieldset>
                  <legend>Page Title</legend>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                        <input class="form-control" type="text" id="title" value="{{ old('title', ( isset( $page->page_title )?$page->page_title:'' )) }}" maxlength="150" placeholder="e.g. Home" name="title" required />
                        {!! $errors->first('title', '<p class="validation-errors">:message</p>') !!}
                      </div>
                    </div>
                  </div>
                </fieldset>

                <fieldset>
                  <legend>Page Content</legend>

                  <div class="row d-flex justify-content-center">
                    @foreach( $page->pageContent as $pageContent )

                    <div class="col-md-11 mb-3 border pt-2">
                      
                      @if( !isset( $sectionVisible[ $pageContent->pc_section_id ] ) || ( isset( $sectionVisible[ $pageContent->pc_section_id ] ) && @in_array( 'title', $sectionVisible[ $pageContent->pc_section_id ] ) ) )
                      <div class="form-group {{ $errors->has( 'content.' . $pageContent->pc_section_id . '.title' ) ? 'has-error' : ''}}">
                        <label class="control-label" for="{{ $pageContent->pc_section_id }}_title">Section Title</label>
                        <input class="form-control" type="text" id="{{ $pageContent->pc_section_id }}_title" value="{{ old( 'content.' . $pageContent->pc_section_id . '.title', $pageContent->pc_title ) }}" maxlength="100" placeholder="e.g. Let's Connect" name="content[{{ $pageContent->pc_section_id }}][title]" />
                        {!! $errors->first( 'content.' . $pageContent->pc_section_id . '.title', '<p class="validation-errors">:message</p>') !!}
                      </div>
                      @endif

                      @if( !isset( $sectionVisible[ $pageContent->pc_section_id ] ) || ( isset( $sectionVisible[ $pageContent->pc_section_id ] ) && @in_array( 'desc', $sectionVisible[ $pageContent->pc_section_id ] ) ) )
                      <div class="form-group">
                        <label class="control-label">Section Description</label>
                        <textarea class="form-control" id="{{ $pageContent->pc_section_id }}_desc" placeholder="e.g. Lorem ipsum dolor sit amet" name="content[{{ $pageContent->pc_section_id }}][desc]">{{ old( 'content.' . $pageContent->pc_section_id . '.desc', $pageContent->pc_description ) }}</textarea>
                      </div>
                      @endif

                      @if( !isset( $sectionVisible[ $pageContent->pc_section_id ] ) || ( isset( $sectionVisible[ $pageContent->pc_section_id ] ) && @in_array( 'image', $sectionVisible[ $pageContent->pc_section_id ] ) ) )
                      <div class="form-group {{ $errors->has( 'content.' . $pageContent->pc_section_id . '.image' ) ? 'has-error' : ''}}">
                        <label class="control-label" for="{{ $pageContent->pc_section_id }}_image">Section Image</label>
                        <input type="file" class="form-control" id="{{ $pageContent->pc_section_id }}_image" name="content[{{ $pageContent->pc_section_id }}][image]">{{ old( 'content.' . $pageContent->pc_section_id . '.image', $pageContent->pc_image ) }}
                        {!! $errors->first(  'content.' . $pageContent->pc_section_id . '.image', '<p class="validation-errors">:message</p>') !!}
                      </div>
                      @endif

                    </div>

                    @endforeach
                  </div>
                </fieldset>

                <fieldset>
                  <legend>SEO</legend>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : ''}}">
                        <label class="control-label">Meta Title</label>
                        <input class="form-control" type="text" id="meta_title" value="{{ old('meta_title', ( isset( $page->page_meta_title )?$page->page_meta_title:'' )) }}" maxlength="150" placeholder="e.g. Home" name="meta_title" />
                        {!! $errors->first('meta_title', '<p class="validation-errors">:message</p>') !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Meta Keywords</label>
                        <input class="form-control" type="text" id="meta_keywords" value="{{ old('meta_keywords', ( isset( $page->page_meta_keywords )?$page->page_meta_keywords:'' )) }}" placeholder="e.g. Keyword1, Keyword2..." name="meta_keywords" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label" for="meta_desc">Meta Description</label>
                        <textarea class="form-control" placeholder="e.g. Lorem ipsum dolor sit amet" name="meta_desc" id="meta_desc">{{ old( 'meta_desc', $page->page_meta_desc ) }}</textarea>
                      </div>
                    </div>
                  </div>
                </fieldset>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.pages') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>
        </form>

      </div>
        
      <div class="clearix"></div>
        
    </div>


  </main>
  <!-- /.content-wrapper -->
@endsection