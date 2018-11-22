@if( !empty($authUser) )
    @include('layouts.teacher.teacher-widget')
@endif
<div class="mainarea">
@yield('content')
</div>