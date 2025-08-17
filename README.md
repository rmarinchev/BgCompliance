# Invoice Ninja Module: BgCompliance

**BgCompliance** is a custom module for [Invoice Ninja v5](https://github.com/invoiceninja/invoiceninja), developed by **Perspecta Ltd.**, to help Bulgarian companies stay compliant with invoicing requirements.

It adds a new runtime variable to invoice templates:

- `invoice.amount_in_text` → the total amount written in Bulgarian words (“словом”).

Example: Словом: сто двадесет и пет лева и тридесет стотинки

---

## Features

- ✅ Automatically converts invoice total into Bulgarian words
- ✅ Works with BGN
- ✅ No database changes required
- ✅ Upgrade-safe (lives entirely in a Laravel module)
- ✅ Published under the MIT License (open source)

---

## Installation

### 1. Install the module manually

From your Invoice Ninja root directory (`/var/www/html`):

```bash
# Create the Modules directory in your Invoice Ninja root
mkdir -p /var/www/html/Modules

# Clone the module into the Modules directory
git clone https://github.com/rmarinchev/bgcompliance.git /var/www/html/Modules/BgCompliance

# Set proper permissions
chown -R www-data:www-data /var/www/html/Modules
find /var/www/html/Modules -type d -exec chmod 755 {} \;
find /var/www/html/Modules -type f -exec chmod 644 {} \;

# Navigate to Invoice Ninja directory and refresh autoloader first
cd /var/www/html
sudo -u www-data composer dump-autoload

# Enable the module
php artisan module:enable BgCompliance
sudo -u www-data php artisan optimize:clear
```


### 2. Update the module

To update the module to the latest version:

```bash
# Navigate to the module directory
cd /var/www/html/Modules/BgCompliance

# Fix Git ownership issue (if you get "dubious ownership" error)
git config --global --add safe.directory /var/www/html/Modules/BgCompliance

# Pull the latest changes
git pull origin main

find /var/www/html/Modules -type d -exec chmod 755 {} \;
find /var/www/html/Modules -type f -exec chmod 644 {} \;

# Navigate back to Invoice Ninja root and refresh
cd /var/www/html
sudo -u www-data composer dump-autoload
sudo -u www-data php artisan optimize:clear
```


### 3. Usage in Templates

Add the Bulgarian amount in words to your invoice templates using either of these methods:

#### Method 1: Using the Twig function
```twig
{{ amount_in_text(invoice) }}
```

#### Method 2: Using the invoice property (if available)
```twig
{{ invoice.amount_in_text }}
```

Both methods will return the hardcoded string 'works' for now, which can be extended later to convert the actual invoice amount to Bulgarian words.

