<?php

use App\Http\Facades\AttendanceModeFacade;
use App\Http\Contracts\AttendanceModeServiceInterface;
use App\Http\Facades\BookFacade;
use App\Http\Contracts\BookServiceInterface;

test('facades resolve to correct interface', function () {
    $reflection = new ReflectionClass(AttendanceModeFacade::class);
    $method = $reflection->getMethod('getFacadeAccessor');
    $method->setAccessible(true);
    expect($method->invoke(null))->toBe(AttendanceModeServiceInterface::class);
    
    $reflection = new ReflectionClass(BookFacade::class);
    $method = $reflection->getMethod('getFacadeAccessor');
    $method->setAccessible(true);
    expect($method->invoke(null))->toBe(BookServiceInterface::class);
});
