# Crypay for WooCommerce

Accept BTC, ETH, USDC, EURC and other cryptocurrencies in your WooCommerce store via the [Crypay](https://crypay.com) payment gateway.

> ⚠️ This plugin is under active development as part of [CRY-784](https://mng.crypay.com/CRY/issues/CRY-784).
> Skeleton committed by Board for the BG agent to extend with HMAC verification, refunds, partial payments.

## Demo

Live demo store: https://woo-demo.crypay.com — explore the checkout end-to-end with a sandboxed Crypay testnet gateway. Demo store data resets every 30 minutes.

## Compatibility

| Plugin | WordPress | WooCommerce | PHP |
|---|---|---|---|
| 0.1.x | 6.0 – 6.6 | 8.0 – 9.4 | 8.0+ |

## Install

1. Download the latest release ZIP from [GitHub Releases](https://github.com/crypay-crypto-pay/crypay-for-woocommerce/releases) (or `git clone` this repo into `wp-content/plugins/crypay-for-woocommerce/`).
2. In WordPress admin → **Plugins → Add New → Upload Plugin** → choose the ZIP → Install → Activate.
3. Go to **WooCommerce → Settings → Payments → Crypay (Crypto)**.
4. Enter your **API key** (get it at https://app.crypay.com/keys) and the **Gateway URL**:
   - Production: `https://gateway.crypay.com`
   - Testnet (sandbox): `https://gateway.dev.crypay.com`
5. Tick **Enable** and save. Crypay now appears at checkout.

## How it works

```
Customer ─ checkout ─▶ WooCommerce
                        │
                        │ create payment
                        ▼
                    Crypay Gateway ─ payment URL ─▶ Customer browser
                        │
                        │ customer pays in crypto
                        │
                        ▼
                    Webhook ─▶ /?wc-api=wc_gateway_crypay
                                   │
                                   ▼
                              Order marked `completed`
```

## License

MIT — see [LICENSE](LICENSE).

## Links

- [Crypay homepage](https://crypay.com)
- [Crypay API docs](https://api.crypay.com/docs) (CRY-765)
- [Other modules](https://crypay.com/downloads/) — PrestaShop, Magento, OpenCart, Shopify, drop-in PHP
- [Issue tracker / Board](https://mng.crypay.com/CRY/issues/CRY-783)
