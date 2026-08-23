# CFC Media Hub — Drupal app

A Drupal 11 site for booking spaces (Desk, Meeting Room, Studio) at CFC Media Hub.

This repo already includes `vendor/` and `web/core/` (Drupal core + all
dependencies), so you do **not** need to run `composer install` to get
started — just clone and follow one of the two setups below.

No database dump is included. A fresh install automatically creates the
demo content (spaces, etc.) through the custom modules' install hooks, so
you don't need one.

---

## Option A — Docker (recommended, easiest)

**Requirements:** Docker Desktop.

```bash
git clone https://github.com/YassineGhilani/CFC-Booking.git drupal
cd drupal
docker compose up -d --build
```

Then install Drupal and turn on the custom modules/theme:

```bash
docker compose exec php vendor/bin/drush site:install standard -y \
  --account-name=admin --account-pass=admin

docker compose exec php vendor/bin/drush pm:enable cfc_pages cfc_booking cfc_content cfc_payment cfc_account -y
docker compose exec php vendor/bin/drush theme:enable cfc_media_hub -y
docker compose exec php vendor/bin/drush config-set system.theme default cfc_media_hub -y
docker compose exec php vendor/bin/drush cache:rebuild
```

- Site: **http://localhost:8080**
- Adminer (database UI): **http://localhost:8081** (server: `db`, user/password/database: `drupal`)
- Admin login: username `admin`, password `admin` (change it in `/user`)

That's it — no PHP, Composer or MySQL install needed on your machine, Docker handles all of it.

---

## Option B — Laragon (or any local PHP + MySQL server)

**Requirements:** PHP 8.3+ with the `gd`, `pdo_mysql`, `mysqli`, `zip`, `intl` extensions (Laragon lets you switch PHP versions easily), and MySQL/MariaDB running.

1. **Clone the repo** into your Laragon `www` folder:
   ```bash
   git clone https://github.com/YassineGhilani/CFC-Booking.git drupal
   ```

2. **Create a database** (any name works, e.g. `drupal`) using Laragon's HeidiSQL or phpMyAdmin.

3. **Edit `web/sites/default/settings.php`** — scroll to the bottom, find this block:
   ```php
   $databases['default']['default'] = array (
     'database' => 'drupal',
     'username' => 'drupal',
     'password' => 'drupal',
     'prefix' => '',
     'host' => 'db',
     'port' => 3306,
     ...
   );
   ```
   Change `'host' => 'db'` to `'host' => 'localhost'`, and update `database`/`username`/`password` to match what you created in step 2 (Laragon's default MySQL user is usually `root` with an empty password).

4. **Point your Laragon virtual host at `drupal/web`** — that's Drupal's docroot, not the repo root. In Laragon: right-click the site → "www" folder should map to the `web` subfolder, or set up a custom vhost pointing there.

5. **Install Drupal** (open a terminal in the `drupal` folder):
   ```bash
   php vendor/bin/drush site:install standard -y \
     --account-name=admin --account-pass=admin

   php vendor/bin/drush pm:enable cfc_pages cfc_booking cfc_content cfc_payment cfc_account -y
   php vendor/bin/drush theme:enable cfc_media_hub -y
   php vendor/bin/drush config-set system.theme default cfc_media_hub -y
   php vendor/bin/drush cache:rebuild
   ```

6. Open the site at whatever local URL Laragon gave the vhost (e.g. `http://cfc-booking.test`).

---

## Copying the database from Docker to Laragon (optional)

If you already have data in the Docker database and want to bring it over instead of reinstalling fresh:

```bash
docker compose exec db mariadb-dump -u drupal -pdrupal drupal > drupal_export.sql
```

Then import `drupal_export.sql` into your Laragon database via HeidiSQL's Import, or:

```bash
mysql -u root -h localhost drupal < drupal_export.sql
```

You still need to do step 3 above (`settings.php`) — importing the database doesn't replace that.

---

## Notes

- **Stripe payments** (Studio booking) need your own Stripe test API keys, configured in Drupal's admin UI (`/admin/config/services/stripe` once the `stripe` module is enabled) — they aren't included in this repo.
- `settings.php` and its `hash_salt` are committed for convenience in this dev setup — fine for local development, just don't reuse them for anything public-facing.
