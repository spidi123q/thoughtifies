<div  class="phone simple-flex-container mobile_flex">
  <div class="myVideo">
    <video id="video" autoplay  loop muted playsinline poster="<?php echo base_url(); ?>images/phone_poster.jpg">
      <source src="<?php echo base_url(); ?>images/phone_preview.mp4" type="video/mp4">
    Your browser does not support the video.
    </video>
  </div>
  <div class="quotes flex-container column">
      <div>Advertising your thoughts</div>
      <div>Connecting people</div>
      <div>Privacy first! Thoughtifies don't track you</div>
  </div>
  <script type="text/javascript">
          var video = document.getElementById('video');
          document.addEventListener('click',function(){
              video.play();
          },false);

  </script>
</div>
<div class="chrome-button {chromebutton}">
    <span onclick="toggleBlur()">
        Add to Home Screen
    </span>
</div>
