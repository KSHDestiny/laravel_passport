# Laravel Employee CRUD with Passport Package

### Database Tables Name
**laravel_passport**

### Installation
**Clone the Repo:**

*terminal*
 - git clone https://github.com/KSHDestiny/laravel_passport.git
 - code Laravel_Passport

**Project Setup:**

*terminal*
 - npm install
 - composer update
 - cp .env.example .env
 - php artisan key:generate
 - php artisan migrate:fresh --seed
 - php artisan passport:install
 - php artisan serve
 - npm run dev

### To Login
> email : admin@gmail.com, password : password  
> email : destiny@gmail.com, password : password

### For API Testing
`http://127.0.0.1:8000/api/register` POST Method  
`http://127.0.0.1:8000/api/login` POST Method  
`http://localhost:8000/api/employee` GET Method  
`http://localhost:8000/api/employee` POST Method  
`http://localhost:8000/api/employee/6` POST Method  
`http://localhost:8000/api/employee/6` DELETE Method

*Note*
I added some feature assuming user as organization and with their employees. 
Organization can only access to interact with their employees but not employees from other organization. 
Unauthorized Organization to access employees from other organizations are blocked by 403 Forbidden. 
If this feature is overdued to deadline (2 days), you can skip it and just check previous commit.
