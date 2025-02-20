<?php
require "MyCollection.php";
$x = new MyCollection([1,2,3,7,9]);
$test = MyCollection::times(5);
print_r($test->pluck(2));