<?php
require "Enumerable.php";
class MyCollection implements ArrayAccess, Enumerable
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $this->getArrayableItems($items);
    }

    protected function getArrayableItems(array $items): array
    {
        if (is_array($items)) {
            return $items;
        }
        return match (true) {
            $items instanceof Enumerable => $items->all(),
            default => (array)$items,
        };
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        }
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public static function make($items = [])
    {
        return new MyCollection($items);
    }

    public static function times($number, ?callable $callback = null)
    {
        $results = [];
        for ($i = 0; $i < $number; $i++) {
            if ($callback) {
                $results[] = $callback($i);
            }
            else {
                $results[] = $i;
            }
        }
        return new MyCollection($results);
    }

    public static function range($from, $to): MyCollection
    {
        return new static (range($from, $to));
    }

    public static function wrap($value)
    {
        return is_array($value) ? $value : [$value];
    }

    public static function unwrap($value)
    {
        return $value;
    }

    public static function empty()
    {
        return new static([]);
    }

    public function all()
    {
        return $this->items;
    }

    public function average($callback = null)
    {
        return $this->avg($callback);
    }

    public function median($key = null)
    {
        $values = (isset($key) ? $this->pluck($key) : $this)
            ->filter(fn ($item) => ! is_null($item))
            ->sort()->values();

        $count = $values->count();

        if ($count === 0) {
            return null;
        }

        $middle = (int) ($count / 2);

        if ($count % 2) {
            return $values->get($middle);
        }

        return new static([
            $values->get($middle - 1), $values->get($middle),
        ])->average();
    }

    public function mode($key = null)
    {
        // TODO:
    }

    public function collapse()
    {
        $results = [];

        foreach ($this->items as $values) {
            if ($values instanceof MyCollection) {
                $values = $values->all();
            } elseif (! is_array($values)) {
                continue;
            }

            $results[] = $values;
        }

        return array_merge([], ...$results);
    }

    public function some($key, $operator = null, $value = null)
    {
        // TODO: Implement some() method.
    }

    public function containsStrict($key, $value = null)
    {
        // TODO: Implement containsStrict() method.
    }

    public function avg($callback = null)
    {
        $reduced = $this->reduce(static function (&$reduce, $value) use ($callback) {
            if (! is_null($resolved = $callback($value))) {
                $reduce[0] += $resolved;
                $reduce[1]++;
            }

            return $reduce;
        }, [0, 0]);

        return $reduced[1] ? $reduced[0] / $reduced[1] : null;
    }

    public function contains($key, $operator = null, $value = null)
    {
        // TODO: Implement contains() method.
    }

    public function doesntContain($key, $operator = null, $value = null)
    {
        // TODO: Implement doesntContain() method.
    }

    public function crossJoin(...$lists)
    {
        // TODO: Implement crossJoin() method.
    }

    public function dd(...$args)
    {
        // TODO: Implement dd() method.
    }

    public function dump(...$args)
    {
        // TODO: Implement dump() method.
    }

    public function diff($items)
    {
        // TODO: Implement diff() method.
    }

    public function diffUsing($items, callable $callback)
    {
        // TODO: Implement diffUsing() method.
    }

    public function diffAssoc($items)
    {
        // TODO: Implement diffAssoc() method.
    }

    public function diffAssocUsing($items, callable $callback)
    {
        // TODO: Implement diffAssocUsing() method.
    }

    public function diffKeys($items)
    {
        // TODO: Implement diffKeys() method.
    }

    public function diffKeysUsing($items, callable $callback)
    {
        // TODO: Implement diffKeysUsing() method.
    }

    public function duplicates($callback = null, $strict = false)
    {
        // TODO: Implement duplicates() method.
    }

    public function duplicatesStrict($callback = null)
    {
        // TODO: Implement duplicatesStrict() method.
    }

    public function each(callable $callback)
    {
        // TODO: Implement each() method.
    }

    public function eachSpread(callable $callback)
    {
        // TODO: Implement eachSpread() method.
    }

    public function every($key, $operator = null, $value = null)
    {
        // TODO: Implement every() method.
    }

    public function except($keys)
    {
        // TODO: Implement except() method.
    }

    public function filter(?callable $callback = null)
    {
        if ($callback) {
            return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
        }
        return new static(array_filter($this->items));
    }

    public function when($value, ?callable $callback = null, ?callable $default = null)
    {
        // TODO: Implement when() method.
    }

    public function whenEmpty(callable $callback, ?callable $default = null)
    {
        // TODO: Implement whenEmpty() method.
    }

    public function whenNotEmpty(callable $callback, ?callable $default = null)
    {
        // TODO: Implement whenNotEmpty() method.
    }

    public function unless($value, callable $callback, ?callable $default = null)
    {
        // TODO: Implement unless() method.
    }

    public function unlessEmpty(callable $callback, ?callable $default = null)
    {
        // TODO: Implement unlessEmpty() method.
    }

    public function unlessNotEmpty(callable $callback, ?callable $default = null)
    {
        // TODO: Implement unlessNotEmpty() method.
    }

    public function where($key, $operator = null, $value = null)
    {
        // TODO: Implement where() method.
    }

    public function whereNull($key = null)
    {
        // TODO: Implement whereNull() method.
    }

    public function whereNotNull($key = null)
    {
        // TODO: Implement whereNotNull() method.
    }

    public function whereStrict($key, $value)
    {
        // TODO: Implement whereStrict() method.
    }

    public function whereIn($key, $values, $strict = false)
    {
        // TODO: Implement whereIn() method.
    }

    public function whereInStrict($key, $values)
    {
        // TODO: Implement whereInStrict() method.
    }

    public function whereBetween($key, $values)
    {
        // TODO: Implement whereBetween() method.
    }

    public function whereNotBetween($key, $values)
    {
        // TODO: Implement whereNotBetween() method.
    }

    public function whereNotIn($key, $values, $strict = false)
    {
        // TODO: Implement whereNotIn() method.
    }

    public function whereNotInStrict($key, $values)
    {
        // TODO: Implement whereNotInStrict() method.
    }

    public function whereInstanceOf($type)
    {
        // TODO: Implement whereInstanceOf() method.
    }

    public function first(?callable $callback = null, $default = null)
    {
        // TODO: Implement first() method.
    }

    public function firstWhere($key, $operator = null, $value = null)
    {
        // TODO: Implement firstWhere() method.
    }

    public function flatten($depth = INF)
    {
        // TODO: Implement flatten() method.
    }

    public function flip()
    {
        // TODO: Implement flip() method.
    }

    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return $default;
    }

    public function groupBy($groupBy, $preserveKeys = false)
    {
        // TODO: Implement groupBy() method.
    }

    public function keyBy($keyBy)
    {
        // TODO: Implement keyBy() method.
    }

    public function has($key)
    {
        // TODO: Implement has() method.
    }

    public function hasAny($key)
    {
        // TODO: Implement hasAny() method.
    }

    public function implode($value, $glue = null)
    {
        // TODO: Implement implode() method.
    }

    public function intersect($items)
    {
        // TODO: Implement intersect() method.
    }

    public function intersectUsing($items, callable $callback)
    {
        // TODO: Implement intersectUsing() method.
    }

    public function intersectAssoc($items)
    {
        // TODO: Implement intersectAssoc() method.
    }

    public function intersectAssocUsing($items, callable $callback)
    {
        // TODO: Implement intersectAssocUsing() method.
    }

    public function intersectByKeys($items)
    {
        // TODO: Implement intersectByKeys() method.
    }

    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    public function isNotEmpty()
    {
        // TODO: Implement isNotEmpty() method.
    }

    public function containsOneItem()
    {
        // TODO: Implement containsOneItem() method.
    }

    public function join($glue, $finalGlue = '')
    {
        // TODO: Implement join() method.
    }

    public function keys()
    {
        return new static(array_keys($this->items));
    }

    public function last(?callable $callback = null, $default = null)
    {
        // TODO: Implement last() method.
    }

    public function map(callable $callback)
    {
        $result = [];
        foreach ($this->items as $key => $value) {
            $result[$key] = $callback($value, $key);
        }

        return new static($result);
    }

    public function mapSpread(callable $callback)
    {
        // TODO: Implement mapSpread() method.
    }

    public function mapToDictionary(callable $callback)
    {
        // TODO: Implement mapToDictionary() method.
    }

    public function mapToGroups(callable $callback)
    {
        // TODO: Implement mapToGroups() method.
    }

    public function mapWithKeys(callable $callback)
    {
        // TODO: Implement mapWithKeys() method.
    }

    public function flatMap(callable $callback)
    {
        // TODO: Implement flatMap() method.
    }

    public function mapInto($class)
    {
        // TODO: Implement mapInto() method.
    }

    public function merge($items)
    {
        // TODO: Implement merge() method.
    }

    public function mergeRecursive($items)
    {
        // TODO: Implement mergeRecursive() method.
    }

    public function combine($values)
    {
        // TODO: Implement combine() method.
    }

    public function union($items)
    {
        // TODO: Implement union() method.
    }

    public function min($callback = null)
    {
        // TODO: Implement min() method.
    }

    public function max($callback = null)
    {
        // TODO: Implement max() method.
    }

    public function nth($step, $offset = 0)
    {
        // TODO: Implement nth() method.
    }

    public function only($keys)
    {
        // TODO: Implement only() method.
    }

    public function forPage($page, $perPage)
    {
        // TODO: Implement forPage() method.
    }

    public function partition($key, $operator = null, $value = null)
    {
        // TODO: Implement partition() method.
    }

    public function concat($source)
    {
        // TODO: Implement concat() method.
    }

    public function random($number = null)
    {
        // TODO: Implement random() method.
    }

    public function reduce(callable $callback, $initial = null)
    {
        // TODO: Implement reduce() method.
    }

    public function reduceSpread(callable $callback, ...$initial)
    {
        // TODO: Implement reduceSpread() method.
    }

    public function replace($items)
    {
        // TODO: Implement replace() method.
    }

    public function replaceRecursive($items)
    {
        // TODO: Implement replaceRecursive() method.
    }

    public function reverse()
    {
        // TODO: Implement reverse() method.
    }

    public function search($value, $strict = false)
    {
        return array_search($value, $this->items, $strict);
    }

    public function before($value, $strict = false)
    {
        // TODO: Implement before() method.
    }

    public function after($value, $strict = false)
    {
        $key = $this->search($value, $strict);

        if ($key === false) {
            return null;
        }

        $position = ($keys = $this->keys())->search($key);

        if ($position === $keys->count() - 1) {
            return null;
        }

        return $this->get($keys->get($position + 1));
    }

    public function shuffle()
    {
        // TODO: Implement shuffle() method.
    }

    public function sliding($size = 2, $step = 1)
    {
        // TODO: Implement sliding() method.
    }

    public function skip($count)
    {
        // TODO: Implement skip() method.
    }

    public function skipUntil($value)
    {
        // TODO: Implement skipUntil() method.
    }

    public function skipWhile($value)
    {
        // TODO: Implement skipWhile() method.
    }

    public function slice($offset, $length = null)
    {
        // TODO: Implement slice() method.
    }

    public function split($numberOfGroups)
    {
        // TODO: Implement split() method.
    }

    public function sole($key = null, $operator = null, $value = null)
    {
        // TODO: Implement sole() method.
    }

    public function firstOrFail($key = null, $operator = null, $value = null)
    {
        // TODO: Implement firstOrFail() method.
    }

    public function chunk($size)
    {
        // TODO: Implement chunk() method.
    }

    public function chunkWhile(callable $callback)
    {
        // TODO: Implement chunkWhile() method.
    }

    public function splitIn($numberOfGroups)
    {
        // TODO: Implement splitIn() method.
    }

    public function sort($callback = null)
    {
        // TODO: Implement sort() method.
    }

    public function sortDesc($options = SORT_REGULAR)
    {
        // TODO: Implement sortDesc() method.
    }

    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        // TODO: Implement sortBy() method.
    }

    public function sortByDesc($callback, $options = SORT_REGULAR)
    {
        // TODO: Implement sortByDesc() method.
    }

    public function sortKeys($options = SORT_REGULAR, $descending = false)
    {
        // TODO: Implement sortKeys() method.
    }

    public function sortKeysDesc($options = SORT_REGULAR)
    {
        // TODO: Implement sortKeysDesc() method.
    }

    public function sortKeysUsing(callable $callback)
    {
        // TODO: Implement sortKeysUsing() method.
    }

    public function sum($callback = null)
    {
        // TODO: Implement sum() method.
    }

    public function take($limit)
    {
        // TODO: Implement take() method.
    }

    public function takeUntil($value)
    {
        // TODO: Implement takeUntil() method.
    }

    public function takeWhile($value)
    {
        // TODO: Implement takeWhile() method.
    }

    public function tap(callable $callback)
    {
        // TODO: Implement tap() method.
    }

    public function pipe(callable $callback)
    {
        // TODO: Implement pipe() method.
    }

    public function pipeInto($class)
    {
        // TODO: Implement pipeInto() method.
    }

    public function pipeThrough($pipes)
    {
        // TODO: Implement pipeThrough() method.
    }

    protected static function explodePluckParameters($value, $key)
    {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    }

    public function pluck($key = null): array
    {
        $results = [];
        if (is_null($key)) return $results;
        foreach ($this->items as $k=>$value) {
            if ($k === $key) $results[] = $value;
        }

        return $results;
    }

    public function reject($callback = true)
    {
        return $this->filter(function ($value, $key) use ($callback) {
            return !$callback($value, $key);
        });
    }


    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        foreach ($keys as $i => $key) {
            if (count($keys) === 1) {
                break;
            }

            unset($keys[$i]);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    public function undot()
    {
        $results = [];
        foreach ($this->items as $key => $value) {
            static::set($results, $key, $value);
        }

        return $results;
    }

    public static function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        foreach ($key as $i => $segment) {
            unset($key[$i]);

            if (is_null($segment)) {
                return $target;
            }

            if ($segment === '*') {
                if ($target instanceof MyCollection) {
                    $target = $target->all();
                } elseif (! is_iterable($target)) {
                    return self::value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = self::data_get($item, $key);
                }

                return in_array('*', $key) ? new static($result)->collapse() : $result;
            }

            $segment = match ($segment) {
                '\*' => '*',
                '\{first}' => '{first}',
                '{first}' => array_key_first(is_array($target) ? $target : (new static($target))->all()),
                '\{last}' => '{last}',
                '{last}' => array_key_last(is_array($target) ? $target : (new static($target))->all()),
                default => $segment,
            };

            if (self::accessible($target) && self::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return self::value($default);
            }
        }

        return $target;
    }

    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists($array, $key)
    {
        if ($array instanceof Enumerable) {
            return $array->has($key);
        }

        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        if (is_float($key)) {
            $key = (string) $key;
        }

        return array_key_exists($key, $array);
    }
    public static function value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }


    public function unique($key = null, $strict = false)
    {
        if (is_null($key) && $strict === false) {
            return new static(array_unique($this->items, SORT_REGULAR));
        }

        $uniqueItems = [];

        foreach ($this->items as $item) {
            $value = data_get($item, $key);
            $uniqueItems[$value] = $item;
        }

        return new static(array_values($uniqueItems));
    }

    public function uniqueStrict($key = null)
    {
        // TODO: Implement uniqueStrict() method.
    }

    public function values()
    {
        return new static(array_values($this->items));
    }

    public function pad($size, $value)
    {
        // TODO: Implement pad() method.
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function countBy($countBy = null)
    {
        // TODO: Implement countBy() method.
    }

    public function zip($items)
    {
        // TODO: Implement zip() method.
    }

    public function collect()
    {
        // TODO: Implement collect() method.
    }

}