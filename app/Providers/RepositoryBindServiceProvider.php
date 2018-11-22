<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindServiceProvider extends ServiceProvider
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
            \App\Repositories\AdminUserRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AdminUserRoleRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRoleRepository::class
        );

        $this->app->singleton(\App\Repositories\UserRepositoryInterface::class, \App\Repositories\Eloquent\UserRepository::class);

        $this->app->singleton(\App\Repositories\FileRepositoryInterface::class, \App\Repositories\Eloquent\FileRepository::class);

        $this->app->singleton(\App\Repositories\ImageRepositoryInterface::class, \App\Repositories\Eloquent\ImageRepository::class);

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserServiceAuthenticationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserServiceAuthenticationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\PasswordResettableRepositoryInterface::class,
            \App\Repositories\Eloquent\PasswordResettableRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\UserPasswordResetRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AdminPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminPasswordResetRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ArticleRepositoryInterface::class,
            \App\Repositories\Eloquent\ArticleRepository::class
        );

        $this->app->singleton(
            \App\Repositories\NotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\NotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserNotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AdminUserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserNotificationRepository::class
        );

        $this->app->singleton(
            'App\Repositories\TeacherRepositoryInterface',
            'App\Repositories\Eloquent\TeacherRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherPasswordResetRepositoryInterface',
            'App\Repositories\Eloquent\TeacherPasswordResetRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherServiceAuthenticationRepositoryInterface',
            'App\Repositories\Eloquent\TeacherServiceAuthenticationRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherNotificationRepositoryInterface',
            'App\Repositories\Eloquent\TeacherNotificationRepository'
        );

        $this->app->singleton(
            'App\Repositories\BookingRepositoryInterface',
            'App\Repositories\Eloquent\BookingRepository'
        );

        $this->app->singleton(
            'App\Repositories\CharacteristicRepositoryInterface',
            'App\Repositories\Eloquent\CharacteristicRepository'
        );

        $this->app->singleton(
            'App\Repositories\FavoriteTeacherRepositoryInterface',
            'App\Repositories\Eloquent\FavoriteTeacherRepository'
        );

        $this->app->singleton(
            'App\Repositories\GenreRepositoryInterface',
            'App\Repositories\Eloquent\GenreRepository'
        );

        $this->app->singleton(
            'App\Repositories\PaymentLogRepositoryInterface',
            'App\Repositories\Eloquent\PaymentLogRepository'
        );

        $this->app->singleton(
            'App\Repositories\PointLogRepositoryInterface',
            'App\Repositories\Eloquent\PointLogRepository'
        );

        $this->app->singleton(
            'App\Repositories\ProvinceRepositoryInterface',
            'App\Repositories\Eloquent\ProvinceRepository'
        );

        $this->app->singleton(
            'App\Repositories\PurchaseLogRepositoryInterface',
            'App\Repositories\Eloquent\PurchaseLogRepository'
        );

        $this->app->singleton(
            'App\Repositories\ReviewRepositoryInterface',
            'App\Repositories\Eloquent\ReviewRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherGenreRepositoryInterface',
            'App\Repositories\Eloquent\TeacherGenreRepository'
        );

        $this->app->singleton(
            'App\Repositories\TimeSlotRepositoryInterface',
            'App\Repositories\Eloquent\TimeSlotRepository'
        );

        $this->app->singleton(
            'App\Repositories\CategoryRepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherCategoryRepositoryInterface',
            'App\Repositories\Eloquent\TeacherCategoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\PersonalityRepositoryInterface',
            'App\Repositories\Eloquent\PersonalityRepository'
        );

        $this->app->singleton(
            'App\Repositories\TeacherPersonalityRepositoryInterface',
            'App\Repositories\Eloquent\TeacherPersonalityRepository'
        );

        $this->app->singleton(
            'App\Repositories\CityRepositoryInterface',
            'App\Repositories\Eloquent\CityRepository'
        );

        $this->app->singleton(
            'App\Repositories\CountryRepositoryInterface',
            'App\Repositories\Eloquent\CountryRepository'
        );

        $this->app->singleton(
            'App\Repositories\InquiryRepositoryInterface',
            'App\Repositories\Eloquent\InquiryRepository'
        );

        $this->app->singleton(
            \App\Repositories\EmailLogRepositoryInterface::class,
            \App\Repositories\Eloquent\EmailLogRepository::class
        );

        $this->app->singleton(
            \App\Repositories\LessonRepositoryInterface::class,
            \App\Repositories\Eloquent\LessonRepository::class
        );

        $this->app->singleton(
            \App\Repositories\TeacherLessonRepositoryInterface::class,
            \App\Repositories\Eloquent\TeacherLessonRepository::class
        );

        $this->app->singleton(
            \App\Repositories\TextBookRepositoryInterface::class,
            \App\Repositories\Eloquent\TextBookRepository::class
        );

        /* NEW BINDING */
    }
}
