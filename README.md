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

## v1.8.6
* Add Billing Address informaton and Shipping options for checkout. Add Product image gallery for individual product pages.

## v1.8.7
* Update page layouts. Image modals for product pages. Add Filter and Range options for Product Search.

## v1.8.8
* Update homepage layout and components. Update Registration inputs and validation.

## v1.9
* Add Cart side toggle menu. Update customer page layouts.

## v1.9.1
* Add order popup for customer order lists. Add form for editing customer profile. Remove individual order page for customers.

## v1.9.2
* Add toggleble nav menu for mobile. Update layouts for mobile.

## Usage

To install the application, clone the files and keep DB, Path, SMTP and Stripe credentials in seperate .ini files outside of Site Root in the following format, replacing the placeholder values with your server settings:

###### db.ini

server=SERVER_NAME<br />
username=USERNAME<br />
password=PASSWORD<br />
db=DATABASE_NAME<br />

###### path.ini

path=PATH_NAME<br />

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

* Replace 404 path in .htaccess file according to your site's path on line 1.

###### API

There are a few endpoints that allow you to create, read, update and delete the Product object.

 **GET** /api/read
 **GET** /api/read_one/:name
 **POST** /api/create/:name :price :description :category_id :image
 **POST** /api/update/:id :name :price :description :category_id :image
 **POST** /api/delete/:id

 ## Read all Products

 **Parameters**

 * None

 Returns all of the currently listed products in the database. Throws a 404 error if there are no products.

 ## Read a Product

 **Parameters**

 * Name - the name of the product. Is case-sensitive but can include spaces.

 Returns a single product as called in the endpoint with the name parameter. Throws a 404 error if there is no such product with a name.

 ## Create a Product

 **Parameters**

 * Name - the name of the product. Is case-sensitive but can include spaces.

 * Price - the price of the product.

 * Description - the description of the product. (Optional)

 * Category ID - the category ID of the product. (Not the name of category)

 * Image - the image file name of the product. (Optional)

 Creates a single product as called in the endpoint with the provided parameters. Throws a 503 error if unsuccessfull.

 ## Update a Product

 **Parameters**

 * ID - the ID of the product.

 * Name - the name of the product. Is case-sensitive but can include spaces.

 * Price - the price of the product.

 * Description - the description of the product. (Optional)

 * Category ID - the category ID of the product. (Not the name of category)

 * Image - the image file name of the product. (Optional)

 Updates a single product as called in the endpoint with the provided parameters. Throws a 503 error if unsuccessfull.

 ## Delete a Product

 **Parameters**

 * ID - the ID of the product.

 Deletes a single product as called in the endpoint with the ID parameter. Throws a 503 error for any error.