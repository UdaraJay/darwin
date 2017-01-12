# Darwin
A simple active learning tool for you and your friends.
All this app does is test you daily with questions from anything you're learning.

## Getting started
Darwin was built on [Laravel](http://laravel.com) 5.3. Reference Laravel documentation for further information.
You can run the following code to get started.

**Create a .env file with appropriate environment variables. (use `.env.example` for reference)**

While Laravel comes with a authentication wrapper. Darwin primarily utilizes Facebook login. If you choose to use Facebook login then setup a Facebook app using their developer portal and include the tokens in the .env file. 

**Install dependencies and Laravel using Composer**
````
composer install
````

**Migrate database tables:**
````
php artisan migrate
````

**This command will start a development server at http://localhost:8000:**
````
php artisan serve
````

## Credits
Darwin was built thanks to the following open-source resources:

1. [Laravel](http://laravel.com)

2. [SlickQuiz](https://github.com/jewlofthelotus/SlickQuiz)

3. [SelectizeJS](http://selectize.github.io/selectize.js/)


## License
Darwin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
