<?php
/**
 * Plugin Name: Crypay for WooCommerce
 * Plugin URI:  https://github.com/crypay-crypto-pay/crypay-for-woocommerce
 * Description: Accept BTC, ETH, USDC, EURC and other crypto via Crypay payment gateway. Sandbox-ready.
 * Version:     0.1.0
 * Author:      Crypay
 * Author URI:  https://crypay.com
 * License:     MIT
 * Text Domain: crypay-for-woocommerce
 * Requires PHP: 8.0
 * Requires at least: 6.0
 * WC requires at least: 8.0
 * WC tested up to: 9.4
 */

if (!defined('ABSPATH')) exit;

define('CRYPAY_WC_VERSION', '0.1.0');
define('CRYPAY_WC_PLUGIN_FILE', __FILE__);
define('CRYPAY_WC_PLUGIN_DIR', plugin_dir_path(__FILE__));

add_action('plugins_loaded', function () {
  if (!class_exists('WC_Payment_Gateway')) return;
  require_once CRYPAY_WC_PLUGIN_DIR . 'includes/class-wc-gateway-crypay.php';
  add_filter('woocommerce_payment_gateways', function ($gateways) {
    $gateways[] = 'WC_Gateway_Crypay';
    return $gateways;
  });
});

// Webhook endpoint: /?wc-api=wc_gateway_crypay
add_action('woocommerce_api_wc_gateway_crypay', function () {
  require_once CRYPAY_WC_PLUGIN_DIR . 'includes/webhook-handler.php';
  crypay_wc_handle_webhook();
});
