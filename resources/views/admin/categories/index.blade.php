@extends('master')
@section('title', '| ' . __('translate.all_categories'))
@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="page-title">{{ __('translate.manage_categories') }}</h3>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success'))
                        <div class="portlet-title">
                            <div class="alert alert-success">
                                {!! Session::get('success') !!}
                            </div>
                        </div>
                    @endif
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue-hoki">
                        <div class="portlet-title">
                            <div class="caption mb-2">
                                <i class="fa fa-globe"></i>{{ __('translate.all_categories') }}
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">{{ __('translate.id') }}<i class="fa fa-sort float-right" aria-hidden="true"></i></th>
                                <th class="th-sm">{{ __('translate.name') }}<i class="fa fa-sort float-right" aria-hidden="true"></i></th>
                                <th class="th-sm">{{ __('translate.slug') }}<i class="fa fa-sort float-right" aria-hidden="true"></i></th>
                                <th class="th-sm">{{ __('translate.edit') }}<i class="fa fa-sort float-right" aria-hidden="true"></i></th>
                                <th class="th-sm">{{ __('translate.delete') }}<i class="fa fa-sort float-right" aria-hidden="true"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach( $categories as $category )
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td><a class="edit" href="{{ route('categories.edit', $category->id) }}">
                                        <i class="fa fa-edit"></i> {{ __('translate.edit') }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="delete" data-toggle="modal" href="#delete-{{$category->id}}">
                                        <i class="fa fa-trash"></i> {{ __('translate.delete') }}
                                        </a>
                                        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                                        <div class="modal fade" id="delete-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                        {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="btn btn-danger mb-1">{{ __('translate.delete') }}</button>
                                                        {!! Form::close() !!}
                                                        <button type="button" class="btn btn-light" data-dismiss="modal" >{{ __('translate.close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
@endsection
