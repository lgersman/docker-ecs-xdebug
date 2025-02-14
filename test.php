<?php

echo "hello world\n";

$complex_obj =[
"foo" => "bar",
"baz" => "qux",
"quux" => [
"corge" => "grault",
"garply-frz-gen" => "waldo",
"fred" => "plugh"
],
];

$foo="bar";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://web.de");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

if ($output === false) {
  echo 'Curl error: ' . curl_error($ch);
} else {
  echo $output;
}

curl_close($ch);

echo "{$foo}\n";
