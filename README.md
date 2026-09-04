# CakeOdyssey
A full-stack cake ordering system featuring role-based access, dynamic cart management, and flexible checkout handling both fixed-size custom cakes and weight-based kilo cakes.

# Cake Ordering System
A comprehensive web application designed to manage a bakery's inventory and customer orders. This system handles the complexities of bakery pricing by supporting both fixed-size custom cakes and variable weight-based (kilo) cakes within a single, dynamic cart system.

## 🚀 Key Features

### Customer Features
*   **Secure Authentication:** User registration and login functionality.
*   **Dynamic Cart System:** Add physical quantities and specific weights (e.g., ordering two 2.5kg chocolate cakes).
*   **Seamless Checkout:** Cart items are automatically calculated using a `Base Price × Weight × Quantity` algorithm.
*   **Order History:** Users can view their past orders with locked-in historical pricing.

### Admin Features
*   **Inventory Management:** Add, update, and manage cake listings.
*   **Flexible Cake Types:** Categorize inventory as either fixed `'custom'` cakes (default 1kg) or variable `'kilo'` cakes.
*   **Order Tracking:** Monitor and fulfill incoming customer orders.

## 🗄️ Database Architecture
The system utilizes a relational database (MySQL) designed for accurate historical tracking and flexible ordering:
*   `users`: Manages both 'admin' and 'customer' roles, storing contact and delivery details.
*   `cakes`: Stores base prices per 1kg, images, and cake types.
*   `cart_items`: Temporarily holds pending user selections, tracking both physical quantity and weight per cake.
*   `orders` & `order_items`: Acts as an immutable receipt, locking in the price at the time of purchase to protect against future inventory price changes.

## 🛠️ Tech Stack
*   **Database:** MySQL
*   **Backend:** [Insert Backend Tech, e.g., Laravel / Node.js]
*   **Frontend:** [Insert Frontend Tech, e.g., React / Next.js / Blade]
