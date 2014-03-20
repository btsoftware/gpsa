<?php
/*
Plugin Name: MyMail AmazonSES Integration
Plugin URI: http://rxa.li/mymail
Description: Uses Amazon's Simple Email Service (SES) to deliver emails for the MyMail Newsletter Plugin for WordPress.
This requires at least version 1.3.2 of the plugin
Version: 0.7.0
Author: revaxarts.com
Author URI: http://revaxarts.com
License: GPLv2 or later
*/


define('MYMAIL_AMAZONSES_VERSION', '0.7.0');
define('MYMAIL_AMAZONSES_REQUIRED_VERSION', '1.3.2');
define('MYMAIL_AMAZONSES_ID', 'amazonses');
define('MYMAIL_AMAZONSES_DOMAIN', 'mymail-amazonses');
define('MYMAIL_AMAZONSES_DIR', WP_PLUGIN_DIR.'/mymail-amazon-ses-integration');
define('MYMAIL_AMAZONSES_URI', plugins_url().'/mymail-amazon-ses-integration');
define('MYMAIL_AMAZONSES_SLUG', substr(__FILE__, strlen(WP_PLUGIN_DIR)+1));


add_action('init', 'mymail_amazonses_init');
register_activation_hook(MYMAIL_AMAZONSES_SLUG, 'mymail_amazonses_activation');
register_deactivation_hook(MYMAIL_AMAZONSES_SLUG, 'mymail_amazonses_deactivation');


/**
 * mymail_amazonses_init function.
 * 
 * init the plugin
 *
 * @access public
 * @return void
 */
function mymail_amazonses_init() {


	if (!defined('MYMAIL_VERSION') || version_compare(MYMAIL_AMAZONSES_REQUIRED_VERSION, MYMAIL_VERSION, '>')) {

		add_action('admin_notices', 'mymail_amazonses_notice');
		
	} else {
	
		
		add_filter('mymail_delivery_methods', 'mymail_amazonses_delivery_method');
		add_action('mymail_deliverymethod_tab_amazonses', 'mymail_amazonses_deliverytab');
		

		add_filter('mymail_verify_options', 'mymail_amazonses_verify_options');

		if (mymail_option('deliverymethod') == MYMAIL_AMAZONSES_ID) {
			add_action('mymail_initsend', 'mymail_amazonses_initsend');
			add_action('mymail_presend', 'mymail_amazonses_presend');
			add_action('mymail_dosend', 'mymail_amazonses_dosend');
			add_filter('mymail_subscriber_errors', 'mymail_amazonses_subscriber_errors');

			$endpoint = mymail_option(MYMAIL_AMAZONSES_ID.'_endpoint', 'us-east-1');
		
			define('MYMAIL_AMAZONSES_ENDPOINT', 'email.'.$endpoint.'.amazonaws.com');
			define('MYMAIL_AMAZONSES_SMTP_ENDPOINT', 'email-smtp.'.$endpoint.'.amazonaws.com');
			

		}

		add_action('admin_init', 'mymail_amazonses_settings_scripts_styles');
		add_action('mymail_amazonses_cron', 'mymail_amazonses_getquota');

	}
	
}


/**
 * mymail_amazonses_initsend function.
 * 
 * uses mymail_initsend hook to set initial settings
 *
 * @access public
 * @param mixed $mailobject
 * @return void
 */
function mymail_amazonses_initsend($mailobject) {


	if (mymail_option(MYMAIL_AMAZONSES_ID.'_smtp')) {

		$secure = mymail_option(MYMAIL_AMAZONSES_ID.'_secure', 'tls');

		$mailobject->mailer->Mailer = 'smtp';
		$mailobject->mailer->SMTPSecure = $secure;
		$mailobject->mailer->Host = MYMAIL_AMAZONSES_SMTP_ENDPOINT;
		$mailobject->mailer->Port = $secure == 'tls' ? 587 : 465;
		$mailobject->mailer->SMTPAuth = true;
		$mailobject->mailer->Username = mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_user');
		$mailobject->mailer->Password = mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_pwd');

	} else {
	
		//disable dkim
		$mailobject->dkim = false;
	}
	
}


/**
 * mymail_amazonses_get_header function.
 * 
 * returns the required headers as array
 *
 * @access public
 * @param string $key (default: '')
 * @param string $secret (default: '')
 * @return void
 */
function mymail_amazonses_get_header($key = '', $secret = '') {

	if (!$key) $key = mymail_option(MYMAIL_AMAZONSES_ID.'_access_key');
	if (!$secret) $secret = mymail_option(MYMAIL_AMAZONSES_ID.'_secret_key');

	$date_value = date(DATE_RFC2822);

	$signature = base64_encode(hash_hmac("sha1", $date_value, $secret, true));

	return array(
		'Content-Type' => 'application/x-www-form-urlencoded',
		'Date' => $date_value,
		'X-Amzn-Authorization' => 'AWS3-HTTPS AWSAccessKeyId='.$key.',Algorithm=HmacSHA1,Signature='.$signature,
	);

}


/**
 * mymail_amazonses_subscriber_errors function.
 * 
 * adds a subscriber error
 * @access public
 * @param mixed $mailobject
 * @return $errors
 */
 
 
function mymail_amazonses_subscriber_errors($errors) {
	$errors[] = 'Address blacklisted';
	return $errors;
}


/**
 * mymail_amazonses_presend function.
 * 
 * uses the mymail_presend hook to apply setttings before each mail
 * @access public
 * @param mixed $mailobject
 * @return void
 */
 
 
function mymail_amazonses_presend($mailobject) {
	

	if (mymail_option(MYMAIL_AMAZONSES_ID.'_smtp')) {

		//use pre_send from the main class
		$mailobject->pre_send();

	} else {

		//need the raw email body to send so we use the same option
		$mailobject->pre_send();
		
	}

}


/**
 * mymail_amazonses_dosend function.
 * 
 * uses the ymail_dosend hook and triggers the send
 * @access public
 * @param mixed $mailobject
 * @return void
 */
function mymail_amazonses_dosend($mailobject) {
	
	if (mymail_option(MYMAIL_AMAZONSES_ID.'_smtp')) {

		//use send from the main class
		$mailobject->do_send();
		
	} else {

		$body = mymail_amazonses_generate_body($mailobject);
		
		$response = wp_remote_post( 'https://'.MYMAIL_AMAZONSES_ENDPOINT, array(
			'headers' => mymail_amazonses_get_header(),
			'body' => $body
		));

		$code = wp_remote_retrieve_response_code($response);
		
		if ($code != 200) {
		
			$response = simplexml_load_string(wp_remote_retrieve_body($response));
			$mailobject->set_error($response->Error->Message);
			$mailobject->sent = false;
		
		}else {

			$mailobject->sent = true;
		}
	}
	
}


/**
 * mymail_amazonses_getquota function.
 * 
 * returns the quota of the account or an WP_error if credentials are wrong
 * @access public
 * @param bool $save (default: true)
 * @param string $key (default: '')
 * @param string $secret (default: '')
 * @return void
 */
function mymail_amazonses_getquota($save = true, $key = '', $secret = '') {

	$response = (wp_remote_post( 'https://'.MYMAIL_AMAZONSES_ENDPOINT, array(
			'headers' => mymail_amazonses_get_header($key, $secret),
			'body' => array(
					'Action' => 'GetSendQuota',
			)))
	);

	$code = wp_remote_retrieve_response_code($response);
	$headers = wp_remote_retrieve_headers($response);
	$response = simplexml_load_string(wp_remote_retrieve_body($response));
	

	if ($code != 200) {

		return new WP_Error($code, '['.$response->Error->Code.'] '.$response->Error->Message);

	}else {
		$limits = array(
			'sent' => intval($response->GetSendQuotaResult->SentLast24Hours),
			'limit' => intval($response->GetSendQuotaResult->Max24HourSend),
			'rate' => ceil((1000/intval($response->GetSendQuotaResult->MaxSendRate)*0.1)),
		);

		$limits['sent'] = min($limits['sent'], $limits['limit']);
	}

	if ($save) 	mymail_amazonses_update_limits($limits);
		
	
	return $limits;

}


/**
 * mymail_amazonses_generate_body function.
 * 
 * returns the array to send with the REST API
 * @access public
 * @param mixed $mailobject
 * @return void
 */
function mymail_amazonses_generate_body($mailobject) {

	//et the raw content
	$mailobject->mailer->PreSend();
	$raw_mail = $mailobject->mailer->GetSentMIMEMessage();
	
	$query = array();

	if (is_array($mailobject->to)) {
		$mcnt = 1;
		foreach ($mailobject->to as $recipient) {
			$query["Destinations.member.{$mcnt}"] = $recipient;
			$mcnt++;
		}
	}else {
		$query["Destinations.member.1"] = $mailobject->to;
	}

	$query["Action"] = "SendRawEmail";
	$query["RawMessage.Data"] = base64_encode($raw_mail);

	return $query;

}


/**
 * mymail_amazonses_delivery_method function.
 * 
 * add the delivery method to the options
 * @access public
 * @param mixed $delivery_methods
 * @return void
 */
function mymail_amazonses_delivery_method($delivery_methods) {
	$delivery_methods[MYMAIL_AMAZONSES_ID] = 'AmazonSES';
	return $delivery_methods;
}


/**
 * mymail_amazonses_deliverytab function.
 * 
 * the content of the tab for the options
 * @access public
 * @return void
 */
function mymail_amazonses_deliverytab() {

	$verified = mymail_option(MYMAIL_AMAZONSES_ID.'_verified');
?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">&nbsp;</th>
			<td><p class="description"><?php echo sprintf(__('You need to create %s to work with Amazon SES', MYMAIL_AMAZONSES_DOMAIN), '<a href="https://console.aws.amazon.com/iam/home?#security_credential" class="external">Access Keys</a>'); ?></p>
			<p class="description"><?php echo sprintf(__('You have to %s to send mails to unverified mails', MYMAIL_AMAZONSES_DOMAIN), '<a href="http://aws.amazon.com/ses/fullaccessrequest/" class="external">request Production Access</a>'); ?></p>
</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Amazon AWS Access Key' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><input type="text" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_access_key]" value="<?php echo esc_attr(mymail_option(MYMAIL_AMAZONSES_ID.'_access_key')); ?>" class="regular-text" placeholder="XXXXXXXXXXXXXXXXXXXX"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Amazon AWS Secret Key' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><input type="password" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_secret_key]" value="<?php echo esc_attr(mymail_option(MYMAIL_AMAZONSES_ID.'_secret_key')); ?>" class="regular-text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Endpoint' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td>
			<select name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_endpoint]" >
				<?php $current =  mymail_option(MYMAIL_AMAZONSES_ID.'_endpoint', 'us-east-1');
					$endpoints = array(
						'us-east-1' => 'US East (N. Virginia) Region',
						'us-west-2' => 'US West (Oregon) Region',
						'eu-west-1' => 'EU (Ireland)',
					);
				foreach($endpoints as $endpoint => $name){
				?>
				<option value="<?php echo $endpoint ?>" <?php selected($current == $endpoint); ?>><?php echo $name.' ('.$endpoint.')'; ?></option>
				<?php } ?>
			</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">&nbsp;</th> 
			<td>
				<img src="<?php echo MYMAIL_URI.'/assets/img/icons/'.($verified ? 'green' : 'red').'_2x.png'?>" width="16" height="16">
				<?php echo ($verified) ? __('Your credentials are ok!', MYMAIL_AMAZONSES_DOMAIN) : __('Your credentials are WRONG!', MYMAIL_AMAZONSES_DOMAIN)?>
				<input type="hidden" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_verified]" value="<?php echo $verified?>">
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><?php _e('SMTP' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><label><input type="checkbox" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_smtp]" value="1" <?php checked(mymail_option( MYMAIL_AMAZONSES_ID.'_smtp'), true)?> class="mymail-amazonses-api"> <?php _e('use SMTP', MYMAIL_AMAZONSES_DOMAIN); ?> </label></td>
		</tr>
	</table>
	<div class="amazonses-tab-smtp" <?php if (!mymail_option( MYMAIL_AMAZONSES_ID.'_smtp')) echo ' style="display:none"' ?>>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">&nbsp;</th>
			<td><p class="description"><?php echo sprintf(__('You have to create %s to get your username and password', MYMAIL_AMAZONSES_DOMAIN), '<a href="https://console.aws.amazon.com/ses/home#smtp-settings:" class="external">SMTP credentials</a>'); ?></p>
</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Amazon SES SMTP Username' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><input type="text" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_smtp_user]" value="<?php echo esc_attr(mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_user')); ?>" class="regular-text" placeholder="XXXXXXXXXXXXXXXXXXXX"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Amazon SES SMTP Password' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><input type="password" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_smtp_pwd]" value="<?php echo esc_attr(mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_pwd')); ?>" class="regular-text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Connection' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><label><input type="radio" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_secure]" value="tls" <?php checked(mymail_option( MYMAIL_AMAZONSES_ID.'_secure', 'tls'), 'tls')?>> <?php _e('TLS', MYMAIL_AMAZONSES_DOMAIN); ?></label>
			<label><input type="radio" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_secure]" value="ssl" <?php checked(mymail_option( MYMAIL_AMAZONSES_ID.'_secure'), 'ssl')?>> <?php _e('SSL', MYMAIL_AMAZONSES_DOMAIN); ?></label></td>
		</tr>
	</table>
	</div>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php _e('Update Limits' , MYMAIL_AMAZONSES_DOMAIN) ?></th>
			<td><label><input type="checkbox" name="mymail_options[<?php echo MYMAIL_AMAZONSES_ID ?>_autoupdate]" value="1" <?php checked(mymail_option( MYMAIL_AMAZONSES_ID.'_autoupdate' ), true)?>> <?php _e('auto update send limits (recommended)', MYMAIL_AMAZONSES_DOMAIN); ?> </label></td>
		</tr>
	</table>

<?php

}


/**
 * mymail_amazonses_verify_options function.
 * 
 * some verification if options are saved
 * @access public
 * @param mixed $options
 * @return void
 */
function mymail_amazonses_verify_options($options) {

	if ( $timestamp = wp_next_scheduled( 'mymail_amazonses_cron' ) ) {
		wp_unschedule_event($timestamp, 'mymail_amazonses_cron' );
	}
	//only if deleivermethod is amazonses
	if ($options['deliverymethod'] == MYMAIL_AMAZONSES_ID) {
		$old_user = mymail_option(MYMAIL_AMAZONSES_ID.'_access_key');
		$old_pwd = mymail_option(MYMAIL_AMAZONSES_ID.'_secret_key');
		$old_smtp_user = mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_user');
		$old_smtp_pwd = mymail_option(MYMAIL_AMAZONSES_ID.'_smtp_pwd');
		if ($old_user != $options[MYMAIL_AMAZONSES_ID.'_access_key']
			|| $old_pwd != $options[MYMAIL_AMAZONSES_ID.'_secret_key']
			|| $old_smtp_user != $options[MYMAIL_AMAZONSES_ID.'_smtp_user']
			|| $old_smtp_pwd != $options[MYMAIL_AMAZONSES_ID.'_smtp_pwd']
			|| mymail_option('deliverymethod') != $options['deliverymethod'] || !mymail_option(MYMAIL_AMAZONSES_ID.'_verified') ) {


			$limits = mymail_amazonses_getquota(false, $options[MYMAIL_AMAZONSES_ID.'_access_key'], $options[MYMAIL_AMAZONSES_ID.'_secret_key']);

			if ( is_wp_error($limits) ) {
			
				add_settings_error( 'mymail_options', 'mymail_options', __('An error occurred:<br>', MYMAIL_AMAZONSES_DOMAIN).$limits->get_error_message() );
				$options[MYMAIL_AMAZONSES_ID.'_verified'] = false;
				
			} else {
			
				$options[MYMAIL_AMAZONSES_ID.'_verified'] = true;
				
				if($limits){
					$options['send_limit'] = $limits['limit'];
					$options['send_period'] = 24;
					$options['send_delay'] = $limits['rate'];
					update_option('_transient__mymail_send_period_timeout', $limits['sent'] > 0);
					update_option('_transient__mymail_send_period', $limits['sent']);
				
					add_settings_error( 'mymail_options', 'mymail_options', __('Send limit has been adjusted to your Amazon SES limits', MYMAIL_AMAZONSES_VERSION) );
				}
				
			}

		}

		
		if(isset($options[MYMAIL_AMAZONSES_ID.'_autoupdate'])){
			if ( !wp_next_scheduled( 'mymail_amazonses_cron' ) ) {
				wp_schedule_event( time(), 'hourly', 'mymail_amazonses_cron');
			}
		}
		
		if(function_exists( 'fsockopen' ) && isset($options[MYMAIL_AMAZONSES_ID.'_smtp'])){
			$host = 'email-smtp.us-east-1.amazonaws.com';
			$port = $options[MYMAIL_AMAZONSES_ID.'_secure'] == 'tls' ? 587 : 465;
			$conn = fsockopen($host, $port, $errno, $errstr, 5);
			
			if(is_resource($conn)){
				
				fclose($conn);
				
			}else{
				
				add_settings_error( 'mymail_options', 'mymail_options', sprintf(__('Not able to use Amazon SES via SMTP cause of the blocked port %s! Please try a different connection, send without SMTP or choose a different delivery method!', MYMAIL_AMAZONSES_DOMAIN), $port) );
				
			}
		}
		

	}
	
	return $options;
}


/**
 * mymail_amazonses_update_limits function.
 * 
 * Update the limits
 * @access public
 * @return void
 */
function mymail_amazonses_update_limits($limits) {
	mymail_update_option('send_limit', $limits['limit']);
	mymail_update_option('send_period', 24);
	mymail_update_option('send_delay', $limits['rate']);
	
	//always reset to 24 hours
	update_option('_transient__mymail_send_period_timeout', $limits['sent'] > 0);
	update_option('_transient__mymail_send_period', $limits['sent']);
}


/**
 * mymail_amazonses_notice function.
 * 
 * Notice if MyMail is not avaiable
 * @access public
 * @return void
 */
function mymail_amazonses_notice() {
?>
<div id="message" class="error">
  <p>
   <strong>AmazonSES integration for MyMail</strong> requires the <a href="http://rxa.li/mymail?utm_source=AmazonSES+integration+for+MyMail">MyMail Newsletter Plugin</a>, at least version <strong><?php echo MYMAIL_AMAZONSES_REQUIRED_VERSION?></strong>. Plugin deactivated.
  </p>
</div>
	<?php
}


/**
 * mymail_amazonses_settings_scripts_styles function.
 * 
 * some scripts are needed
 * @access public
 * @return void
 */
function mymail_amazonses_settings_scripts_styles() {
	global $pagenow;
	
	if($pagenow == 'options-general.php' && isset($_REQUEST['page']) && $_REQUEST['page'] == 'newsletter-settings'){

		wp_register_script('mymail-amazonses-settings-script', MYMAIL_AMAZONSES_URI . '/js/script.js', array('jquery'), MYMAIL_AMAZONSES_VERSION);
		wp_enqueue_script('mymail-amazonses-settings-script');
		
	}

}


/**
 * mymail_amazonses_activation function.
 * 
 * actication function
 * @access public
 * @return void
 */
function mymail_amazonses_activation() {

	if (defined('MYMAIL_VERSION') && version_compare(MYMAIL_AMAZONSES_REQUIRED_VERSION, MYMAIL_VERSION, '<=')) {
		mymail_notice(sprintf(__('Change the delivery method on the %s!', MYMAIL_AMAZONSES_DOMAIN), '<a href="options-general.php?page=newsletter-settings&mymail_remove_notice=mymail_delivery_method#delivery">Settings Page</a>'), '', false, 'delivery_method');
		
		if ( !wp_next_scheduled( 'mymail_amazonses_cron' ) ) {
			wp_schedule_event( time(), 'hourly', 'mymail_amazonses_cron');
		}
	}
	
}


/**
 * mymail_amazonses_deactivation function.
 * 
 * deactication function
 * @access public
 * @return void
 */
function mymail_amazonses_deactivation() {

	if (defined('MYMAIL_VERSION') && version_compare(MYMAIL_AMAZONSES_REQUIRED_VERSION, MYMAIL_VERSION, '<=')) {
		if(mymail_option('deliverymethod') == MYMAIL_AMAZONSES_ID){
			mymail_update_option('deliverymethod', 'simple');
			mymail_notice(sprintf(__('Change the delivery method on the %s!', MYMAIL_AMAZONSES_DOMAIN), '<a href="options-general.php?page=newsletter-settings&mymail_remove_notice=mymail_delivery_method#delivery">Settings Page</a>'), '', false, 'delivery_method');
		}
		
		if ( $timestamp = wp_next_scheduled( 'mymail_amazonses_cron' ) ) {
			wp_unschedule_event($timestamp, 'mymail_amazonses_cron' );
		}
	}
	
}


?>