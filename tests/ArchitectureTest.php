<?php

test('all files should be strictly typed', fn () => expect('Bubblehearth\Bubblehearth')
    ->toUseStrictTypes()
    ->and('Bubblehearth\Bubblehearth')
    ->classes()
    ->toBeFinal());
