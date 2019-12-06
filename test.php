<?php
echo "<img src='https://pics3.baidu.com/feed/6f061d950a7b0208b4602310333d2bd6552cc884.jpeg?token=9e3c6da39d30e755070ade98bcfa9508&s=4C82609C46FB1F862C8439800300F088' />";
die;
$str = '<img  width="100" height="200" src="https://t12.baidu.com/it/u=3999260081,4172311933&fm=76" /><img  width="100" height="200" src="pics3.baidu.com/feed/6f061d950a7b0208b4602310333d2bd6552cc884.jpeg?token=9e3c6da39d30e755070ade98bcfa9508&s=4C82609C46FB1F862C8439800300F088" />';
$pattern = '/src=\"[\S]*\"/i';
preg_match_all($pattern,$str , $result);
var_dump($result);