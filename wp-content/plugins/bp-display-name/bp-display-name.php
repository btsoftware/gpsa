<?php
/**
 * Plugin Name: BP Display Name
 * Plugin URI:  http://scenicjobs.com/wordpress-plugins
 * Description: Makes Display Name universal Sitewide. Choose "Username", "First Name", "Last Name", "First and Last Name", or "Nickname" as Displayname. Currently working with Wordpress, BuddyPress, and BuddyBoss. 
 * Author:      ScenicJobs.com
 * Version:     1.0
 * Author URI:  http://scenicjobs.com/wordpress-plugins
 */

class BP_Display_Name {
	
	public function __construct() {
		add_action('bp_init', array($this,'init'));
	}
	
	function init() {
		global $bp,$current_user;
		add_action('bp_displayed_user_fullname', array($this,'displayed_user'));
		add_action('bp_member_name', array($this,'member'));
		add_action( bp_core_admin_hook(), array($this, 'add_admin_menu'), 25 );

	}
	
	function displayed_user( $default ) {
		global $bp;
		$bp->displayed_user->userdata->id = $bp->displayed_user->userdata->ID;
		return $this->build_username( $bp->displayed_user->userdata, $default);
	}
	
	function member() {
		global $members_template;
		return $this->build_username( $members_template->member, $members_template->member->fullname);
	}
	
	function build_username($user, $default) {
		$name = '';
		$name_type = get_option( 'bp_display_name_type' );
		
		switch( $name_type ) {
			case 'first_last_name':
				$f_name = get_user_meta($user->id,'first_name',true);
				$l_name = get_user_meta($user->id,'last_name',true);
				$name = $f_name . " " . $l_name;
				break;
			
			case 'username':
				$name = $user->user_login;
				break;
			
			case 'nickname':
				$name = get_user_meta($user->id,'nickname',true);
				break;
			
			case 'first_name':
				$name = get_user_meta($user->id,'first_name',true);
				break;
			
			case 'last_name':
				$name = get_user_meta($user->id,'last_name',true);
				break;
		}
		
		return ( $name != '' ) ? $name : $default;
	}
	
	
	function add_admin_menu() {
		global $bp;
		if ( !is_super_admin() )
			return false;
		$hook = add_submenu_page( 'bp-general-settings', __( 'BP Display Name', 'buddypress' ), __( 'BP Display Name', 'buddypress' ), 'manage_options', 'bp-display-name', array($this,'admin_screen') );
        add_action( "admin_print_styles-$hook", 'bp_core_add_admin_menu_styles' );
	}

	
	function admin_screen() {
		if ( isset( $_POST['submit'] ) ) {
			update_option( 'bp_display_name_type', $_POST['name-type'] );
			$updated = true;
		}
		$name_type = get_option( 'bp_display_name_type' );
		$types = array(
			'username' => 'Username',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'first_last_name' => 'First and Last Name',
			'nickname' => 'Nickname'
		);
		
		?>    
		<div class="wrap">

			<?php screen_icon( 'buddypress' ); ?>

		<h2><?php _e( 'BP Display Name', 'buddypress' ) ?></h2>
		<br />
		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'buddypress' ) . "</p></div>" ?><?php endif; ?>
		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp-display-name' ?>" name="bpdn-settings-form" id="bpdn-settings-form" method="post">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="target_uri"><?php _e( 'Display name publicly as', 'buddypress' ) ?></label></th>
						<td>
							<select name="name-type" id="name-type">
								<?php foreach($types as $type => $type_full):?>
									<option value="<?php echo $type?>" <?php selected($type,$name_type)?>><?php echo $type_full?></option>
								<?php endforeach;?>
							</select>
						</td>
				</table>
				<p class="submit">
						<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'buddypress' ) ?>"/>
				</p>
		</form>

		</div>	
	<?php
	}


}

$BP_Display_Name = new BP_Display_Name();