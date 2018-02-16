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

      window.downloadHex = function(dom)
      {
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


      window.downloadWav = function(dom)
      {
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
            unsafeMessage: '<div class="mg-lg fontpress"><h3  class="fontbit">' + hex_name + '</h3> <hr class=""/> <p>Program name: <b>' + hex_name + '</b></p> <p> <ul class=""><li>Start with 8BitmixtapeNEO turned off, Connect 8BitMixtapeNEO <b>Audio Programming</b> to <b>CPU speaker out</b></li> <li>Power it on</li>  <li>While Programming Led is blinking, click <b>PLAY</b> button (recommended browser: firefox, chrome)</li></ul></p></div>',
            input: '<audio controls="controls"><source src="' + hex_id + '" preload="" type="audio/x-wav"></audio>'
        });
      }


      window.openModal = function (hex_id, hex_name)
      {
          vex.dialog.open({
            overlayClassName: "bgc-raspberry-pink bloc-bg-texture texture-diagonal-lines",
            contentClassName: 'panel-shadow',
            buttons: [],
            unsafeMessage: '<div class="mg-lg fontpress"><h3  class="fontbit">' + hex_name + '</h3> <hr class=""/> <p>Program name: <b>' + hex_name + '</b></p> <p> <ul class=""><li>Start with 8BitmixtapeNEO turned off, Connect 8BitMixtapeNEO <b>Audio Programming</b> to <b>CPU speaker out</b></li> <li>Power it on</li>  <li>While Programming Led is blinking, click <b>INSTALL</b></li></ul></p></div>',
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