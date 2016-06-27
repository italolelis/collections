# Collections

[![Build Status](https://travis-ci.org/italolelis/collections.svg?style=flat-square)](https://travis-ci.org/italolelis/collections)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/italolelis/collections.svg?style=flat-square)](https://scrutinizer-ci.com/g/italolelis/collections/)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/italolelis/collections.svg?style=flat-square)](https://scrutinizer-ci.com/g/italolelis/collections/)
[![Latest Stable Version](http://img.shields.io/packagist/v/easyframework/collections.svg?style=flat-square)](https://packagist.org/packages/easyframework/collections)
[![Downloads](https://img.shields.io/packagist/dt/easyframework/collections.svg?style=flat-square)](https://packagist.org/packages/easyframework/collections)

Collections Abstraction library for PHP

The Collection library is one of the most useful things that many modern languages has, but for some reason PHP doesn't has a built in collection layer.

For that reason we created Collections, an incredible library that gathers the best of .NET's and Java's collections patterns and
unify it with PHP array power.

Take a look and see what we're talking about!!

## Install

```bash
composer require easyframework/collections
```

## Usage

### The Collection Class

The Collection represents the List in .NET language or simply non-associative arrays in php:

```php
  $person1 = new \stdClass();
  $person1->name = 'John';
  $person1->age = 25;
  
  $person2 = new \stdClass();
  $person2->name = 'Maria';
  $person2->age = 30;
  
  $person3 = new \stdClass();
  $person3->name = 'Anderson';
  $person3->age = 15;
     
  $collection = new Collections\Vector();
  $collection->add($person1);
  $collection->add($person2);
  $collection->add($person3);
  
  $collection->filter(function($person){
        return $person->age > 18;
  })->each(function($item){
        echo $item->name; //John and Maria
  });
```

## Contributing

Please see [CONTRIBUTING](https://github.com/italolelis/collections/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/italolelis/collections/blob/master/LICENSE) for more information.

### Documentation

More information can be found in the online documentation at
https://italolelis.gitbooks.io/collections.
