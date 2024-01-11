1. # DishPriceDefender

Laracoffee is a web application built using the Laravel framework that allows users to browse and order coffee products online.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [UI](#ui)
- [In Summary](#in-summary)


## Features
### Admin
- Authentication Page: This page allows admin to log in.
- Dashboard Page: Admin have access to a dashboard for an overview of system activities.
- Customer Page: Provides a list of registered customer details for admin to view.
- Product Page: Admin can view, add, edit, and remove product details.
- Product Review Page: Admin can view product reviews 
- Generate Report: Admin can generate report for vendor.


### General User
- Authentication and Registration Page: Users can log in or register for an account.
- Home Page: The main landing page for users.
- Profile Page: Users can edit their profile data and change passwords if needed.
- Product Page: Users can purchase products, view product details, and leave product reviews 

  
### Vendor
- Authentication and Registration Page: Vendor can log in or register for an account.
- Home Page: The main landing page for vendor.
- Profile Page: Users can edit their profile data and change passwords if needed.
- Product Page: Vendor can manage food, see rating


## Installation

To run DishPriceDefender locally, follow these steps:

1. Clone this repository:

   ```bash
   git clone 
   ```
2. Change to the project directory
    ```bash
    cd ProjekDishPriceDefender
    ```
3. Install the project dependencies
    ```bash
    composer install
    npm install
    ```
4. Copy the .env.example file to .env and configure your environment variables, including your database settings and any other necessary configuration.
    ```bash
    copy .env.example .env
    ```
5. Generate an application key
    ```bash
    php artisan key:generate
    ```
6. Migrate the database
    ```bash
    php artisan migrate
    ```

8. Start the development server
    ```bash
    php artisan serve
    ```
9. Access the application in your browser at http://localhost:8000

## Usage
- Visit the website and register for an account.
- Browse the available coffee products, add them to your cart, and proceed to checkout.
- Make a test order to see the order processing workflow.
- Access the admin panel by log in with admin credentials (if seeded).
- Manage products and orders through the admin panel.

## Contributing
Contributions are welcome! If you'd like to contribute to this project, please follow these steps:
1. Fork the repository.
2. Create a new branch for your feature or bugfix: `git checkout -b feature-name`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to your fork: `git push origin feature-name`.
5. Create a pull request on the original repository.



## UI


## In Summary
 Feel free to explore the application and give it a try yourself. If you have any questions or encounter any issues, please don't hesitate to reach out. Your feedback is greatly appreciated. Happy exploring!!!
 
