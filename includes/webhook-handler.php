<?php
if (!defined('ABSPATH')) exit;

function crypay_wc_handle_webhook() {
  $payload = file_get_contents('php://input');
  $data    = json_decode($payload, true);

  if (empty($data['reference']) || !preg_match('/^WC-(\d+)$/', $data['reference'], $m)) {
    status_header(400);
    echo 'invalid reference';
    exit;
  }

  $order = wc_get_order((int) $m[1]);
  if (!$order) {
    status_header(404);
    echo 'order not found';
    exit;
  }

  // TODO: HMAC signature verification (CRY-784 Phase 2)
  // $expected = hash_hmac('sha256', $payload, $webhook_secret);
  // if (!hash_equals($expected, $_SERVER['HTTP_X_CRYPAY_SIGNATURE'] ?? '')) { ... }

  switch ($data['state'] ?? '') {
    case 'SUCCESS':
      $order->payment_complete($data['transactionId'] ?? '');
      $order->add_order_note('Crypay: payment confirmed');
      break;
    case 'FAILED':
    case 'CANCELLED':
      $order->update_status('failed', 'Crypay: payment ' . strtolower($data['state']));
      break;
  }

  status_header(200);
  echo 'ok';
}
