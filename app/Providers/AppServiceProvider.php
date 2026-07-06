<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $contractFiles = File::files(app_path('Http/Contracts'));
        
        foreach ($contractFiles as $file) {
            $baseName = $file->getFilenameWithoutExtension();
            if (str_ends_with($baseName, 'ServiceInterface')) {
                $serviceName = str_replace('ServiceInterface', 'Service', $baseName);
                
                $contractClass = 'App\\Http\\Contracts\\' . $baseName;
                $serviceClass = 'App\\Http\\Services\\' . $serviceName;
                
                if (class_exists($serviceClass) && interface_exists($contractClass)) {
                    $this->app->singleton($contractClass, $serviceClass);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
