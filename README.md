# Jaffar Management System (ERP / Inventory / POS)

This repository contains a comprehensive Business Management System built with Laravel. It handles multiple aspects of a trading/distribution business, including inventory (stock), sales, purchases, order booking, finance, and reporting.

**Purpose of this README:** This document provides a complete architectural overview for any AI or developer to quickly understand the project's structure without having to manually read every file.

---

## 1. Module Overview

The system is modularized into several key business domains:
- **Core Operations:** Products, Categories, Units.
- **Sales & Orders:** Sales, Sale Payments, Orders, Order bookers, Deliverymen, Transporters. *(Note: Order bookers can have specific Customers assigned to them via `orderbooker_customers` pivot table).*
- **Purchases:** Purchases, Purchase Orders, Purchase Payments.
- **Stock & Inventory:** Stock management, Stock Adjustments, Transfers.
- **Finance & Accounts:** Chart of Accounts, Deposits & Withdrawals, Expenses, Payment Receiving.
- **Targets:** Self Targets, Orderbooker Targets.
- **Reports:** A comprehensive suite of reports for all the above modules.

---

## 2. Routes (`/routes`)

To keep the application manageable, routes are logically separated into multiple files rather than being stuffed into a single `web.php`:

- `web.php`: Core application routes (Dashboard, Units, Categories, Products, Transporter, Deliveryman) and requires other route files.
- `auth.php`: Authentication routes (login, register, password reset).
- `finance.php`: Routes related to financial transactions, expenses, deposits, withdrawals, and account management.
- `purchase.php`: Routes for managing purchases and purchase payments.
- `purchase_order.php`: Routes specifically for generating and managing purchase orders.
- `stock.php`: Routes for stock overview, adjustments, and warehouse transfers.
- `sale.php`: Routes for sales invoices, sale details, and sale payments.
- `orders.php`: Routes for managing orders placed by order bookers or customers.
- `targets.php`: Routes for defining and tracking sales targets (self and order bookers).
- `reports.php`: Contains all reporting routes (sales reports, stock reports, financial ledgers, etc.).
- `api.php`: API endpoints for the application (if accessed via mobile app or external services).
- `console.php`: Artisan console commands.

---

## 3. Controllers (`app/Http/Controllers/`)

The controllers map 1:1 with the business modules. They contain the core logic for processing requests:

### Core / Setup Controllers
- `ProductsController.php`: Manages product creation, editing, and listing.
- `CategoriesController.php`: Manages product categories.
- `UnitsController.php`: Manages units of measurement for products (e.g., kg, box, piece).
- `dashboardController.php`: Handles the data aggregation for the main dashboard.

### Sales & Order Controllers
- `SalesController.php`: Manages the creation and listing of sales invoices.
- `SaleDetailsController.php`: Manages individual line items of a sale.
- `SalePaymentsController.php`: Handles payments received against specific sales.
- `OrdersController.php`: Manages the lifecycle of customer orders.
- `OrderbookerController.php`: Manages the profiles of order bookers (field sales reps).
- `DeliverymanController.php` & `TransporterController.php`: Manages logistics personnel.

### Purchase Controllers
- `PurchaseController.php`: Manages purchase invoices from vendors.
- `PurchaseOrderController.php`: Handles the creation of POs to be sent to vendors.
- `PurchasePaymentsController.php`: Manages outgoing payments to vendors.

### Stock & Inventory Controllers
- `StockController.php`: General stock viewing and tracking.
- `StockAdjustmentController.php`: Handles manual adjustments to stock levels (e.g., damages, audits).
- `TransferController.php`: Manages stock movement between locations or warehouses.

### Finance Controllers
- `AccountsController.php`: Manages the chart of accounts (vendors, customers, banks, cash).
- `DepositWithdrawController.php`: Handles cash/bank deposits and withdrawals.
- `ExpensesController.php`: Records business expenses.
- `PaymentReceivingController.php`: General payment receiving logic.

### Target Controllers
- `TargetsController.php`, `SelfTargetController.php`, `OrderbookerTargetController.php`: Manages the creation, tracking, and evaluation of sales targets.

### Other Controllers
- `authController.php`, `confirmPasswordController.php`, `profileController.php`: Handle user authentication and profile management.

---

## 4. Views (`resources/views/`)

The view layer is organized in directories that correspond to the controllers and routes:

- `layout/`: Contains the master layout files (sidebar, header, footer) using Blade templates.
- `dashboard/`: Dashboard views.
- `auth/`: Login, registration, and password management views.
- **Entity Views (CRUD interfaces):**
  - `products/`, `categories/`, `units/`
  - `sales/`, `orders/`, `orderbookers/`
  - `purchase/`, `purchase_order/`
  - `stock/`
  - `finance/`
  - `deliveryman/`, `transporter/`
  - `target/`, `self_target/`, `orderbooker_target/`
- `reports/`: Contains all the blade files for generating tabular reports and printouts.

---

## 5. Middleware & Security
- `auth`: Most routes are protected by Laravel's default `auth` middleware.
- `adminCheck`: Core setup routes (Units, Categories, Products) use the `adminCheck` middleware to restrict access to administrators only.

## AI Instructions (Context for future prompts)
When asked to modify this project:
1. **Identify the Domain:** Determine if the request is about Sales, Purchase, Stock, or Finance.
2. **Locate the Route:** Find the corresponding route file in `routes/` (e.g., `routes/finance.php`).
3. **Locate the Controller:** Find the corresponding controller in `app/Http/Controllers/`.
4. **Locate the View:** Look in `resources/views/` under the domain's folder name.
5. **Keep modularity:** If adding a new feature, add it to its specific route file rather than `web.php`.
