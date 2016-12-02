<div layout="column">
        <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
        <label for="input-file-id" class="md-button md-primary">
          Choose File
        </label>
        <img src="{{myImage}}" />
        <md-progress-linear ng-hide="upload.progress" md-mode="determinate" value="{{upload.status}}"></md-progress-linear>
</div>
