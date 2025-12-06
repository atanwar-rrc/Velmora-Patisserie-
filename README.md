# Velmora Patisserie

A bakery e-commerce website built with PHP and MySQL. Browse cakes, manage your cart, and checkout - all the essentials of an online store.

## About This Project

I built this to learn how e-commerce websites work behind the scenes. It's a full-stack PHP application where customers can shop for cakes and admins can manage the inventory. The main challenge was implementing the shopping cart logic and making sure everything stayed in sync between the user's session and the database.

## What It Does

**Customer Side:**
- Browse cakes by category (birthdays, weddings, cupcakes, etc.)
- Search for specific products
- Add items to shopping cart with quantity controls
- Save items to wishlist for later
- Complete checkout with billing information
- Leave reviews and comments

**Admin Side:**
- Add, edit, or remove products
- Manage product categories
- Handle user accounts
- Upload product images
- Organize inventory

## Tech Stack

**Backend:**
- PHP 8.0
- MySQL for data storage
- PDO for database connections

**Frontend:**
- HTML5, CSS3, JavaScript
- Bootstrap 5 for responsive layout
- Some helpful libraries (AOS for animations, Swiper for carousels)

## Requirements

You need PHP and MySQL installed to run this project. Here are your options:

### Option 1: XAMPP (Recommended for Beginners)

XAMPP is an all-in-one package that includes Apache, MySQL, PHP, and phpMyAdmin. This is the easiest way to get started.

**Download:** https://www.apachefriends.org/download.html

**Installation:**
1. Download the installer for your operating system (Windows, Mac, or Linux)
2. Run the installer and follow the setup wizard
3. During installation, make sure Apache and MySQL are selected
4. After installation, launch XAMPP Control Panel
5. Start the Apache and MySQL services

**What you get:**
- PHP 8.0+
- MySQL/MariaDB database
- Apache web server
- phpMyAdmin (web interface for managing databases)

### Option 2: Install Separately

If you prefer to install components individually:

**PHP:**
- Windows: Download from https://windows.php.net/download/
- Mac: Comes pre-installed, or use Homebrew: `brew install php`
- Linux: `sudo apt-get install php php-mysql` (Ubuntu/Debian) or `sudo yum install php php-mysql` (CentOS/RHEL)

**MySQL:**
- Download from https://dev.mysql.com/downloads/mysql/
- Or use MariaDB: https://mariadb.org/download/

**Minimum versions:**
- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.x+

## Installation

**1. Get the code**

Clone or download this repository:
```bash
git clone https://github.com/yourusername/Velmora-Patisserie.git
cd Velmora-Patisserie
```

Or download as ZIP from GitHub and extract it.

**2. Set up the database**

**If using XAMPP:**
1. Make sure MySQL is running in XAMPP Control Panel (green indicator)
2. Open phpMyAdmin in your browser: http://localhost/phpmyadmin
3. Click "New" in the left sidebar
4. Enter database name: `velmorapatisserie`
5. Click "Create"

**If using command line:**
```bash
mysql -u root -p
```
Then type:
```sql
CREATE DATABASE velmorapatisserie;
exit;
```

**Important:** The database tables will be created automatically when you first run the application. You don't need to import any SQL files.

**3. Configure database connection**

Open the file `getConnection.php` in a text editor and verify these settings:

```php
$servername = "localhost";
$dbname = "velmorapatisserie";
$username = "root";
$password = "";
```

**Note:** If you set a password for your MySQL root user, update the `$password` value accordingly.

**4. Start the application**

You have two options to run the project:

**Method A: Using PHP Built-in Server (Simple & Quick)**

1. Open terminal/command prompt
2. Navigate to the project folder:
   ```bash
   cd path/to/Velmora-Patisserie
   ```
3. Start the server:
   ```bash
   php -S localhost:8000
   ```
   
   **Note:** On Windows with XAMPP, use the full path:
   ```bash
   C:\xampp\php\php.exe -S localhost:8000
   ```

4. Open your browser and go to: http://localhost:8000

**Method B: Using XAMPP**

1. Copy the entire project folder to XAMPP's htdocs directory:
   - Windows: `C:\xampp\htdocs\velmora`
   - Mac: `/Applications/XAMPP/htdocs/velmora`
   - Linux: `/opt/lampp/htdocs/velmora`

2. Make sure Apache and MySQL are running in XAMPP Control Panel

3. Open your browser and go to: http://localhost/velmora

**5. Create an admin account**

The first time you run the app:
1. Go to the registration page (Sign Up)
2. Create your account
3. Open phpMyAdmin: http://localhost/phpmyadmin
4. Navigate to `velmorapatisserie` database → `user` table
5. Find your user record and change `user_type` from 'user' to 'admin'
6. Log out and log back in - you now have admin access

## How It Works

### Shopping Cart

This took me a while to figure out. Here's how it works:
- When you add a product, it checks if you already have it in your cart
- If yes, it just bumps up the quantity instead of adding a duplicate row
- The +/- buttons use JavaScript to auto-submit the form, so quantities update instantly
- Everything is tied to your session, so your cart persists as you browse

The cart data is stored in a MySQL table with user email, product details, and quantities.

### Wishlist

Similar concept to the cart but separate table. You can save items and move them to cart later. When you move an item, it transfers the quantity correctly (that was a bug I had to fix).

### Checkout

Has a complete billing form with proper validation. I used Bootstrap's validation styles to show errors under each field. Right now it's just a mockup - no real payment processing, just Cash on Delivery or Card selection.

### Admin Panel

Only users with admin role can access admin pages. I check the session on each admin page - if you're not an admin, you get redirected. Admins can do full CRUD operations on products, categories, and users. Image uploads go to the `upload/` folder.

### Security

- Passwords are hashed with `password_hash()` before storing
- All database queries use PDO prepared statements (no SQL injection)
- User input is sanitized with `htmlspecialchars()`
- Sessions handle authentication
- Redirects use proper headers to avoid the "headers already sent" issue

## Project Structure

```
Velmora-Patisserie/
├── index.php                 # Homepage
├── SignIn.php                # Login page
├── SignUp.php                # Registration
├── Products.php              # Product listing
├── ViewProduct.php           # Product details
├── Cart.php                  # Shopping cart
├── Wishlist.php              # Wishlist
├── Checkout.php              # Checkout form
├── getConnection.php         # Database config
├── TopBar.php                # Header navigation
├── Footer.php                # Footer
├── Admin*.php                # Admin dashboard files
├── assets/
│   ├── css/                  # Styles
│   ├── js/                   # Scripts
│   ├── img/                  # Images
│   └── vendor/               # Third-party libraries
└── upload/                   # User uploads
```

## Database Tables

- `user` - Customer and admin accounts
- `category` - Product categories
- `product` - All products with prices and descriptions
- `cart` - Shopping cart items
- `wishlist` - Saved items
- `comment` - Customer reviews

Products link to categories, cart/wishlist items link to both users and products.

## What I Learned

Building this taught me:
- How shopping carts actually work under the hood
- Managing user sessions properly in PHP
- File upload handling and validation
- Working with foreign keys and table relationships
- Form validation on both client and server side
- Preventing common security vulnerabilities

## Current Limitations

Being honest about what's not there yet:
- No actual payment gateway integration (just mockup)
- All products use the same placeholder image
- No email notifications
- No order history or tracking
- Could use better error handling in some places

## Troubleshooting

**Database won't connect:**
Check that MySQL is running and your credentials in `getConnection.php` are correct.

**Session problems:**
Clear your browser cookies and cache. Make sure `session_start()` is only called once (it's in `getConnection.php`).

**Images not showing:**
Check folder permissions on `upload/` and `assets/img/`. The web server needs read access.

**Can't access admin features:**
Your user needs `user_type = 'admin'` in the database. You can set this manually in phpMyAdmin.

**Form validation not working:**
Try a hard refresh (Ctrl + Shift + R). Make sure Bootstrap's JavaScript is loading.

## Future Ideas

Things I want to add when I have time:
- Order history for customers
- Email confirmations
- Actual product images for each item
- Better search with filters
- Customer reviews with ratings
- Maybe integrate a real payment system

## Contributing

If you find bugs or want to add features, feel free to open a pull request. I'm always interested in learning better ways to do things.

## License

Free to use for learning or portfolio projects.

---

**Built by Abhimayu**

This project helped me understand e-commerce fundamentals and full-stack PHP development. If it helps you learn too, that's great!
