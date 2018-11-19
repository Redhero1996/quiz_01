@extends('main')
@section('title', '| ' . __('translate.create_topic'))
@section('content')
    <div class="form-group quiz">
        <div class="form-group">
            <h3 id="title-quiz">{!! __('translate.create_topic') !!} </h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $err)
                        {{ $err }}<br>
                    @endforeach
                </div>
            @endif
            {!! Form::open(['route' => 'create-topics.store', 'method' => 'POST', 'class' => 'form-horizontal created']) !!}
                <div class="form-body">
                    <div class="form-group">
                        {!! Form::label('category_id', __('translate.category'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => 'browser-default custom-select']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('topic_id', __('translate.topic'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::text('topic_name', old('topic_name'), ['class' => 'form-control input-circle', 'placeholder' => 'Enter name of topic']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('number_quest', __('translate.question_num'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="row ml-1">
                            <div class="col-md-3">
                                {!! Form::text('number_quest', config('constants.zero'), ['class' => 'form-control input-circle', 'required' => 'required']) !!}
                            </div>
                            <div class="col-md-3 pt-2">
                                <span class="text-success add-quest"><i class="fas fa-plus-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body question-form">
                    </div>
                    <div class="col-md-3 addQuest">
                        <span class="btn btn-primary btn-sm addQuest"><i class="fas fa-plus"></i>{{ __('translate.add') }}</span>
                    </div>
                </div>
                <div class="form-actions pl-2">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            {!! Form::submit(__('translate.send'), ['class' => 'btn btn-info', 'disabled' => true]) !!}
                            <a href="{{ route('create-topics.index', Auth::user()->id) }}" class="btn btn-light submit">
                                {{ __('translate.cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('bower_components/ckeditor5-build-classic/build/ckeditor.js') !!}
    {!! Html::script('bower_components/jquery-validation/dist/jquery.validate.min.js') !!}
    <script type="text/javascript">
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
          ClassicEditor.create(allEditors[i]);
        }
        $(document).ready(function() {
            $('div.addQuest').hide();
            var alphabet = @json($alphabet);
            $('span.add-quest').click(function() { 
                // prevent when reload page
                window.onbeforeunload = function() {
                    return '{{ __('translate.alert') }}';
                }
                var number_quest = parseInt($('input#number_quest').val()); 
                if (number_quest <= 0) {
                    alert('{{ __('translate.input_numb') }}');
                }
                else {
                    $('input[type=submit]').prop('disabled', false);
                    $(this).hide();
                    // $('input#number_quest').prop('disabled', true);
                    $('div.addQuest').show();
                    checkAdd(number_quest);                 
                    $('button.close').click(function() {
                        number_quest -= 1;
                        $('input#number_quest').val(number_quest);
                    });
                }
                $('div.addQuest').click(function() {
                    number_quest += 1;
                    $('input#number_quest').val(number_quest);
                    $('div.question-form').append(`
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                </button>
                                <div class="form-group">
                                    <label for="question" class="col-md-3 control-label question">Câu hỏi ` + number_quest +`</label>
                                    <div class="col-md-12">
                                        <textarea class="editor" name="content[`+ number_quest +`]" cols="94" id="content" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <input type="checkbox" name="correct_ans[`+ i +`][]" value="0">
                                    <label>Đáp án A:</label>
                                    <input type="text" name="answer[`+ number_quest +`][]" class="form-control" value="" required>
                                </div>
                                <div class="form-group ml-3">
                                     <input type="checkbox" name="correct_ans[`+ number_quest +`][]" value="1">
                                     <label>Đáp án B:</label>
                                    <input type="text" name="answer[`+ number_quest +`][]" class="form-control" value="" required>
                                </div>
                                <div class="form-group ml-3">
                                     <input type="checkbox" name="correct_ans[`+ number_quest +`][]" value="2">
                                     <label>Đáp án C:</label>
                                    <input type="text" name="answer[`+ number_quest +`][]" class="form-control" value="" required>
                                </div>
                                <div class="form-group ml-3">
                                    <input type="checkbox" name="correct_ans[`+ number_quest +`][]" value="3">
                                    <label>Đáp án D:</label>
                                    <input type="text" name="answer[`+ number_quest +`][]" class="form-control" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="explain" class="ml-3">Explain</label>
                                    <div class="col-md-12">
                                        <textarea class="editor" name="explain[`+ number_quest +`][]" cols="94" id="explain"></textarea>
                                    </div>
                                </div>
                            </div>
                    `);
                });
            });
            $('input[type=submit]').click(function() {
                window.onbeforeunload = function() {
                    return null;
                };
            });   
        });
        function checkAdd(valueAdd) {
            for (i = 1; i <= valueAdd; i++) {
                $('div.question-form').append(`
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" data-id="close_`+i+`">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                            <div class="form-group">
                                <label for="question" class="col-md-3 control-label question">Câu hỏi <span class="number_label">` + i +`</span></label>
                                <div class="col-md-12">
                                    <textarea class="editor" name="content[`+ i +`]" cols="94" id="content" required></textarea>
                                </div>
                            </div>
                            <div class="form-group ml-3">
                                <input type="checkbox" name="correct_ans[`+ i +`][]" value="0">
                                <label>Đáp án A:</label>
                                <input type="text" name="answer[`+ i +`][]" class="form-control" value="" required>
                            </div>
                            <div class="form-group ml-3">
                                 <input type="checkbox" name="correct_ans[`+ i +`][]" value="1">
                                 <label>Đáp án B:</label>
                                <input type="text" name="answer[`+ i +`][]" class="form-control" value="" required>
                            </div>
                            <div class="form-group ml-3">
                                 <input type="checkbox" name="correct_ans[`+ i +`][]" value="2">
                                 <label>Đáp án C:</label>
                                <input type="text" name="answer[`+ i +`][]" class="form-control" value="" required>
                            </div>
                            <div class="form-group ml-3">
                                <input type="checkbox" name="correct_ans[`+ i +`][]" value="3">
                                <label>Đáp án D:</label>
                                <input type="text" name="answer[`+ i +`][]" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="explain" class="ml-3">Explain</label>
                                <div class="col-md-12">
                                    <textarea class="editor" name="explain[`+ i +`][]" cols="94" id="explain"></textarea>
                                </div>
                            </div>
                        </div>
                `);
            }
        }
    </script>
@endsection
