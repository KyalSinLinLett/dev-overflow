# Laravel+Vue based social network. (Dev-Overflow)

## Pusher
You will also need to set up a [Pusher](https://pusher.com/) account and create your own project to get the APP credentials to fill in the .env file so that the notifications and the chat feature works.

## Installation

Firstly, you need to have [composer](https://getcomposer.org/download/), [PHP](https://www.apachefriends.org/download.html) and [npm](https://nodejs.org/en/download/) to work with this project.

Now, follow these 11 easy steps to have the project running on your local machine.

### Step 1:
Clone this repository onto your local machine.
```bash
git clone https://github.com/KyalSinLinLett/dev-overflow.git
```

### Step 2:
**cd** into your project
```bash
cd dev-overflow
```

### Step 3:
Install composer dependencies
```bash
composer install
```
### Step 4:
Install npm dependencies
```bash
npm install
```
### Step 5:
Make a copy of the *.env.example* file and name it *.env*. You can now open this project with your preferred text editor to fill out the configuration details such as database and APP_KEY value.
```bash
cp .env.example .env
```
### Step 6:
You now have to generate an APP_KEY that will be automatically filled in, in your *.env* file.
```bash
php artisan key:generate
```
### Step 7:
Our web application requires a database. Create an empty database for your project using the database tool you prefer. If you had installed [XAMPP](https://www.apachefriends.org/download.html), then you could use **phpmyadmin** to set up your database.

### Step 8:
In the .env file, fill the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created.

### Step 9:
Now you can run migrations and the tables will be generated for you.
```bash
php artisan migrate
```
### Step 10:
Create a symlink to link the files under storage with public.
```bash
php artisan storage:link
```
### Step 11:
The project is ready to be served on your local machine.
```bash
php artisan serve
npm run watch
```
## License
[MIT](https://choosealicense.com/licenses/mit/)
