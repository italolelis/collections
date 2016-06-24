# Change Log
All notable changes to this project will be documented in this file.

## 6.0.0 - unreleased

### Add
- Lazy Iterator API, many new Lazy iterators that speed up the functional approach on the collections
- `Pair` collection, that helps a `Map` to add a key value pair

## Removed
- `tryGet()` method, now you need to use `get()`

## 5.0.0 - 2016-04-06
### Add
- `Set` class

### Deprecated
- Deprecated `tryGet()` method, now we can use the `get()`

### Fixed
- `toKeysArray` bug
- Immutable API bug
- `concat()` method bug
- `removeKey()` bug

## 4.1.0 - 2015-06-03
### Add
- Added to all collections the JsonSerializable interface.

### Updated
- All collections that extends from ArrayCollection now have the toArrayKeys method.

## 4.0.0 - 2015-02-21
### Add
- Added Reactive Extension Trait.
- Added unfold method, almost like flatMap.
- Added BinaryTree data structure.
- Added AvlTree data structure.
- Added LinkedQueue data structure.
- Added LinkedStack data structure.

### Changed
- The match method now don't receive a Criteria object but uses a callable instead.
- Now dictionary act as a HashMap, which can accept any type of key.
- The *toKeysArray* method now is only available in MapInterface.

## Removed
- Removed the Expression Search API

## 3.2.0 - 2015-02-14
### Add
- Added flatMap method, just like the Scala and Javascript implementation.

### Changed
- The default Queue implementation uses Doubly Linked List.
- The default Stack implementation uses Doubly Linked List.

### Deprecated
- Deprecated *slice* method, now we can use the *take*, this is part of the Reactive Extensions initiative.
- Deprecated Expression search API

## 3.1.2 - 2014-09-08 
### Changed
- Changed the array_merge_recursive to array_merge from the *concat* method cause was causing errors.

## 3.1.1 - 2014-09-05
### Changed
- Ajusting tests for the Dictionary class, which wasn't expecting the correct exception class.

### Removed
- Removing nbproject form gitignore.

## 3.1.0 - 2014-08-27
### Fixed
- All the interfaces bugs which waren't being called correctly.

## 3.0.0 - 2014-08-26
### Update
- Changed all interfaces names to PSR (using the *Interface* suffix).
