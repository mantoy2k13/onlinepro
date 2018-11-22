<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! $authUser->getProfileImageUrl() !!}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{!! $authUser->name !!}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <li @if( $menu=='dashboard') class="active" @endif ><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
            <li @if( $menu=='admin_users') class="active" @endif ><a href="{!! URL::action('Admin\AdminUserController@index') !!}"><i class="fa fa-user-secret"></i> <span>Admin Users</span></a></li>
            <li @if( $menu=='site_configurations') class="active" @endif ><a href="{!! URL::action('Admin\SiteConfigurationController@index') !!}"><i class="fa fa-cogs"></i> <span>Site Configurations</span></a></li>
            @endif
            <li @if( $menu=='users') class="active" @endif ><a href="{!! URL::action('Admin\UserController@index') !!}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li @if( $menu=='user_notification') class="active" @endif ><a href="{!! URL::action('Admin\UserNotificationController@index') !!}"><i class="fa fa-bell"></i> <span>UserNotifications</span></a></li>
            <li @if( $menu=='admin_user_notification') class="active" @endif ><a href="{!! URL::action('Admin\AdminUserNotificationController@index') !!}"><i class="fa fa-bell-o"></i> <span>AdminUserNotifications</span></a></li>
            <li @if( $menu=='image') class="active" @endif ><a href="{!! URL::action('Admin\ImageController@index') !!}"><i class="fa fa-file-image-o"></i> <span>Images</span></a></li>
            <li @if( $menu=='booking') class="active" @endif ><a href="{!! action('Admin\BookingController@index') !!}"><i class="fa fa-users"></i> <span>Bookings</span></a></li>
            <li @if( $menu=='review') class="active" @endif ><a href="{!! action('Admin\ReviewController@index') !!}"><i class="fa fa-users"></i> <span>Reviews</span></a></li>
            <li @if( $menu=='country') class="active" @endif ><a href="{!! action('Admin\CountryController@index') !!}"><i class="fa fa-users"></i> <span>Countries</span></a></li>
            <li @if( $menu=='city') class="active" @endif ><a href="{!! action('Admin\CityController@index') !!}"><i class="fa fa-users"></i> <span>Cities</span></a></li>
            <li @if( $menu=='province') class="active" @endif ><a href="{!! action('Admin\ProvinceController@index') !!}"><i class="fa fa-users"></i> <span>Provinces</span></a></li>
            <li @if( $menu=='payment_log') class="active" @endif ><a href="{!! action('Admin\PaymentLogController@index') !!}"><i class="fa fa-users"></i> <span>PaymentLogs</span></a></li>
            <li @if( $menu=='inquiry') class="active" @endif ><a href="{!! action('Admin\InquiryController@index') !!}"><i class="fa fa-users"></i> <span>Inquiries</span></a></li>
            <li @if( $menu=='purchase_log') class="active" @endif ><a href="{!! action('Admin\PurchaseLogController@index') !!}"><i class="fa fa-users"></i> <span>PurchaseLogs</span></a></li>
            <li @if( $menu=='teacher') class="active" @endif ><a href="{!! action('Admin\TeacherController@index') !!}"><i class="fa fa-users"></i> <span>Teachers</span></a></li>
            <li @if( $menu=='point_log') class="active" @endif ><a href="{!! action('Admin\PointLogController@index') !!}"><i class="fa fa-users"></i> <span>PointLogs</span></a></li>
            <li @if( $menu=='teacher_notification') class="active" @endif ><a href="{!! action('Admin\TeacherNotificationController@index') !!}"><i class="fa fa-users"></i> <span>TeacherNotifications</span></a></li>
            <li @if( $menu=='email_log') class="active" @endif ><a href="{!! action('Admin\EmailLogController@index') !!}"><i class="fa fa-users"></i> <span>EmailLogs</span></a></li>
            <li @if( $menu=='text_book') class="active" @endif ><a href="{!! action('Admin\TextBookController@index') !!}"><i class="fa fa-users"></i> <span>TextBooks</span></a></li>
            <li @if( $menu=='personalities') class="active" @endif ><a href="{!! action('Admin\PersonalityController@index') !!}"><i class="fa fa-users"></i> <span>Personalities</span></a></li>
            <!-- %%SIDEMENU%% -->
        </ul>
    </section>
</aside>
