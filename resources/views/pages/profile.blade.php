@extends('main')
@section('title', ' Tài khoản')
@section('content')
    <maain class="main">
        <div class="container-fluid">
            <!-- Section: Edit Account -->
            <section class="section">
                {!! Form::model($user, ['route' => ['user.update', $user->name, $user->id], 'method' => 'POST', 'files' => true]) !!}
                    <!-- First row -->
                    <div class="row">
                        <!-- First column -->
                        <div class="col-lg-4 mb-4">
                            <!--Card-->
                            <div class="card card-cascade narrower">
                                <!--Card image-->
                                <div class="view view-cascade gradient-card-header mdb-color lighten-3 avatar">
                                    <h5 class="mb-0 font-weight-bold">{{ trans('translate.avatar') }}</h5>
                                </div>
                                <!--/Card image-->
                                <!-- Card content -->
                                <div class="card-body card-body-cascade text-center">
                                    @if ($user->avatar == null )
                                        <img id="img" class="avatar profile" src="{{ config('filesystems.photos_url') }}" />
                                    @else
                                        <img id="img" class="avatar profile" src="{{ asset('images/' . $user->avatar) }}" />
                                    @endif
                                    <div class="row flex-center upfile">
                                        {!! Form::button(trans('translate.upload'), ['class' => 'btn btn-info btn-rounded btn-sm']) !!}
                                        {!! Form::file('avatar', ['class' => 'upload-file']) !!}
                                        <br>
                                    </div>
                                </div>
                                <!-- /.Card content -->
                            </div>
                            <!--/.Card-->
                            <!--Card-->
                            <div class="card card-cascade narrower">
                                <table class="table table-striped table-responsive-md btn-table">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('translate.numb_topic') }}</th>
                                            <th>{{ trans('translate.topic') }}</th>
                                            <th>{{ trans('translate.total_profile') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->topics as $key => $topic)
                                            <tr>
                                                <th scope="row">{{ $key + config('constants.number_ques') }}</th>
                                                <td>
                                                    <a class="review" href="{{ route('review', [$topic->category->slug, $topic->slug, $topic->pivot->id]) }}">{{ $topic->name }}</a>
                                                </td>
                                               <td>{{ $topic->pivot->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!--/.Card-->
                        </div>
                        <!-- /.First column -->
                        <!-- Second column -->
                        <div class="col-lg-8 mb-4">
                            <!--Card-->
                            <div class="card card-cascade narrower">
                                <!--Card image-->
                                <div class="view view-cascade gradient-card-header mdb-color lighten-3 account">
                                    <h5 class="mb-0 font-weight-bold">{{ trans('translate.info_account') }}</h5>
                                </div>
                                @if(Session::has('success'))
                                 <div class="alert alert-success" role="alert">
                                     <strong>{{Session::get('success')}}</strong>
                                 </div>
                                @endif
                                <!--/Card image-->
                                <!-- Card content -->
                                <div class="card-body card-body-cascade text-center">
                                    <!--First row-->
                                    <div class="row">
                                        <!--First column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                {!! Form::label('email', 'E-mail') !!}
                                                @if ($errors->has('email'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <!--Second column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                                                {!! Form::label('name', trans('translate.username')) !!}
                                                @if ($errors->has('name'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.First row-->
                                    <!--First row-->
                                    <div class="row">
                                        <!--First column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
                                                {!! Form::label('first_name', trans('translate.first_name')) !!}
                                                @if ($errors->has('first_name'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <!--Second column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
                                                {!! Form::label('last_name', trans('translate.last_name')) !!}
                                                @if ($errors->has('last_name'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.First row-->
                                    <!--Second row-->
                                    <div class="row">
                                        <!--First column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::text('phone_number', $user->phone_number, ['class' => 'form-control']) !!}
                                                {!! Form::label('phone_number', trans('translate.phone_number')) !!}
                                                @if ($errors->has('phone_number'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <!--Second column-->
                                        <div class="col-md-6">
                                            <div class="md-form mb-0">
                                                {!! Form::text('address', $user->address, ['class' => 'form-control']) !!}
                                                {!! Form::label('address', trans('translate.address')) !!}
                                                @if ($errors->has('address'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.Second row-->
                                    <div class="row password">
                                        {!! Form::checkbox('change_password', null, null, ['class' => 'form-control change', 'id' => 'change_password']) !!}
                                        {!! Form::label('change_password', trans('translate.change_password')) !!}
                                    </div>
                                    <!--Third row-->
                                    <div class="row">
                                        <!--First column-->
                                        <div class="col-md-12">
                                            <div class="md-form mb-0">
                                                {!! Form::password('password', ['class' => 'form-control password', 'disabled' => 'disabled']) !!}
                                                {!! Form::label('password', trans('translate.password')) !!}
                                                @if ($errors->has('password'))
                                                    <p class="help-block validated" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--First column-->
                                        <div class="col-md-12">
                                            <div class="md-form mb-0">
                                                {!! Form::password('password_confirmation', ['class' => 'form-control password', 'disabled' => 'disabled']) !!}
                                                {!! Form::label('password_confirmation', trans('translate.confirm_password')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.Third row-->
                                    <!-- Fourth row -->
                                    <div class="row">
                                        <div class="col-md-12 text-center my-4">
                                            {!! Form::submit(trans('translate.update_account'), ['class' => 'btn btn-info btn-rounded']) !!}
                                        </div>
                                    </div>
                                    <!-- /.Fourth row -->
                                </div>
                                <!-- /.Card content -->
                            </div>
                            <!--/.Card-->
                        </div>
                        <!-- /.Second column -->
                    </div>
                    <!-- /.First row -->
                {!! Form::close() !!}
            </section>
            <!-- /.Section: Edit Account -->
        </div>
    </main>
@endsection
@section('scripts')
    <script type="text/javascript">
        // Check password
        $(document).ready(function() {
            $('input#change_password').change(function() {
                if ($(this).is(':checked')) {
                    $('.password').removeAttr('disabled');
                } else {
                    $('.password').attr('disabled', '');
                }
            });
        });

        // Avatar
        $(function() {
            $('.upload-file').change(function() {
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#img').attr('src', e.target.result);
                        $('#img').css({
                            'width' : '200px',
                            'height' : '200px',
                        });
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $('#img').attr('src', '{{ asset('images/' . $user->avatar) }}');
                }
            });
        });
    </script>
@endsection
