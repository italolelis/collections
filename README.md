# Collections

[![Build Status](https://travis-ci.org/italolelis/collections.svg?style=flat-square)](https://travis-ci.org/italolelis/collections)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/italolelis/collections.svg?style=flat-square)](https://scrutinizer-ci.com/g/italolelis/collections/)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/italolelis/collections.svg?style=flat-square)](https://scrutinizer-ci.com/g/italolelis/collections/)
[![Latest Stable Version](http://img.shields.io/packagist/v/easyframework/collections.svg?style=flat-square)](https://packagist.org/packages/easyframework/collections)
[![Downloads](https://img.shields.io/packagist/dt/easyframework/collections.svg?style=flat-square)](https://packagist.org/packages/easyframework/collections)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86/small.png)](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86)

Collections Abstraction library for PHP

The Collection library is one of the most useful things that many modern languages has, but for some reason PHP doesn't has a built in collection layer.

For that reason we created Collections, an incredible library that gathers the best of .NET's and Java's collections patterns and
unify it with PHP array power.

Take a look and see what we're talking about!!

## Install

``` json
{
    "require": {
        "easyframework/collections": "~4.0"
    }
}
```

## Usage

### The Collection Class

The Collection represents the List in .NET language or simply non-associative arrays in php:

```php
  $collection = new Collections\ArrayList();
  $collection->add('John');
  $collection->add('Maria');
  $collection->add('Anderson');
  
  $collection->each(function($item){
        echo $item;
  });

```    
Lets continue with the exemple above and count how many elements we have!

```php
  echo $colletion->count();
```

Great, now we know how to run through a collection and how to count it, but these are pretty simple things to do, so lets sort them:

```php
  $collection->sort(); //by default the sort is by the keys
  
  $colletion->sort(new Collections\Comparer\StringComparer()); //this will sort by alfabetic order
  
  $collection->sort(new YourCustomComparer()); //you can create your own custom comparer to sort your collection
```

Yeah that is great, isn't it? But we can do much more things, now lets search for someone in the collection.

```php
  print_r($collection->contains("John")); //returns true
```

Ok now we learned many things of collections, we can do even more, but I'll show you other type of collection called Dictionary.

### The Dictionary Class

The Dictionary class is something like associative arrays in PHP, or Hash tables in other languages.

```php
  $dictionary = new Collections\Dictionary();
  $dictionary->add('person1', array(
      'name' => 'John',
      'age' => 20
  ));
  $dictionary->add('person2', array(
      'name' => 'Maria',
      'age' => 19
  ));
  $dictionary->add('person3', array(
      'name' => 'Anderson',
      'age' => 25
  ));

  $collection->each(function($item){
        echo $key . ": " . $item['name'] . "-" . $item['age'];
  });
  
```

We can use object as keys too.

```php
    $dictionary = new Collections\Dictionary();
    
    $object = new \stdClass();
    $dictionary->add($object, 'value');

    echo $dictionary->get($object); //prints 'value'
```

When one key is inserted we can't insert the same key again, if we want to change its value we need to use the method set()
Here is an example of how we can get some item based on the key;

```php
  print_r ($dictionary->get('person1')); //returns array('name' => John, 'age' => 20)
```   

All Collection methods are also avaliable in Dictionary class, just remember to use each one in correct case, this will help you keep organization in your project.

### Working with objects

To our last exemple we'll use objects in our collection.

```php
  $people = new Collections\ArrayList();
  $people->add(new Person('John', 20));
  $people->add(new Person('Peter', 20));
  $people->add(new Person('Sophie', 21));
  $people->add(new Person('Angela', 29));
  $people->add(new Person('Maria', 19));
  $people->add(new Person('Anderson', 25));

  $people->each(function($item){
        echo $item->getName();
  });
```  

Pretty simple, but the reason I wanted to show you objects is because of Reactive Extension API.
Lets seek everyone with age 20.

```php
  // this will return John and Peter
  $people = $people->filter(function($person){
      return $person->getAge() === 20 ? $person : null;
  });
``` 

The *map()* method will create a new collection based on the output of the callback being applied to each object 
in the original collection:

```php
  $new = $people->map(function ($person, $key) {
      return $person->getAge() * 2;
  });
  
  // $result contains all persons with twice theirs ages;
  $result = $new->toArray();
``` 

One of the most common uses for a *map()* function is to extract a single column from a collection. 
If you are looking to build a list of elements containing the values for a particular property, 
you can use the *extract()* method:

```php
  $names = $people->extract('name');
  
  // $result contains ['John', 'Peter', 'Sophie', 'Angela', 'Maria', 'Anderson'];
  $result = $names->toArray();
``` 

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/LellysInformatica/collections/blob/master/CONTRIBUTING.md) for details.

## Credits

- [italolelis](https://github.com/italolelis)
- [philipe](https://github.com/philipe)
- [AyrtonRicardo](https://github.com/AyrtonRicardo)
- [All Contributors](https://github.com/LellysInformatica/collections/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/LellysInformatica/collections/blob/master/LICENSE) for more information.
