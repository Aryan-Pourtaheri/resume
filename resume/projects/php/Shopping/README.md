# Shopping PHP E-Commerce

A modern, responsive e-commerce web application built with PHP, MySQL, Bootstrap, and jQuery.

---

## Features

- **User Authentication:** Register, login, logout, and profile management.
- **Product Catalog:** Browse products by category, filter by price, and view product details.
- **Shopping Cart:** Add, update, and remove products from the cart.
- **Checkout:** Place orders with billing and payment options.
- **Order Management:** Admin panel for managing products, categories, customers, and orders.
- **Responsive Design:** Looks great on desktop and mobile.
- **Modern Red Theme:** Clean, bold red-accented UI using Bootstrap 4/5.

---

## Folder Structure

```
/Shopping
│
├── Admin/                # Admin dashboard and management
├── _auth/                # Authentication (login, register, logout)
├── components/
│   ├── shop-header/      # Navbar, topbar, header
│   ├── shop-contents/    # Shop, cart, checkout, detail content
│   └── shop-footer/      # Footer
├── config/               # Database connection
├── css/                  # Stylesheets (Bootstrap, custom)
├── img/                  # Images
├── js/                   # JavaScript files
├── lib/                  # Libraries (OwlCarousel, Animate.css, etc.)
├── uploads/              # Uploaded images (products, profiles)
├── shop.php              # Main shop page
├── cart.php              # Cart page
├── checkout.php          # Checkout page
├── detail.php            # Product detail page
├── add-to-cart.php       # Add to cart handler
├── profile.php           # User profile page
└── shop.sql              # Database schema
```

---

## Quick Start

1. **Clone or Download the Repository**

2. **Import the Database**

   - Import `shop.sql` into your MySQL server.

3. **Configure Database Connection**

   - Edit `config/connection.php` with your database credentials.

4. **Set Up Uploads Folder**

   - Make sure `uploads/` and its subfolders are writable.

5. **Run Locally**

   - Place the project in your XAMPP/htdocs or similar web root.
   - Access via `http://localhost/Shopping/shop.php`

---

## Customization

- **Theme Colors:**  
  The main accent color is red (`#e53935`).  
  You can adjust this in your custom CSS files in `/css/`.

- **Images:**  
  Place product images in `/uploads/products/` and profile images in `/uploads/profile_pictures/`.

- **Admin Panel:**  
  Access admin features via `/Admin/` (you may need to log in as an admin).

---

## Dependencies

- [Bootstrap 4/5](https://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [Font Awesome](https://fontawesome.com/)
- [OwlCarousel](https://owlcarousel2.github.io/OwlCarousel2/)
- [Animate.css](https://animate.style/)

---

## License

This project is for educational/demo purposes.  
Feel free to use and modify for your own needs.

---

## Credits

- UI inspired by modern Bootstrap e-commerce templates.
- Icons by [Font Awesome](https://fontawesome.com/).

---

**Enjoy your shopping platform!**
