<?php
require "Collection.php";

class MyCollection implements Collection
{
    protected $items;

    public function __construct(array $items)
    {
        if (is_array($items)) {
            $this->items = $items;
        } else {
            $this->items = $items->all();
        }
    }

    public function all()
    {
        return $this->items;
    }

    public function add($item)
    {
        $this->items[] = $item;
        return $this;
    }

    public function remove($item)
    {
        $this->items = array_diff($this->items, [$item]);
        return $this;
    }

    public function map(callable $callback)
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = $callback($item);
        }

        return new MyCollection($result);
    }

    public function filter(callable $callback)
    {
        $result = [];
        foreach ($this->items as $item) {
            if ($callback($item)) $result[] = $item;
        }
        return new MyCollection($result);
    }

    public function first()
    {
        return $this->items[0] ?? null;
    }

    public function last()
    {
        return end($this->items);
    }

    public function isEmpty()
    {
        return $this->items === [];
    }

    public function isNotEmpty()
    {
        return $this->items !== [];
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return null;
    }

    public function search($value)
    {
        return array_search($value, $this->items);
    }

    public function keys()
    {
        return new static(array_keys($this->items));
    }

    public function values()
    {
        return new static(array_values($this->items));
    }

    public function min($k = null)
    {
        if (is_null($k)) {
            return min($this->items);
        }

        return min(array_map(fn($item) => is_array($item) ? ($item[$k] ?? null) : ($item->{$k} ?? null), $this->items));
    }

    public function max($k = null)
    {
        if (is_null($k)) {
            return max($this->items);
        }

        return max(array_map(fn($item) => is_array($item) ? ($item[$k] ?? null) : ($item->{$k} ?? null), $this->items));
    }

    public function nth($n, $step = 1)
    {
        return array_slice($this->items, $n, $step, true);
    }

    public static function make($items = [])
    {
        return new MyCollection($items);
    }

    public static function exists($array, $key)
    {
        return array_key_exists($key, $array);
    }

    public static function times($number, ?callable $callback = null)
    {
        $results = [];
        for ($i = 0; $i < $number; $i++) {
            if ($callback) {
                $results[] = $callback($i);
            } else {
                $results[] = $i;
            }
        }
        return new MyCollection($results);
    }

    public static function range($from, $to): MyCollection
    {
        return new static (range($from, $to));
    }

    public static function empty()
    {
        return new static([]);
    }

    public function after($value)
    {
        $key = $this->search($value);

        if ($key === false) {
            return null;
        }

        $position = ($keys = $this->keys())->search($key);

        if ($position === $keys->count() - 1) {
            return null;
        }

        return $this->get($keys->get($position + 1));
    }
}