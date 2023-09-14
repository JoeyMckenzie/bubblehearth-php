<?php

namespace Feature;

use Joeymckenzie\Bubblehearth\BubbleHearthClient;

test('client test', function () {
    $client = new BubbleHearthClient('', '');

    $client->run();

    expect(true)->toBeTrue();
});
