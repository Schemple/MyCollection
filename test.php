<?php
require "MyCollection.php";
$x = new MyCollection([1,2,3,7,9]);
print_r($x->all());

$x->add(99);
print("add 99 ");
print_r($x->all());

$x->remove(99);
print("remove 99 ");
print_r($x->all());

$y = $x->map(fn($item) => $item * 2);
print("map ");
print_r($y->all());

$y = $x->filter(fn($item) => $item % 2 === 0);
print("filter ");
print_r($y->all());

$y = $x->after(7);
print("after 7: ");
print($y . "\n");

$y = $x->nth(2);
print("nth n=2 ");
print_r($y);

$y = $x->nth(2, 2);
print("nth n=2 step=2 ");
print_r($y);