==========
Quickstart
==========

This page provides a quick introduction to Collections and introductory examples.
If you have not already installed, Collections, head over to the :ref:`installation`
page.

ArrayList
=========

The ArrayList represents the List in .NET language or simply non-associative arrays in php:

.. code-block:: php

    use Collections\ArrayList;

    $person1 = new \stdClass();
    $person1->name = 'John';
    $person1->age = 25;

    $person2 = new \stdClass();
    $person2->name = 'Maria';
    $person2->age = 30;

    $person3 = new \stdClass();
    $person3->name = 'Anderson';
    $person3->age = 15;

    $collection = new Collections\ArrayList();
    $collection->add($person1);
    $collection->add($person2);
    $collection->add($person3);

    $collection->filter(function($person){
        return $person->age > 18;
    })->each(function($item){
        echo $item->name; //John and Maria
    });

Lets continue with the example above and count how many elements we have!

.. code-block:: php

    echo $collection->count();

Great, now we know how to run through a collection and how to count it, but these are pretty simple things to do,
so lets sort them:

.. code-block:: php

    use Collections\ArrayList;
    use Collections\Comparer\StringComparer;

    $collection->sort(); //by default the sort is by the keys
    $collection->sort(new StringComparer()); //this will sort by alfabetic order
    $collection->sort(new YourCustomComparer()); //you can create your own custom comparer to sort your collection

Yeah that is great, isn't it? But we can do much more things, now lets search for someone in the collection.

.. code-block:: php

    print_r($collection->contains("John")); //returns true

Ok now we learned many things of collections, we can do even more, but I'll show you other type of collection
called Dictionary.

Dictionary
==========

The Dictionary class is something like associative arrays in PHP, or Hash tables in other languages.

.. code-block:: php

    use Collections\Dictionary;

    $dictionary = new Dictionary();
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

    $dictionary->map(function($item){
        echo $key . ": " . $item['name'] . "-" . $item['age'];
    });

We can use object as keys too.

.. code-block:: php

    use Collections\Dictionary;

    $dictionary = new Dictionary();

    $object = new \stdClass();
    $dictionary->add($object, 'value');
    echo $dictionary->get($object); //prints 'value'

When one key is inserted we can't insert the same key again, if we want to change its value we need to use
the method set(). Here is an example of how we can get some item based on the key;

.. code-block:: php

  print_r ($dictionary->get('person1')); //returns ['name' => John, 'age' => 20]

Working with objects
====================

To our last example we'll use objects in our collection.

.. code-block:: php

    use Collections\ArrayList;

    $collection = new ArrayList();
    $collection->add(new Person('John', 20));
    $collection->add(new Person('Peter', 20));
    $collection->add(new Person('Sophie', 21));
    $collection->add(new Person('Angela', 29));
    $collection->add(new Person('Maria', 19));
    $collection->add(new Person('Anderson', 25));

    $collection->map(function($item){
        echo $item->getName();
    });

Pretty simple, but the reason I wanted to show you objects is because of Reactive Extension API.
Lets seek everyone with age 20.

.. code-block:: php

  // this will return John and Peter
  $people = $people->filter(function($person){
      return $person->getAge() === 20;
  });

The *map()* method will create a new collection based on the output of the callback being applied to each object
in the original collection:

.. code-block:: php

  $new = $people->map(function ($person, $key) {
      return $person->getAge() * 2;
  });

  // $result contains all persons with twice theirs ages;
  $result = $new->toArray();

One of the most common uses for a *map()* function is to extract a single column from a collection.
If you are looking to build a list of elements containing the values for a particular property,
you can use the *extract()* method:

.. code-block:: php

  $names = $people->extract('name');

  // $result contains ['John', 'Peter', 'Sophie', 'Angela', 'Maria', 'Anderson'];
  $result = $names->toArray();