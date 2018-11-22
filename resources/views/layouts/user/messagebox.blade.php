@if(Session::has('message-success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> @lang('user.messages.general.success')</h4>
        <p class="message"> {{ Session::get('message-success') }}</p>
    </div>
@endif
@if(Session::has('message-failed'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-times"></i> @lang('user.messages.general.failed')</h4>
        <p class="message"> {{ Session::get('message-failed') }}</p>
    </div>
@endif