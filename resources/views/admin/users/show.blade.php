@extends('master')

@section('title', '| ' . __('translate.info_account'))

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="page-header"> 
                        {{ __('translate.info_account') }}
                    </h2>

                </div>
                <!-- /.col-lg-12 -->
                <div class="col-md-8 col-md-offset-2">
                    
                    <!-- Success -->
                   @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('success') }}</strong> 
                    </div>
                   @endif
                  
                    <div class="form-group">
                        <label>{{ __('translate.avatar') }}</label><br>
                        @if ($user->avatar == null )
                            <img id="img" class="avatar profile" src="{{ config('view.image_paths.images') . 'avatar-default-icon.png' }}" />
                        @else
                            <img id="img" class="avatar profile" src="{{ config('view.image_paths.images') . $user->avatar }}" />
                        @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('name', __('translate.username')) !!}
                        {!! Form::text('name', $user->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('first_name', __('translate.first_name')) !!}
                        {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', __('translate.last_name')) !!}
                        {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone_number', __('translate.phone_number')) !!}
                        {!! Form::text('phone_number', $user->phone_number, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', __('translate.address')) !!}
                            {!! Form::text('address', $user->address, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail') !!}
                        {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary btn-block">{{ __('translate.edit') }}</a>
                        </div>
                        <div class="col-sm-6">      
                             <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-{{ $user->id }}">{{ __('translate.delete') }}</a>

                        </div>
                        <!-- Delete Confirmation Modal (place it right below the button) -->
                        <div class="modal fade" id="delete-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">{{ __('translate.del_confirm') }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h5>{{ __('translate.del_alert') }}</h5>
                                    </div>
                                    <div class="modal-footer">
                                        
                                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'style' => 'width: 500px; float:left;']) !!}
                                        <button type="submit" class="btn btn-danger" style="margin-bottom: 5px;">{{ __('translate.delete') }}</button>
                                        {!! Form::close() !!}

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >{{ __('translate.close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!--At the end -->
                    </div><br>
                        
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
