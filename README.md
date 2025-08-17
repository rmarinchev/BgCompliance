# Invoice Ninja Module: BgCompliance

**BgCompliance** is a custom module for [Invoice Ninja v5](https://github.com/invoiceninja/invoiceninja), developed by **Perspecta Ltd.**, to help Bulgarian companies stay compliant with invoicing requirements.

It adds a new runtime variable to invoice templates:

- `invoice.amount_in_text` → the total amount written in Bulgarian words (“словом”).

Example: Словом: сто двадесет и пет лева и тридесет стотинки


---

## Features

- ✅ Automatically converts invoice total into Bulgarian words  
- ✅ Works with BGN by default, with simple fallbacks for other currencies  
- ✅ No database changes required  
- ✅ Upgrade-safe (lives entirely in a Laravel module)  
- ✅ Published under the MIT License (open source)

---

## Installation

### 1. Install the module automatically from GitHub

From your Invoice Ninja root directory:

```bash
php artisan module:install rmarinchev/bgcompliance dev-main --type=github
composer dump-autoload
php artisan optimize:clear
```
