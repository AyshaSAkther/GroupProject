# Donation & Fundraising Platform

**CIS 344 Group Project | Spring 2026 | Lehman College, CUNY**

A full-stack web application that connects donors with meaningful causes. Users can register, log in, create fundraising campaigns, donate to campaigns, and review their donation history.

---

## Team Members

- Aysha Syeda Akther
- Ahmed Huzaifa
- Zamzam

**Professor:** Yanilda Peralta Ramos

---

## Features

- **User Authentication** — Secure registration, login, and logout using PHP sessions and bcrypt password hashing
- **Campaign Management** — Create and browse fundraising campaigns
- **Donation System** — Donate to any campaign with real-time progress tracking (goal, raised, remaining)
- **Donation History** — View a full ledger of all donations across all donors and campaigns
- **Security** — Prepared statements (no SQL injection), password_hash/password_verify, XSS output encoding

---

## Technology Stack

| Layer      | Technology                      |
|------------|---------------------------------|
| Frontend   | HTML5, CSS3                     |
| Backend    | PHP 8+                          |
| Database   | MySQL (via phpMyAdmin)          |
| Server     | Apache (XAMPP)                  |

---

## Prerequisites

- [XAMPP](https://www.apachefriends.org/) (includes PHP 8+, MySQL, Apache)
- A modern web browser

---

## Setup Instructions

### 1. Clone or Download

```bash
git clone https://github.com/<your-username>/donation_platform.git
```

Or download the ZIP and extract it.

### 2. Copy to XAMPP `htdocs`

```
C:\xampp\htdocs\donation_platform\
```

### 3. Import the Database

1. Start **XAMPP** and enable Apache + MySQL.
2. Open **phpMyAdmin**: http://localhost/phpmyadmin
3. Click **Import** and select `donation_db.sql` from the repository root.
4. Click **Go**. The `donation_db` database and all three tables will be created.

### 4. Run the Application

Navigate to:

```
http://localhost/donation_platform/index.php
```

---

## Test Credentials

| Field    | Value                    |
|----------|--------------------------|
| Email    | Ayeshaakther@gmail.com   |
| Password | 12345                    |

---

## Folder Structure

```
donation_platform/
├── campaigns/
│   ├── create.php        # Campaign creation form
│   ├── donate.php        # Donation processing
│   └── list.php          # Campaign listing (uses INNER JOIN + LEFT JOIN)
├── users/
│   ├── login.php         # Login with prepared statements
│   ├── register.php      # Registration with hashed password
│   └── logout.php        # Session destruction
├── config/
│   └── db.php            # Database connection
├── index.php             # Home page
├── dashboard.php         # User dashboard
├── history.php           # Donation history (dual INNER JOIN)
├── style.css             # Global stylesheet
├── donation_db.sql       # Database schema + seed data
└── README.md
```

---

## Database Schema

```sql
-- Three tables with foreign-key relationships
donors       (id PK, name, last_name, email UNIQUE, password)
campaigns    (id PK, title, description, goal_amount, created_by FK→donors.id)
donations    (id PK, donor_id FK→donors.id, campaign_id FK→campaigns.id, amount, donated_at)
```

### Key SQL JOINs

**Campaign listing** (INNER JOIN + LEFT JOIN + GROUP BY):
```sql
SELECT campaigns.*, donors.name, donors.last_name,
       IFNULL(SUM(donations.amount), 0) AS total_donated
FROM campaigns
INNER JOIN donors   ON campaigns.created_by = donors.id
LEFT JOIN donations ON campaigns.id = donations.campaign_id
GROUP BY campaigns.id;
```

**Donation history** (dual INNER JOIN):
```sql
SELECT donors.name, donors.last_name, campaigns.title, donations.amount
FROM donations
INNER JOIN donors   ON donations.donor_id   = donors.id
INNER JOIN campaigns ON donations.campaign_id = campaigns.id;
```

---

## Security Notes

- All database queries use **prepared statements** to prevent SQL injection.
- Passwords are stored as **bcrypt hashes** (`password_hash` / `password_verify`).
- Session-based authentication protects all private pages.
- User-supplied output is encoded with `htmlspecialchars()` to prevent XSS.

---

## License

Academic project — Lehman College, CIS 344, Spring 2026.
