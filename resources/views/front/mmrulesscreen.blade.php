@extends('front.layouts.default')
@section('content')

  <script>
    var mmurl = "{{ Config::get("constants.mm_url").'?enc='.$encryptedId }}";
    // window.location.href = mmurl;
  </script>
@stop