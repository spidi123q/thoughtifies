<md-whiteframe  class="md-whiteframe-2dp" ng-style="shadow"   layout-align="center center" layout="row" style="background-color:white;" >
  <span layout="row" flex>
    <md-list class="md-dense" flex>
        <md-list-item class="md-2-line" >
          <img ng-src="http://www.freedigitalphotos.net/images/img/homepage/87357.jpg" class="md-avatar" alt="{{item.who}}" />
          <div class="md-list-item-text" layout="column">
            <div contenteditable ng-model="data" 
            ng-focus="focus()"
            ng-blur="unfocus()"
            ></div>
          </div>
        </md-list-item>
        <div layout="row">
            <div ng-repeat="item in uploader.queue">
                <span layout="column">
                  <div  ng-thumb="{ file: item._file, height: 100 }"></div>
                  <md-progress-linear ng-hide="upload.progress" md-mode="determinate" value="{{upload.status}}" class="md-warn"></md-progress-linear>
                </span>
            </div>

        </div>
        <span layout="row" layout-align="space-between end">
          <span layout="row" layout-align="end center">
            <md-button class="md-icon-button md-primary" aria-label="More">
                <i class="material-icons">tag_faces</i>
            </md-button>
            <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
            <label for="input-file-id" class="md-icon-button">
                  <i class="material-icons">insert_photo</i>
            </label>
          </span>
          <span layout="row" layout-align="end center">
            <md-button ng-click="post()" ng-disabled="upload.button" class="md-warn">post</md-button>
          </span>
        </span>

    </md-list>

  </span>

 </md-whiteframe>
