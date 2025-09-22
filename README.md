# BorrowMyCharger — README

Web application for **peer-to-peer EV charger sharing**.  
Users can register, list their private EV charge points, and browse available chargers in their area via an interactive map.

> **Tech stack:** Plain PHP 8.x, MySQL 8.x, Composer (autoload + dotenv), basic HTML/CSS/Bootstrap for views.  
> No framework is used — lightweight MVC structure with `Model/`, `View/`, and controllers.

---

## Features

- **User authentication system**  
  - Secure registration with server-side validation.  
  - Passwords hashed with PHP’s `password_hash()` and verified with `password_verify()`.  
  - Session-based login/logout management.  

- **Charge point listing and management**  
  - Add, view, and search EV charge points.  
  - Store charger details: address, postcode, cost per kWh, latitude & longitude.  
  - Relational mapping between users and their listed chargers (foreign key constraints).  

- **Interactive map integration**  
  - Frontend integration with a mapping/geolocation API (e.g., Google Maps/Leaflet).  
  - Dynamically display available charge points on the map using stored coordinates.  

- **Profile management**  
  - User profile creation with optional profile photo upload.  
  - Image validation (format/size restrictions) and secure storage in the `Images/` folder.  

- **MVC-inspired architecture**  
  - `Model/` classes for DB access and data encapsulation (`UserDataSet`, `Database`, `UserData`).  
  - `View/` templates for presentation (Bootstrap-based UI).  
  - Lightweight controllers for request handling (`loginController.php`, `registrationController.php`).  
  - Autoloading via Composer to keep the code modular and organized.  

- **Environment-based configuration**  
  - `.env.local` file for DB credentials and secrets.  
  - Centralized database connection via `Database.php` singleton.  

- **Database management**  
  - SQL dump file (`borrowmycharger_dump.sql`) to recreate schema + demo data.  
  - Normalized schema with relations between `users` and `charge_points`.  

---

## Repository layout (key folders)

```
Model/             # Database.php, User.php, UserData.php, UserDataSet.php, etc.
View/              # Templates (header, navbar, login.phtml, registration.phtml, etc.)
Images/            # Uploaded profile pictures and app assets
borrowmycharger_dump.sql  # Database schema + demo data
index.php          # Front controller
autoloader.php     # Class autoload + dotenv loader
registrationController.php
loginController.php
```

---

## Prerequisites

- **PHP 8.1+** with `pdo_mysql` enabled  
- **MySQL 8.x** (or compatible MariaDB)  
- **Composer 2.6+**

Verify with:

```bash
php -v
mysql --version
composer --version
```

---

## Local setup

```bash
git clone <your-repo-url>.git
cd borrowmycharger

# 1) Install PHP dependencies (dotenv, etc.)
composer install

# 2) Configure environment
cp .env.local.example .env.local
# Edit .env.local:
# DB_HOST=127.0.0.1
# DB_NAME=borrowmycharger
# DB_USER=root
# DB_PASS=your_mysql_password

# 3) Create database and import schema + demo data
mysql -u root -p -e "CREATE DATABASE borrowmycharger CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p borrowmycharger < borrowmycharger_dump.sql

# 4) Run the dev server
php -S 127.0.0.1:8080
```

Open your browser at:  
http://127.0.0.1:8080

---

## Configuration

`.env.local` — holds DB connection values. Example:

```env
DB_HOST=127.0.0.1
DB_NAME=borrowmycharger
DB_USER=root
DB_PASS=your_mysql_password
```

Passwords are hashed using PHP’s `password_hash()` and validated with `password_verify()`.

---

## Database dump file

The included `borrowmycharger_dump.sql` contains:

- **users** table with a sample user.  
- **charge_points** table with one demo charger.  

### Common tasks

```bash
# Import DB dump again (reset DB)
mysql -u root -p borrowmycharger < borrowmycharger_dump.sql

# Remove and reinstall dependencies
rm -rf vendor/ composer.lock
composer install
```

---

## Testing

Try logging in with the sample user in the dump:

- **Email:** lee@lee.com  
- **Password:** (set during registration OR update manually in DB)  

Or register a new account via the app.

---

## Security notes

- Never commit `.env.local` with real credentials.  
- Use strong MySQL passwords.  
- Restrict file uploads to safe formats (images only).  

---

## Troubleshooting

- **Incorrect login details** → ensure passwords in DB are hashed properly.  
- **DB connection errors** → check `.env.local` values and MySQL service.  
- **App crashes on registration** → confirm tables match the dump (`users`, `charge_points`).  

---

## Authorship & Contact
Developed by **Jose Wong**  
j.wong@mail.com  
https://www.linkedin.com/in/jose-wongg  
https://github.com/JoseWongg  

## License
MIT — see the [LICENSE](LICENSE) file for details.
