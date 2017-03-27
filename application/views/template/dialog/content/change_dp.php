<div layout="column">
        <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
        <label for="input-file-id" class="md-button md-primary">
          Choose File
        </label>
        <div ng-if="upload.response !== undefined" layout="column">
          <div class="empty_msg">
              Preview
          </div>
          <img src="{{upload.response.dp}}" alt="">
        </div>
        <div ng-if="uploader.isUploading" layout="column">
          <div class="empty_msg">
            Uploading
          </div>
          <div ng-repeat="item in uploader.queue">
                <div  ng-thumb="{ file: item._file, height: 100 }"></div>
          </div>
          <md-progress-linear ng-if="uploader.isUploading" md-mode="determinate" value="{{upload.status}}"></md-progress-linear>
        </div>

</div>
