<div  class="jk-rating-stars-container" layout="row" >
  <a class="button star-button"
    ng-class="item.class"
    ng-mouseover="ctrl.setMouseOverRating($index + 1)"
    ng-mouseleave="ctrl.setMouseOverRating(ctrl.rating)"
    ng-click="ctrl.setRating($index + 1)"
    ng-repeat="item in ctrl.starsArray" >
    <i class="material-icons">star</i>
  </a>
</div>
