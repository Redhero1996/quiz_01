@extends('main')
@section('title', ' Mini Test ')
@section('content')
    <div class="row">
        <div class="col-sm-2">
            <nav id="nav-sidebar" class="bg-faded">
                <p class="mt-3"></p>
                <div class="sidebar-content hidden-sm-down">
                    <ul class="nav nav-pills flex-column" id="menu">
                        <li class="view overlay z-depth-1-half">
                            <a class="nav-link active" href="{{ url('/') }}">{{ trans('translate.category') }} <span class="sr-only">(current)</span></a>
                            <div class="mask rgba-white-slight"></div>
                        </li>
                        @foreach ($categories as $category)
                        <li class="nav-item view overlay z-depth-1-half" value="{{ $category->id }}">
                            <span class="nav-link">{{ $category->name }} ({{ count($category->topics) }})</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-9" id="topics">
            <p class="mt-3"></p>
            @foreach ($topics as $topic)
                <a class="chip chip-lg light-blue lighten-4" href="{{ route('quiz', [$topic->category->slug, $topic->slug]) }}">
                    <div class="calendar">
                        <div class="year">{{ $topic->created_at['year'] }}</div>
                        <div class="day">{{ $topic->created_at['day'] }}
                            <div id="line"></div>
                        </div>
                        <div class="month">{{ $topic->created_at['month'] }}</div>
                    </div>
                    <div class="div-content">
                        {{ $topic->name }}
                    </div>
                </a>
                <p class="row-space"></p>
            @endforeach
            <div class="row" id="paginate">
                {!! $topics->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('ul#menu > li.nav-item').click(function () {
                // handle click event
                $(this).attr('id', 'active');
                var li_current = $(this).parents().find('li');
                if (li_current.attr('id', 'active')) {
                    li_current.removeAttr('id');
                    $(this).attr('id', 'active');
                }
                var category_id = $(this).val();

                // Use ajax for category
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        // 'accepts': 'application/json',
                    }
                });
                $.ajax({
                    url: 'category/' + category_id,
                    type: 'GET',
                    datatype: 'json',
                    success: function(data) {
                        $('#topics').empty();
                        $.each(data.topics, function(key, topic) {
                            date = topic.created_at;
                            $('#topics').append(
                                `<p class="mt-3"></p>
                                    <a href="`+ data.category_slug + `/` + topic.slug +`" class="chip chip-lg light-blue lighten-4 waves-effect">
                                        <div class="calendar">
                                            <div class="year">`+ date.year +`</div>
                                            <div class="day">`+ date.day +`
                                                <div id="line"></div>
                                            </div>
                                            <div class="month">`+ date.month +`</div>
                                        </div>
                                        <div class="div-content">
                                            `+ topic.name +`
                                        </div>
                                    </a>
                                <p class="row-space"></p>`
                            );
                        });
                    }
                });
            });
        });
    </script>
@endsection
