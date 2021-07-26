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
var saveSettings = false;
var updateMutedAudioOnPublisher = false;
var updateMutedVideoOnPublisher = false;
var updateInitialMediaOnPublisher = false;
var showVideoPoster = false;
var hideVideoPoster = false;
var getSocketLocationFromProtocol = false;
var onBitrateUpdate = false;
var onPublisherEvent = false;
var onPublishFail = false;
var onPublishSuccess = false;
var onUnpublishFail = false;
var onUnpublishSuccess = false;
var getAuthenticationParams = false;
var getUserMediaConfiguration = false;
var setPublishingUI = false;
var updatePublishingUIOnStreamCount = false;
var appendMessage = false;
var messageTransmit = false;
var establishSharedObject = false;
var doPublish = false;
var unpublish = false;
var shutdown = false;
var processStreams = false;

(function(window, document, red5prosdk) {
  'use strict';

  var SharedObject = red5prosdk.Red5ProSharedObject;
  var so = undefined; // @see onPublishSuccess
  var isPublishing = false;

  var serverSettings = (function() {
    var settings = sessionStorage.getItem('r5proServerSettings');
    try {
      return JSON.parse(settings);
    }
    catch (e) {
      console.error('Could not read server settings from sessionstorage: ' + e.message);
    }
    return {};
  })();

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

  var updateStatusFromEvent = window.red5proHandlePublisherEvent; // defined in src/template/partial/status-field-publisher.hbs

  var targetPublisher;
  var roomName = window.query('room') || 'red5pro'; // eslint-disable-line no-unused-vars
  //var streamName = window.query('streamName') || ['publisher', Math.floor(Math.random() * 0x10000).toString(16)].join('-');

  //var roomField = document.getElementById('room-field');
  //var publisherContainer = document.getElementById('publisher-container');
  //var publisherMuteControls = document.getElementById('publisher-mute-controls');
  //var publisherSession = document.getElementById('publisher-session');
  //var publisherNameField = document.getElementById('publisher-name-field');
 /* var streamNameField = false;
  var publisherVideo =false;
  var audioCheck = false;
  var videoCheck = false;
  var joinButton = false;*/
  //var statisticsField = document.getElementById('statistics-field');

  //roomField.value = roomName;
  
/*

window.addEventListener('load', (event) => {
    setTimeout(function(){ 
      
      streamNameField = document.getElementById('streamname-field');
  
      publisherVideo = document.getElementById('red5pro-publisher');
      audioCheck = document.getElementById('audio-check');
      videoCheck = document.getElementById('video-check');
      joinButton = document.getElementById('join-button');

      streamNameField.value = streamName;
      audioCheck.checked = configuration.useAudio;
      videoCheck.checked = configuration.useVideo;

      audioCheck.addEventListener('change', updateMutedAudioOnPublisher);
      /*videoCheck.addEventListener('change', updateMutedVideoOnPublisher);*/
      /*joinButton.addEventListener('click', function () {
          videoCheck.checked = ( !this.classList.contains( 'active' ) )?true:false;
          if( videoCheck.checked ) { 
            $( '#hide-image' ).removeClass( 'hidden' );
            $( '#hide-video' ).addClass( 'hidden' );
          } else { 
            $( '#hide-image' ).addClass( 'hidden' );
            $( '#hide-video' ).removeClass( 'hidden' );
          }
          updateMutedVideoOnPublisher();
      });

      saveSettings();
      doPublish(streamName);
      setPublishingUI(streamName);
    }, 6000);
});*/

  /*joinButton.addEventListener('click', function () {
      saveSettings();
      doPublish(streamName);
      setPublishingUI(streamName);
  });*/

  /*audioCheck.addEventListener('change', updateMutedAudioOnPublisher);
  videoCheck.addEventListener('change', updateMutedVideoOnPublisher);
  joinButton.addEventListener('click', function () {
      videoCheck.checked = ( !this.classList.contains( 'active' ) )?true:false;
      if( videoCheck.checked ) { 
        $( '#hide-image' ).removeClass( 'hidden' );
        $( '#hide-video' ).addClass( 'hidden' );
      } else { 
        $( '#hide-image' ).addClass( 'hidden' );
        $( '#hide-video' ).removeClass( 'hidden' );
      }
      updateMutedVideoOnPublisher();
  });*/

  //var soField = document.getElementById('so-field');

  var protocol = serverSettings.protocol;
  var isSecure = protocol == 'https';

  saveSettings = function () {
    console.log( iframeObj );
    streamName = streamNameField.value;
  }

  updateMutedAudioOnPublisher = function () {
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

  updateMutedVideoOnPublisher = function () {
    if (targetPublisher && isPublishing) {
      if (videoCheck.checked) {
        if (videoTrackClone) {
          var c = targetPublisher.getPeerConnection();
          var senders = c.getSenders();
          senders[1].replaceTrack(videoTrackClone);
          videoTrackClone = undefined;
        } else {
          targetPublisher.unmuteVideo();
        }
      } else { 
        targetPublisher.muteVideo(); 
      }
    }
    !videoCheck.checked && showVideoPoster();
    videoCheck.checked && hideVideoPoster();
  }

  var audioTrackClone;
  var videoTrackClone;
  updateInitialMediaOnPublisher = function () {
    var t = setTimeout(function () {
      // If we have requested no audio and/or no video in our initial broadcast,
      // wipe the track from the connection.
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

  showVideoPoster = function () {
    publisherVideo.classList.add('hidden');
  }

  hideVideoPoster = function () {
    publisherVideo.classList.remove('hidden');
  }

  getSocketLocationFromProtocol = function () {
    return !isSecure
      ? {protocol: 'ws', port: serverSettings.wsport}
      : {protocol: 'wss', port: serverSettings.wssport};
  }

  var bitrateTrackingTicket;
  onBitrateUpdate = function (bitrate, packetsSent) {
    //statisticsField.innerText = 'Bitrate: ' + Math.floor(bitrate) + '. Packets Sent: ' + packetsSent + '.';
  }

  onPublisherEvent = function (event) {
    //console.log('[Red5ProPublisher] ' + event.type + '.');
    if (event.type === 'WebSocket.Message.Unhandled') {
      //console.log(event);
    } else if (event.type === red5prosdk.RTCPublisherEventTypes.MEDIA_STREAM_AVAILABLE) {
      window.allowMediaStreamSwap(targetPublisher, targetPublisher.getOptions().mediaConstraints, document.getElementById('red5pro-publisher'));
    }
    updateStatusFromEvent(event);
  }
  onPublishFail = function (message) {
    isPublishing = false;
    console.error('[Red5ProPublisher] Publish Error :: ' + message);
  }
  onPublishSuccess = function (publisher) {
    isPublishing = true;
    window.red5propublisher = publisher;
    //console.log('[Red5ProPublisher] Publish Complete.');
    establishSharedObject(publisher, roomName, streamNameField.value);

    try {
      bitrateTrackingTicket = window.trackBitrate(publisher.getPeerConnection(), onBitrateUpdate, null, null, true);
    }
    catch (e) {
      // no tracking for you!
    }
  }
  onUnpublishFail = function  (message) {
    isPublishing = false;
    console.error('[Red5ProPublisher] Unpublish Error :: ' + message);
  }
  onUnpublishSuccess = function  () {
    isPublishing = false;
    //console.log('[Red5ProPublisher] Unpublish Complete.');
  }

  getAuthenticationParams = function () {
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

  getUserMediaConfiguration = function () {
    return {
      mediaConstraints: {
        audio: configuration.useAudio ? configuration.mediaConstraints.audio : false,
        video: configuration.useVideo ? configuration.mediaConstraints.video : false
      }
    };
  }

  setPublishingUI = function  (streamName) {
    //publisherNameField.innerText = streamName;
    //roomField.setAttribute('disabled', true);
    //publisherSession.classList.remove('hidden');
    //publisherNameField.classList.remove('hidden');
    //publisherMuteControls.classList.remove('hidden');
    Array.prototype.forEach.call(document.getElementsByClassName('remove-on-broadcast'), function (el) {
      el.classList.add('hidden');
    });
  }

  updatePublishingUIOnStreamCount = function  (streamCount) {
    /*if (streamCount > 0) {
      publisherContainer.classList.remove('auto-margined');
      publisherContainer.classList.add('spaced');
      publisherContainer.classList.add('float-left');
    } else {
      publisherContainer.classList.add('auto-margined');
      publisherContainer.classList.remove('spaced');
      publisherContainer.classList.remove('float-left');
    }*/
  }

  var hasRegistered = false;
  appendMessage = function  (message) {
    //soField.value = [message, soField.value].join('\n');
  }
  // Invoked from METHOD_UPDATE event on Shared Object instance.
  messageTransmit = function  (message) { // eslint-disable-line no-unused-vars
    //soField.value = ['User "' + message.user + '": ' + message.message, soField.value].join('\n');
  }
  establishSharedObject = function (publisher, roomName, streamName) {
    // Create new shared object.
    so = new SharedObject(roomName, publisher)
    var soCallback = {
      messageTransmit: messageTransmit
    };
    so.on(red5prosdk.SharedObjectEventTypes.CONNECT_SUCCESS, function (event) { // eslint-disable-line no-unused-vars
      //console.log('[Red5ProPublisher] SharedObject Connect.');
      appendMessage('Connected.');
    });
    so.on(red5prosdk.SharedObjectEventTypes.CONNECT_FAILURE, function (event) { // eslint-disable-line no-unused-vars
      //console.log('[Red5ProPublisher] SharedObject Fail.');
    });
    so.on(red5prosdk.SharedObjectEventTypes.PROPERTY_UPDATE, function (event) {
      //console.log('[Red5ProPublisher] SharedObject Property Update.');
      //console.log(JSON.stringify(event.data, null, 2));
      if (event.data.hasOwnProperty('streams')) {
        appendMessage('Stream list is: ' + event.data.streams + '.');
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
      //console.log('[Red5ProPublisher] SharedObject Method Update.');
      //console.log(JSON.stringify(event.data, null, 2));
      soCallback[event.data.methodName].call(null, event.data.message);
    });
  }

  determinePublisher = function () {

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

  doPublish = function  (name) {
    targetPublisher.publish(name)
      .then(function () {
        onPublishSuccess(targetPublisher);
        updateInitialMediaOnPublisher();
      })
      .catch(function (error) {
        var jsonError = typeof error === 'string' ? error : JSON.stringify(error, null, 2);
        console.error('[Red5ProPublisher] :: Error in publishing - ' + jsonError);
        console.error(error);
        onPublishFail(jsonError);
       });
  }

  unpublish = function  () {
    if (so !== undefined)  {
      var name = streamName;
      var updateList = streamsPropertyList.filter(function (item) {
        return item !== name;
      });
      streamsPropertyList = updateList;
      so.setProperty('streams', updateList.join(','));
      so.close();
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

  // Kick off.
/*  determinePublisher()
    .then(function (publisherImpl) {
      targetPublisher = publisherImpl;
      targetPublisher.on('*', onPublisherEvent);
      return targetPublisher.preview();
    })
    .catch(function (error) {
      var jsonError = typeof error === 'string' ? error : JSON.stringify(error, null, 2);
      console.error('[Red5ProPublisher] :: Error in publishing - ' + jsonError);
      console.error(error);
      onPublishFail(jsonError);
     });*/

  var shuttingDown = false;

  shutdown = function  () {
    if (shuttingDown) return;
    shuttingDown = true;
    function clearRefs () {
      if (targetPublisher) {
        targetPublisher.off('*', onPublisherEvent);
      }
      targetPublisher = undefined;
    }
    unpublish().then(clearRefs).catch(clearRefs);
    window.untrackBitrate(bitrateTrackingTicket);
  }
  window.addEventListener('beforeunload', shutdown);
  window.addEventListener('pagehide', shutdown);

  var streamsPropertyList = [];
  var subscribersEl = document.getElementById('subscribers');
  processStreams = function  (streamlist, exclusion) {
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

    updatePublishingUIOnStreamCount(nonPublishers.length);
  }

})(this, document, window.red5prosdk);

