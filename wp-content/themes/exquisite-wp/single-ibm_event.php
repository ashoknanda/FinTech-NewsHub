<?php get_header(); ?>
<div class="row relative">
<?php //get_template_part( 'inc/postformats/post-sharebox' ); ?>
<section class="nine columns">
  <?php 
  if (have_posts()) :  while (have_posts()) : the_post(); 
  	$ibm_event_start = get_post_meta( get_the_ID(), '_ibm_event_start', true );
  	$ibm_event_end = get_post_meta( get_the_ID(), '_ibm_event_end', true );
  	$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );
  ?>
  	<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
  		
		<?php
	    // The following determines what the post format is and shows the correct file accordingly
	    $format = get_post_format();
	    if ($format) {
		    get_template_part( 'inc/postformats/'.$format );
	    } else {
		    get_template_part( 'inc/postformats/standard' );
	    }
		?>
		
		  <div class="post-title">
		  	<!--<aside><?php echo thb_DisplaySingleCategory(true); ?></aside>-->
		  	<h1><?php the_title(); ?></h1>
		  </div>
		  <aside class="post-meta single">
		  	<?php
		  	$end_empty = false;
		  	if (empty($ibm_event_end)) {
		  		$end_empty = true;
		  	}

			$timezone_2 = (str_replace('UTC-', 'Etc/GMT+', str_replace('UTC+', 'Etc/GMT-', $timezone)));

			date_default_timezone_set($timezone_2); // set default timezone as desired
  			$ibm_event_timezone_time = date(" T", $ibm_event_start);
			set_default_time_zone_config();

  			$ibm_event_start_text = date("F j, Y", $ibm_event_start);
  			$ibm_event_start_time = date("g:i A", $ibm_event_start);

  			if ($end_empty == false) {
  				$ibm_event_end_text = date("F j, Y", $ibm_event_end);
	  			$ibm_event_end_time = date("g:i A", $ibm_event_end).$ibm_event_timezone_time;
	  		}else{
  				$ibm_event_start_time .= $ibm_event_timezone_time;
  			}
		  	if (strtolower(trim(get_post_meta( get_the_ID(), '_ibm_event_type', true ))) == 'webinar') { 
		  		if ($ibm_event_start > time()) {
		  	?> 
		  	<ul>
		  		<!--
		  		<li class="strong"><?php echo get_event_datetime_timeze_change($ibm_event_start, false, $timezone ); ?> - <?php echo get_event_datetime_timeze_change($ibm_event_end, false, $timezone, true ); ?></li>
		  		-->
		  	</ul>
		  	<ul>
		  		<li>
		  			<span class="span_date_hosted_location"><?php echo $ibm_event_start_text; ?></span> <?php echo $ibm_event_start_time; ?> - <?php echo $ibm_event_end_time; ?>
		  		</li>
			  </ul>

		  	<?php
		  		} 
		  	} else { 
		  	?>		  	
		  		<?php
		  			if ($end_empty == true) {
		  			?>
		  				<ul>
		  					<li class="strong">
		  						<?php echo $ibm_event_start_text; ?>
		  					</li>
							</ul>
		  				<ul>
		  					<li>
		  						Begins at <?php echo $ibm_event_start_time; ?>
		  					</li>
							</ul>		  			
		  			<?php
		  			}else if ($ibm_event_start_text == $ibm_event_end_text) {
		  			?>
		  				<ul>
		  					<li class="strong">
		  						<?php echo $ibm_event_start_text; ?>
		  					</li>
							</ul>
		  				<ul>
		  					<li>
		  						<?php echo $ibm_event_start_time; ?>
		  						&mdash;
		  						<?php echo $ibm_event_end_time; ?>
		  					</li>
							</ul>
		  			<?php
		  			} else {
		  			?>

		  				<ul>
		  					<li class="strong">
		  						<?php echo $ibm_event_start_text; ?>
		  					</li>
		  					<li class="strong">&mdash;</li>
		  					<li class="strong">
		  						<?php echo $ibm_event_end_text; ?>
		  					</li>
							</ul>
						<?php
		  			}
		  			?>
				  		<ul>
					  	<?php if ( get_post_meta( get_the_ID(), '_ibm_event_location', true ) ) { ?>
					  		<li><?php echo get_post_meta( get_the_ID(), '_ibm_event_location', true ); ?></li>
					  	<?php } else { ?>
					  		<li><?php echo str_replace('_', ' ', str_replace('/', ', ', $timezone)); ?></li>
					  	<?php } ?>
					  	</ul>

		  	<?php } ?>
		  </aside>
		  <div class="post-content">
		  	<?php get_template_part('template-addthis-horizontal'); ?>
			<hr class="space">
		  	<?php
		  	if ( get_post_meta( get_the_ID(), '_ibm_event_register_url', true ) ) {
			  	echo '<p><a class="btn black large" href="' . esc_url( get_post_meta( get_the_ID(), '_ibm_event_register_url', true ) ) . '" target="_blank">Register</a></p>';
			}

echo '<div id="div-post-event-the-content">';
			the_content();
			echo '</div>';

	  	if ( trim(get_post_meta( get_the_ID(), '_ibm_event_on24_event_id', true )) != '' && trim(get_post_meta( get_the_ID(), '_ibm_event_on24_key', true )) != '') {	  		
	  		$on24_event_id = trim(get_post_meta( get_the_ID(), '_ibm_event_on24_event_id', true ));
	  		$event_on24_key = trim(get_post_meta( get_the_ID(), '_ibm_event_on24_key', true ));
	  		$event_on24_session_id = trim(get_post_meta( get_the_ID(), 'event_on24_session_id', true ));
	  		if (empty($event_on24_session_id)){
	  			$event_on24_session_id = 1;
	  		}
	  		?>
	  	<div id="div_on24_register">
			<p class="register-headline">Register Now</p>
			<form name="myform" id="event24-register-form" action="http://event.on24.com/interface/registration/autoreg/index.html" method="GET" target="_blank">
				<input type="hidden" name="eventid" value="<?php echo $on24_event_id; ?>">
				<input type="hidden" name="sessionid" value="<?php echo $event_on24_session_id; ?>">
				<input type="hidden" name="key" value="<?php echo $event_on24_key; ?>">

				<input type="text" name="firstname" placeholder="First Name*">
				<input type="text" name="lastname" placeholder="Last Name*"> 
				<input type="text" name="email" placeholder="Email*">
				<input type="text" name="company" placeholder="Company*">
				<input type="text" name="job_title" placeholder="Title*">
				<input type="text" name="work_phone" placeholder="Work Phone – example 5551112222*">
				<select name="state">
					<option value="">Select a state</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>	
				<p>Country<span class="red">*</span></p>
				<select name="country">
					<option value="">Select the Country</option>
					<option value="Afganistan">Afghanistan</option>
					<option value="Albania">Albania</option>
					<option value="Algeria">Algeria</option>
					<option value="American Samoa">American Samoa</option>
					<option value="Andorra">Andorra</option>
					<option value="Angola">Angola</option>
					<option value="Anguilla">Anguilla</option>
					<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
					<option value="Argentina">Argentina</option>
					<option value="Armenia">Armenia</option>
					<option value="Aruba">Aruba</option>
					<option value="Australia">Australia</option>
					<option value="Austria">Austria</option>
					<option value="Azerbaijan">Azerbaijan</option>
					<option value="Bahamas">Bahamas</option>
					<option value="Bahrain">Bahrain</option>
					<option value="Bangladesh">Bangladesh</option>
					<option value="Barbados">Barbados</option>
					<option value="Belarus">Belarus</option>
					<option value="Belgium">Belgium</option>
					<option value="Belize">Belize</option>
					<option value="Benin">Benin</option>
					<option value="Bermuda">Bermuda</option>
					<option value="Bhutan">Bhutan</option>
					<option value="Bolivia">Bolivia</option>
					<option value="Bonaire">Bonaire</option>
					<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
					<option value="Botswana">Botswana</option>
					<option value="Brazil">Brazil</option>
					<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
					<option value="Brunei">Brunei</option>
					<option value="Bulgaria">Bulgaria</option>
					<option value="Burkina Faso">Burkina Faso</option>
					<option value="Burundi">Burundi</option>
					<option value="Cambodia">Cambodia</option>
					<option value="Cameroon">Cameroon</option>
					<option value="Canada">Canada</option>
					<option value="Canary Islands">Canary Islands</option>
					<option value="Cape Verde">Cape Verde</option>
					<option value="Cayman Islands">Cayman Islands</option>
					<option value="Central African Republic">Central African Republic</option>
					<option value="Chad">Chad</option>
					<option value="Channel Islands">Channel Islands</option>
					<option value="Chile">Chile</option>
					<option value="China">China</option>
					<option value="Christmas Island">Christmas Island</option>
					<option value="Cocos Island">Cocos Island</option>
					<option value="Colombia">Colombia</option>
					<option value="Comoros">Comoros</option>
					<option value="Congo">Congo</option>
					<option value="Cook Islands">Cook Islands</option>
					<option value="Costa Rica">Costa Rica</option>
					<option value="Cote DIvoire">Cote D'Ivoire</option>
					<option value="Croatia">Croatia</option>
					<option value="Cuba">Cuba</option>
					<option value="Curaco">Curacao</option>
					<option value="Cyprus">Cyprus</option>
					<option value="Czech Republic">Czech Republic</option>
					<option value="Denmark">Denmark</option>
					<option value="Djibouti">Djibouti</option>
					<option value="Dominica">Dominica</option>
					<option value="Dominican Republic">Dominican Republic</option>
					<option value="East Timor">East Timor</option>
					<option value="Ecuador">Ecuador</option>
					<option value="Egypt">Egypt</option>
					<option value="El Salvador">El Salvador</option>
					<option value="Equatorial Guinea">Equatorial Guinea</option>
					<option value="Eritrea">Eritrea</option>
					<option value="Estonia">Estonia</option>
					<option value="Ethiopia">Ethiopia</option>
					<option value="Falkland Islands">Falkland Islands</option>
					<option value="Faroe Islands">Faroe Islands</option>
					<option value="Fiji">Fiji</option>
					<option value="Finland">Finland</option>
					<option value="France">France</option>
					<option value="French Guiana">French Guiana</option>
					<option value="French Polynesia">French Polynesia</option>
					<option value="French Southern Ter">French Southern Ter</option>
					<option value="Gabon">Gabon</option>
					<option value="Gambia">Gambia</option>
					<option value="Georgia">Georgia</option>
					<option value="Germany">Germany</option>
					<option value="Ghana">Ghana</option>
					<option value="Gibraltar">Gibraltar</option>
					<option value="Great Britain">Great Britain</option>
					<option value="Greece">Greece</option>
					<option value="Greenland">Greenland</option>
					<option value="Grenada">Grenada</option>
					<option value="Guadeloupe">Guadeloupe</option>
					<option value="Guam">Guam</option>
					<option value="Guatemala">Guatemala</option>
					<option value="Guinea">Guinea</option>
					<option value="Guyana">Guyana</option>
					<option value="Haiti">Haiti</option>
					<option value="Hawaii">Hawaii</option>
					<option value="Honduras">Honduras</option>
					<option value="Hong Kong">Hong Kong</option>
					<option value="Hungary">Hungary</option>
					<option value="Iceland">Iceland</option>
					<option value="India">India</option>
					<option value="Indonesia">Indonesia</option>
					<option value="Iran">Iran</option>
					<option value="Iraq">Iraq</option>
					<option value="Ireland">Ireland</option>
					<option value="Isle of Man">Isle of Man</option>
					<option value="Israel">Israel</option>
					<option value="Italy">Italy</option>
					<option value="Jamaica">Jamaica</option>
					<option value="Japan">Japan</option>
					<option value="Jordan">Jordan</option>
					<option value="Kazakhstan">Kazakhstan</option>
					<option value="Kenya">Kenya</option>
					<option value="Kiribati">Kiribati</option>
					<option value="Korea North">Korea North</option>
					<option value="Korea Sout">Korea South</option>
					<option value="Kuwait">Kuwait</option>
					<option value="Kyrgyzstan">Kyrgyzstan</option>
					<option value="Laos">Laos</option>
					<option value="Latvia">Latvia</option>
					<option value="Lebanon">Lebanon</option>
					<option value="Lesotho">Lesotho</option>
					<option value="Liberia">Liberia</option>
					<option value="Libya">Libya</option>
					<option value="Liechtenstein">Liechtenstein</option>
					<option value="Lithuania">Lithuania</option>
					<option value="Luxembourg">Luxembourg</option>
					<option value="Macau">Macau</option>
					<option value="Macedonia">Macedonia</option>
					<option value="Madagascar">Madagascar</option>
					<option value="Malaysia">Malaysia</option>
					<option value="Malawi">Malawi</option>
					<option value="Maldives">Maldives</option>
					<option value="Mali">Mali</option>
					<option value="Malta">Malta</option>
					<option value="Marshall Islands">Marshall Islands</option>
					<option value="Martinique">Martinique</option>
					<option value="Mauritania">Mauritania</option>
					<option value="Mauritius">Mauritius</option>
					<option value="Mayotte">Mayotte</option>
					<option value="Mexico">Mexico</option>
					<option value="Midway Islands">Midway Islands</option>
					<option value="Moldova">Moldova</option>
					<option value="Monaco">Monaco</option>
					<option value="Mongolia">Mongolia</option>
					<option value="Montserrat">Montserrat</option>
					<option value="Morocco">Morocco</option>
					<option value="Mozambique">Mozambique</option>
					<option value="Myanmar">Myanmar</option>
					<option value="Nambia">Nambia</option>
					<option value="Nauru">Nauru</option>
					<option value="Nepal">Nepal</option>
					<option value="Netherland Antilles">Netherland Antilles</option>
					<option value="Netherlands">Netherlands (Holland, Europe)</option>
					<option value="Nevis">Nevis</option>
					<option value="New Caledonia">New Caledonia</option>
					<option value="New Zealand">New Zealand</option>
					<option value="Nicaragua">Nicaragua</option>
					<option value="Niger">Niger</option>
					<option value="Nigeria">Nigeria</option>
					<option value="Niue">Niue</option>
					<option value="Norfolk Island">Norfolk Island</option>
					<option value="Norway">Norway</option>
					<option value="Oman">Oman</option>
					<option value="Pakistan">Pakistan</option>
					<option value="Palau Island">Palau Island</option>
					<option value="Palestine">Palestine</option>
					<option value="Panama">Panama</option>
					<option value="Papua New Guinea">Papua New Guinea</option>
					<option value="Paraguay">Paraguay</option>
					<option value="Peru">Peru</option>
					<option value="Phillipines">Philippines</option>
					<option value="Pitcairn Island">Pitcairn Island</option>
					<option value="Poland">Poland</option>
					<option value="Portugal">Portugal</option>
					<option value="Puerto Rico">Puerto Rico</option>
					<option value="Qatar">Qatar</option>
					<option value="Republic of Montenegro">Republic of Montenegro</option>
					<option value="Republic of Serbia">Republic of Serbia</option>
					<option value="Reunion">Reunion</option>
					<option value="Romania">Romania</option>
					<option value="Russia">Russia</option>
					<option value="Rwanda">Rwanda</option>
					<option value="St Barthelemy">St Barthelemy</option>
					<option value="St Eustatius">St Eustatius</option>
					<option value="St Helena">St Helena</option>
					<option value="St Kitts-Nevis">St Kitts-Nevis</option>
					<option value="St Lucia">St Lucia</option>
					<option value="St Maarten">St Maarten</option>
					<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
					<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
					<option value="Saipan">Saipan</option>
					<option value="Samoa">Samoa</option>
					<option value="Samoa American">Samoa American</option>
					<option value="San Marino">San Marino</option>
					<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
					<option value="Saudi Arabia">Saudi Arabia</option>
					<option value="Senegal">Senegal</option>
					<option value="Serbia">Serbia</option>
					<option value="Seychelles">Seychelles</option>
					<option value="Sierra Leone">Sierra Leone</option>
					<option value="Singapore">Singapore</option>
					<option value="Slovakia">Slovakia</option>
					<option value="Slovenia">Slovenia</option>
					<option value="Solomon Islands">Solomon Islands</option>
					<option value="Somalia">Somalia</option>
					<option value="South Africa">South Africa</option>
					<option value="Spain">Spain</option>
					<option value="Sri Lanka">Sri Lanka</option>
					<option value="Sudan">Sudan</option>
					<option value="Suriname">Suriname</option>
					<option value="Swaziland">Swaziland</option>
					<option value="Sweden">Sweden</option>
					<option value="Switzerland">Switzerland</option>
					<option value="Syria">Syria</option>
					<option value="Tahiti">Tahiti</option>
					<option value="Taiwan">Taiwan</option>
					<option value="Tajikistan">Tajikistan</option>
					<option value="Tanzania">Tanzania</option>
					<option value="Thailand">Thailand</option>
					<option value="Togo">Togo</option>
					<option value="Tokelau">Tokelau</option>
					<option value="Tonga">Tonga</option>
					<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
					<option value="Tunisia">Tunisia</option>
					<option value="Turkey">Turkey</option>
					<option value="Turkmenistan">Turkmenistan</option>
					<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
					<option value="Tuvalu">Tuvalu</option>
					<option value="Uganda">Uganda</option>
					<option value="Ukraine">Ukraine</option>
					<option value="United Arab Erimates">United Arab Emirates</option>
					<option value="United Kingdom">United Kingdom</option>
					<option value="United States of America">United States of America</option>
					<option value="Uraguay">Uruguay</option>
					<option value="Uzbekistan">Uzbekistan</option>
					<option value="Vanuatu">Vanuatu</option>
					<option value="Vatican City State">Vatican City State</option>
					<option value="Venezuela">Venezuela</option>
					<option value="Vietnam">Vietnam</option>
					<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
					<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
					<option value="Wake Island">Wake Island</option>
					<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
					<option value="Yemen">Yemen</option>
					<option value="Zaire">Zaire</option>
					<option value="Zambia">Zambia</option>
					<option value="Zimbabwe">Zimbabwe</option>
				</select>					
				<p><span class="red">*</span>Denotes required.</p>
				<input type="submit" value="Register">
			</form>	
	  		</div>
	  		<div id="div_on24_thank_you">
					<p>
						Thank you for registering for this IBM Security Webinar. We hope you enjoy the presentation.
						<br />
						Follow the latest security trends and threats at <a href="<?php echo get_site_url(); ?>">Security Intelligence</a>.
					</p>
	  		</div>	  		
	  		<?php
			}

		  	if ( shortcode_exists( 'register_free_webinar' ) && get_post_meta( get_the_ID(), '_ibm_event_type', true ) == 'webinar' && get_post_meta( get_the_ID(), '_ibm_event_start', true ) > time() && is_numeric( get_post_meta( get_the_ID(), '_ibm_event_gtm_id', true ) ) ) {
					$attrs = get_timezone_arguments_element();
			  	echo '<a id="register"></a>';
			  	echo '<h4>Register Now:</h4>';
				echo '<div class="change_timezone_text"'. $attrs.' data-timezone-type="6">';
			  	echo do_shortcode('[register_free_webinar webid=' . get_post_meta( get_the_ID(), '_ibm_event_gtm_id', true ) . ' pageid=' . get_the_ID() . ']');
			  	echo '</div>';
			}
		  	?>
		  	<?php if ( is_single()) { wp_link_pages(); } ?>
		  </div>
			  
  	</article>
  <?php endwhile; ?>
  	<?php get_template_part( 'inc/postformats/post-review' ); ?>
  <?php else : ?>
    <p><?php _e( 'Please add posts from your WordPress admin page.', THB_THEME_NAME ); ?></p>
  <?php endif; ?>
  	<?php get_template_part( 'inc/postformats/post-prevnext' ); ?>
  	<?php get_template_part( 'inc/postformats/post-related' ); ?>
  	<?php get_template_part( 'inc/postformats/post-endbox' ); ?>
  	<!-- Start #comments -->
  	<section id="comments" class="cf">
  	  <?php // comments_template('', true ); ?>
  	</section>
  	<!-- End #comments -->
</section>
  <?php get_sidebar('event'); ?>
</div>
<?php get_footer(); ?>
