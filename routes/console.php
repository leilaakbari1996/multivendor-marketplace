<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('model:prune')
    ->dailyAt('03:00')
    ->withoutOverlapping();
