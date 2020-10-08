1) Go to your projects folder and clone the project (git clone https://github.com/samborskyalexandr/book_catalog.git <project_filder_name>)
2) Go to the new project root directory
3) Install dependencies - run "composer install"
4) Copy .env.example file and rename it to .env
5) Create database and set up connection in the .env file - change configs DB_DATABASE, DB_USERNAME, DB_PASSWORD
6) Generate application key - run "php artisan key:generate"
7) Run migrations "php artisan migrate"
8) Create the symbolic link - run "php artisan storage:link"
9) Run your server
