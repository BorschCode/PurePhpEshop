# Pure PHP E-Commerce Catalog
=============================
## Constraints:
- Use of **CMS is not allowed**.
- Use of **Frameworks is not allowed**.

## Requirements:
- Must implement the ability to add one product to **multiple categories**.
- One product must have the following image sizes provided: **110x110, 250x250, 450x450**.
- **Breadcrumbs** must be implemented in **microformat**.
- **Required meta-tags** must be present on all pages.
- Must implement **administration of categories and products**.
- Routing must be implemented as:
    - `Domen/alias/c<id>` - Product Category
    - `Domen/alias/p<id>` - Product

## Task Description:
This module is essentially a standard product catalog with a tree-like structure, with the exception that **one product can have more than one parent**. Products and categories must have image previews. The product must also have a **regular price** and a **promotional price (sale price)**.

# Implementation
=================================
## Project Description:
This project is implemented **without using external CMS/Frameworks**.
It is built according to the **MVC principle**, visible from the folder structure.

![Главная страница магаизна](./readme/main13.png)

| Video Link & Preview | Description |
| :--- | :--- |
| [![Video: Routing in Pure PHP](https://img.youtube.com/vi/AVpCHPMhmsA/0.jpg)](https://youtu.be/AVpCHPMhmsA) | **Custom Routing Logic:** A detailed look at the custom, framework-less routing implemented in the `router` class, showing how requests like `/c<id>` and `/p<id>` are handled. |
| [![Video: File Handling Implementation](https://img.youtube.com/vi/X6BpvPH0Z6Y/0.jpg)](https://www.youtube.com/watch?v=X6BpvPH0Z6Y) | **Image Processing:** Demonstration of the file handling logic, including the automatic resizing of uploaded images into the three required sizes (110x110, 250x250, 450x450). |
| [![Video: Short Presentation/Demo](https://img.youtube.com/vi/1Y5WRqS-hY4/0.jpg)](https://youtu.be/1Y5WRqS-hY4) | **Project Walkthrough:** A brief, comprehensive presentation of the main features, including the catalog view, product cards, and the basic user flow. |

> The visual basis is taken from the WordPress theme [e-commerce](https://wordpress.org/themes/e-commerce/).
**Bootstrap 4** is also used as an acceptable visual component, along with **FontAwesome** fonts and custom styles in `Main.CSS`.

## Image Sizing:
- One product must provide the following image sizes: 110x110, 250x250, 450x450.
- The call to view different sized images is implemented in the class `product::ImageSize(['id'] product)`.
- Image uploading happens in `adminProductController` functions `actionUpdate($id)` and `actionCreate()`.
- When editing or creating a product, one image file can be uploaded, which will be automatically resized to 450x450, then to 250x250, and 110x110.
- The 110x110 size is loaded in the product card on the main page. The 250x250 size is also available on the product card, displayed over the old photo by changing CSS properties.
- The 450x450 size is available in the product description itself.

## Routing Implementation:
- Routing must be implemented as:
    - `Domen/alias/c<id>` - Product Category
    - `Domen/alias/p<id>` - Product
- Catalog routing is implemented in the **router class**, and the request patterns and routing itself can be defined in the `config/routes.php` file.
  [![Video: Routing in Pure PHP](https://img.youtube.com/vi/AVpCHPMhmsA/0.jpg)](https://youtu.be/AVpCHPMhmsA)

## Meta-tags and Breadcrumbs:
- Required meta-tags must be present on all pages.
- **Breadcrumbs** must be implemented in **microformat**.
- When calling the necessary view from each controller, the required meta-tags + page title data are passed.
- This data is also used for forming microdata.
- All functions are described in the site header.

## Administration of Categories and Products:
- Implemented: Four controllers responsible for working with products and categories.
- Accessible at the address: `http://wezom.test/admin`
- Admin assignment is available by editing data in the MySql table field `role` — setting it to `admin` assigns the user as an admin.

![screenshot of sample](https://screenshots.firefoxusercontent.com/images/7a9dda93-b224-497a-8786-1aff93daa033.png)

## Price and Parent Categories:
- **Regular price and promotional price:** Implemented as separate fields for the product. Display of the promotional price is implemented directly in the view files.
- **One product can have more than one parent:** This is handled by the `categories` field in the products table. Multiple parents can be assigned in the administration panel after the product is created.
  ![screenshot of sample](https://screenshots.firefoxusercontent.com/images/d0667b7e-a206-41ae-bcd4-edf7743aa3c8.png)

#### This is how the display of multiple categories on a product looks
![screenshot of sample](https://screenshots.firefoxusercontent.com/images/d0038a9c-7da9-4ed2-b260-364aecfe1e6b.png)

## Project Structure Summary:
The project consists of controller files, one for each function. Each controller/function has its own viewer. The project also includes an `assets` folder containing Bootstrap, jQuery, FontAwesome.otf, etc.

## Project Structure:

| File/Folder Name | Description |
|------------------|-------------|
| `assets/` | Contains local Bootstrap, DataTables, jQuery, styles, fonts |
| `index.php` | Main front controller managing the application entry point |
| `models/` | Contains models for user, product, order management |
| `adminProductController.php` | Admin controller for product database operations |
| `userController.php` | Controller for user authentication and verification |
| `cartController.php` | Controller for shopping cart functionality |
| `adminCategoryController.php` | Admin controller for product category management |
| `adminOrderController.php` | Admin controller for order management |
| `cabinetController.php` | Controller for user cabinet/profile management |
| `siteController.php` | Main site controller for public pages |
| `views/` | Contains all view templates for data presentation |
| `upload/` | Directory for uploaded product images |
| `config/` | Configuration files directory |
| `layouts/` | Site header and footer template files |
| `catalog.sql` | Database schema with field documentation |


The main page consists of three view files loaded sequentially in the main controller: header.php + main_view.php + footer.php create the starting page. Consequently, header.php and footer.php are used for creating the site's footer and header. From the starting page, you can immediately go to the authorization page.

Adding products to the cart works via Ajax (for instantaneous change of the cart icon) + a controller function.

Future Versions and Changes
In the next version, I still hope to implement several parents for one product. Please leave suggestions and corrections in the code commenting branch. For contact, I am on LinkedIn.