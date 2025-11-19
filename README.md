# Reservation & Admin System – Mvp Note


This is a simple demo of a hotel reservation & admin system.


**User features:**
- Book rooms and make payments via Stripe
- View and manage own bookings
- Access personal dashboard to track reservations and payments


**Admin features:**
- Manage customers and user accounts, including roles and permissions
- Manage all reservations (view, edit, cancel)
- Manage all payments and transactions
- Access admin dashboard with reports and statistics


**Setup (local/demo):**
```bash
git clone <repo-url>
cd <project-folder>
composer install
cp .env.example .env
# edit .env for DB & Stripe
php artisan key:generate
npm install
npm run dev
php artisan migrate --seed
php artisan serve
```
Open at `http://127.0.0.1:8000`

## Test Credentials

For demo purposes, you can use the following accounts:

**Admin Account**  
- Email: test@example.com  
- Password: 1234  

**User Account**  
- Email: any  
- Password: password


**Notes:**
- PUT & DELETE routes may not work on free/limited hosting.
- Booking creation and viewing main features work fine.
- Full Stripe integration requires valid API keys.


**Structure:** `app/` – backend, `resources/` – frontend, `routes/`, `database/`, `public/`
