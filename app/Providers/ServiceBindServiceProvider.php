<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(
            \App\Services\AdminUserServiceInterface::class,
            \App\Services\Production\AdminUserService::class
        );

        $this->app->singleton(\App\Services\APIServiceInterface::class, \App\Services\Production\APIService::class);

        $this->app->singleton(\App\Services\AsyncServiceInterface::class, \App\Services\Production\AsyncService::class);

        $this->app->singleton(
            \App\Services\AuthenticatableServiceInterface::class,
            \App\Services\Production\AuthenticatableService::class
        );

        $this->app->singleton(\App\Services\BaseServiceInterface::class, \App\Services\Production\BaseService::class);

        $this->app->singleton(
            \App\Services\FileUploadServiceInterface::class,
            \App\Services\Production\FileUploadService::class
        );

        $this->app->singleton(\App\Services\ImageServiceInterface::class, \App\Services\Production\ImageService::class);

        $this->app->singleton(
            \App\Services\LanguageDetectionServiceInterface::class,
            \App\Services\Production\LanguageDetectionService::class
        );

        $this->app->singleton(\App\Services\MailServiceInterface::class, \App\Services\Production\MailService::class);

        $this->app->singleton(
            \App\Services\MetaInformationServiceInterface::class,
            \App\Services\Production\MetaInformationService::class
        );

        $this->app->singleton(
            \App\Services\ServiceAuthenticationServiceInterface::class,
            \App\Services\Production\ServiceAuthenticationService::class
        );

        $this->app->singleton(\App\Services\SlackServiceInterface::class, \App\Services\Production\SlackService::class);

        $this->app->singleton(
            \App\Services\UserServiceAuthenticationServiceInterface::class,
            \App\Services\Production\UserServiceAuthenticationService::class
        );

        $this->app->singleton(\App\Services\UserServiceInterface::class, \App\Services\Production\UserService::class);

        $this->app->singleton(
            \App\Services\GoogleAnalyticsServiceInterface::class,
            \App\Services\Production\GoogleAnalyticsService::class
        );

        $this->app->singleton(
            \App\Services\ArticleServiceInterface::class,
            \App\Services\Production\ArticleService::class
        );

        $this->app->singleton(
            \App\Services\UserNotificationServiceInterface::class,
            \App\Services\Production\UserNotificationService::class
        );

        $this->app->singleton(
            \App\Services\AdminUserNotificationServiceInterface::class,
            \App\Services\Production\AdminUserNotificationService::class
        );

        $this->app->singleton(
            \App\Services\TeacherServiceInterface::class,
            \App\Services\Production\TeacherService::class
        );

        $this->app->singleton(
            \App\Services\BookingServiceInterface::class,
            \App\Services\Production\BookingService::class
        );

        $this->app->singleton(
            \App\Services\TimeSlotServiceInterface::class,
            \App\Services\Production\TimeSlotService::class
        );

        $this->app->singleton(
            \App\Services\ExcelServiceInterface::class,
            \App\Services\Production\ExcelService::class
        );

        $this->app->singleton(
            \App\Services\TimeSlotServiceInterface::class,
            \App\Services\Production\TimeSlotService::class
        );

        $this->app->singleton(
            \App\Services\PointServiceInterface::class,
            \App\Services\Production\PointService::class
        );

        $this->app->singleton(
            \App\Services\PayPalServiceInterface::class,
            \App\Services\Production\PayPalService::class
        );

        $this->app->singleton(
            \App\Services\PointLogServiceInterface::class,
            \App\Services\Production\PointLogService::class
        );

        $this->app->singleton(
            \App\Services\CategoryServiceInterface::class,
            \App\Services\Production\CategoryService::class
        );

        $this->app->singleton(
            \App\Services\LessonInterface::class,
            \App\Services\Production\Lesson::class
        );

        $this->app->singleton(
            \App\Services\LessonServiceInterface::class,
            \App\Services\Production\LessonService::class
        );

        /* NEW BINDING */
    }
}
