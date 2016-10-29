<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo base_url(); ?>bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/jquery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?>bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo base_url(); ?>mdl/material.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">
<script defer src="<?php echo base_url(); ?>mdl/material.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
<script>
		// A $( document ).ready() block.
		$( document ).ready(function() {

		});
</script>
</head>
	<body>
		<div id="main_cont">
		<div id="top_panel" class="row-fluid ">
							<form name="loginform" action="data/1" method="post">
									<div class="container-fluid row-fluid">
										<div id="fdf" class="col-sm-7">L social network</div>
												<div class="col-sm-2">
														  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
													    	<input class="mdl-textfield__input" name="username" type="text"/>
													    	<label class="mdl-textfield__label" for="sample3">username</label>
															</div>
												  </div>
													<div class="col-sm-2">
															<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																	<input class="mdl-textfield__input" name="password" type="password"/>
														    <label class="mdl-textfield__label" for="sample3">password</label>
															</div>
												  </div>
									  <div class="col-sm-1"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" name="" type="submit">login</button></div>
									</div>
							</form>
		</div>
			<div class="center-block">
								<!-- Large Tooltip -->
				<div class="mdl-tooltip mdl-tooltip--large" for="tt2">Create Account</div>

				<button id="tt2"  class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" data-toggle="collapse" data-target="#create_account_form"><i class="material-icons">account_box</i></button>

			</div>
		<div id="content" class="container-fluid row-fluid">
			<div class="col-sm-2">

			</div>
			<div class="col-sm-8 collapse  mdl-shadow--2dp" id="create_account_form">
				<form id="register" name="reg" action="data/2" method="post">

														<div class="row">
															<div class="col-sm-12">
																<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																		<input class="mdl-textfield__input" type="text" name="email"/>
																	<label class="mdl-textfield__label" for="sample3">Email</label>
																</div>

															</div>
														</div>
														<div class="row">
															<div class="col-sm-6">
																				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																				<input class="mdl-textfield__input" type="text" name="fname"/>
																			<label class="mdl-textfield__label" for="sample3">First name</label>
																		</div>
															</div>
															<div class="col-sm-6">
																		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																				<input class="mdl-textfield__input" type="text" name="lname"/>
																			<label class="mdl-textfield__label" for="sample3">Last name</label>
																		</div>
															</div>
														</div>
														<div class="row">

														<div class="col-sm-6">
															<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
																	  <input type="radio" class="mdl-radio__button" id="option-1" name="gender" value="M" checked>
																	  <span class="mdl-radio__label">Male</span>
															</label>
														</div>

														<div class="col-sm-6">
															<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
																	  <input type="radio" class="mdl-radio__button" id="option-2" name="gender" value="F">
																	  <span class="mdl-radio__label">Female</span>
															</label>
														</div>
													</div>
													<div class="row">
																<div class="col-sm-12">
																	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																			<input class="mdl-textfield__input" type="text" name="contact"/>
																			<label class="mdl-textfield__label" for="sample3">Mobile</label>
																	</div>
																</div>
													</div>
												<div class="row">
													<div class="col-sm-5">
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																		<input class="mdl-textfield__input"  onchange="usernameCheck()" id="username_val" type="text" name="username"/>
																		<label class="mdl-textfield__label" for="sample3">Username</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div id="username_check"></div>
													</div>
													<div class="col-xs-5">
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
															<input class="mdl-textfield__input" type="password" name="password"/>
															<label class="mdl-textfield__label" for="sample3">Password</label>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-4">
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																				<input class="mdl-textfield__input" type="text" maxlength="2" size="2" name="dd"/>
																			<label class="mdl-textfield__label" for="sample3">Day</label>
														</div>
													</div>
													<div class="col-sm-4" id="month-div">
																<select id="month" class="selectpicker" name="mm"><span class="pln"></span>
																		<option value="0"><span class="typ">Month</span>
																		</option><option><span class="pln">
																		</span></option><option value="1"><span class="typ mdl-menu__item">January</span></option><option><span class="pln">
																		</span></option><option value="2"><span class="typ">February</span></option><option><span class="pln">
																		</span></option><option value="3"><span class="typ">March</span></option><option><span class="pln">
																		</span></option><option value="4"><span class="typ">April</span></option><option><span class="pln">
																		</span></option><option value="5"><span class="typ">May</span></option><option><span class="pln">
																		</span></option><option value="6"><span class="typ">June</span></option><option><span class="pln">
																		</span></option><option value="7"><span class="typ">July</span></option><option><span class="pln">
																		</span></option><option value="8"><span class="typ">August</span></option><option><span class="pln">
																		</span></option><option value="9"><span class="typ">September</span></option><option><span class="pln">
																		</span></option><option value="10"><span class="typ">October</span></option><option><span class="pln">
																		</span></option><option value="11"><span class="typ">November</span></option><option><span class="pln">
																		</span></option><option value="12"><span class="typ">December</span></option><option>
																		</option>
															</select>
													<!--	<input type="text" name="mm-" maxlength="2" size="2"/>-->
													</div>
													<div class="col-sm-4">
														<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
																				<input class="mdl-textfield__input" type="text" name="yy" maxlength="4" size="4"/>
																			<label class="mdl-textfield__label" for="sample3">Year</label>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12">
														<select class="selectpicker" name="country" form="register">
															<option value="AF">Afghanistan</option>
															<option value="AX">Åland Islands</option>
															<option value="AL">Albania</option>
															<option value="DZ">Algeria</option>
															<option value="AS">American Samoa</option>
															<option value="AD">Andorra</option>
															<option value="AO">Angola</option>
															<option value="AI">Anguilla</option>
															<option value="AQ">Antarctica</option>
															<option value="AG">Antigua and Barbuda</option>
															<option value="AR">Argentina</option>
															<option value="AM">Armenia</option>
															<option value="AW">Aruba</option>
															<option value="AU">Australia</option>
															<option value="AT">Austria</option>
															<option value="AZ">Azerbaijan</option>
															<option value="BS">Bahamas</option>
															<option value="BH">Bahrain</option>
															<option value="BD">Bangladesh</option>
															<option value="BB">Barbados</option>
															<option value="BY">Belarus</option>
															<option value="BE">Belgium</option>
															<option value="BZ">Belize</option>
															<option value="BJ">Benin</option>
															<option value="BM">Bermuda</option>
															<option value="BT">Bhutan</option>
															<option value="BO">Bolivia, Plurinational State of</option>
															<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
															<option value="BA">Bosnia and Herzegovina</option>
															<option value="BW">Botswana</option>
															<option value="BV">Bouvet Island</option>
															<option value="BR">Brazil</option>
															<option value="IO">British Indian Ocean Territory</option>
															<option value="BN">Brunei Darussalam</option>
															<option value="BG">Bulgaria</option>
															<option value="BF">Burkina Faso</option>
															<option value="BI">Burundi</option>
															<option value="KH">Cambodia</option>
															<option value="CM">Cameroon</option>
															<option value="CA">Canada</option>
															<option value="CV">Cape Verde</option>
															<option value="KY">Cayman Islands</option>
															<option value="CF">Central African Republic</option>
															<option value="TD">Chad</option>
															<option value="CL">Chile</option>
															<option value="CN">China</option>
															<option value="CX">Christmas Island</option>
															<option value="CC">Cocos (Keeling) Islands</option>
															<option value="CO">Colombia</option>
															<option value="KM">Comoros</option>
															<option value="CG">Congo</option>
															<option value="CD">Congo, the Democratic Republic of the</option>
															<option value="CK">Cook Islands</option>
															<option value="CR">Costa Rica</option>
															<option value="CI">Côte d'Ivoire</option>
															<option value="HR">Croatia</option>
															<option value="CU">Cuba</option>
															<option value="CW">Curaçao</option>
															<option value="CY">Cyprus</option>
															<option value="CZ">Czech Republic</option>
															<option value="DK">Denmark</option>
															<option value="DJ">Djibouti</option>
															<option value="DM">Dominica</option>
															<option value="DO">Dominican Republic</option>
															<option value="EC">Ecuador</option>
															<option value="EG">Egypt</option>
															<option value="SV">El Salvador</option>
															<option value="GQ">Equatorial Guinea</option>
															<option value="ER">Eritrea</option>
															<option value="EE">Estonia</option>
															<option value="ET">Ethiopia</option>
															<option value="FK">Falkland Islands (Malvinas)</option>
															<option value="FO">Faroe Islands</option>
															<option value="FJ">Fiji</option>
															<option value="FI">Finland</option>
															<option value="FR">France</option>
															<option value="GF">French Guiana</option>
															<option value="PF">French Polynesia</option>
															<option value="TF">French Southern Territories</option>
															<option value="GA">Gabon</option>
															<option value="GM">Gambia</option>
															<option value="GE">Georgia</option>
															<option value="DE">Germany</option>
															<option value="GH">Ghana</option>
															<option value="GI">Gibraltar</option>
															<option value="GR">Greece</option>
															<option value="GL">Greenland</option>
															<option value="GD">Grenada</option>
															<option value="GP">Guadeloupe</option>
															<option value="GU">Guam</option>
															<option value="GT">Guatemala</option>
															<option value="GG">Guernsey</option>
															<option value="GN">Guinea</option>
															<option value="GW">Guinea-Bissau</option>
															<option value="GY">Guyana</option>
															<option value="HT">Haiti</option>
															<option value="HM">Heard Island and McDonald Islands</option>
															<option value="VA">Holy See (Vatican City State)</option>
															<option value="HN">Honduras</option>
															<option value="HK">Hong Kong</option>
															<option value="HU">Hungary</option>
															<option value="IS">Iceland</option>
															<option value="IN">India</option>
															<option value="ID">Indonesia</option>
															<option value="IR">Iran, Islamic Republic of</option>
															<option value="IQ">Iraq</option>
															<option value="IE">Ireland</option>
															<option value="IM">Isle of Man</option>
															<option value="IL">Israel</option>
															<option value="IT">Italy</option>
															<option value="JM">Jamaica</option>
															<option value="JP">Japan</option>
															<option value="JE">Jersey</option>
															<option value="JO">Jordan</option>
															<option value="KZ">Kazakhstan</option>
															<option value="KE">Kenya</option>
															<option value="KI">Kiribati</option>
															<option value="KP">Korea, Democratic People's Republic of</option>
															<option value="KR">Korea, Republic of</option>
															<option value="KW">Kuwait</option>
															<option value="KG">Kyrgyzstan</option>
															<option value="LA">Lao People's Democratic Republic</option>
															<option value="LV">Latvia</option>
															<option value="LB">Lebanon</option>
															<option value="LS">Lesotho</option>
															<option value="LR">Liberia</option>
															<option value="LY">Libya</option>
															<option value="LI">Liechtenstein</option>
															<option value="LT">Lithuania</option>
															<option value="LU">Luxembourg</option>
															<option value="MO">Macao</option>
															<option value="MK">Macedonia, the former Yugoslav Republic of</option>
															<option value="MG">Madagascar</option>
															<option value="MW">Malawi</option>
															<option value="MY">Malaysia</option>
															<option value="MV">Maldives</option>
															<option value="ML">Mali</option>
															<option value="MT">Malta</option>
															<option value="MH">Marshall Islands</option>
															<option value="MQ">Martinique</option>
															<option value="MR">Mauritania</option>
															<option value="MU">Mauritius</option>
															<option value="YT">Mayotte</option>
															<option value="MX">Mexico</option>
															<option value="FM">Micronesia, Federated States of</option>
															<option value="MD">Moldova, Republic of</option>
															<option value="MC">Monaco</option>
															<option value="MN">Mongolia</option>
															<option value="ME">Montenegro</option>
															<option value="MS">Montserrat</option>
															<option value="MA">Morocco</option>
															<option value="MZ">Mozambique</option>
															<option value="MM">Myanmar</option>
															<option value="NA">Namibia</option>
															<option value="NR">Nauru</option>
															<option value="NP">Nepal</option>
															<option value="NL">Netherlands</option>
															<option value="NC">New Caledonia</option>
															<option value="NZ">New Zealand</option>
															<option value="NI">Nicaragua</option>
															<option value="NE">Niger</option>
															<option value="NG">Nigeria</option>
															<option value="NU">Niue</option>
															<option value="NF">Norfolk Island</option>
															<option value="MP">Northern Mariana Islands</option>
															<option value="NO">Norway</option>
															<option value="OM">Oman</option>
															<option value="PK">Pakistan</option>
															<option value="PW">Palau</option>
															<option value="PS">Palestinian Territory, Occupied</option>
															<option value="PA">Panama</option>
															<option value="PG">Papua New Guinea</option>
															<option value="PY">Paraguay</option>
															<option value="PE">Peru</option>
															<option value="PH">Philippines</option>
															<option value="PN">Pitcairn</option>
															<option value="PL">Poland</option>
															<option value="PT">Portugal</option>
															<option value="PR">Puerto Rico</option>
															<option value="QA">Qatar</option>
															<option value="RE">Réunion</option>
															<option value="RO">Romania</option>
															<option value="RU">Russian Federation</option>
															<option value="RW">Rwanda</option>
															<option value="BL">Saint Barthélemy</option>
															<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
															<option value="KN">Saint Kitts and Nevis</option>
															<option value="LC">Saint Lucia</option>
															<option value="MF">Saint Martin (French part)</option>
															<option value="PM">Saint Pierre and Miquelon</option>
															<option value="VC">Saint Vincent and the Grenadines</option>
															<option value="WS">Samoa</option>
															<option value="SM">San Marino</option>
															<option value="ST">Sao Tome and Principe</option>
															<option value="SA">Saudi Arabia</option>
															<option value="SN">Senegal</option>
															<option value="RS">Serbia</option>
															<option value="SC">Seychelles</option>
															<option value="SL">Sierra Leone</option>
															<option value="SG">Singapore</option>
															<option value="SX">Sint Maarten (Dutch part)</option>
															<option value="SK">Slovakia</option>
															<option value="SI">Slovenia</option>
															<option value="SB">Solomon Islands</option>
															<option value="SO">Somalia</option>
															<option value="ZA">South Africa</option>
															<option value="GS">South Georgia and the South Sandwich Islands</option>
															<option value="SS">South Sudan</option>
															<option value="ES">Spain</option>
															<option value="LK">Sri Lanka</option>
															<option value="SD">Sudan</option>
															<option value="SR">Suriname</option>
															<option value="SJ">Svalbard and Jan Mayen</option>
															<option value="SZ">Swaziland</option>
															<option value="SE">Sweden</option>
															<option value="CH">Switzerland</option>
															<option value="SY">Syrian Arab Republic</option>
															<option value="TW">Taiwan, Province of China</option>
															<option value="TJ">Tajikistan</option>
															<option value="TZ">Tanzania, United Republic of</option>
															<option value="TH">Thailand</option>
															<option value="TL">Timor-Leste</option>
															<option value="TG">Togo</option>
															<option value="TK">Tokelau</option>
															<option value="TO">Tonga</option>
															<option value="TT">Trinidad and Tobago</option>
															<option value="TN">Tunisia</option>
															<option value="TR">Turkey</option>
															<option value="TM">Turkmenistan</option>
															<option value="TC">Turks and Caicos Islands</option>
															<option value="TV">Tuvalu</option>
															<option value="UG">Uganda</option>
															<option value="UA">Ukraine</option>
															<option value="AE">United Arab Emirates</option>
															<option value="GB">United Kingdom</option>
															<option value="US">United States</option>
															<option value="UM">United States Minor Outlying Islands</option>
															<option value="UY">Uruguay</option>
															<option value="UZ">Uzbekistan</option>
															<option value="VU">Vanuatu</option>
															<option value="VE">Venezuela, Bolivarian Republic of</option>
															<option value="VN">Viet Nam</option>
															<option value="VG">Virgin Islands, British</option>
															<option value="VI">Virgin Islands, U.S.</option>
															<option value="WF">Wallis and Futuna</option>
															<option value="EH">Western Sahara</option>
															<option value="YE">Yemen</option>
															<option value="ZM">Zambia</option>
															<option value="ZW">Zimbabwe</option>
														</select>
													</div>
												</div><br>
												<div class="row">
													<div class="col-sm-12">
														<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" name="submit" type="submit">Sign Up</button>
													</div>
												</div>
				</form>
			</div>
			<div class="col-sm-2">

			</div>
		</div>

		</div>
		<br><br>
		<div id="footer">
		</div>
	</body>
</html>
