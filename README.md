Common
======

Common class library, including a flexible autoloader and various containers.

**Namespace: `Phpf\Common`**

**Dependencies: None**

###Classes
#####Containers
 * `Container`
 * `DataContainer`
 * `EnhancedContainer`
 * `EnhancedDataContainer`
 * `SerializableContainer`
 * `SerializableDataContainer`

#####Registries
 * `Registry`
 * `StaticRegistry`

#####Other
 * `Autoloader`
 * `ClassAliaser`


###About

####Containers
Containers provide a generic object interface and are based on 4 core methods:
 * `get($var)` - Retrieve an item.
 * `set($var, $val)` - Set an item.
 * `exists($var)` - Return whether an item exists.
 * `remove($var)` - Remove an item.

Containers also have the following additional methods:
 * `import($vars)` - Sets items from an associative array or iterable object.
 * `toArray($indexed = false)` - Returns items as an array, optionally indexed.
 * `count()` - Implements `Countable`
 * `getIterator()` - Implements `IteratorAggregate`.

Containers implement `ArrayAccess` and the four magic methods `__get()`, `__set()`, `__isset()`, and `__unset()`. Both the magic and array access methods are based on the four core methods, which means that subclasses only need to overwrite the 4 core methods.

#####`Container`
The `Container` class is the simplest type of container. Each item is a property - for example, `$container->set('name', 'Jim')` would set the object property `name` to `Jim`.

#####`DataContainer`
The `DataContainer` class has the same methods as the basic container; however, items are stored in a single array property `data`. Using the same example as above, the data container would instead add an array entry to its `data` property with key `name` and value `Jim`.

#####`EnhancedContainer`
The "enhanced" containers (`EnhancedContainer` and `EnhancedDataContainer`) simply allow callable properties to be added and then called as object methods, much like JavaScript.

For example:
```php
$container = new \Phpf\Common\EnhancedContainer;

$container->set('formalize', function ($last_name, $gender) {
	
	switch($gender) {
		case 'doctor':
			$pre = 'Dr.';
			break;
		case 'male':
			$pre = 'Mr.';
			break;
		case 'female':
			$pre = 'Ms.';
			break;
	}
	
	return $pre.' '.$last_name;
});

echo $container->formalize('Jones', 'male'); // prints "Mr. Jones"
```
