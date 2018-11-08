@extends('main')
@section('content')
    <div class="row">
        <div class="col-sm-2">
            <nav id="nav-sidebar" class="bg-faded mt-3">
                <div class="sidebar-content hidden-sm-down">
                    <ul class="nav nav-pills flex-column" id="menu">
                            <a class="nav-link active" href="{{ url('/') }}">{{ __('translate.category') }} </a>
                            <!-- Search form -->
                            <form class="form-inline md-form form-sm active-pink-2 mt-2">
                              <input class="form-control form-control-sm w-55 search" id="search" type="text" placeholder="Search" aria-label="Search">
                              <i class="fa fa-search" aria-hidden="true"></i>
                            </form>
                            {{-- <div class="mask rgba-white-slight"></div> --}}
                        <div id="show-search">
                            @foreach ($categories as $category)
                            <li class="nav-item view overlay z-depth-1-half" value="{{ $category->id }}">
                                <span class="nav-link">{{ $category->name }} ({{ count($category->topics) }})</span>
                            </li>
                            @endforeach

                        </div>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-6 mt-3" id="topics">
            @foreach ($topics as $topic)
                <a class="chip chip-lg light-blue lighten-4 topic" id="{{ $topic->id }}" href="{{ route('quiz', [$topic->category->slug, $topic->slug]) }}">
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
                    <div class="div-quest">
                        <div class="quest">
                            <i class="fas fa-pencil-alt"></i>
                            <span>{{ count($topic->questions) }} {{ __('translate.question') }}</span>
                        </div>
                        <div class="time">
                            <i class="far fa-clock"></i>
                            <span>{{ __('translate.time_clock', ['time' => config('constants.minute')]) }}</span>
                        </div>
                    </div>
                    @foreach ($topic->users as $user)
                        @if (Auth::check() && Auth::user()->id == $user->pivot->user_id)
                            <i class="fas fa-check-circle text-success"></i>
                            @break
                        @endif
                    @endforeach
                </a>
                <p class="row-space"></p>
            @endforeach
            <div class="row" id="paginate">
                {!! $topics->links() !!}
            </div>
        </div>
        <div class="col-md-4 mt-3 rank">
            <h3 class="text-center font-weight-bold">{{ __('translate.top') }}</h3>
            <div class="card card-cascade narrower">
                <table class="table table-striped table-responsive-md btn-table text-center">
                    <thead class="rank-top">
                        <tr>
                            <th>{{ __('translate.rank') }}</th>
                            <th>{{ __('translate.member') }}</th>
                            <th>{{ __('translate.count_topic') }}</th>
                            <th>{{ __('translate.total_profile') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ranks as $key => $rank)
                            <tr>
                                <th scope="row">{{ $key + config('constants.number_ques') }}</th>
                                <td><img class="avatar" src="{{ config('view.image_paths.images') . $rank['avatar'] }}"> {{ $rank['username'] }}</td>
                                <td>{{ $rank['count'] }}</td>
                                <td>{{ round($rank['total'], config('constants.two')) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#show-search li').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('ul#menu > div li.nav-item').click(function () {
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
                            if (topic.user) {
                                $('#topics').append(
                                    `<a href="` + data.category_slug + `/` + topic.slug + `" class="chip chip-lg light-blue lighten-4 waves-effect">
                                        <div class="calendar">
                                            <div class="year">` + date.year + `</div>
                                            <div class="day">` + date.day + `
                                                <div id="line"></div>
                                            </div>
                                            <div class="month">` + date.month + `</div>
                                        </div>
                                        <div class="div-content">
                                            ` + topic.name + `
                                        </div>
                                        <div class="div-quest">
                                            <div class="quest">
                                                <i class="fas fa-pencil-alt"></i>
                                                <span>` + topic.count + ` {{ __('translate.question') }}` + `</span>
                                            </div>
                                            <div class="time">
                                                <i class="far fa-clock"></i>
                                                <span>{{ __('translate.time_clock', ['time' => config('constants.minute')]) }}</span>
                                            </div>
                                        </div>
                                        <i class="fas fa-check-circle text-success"></i>
                                    </a>
                                    <p class="row-space"></p>`
                                );
                            } else {
                                $('#topics').append(
                                    `<a href="` + data.category_slug + `/` + topic.slug + `" class="chip chip-lg light-blue lighten-4 waves-effect">
                                        <div class="calendar">
                                            <div class="year">` + date.year + `</div>
                                            <div class="day">` + date.day + `
                                                <div id="line"></div>
                                            </div>
                                            <div class="month">` + date.month + `</div>
                                        </div>
                                        <div class="div-content">
                                            ` + topic.name + `
                                        </div>
                                        <div class="div-quest">
                                            <div class="quest">
                                                <i class="fas fa-pencil-alt"></i>
                                                <span>` + topic.count + ` {{ __('translate.question') }}` + `</span>
                                            </div>
                                            <div class="time">
                                                <i class="far fa-clock"></i>
                                                <span>{{ __('translate.time_clock', ['time' => config('constants.minute')]) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                    <p class="row-space"></p>`
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
