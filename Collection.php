<?php
interface Collection
{
    public function all();
    public function add($item);
    public function remove($item);
    public function map(callable $callback);
    public function filter(callable $callback);
    public function first();
    public function last();
    public function isEmpty();
    public function isNotEmpty();
    public function count();
    public function get($key);
    public function search($value);
    public function keys();
    public function values();
    public function min($k = null);
    public function max($k = null);
    public function nth($n, $step = 1);
    public static function make($items = []);
    public static function exists($array, $key);
    public static function times($number, ?callable $callback = null);
    public static function range($from, $to);
    public static function empty();
}