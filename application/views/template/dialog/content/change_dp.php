<div layout="column">
        <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
        <label for="input-file-id" class="md-button md-primary">
          Choose File
        </label>
        <div ng-show="upload.response !== undefined" layout="column" layout-margin>
          <div class="empty_msg">
              Preview
          </div>
          <span ng-bind-html="error"></span>
          <img src="{{upload.response.dp}}" alt="" ng-click="previewClick($event)">
        </div>
        <div ng-show="uploader.isUploading" layout="column">
          <div class="empty_msg">
            Uploading
          </div>
          <div ng-repeat="item in uploader.queue">
                <div  ng-thumb="{ file: item._file, height: 100 }"></div>
          </div>
          <md-progress-linear ng-show="uploader.isUploading" md-mode="determinate" value="{{upload.status}}"></md-progress-linear>
        </div>

</div>
