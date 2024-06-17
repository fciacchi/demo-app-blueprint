<?php

app()->get(
    '/',
    static function (): void {
        // `render(view, [])` is the same as `echo view(view, [])`.
        render('index');
    }
);
