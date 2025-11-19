# Reservation & Admin System – Demo Note


This is a simple demo of a food reservation & admin system.


**User features:**
- Book meals & food slots
- Manage & cancel reservations
- View payment history


**Admin features:**
- Manage users, reservations & payments
- Stripe payment integration
- View reports & stats


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


**Notes:**
- PUT & DELETE routes may not work on free/limited hosting.
- Booking creation and viewing main features work fine.
- Full Stripe integration requires valid API keys.


**Structure:** `app/` – backend, `resources/` – frontend, `routes/`, `database/`, `public/`
