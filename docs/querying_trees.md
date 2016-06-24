# Querying Trees

Sometimes, in addition to flat collections, we need to query trees. Trees pose a challenge because we need to flatten them into collections in order to apply `filter()` and `map()` operations on them. In this section we'll define a `concatAll()` function that we can combine with `map()` and `filter()` to query trees.

```php
$data = [
  [
    "name" => "New Releases",
    "videos" => [
        [
            "id" => 70111470,
            "title" => "Die Hard",
            "boxart" => "http://cdn-0.nflximg.com/images/2891/DieHard.jpg",
            "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
            "rating" => 4.0,
            "bookmark" => []
        ],
        [
            "id" => 654356453,
            "title" => "Bad Boys",
            "boxart" => "http://cdn-0.nflximg.com/images/2891/BadBoys.jpg",
            "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
            "rating" => 5.0,
            "bookmark" => [[ id:432534, time:65876586 ]]
        ]
    ]
  ],
  [
    "name" => "Dramas",
    "videos" => [
        [
            "id" => 65432445,
            "title" => "The Chamber",
            "boxart" => "http://cdn-0.nflximg.com/images/2891/TheChamber.jpg",
            "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
            "rating" => 4.0,
            "bookmark" => []
        ],
        [
            "id" => 675465,
            "title" => "Fracture",
            "boxart" => "http://cdn-0.nflximg.com/images/2891/Fracture.jpg",
            "uri" => "http://api.netflix.com/catalog/titles/movies/70111470",
            "rating" => 5.0,
            "bookmark" => [[ "id" => 432534, "time" => 65876586 ]]
        ]
    ]
  ]
];
$movieLists = new Map($data);

$flattenVideos = $movieLists->map(function($movieList) { 
    return $movieList["videos"]->map(function($video) {
        return $video["id"];
    });
})->concatAll();
```