# Admin guide — Crypay for WooCommerce

## Where do I see Crypay payments?

WooCommerce → Orders. Crypay-paid orders show:

- Payment method: **Crypay (Crypto)**
- Order status: `processing` or `completed` once webhook is received
- Custom field `_crypay_payment_id` (the Crypay payment ID)

## How do I refund a Crypay payment?

> ⚠️ Refunds are coming in 0.2.x. For now, refunds must be issued manually via the Crypay merchant dashboard.

## Webhook security

The plugin verifies HMAC-SHA256 signatures on webhooks. Your **Webhook secret** is configured in the Crypay merchant dashboard — copy it into WooCommerce → Settings → Payments → Crypay → **Webhook secret**.

## Reporting

Standard WooCommerce reports (Orders → Reports) include Crypay orders alongside other payment methods.

## Multi-currency

Crypay supports payment in any currency the gateway recognises (BTC, ETH, USDC, EURC, ...). Customers choose at the Crypay payment page; your order remains denominated in your store currency, with the crypto amount shown on the order page.
