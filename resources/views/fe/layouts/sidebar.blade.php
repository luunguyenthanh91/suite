<aside class="sidebar">
    <ul class="main-menu">
        @foreach(Helper::first_function() as $category)
            <li class="">
                {{ $category['name'] }}
            </li>
        @endforeach
    </ul>
</aside>