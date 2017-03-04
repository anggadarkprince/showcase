<div class="panel panel-default profile-sidebar">
    <div class="profile">
        <div class="avatar" style="background-image: url('{{ asset("storage/avatars/{$user->avatar}") }}')"></div>
        <div class="profile-wrapper">
            <a href="{{ route('profile.show', [$user->username]) }}" class="name">{{ $user->name }}</a>
            <p class="username">{{ "@{$user->username}" }}</p>
            <p class="location"><span class="glyphicon glyphicon-map-marker"></span> {{ $user->location or "No location" }}</p>
            <p class="about hidden-xs">{!! $user->about !!}</p>
        </div>
        @if(Auth::check())
            <?php $loggedUser = Auth::user(); ?>
            @if($user->username == $loggedUser->username)
                <a href="{{ route('account.portfolio.create', [$loggedUser->username]) }}" class="btn btn-primary btn-block">CREATE PORTFOLIO</a>
            @endif
        @endif
    </div>
    <ul class="info list-group hidden-xs hidden-sm">
        <li class="list-group-item">
            <strong>Portfolio</strong>
            <p>{{ $user->portfolios()->count() }} Items</p>
        </li>
        <li class="list-group-item">
            <strong>Email</strong>
            <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
        </li>
        <li class="list-group-item">
            <strong>Birthday</strong>
            <p>@if(is_null($user->birthday)){{ "-" }}@else{{ $user->birthday->format('d F Y') }}@endif</p>
        </li>
        <li class="list-group-item">
            <strong>Contact</strong>
            <p>{{ $user->contact or "-" }}</p>
        </li>
        <li class="list-group-item">
            <strong>Gender</strong>
            <p>{{ $user->gender or "-" }}</p>
        </li>
    </ul>
</div>