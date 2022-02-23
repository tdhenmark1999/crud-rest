@if(session()->has('notification-status'))
<div role="alert" class="alert alert-{{in_array(session()->get('notification-status'),["failed","error"]) ? "danger" : session()->get('notification-status') }} alert-dismissible">
 {{session()->get('notification-msg')}} 
</div>
@endif
