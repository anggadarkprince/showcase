<?php

namespace App\Http\Controllers;

use App\Jobs\SendDiscoveryEmail;
use App\Mail\UserRegistered;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function __invoke(Request $request)
    {
        echo '<!doctype html>';
        echo '<html>';
        echo '<head>';
        echo '<title>Laravel Helper</title>';
        echo '<style>body{ font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }</style>';
        echo '<style>body{ padding: 20px; }</style>';
        echo '<style>hr{ margin-bottom: 30px; opacity: 0.3; }</style>';
        echo '</head>';
        echo '<body>';
        switch ($request->get('help')) {
            case 'array':
                $this->array_helper();
                break;
            case 'path':
                $this->path_helper();
                break;
            case 'string':
                $this->string_helper();
                break;
            case 'url':
                $this->url_helper();
                break;
            case 'misc':
                $this->misc_helper();
                break;
            case 'all':
                $this->array_helper();
                $this->path_helper();
                $this->string_helper();
                $this->url_helper();
                $this->misc_helper();
                break;
            default:
                echo 'add parameter ?help=[array, path, string, url, misc, or all]';
        }
        echo '</body>';
        echo '</html>';
    }

    private function print_title($title)
    {
        $array_title = explode(' ', $title);
        echo '<p style="margin-bottom: 20px;">';
        echo '<strong style="color: dodgerblue">' . array_pull($array_title, 0) .
            '</strong> &nbsp; <span style="opacity:0.5">' . implode(' ', $array_title) . '</span>';
        echo '</p>';
    }

    private function print_data($data, $separator = true)
    {
        echo "<br><strong>Result:</strong>";
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($separator) {
            echo '<hr>';
        }
    }

    private function print_code($code)
    {
        echo '<pre>';
        echo '<code>' . $code . '</code>';
        echo '</pre>';
    }

    private function array_helper()
    {
        echo '<h3 style="margin-bottom: 30px">Array Helper</h3>';

        $this->print_title("array_add() adds a given key / value pair");
        $this->print_code("array_add(['name' => 'Desk'], 'price', 100);");
        $array = array_add(['name' => 'Desk'], 'price', 100);
        $this->print_data($array);
        // ['name' => 'Desk', 'price' => 100]

        $this->print_title("array_prepend() will push an item onto the beginning of an array");
        $this->print_code("\$array = ['one', 'two', 'three', 'four'];");
        $this->print_code("\$array = array_prepend(\$array, 'zero');");
        $array = ['one', 'two', 'three', 'four'];
        $array = array_prepend($array, 'zero');
        $this->print_data($array);
        // $array: ['zero', 'one', 'two', 'three', 'four']

        $this->print_title("array_forget() removes a given key / value pair from a deeply nested array");
        $this->print_code("\$array = ['products' => ['desk' => ['price' => 100], 'chair' => 200]];");
        $this->print_code("array_forget(\$array, 'products.desk');");
        $array = ['products' => ['desk' => ['price' => 100], 'chair' => 200]];
        array_forget($array, 'products.desk');
        $this->print_data($array);
        // ['products' => ['chair' => 200]]

        $this->print_title("array_pull() returns and removes a key / value pair from the array");
        $this->print_code("\$array = ['name' => 'Desk', 'price' => 100];");
        $this->print_code("\$name = array_pull(\$array, 'name');");
        $array = ['name' => 'Desk', 'price' => 100];
        $name = array_pull($array, 'name');
        $this->print_data('$name: ' . $name, false);
        $this->print_data($array);
        // $name: Desk
        // $array: ['price' => 100]

        $this->print_title("array_collapse() collapses an array of arrays into a single array");
        $this->print_code("\$array = array_collapse([[1, 2, ['a', 'b']], [4, 5, 6], [7, 8, 9]]);");
        $array = array_collapse([[1, 2, ['a', 'b']], [4, 5, 6], [7, 8, 9]]);
        $this->print_data($array);
        // [1, 2, [a, b], 4, 5, 6, 7, 8, 9]

        $this->print_title("array_flatten() flatten a multi-dimensional array into a single level");
        $this->print_code("\$array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby', [0 => 'Java']]];");
        $this->print_code("\$array = array_flatten(\$array);");
        $array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby', [0 => 'Java']]];
        $array = array_flatten($array);
        $this->print_data($array);
        // ['Joe', 'PHP', 'Ruby', 'Java'];

        $this->print_title("array_divide() returns two arrays, one containing the keys, and the other containing the values");
        $this->print_code("list(\$keys, \$values) = array_divide(['up' => 'Desk', 'down' => 'Chair']);");
        list($keys, $values) = array_divide(['up' => 'Desk', 'down' => 'Chair']);
        $this->print_data($keys, false);
        $this->print_data($values);
        // $keys: ['up', 'down']
        // $values: ['Desk', 'Chair']

        $this->print_title("array_dot() flattens a multi-dimensional array into a single level array that uses \"dot\" notation");
        $this->print_code("\$array = array_dot(['foo' => ['bar' => 'baz']]);");
        $array = array_dot(['foo' => ['bar' => 'baz']]);
        $this->print_data($array);
        // ['foo.bar' => 'baz'];

        $this->print_title("array_except() removes the given key / value pairs from the array");
        $this->print_code("\$array = ['name' => 'Desk', 'price' => 100, 0 => 50];");
        $this->print_code("\$array = array_except(\$array, ['price', 0]);");
        $array = ['name' => 'Desk', 'price' => 100, 0 => 50];
        $array = array_except($array, ['price', 0]);
        $this->print_data($array);
        // ['name' => 'Desk']

        $this->print_title("array_only() return only the specified key / value pairs from the given array");
        $this->print_code("\$array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];");
        $this->print_code("\$array = array_only(\$array, ['name', 'price']);");
        $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
        $array = array_only($array, ['name', 'price']);
        $this->print_data($array);
        // ['name' => 'Desk', 'price' => 100]

        $this->print_title("head() simply returns the first element in the given array");
        $this->print_code("\$array = head([100, 200, 300]);");
        $array = [100, 200, 300];
        $first = head($array);
        $this->print_data($first);
        // 100

        $this->print_title("array_first() returns the first element of an array passing a given truth test");
        $this->print_code("\$array = [100, 200, 300];");
        $this->print_code("\$value = array_first(\$array, function (\$value, \$key) {");
        $this->print_code("     return \$value >= 150;");
        $this->print_code("}, 'default value here');");
        $array = [100, 200, 300];
        $value = array_first($array, function ($value, $key) {
            return $value >= 150;
        }, 'default value here');
        $this->print_data($value);
        // 200

        $this->print_title("last() simply returns the last element in the given array");
        $this->print_code("\$array = last([100, 200, 300]);");
        $array = [100, 200, 300];
        $last = last($array);
        $this->print_data($last);
        // 300

        $this->print_title("array_last() returns the last element of an array passing a given truth test");
        $this->print_code("\$array = [100, 200, 300, 110];");
        $this->print_code("\$value = array_last(\$array, function (\$value, \$key) {");
        $this->print_code("     return \$value >= 150;");
        $this->print_code("}, 'default value here');");
        $array = [100, 200, 300, 110];
        $value = array_last($array, function ($value, $key) {
            return $value >= 150;
        }, 'default value here');
        $this->print_data($value);
        // 300

        $this->print_title("array_where() function filters the array using the given Closure");
        $this->print_code("\$array = [100, '200', 300, '400', 500];");
        $this->print_code("\$array = array_where(\$array, function (\$value, \$key) {");
        $this->print_code("     return is_string(\$value) || \$value < 200;");
        $this->print_code("});");
        $array = [100, '200', 300, '400', 500];
        $array = array_where($array, function ($value, $key) {
            return is_string($value) || $value < 200;
        });
        $this->print_data($array);
        // [1 => 200, 3 => 400]

        $this->print_title("array_get() retrieves a value from a deeply nested array");
        $this->print_code("\$array = ['products' => ['desk' => ['price' => 100]]];");
        $this->print_code("\$value = array_get(\$array, 'products.desk', 'default');");
        $array = ['products' => ['desk' => ['price' => 100]]];
        $value = array_get($array, 'products.desk', 'default');
        $this->print_data($value);
        // ['price' => 100]

        $this->print_title("array_set()  sets a value from a deeply nested array");
        $this->print_code("\$array = ['products' => ['desk' => ['price' => 100]]];");
        $this->print_code("array_set(\$array, 'products.desk.price', 200);");
        $array = ['products' => ['desk' => ['price' => 100]]];
        array_set($array, 'products.desk.price', 200);
        $this->print_data($array);
        // ['products' => ['desk' => ['price' => 200]]]

        $this->print_title("array_has() checks that a given item or items exists in an array");
        $this->print_code("\$array = ['product' => ['name' => 'desk', 'price' => 100]];");
        $this->print_code("\$hasItem = array_has(\$array, 'product.name');");
        $array = ['product' => ['name' => 'desk', 'price' => 100]];
        $hasItem = array_has($array, 'product.name');
        $this->print_data($hasItem, false);
        // true
        $this->print_code("\$hasItems = array_has(\$array, ['product.price', 'product.discount']);");
        $hasItems = array_has($array, ['product.price', 'product.discount']);
        $this->print_data($hasItems);
        // false

        $this->print_title("array_pluck() pluck a list of the given key / value pairs from the array");
        $this->print_code("\$array = [");
        $this->print_code("     ['developer' => ['id' => 1, 'name' => 'Taylor']],");
        $this->print_code("     ['developer' => ['id' => 2, 'name' => 'Abigail']],");
        $this->print_code("];");
        $this->print_code("\$array = array_pluck(\$array, 'developer.name', 'developer.id');");
        $array = [
            ['developer' => ['id' => 1, 'name' => 'Taylor']],
            ['developer' => ['id' => 2, 'name' => 'Abigail']],
        ];
        $array = array_pluck($array, 'developer.name', 'developer.id');
        $this->print_data($array);
        // [1 => 'Taylor', 2 => 'Abigail'];

        $this->print_title("array_values() sorts the array by the results of the given Closure");
        $this->print_code("\$array = [");
        $this->print_code("     ['name' => 'Desk'],");
        $this->print_code("     ['name' => 'Chair'],");
        $this->print_code("];");
        $this->print_code("\$array = array_values(array_sort(\$array, function (\$value) {");
        $this->print_code("     return \$value['name'];");
        $this->print_code("}));");
        $array = [
            ['name' => 'Desk'],
            ['name' => 'Chair'],
        ];
        $array = array_values(array_sort($array, function ($value) {
            return $value['name'];
        }));
        $this->print_data($array);
        // [ ['name' => 'Chair'], ['name' => 'Desk'], ]

        $this->print_title("array_sort_recursive() recursively sorts the array using the sort function");
        $this->print_code("\$array = [
            [
                'Roman',
                'Taylor',
                'Li',
            ],
            [
                'PHP',
                'Ruby',
                'JavaScript',
                [
                    'b',
                    'c',
                    'a'
                ]
            ],
        ];");
        $this->print_code("\$array = array_sort_recursive(\$array);");
        $array = [
            [
                'Roman',
                'Taylor',
                'Li',
            ],
            [
                'PHP',
                'Ruby',
                'JavaScript',
                [
                    'b',
                    'c',
                    'a'
                ]
            ],
        ];

        $array = array_sort_recursive($array);
        $this->print_data($array);
        /*
            [
                [
                    'Li',
                    'Roman',
                    'Taylor',
                ],
                [
                    'JavaScript',
                    'PHP',
                    'Ruby',
                ]
            ];
        */

    }

    public function string_helper()
    {
        echo '<h3 style="margin-bottom: 30px">String Helper</h3>';

        $this->print_title("studly_case() function converts the given string to StudlyCase");
        $this->print_code("\$value = studly_case('foo_bar');");
        $value = studly_case('foo_bar');
        $this->print_data($value);
        // FooBar

        $this->print_title("camel_case() converts the given string to camelCase");
        $this->print_code("\$camel = camel_case('foo_bar');");
        $camel = camel_case('foo_bar');
        $this->print_data($camel);
        // fooBar

        $this->print_title("snake_case() converts the given string to snake_case");
        $this->print_code("\$snake = snake_case('fooBar');");
        $snake = snake_case('fooBar');
        $this->print_data($snake);
        // foo_bar

        $this->print_title("title_case() converts the given string to Title Case");
        $this->print_code("\$title = title_case('a nice title uses the correct case');");
        $title = title_case('a nice title uses the correct case');
        $this->print_data($title);
        // A Nice Title Uses The Correct Case

        $this->print_title("str_plural() converts a string to its plural form");
        $this->print_code("\$plural1 = str_plural('car');");
        $this->print_code("\$plural2 = str_plural('child');");
        $plural1 = str_plural('car');
        $plural2 = str_plural('child');
        $plural_keep = str_plural($plural2, 1);
        $this->print_data(compact('plural1', 'plural2', 'plural_keep'));
        // [plural1] => cars
        // [plural2] => children
        // [plural_keep] => children

        $this->print_title("str_singular() converts a string to its singular form");
        $this->print_code("\$singular = str_singular('cars');");
        $singular = str_singular('cars');
        $this->print_data($singular);
        // car

        $this->print_title("str_random() generates a random string of the specified length");
        $this->print_code("\$string = str_random(40);");
        $string = str_random(40);
        $this->print_data($string);
        // hTpIDXV0GgXQgdaGxKoJ2Pj8h3r6KEvxNjpyro9f

        $this->print_title("str_contains() determines if the given string contains the given value");
        $this->print_code("\$value = str_contains('This is my name', ['my', 'is']);");
        $value = str_contains('This is my name', ['my', 'is']);
        $this->print_data($value);
        // true

        $this->print_title("str_limit() limits the number of characters in a string");
        $this->print_code("\$value = str_limit('The PHP framework for web artisans.', 7);");
        $value = str_limit('The PHP framework for web artisans.', 7);
        $this->print_data($value);
        // The PHP...

        $this->print_title("str_is() determines if a given string matches a given pattern");
        $this->print_code("\$valueTrue = str_is('foo*', 'foobar');");
        $this->print_code("\$valueFalse = str_is('baz*', 'foobar');");
        $valueTrue = str_is('foo*', 'foobar');
        $valueFalse = str_is('baz*', 'foobar');
        $this->print_data(compact('valueTrue', 'valueFalse'));
        // [valueTrue] => 1
        // [valueFalse] => 0

        $this->print_title("e() runs htmlspecialchars over the given string");
        $this->print_code("\$htmlentities = e('<html>foo</html>');");
        $htmlentities = e('<html>foo</html>');
        $this->print_data($htmlentities);
        // &lt;html&gt;foo&lt;/html&gt;

        $this->print_title("ends_with() determines if the given string ends with the given value");
        $this->print_code("\$value = ends_with('This is my name', 'name');");
        $value = ends_with('This is my name', 'name');
        $this->print_data($value);
        // true

        $this->print_title("starts_with() determines if the given string begins with the given value");
        $this->print_code("\$value = starts_with('This is my name', 'This');");
        $value = starts_with('This is my name', 'This');
        $this->print_data($value);
        // true

        $this->print_title("str_finish() adds a single instance of the given value to a string");
        $this->print_code("\$string = str_finish('this/string', '/');");
        $string = str_finish('this/string', '/');
        $this->print_data($string);
        // this/string/

        $this->print_title("trans() translates the given language line using your localization files");
        $this->print_code("\$value = trans('validation.required', ['attribute' => 'name']);");
        $value = trans('validation.required', ['attribute' => 'name']);
        $this->print_data($value);
        // The Name field is required.

        $this->print_title("trans_choice() translates the given language line with inflection");
        $this->print_code("\$value = trans_choice('validation.required', 2, ['attribute' => 'name'], 'messages', 'id');");
        $value = trans_choice('validation.required', 2, ['attribute' => 'name'], 'messages', 'id');
        $this->print_data($value);
        // The Name field is required.

        $this->print_title("class_basename() returns the class name of the given class with the class namespace removed");
        $this->print_code("\$class = class_basename(User::class);");
        $class = class_basename(User::class);
        $this->print_data($class);
        // User
    }

    private function path_helper()
    {
        echo '<h3 style="margin-bottom: 30px">Path Helper</h3>';

        $this->print_title("app_path() returns the fully qualified path to the app directory");
        $this->print_code("\$path_base = app_path();");
        $this->print_code("\$path = app_path('Http/Controllers/Controller.php');");
        $path_app = app_path();
        $path = app_path('Http/Controllers/Controller.php');
        $this->print_data(compact('path_app', 'path'));
        // [path_base] /media/sf_laravel-blog/app
        // [path] => /media/sf_laravel-blog/app/Http/Controllers/Controller.php

        $this->print_title("base_path() returns the fully qualified path to the project root");
        $this->print_code("\$path_base = base_path();");
        $this->print_code("\$path = base_path('vendor/bin');");
        $path_base = base_path();
        $path = base_path('vendor/bin');
        $this->print_data(compact('path_base', 'path'));

        $this->print_title("config_path() returns the fully qualified path to the application configuration directory");
        $this->print_code("\$path = config_path();");
        $path = config_path();
        $this->print_data($path);

        $this->print_title("database_path() returns the fully qualified path to the application's database directory");
        $this->print_code("\$path = config_path();");
        $path = database_path();
        $this->print_data($path);

        $this->print_title("elixir() function gets the path to a versioned Elixir file");
        $this->print_code("\$path = elixir('css/app.css');");
        $path = elixir('css/app.css');
        $this->print_data($path);

        $this->print_title("public_path() function returns the fully qualified path to the public directory");
        $this->print_code("\$path = public_path();");
        $path = public_path();
        $this->print_data($path);

        $this->print_title("resource_path() function returns the fully qualified path to the resources directory");
        $this->print_code("\$path_resource = resource_path();");
        $this->print_code("\$path = resource_path('assets/sass/app.scss');");
        $path_resource = resource_path();
        $path = resource_path('assets/sass/app.scss');
        $this->print_data(compact('path_resource', 'path'));

        $this->print_title("storage_path() function returns the fully qualified path to the storage directory");
        $this->print_code("\$path_storage = storage_path();");
        $this->print_code("\$path = storage_path('app/public/screenshots/placeholder.jpg');");
        $path_storage = storage_path();
        $path = storage_path('assets/sass/app.scss');
        $this->print_data(compact('path_storage', 'path'));
    }

    private function url_helper()
    {
        echo '<h3 style="margin-bottom: 30px">URLs Helper</h3>';

        $this->print_title("action() returns generates a URL for the given controller action");
        $this->print_code("\$url_index = action('PageController@explore');");
        $this->print_code("\$url_param = action('UserController@show', ['user' => 'anggadarkprince']);");
        $url_index = action('PageController@explore');
        $url_param = action('UserController@show', ['user' => 'anggadarkprince']);
        $this->print_data(compact('url_index', 'url_param'));
        // [url_index] => http://laravel.dev:8080/explore
        // [url_param] => http://account.laravel.dev:8080/anggadarkprince

        $this->print_title("asset() generate a URL for an asset using the current scheme of the request (HTTP or HTTPS)");
        $this->print_code("\$url = asset('img/layout/icon-twitter.jpg');");
        $url = asset('img/layout/icon-twitter.jpg');
        $this->print_data($url);
        // http://laravel.dev:8080/img/layout/icon-twitter.jpg

        $this->print_title("secure_asset() generate a URL for an asset using HTTPS:");
        $this->print_code("\$url = secure_asset('img/layout/icon-twitter.jpg');");
        $url = secure_asset('img/layout/icon-twitter.jpg');
        $this->print_data($url);
        // https://laravel.dev:8080/img/layout/icon-twitter.jpg

        $this->print_title("route() function generates a URL for the given named route");
        $this->print_code("\$url = route('profile.show', ['user' => 'anggadarkprince']);");
        $url = route('profile.show', ['user' => 'anggadarkprince']);
        $this->print_data($url);
        // http://laravel.dev:8080/anggadarkprince

        $this->print_title("url() function generates a fully qualified URL to the given path");
        $this->print_code("\$url_current = url()->current();");
        $this->print_code("\$url_full = url()->full();");
        $this->print_code("\$url_previous = url()->previous();");
        $this->print_code("\$url_base = url('/');");
        $this->print_code("\$url_path = url('anggadarkprince/profile/whibo-23');");
        $url_current = url()->current();
        $url_full = url()->full();
        $url_previous = url()->previous();
        $url_base = url('/');
        $url_path = url('anggadarkprince/profile/whibo-23');
        $this->print_data(compact('url_current', 'url_full', 'url_previous', 'url_base', 'url_path'));
        // [url_current] => http://laravel.dev:8080/helper
        // [url_full] => http://laravel.dev:8080/helper?help=url
        // [url_previous] => http://laravel.dev:8080/helper?help=url
        // [url_base] => http://laravel.dev:8080
        // [url_path] => http://laravel.dev:8080/anggadarkprince/profile/whibo-23
    }

    private function misc_helper()
    {
        echo '<h3 style="margin-bottom: 30px">Misc Helper</h3>';

        $this->print_title("abort() throws a HTTP exception which will be rendered by the exception handler");
        $this->print_code("abort(401, 'Unauthorized.');");
        // abort(401, 'Unauthorized.');
        $this->print_data('void');

        $this->print_title("abort_if() throws a HTTP exception if a given boolean expression evaluates to true");
        $this->print_code("abort_if(! Auth::user()->active, 403);");
        // abort_if(! Auth::user()->active, 403);
        $this->print_data('void');

        $this->print_title("abort_if() throws a HTTP exception if a given boolean expression evaluates to false");
        $this->print_code("abort_unless(Auth::user()->active, 403);");
        // abort_unless(Auth::user()->active, 403);
        $this->print_data('void');

        $this->print_title("auth() returns an authenticator instance. You may use it instead of the Auth facade");
        $this->print_code("\$user = auth()->user();");
        $user = auth()->user();
        $this->print_data($user->toArray());

        $this->print_title("back() generates a redirect response to the user's previous location");
        $this->print_code("back()");
        $this->print_data('void');

        $this->print_title("bcrypt() hashes the given value using Bcrypt. You may use it as an alternative to the Hash facade");
        $this->print_code("\$password = bcrypt('my-secret-password');");
        $password = bcrypt('my-secret-password');
        $this->print_data($password);

        $this->print_title("cache() may be used to get values from the cache");
        $this->print_code("cache(['key' => 'value of cache'], 5);");
        $this->print_code("cache(['stats' => 34500], Carbon::now()->addSeconds(10));");
        $this->print_code("\$value1 = cache('key');");
        $this->print_code("\$value2 = cache('key', 'default');");
        cache(['key' => 'value of cache'], 5);
        cache(['stats' => 34500], Carbon::now()->addSeconds(10));
        $value1 = cache('key');
        $value2 = cache('visitor', 'default');
        $this->print_data(compact('value1', 'value2'));
        // [value1] => value of cache
        // [value2] => default

        $this->print_title("collect() creates a collection instance from the given array");
        $this->print_code("\$collection = collect(['taylor', 'abigail']);");
        $collection = collect(['taylor', 'abigail']);
        $this->print_data($collection);

        $this->print_title("config() gets or sets the value of a configuration variable");
        $this->print_code("config(['app.debug' => true]);");
        $this->print_code("\$value = config('app.locale', 'id');");
        config(['app.debug' => true]);
        $value = config('app.locale', 'id');
        $this->print_data($value);

        $this->print_title("method_field() generates an HTML hidden input field containing the spoofed value of the form's HTTP verb");
        $this->print_code("{{ method_field('DELETE') }}");
        echo method_field('DELETE');

        $this->print_title("csrf_field() generates an HTML hidden input field containing the value of the CSRF token");
        $this->print_code("{{ csrf_field() }}");
        echo csrf_field();

        $this->print_title("csrf_token() retrieves the value of the current CSRF token");
        $this->print_code("\$token = csrf_token();");
        $token = csrf_token();
        $this->print_data($token);

        $this->print_title("dd() dumps the given variables and ends execution");
        $this->print_code("dd(\$value1, \$value2, \$value3, ...);");
        // dd($value1, $value2, $value3, ...);
        $this->print_data('void');

        $this->print_title("dispatch() pushes a new job onto the Laravel job queue");
        $this->print_code("dispatch(new SendDiscoveryEmail(\$portfolio, \$admin));");
        // dispatch(new SendDiscoveryEmail($portfolio, $admin));
        $this->print_data('void');

        $this->print_title("dispatch() function dispatches the given event to its listeners");
        $this->print_code("event(new UserRegistered(\$user));");
        // event(new UserRegistered($user));
        $this->print_data('void');

        $this->print_title("env() gets the value of an environment variable or returns a default value");
        $this->print_code("\$env = env('APP_ENV', 'production');");
        $env = env('APP_ENV');
        // Return a default value if the variable doesn't exist...
        $env = env('APP_ENV', 'production');
        $this->print_data($env);

        $this->print_title("factory() creates a model factory builder for a given class, name, and amount. It can be used while testing or seeding");
        $this->print_code("\$user = factory(User::class)->make();");
        $user = factory(User::class)->make();
        $this->print_data($user->toArray());

        $this->print_title("info() will write information to the log");
        $this->print_code("info('User login attempt failed.', ['name' => \$user->name]);");
        info('User login attempt failed.', ['name' => $user->name]);
        $this->print_data('void');

        $this->print_title("logger() can be used to write a debug level message to the log");
        $this->print_code("logger('User login attempt failed.', ['name' => $user->name]);");
        $this->print_code("logger()->error('You are not allowed here.');");
        logger('User login attempt failed.', ['name' => $user->name]);
        logger()->error('You are not allowed here.');
        $this->print_data('void');

        $this->print_title("old() retrieves an old input value flashed into the session");
        $this->print_code("\$value = old('value', 'default');");
        $value = old('value');
        $value = old('value', 'default');
        $this->print_data($value);

        $this->print_title("redirect() returns a redirect HTTP response, or returns the redirector instance if called with no arguments");
        $this->print_code("redirect('/home');");
        $this->print_code("redirect()->route('route.name');");
        redirect('/home');
        redirect()->route('page.about');
        $this->print_data('RedirectResponse');

        $this->print_title("request() returns the current request instance or obtains an input item");
        $this->print_code("\$request = request();");
        $this->print_code("\$value = request('help', \$default = 'nothing');");
        $request = request()->all();
        $value = request('help', $default = 'nothing');
        $this->print_data(compact('request', 'value'));

        $this->print_title("response() creates a response instance or obtains an instance of the response factory");
        $this->print_code("return response('Hello World', 200, \$headers);");
        $this->print_code("return response()->json(['foo' => 'bar'], 200, \$headers);");

        $headers = [
            'Content-Type' => 'text/plain'
        ];
        response('Hello World', 200, $headers);
        response()->json(['foo' => 'bar'], 200, $headers);
        $this->print_data('Response');

        $this->print_title("session() may be used to get or set session values");
        $this->print_code("session(['chairs' => 7, 'instruments' => 3]);");
        $this->print_code("\$value1 = session('chairs', 'default');");
        $this->print_code("The session store will be returned if no value is passed to the function:");
        $this->print_code("\$value2 = session()->get('instruments');');");
        $this->print_code("session()->put('key', \$value2);");
        session(['chairs' => 7, 'instruments' => 3]);
        $value1 = session('chairs', 'default');
        $value2 = session()->get('instruments');
        session()->put('key', $value2);
        $this->print_data(compact('value1', 'value2'));

        $this->print_title("value() function's behavior will simply return the value it is given");
        $this->print_code("\$value = value(function () {
                return 'bar';
            });");
        $value = value(function () {
            return 'bar';
        });
        $this->print_data($value);

        $this->print_title("view() function retrieves a view instance");
        $this->print_code("view('auth.login');");
        view('auth.login');
        $this->print_data('View');
    }
}
