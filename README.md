Collections
===========

[![Build Status](https://travis-ci.org/LellysInformatica/collections.png?branch=master)](https://travis-ci.org/LellysInformatica/collections)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LellysInformatica/collections/badges/quality-score.png?s=0bdaef0d3ed9e37348e610c6a41908fd505d6328)](https://scrutinizer-ci.com/g/LellysInformatica/collections/)
[![Code Coverage](https://scrutinizer-ci.com/g/LellysInformatica/collections/badges/coverage.png?s=fbbb73d61336e5247035682fed9a9c5969001103)](https://scrutinizer-ci.com/g/LellysInformatica/collections/)
[![Latest Stable Version](https://poser.pugx.org/easyframework/collections/v/stable.png)](https://packagist.org/packages/easyframework/collections)
[![Latest Unstable Version](https://poser.pugx.org/easyframework/collections/v/unstable.png)](https://packagist.org/packages/easyframework/collections)

Collections Abstraction library for PHP

What is it?
----------
The Collection library is one of the most useful things that many modern languages has, but for some reason PHP doesn't has a built in collection layer.

For that reason we created Collections, an incredible library that gathers the best of .NET's and Java's collections patterns and
unify it with PHP array power.

Take a look and see what we're talking about!!


Installation
----------

  `require: { "easyframework/collections": "1.0.*" }`
  
  `$ composer install`

Usage
----------

### The Collection Class ###

The Collection represents the List in .NET language or simply non-associative arrays in php:

    $collection = new \Easy\Collections\ArrayList();
    $collection->add('John');
    $collection->add('Maria');
    $collection->add('Anderson');
    
    foreach($collection as $item){
        echo $item;
    }
    
Lets continue with the exemple above and count how many elements we have!

    echo $colletion->count();

Great, now we know how to run through a collection and how to count it, but these are pretty simple things to do, so lets sort them:

    $collection->sort(); //by default the sort is by the keys
    
    $colletion->sort(new \Easy\Collections\Comparer\StringComparer()); //this will sort by alfabethic order
    
    $collection->sort(new YourCustomComaparer()); //you can create your own custom comparer to sort your collection
    
Yeah that is great, isn't it? But we can do much more things, now lets search for someone in the collection.

    print_r($collection->contains("John")); //returns true
    
Ok now we learned many things of collections, we can do even more, but I'll show you other type of collection called Dictionary.

### The Dictionary Class ###

The Dictionary class is something like associative arrays in PHP, or Hash tables in other languages.

    $dictionary = new \Easy\Collections\Dictionary();
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

    foreach ($dictionary as $key => $item) {
        echo $key . ": " . $item['name'] . "-" . $item['age'];
    }
    
When one key is inserted we can't insert the same key again, if we want to change its value we need to use the method set()
Here is an exemple of how we can get some item based on the key;

    print_r ($dictionary->get('person1')); //returns array('name' => John, 'age' => 20)
    
All Collection methods are also avaliable in Dictionary class, just remember to use each one in correct case, this will help you keep organization in your project.

### Working with objects ###

To our last exemple we'll use objects in our collection.

    $collection = new \Easy\Collections\ArrayList();
    $collection->add(new Person('John', 20));
    $collection->add(new Person('Peter', 20));
    $collection->add(new Person('Sophie', 21));
    $collection->add(new Person('Angela', 29));
    $collection->add(new Person('Maria', 19));
    $collection->add(new Person('Anderson', 25));
    
    foreach($collection as $item){
        echo $item->getName();
    }

Pretty simple, but the reason I wanted to show you objects is because of Expression search, something like Linq for .NET
Lets seek everyone with age 20.

    $criteria = new \Easy\Collections\Criteria();
    $expr = $criteria->createExpression()->eq("age", 20);
    $criteria->where($expr);
    $collection = $collection->matching($criteria);
    
    //only going to list John and Peter wich has 20 years
    foreach($collection as $item){
        echo $item->getName() . "-" . $item->getAge();
    }
    
Now we want everyone where the name starts with 'A'

    $criteria = new \Easy\Collections\Criteria();
    $expr = $criteria->createExpression()->contains("name", "A");
    $criteria->where($expr);
    $collection = $collection->matching($criteria);
    
    //only going to list Angela and Anderson
    foreach($collection as $item){
        echo $item->getName() . "-" . $item->getAge();
    }
    

### Conclusion ###

Hope you've enjoy it our tour through the Collection library, if you want to see all the avaliables methods and others collections (like Stack, Queue) check our [API][1].

[1]: http://easyframework.net/collections/api
