# Restaurant QR Ordering System – Planning Document

## 1. Project Overview
A web-based restaurant ordering system using **QR per table**. Customers scan a QR code at their table, browse the menu, add items to cart, confirm the order, and choose a payment method. Orders are only sent to the kitchen **after payment is confirmed** (online or cashier-verified).

This system is designed to be **simple, operationally correct, and scalable**, aligned with real restaurant workflows.

---

## 2. Core Objectives
- Reduce ordering friction for customers
- Prevent unpaid orders from reaching the kitchen
- Centralize menu and order management
- Support both online and offline (cash/card) payments
- Be extensible for future features (KDS, inventory, multi-branch)

---

## 3. User Roles & Responsibilities

### 3.1 Admin (Owner / Super Admin)
**Purpose:** System configuration & oversight

**Permissions:**
- Manage restaurant profile (name, logo, basic theme)
- Full menu management:
  - Create / update menu items
  - Set prices, categories, add-ons
- Generate QR codes per table
- Manage staff accounts
- View reports & order history

**Restrictions:**
- Cannot update order operational status
- Not intended for daily cashier operations

---

### 3.2 Staff (Cashier / Operator)
**Purpose:** Daily restaurant operations

**Permissions:**
- View incoming orders
- Update order status:
  - WAITING_PAYMENT → PAID
  - PAID → SENT_TO_KITCHEN
- Print receipts
- Toggle menu availability (Available / Unavailable)

**Restrictions:**
- Cannot edit menu price or name
- Cannot generate QR codes
- Cannot access system-wide settings

---

### 3.3 Customer (Public / Anonymous)
**Purpose:** Place food orders

**Permissions:**
- Scan QR code
- View menu
- Add/edit/remove items in cart
- Confirm order
- Choose payment method:
  - Online (FPX)
  - Cash / Card (pay at counter)

**Restrictions:**
- No login
- Cannot view other tables’ orders
- Cannot modify order after status = WAITING_PAYMENT

---

## 4. Ordering Flow (End-to-End)

### 4.1 Entry
1. Customer sits at table
2. Scans QR code
3. System identifies:
   - Restaurant
   - Table number

---

### 4.2 Menu & Cart
- Customer browses menu
- Adds items to cart
- Can:
  - Update quantity
  - Remove items

Cart is saved as **Order Draft**.

---

### 4.3 Confirmation Page
- Customer reviews order
- Can:
  - Edit items
  - Delete items
  - Add new items

Order is **not committed** at this stage.

---

### 4.4 Payment Selection

#### Option A: Online Payment (FPX)
- Redirect to payment gateway
- On success:
  - Order status = PAID
  - Order sent to kitchen

#### Option B: Cash / Card
- Order status = WAITING_PAYMENT
- Customer instructed to pay at counter
- Order NOT sent to kitchen yet

---

### 4.5 Counter Flow (Cash/Card)
1. Staff selects table / order
2. Receives payment
3. Prints receipt

**Receipt print = order commit**

After print:
- Order status = PAID
- Order sent to kitchen

---

### 4.6 Kitchen (Phase 1)
- Orders printed on paper
- Single printer
- Manual preparation

---

## 5. Order Status Lifecycle

```
DRAFT
  ↓
WAITING_PAYMENT
  ↓
PAID
  ↓
SENT_TO_KITCHEN
  ↓
COMPLETED
```

**Online payment shortcut:**
```
DRAFT → PAID → SENT_TO_KITCHEN
```

---

## 6. Key Business Rules

- One active order per table at a time
- Orders are immutable after WAITING_PAYMENT
- Kitchen only receives PAID orders
- Receipt printing is the single source of truth

---

## 7. Menu Management Rules

- Menu structure:
  - Category
  - Item
  - Optional add-ons
- Pricing controlled by Admin only
- Availability toggled by Staff

---

## 8. QR Code Design

Each QR code contains:
- restaurant_id
- table_number

QR is static per table.

---

## 9. Reporting (Phase 1)

- Daily sales summary
- Order history
- Payment method breakdown

(Admin view only)

---

## 10. Technical Direction (Draft)

- Platform: Web-based (mobile-first)
- Customer UI: No authentication
- Staff/Admin UI: Authenticated
- Architecture: Modular, API-driven

(Tech stack to be finalized next phase)

---

## 11. Future Enhancements (Out of Scope – Phase 1)

- Kitchen Display System (KDS)
- Inventory auto-deduction
- Loyalty & rewards
- Multi-branch support
- Advanced analytics dashboard

---

## 12. Initial Implementation Focus (Phase 1)

For the first development phase, implementation will **start with internal operational pages** to establish system foundation and configuration.

### Phase 1A: Admin & Staff Foundation

1. **Admin Page**
   - Admin authentication
   - Restaurant settings (name, logo)
   - Staff account management
   - Table management & QR code generation
   - Menu management (create, edit, pricing)

2. **Staff Page**
   - Staff authentication
   - View incoming orders
   - Update order status (WAITING_PAYMENT → PAID → SENT_TO_KITCHEN)
   - Print receipts
   - Toggle menu availability

3. **Menu Page (Internal Management)**
   - Category management
   - Menu item management
   - Price configuration (Admin only)
   - Availability control (Staff)

Customer ordering interface, payment gateway integration, and kitchen workflow will be implemented **after** the admin and staff foundations are stable.

---

## 13. Next Steps

1. Design database ERD (Admin & Staff first)
2. Define table schema
3. Define API/module boundaries
4. Finalize tech stack
5. Begin Phase 1A implementation

---

**Status:** Requirements Locked – Phase 1A (Admin & Staff First)

