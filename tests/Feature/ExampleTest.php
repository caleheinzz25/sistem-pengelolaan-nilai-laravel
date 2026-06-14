<?php

test('root redirects to login page for guests', function () {
    $this->get('/')->assertRedirect('/login');
});
