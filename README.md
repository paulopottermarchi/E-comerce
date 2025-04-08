# 💲 Marchese Store

**Marchese Store** is a modern e-commerce platform built with **Laravel 12** and **Bootstrap 5**. It allows users to browse products, manage a shopping cart, complete secure payments via Stripe, and track their order history.

---

## ✨ Features

- 🔐 User authentication (register & login)
- 🛖 Product listing and details page
- 👚 Shopping cart with quantity tracking
- 💳 Stripe payment integration
- 📌 Order history with status
- ✅ Flash messages for feedback (success & error)

---

## ⚙️ Tech Stack

- **Laravel 12**  
- **PHP 8.2+**  
- **Bootstrap 5**  
- **MySQL**  
- **Stripe API**  
- **Pinggy** (for local webhook testing)

---

## ⚙️ Installation

```bash
# Clone the repo
git clone https://github.com/your-username/marchese-store.git
cd marchese-store

# Install backend dependencies
composer install

# Install frontend dependencies
npm install && npm run dev

# Environment setup
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with your database credentials and Stripe keys:

```
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=your_stripe_webhook_secret
```

Run migrations:
```bash
php artisan migrate
```

Create a symbolic link to storage (for images if needed):
```bash
php artisan storage:link
```

---

## 🧪 Testing Stripe Webhook Locally

To test the Stripe webhook locally:

### Option 1: Using [Pinggy](https://pinggy.io)
```bash
pinggy http://127.0.0.1:8000
```

Make sure your `STRIPE_WEBHOOK_SECRET` matches the one from the Stripe Dashboard.

Set the webhook URL in Stripe to:
```
https://your-pinggy-subdomain.pinggy.link/webhook/stripe
```

### Option 2: Using Ngrok
```bash
ngrok http 8000
```
Then set the webhook in Stripe like:
```
https://your-ngrok-subdomain.ngrok.io/webhook/stripe
```

Test with Stripe CLI (optional):
```bash
stripe listen --forward-to localhost:8000/webhook/stripe
```

---

## 📸 Screenshots

### 🌐 Homepage (Hero Section)
![Homepage](screenshots/homepage.png)

### 🛒 Product Listing
![Products](screenshots/products.png)

### 🛒 Cart View
![Cart](screenshots/cart.png)

### 💳 Stripe Checkout
![Checkout](screenshots/checkout.png)

### 📋 Order History
![Orders](screenshots/orders.png)

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 👋 About

Marchese Store was built as a learning project and showcase of modern Laravel development, including authentication, session cart management, Stripe integration, and clean responsive UI using Bootstrap.

Feel free to fork, contribute or suggest improvements!

---

Made with ❤️ by [your-name].
