<div class="profile-sidebar">
    <div class="profile">
        <div class="avatar" style="background-image: url('{{ asset("storage/avatars/{$user->avatar}") }}')"></div>
        <div class="profile-wrapper">
            <h3 class="name">{{ $user->name }}</h3>
            <p class="username">{{ "@{$user->username}" }}</p>
            <p class="location"><span class="glyphicon glyphicon-map-marker"></span> {{ $user->location }}</p>
            <p class="about hidden-xs">{{ $user->about }}</p>
        </div>
    </div>
    <ul class="info list-group hidden-xs hidden-sm">
        <li class="list-group-item">
            <strong>Portfolio</strong>
            <p>{{ $user->portfolios()->count() }} Items</p>
        </li>
        <li class="list-group-item">
            <strong>Email</strong>
            <p>{{ $user->email }}</p>
        </li>
        <li class="list-group-item">
            <strong>Birthday</strong>
            <p>{{ $user->birthday->format('d F Y') }}</p>
        </li>
        <li class="list-group-item">
            <strong>Contact</strong>
            <p>{{ $user->contact }}</p>
        </li>
        <li class="list-group-item">
            <strong>Gender</strong>
            <p>{{ $user->gender }}</p>
        </li>
    </ul>
</div>