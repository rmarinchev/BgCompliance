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

### 1. Install the module manually

From your Invoice Ninja root directory:

```bash
# Create the Modules directory if it doesn't exist
mkdir -p Modules

# Clone the module into the Modules directory
git clone https://github.com/rmarinchev/bgcompliance.git Modules/BgCompliance

# Enable the module and refresh autoloader
php artisan module:enable BgCompliance
composer dump-autoload
php artisan optimize:clear
```
