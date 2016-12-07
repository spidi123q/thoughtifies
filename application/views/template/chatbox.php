<div class="holder">
	<div class="scroller">
		<div class="wrap">
			<div class="message {{::msg.own}}" ng-repeat="msg in messages">
				<div>
					{{:: msg | chatboxExtractText }}
					<p class="time" ng-if="msg.time">{{::msg.time}}</p>
				</div>
			</div>
		</div>
	</div>
</div>

<style media="screen">
.holder {
border: 1px dotted navy;
height: 400px;
width: 320px;
background-color: #EEF;
font: 12px Verdana;
position: relative;
overflow-y: auto;
}

.scroller {
position: absolute;
bottom: 0px;
width: 100%;
overflow-y: auto;
max-height: 400px;
}

.wrap {
position: relative;
width: 100%;
padding-bottom: 8px;
}

.message {
text-align: left;
padding: 0 10px;
}

.message > div {
display: block;
background-color: #FFE;
padding: 6px;
margin: 4px 0px;
border-radius: 10px;
}

.message .time {
font-size: 8px;
color: silver;
margin-bottom: 0;
}

.message .index:after {
content: ': ';
}

.message.mine > div, .message.their > div {
display: inline-block;
}

.message.mine > div {
border-bottom-left-radius: 0;
position: relative;
}


.message.mine > div:before{
content: "";
width: 0;
height: 0;
border-bottom: 12px solid #FFE;
border-left: 8px solid transparent;
bottom: 0;
left: -8px;
position: absolute;
}


.message.their {
text-align: right;
}

.message.their > div {
background-color: #CCF;
border-bottom-right-radius: 0;
right: 0;
position: relative;
}

.message.their > div:after{
content: "";
width: 0;
height: 0;
border-bottom: 12px solid #CCF;
border-right: 8px solid transparent;
bottom: 0;
right: -8px;
position: absolute;
}

.message.their .time {
color: #8992D6;
}
</style>
