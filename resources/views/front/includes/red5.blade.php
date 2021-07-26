<script src="//webrtchacks.github.io/adapter/adapter-latest.js"></script>
<script src="{{ asset('assets/red5/lib/screenfull/screenfull.min.js') }}"></script>
<script src="{{ asset('assets/red5/script/testbed-config.js') }}"></script>
<script src="{{ asset('assets/red5/script/red5pro-utils.js') }}"></script>
<script src="{{ asset('assets/red5/script/reachability.js') }}"></script>
<script src="{{ asset('assets/red5/script/subscription-status.js') }}"></script>
<script src="{{ asset('assets/red5/script/publisher-status.js') }}"></script>
<script src="{{ asset('assets/red5/lib/es6/es6-promise.min.js') }}"></script>
<script src="{{ asset('assets/red5/lib/es6/es6-bind.js') }}"></script>
<script src="{{ asset('assets/red5/lib/es6/es6-array.js') }}"></script>
<script src="{{ asset('assets/red5/lib/es6/es6-object-assign.js') }}"></script>
<script src="{{ asset('assets/red5/lib/es6/es6-fetch.js') }}"></script>
<script src="{{ asset('assets/red5/lib/red5pro/red5pro-sdk.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('assets/red5/css/reset.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/red5/css/testbed.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/red5/lib/red5pro/red5pro-media.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/red5/css/conference.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/red5/css/red5-custom.css') }}" />

<div class="video-wraps hidden col-md-12 joined_member text-center <?php if($bitt != 1 ) { echo ' mmrulscreen'; } ?>">
  <div class="members-streaming">
    <ul id="aw_joined_users" class="cab-add"></ul> 
  </div>
  <input type="checkbox" id="video-check" name="video-check" style="display:none;" checked />
  <input type="checkbox" id="audio-check" name="audio-check" style="display:none;" checked />
  <input type="hidden" id="streamname-field" name="streamname-field" />

</div>

<script>
  var roomName = 'vs_{{$channel_id}}';
  //var streamName = 'video_joinuser_{{$user_id}}__{{time()}}';
  var streamName = 'video_joinuser_{{$user_id}}';
  (function (window, document, red5pro) {

    var configuration = (function () {
    var conf = sessionStorage.getItem('r5proTestBed');
      try {
        return JSON.parse(conf);
      }
      catch (e) {
        console.error('Could not read testbed configuration from sessionstorage: ' + e.message);
      }
      return {}
    })();

    console.log('Settings:\r\n' + JSON.stringify(configuration, null, 2));

    function seal (config) {
      sessionStorage.setItem('r5proTestBed', JSON.stringify(config));
    }

    configuration.host = 'stream.officecampfire.com';
    console.warn( configuration );

    seal(configuration);

  })(this, document, window.red5prosk);
</script>
<script src="{{ asset('assets/red5/conference-subscriber.js') }}"></script>
<script src="{{ asset('assets/red5/device-selector-util.js') }}"></script>

<script src="{{ asset('assets/red5/index.js') }}"></script>