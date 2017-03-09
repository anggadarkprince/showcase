@extends('layouts.app')

@section('title', '- Activities')

@section('content')
    <div class="container activity-wrapper" data-id="{{ Auth::user()->id }}">

        <div class="row">
            <div class="col-md-4 col-lg-3">
                @include('partials._profile_sidebar')
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Activities</div>
                        </div>
                    </div>
                </div>
                @include('errors.common')

                <ul class="list-unstyled activity-unread-wrapper" style="padding: 10px">
                    <li class="text-primary m-b-sm">Unread Notifications</li>
                    @forelse($user->unreadNotifications as $notification)

                        <li class="m-b-sm">
                            @if($notification->type == \App\Notifications\WelcomeGreeting::class)
                                Hi {{ $notification->data['name'] }},<br>
                                {{ $notification->data['message'] }}
                            @elseif($notification->type == \App\Notifications\UpdateActivityView::class)
                                <a href="{{ route('profile.show', [$notification->data['username']]) }}">
                                    {{ '@'.$notification->data['username'] }}
                                </a>
                                {{ $notification->data['message'] }}
                            @endif

                            @if(is_null($notification->read_at))
                                <span class="label label-primary m-l-sm">NEW</span>
                            @endif
                            <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="m-b-sm">You are up to date</li>
                    @endforelse
                    <li class="m-b-sm text-primary">Past Activities</li>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($user->notifications as $notification)
                        @if(!is_null($notification->read_at))
                            @php $count++; @endphp
                            <li class="m-b-sm">
                                @if($notification->type == \App\Notifications\WelcomeGreeting::class)
                                    Hi {{ $notification->data['name'] }},<br>
                                    {{ $notification->data['message'] }}
                                @elseif($notification->type == \App\Notifications\UpdateActivityView::class)
                                    <a href="{{ route('profile.show', [$notification->data['username']]) }}">
                                        {{ '@'.$notification->data['username'] }}
                                    </a>
                                    {{ $notification->data['message'] }}
                                @endif

                                @if(is_null($notification->read_at))
                                    <span class="label label-primary m-l-sm">NEW</span>
                                @endif
                                <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                            </li>
                        @endif
                    @endforeach
                    @if($count == 0)
                        <li class="m-b-sm">No old activities</li>
                    @endif

                    @php
                        $user->unreadNotifications->markAsRead();
                    @endphp
                </ul>
            </div>
        </div>
    </div>
@endsection