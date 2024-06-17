<?php

app()->get(
    '/hello',
    static function (): void {
        inertia('Hello');
    }
);
