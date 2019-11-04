<?php
/**
 * GitHub Updater
 *
 * @author    Andy Fragen
 * @license   GPL-2.0+
 * @link      https://github.com/afragen/github-updater
 * @package   github-updater
 */

namespace Fragen\GitHub_Updater;

/*
 * Exit if called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load textdomain.
add_action(
	'init',
	function() {
		load_plugin_textdomain( 'github-updater' );
	}
);

/**
 * Class Bootstrap
 */
class Bootstrap {
	/**
	 * Holds main plugin file.
	 *
	 * @var $file
	 */
	protected $file;

	/**
	 * Holds main plugin directory.
	 *
	 * @var $dir
	 */
	protected $dir;

	/**
	 * Constructor.
	 *
	 * @param  string $file Main plugin file.
	 * @return void
	 */
	public function __construct( $file ) {
		$this->file = $file;
		$this->dir  = dirname( $file );
	}

	/**
	 * Run the bootstrap.
	 *
	 * @return void
	 */
	public function run() {
		if ( ! $this->check_requirements() ) {
			return;
		}

		define( 'GITHUB_UPDATER_DIR', $this->dir );

		// Load Autoloader.
		require_once $this->dir . '/vendor/autoload.php';

		register_activation_hook( $this->file, array( new Init(), 'rename_on_activation' ) );
		( new Init() )->run();
		add_action( 'rest_api_init', [ new REST_API(), 'register_endpoints' ] );

		/**
		 * Initialize Persist Admin notices Dismissal.
		 *
		 * @link https://github.com/collizo4sky/persist-admin-notices-dismissal
		 */
		add_action( 'admin_init', array( 'PAnD', 'init' ) );
	}

	/**
	 * Check PHP requirements and deactivate plugin if not met.
	 *
	 * @return void|bool
	 */
	public function check_requirements() {
		add_action(
			'admin_init',
			function() {
				if ( version_compare( phpversion(), '5.6', '<=' ) ) {
					echo '<div class="error notice is-dismissible"><p>';
					printf(
						/* translators: 1: minimum PHP version required */
						wp_kses_post( __( 'GitHub Updater cannot run on PHP versions older than %1$s.', 'github-updater' ) ),
						'5.6'
					);
					echo '</p></div>';
					\deactivate_plugins( plugin_basename( $this->file ) );

					return false;
				}
			}
		);

		return true;
	}
}
