<?php
/**
 * WooCommerce Onboarding
 * NOTE: DO NOT edit this file in WooCommerce core, this is generated from woocommerce-admin.
 *
 * @package Woocommerce Admin
 */

/**
 * Contains backend logic for the onboarding profile and checklist feature.
 */
class WC_Admin_Onboarding {
	/**
	 * Class instance.
	 *
	 * @var WC_Admin_Onboarding instance
	 */
	protected static $instance = null;

	/**
	 * Get class instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook into WooCommerce.
	 */
	public function __construct() {
		add_action( 'woocommerce_components_settings', array( $this, 'component_settings' ), 20 ); // Run after WC_Admin_Loader.
		add_filter( 'woocommerce_admin_is_loading', array( $this, 'is_loading' ) );
	}

	/**
	 * Returns true if the profiler should be displayed (not completed and not skipped).
	 *
	 * @return bool
	 */
	public function should_show_profiler() {
		$onboarding_data = get_option( 'wc_onboarding_profile', array() );

		$is_completed = isset( $onboarding_data['completed'] ) && true === $onboarding_data['completed'];
		$is_skipped   = isset( $onboarding_data['skipped'] ) && true === $onboarding_data['skipped'];

		// @todo When merging to WooCommerce Core, we should set the `completed` flag to true during the upgrade progress.
		// https://github.com/woocommerce/woocommerce-admin/pull/2300#discussion_r287237498.
		return $is_completed || $is_skipped ? false : true;
	}

	/**
	 * Add profiler items to component settings.
	 *
	 * @param array $settings Component settings.
	 */
	public function component_settings( $settings ) {
		$settings['onboardingProfile'] = get_option( 'wc_onboarding_profile', array() );
		return $settings;
	}

	/**
	 * Let the app know that we will be showing the onboarding route, so wp-admin elements should be hidden while loading.
	 *
	 * @param bool $is_loading Indicates if the `woocommerce-admin-is-loading` should be appended or not.
	 * @return bool
	 */
	public function is_loading( $is_loading ) {
		$show_profiler = $this->should_show_profiler();
		if ( ! $show_profiler ) {
			return $is_loading;
		}
		return true;
	}
}

new WC_Admin_Onboarding();
