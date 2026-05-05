# Installation guide — Crypay for WooCommerce

## Prerequisites

- WordPress 6.0 or newer
- WooCommerce 8.0 or newer
- PHP 8.0 or newer
- A Crypay merchant account ([sign up](https://crypay.com/signup))
- A Crypay API key (Dashboard → API Keys)

## Step 1 — Download

Two ways:

### Option A — ZIP from GitHub Releases (recommended for production)

1. Open https://github.com/crypay-crypto-pay/crypay-for-woocommerce/releases
2. Download the latest `crypay-for-woocommerce-vX.Y.Z.zip`

### Option B — `git clone` (recommended for development)

```bash
cd wp-content/plugins/
git clone https://github.com/crypay-crypto-pay/crypay-for-woocommerce.git
```

## Step 2 — Activate

1. Log in to your WordPress admin.
2. Plugins → **Crypay for WooCommerce** → **Activate**.
3. WooCommerce → Settings → Payments — you should see **Crypay (Crypto)** in the list.

## Step 3 — Configure

Open **Crypay (Crypto)** settings and fill in:

| Field | Value |
|---|---|
| Title | The label customers see at checkout (e.g. "Pay with crypto") |
| Description | Short description below the title |
| API key | From https://app.crypay.com/keys |
| Gateway URL | `https://gateway.crypay.com` (production) or `https://gateway.dev.crypay.com` (testnet) |
| Sandbox mode | ✅ for testing, ❌ for production |

Save.

## Step 4 — Test

1. Set **Gateway URL** to the testnet URL.
2. Place a test order in your store.
3. Choose **Crypay** at checkout.
4. You should be redirected to the Crypay payment page, where you can simulate a payment.
5. After 30 seconds the testnet auto-confirms; you return to the order success page and the order is marked **completed** in WooCommerce admin.

## Troubleshooting

| Symptom | Likely cause | Fix |
|---|---|---|
| "Crypay gateway unreachable" | wrong Gateway URL or firewall | check URL spelling; ensure outbound HTTPS |
| Order stuck in **on-hold** | webhook not delivered | check Gateway dashboard → Webhooks tab; ensure your site is reachable |
| 401 from gateway | API key invalid | re-copy from Dashboard; check whitespace |

## Need help?

- GitHub issues: https://github.com/crypay-crypto-pay/crypay-for-woocommerce/issues
- Email support: support@crypay.com
