# Iterating


## Projecting Collections

Applying a function to a value and creating a new value is called a projection. To project one array into another, we apply a projection function to each item in the array and collect the results in a new array.



```php
$data = [
  [
      "id" => 70111470,
      "title" =>  "Die Hard",
      "boxart" => "http://cdn-0.nflximg.com/images/2891/DieHard.jpg",
      "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
      "rating" =>  [4.0],
      "bookmark" =>  []
  ],
  [
      "id" =>  654356453,
      "title" => "Bad Boys",
      "boxart" =>  "http://cdn-0.nflximg.com/images/2891/BadBoys.jpg",
      "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
      "rating" =>  [5.0],
      "bookmark" => [{ "id" => 432534, "time" => 65876586 }]
  ],
  [
      "id" => 65432445,
      "title" => "The Chamber",
      "boxart" => "http://cdn-0.nflximg.com/images/2891/TheChamber.jpg",
      "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
      "rating" => [4.0],
      "bookmark" => []
  ]
];
$videos = new Dictionary($data);
```

##Iterating

### Each

Collections can be iterated and/or transformed into new collections with the `each()` and `map()` methods. The `each()` method will not create a new collection, but will allow you to modify any objects within the collection:

```php
use Collection\ArrayList;

$videos->each(function ($value, $key) {
    echo "Video $key: $value";
});
```

### Map

The `map()` method will create a new collection based on the output of the callback being applied to each object in the original collection:

Lets use map to project a collection of videos into a collection of [id, title]:

```php
use Collection\Dictionary;

$new = $videos->map(function ($video) {
    return [
		"id" => $video["id"],
		"title" => $video["title"]
	];
});
```

The `map()` method will create a new iterator which lazily creates the resulting items when iterated.

### Filter

Like projection, filtering a collection is also a common operation. To filter a collection we apply a test to each item in the iterable and collect the items that pass into a new iterable.

Lets filter and map to collect the ids of videos that have a rating of 5.0

```php
use Collection\Dictionary;

$topRatedVideos = $videos->filter(function ($video) {
    return $video["rating"] === 5.0;
})->map(function ($video) {
    return $video["rating"] ;
});
```

