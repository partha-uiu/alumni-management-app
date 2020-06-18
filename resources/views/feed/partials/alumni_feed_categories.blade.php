@php
    if(!isset($active) || !$active) {
        $active = 'all';
    }
@endphp

<div class="card border-color-9">
    <div class="card-header background-oxford color-white p-3 border-color-oxford">
        <i class="fa fa-rss pr-2"></i> Alumni Feeds
    </div>
    <div class="list-group list-group-flush alumni-feed-categories">
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'all') active @endif" href="{{ route('feed', ['q' => 'all']) }}"><i class="icon-A-Z mr-3"></i> All</a>
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'event') active @endif" href="{{ route('feed', ['q' => 'event']) }}"><i class="icon-Balloon mr-3"></i> Event</a>
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'news') active @endif" href="{{ route('feed', ['q' => 'news']) }}"><i class="icon-Newspaper-2 mr-3"></i> News</a>
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'job') active @endif" href="{{ route('feed', ['q' => 'job']) }}"><i class="icon-Management mr-3"></i> Job</a>
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'donation') active @endif" href="{{ route('feed', ['q' => 'donation']) }}"><i class="icon-Money-2 mr-3"></i> Donation</a>
        <a class="list-group-item list-group-item-action hv-cursor-pointer @if($active == 'poll') active @endif" href="{{ route('feed', ['q' => 'poll']) }}"><i class="icon-Bar-Chart3 mr-3"></i> Poll</a>
    </div>
</div>