<?php

app()->get(
    '/',
    static function (): void {
        inertia('Index');
    }
);
