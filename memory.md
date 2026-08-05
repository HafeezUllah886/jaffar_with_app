# AI Memory & Changelog

This document serves as the persistent memory for the AI assistant working on the **Jaffar Management System**. 
Every time a significant change is made, the AI should log it here. This helps maintain context across sessions and makes it easier to plan the next steps.

---

## 📝 Pending Tasks & Next Steps
*(AI should update this section with whatever needs to be done next based on the user's ongoing requests)*

- [ ] Task 1: (Pending...)
- [ ] Task 2: (Pending...)

---

## 🔄 Changelog (Recent to Oldest)
*(AI should log changes here in reverse chronological order)*

### [2026-07-18]
- **Feature - Assign Customers**: Created `OrderbookerCustomer` model/migration to store many-to-many relationship between orderbookers (`users` table) and customers (`accounts` table). Added UI in Order Bookers index to assign and manage these customers.
- **Documentation**: Completely rewrote `README.md` to map out the application's structure (Routes, Controllers, Views, Domains).
- **Setup**: Created `memory.md` to track ongoing AI context and tasks.

---

## 🧠 System Context Notes
*(Add any persistent, specific system quirks, ongoing bugs, or important architectural decisions the AI should remember here)*

- The project uses separate route files (e.g., `routes/finance.php`, `routes/sales.php`) instead of relying solely on `web.php`.
- Views are organized in folders that correspond to their domains (e.g., `resources/views/finance`).
