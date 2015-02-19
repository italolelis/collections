=================
Welcome to Collections
=================

What is it?
============

The Collection library is one of the most useful things that many modern languages has, but for some reason
PHP doesn't has a built in collection layer.

For that reason we created Collections, an incredible library that gathers the best of .NET's and Java's
collections patterns and unify it with PHP array power.

Installation
============

The recommended way to install Guzzle is with `Composer <http://getcomposer.org>`_. Composer is a dependency
management tool for PHP that allows you to declare the dependencies your project needs and installs them into your
project.

.. code-block:: bash

    # Install Composer
    curl -sS https://getcomposer.org/installer | php

You can add Guzzle as a dependency using the composer.phar CLI:

.. code-block:: bash

    php composer.phar require easyframework/collections:~4.0

Alternatively, you can specify Collections as a dependency in your project's
existing composer.json file:

.. code-block:: js

    {
      "require": {
         "easyframework/collections": "~4.0"
      }
   }

After installing, you need to require Composer's autoloader:

.. code-block:: php

    require 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and
other best-practices for defining dependencies at `getcomposer.org <http://getcomposer.org>`_.

Bleeding edge
-------------

During your development, you can keep up with the latest changes on the master
branch by setting the version requirement for Guzzle to ``~4.0@dev``.

.. code-block:: js

   {
      "require": {
         "easyframework/collections": "~4.0@dev"
      }
   }

License
=======

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    The MIT License (MIT)

    Copyright (c) 2013 italolelis <italolelis@gmail.com>

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.

Contributing
============

Guidelines
----------

1. Collections follows PSR-0, PSR-1, and PSR-2.
2. Collections is meant to be lean and fast with very few dependencies.
3. Collections has a minimum PHP version requirement of PHP 5.4. Pull requests must
   not require a PHP version greater than PHP 5.4.
4. All pull requests must include unit tests to ensure the change works as
   expected and to prevent regressions.

Running the tests
-----------------

In order to contribute, you'll need to checkout the source from GitHub and
install Collection's dependencies using Composer:

.. code-block:: bash

    git clone https://github.com/italolelis/collections.git
    cd guzzle && curl -s http://getcomposer.org/installer | php && ./composer.phar install --dev

Guzzle is unit tested with PHPUnit. Run the tests using the vendored PHPUnit
binary:

.. code-block:: bash

    vendor/bin/phpunit