# System Documentation for FLEUR Flower Shop

This document outlines the system architecture, diagrams, and processes for the FLEUR flower shop web application built with Laravel.

## 1. System Architecture

### Description
The system architecture diagram illustrates the overall structure of the FLEUR application, showing how different components interact. It depicts the flow of data and processes from user interaction to database storage and back.

### Components
- **Frontend**: Blade templates with HTML, CSS, and JavaScript for user interface
- **Backend**: Laravel framework handling business logic, routing, and controllers
- **Database**: MySQL database storing user data, products, orders, etc.
- **File Storage**: Public directory for images and assets
- **Authentication**: Laravel's built-in auth system for user management

### Process Flow
1. User accesses the website via browser
2. Request routed through Laravel's routing system
3. Controller processes the request, interacts with models
4. Models query the database for data
5. Data rendered in Blade views and returned to user
6. Static assets (CSS, JS, images) served directly

### How to Create
Use tools like Draw.io, Lucidchart, or Microsoft Visio to create a layered diagram showing:
- Client layer (browser)
- Application layer (Laravel)
- Data layer (MySQL)

## 2. Sitemap

### Description
The sitemap shows the hierarchical structure of the website, mapping out all pages and their relationships. For FLEUR, it demonstrates how users navigate through the flower shop from browsing to checkout.

### Key Pages
- Home (landing page with featured products)
- Products (product catalog with filtering)
- Flowers (flower gallery)
- Gallery (event gallery)
- Services (service offerings)
- About (company information)
- Contact (contact form)
- Cart (shopping cart)
- Checkout (order processing)
- Login/Register (authentication)
- Profile (user account management)
- Admin Dashboard (admin panel for managing products, orders, etc.)

### Process Flow
1. Visitors land on Home page
2. Browse Products or Flowers
3. Add items to Cart
4. Proceed to Checkout (requires login)
5. Complete order
6. Admins access Dashboard for management

### How to Create
Create a hierarchical diagram using:
- Main navigation pages at top level
- Sub-pages and features as children
- Arrows showing navigation flow
- User authentication gates marked

## 3. Wireframes

### Description
Wireframes are low-fidelity blueprints of the user interface, showing layout and functionality without design details. For FLEUR, they illustrate the user experience flow from browsing flowers to completing a purchase.

### Key Wireframes
- Home page wireframe
- Product listing page
- Product detail page
- Shopping cart page
- Checkout form
- User login/register forms
- Admin dashboard

### Process Flow
1. User sees product grid on home/catalog pages
2. Clicks product for detailed view with add-to-cart button
3. Cart shows selected items with quantity controls
4. Checkout form collects shipping and payment info
5. Confirmation page shows order summary

### How to Create
Use tools like Figma, Adobe XD, or Balsamiq:
- Sketch basic layouts with placeholders for content
- Show navigation elements, buttons, forms
- Include annotations for functionality
- Create multiple versions for different screen sizes

## 4. Use Case Diagram

### Description
The use case diagram shows the interactions between users (actors) and the system. For FLEUR, it demonstrates how different user types interact with the flower shop system.

### Actors
- Customer (unregistered visitor)
- Registered User
- Administrator

### Use Cases
- Browse products
- Search products
- View product details
- Add to cart
- Manage cart
- Checkout and pay
- Register account
- Login/logout
- View order history
- Update profile
- Manage products (admin)
- Manage orders (admin)
- Manage users (admin)

### Process Flow
1. Customer browses and searches products
2. Registered user adds items to cart and completes purchase
3. Admin manages inventory and processes orders
4. System validates user actions and maintains data integrity

### How to Create
Use UML diagramming tools:
- Draw stick figures for actors
- Use ovals for use cases
- Connect with lines showing associations
- Include <<include>> or <<extend>> relationships where applicable

## 5. ERD (Entity-Relationship Diagram)

### Description
The ERD shows the database structure and relationships between entities. For FLEUR, it illustrates how user data, products, orders, and other information are stored and connected.

### Key Entities
- Users (id, name, email, password, role)
- Products (id, name, price, description, image)
- Flowers (id, name, description, image)
- Events (id, name, description, images)
- Carts (id, user_id, created_at)
- Cart_Items (id, cart_id, product_id, quantity)
- Orders (if implemented: id, user_id, total, status)

### Relationships
- User has many Carts
- Cart has many Cart_Items
- Cart_Item belongs to Product
- Event has many Event_Images
- User has role (customer/admin)

### Process Flow
1. User registers and creates profile
2. Products are stored with details
3. User adds products to cart (creates cart and cart_items)
4. During checkout, cart data is processed
5. Admin manages products, flowers, events

### How to Create
Use database design tools like MySQL Workbench or draw.io:
- Rectangles for entities
- Diamonds for relationships
- Lines with cardinality (1:1, 1:many, many:many)
- Attributes listed within entities

## 6. DFD (Data Flow Diagram)

### Description
The DFD shows how data flows through the system, from input to processing to output. For FLEUR, it demonstrates the data movement during a typical shopping process.

### Levels
- Context Diagram (Level 0): System overview
- Level 1: Main processes
- Level 2: Detailed subprocesses

### Key Processes
- User Authentication
- Product Browsing
- Cart Management
- Order Processing
- Inventory Management
- Payment Processing

### Data Flows
1. User inputs login credentials → System validates → User authenticated
2. User searches products → System queries database → Product list displayed
3. User adds to cart → Cart data stored → Cart updated
4. User checks out → Payment processed → Order created → Confirmation sent

### Process Flow
1. External entities (Customer, Admin) interact with the system
2. Data flows through processes (authentication, browsing, ordering)
3. Data stores (database) are accessed and updated
4. Trust boundaries and data validation points are shown

### How to Create
Use DFD diagramming tools:
- Circles/rounded rectangles for processes
- Rectangles for data stores
- Arrows for data flows
- Squares for external entities
- Start with Level 0, then decompose into Level 1 and 2

## Tools Recommendations

- **Diagramming**: Draw.io (free), Lucidchart, Microsoft Visio
- **Wireframing**: Figma, Adobe XD, Balsamiq
- **Database Design**: MySQL Workbench, dbdiagram.io
- **Documentation**: Markdown editors, GitBook, or GitHub Wiki

## Implementation Notes

- Ensure all diagrams are consistent with the actual Laravel implementation
- Include legends and annotations for clarity
- Update diagrams as the system evolves
- Use these diagrams for stakeholder communication and development planning