# Change Log
All notable changes to this project will be documented in this file.

## Next - unreleased

- Decouple LINQ interface from Collections.
- Reactive Extensions initiative.
- Adding new data structure TreeMap.
- Adding new data structures LinkedList and LinkedDictionary. 

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
