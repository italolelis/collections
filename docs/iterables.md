# Functional approach


## What is it?

The reactive extensions for PHP are a set of libraries to compose asynchronous
and event-based programs using observable collections and LINQ-style query operators in PHP.

Iterating
=========

### Each


Collections can be iterated and/or transformed into new collections with the `each()` and `map()` methods. The `each()` method will not create a new collection, but will allow you to modify any objects within the collection:

```php
use Collection\ArrayList;

$collection = new ArrayList($items);
$collection = $collection->each(function ($value, $key) {
    echo "Element $key: $value";
});
```

### Map

The `map()` method will create a new collection based on the output of the callback being applied to each object in the original collection:

```php
use Collection\Dictionary;

$items = ['a' => 1, 'b' => 2, 'c' => 3];
$collection = new Dictionary($items);

$new = $collection->map(function ($value, $key) {
    return $value * 2;
});

// $result contains [2, 4, 6];
$result = $new->toArray();
```

The `map()` method will create a new iterator which lazily creates the resulting items when iterated.

### Concat All

One of the most common uses for a `map()` function is to extract a single column from a collection. If you are looking to build a list of elements containing the values for a particular property, you can use the `extract()` method:

.. code-block:: php

    use Collection\ArrayList;

    $collection = new ArrayList($people);
    $names = $collection->extract('name');

    // $result contains ['mark', 'jose', 'barbara'];
    $result = $names->toArray();

As with many other functions in the collection class, you are allowed to specify a dot-separated path
for extracting columns. This example will return a collection containing the author names from a list
of articles:

.. code-block:: php

    use Collection\ArrayList;

    $collection = new ArrayList($articles);
    $names = $collection->extract('author.name');

    // $result contains ['Maria', 'Stacy', 'Larry'];
    $result = $names->toArray();

Finally, if the property you are looking after cannot be expressed as a path, you can use a callback
function to return it:

.. code-block:: php

    use Collection\ArrayList;

    $collection = new ArrayList($articles);
    $names = $collection->extract(function ($article) {
        return $article->author->name . ', ' . $article->author->last_name;
    });

combine
-------

The map() method will create a new collection based on the output of the callback being applied to each
object in the original collection:

.. code-block:: php

    use Collection\ArrayList;

    $items = [
        ['id' => 1, 'name' => 'foo', 'parent' => 'a'],
        ['id' => 2, 'name' => 'bar', 'parent' => 'b'],
        ['id' => 3, 'name' => 'baz', 'parent' => 'a'],
    ];
    $combined = (new ArrayList($items))->combine('id', 'name');

    // Result will look like this when converted to array
    [
        1 => 'foo',
        2 => 'bar',
        3 => 'baz',
    ];

You can also optionally use a groupPath to group results based on a path: