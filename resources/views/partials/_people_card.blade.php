@foreach($users as $user)

    <div class="{{ $columns }}">
        <div class="panel panel-default people-item">
            <div class="featured" style="background: url('{{ asset("storage/avatars/{$user->avatar}") }}') center center / cover;"></div>
            <div class="caption">
                <div class="title-wrapper">
                    <h3 class="name">
                        <a href="{{ route('profile.show', [$user->username]) }}">
                            {{ $user->name }}
                        </a>
                    </h3>
                    <p class="username">{{ "@{$user->username}" }}</p>
                </div>
                <hr>
                <p>{{ $user->portfolios()->count() }} Showcases</p>
            </div>
        </div>
    </div>
@endforeach