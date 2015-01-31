#Common

###Dependencies
 * None

##About
The Common package includes a variety of general-use classes and interfaces.

In the root directory are a number of (very) generic interfaces:
 * `Arrayable` - contains one method, `toArray()`
 * `Importable` - contains one method, `import()`
 * `Sortable` - contains sorting methods (e.g. `asort()`, `ksort()`, etc.)
 * `DataStructure` - base data structure contract that contains two methods: `isEmpty()` and `contains()`. Extends `Arrayable`, `Importable`, `\ArrayAccess`, `\Countable`, and `\Traversable`.

Also in the root directory are two classes and a trait:
 * Class `Object` - an extended `ArrayObject`
 * Class `PropertyAwareObject` - an extended `Object` that restricts values to class properties.
 * Trait `Singleton` - a trait for implementing the Singleton (anti) pattern. `instance()` is the getter method.

####`Structure`

The `Structure` namespace includes generic interfaces and base classes for building data structures:
 * Interface `MapInterface` - Extends `DataStructure`. Methods: `get()`, `set()`, `has()`, `remove()`, `indexOf()`, `keys()`, `values()`.
 * Interface `QueueInterface` - Extends `DataStructure`. Methods: `enqueue()`, `dequeue()`.
 * Interface `StackInterface` - Extends `DataStructure`. Methods: `push()`, `pop()`.
 * Abstract Class `Base` - A `DataStructure` that implements `\IteratorAggregate`.
 * Class `BaseMap` - An implementation of `MapInterface`.
 * Class `Map` - Extends `BaseMap` with an optional constructor argument.
 * Class `Queue` - An implementation of `QueueInterface`.
 * Class `Stack` - An implementation of `StackInterface`.

####`Storage`

The `Storage` namespace includes various extensions of structures (mostly map-based):
 * Class `Registry` - Extends `Structure\BaseMap`. Restricts values to objects and provides lazy-loading via Closures.
 * Class `LockableRegistry` - Extends `Registry`. Allows locking of objects.
 * Class `Container` - Extends `Structure\BaseMap`. Uses "dot-notation" for item keys.
 * Class `Config` - Extends `Container`. Allows setting of a "parent" object (presumed to be the one being configured).
 * Class `Bin` - Extends `Structure\BaseMap`, implements `Structure\StackInterface`. Adds some extra methods like `clear()`, `attach()`, and `detach()`. 
 * Class `Collection` - Extends `Bin`, implements `Sortable`. Adds a bunch of array-like methods: `map()`, `slice()`, `intersect()`, `diff()`, `keyDiff()`, and more.
