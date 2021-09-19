### Installation 
After cloning this repo create an .env file and copy everything from .env.example<br>
<pre> cp .env.example .env </pre>
It will create a copy of .env.example as .env <br><br>
Now open the .env file you just created and give a database name on DB_DATABASE as you want<br>
Suppose the database name is routine<br>
The database configuration will look like this<br>
<pre>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=routine
DB_USERNAME=root
DB_PASSWORD=</pre>
After that create a database named as "routine" which I used as an example above <br><br>
Now install all composer packages <br>
<pre> composer install </pre>
Now generate an APP_KEY <br>
<pre> php artisan key:generate </pre>
Then run migration as well as db:seed command to get some pre-existing data to get started with the project<br>
<pre> php artisan migrate:fresh --seed </pre>
Now you can serve the project or run with xampp anyway you prefer<br><br>
To serve with artisan <br>
<pre> php artisan serve </pre>
Now you can run the project with localserver accessing this url below:
<pre> http://127.0.0.1:8000 </pre> 
