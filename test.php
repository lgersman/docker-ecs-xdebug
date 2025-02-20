<?php

printf("hello world\n");

$complex_obj = [
    'foo'  => 'bar',
    'baz'  => 'qux',
    'quux' => [
        'corge'          => 'grault',
        'garply-frz-gen' => 'waldo',
        'fred'           => 'plugh',
    ],
];

$foo = 'bar';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://web.de');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

if (false === $output) {
  printf('Curl error: ' . curl_error($ch));
} else {
  printf($output);
}

curl_close($ch);

printf("{$foo}\n");
