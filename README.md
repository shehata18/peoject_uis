# Laravel Project Setup Instructions

## Cloning the Project
First, clone the repository to your local machine using the following command:
````
git clone https://github.com/shehata18/peoject_uis
````

## Configuration
1- .env file should not upload, so i encrypted .env file to upload it , Now you can decrypt this file by this command
with this flag ```--key=base64:dc5VHFt98nfVU1ZPwC9qY9yiEyGlmsQvuUK+xpjNmCQ= ```
```
php artisan env:decrypt --key=base64:dc5VHFt98nfVU1ZPwC9qY9yiEyGlmsQvuUK+xpjNmCQ=
```

2- Change the database name to project_uis in the .env file:
```
DB_DATABASE=project_uis
```
![code](https://github.com/user-attachments/assets/85ba19bd-e9ed-4f7d-b65b-00ced709ee21)


3- At the end of the .env file, add this line:
```
WEBHOOK_URL=https://webhook.site/3e07ad06-96a0-4544-ace5-3b00d35ba073
```
## Setting Up the Database
You have two options to set up your database:
# Option 1: Using Migrations
Run the following command to migrate the database:
```
php artisan migrate
```
# Option 2: Using a Local Server
Run XAMPP or any local server to import the database. 
Database file called `project_uis.sql` , will found in project files
Make sure the database name matches `project_uis`.

# Running the Project
To start the project, use the following command:
```
php artisan serve
```
You will get a URL like http://127.0.0.1:8000.

# Running Frontend Assets
Run this command to compile the frontend assets
```
npm run dev
```

Accessing the Application
* Open the URL http://127.0.0.1:8000 in your browser.
* In the navigation bar, you will find options to Register or Login.
* After logging in, you can browse products, place orders, and view details of products or orders.

## API Documentation
To browse the API documentation, navigate to:
````
http://127.0.0.1:8000/api/documentation
````

![L5-Swagger-UI](https://github.com/user-attachments/assets/c0073f1e-70cf-4597-a9cb-d13b9c3dbaf4)


### Testing Webhook
To test the webhook when calling (PUT) /api/orders/{order} to change order status, 
open this link in your browser to see the result of the webhook:
https://webhook.site/#!/view/3e07ad06-96a0-4544-ace5-3b00d35ba073

![image](https://github.com/user-attachments/assets/2b02532d-da57-4567-9ac6-96ef5fd5ec68)



This README file provides clear and concise instructions for setting up and running your Laravel project.
