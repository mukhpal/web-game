/*
Copyright © 2015 Infrared5, Inc. All rights reserved.

The accompanying code comprising examples for use solely in conjunction with Red5 Pro (the "Example Code") 
is  licensed  to  you  by  Infrared5  Inc.  in  consideration  of  your  agreement  to  the  following  
license terms  and  conditions.  Access,  use,  modification,  or  redistribution  of  the  accompanying  
code  constitutes your acceptance of the following license terms and conditions.

Permission is hereby granted, free of charge, to you to use the Example Code and associated documentation 
files (collectively, the "Software") without restriction, including without limitation the rights to use, 
copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit 
persons to whom the Software is furnished to do so, subject to the following conditions:

The Software shall be used solely in conjunction with Red5 Pro. Red5 Pro is licensed under a separate end 
user  license  agreement  (the  "EULA"),  which  must  be  executed  with  Infrared5,  Inc.   
An  example  of  the EULA can be found on our website at: https://account.red5pro.com/assets/LICENSE.txt.

The above copyright notice and this license shall be included in all copies or portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,  INCLUDING  BUT  
NOT  LIMITED  TO  THE  WARRANTIES  OF  MERCHANTABILITY, FITNESS  FOR  A  PARTICULAR  PURPOSE  AND  
NONINFRINGEMENT.   IN  NO  EVENT  SHALL INFRARED5, INC. BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
WHETHER IN  AN  ACTION  OF  CONTRACT,  TORT  OR  OTHERWISE,  ARISING  FROM,  OUT  OF  OR  IN CONNECTION 
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
var SharedObject =  false;
var so = undefined; // @see onPublishSuccess
var isPublishing = false;
var targetPublisher;
var shutdown = false;
var doPublishAuto = false;
var setFields = false;

var streamNameField = false;
var publisherVideo = false;
var audioCheck = false;
var videoCheck = false;
var joinButton = false;

var disableVideoWrap = false;
var enableVideoWrap = false;

var tried = 1;
var tryingPublishing = false;

var hasRegistered = false;
var streamsPropertyList = [];
var subscribersEl = false;

var makeUnique = false;

(function(window, document, red5prosdk) {
  'use strict';

  SharedObject = red5prosdk.Red5ProSharedObject;

  var serverSettings = (function() {
    var settings = sessionStorage.getItem('r5proServerSettings');
    try {
      return JSON.parse(settings);
    }
    catch (e) {
      console.error('Could not read server settings from sessionstorage: ' + e.message);
    }
    return {};
  })( );

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
  red5prosdk.setLogLevel(configuration.verboseLogging ? red5prosdk.LOG_LEVELS.TRACE : red5prosdk.LOG_LEVELS.WARN);

  var updateStatusFromEvent = window.red5proHandlePublisherEvent;
  var protocol = serverSettings.protocol;
  var isSecure = protocol == 'https';

  makeUnique = function (list) {
      var result = [];
      $.each(list, function(i, e) {
          if ($.inArray(e, result) == -1) result.push(e);
      });
      return result;
  };

  shutdown = function () { 
    disableVideoWrap( );
    function clearRefs () {
      if (targetPublisher) {
        targetPublisher.off('*', onPublisherEvent);
      }
      targetPublisher = undefined;
    }
    unpublish().then(clearRefs).catch(clearRefs);
    if ( bitrateTrackingTicket ) window.untrackBitrate(bitrateTrackingTicket);
  }
  window.addEventListener('beforeunload', shutdown);
  window.addEventListener('pagehide', shutdown);

  enableVideoWrap = function( ) { 
    $( '#' + streamName ).removeClass( 'hidden' );
    $( '#hide-image' ).addClass( 'hidden' );
    $( '#' + streamName ).closest( 'li' ).find( '.cap_video' ).removeClass( 'hidden' );
    joinButton.classList.add( 'active' );
  };

  disableVideoWrap = function( ) { 
    $( '#' + streamName ).addClass( 'hidden' );
    $( '#hide-image' ).removeClass( 'hidden' );
    $( '#' + streamName ).closest( 'li' ).find( '.cap_video' ).addClass( 'hidden' );
    joinButton.classList.remove( 'active' );
    if( targetPublisher.getMediaStream() ) { 
      targetPublisher.getMediaStream().getTracks().forEach(track => track.stop());
    }
  };

  setFields = function () {

    streamNameField = document.getElementById('streamname-field');
    publisherVideo = document.getElementById('red5pro-publisher');
    audioCheck = document.getElementById('audio-check');
    videoCheck = document.getElementById('video-check');
    joinButton = document.getElementById('join-button');
    subscribersEl = document.getElementById('subscribers');

    streamNameField.value = streamName;
    audioCheck.checked = configuration.useAudio;
    videoCheck.checked = configuration.useVideo;

    joinButton.addEventListener('click', function () {
        if( !this.classList.contains( 'active' ) ){
          enableVideoWrap( );
          videoCheck.checked = true;
          console.warn( 'Starting' );
          tried = 1;
          doPublishAuto( 1000 );
        } else { 
          disableVideoWrap( );
          videoCheck.checked = false;
          console.warn( 'Shutting Down' );
          shutdown( );
        }
    });

  };

  doPublishAuto = function( restartRightNow ){

    if( typeof restartRightNow == typeof undefined ) var restartRightNow = 3000;

    if( tryingPublishing && tried >= 6 ) { 
      return;
    }

    tryingPublishing = true;
    tried++;

    setTimeout(function(){ 
        
        hasRegistered = false;
        streamsPropertyList = [];

        if( targetPublisher ) { 
          doPublish(streamName);
        } else { 
          determinePublisher()
            .then(function (publisherImpl) {
              targetPublisher = publisherImpl;
              targetPublisher.on('*', onPublisherEvent);
              var $return = targetPublisher.preview();
              doPublish(streamName);
              return $return;
            })
            .catch(function (error) {
              onPublishFail(error);
             });
        }
      }, restartRightNow );
  }

  function updateMutedAudioOnPublisher () {
    if (targetPublisher && isPublishing) {
      if (audioCheck.checked) { 
        if (videoTrackClone) {
          var c = targetPublisher.getPeerConnection();
          var senders = c.getSenders();
          senders[0].replaceTrack(audioTrackClone);
          audioTrackClone = undefined;
        } else {
          targetPublisher.unmuteAudio();
        }
      } else { 
        targetPublisher.muteAudio(); 
      }
    }
  }

  var audioTrackClone;
  var videoTrackClone;
  function updateInitialMediaOnPublisher () {
    var t = setTimeout(function () {

      var audioTrack = targetPublisher.getMediaStream().getAudioTracks()[0];
      var videoTrack = targetPublisher.getMediaStream().getVideoTracks()[0];
      var connection = targetPublisher.getPeerConnection();
      if (!videoCheck.checked) {
        videoTrackClone = videoTrack.clone();
        connection.getSenders()[1].replaceTrack(null);
      }
      if (!audioCheck.checked) {
        audioTrackClone = audioTrack.clone();
        connection.getSenders()[0].replaceTrack(null);
      }
      clearTimeout(t);
    }, 2000); 
    // a bit of a hack. had to put a timeout to ensure the video track bits at least started flowing :/
  }

  function getSocketLocationFromProtocol () {
    return !isSecure
      ? {protocol: 'ws', port: serverSettings.wsport}
      : {protocol: 'wss', port: serverSettings.wssport};
  }

  var bitrateTrackingTicket;
  function onBitrateUpdate (bitrate, packetsSent) {
    /*statisticsField.innerText = 'Bitrate: ' + Math.floor(bitrate) + '. Packets Sent: ' + packetsSent + '.';*/
  }

  function onPublisherEvent (event) {
    console.log('[Red5ProPublisher] ' + event.type + '.');
    if (event.type === 'Publisher.Connection.Closed' ) { 
      disableVideoWrap( );
      videoCheck.checked = false;
      console.warn( 'Shutting Down' );
      shutdown( );
    } else if (event.type === 'WebSocket.Message.Unhandled') {
      console.log(event);
    } else if (event.type === red5prosdk.RTCPublisherEventTypes.MEDIA_STREAM_AVAILABLE) {
      window.allowMediaStreamSwap(targetPublisher, targetPublisher.getOptions().mediaConstraints, document.getElementById('red5pro-publisher'));
    }
    updateStatusFromEvent(event);
  }

  function onPublishFail (message) {
    isPublishing = false;
    tryingPublishing = false;
    var jsonError = typeof message === 'string' ? message : JSON.stringify(message, null, 2);

    if( typeof message !== 'string' && message && message.type && message.type == 'Timeout' ) { 
      console.warn( 'Restarting' );
      doPublishAuto( );
    } else { 
      disableVideoWrap( );
    }

    console.error('[Red5ProPublisher] :: Error in publishing - ' + jsonError);
    console.error( message );
  }

  function onPublishSuccess (publisher) {
    isPublishing = true;
    tryingPublishing = false;
    window.red5propublisher = publisher;
    console.log('[Red5ProPublisher] Publish Complete.');
    establishSharedObject(publisher, roomName, streamNameField.value);
    try {
      if( publisher.getPeerConnection() ) bitrateTrackingTicket = window.trackBitrate(publisher.getPeerConnection(), onBitrateUpdate, null, null, true);
      enableVideoWrap();
    }
    catch (e) {
      // no tracking for you!
    }
  }
  function onUnpublishFail (message) {
    isPublishing = false;
    console.error('[Red5ProPublisher] Unpublish Error :: ' + message);
  }

  function onUnpublishSuccess () {
    isPublishing = false;
    disableVideoWrap( );
    console.log('[Red5ProPublisher] Unpublish Complete.');
  }

  function getAuthenticationParams () {
    var auth = configuration.authentication;
    return auth && auth.enabled
      ? {
        connectionParams: {
          username: auth.username,
          password: auth.password
        }
      }
      : {};
  }

  function getUserMediaConfiguration () {
    return {
      mediaConstraints: {
        audio: configuration.useAudio ? configuration.mediaConstraints.audio : false,
        video: configuration.useVideo ? configuration.mediaConstraints.video : false
      }
    };
  }

  // Invoked from METHOD_UPDATE event on Shared Object instance.
  function messageTransmit (message) { // eslint-disable-line no-unused-vars
    /*soField.value = ['User "' + message.user + '": ' + message.message, soField.value].join('\n');*/
  }

  function establishSharedObject (publisher, roomName, streamName) {
    // Create new shared object.
    console.warn( publisher );
    so = new SharedObject(roomName, publisher)
    var soCallback = {
      messageTransmit: messageTransmit
    };
    so.on(red5prosdk.SharedObjectEventTypes.CONNECT_SUCCESS, function (event) { // eslint-disable-line no-unused-vars
      console.log('[Red5ProPublisher] SharedObject Connect.'); 
    });
    so.on(red5prosdk.SharedObjectEventTypes.CONNECT_FAILURE, function (event) { // eslint-disable-line no-unused-vars
      console.log('[Red5ProPublisher] SharedObject Fail.');
    });
    so.on(red5prosdk.SharedObjectEventTypes.PROPERTY_UPDATE, function (event) {
      console.log('[Red5ProPublisher] SharedObject Property Update.');
      console.log(JSON.stringify(event.data, null, 2));
      if (event.data.hasOwnProperty('streams')) { 
        var streams = event.data.streams.length > 0 ? event.data.streams.split(',') : [];
        if (!hasRegistered) {
          hasRegistered = true;
          so.setProperty('streams', streams.concat([streamName]).join(','));
        }
        streamsPropertyList = streams;
        processStreams(streamsPropertyList, streamName);
      }
      else if (!hasRegistered) {
        hasRegistered = true;
        streamsPropertyList = [streamName];
        so.setProperty('streams', streamName);
      }
    });
    so.on(red5prosdk.SharedObjectEventTypes.METHOD_UPDATE, function (event) {
      console.log('[Red5ProPublisher] SharedObject Method Update.');
      console.log(JSON.stringify(event.data, null, 2));
      soCallback[event.data.methodName].call(null, event.data.message);
    });
  }

  function determinePublisher () {

    var config = Object.assign({},
                      configuration,
                      {
                        streamMode: configuration.recordBroadcast ? 'record' : 'live'
                      },
                      getAuthenticationParams(),
                      getUserMediaConfiguration());

    var rtcConfig = Object.assign({}, config, {
                      protocol: getSocketLocationFromProtocol().protocol,
                      port: getSocketLocationFromProtocol().port,
                      bandwidth: {
                        video: 256
                      },
                      mediaConstraints: {
                        audio: true,
                        video: {
                          width: {
                            exact: 320
                          },
                          height: {
                            exact: 240
                          },
                          frameRate: {
                            exact: 15
                          }
                        }
                      },
                      streamName: streamName
                   });

    var publisher = new red5prosdk.RTCPublisher();
    return publisher.init(rtcConfig);

  }

  function doPublish (name) {
    targetPublisher.publish(name)
      .then(function () {
        onPublishSuccess(targetPublisher);
        updateInitialMediaOnPublisher();
      })
      .catch(function (error) {
        onPublishFail(error);
       });
  }

  function unpublish () { 
    if (so !== undefined)  {
      var name = streamName;
      var updateList = streamsPropertyList.filter(function (item) {
        return item !== name;
      });
      streamsPropertyList = updateList;
      try{ 
        so.setProperty('streams', updateList.join(','));
        so.close();
      } catch( e ){
        console.warn( e );
        console.warn( so );
      }
    }
    return new Promise(function (resolve, reject) {
      var publisher = targetPublisher;
      publisher.unpublish()
        .then(function () {
          onUnpublishSuccess();
          resolve();
        })
        .catch(function (error) {
          var jsonError = typeof error === 'string' ? error : JSON.stringify(error, 2, null);
          onUnpublishFail('Unmount Error ' + jsonError);
          reject(error);
        });
    });
  }

  function processStreams (streamlist, exclusion) {
    var nonPublishers = streamlist.filter(function (name) {
      return name !== exclusion;
    });
    var list = nonPublishers.filter(function (name, index, self) {
      return (index == self.indexOf(name)) &&
        !document.getElementById(window.getConferenceSubscriberElementId(name));
    });
    var subscribers = list.map(function (name, index) {
      return new window.ConferenceSubscriberItem(name, subscribersEl, index);
    });

    var i, length = subscribers.length - 1;
    var sub;
    for(i = 0; i < length; i++) {
      sub = subscribers[i];
      sub.next = subscribers[sub.index+1];
    }
    if (subscribers.length > 0) {
      var baseSubscriberConfig = Object.assign({},
                                  configuration,
                                  {
                                    protocol: getSocketLocationFromProtocol().protocol,
                                    port: getSocketLocationFromProtocol().port
                                  },
                                  getAuthenticationParams(),
                                  getUserMediaConfiguration());
      subscribers[0].execute(baseSubscriberConfig);
    }
  }

})(this, document, window.red5prosdk);