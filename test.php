<?php
$lines = file('storage/logs/laravel.log');
$errors = array_filter($lines, function($line) {
    return str_contains($line, 'local.ERROR');
});
echo end($errors);
