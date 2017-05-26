<md-toast>
    <span class="md-toast-text" flex>Help your friends to find Thoughtifies</span>
    <md-button ng-click="closeToast()">
        Close
    </md-button>
    <md-button class="md-highlight" href="https://www.facebook.com/dialog/feed?
  app_id=<?php echo $_SERVER['FB_APP_ID'] ?>
  &display=popup&amp;caption=thoughtifies.com
  &link=https://thoughtifies.com/
  &redirect_uri=<?php echo base_url(); ?>" ng-click="onClickShare()">
        Share
    </md-button>
</md-toast>