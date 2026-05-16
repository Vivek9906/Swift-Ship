# Logistics & Delivery Tracking Portal

Laravel 11 MVC CRM-style portal for managing shipments end-to-end. It uses MongoDB-backed Eloquent models, Blade + Tailwind + Alpine, Chart.js dashboards, Leaflet live maps, queued shipment pings, broadcast shipment events, role middleware, policies, and database/broadcast notifications.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run dev
php artisan db:seed
php artisan serve
```

Open `http://127.0.0.1:8000` and sign in with:

```text
admin@logistics.test
password
```

## Realtime And Queues

Use Laravel Reverb for local WebSockets:

```bash
php artisan reverb:start
php artisan queue:work
php artisan schedule:work
```

The scheduler dispatches `UpdateShipmentLocation` every minute for active shipments. Status changes broadcast `ShipmentStatusUpdated` on `shipment.{id}` and delayed shipments create database plus broadcast notifications for admin and manager users.

## Roles

Seeded users:

- Admin: `admin@logistics.test`
- Managers: `riya.manager@logistics.test`, `arjun.manager@logistics.test`
- Viewers: `meera.viewer@logistics.test`, `kabir.viewer@logistics.test`

All seeded passwords are `password`.

## Main Modules

- Dashboard KPIs, Chart.js volume/status charts, live simulated activity feed, recent shipment table
- Shipments CRM table with search, filters, sorting, pagination, CSV export, bulk delivery updates, carrier reassignment, and modal creation
- Shipment detail with metadata, tracking timeline, Leaflet route map, animated destination-city marker, customer profile panel
- Live tracking map with auto-refreshed active shipment markers and synced sidebar
- Customer CRM with profile, shipment history, stats, notes, add/edit modal
- Carrier performance pages with progress bars and Chart.js trend
- Alerts panel with database notifications, realtime-ready counter, resolved/snooze actions, simulated feed
- Settings page with company profile, notification preferences, roles, and theme toggle in the shell

## Optional Breeze Install

This repo includes a minimal Breeze-compatible session controller so the seeded demo can run immediately. To replace it with full Laravel Breeze screens:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
```
