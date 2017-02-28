<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __invoke(Request $request)
    {
        echo '<!doctype html>';
        echo '<html>';
        echo '<head>';
        echo '<title>Laravel Collection</title>';
        echo '<style>body{ font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }</style>';
        echo '<style>body{ padding: 20px; }</style>';
        echo '<style>hr{ margin-bottom: 30px; opacity: 0.3; }</style>';
        echo '</head>';
        echo '<body>';

        $this->methods();

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

    private function methods()
    {
        // example to create a Collection
        $collection = collect(['angga', 'ari', 3, null, 'KEY' => 'value'])->map(function ($value, $key) {
            return strtoupper($value);
        })->reject(function ($name) {
            return empty($name);
        });

        echo '<h3 style="margin-bottom: 30px">Collection Methods</h3>';

        $this->print_title("all() returns the underlying array represented by the collection");
        $this->print_code("\$data = collect([1, 2, 3])->all();");
        $data = collect([1, 2, 3])->all();
        $this->print_data($data);
        // [1, 2, 3]

        $this->print_title("avg() returns the average of all items in the collection");
        $this->print_code("\$data = collect([1, 2, 3, 4, 5])->avg();");
        $this->print_code("\$pages = collect([
            ['name' => 'JavaScript: The Good Parts', 'pages' => 176],
            ['name' => 'JavaScript: The Definitive Guide', 'pages' => 1096],
        ])->avg('pages');");

        $data = collect([1, 2, 3, 4, 5])->avg();
        $pages = collect([
            ['name' => 'JavaScript: The Good Parts', 'pages' => 176],
            ['name' => 'JavaScript: The Definitive Guide', 'pages' => 1096],
        ])->avg('pages');
        $this->print_data(compact('data', 'pages'));
        // 3, 636

        $this->print_title("chunk() breaks the collection into multiple, smaller collections of a given size");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5, 6, 7]);");
        $this->print_code("\$chunks = \$collection->chunk(4);");
        $collection = collect([1, 2, 3, 4, 5, 6, 7]);
        $chunks = $collection->chunk(4);
        $this->print_data($chunks->toArray());
        // [[1, 2, 3, 4], [5, 6, 7]]

        $this->print_title("collapse() collapses a collection of arrays into a single, flat collection");
        $this->print_code("\$collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);");
        $this->print_code("\$collapsed = \$collection->collapse();");
        $collection = collect([[1, ['a', 'b'], 3], [4, 5, 6], [7, 8, 9]]);
        $collapsed = $collection->collapse();
        $this->print_data($collapsed->all());
        // [1, ['a', 'b'], 3, 4, 5, 6, 7, 8, 9]

        $this->print_title("combine() combines the keys of the collection with the values of another array or collection");
        $this->print_code("\$collection = collect(['name', 'age']);");
        $this->print_code("\$combined = \$collection->combine(['George', 29]);");
        $collection = collect(['name', 'age']);
        $combined = $collection->combine(['George', 29]);
        $this->print_data($combined->all());
        // ['name' => 'George', 'age' => 29]

        $this->print_title("contains() determines whether the collection contains a given item");
        $this->print_code("\$collection = collect(['name' => 'Desk', 'price' => 100]);");
        $this->print_code("\$isContain = collection->contains('Desk');");
        $this->print_code("\$contain = collection->contains(function (\$value, \$key) {
            return \$value > 5;
        });");
        $collection = collect(['name' => 'Desk', 'price' => 100]);
        $isContain = $collection->contains('Desk');
        // $collection->contains('product', 'Bookcase');
        $contain = $collection->contains(function ($value, $key) {
            return $value > 5;
        });
        $this->print_data(compact('isContain', 'contain'));
        // true

        $this->print_title("count() returns the total number of items in the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4])->count();");
        $collection = collect([1, 2, 3, 4])->count();
        $this->print_data($collection);
        // 4

        $this->print_title("diff() compares the collection against another collection or a plain PHP array based on its values");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5]);");
        $this->print_code("\$diff = \$collection->diff([2, 4, 6, 8]);");
        $collection = collect([1, 2, 3, 4, 5]);
        $diff = $collection->diff([2, 4, 6, 8]);
        $this->print_data($diff->all());
        // [1, 3, 5]

        $this->print_title("diffKeys() compares the collection against another collection or a plain PHP array based on its keys");
        $this->print_code("\$collection = collect([
            'one' => 10,
            'two' => 20,
            'three' => 30,
            'four' => 40,
            'five' => 50,
        ]);");
        $this->print_code("\$diff = \$collection->diffKeys([
            'two' => 2,
            'four' => 4,
            'six' => 6,
            'eight' => 8,
        ]);");

        $collection = collect([
            'one' => 10,
            'two' => 20,
            'three' => 30,
            'four' => 40,
            'five' => 50,
        ]);

        $diff = $collection->diffKeys([
            'two' => 2,
            'four' => 4,
            'six' => 6,
            'eight' => 8,
        ]);

        $this->print_data($diff->all());
        // ['one' => 10, 'three' => 30, 'five' => 50]

        $this->print_title("each() iterates over the items in the collection and passes each item to a callback");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5]);");
        $this->print_code("\$collection = \$collection->each(function (\$item, \$key) {
            echo \$item.',';
            if (\$item >= 3) {
                return false;
            }
        });");
        $collection = collect([1, 2, 3, 4, 5]);
        $collection = $collection->each(function ($item, $key) {
            echo $item;
            if ($item >= 3) {
                return false;
            }
        });
        $this->print_data($collection->all());
        // [1, 2, 3, 4, 5]

        $this->print_title("every() creates a new collection consisting of every n-th element (with offset)");
        $this->print_code("\$collection = collect(['a', 'b', 'c', 'd', 'e', 'f'])->every(4);");
        $collection = collect(['a', 'b', 'c', 'd', 'e', 'f'])->every(4, 1);
        $this->print_data($collection->all());
        // ['a', 'e'] / ['b', 'f'] (with offset)

        $this->print_title("except() returns all items in the collection except for those with the specified keys");
        $this->print_code("\$collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);");
        $this->print_code("\$filtered = \$collection->except(['price', 'discount']);");
        $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
        $filtered = $collection->except(['price', 'discount']);
        $this->print_data($filtered->all());
        // ['product_id' => 1]

        $this->print_title("filter() filters the collection using the given callback, keeping only those items that pass a given truth test");
        $this->print_code("\$collection = collect([1, 2, 3, 4])->filter(function (\$value, \$key) {
            return \$value > 2;
        });");
        $this->print_code("\$collectionValidValue = collect([1, 2, 3, null, false, '', 0, []])->filter();");
        $collection = collect([1, 2, 3, 4])->filter(function ($value, $key) {
            return $value > 2;
        })->all();
        $collectionValidValue = collect([1, 2, 3, null, false, '', 0, []])->filter()->all();
        $this->print_data(compact('collection', 'collectionValidValue'));
        // [3, 4]

        $this->print_title("first() returns the first element in the collection that passes a given truth test");
        $this->print_code("\$data = collect([1, 2, 3, 4])->first(function (\$value, \$key) {
            return \$value > 2;
        });");
        $this->print_code("\$first = collect([1, 2, 3, 4])->first();");
        $data = collect([1, 2, 3, 4])->first(function ($value, $key) {
            return $value > 2;
        });
        $first = collect([1, 2, 3, 4])->first();
        $this->print_data(compact('data', 'first'));
        // 1

        $this->print_title("flatMap() iterates through the collection and passes each value to the given callback which free to modify the item and return it");
        $this->print_code("\$collection = collect([['name' => 'Sally'], ['school' => 'Arkansas'], ['age' => 28]]);");
        $this->print_code("\$flattened = \$collection->flatMap(function (\$values) {
            return array_map('strtoupper', \$values);
        });");
        $collection = collect([['name' => 'Sally'], ['school' => 'Arkansas'], ['age' => 28]]);
        $flattened = $collection->flatMap(function ($values) {
            return array_map('strtoupper', $values);
        });
        $this->print_data($flattened->all());
        // ['name' => 'SALLY', 'school' => 'ARKANSAS', 'age' => '28'];

        $this->print_title("flatten() flattens a multi-dimensional collection into a single dimension");
        $this->print_code("\$collection = collect([['name' => 'Sally'], ['school' => 'Arkansas'], ['age' => 28]]);");
        $flattened = collect(['name' => 'taylor', 'languages' => ['php', 'javascript']])->flatten();
        $this->print_data($flattened->all());
        // ['taylor', 'php', 'javascript'];

        $this->print_title("flip()  swaps the collection's keys with their corresponding values");
        $this->print_code("\$flipped = collect(['name' => 'taylor', 'framework' => 'laravel'])->flip();");
        $flipped = collect(['name' => 'taylor', 'framework' => 'laravel'])->flip();
        $this->print_data($flipped->all());
        // ['taylor' => 'name', 'laravel' => 'framework']

        $this->print_title("forget() removes an item from the collection by its key");
        $this->print_code("\$collection = collect(['name' => 'taylor', 'framework' => 'laravel']);");
        $this->print_code("\$collection->forget('name');");
        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $collection->forget('name');
        $this->print_data($collection->all());
        // ['framework' => 'laravel']

        $this->print_title("forPage() returns a new collection containing the items that would be present on a given page number");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9])->forPage(2, 3);");
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9])->forPage(2, 3);
        $this->print_data($collection->all());
        // [4, 5, 6]

        $this->print_title("get() returns the item at a given key");
        $this->print_code("\$collection = collect(['name' => 'taylor', 'framework' => 'laravel']);");
        $this->print_code("\$value = \$collection->get('foo', 'default-value');");
        $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        $value = $collection->get('foo', 'default-value');
        $this->print_data($value);
        // default-value

        $this->print_title("groupBy() method groups the collection's items by a given key");
        $this->print_code("\$grouped = collect([
            ['account_id' => 'account-x10', 'product' => 'Chair'],
            ['account_id' => 'account-x10', 'product' => 'Bookcase'],
            ['account_id' => 'account-x11', 'product' => 'Desk'],
        ])->groupBy('account_id');");
        $this->print_code("\$grouped = \$collection->groupBy(function(\$item, \$key) {
            return substr(\$item['account_id'], -3);
        });");

        $grouped = collect([
            ['account_id' => 'account-x10', 'product' => 'Chair'],
            ['account_id' => 'account-x10', 'product' => 'Bookcase'],
            ['account_id' => 'account-x11', 'product' => 'Desk'],
        ])->groupBy('account_id');
        $this->print_data($grouped->toArray());
        /*
            [
                'x10' => [
                    ['account_id' => 'account-x10', 'product' => 'Chair'],
                    ['account_id' => 'account-x10', 'product' => 'Bookcase'],
                ],
                'x11' => [
                    ['account_id' => 'account-x11', 'product' => 'Desk'],
                ],
            ]
        */

        $this->print_title("has() determines if a given key exists in the collection");
        $this->print_code("\$exist = collect(['account_id' => 1, 'product' => 'Desk'])->has('product');");
        $exist = collect(['account_id' => 1, 'product' => 'Desk'])->has('product');
        $this->print_data($exist);
        // true

        $this->print_title("has() determines if a given key exists in the collection");
        $this->print_code("\$collection = collect([
            ['account_id' => 1, 'product' => 'Desk'],
            ['account_id' => 2, 'product' => 'Chair'],
        ])->implode('product', ', ');");
        $this->print_code("collect([1, 2, 3, 4, 5])->implode('-');");
        $collection = collect([
            ['account_id' => 1, 'product' => 'Desk'],
            ['account_id' => 2, 'product' => 'Chair'],
        ])->implode('product', ', ');
        $this->print_data($collection);
        // Desk, Chair / // '1-2-3-4-5'

        $this->print_title("intersect() removes any values from the original collection that are not present in the given array or collection");
        $this->print_code("\$collection = collect(['Desk', 'Sofa', 'Chair']);");
        $this->print_code("\$intersect = \$collection->intersect(['Desk', 'Chair', 'Bookcase']);");
        $collection = collect(['Desk', 'Sofa', 'Chair']);
        $intersect = $collection->intersect(['Desk', 'Chair', 'Bookcase']);
        $this->print_data($intersect->all());
        // [0 => 'Desk', 2 => 'Chair']

        $this->print_title("isEmpty() returns true if the collection is empty; otherwise, false is returned");
        $this->print_code("\$collection = collect([])->isEmpty();");
        $collection = collect([])->isEmpty();
        $this->print_data($collection);
        // true

        $this->print_title("keyBy() keys the collection by the given key. If multiple items have the same key, only the last one will appear");
        $this->print_code("\$collection = collect([
            ['product_id' => 'prod-100', 'name' => 'desk'],
            ['product_id' => 'prod-200', 'name' => 'chair'],
        ]);");
        $this->print_code("\$keyed = \$collection->keyBy('product_id');");
        $collection = collect([
            ['product_id' => 'prod-100', 'name' => 'desk'],
            ['product_id' => 'prod-200', 'name' => 'chair'],
        ]);
        $keyed = $collection->keyBy('product_id');
        $this->print_data($keyed->toArray());
        /*
         [
            [prod-100] => Array
                (
                    [product_id] => prod-100
                    [name] => desk
                )

            [prod-200] => Array
                (
                    [product_id] => prod-200
                    [name] => chair
                )
        ]
         */

        $this->print_title("keys() returns all of the collection's keys");
        $this->print_code("\$collection = collect(['prod-100' => 'Desk', 'prod-200' => 'Chair'])->keys();");
        $collection = collect(['prod-100' => 'Desk', 'prod-200' => 'Chair'])->keys();
        $this->print_data($collection->all());
        // [[0] => prod-100 [1] => prod-200]

        $this->print_title("last() returns the last element in the collection that passes a given truth test");
        $this->print_code("\$last = collect([1, 2, 3, 4])->last(function (\$value, \$key) {
            return \$value < 3;
        });");
        $this->print_code("\$very_last = collect([1, 2, 3, 4])->last();");
        $last = collect([1, 2, 3, 4])->last(function ($value, $key) {
            return $value < 3;
        });
        $very_last = collect([1, 2, 3, 4])->last();
        $this->print_data(compact('last', 'very_last'));
        // 2 and 4

        $this->print_title("map() returns the last element in the collection that passes a given truth test");
        $this->print_code("\$multiplied = collect([1, 2, 3, 4, 5])->map(function (\$item, \$key) {
            return \$item * 2;
        });");
        $multiplied = collect([1, 2, 3, 4, 5])->map(function ($item, $key) {
            return $item * 2;
        });
        $this->print_data($multiplied->all());
        // [2, 4, 6, 8, 10]

        $this->print_title("mapWithKeys() iterates through the collection and passes each value to the given callback");
        $this->print_code("\$keyed = collect([
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane@example.com'
            ]
        ])->mapWithKeys(function (\$item) {
            return [\$item['email'] => \$item['name']];
        });");

        $keyed = collect([
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane@example.com'
            ]
        ])->mapWithKeys(function ($item) {
            return [$item['email'] => $item['name']];
        });

        $this->print_data($keyed->all());
        /*
            [
                'john@example.com' => 'John',
                'jane@example.com' => 'Jane',
            ]
        */

        $this->print_title("max() returns the maximum value of a given key");
        $this->print_code("\$maxByKey = collect([['foo' => 10], ['foo' => 20]])->max('foo');");
        $this->print_code("\$maxNumber = collect([1, 2, 3, 4, 5])->max();");
        $maxByKey = collect([['foo' => 10], ['foo' => 20]])->max('foo');
        $maxNumber = collect([1, 2, 3, 4, 5])->max();
        $this->print_data(compact('maxByKey', 'maxNumber'));
        // 20 and 5

        $this->print_title("merge() method merges the given array into the original collection");
        $this->print_code("\$collection = collect(['product_id' => 1, 'price' => 100]);");
        $this->print_code("\$merged = \$collection->merge(['price' => 200, 'discount' => false]);");
        $this->print_code("\$collection = collect(['Desk', 'Chair'])->merge(['Bookcase', 'Door']);");
        $collection = collect(['product_id' => 1, 'price' => 100]);
        $merged = $collection->merge(['price' => 200, 'discount' => false]);
        $this->print_data($merged->all());
        // ['product_id' => 1, 'price' => 200, 'discount' => false]

        $this->print_title("min() returns the minimum value of a given key");
        $this->print_code("\$minByKey = collect([['foo' => 10], ['foo' => 20]])->min('foo');");
        $this->print_code("\$minNumber = collect([1, 2, 3, 4, 5])->min();");
        $minByKey = collect([['foo' => 10], ['foo' => 20]])->min('foo');
        $minNumber = collect([1, 2, 3, 4, 5])->min();
        $this->print_data(compact('minByKey', 'minNumber'));
        // 10 and 1

        $this->print_title("only() returns the items in the collection with the specified keys");
        $this->print_code("\$collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);");
        $this->print_code("\$filtered = \$collection->only(['product_id', 'name']);");
        $collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);
        $filtered = $collection->only(['product_id', 'name']);
        $this->print_data($filtered->all());
        // ['product_id' => 1, 'name' => 'Desk']

        $this->print_title("pipe() passes the collection to the given callback and returns the result");
        $this->print_code("\$collection = collect([1, 2, 3])->pipe(function (\$collection) {
            return \$collection->sum();
        });");
        $collection = collect([1, 2, 3])->pipe(function ($collection) {
            return $collection->sum();
        });
        $this->print_data($collection);
        // 6

        $this->print_title("pluck() retrieves all of the values for a given key");
        $this->print_code("\$data = collect([
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ]);");
        $this->print_code("\$collection = \$data->pluck('name', 'product_id')");
        $this->print_code("\$plucked = \$collection->pluck('name');");
        $data = collect([
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ]);
        $collection = $data->pluck('name', 'product_id')->all();
        $plucked = $data->pluck('name')->all();
        $this->print_data(compact('collection', 'plucked'));
        // ['Desk', 'Chair'] and
        // ['prod-100' => 'Desk', 'prod-200' => 'Chair']

        $this->print_title("pop() removes and returns the last item from the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->pop();");
        $collection = collect([1, 2, 3, 4, 5])->pop();
        $this->print_data($collection);
        // [1, 2, 3, 4] return 5

        $this->print_title("prepend() adds an item to the beginning of the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->prepend(0);");
        $this->print_code("\$collectionWithKey = collect(['one' => 1, 'two' => 2])->prepend(0, 'zero')");
        $collection = collect([1, 2, 3, 4, 5])->prepend(0)->all();
        $collectionWithKey = collect(['one' => 1, 'two' => 2])->prepend(0, 'zero')->all();
        $this->print_data(compact('collection', 'collectionWithKey'));
        // [0, 1, 2, 3, 4, 5] and
        // ['zero' => 0, 'one' => 1, 'two', => 2]

        $this->print_title("pull() removes and returns an item from the collection by its key");
        $this->print_code("\$collection = collect(['product_id' => 'prod-100', 'name' => 'Desk'])->pull('name')");
        $collection = collect(['product_id' => 'prod-100', 'name' => 'Desk'])->pull('name');
        $this->print_data($collection);
        // ['product_id' => 'prod-100'] return 'Desk'

        $this->print_title("push() appends an item to the end of the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4])->push(5);");
        $collection = collect([1, 2, 3, 4])->push(5);
        $this->print_data($collection->all());
        // [1, 2, 3, 4, 5]

        $this->print_title("put() sets the given key and value in the collection");
        $this->print_code("\$collection = collect(['product_id' => 1, 'name' => 'Desk'])->put('price', 100);");
        $collection = collect(['product_id' => 1, 'name' => 'Desk'])->put('price', 100);
        $this->print_data($collection->all());
        // ['product_id' => 1, 'name' => 'Desk', 'price' => 100]

        $this->print_title("random() returns a random item from the collection");
        $this->print_code("\$random = collect([1, 2, 3, 4, 5])->random();");
        $this->print_code("\$collectionRandom = collect([1, 2, 3, 4, 5])->random(3);");
        $random = collect([1, 2, 3, 4, 5])->random();
        $collectionRandom = collect([1, 2, 3, 4, 5])->random(3)->all();
        $this->print_data(compact('random', 'collectionRandom'));
        // 4 - (retrieved randomly) and [2, 4, 5] - (retrieved randomly)

        $this->print_title("reduce() reduces the collection to a single value, passing the result of each iteration into the subsequent iteration, The value for \$carry on the first iteration is null; however, you may specify its initial value");
        $this->print_code("\$result = collect([1, 2, 3])->reduce(function (\$carry, \$item) {
            return \$carry + \$item;
        }, 4);");
        $result = collect([1, 2, 3])->reduce(function ($carry, $item) {
            return $carry + $item;
        }, 4);
        $this->print_data($result);
        // 6 with initial value 10

        $this->print_title("reject() filters the collection using the given callback.");
        $this->print_code("\$filtered = collect([1, 2, 3, 4])->reject(function (\$value, \$key) {
            return \$value > 2;
        });");
        $filtered = collect([1, 2, 3, 4])->reject(function ($value, $key) {
            return $value > 2;
        });
        $this->print_data($filtered->all());
        // [1, 2]

        $this->print_title("reverse() reverses the order of the collection's items");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->reverse();");
        $collection = collect([1, 2, 3, 4, 5])->reverse();
        $this->print_data($collection->all());
        // [5, 4, 3, 2, 1]

        $this->print_title("search() searches the collection for the given value and returns its key if found");
        $this->print_code("\$key = collect([2, 4, 6, 8])->search(4);");
        $this->print_code("\$strict = collect([2, 4, 6, 8])->search('4', true);");
        $this->print_code("\$custom = collect([2, 4, 6, 8])->search(function (\$item, \$key) {
            return \$item > 5;
        });");
        $key = collect([2, 4, 6, 8])->search(4);
        $strict = collect([2, 4, 6, 8])->search('4', true);
        $custom = collect([2, 4, 6, 8])->search(function ($item, $key) {
            return $item > 5;
        });
        $this->print_data(compact('key', 'strict', 'custom'));
        // 1, false and 2

        $this->print_title("shift() removes and returns the first item from the collection");
        $this->print_code("\$pullFirst = collect([1, 2, 3, 4, 5])->shift();");
        $pullFirst = collect([1, 2, 3, 4, 5])->shift();
        $this->print_data($pullFirst);
        // [2, 3, 4, 5] return 1

        $this->print_title("shuffle() randomly shuffles the items in the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->shuffle();");
        $collection = collect([1, 2, 3, 4, 5])->shuffle();
        $this->print_data($collection->all());
        // [3, 2, 5, 1, 4] // (generated randomly)

        $this->print_title("slice() returns a slice of the collection starting at the given index (or with limit)");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->slice(4, 2);");
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->slice(4, 2);
        $this->print_data($collection->all());
        // [5, 6]

        $this->print_title("sort() sorts the collection, keep the index");
        $this->print_code("\$collection = collect([5, 3, 1, 2, 4])->sort()->values();");
        $collection = collect([5, 3, 1, 2, 4])->sort()->values();
        $this->print_data($collection->all());
        // [1, 2, 3, 4, 5]

        $this->print_title("sortBy() sorts the collection by the given key");
        $this->print_code("\$collection = collect([
            ['name' => 'Desk', 'price' => 200],
            ['name' => 'Chair', 'price' => 100],
            ['name' => 'Bookcase', 'price' => 150],
        ])->sortBy('price')->values();");
        $this->print_code("\$sorted = \$collection->sortBy(function (\$product, \$key) {
            return count(\$product['colors']);
        });");
        $collection = collect([
            ['name' => 'Desk', 'price' => 200],
            ['name' => 'Chair', 'price' => 100],
            ['name' => 'Bookcase', 'price' => 150],
        ])->sortBy('price')->values();
        $this->print_data($collection->all());
        /*
            [
                ['name' => 'Chair', 'price' => 100],
                ['name' => 'Bookcase', 'price' => 150],
                ['name' => 'Desk', 'price' => 200],
            ]
        */

        $this->print_title("sortByDesc() has the same signature as the sortBy method, but will sort the collection in the opposite order");
        $this->print_code("\$collection = \$collection->sortByDesc('price')->values();");
        $collection = $collection->sortByDesc('price')->values();
        $this->print_data($collection->all());
        // [5, 4. 3, 2, 1]

        $this->print_title("splice() removes and returns a slice of items starting at the specified index, and add item as well");
        $this->print_code("\$collection = \$collection->sortByDesc('price')->values();");
        $collection = collect([1, 2, 3, 4, 5]);
        $chunk = $collection->splice(2, 1, [10, 11])->all();
        $this->print_data(compact('collection', 'chunk'));
        // [1, 2, 10, 11, 4, 5] return [3]

        $this->print_title("split() breaks a collection into the given number of groups");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->split(3);");
        $collection = collect([1, 2, 3, 4, 5])->split(3);
        $this->print_data($collection->toArray());
        // [[1, 2], [3, 4], [5]]

        $this->print_title("sum() returns the sum of all items in the collection");
        $this->print_code("\$total = collect([1, 2, 3, 4, 5])->sum();");
        $this->print_code("\$totalByKey = collect([
            ['name' => 'JavaScript: The Good Parts', 'pages' => 176],
            ['name' => 'JavaScript: The Definitive Guide', 'pages' => 1096],
        ])->sum('pages');");
        $total = collect([1, 2, 3, 4, 5])->sum();
        $totalByKey = collect([
            ['name' => 'JavaScript: The Good Parts', 'pages' => 176],
            ['name' => 'JavaScript: The Definitive Guide', 'pages' => 1096],
        ])->sum('pages');
        $this->print_data(compact('total', 'totalByKey'));
        // 15 and 1272

        $this->print_title("take() returns a new collection with the specified number of items");
        $this->print_code("\$collection = collect([0, 1, 2, 3, 4, 5])->take(3);");
        $this->print_code("\$collection = collect([0, 1, 2, 3, 4, 5])->take(-3);");
        $collectionFront = collect([0, 1, 2, 3, 4, 5])->take(3)->toArray();
        $collectionBack = collect([0, 1, 2, 3, 4, 5])->take(-3)->toArray();
        $this->print_data(compact('collectionFront', 'collectionBack'));
        // [0, 1, 2] and [3, 4, 5]

        $this->print_title("toArray() converts the collection into a plain PHP array");
        $this->print_code("\$collection = collect(['name' => 'Desk', 'price' => 200])->toArray();");
        $collection = collect(['name' => 'Desk', 'price' => 200])->toArray();
        $this->print_data($collection);
        /*
            [
                ['name' => 'Desk', 'price' => 200],
            ]
        */

        $this->print_title("toJson() converts the collection into JSON");
        $this->print_code("\$collection = collect(['name' => 'Desk', 'price' => 200])->toJson();");
        $collection = collect(['name' => 'Desk', 'price' => 200])->toJson();
        $this->print_data($collection);
        // '{"name":"Desk", "price":200}'

        $this->print_title("transform() iterates over the collection and calls the given callback with each item in the collection");
        $this->print_code("\$collection = collect([1, 2, 3, 4, 5])->transform(function (\$item, \$key) {
            return \$item * 2;
        });");
        $collection = collect([1, 2, 3, 4, 5])->transform(function ($item, $key) {
            return $item * 2;
        });
        $this->print_data($collection->all());
        // [2, 4, 6, 8, 10]

        $this->print_title("union() adds the given array to the collection. If the given array contains keys that are already in the original collection, the original collection's values will be preferred");
        $this->print_code("\$collection = collect([1 => ['a'], 2 => ['b']])->union([3 => ['c'], 1 => ['b']]);");
        $collection = collect([1 => ['a'], 2 => ['b']])->union([3 => ['c'], 1 => ['b']]);
        $this->print_data($collection->all());
        // [1 => ['a'], 2 => ['b'], [3 => ['c']]

        $this->print_title("unique() returns all of the unique items in the collection");
        $this->print_code("\$collection = collect([
            ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
            ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
            ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
            ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
            ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
        ]);");
        $this->print_code("\$unique = collect([1, 1, 2, 2, 3, 4, 2])->unique()->toArray();");
        $this->print_code("\$collectionNested = \$collection->unique('brand')->toArray();");
        $this->print_code("\$uniqueCustom = \$collection->unique(function (\$item) {
            return \$item['brand'].\$item['type'];
        })->values()->all();");
        $collection = collect([
            ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
            ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
            ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
            ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
            ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
        ]);
        $unique = collect([1, 1, 2, 2, 3, 4, 2])->unique()->toArray();
        $uniquerNested = $collection->unique('brand')->toArray();
        $uniqueCustom = $collection->unique(function ($item) {
            return $item['brand'] . $item['type'];
        })->values()->all();
        $this->print_data(compact('unique', 'uniquerNested', 'uniqueCustom'));
        // [1, 2, 3, 4]
        /*
            [
                ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
                ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
            ]
        */
        /*
            [
                ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
                ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
                ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
                ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
            ]
        */

        $this->print_title("values() returns a new collection with the keys reset to consecutive integers");
        $this->print_code("\$collection = collect([
            10 => ['product' => 'Desk', 'price' => 200],
            11 => ['product' => 'Desk', 'price' => 200]
        ])->values();");
        $collection = collect([
            10 => ['product' => 'Desk', 'price' => 200],
            11 => ['product' => 'Desk', 'price' => 200]
        ])->values();
        $this->print_data($collection->all());
        /*
            [
                0 => ['product' => 'Desk', 'price' => 200],
                1 => ['product' => 'Desk', 'price' => 200],
            ]
        */

        $this->print_title("where() filters the collection by a given key / value pair");
        $this->print_code("\$collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Door', 'price' => 100],
        ])->where('price', 100);");
        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Door', 'price' => 100],
        ])->where('price', 100);
        $this->print_data($collection->all());
        /*
        [
            ['product' => 'Chair', 'price' => 100],
            ['product' => 'Door', 'price' => 100],
        ]
        */

        $this->print_title("whereStrict() same signature as the where method; however, all values are compared using \"strict\" comparisons");
        $this->print_code("\$collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => '100'],
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Door', 'price' => 100],
        ])->whereStrict('price', 100);");
        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => '100'],
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Door', 'price' => 100],
        ]);
        $filtered = $collection->whereStrict('price', '100');
        $this->print_data($filtered->all());
        /*
        [
            ['product' => 'Chair', 'price' => '100'],
        ]
        */

        $this->print_title("whereIn() filters the collection by a given key / value contained within the given array");
        $this->print_code("\$filtered = \$collection->whereIn('price', [150, 200]);");
        $filtered = $collection->whereIn('price', [150, 200]);
        $this->print_data($filtered->all());
        /*
        [
            ['product' => 'Bookcase', 'price' => 150],
            ['product' => 'Desk', 'price' => 200],
        ]
        */

        $this->print_title("whereInStrict() same signature as the whereIn method; however, all values are compared using strict comparisons");
        $this->print_code("\$filtered = \$collection->whereIn('price', ['150', 200]);");
        $filtered = $collection->whereInStrict('price', ['150', 200]);
        $this->print_data($filtered->all());
        /*
         [
             [product] => Desk
             [price] => 200
         ]
         */

        $this->print_title("zip() merges together the values of the given array with the values of the original collection at the corresponding index");
        $this->print_code("\$collection = collect(['Chair', 'Desk'])->zip([100, 200]);");
        $collection = collect(['Chair', 'Desk'])->zip([100, 200]);
        $this->print_data($collection->toArray());
        // [['Chair', 100], ['Desk', 200]]
    }
}
