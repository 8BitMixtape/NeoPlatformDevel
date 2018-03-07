$(function () {
  
      var isuploading = false;
      var hex2wav = new Hex2wav();
      var hex_cache = {};

      var uploadHex = function(hex_string, cb)
      {
        var decoded_hex_array = hex2wav.decodeHexFile(hex_string);
        var signal = hex2wav.generateProgrammingSignal(decoded_hex_array);
        var time = (signal.length/44100)*1000;
        hex2wav.playSignal(hex2wav.audioCtx, signal);
        setTimeout(cb, time);
      }

      window.downloadHex = function(dom, event)
      {
          event.preventDefault();
          
          var hex_id = dom.getAttribute('value');
          var hex_name = dom.getAttribute('programName');

          var normal_txt = "<span class=\"fa fa-bolt icon-spacer\" ></span>INSTALL";
          var getting_txt = "<b>Loading..</b>";
          var failed_txt = "<b>Fail, Retry?..</b>";

          dom.innerHTML = getting_txt;

          $.ajax({
              url: '' + hex_id,
              type: 'GET'
          })
          .done(function(data) {
            //console.log(data);
            hex_cache[hex_id] = data;
            window.openModal(hex_id, hex_name);
            dom.innerHTML = normal_txt;
            
          })
          .fail(function() {
            dom.innerHTML = failed_txt;       
          });

      }


      window.downloadWav = function(dom, event)
      {
          event.preventDefault();
          
          var hex_id = dom.getAttribute('value');
          var hex_name = dom.getAttribute('programName');

          var normal_txt = "<span class=\"fa fa-bolt icon-spacer\" ></span>INSTALL";
          var getting_txt = "<b>Loading..</b>";
          var failed_txt = "<b>Fail, Retry?..</b>";

            //console.log(data);
           window.openModalWav(hex_id, hex_name);
 
      }


      window.openModalWav = function (hex_id, hex_name)
      {
          vex.dialog.open({
            overlayClassName: "bgc-raspberry-pink bloc-bg-texture texture-diagonal-lines",
            contentClassName: 'panel-shadow',
            buttons: [],
            unsafeMessage: '<div class="mg-lg fontpress"><h3  class="fontbit">' + hex_name + '</h3> <hr class=""/> <p>Program name: <b>' + hex_name + '</b></p> <p> <ol><li class=“”>First, start turning on your synthesizer by pressing the <b>power button</b> on the middle.</li><li class=“”>Second, you can tell that it’s on by looking at the <b>blinking LED</b> on the right side of your synthesizer. </li><li class=“”>Then click <b>PLAY button</b> before blinking time runs out (5 seconds).</li><li class=“”>Next, your LED will <b>blink rapidly</b> when installation is running. Voila! Your synthesizer is ready to use!</li></ol> </p></div>',
            input: '<audio controls="controls"><source src="' + hex_id + '" preload="" type="audio/x-wav"></audio>'
        });
      }


      window.openModal = function (hex_id, hex_name)
      {
          vex.dialog.open({
            overlayClassName: "bgc-raspberry-pink bloc-bg-texture texture-diagonal-lines",
            contentClassName: 'panel-shadow',
            buttons: [],
            unsafeMessage: '<div class="mg-lg fontpress"><h3  class="fontbit">' + hex_name + '</h3> <hr class=""/> <p>Program name: <b>' + hex_name + '</b></p> <p> <ol><li class=“”>First, start turning on your synthesizer by pressing the <b>power button</b> on the middle.</li><li class=“”>Second, you can tell that it’s on by looking at the <b>blinking LED</b> on the right side of your synthesizer. </li><li class=“”>Then click <b>INSTALL</b> before blinking time runs out (5 seconds).</li><li class=“”>Next, your LED will <b>blink rapidly</b> when installation is running. Voila! Your synthesizer is ready to use!</li></ol> </p></div>',
            input: ' <a class="mg-lg btn btn-sq btn-block btn-flat panel-shadow btn-neon-carrot" onclick="window.uploadHexBtn(this, event);" href="#" value="' + hex_id + '" ><span class="fa fa-bolt icon-spacer"></span><b>INSTALL</b> <span class="fa fa-bolt icon-spacer"></span></a>'
        });
      }

      //global
      window.uploadHexBtn = function(event, dom)
      {

        if (isuploading) {
          dom.preventDefault();
          return;
        }

        var hex_id = (event.getAttribute('value')); 
        console.log(hex_cache[hex_id]);     

        event.innerHTML = "<b>Uploading..</b>";
        isuploading = true;

        uploadHex(hex_cache[hex_id], function(){
            event.innerHTML = "<b>Retry</b>";
            isuploading = false;
        });

        dom.preventDefault();
      }

});