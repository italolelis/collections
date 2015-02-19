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

## Contributing

Please see [CONTRIBUTING](https://github.com/LellysInformatica/collections/blob/master/CONTRIBUTING.md) for details.

## Credits

- [italolelis](https://github.com/italolelis)
- [philipe](https://github.com/philipe)
- [AyrtonRicardo](https://github.com/AyrtonRicardo)
- [All Contributors](https://github.com/LellysInformatica/collections/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/LellysInformatica/collections/blob/master/LICENSE) for more information.

### Documentation

More information can be found in the online documentation at
http://collections.readthedocs.org/.