<div class="container">
    <div class="row">
        @card(['title' => 'Most Commented',
               'subtitle' => 'What people are currently talking about'])
            @slot('items')
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            @endslot
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title' => 'Most Active Users',
               'subtitle' => 'Users with most posts written',
               'items' => collect($mostActiveUsers)->pluck('name')])
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title' => 'Most Active Users Last Month',
               'subtitle' => 'Users with most posts written since last month',
               'items' => collect($mostActiveUsersLastMonth)->pluck('name')])
        @endcard
    </div>
</div>
