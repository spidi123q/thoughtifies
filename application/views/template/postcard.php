<md-whiteframe  class="md-whiteframe-2dp" ng-style="shadow"   layout-align="center center" layout="row" style="background-color:white;" >
  <span layout="row" flex>
    <md-list class="md-dense" flex>
        <md-list-item class="md-2-line" >
          <img ng-csp image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{picture}}" size="60" class="md-avatar" alt="{{item.who}}" />
          <div class="md-list-item-text post_dialog_contenteditable" layout="column">
            <div  contenteditable="true" placeholder="Share your thoughts" ng-model="data"
            ></div>
          </div>
        </md-list-item>
        <span layout="row" layout-align="space-between end">
          <span flex-offset="5" layout="row" layout-align="end center">
            <md-switch  ng-change="changeEmojiView()" class="md-warn"  ng-model="view" >

             <md-button class="md-icon-button" aria-label="More">
                   <i class="material-icons ">tag_faces</i>
             </md-button>
           </md-switch>
             <md-button class="md-icon-button" ng-class="classUploadButton" aria-label="More" ng-click="onUploadButtonClick()">
                   <md-icon md-font-library="material-icons" class="md-light md-48">add_a_photo</md-icon>
             </md-button>
          </span>
          <span layout="row" layout-align="end center">
            <md-progress-circular ng-show="progress" class="md-warn" md-mode="indeterminate" md-diameter="20px"></md-progress-circular>
            <md-button  ng-click="post()" ng-disabled="upload.button || progress" class="md-warn">
              <md-icon md-font-library="material-icons" class="md-light md-48">send</md-icon>
            </md-button>
          </span>
        </span>
        <div ng-show="fileView" layout="row" layout-align="center center">
            <input class="ng-hide" id="input-file-id"  type="file" accept="image/*" size="100" nv-file-select="" uploader="uploader" />
            <label ng-click="uploader.clearQueue();" for="input-file-id" class="md-button md-primary" style="width: inherit">
                  Choose file
            </label>
            <md-button ng-show="clearButtonView" ng-click="onClearButtonClick()">
                Clear
            </md-button>
        </div>
        <div layout="row" layout-align="center center">
            <div ng-if="error == ''" ng-repeat="item in uploader.queue">
                <span layout="column">
                  <div  ng-thumb="{ file: item._file, height: 100 }"></div>
                  <md-progress-linear ng-hide="upload.progress" md-mode="determinate" value="{{upload.status}}" class="md-warn"></md-progress-linear>
                </span>
            </div>
            <span style="padding: 10px" ng-bind-html="error"></span>

        </div>
        <md-content class="blue-slow"  ng-show="view" style="height:100%;background-color: ">
            <span class="" ng-animate="'animate'"  ng-repeat="item in emojilist" ng-click="onEmojiClick(item)" style="width:32px;height:32px;">
              <span ng-bind-html="item" ></span>
            </span>
        </md-content>

    </md-list>

  </span>

 </md-whiteframe>
