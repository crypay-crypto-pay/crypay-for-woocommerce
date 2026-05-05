<?php
if (!defined('ABSPATH')) exit;

class WC_Gateway_Crypay extends WC_Payment_Gateway {
  public function __construct() {
    $this->id                 = 'crypay';
    $this->icon               = 'https://crypay.com/images/crypay-logo.svg';
    $this->has_fields         = false;
    $this->method_title       = 'Crypay (Crypto)';
    $this->method_description = 'Accept BTC, ETH, USDC, EURC and other cryptocurrencies via the Crypay gateway.';
    $this->supports           = ['products', 'refunds'];

    $this->init_form_fields();
    $this->init_settings();

    $this->title       = $this->get_option('title');
    $this->description = $this->get_option('description');
    $this->api_key     = $this->get_option('api_key');
    $this->gateway_url = $this->get_option('gateway_url', 'https://gateway.dev.crypay.com');
    $this->sandbox     = 'yes' === $this->get_option('sandbox');

    add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
  }

  public function init_form_fields() {
    $this->form_fields = [
      'enabled' => [
        'title'   => 'Enable',
        'type'    => 'checkbox',
        'label'   => 'Enable Crypay payment method',
        'default' => 'yes',
      ],
      'title' => [
        'title'       => 'Title',
        'type'        => 'text',
        'description' => 'Title customers see at checkout.',
        'default'     => 'Pay with crypto (Crypay)',
        'desc_tip'    => true,
      ],
      'description' => [
        'title'   => 'Description',
        'type'    => 'textarea',
        'default' => 'Pay securely with BTC, ETH, USDC, EURC and other cryptocurrencies. You will be redirected to Crypay to complete the payment.',
      ],
      'api_key' => [
        'title'       => 'API key',
        'type'        => 'password',
        'description' => 'Your Crypay merchant API key.',
        'default'     => '',
      ],
      'gateway_url' => [
        'title'       => 'Gateway URL',
        'type'        => 'text',
        'description' => 'Crypay gateway base URL. Use https://gateway.dev.crypay.com for testnet.',
        'default'     => 'https://gateway.dev.crypay.com',
      ],
      'sandbox' => [
        'title'   => 'Sandbox mode',
        'type'    => 'checkbox',
        'label'   => 'Use Crypay testnet (no real funds)',
        'default' => 'yes',
      ],
    ];
  }

  public function process_payment($order_id) {
    $order = wc_get_order($order_id);
    $body  = [
      'amount'   => (float) $order->get_total(),
      'currency' => $order->get_currency(),
      'reference'=> 'WC-' . $order->get_id(),
      'redirect' => $this->get_return_url($order),
      'webhook'  => add_query_arg('wc-api', 'wc_gateway_crypay', home_url('/')),
      'customer' => [
        'email' => $order->get_billing_email(),
      ],
    ];

    $resp = wp_remote_post($this->gateway_url . '/api/v1/payments', [
      'headers' => ['Content-Type' => 'application/json', 'X-API-Key' => $this->api_key],
      'body'    => wp_json_encode($body),
      'timeout' => 20,
    ]);

    if (is_wp_error($resp)) {
      wc_add_notice('Crypay gateway unreachable: ' . $resp->get_error_message(), 'error');
      return ['result' => 'failure'];
    }

    $data = json_decode(wp_remote_retrieve_body($resp), true);
    if (empty($data['url'])) {
      wc_add_notice('Crypay: invalid response — no payment URL', 'error');
      return ['result' => 'failure'];
    }

    $order->update_status('on-hold', 'Crypay payment created — awaiting customer payment.');
    $order->update_meta_data('_crypay_payment_id', $data['id'] ?? '');
    $order->save();

    return ['result' => 'success', 'redirect' => $data['url']];
  }
}
