<?php
/**
 * Plugin Name: Pootle - My account
 * Plugin URI: https://www.pootlepress.com/
 * Description: Creates a cool accounts page for showing WC - API Manager and non WC - API Manager downloadable products and other info in a cozy tabbed navigation.
 * Version: 0.7
 * Author: shramee
 * Author URI: https://www.shramee.com
 *
 * @developer shramee<shramee.srivastav@gmail.com>
 * At: 2:43 PM 4/8/15
 */

class Pootle_My_Account {
	/**
	 * @var Pootle_My_Account The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * Get Pootle_My_Account instance
	 * @return Pootle_My_Account Instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) && ! is_object( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 */
	private function __clone() {}

	private function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WooCommerce_API_Manager' ) ) {
			return;
		}

		// Display Update API Manager data on a User's account page
		add_action( 'woocommerce_before_my_account', function () {
			ob_start();
		}, 7 );
		add_filter( 'woocommerce_my_account_my_address_title', function ( $title ) {
			?>
			</div>
			<div class="pmac-address tab tab-another-tab">
			<?php
			return $title;
		}, 7 );
		add_action( 'woocommerce_before_my_account', array( $this, 'before_my_account' ), 20 );
		add_action( 'woocommerce_after_my_account', array( $this, 'after_my_account' ), 999 );
	}

	public function before_my_account() {
		ob_end_clean();
		echo '<div style="display: none;">' . do_shortcode( '[tabs style="boxed"][/tabs]' ) . '</div>';
		?>
		<style>
			.digital-downloads,
			.pmac-downloads .digital-downloads ~ h2:first-child{
				display: none;
			}
			.pmac-downloads .digital-downloads {
				display: block;
			}
			.pootle-my-account-tabs h2 {
				margin: 0;
			}
		</style>
		<div class="pootle-my-account-tabs shortcode-tabs boxed">
			<ul class="tab_titles">
				<li class="nav-tab"><a href="#tab-1">My Downloads</a></li>
				<li class="nav-tab"><a href="#tab-2">My Licenses</a></li>
				<li class="nav-tab"><a href="#tab-3">My Orders</a></li>
				<li class="nav-tab"><a href="#tab-4">My Details</a></li>
			</ul>
			<div class="pmac-downloads tab tab-first-tab">
				<?php
				wc_get_template( 'tpl-my-downloads.php', array(), '', plugin_dir_path( __FILE__ ) );
				?>
			</div>
			<div class="pmac-license tab tab-another-tab">
				<?php
				$user_id = get_current_user_id();
				wc_get_template( 'my-api-keys.php', array( 'user_id' => $user_id ), '', WCAM()->plugin_path() . '/templates/' );
				?>
			</div>
			<div class="pmac-orders tab tab-another-tab">

		<?php
	}

	public function after_my_account() {
		?>
			</div>

			<div class="fix"></div><!--/.fix-->
		</div><!--/.tabs-->
		<?php
	}
}

Pootle_My_Account::instance();