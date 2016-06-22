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


### Concat

The `concat($iterable)` method will merge the elements of the one iterable or array into the collection:

```php
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
```