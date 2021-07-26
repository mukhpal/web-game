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

        <form name="edit_page_frm" id="edit_page_frm" method="post" action="{{ route('admin.update_cc' ) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
              
                @foreach( $sections as $fields )
                  @php 
                    $name = $fields[ 'name' ];
                    unset($fields[ 'name' ]);
                  @endphp
                  <fieldset>
                      <legend>{{$name}}</legend>
                      @foreach( $fields as $fieldName => $fieldData )
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="control-label" for="{{ $fieldName }}">{{$fieldData[ 'label' ]}}</label>

                              @if( in_array( $fieldData[ 'type' ], [ 'text', 'url', 'email' ] ) )
                                <input class="form-control" type="{{$fieldData[ 'type' ]}}" id="{{$fieldName}}" value="{{ old( $fieldName, ( isset( $confs[$fieldName] )?$confs[$fieldName]:'' )) }}" placeholder="{{$fieldData[ 'placeholder' ]}}" name="{{$fieldName}}" />
                              @elseif( $fieldData[ 'type' ] == 'multiple_select' )
                                <select class="form-control" id="{{$fieldName}}" name="{{$fieldName}}[]" multiple>
                                  <option disabled="disabled">Select Countries</option>
                                  @foreach( $fieldData[ 'options' ] as $short => $option )
                                    <option value="{{$short}}" @if( in_array( $short, old( $fieldName, ( isset( $confs[$fieldName] ) && is_array( $confs[$fieldName] )?$confs[$fieldName]:[] )) ) ) selected @endif}>{{$option}}</option>
                                  @endforeach
                                </select>
                              @elseif( $fieldData[ 'type' ] == 'textarea' )
                                <textarea class="form-control" id="{{$fieldName}}" placeholder="{{$fieldData[ 'placeholder' ]}}" name="{{$fieldName}}">{{ old( $fieldName, ( isset( $confs[$fieldName] )?$confs[$fieldName]:'' )) }}</textarea>
                              @endif
                            </div>
                          </div>
                        </div>
                      @endforeach
                  </fieldset>
                @endforeach

            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
            </div>
          </div>
        </form>

      </div>
        
      <div class="clearix"></div>
        
    </div>


  </main>
  <!-- /.content-wrapper -->
@endsection