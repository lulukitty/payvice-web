@foreach($list[1] as $agent)
<a href="#" data-agent="{{ $agent['TID'] }}" data-email="{{ $agent['USR_USERID'] }}"><strong><i class="fa fa-user"></i> {{ $agent['TID'] }}</strong></a><br>
@endforeach
