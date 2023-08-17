<?php

use PhpTelegramBot\FluentKeyboard\ReplyKeyboardRemove;

it('creates valid JSON', function () {
    $keyboard = ReplyKeyboardRemove::make();

    expect($keyboard)->toMatchEntity([
        'remove_keyboard' => true
    ]);
});

it('can set known fields', function () {
    $keyboard = ReplyKeyboardRemove::make()
        ->selective();

    expect($keyboard)->toMatchEntity([
        'remove_keyboard' => true,
        'selective'       => true,
    ]);
});

it('can set unknown fields', function () {
    $keyboard = ReplyKeyboardRemove::make()
        ->unknownFields('unknown');

    expect($keyboard)->toMatchEntity([
        'remove_keyboard' => true,
        'unknown_fields'  => 'unknown'
    ]);
});