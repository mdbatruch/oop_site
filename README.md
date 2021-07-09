# Website Content Management System with API, Shopping Cart Components and Stripe API Integration

These are the files for a custom built Website CMS and a Shopping Cart Portion with an API with endpoints for the products and Stripe Integration.

## Changelog

## v1
* Initial build with Database setup with Database Classes. Add Email option with PHPMailer library, both DB and SMTP credentials set in env file. Add Page and Site Classes with initialization file, creating a new site Instance on server start and starting new session with the Session Class. With Session Class included, added login option with browser and server side validation through AJAX/PHP. Admin Dashboard included with new and edit page option.

## v1.1
* Added Slider Gallery Feature for the Admin, enabling to set to existing site pages, enabled/disable option, upload images, change title and description.

## v1.2
* Added option to customize main navigation order and hierarchy from Admin Panel.

## v1.3
* Search option included to allow users to search content from pages.

## v1.4
* Product API created, allowing endpoints for reading all products, reading one, deleting, creating, updating.

## v1.5
* Add Customer class, customer table, customer registration and login options.

## v1.6
* Add Cart for Customer, ability to add, update, delete and view cart items.

## v1.6.1
* Product Image added.

## v1.7
* Product Search through React App added on homepage.

## v1.7.1
* Product Categories included, product search through category option added.

## v1.7.2
* Product Pagination and Customer Avatars added.

## v1.8
* Add Checkout feature for orders with Stripe API incorporation. Add order table to database.

## v1.8.1
* Prevent viewing confirmation page of orders besides the current one. Prevent continuation of order checkout unless logged in and cart has items.

## v1.8.2
* Add Customer and profile page to admin dashboard, allowing to view all customers and profiles.

## v1.8.3
* Checkout form validation through front end, add spin icon for processing. Add 404 page and admin bar when logged in as admin.

## v1.8.4
* Prevent admins or non-customers from adding items to cart. Fix bugs in personal API endpoints.

## v1.8.5
* Create customer in Stripe API when checkout is completed, only create when customer does not exist. Create and post test charge with entered card from checkout.

## Usage

To install the application, clone the files and keep DB, SMTP and Stripe credentials in seperate .ini files outside of Site Root in the following format, replacing the placeholder values with your server settings:

###### db.ini

server=SERVER_NAME<br />
username=USERNAME<br />
password=PASSWORD<br />
db=DATABASE_NAME<br />

###### smtp.ini

username=USERNAME<br />
password=PASSWORD<br />
host=SMTP_HOST<br />
port=PORT<br />
secure=PROTOCOL<br />
from=FROM_EMAIL<br />
recipient=EMAIL_RECIPIENT<br />
recaptchaprivate=CAPTCHA_PRIVATE_KEY<br />
recaptchapublic=CAPTCHA_PUBLIC_KEY<br />

###### stripe.ini

secret_key=STRIPE_PRIVATE_KEY<br />
public_key=STRIPE_PUBLIC_KEY<br />

In order to obtain the both Stripe secret and public keys, you will need to create a Stripe account at https://stripe.com/. Stripe library files are already included in the libs directory in root.

######

GETTING STARTED

* Create A Database and Run all Migrations, including the Seed files (you can replace values as needed and make sure password is hashed with MD5 encryption). Be sure to run Customer Migration and Seed *before* Cart Migration and Seed as Cart has foreign key attached to customer and will return error if order is wrong. Create new MD5 password hashes for customer and admin profiles.

* To run Sass and BrowserSync preprocessor, cd into resources directory and run **npm install** command to install node modules. Replace proxy url with your site's directory in gulpfile.js on line 17. After installation run **gulp** to watch any changes to sass files. You may need to refresh browser to begin seeing changes, you'll be on port 3000.

* Replace site_path variable in initialize.php according to your site's path on line 8. **This is very important, otherwise the site will throw errors!**

* Replace 404 path in .htaccess file according to your site's path on line 1.