@extends('layouts.main')
@section('title', __('All Permissions'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
    <li class="breadcrumb-item">{{ __('All Permissions') }}</li>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <form class="form-horizontal" method="POST" data-validate action="{{ route('role.permission', $role->id) }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="float-end">
                        </div>
                        <h5>{{ __('All Permissions') }}</h5>
                    </div>
                    <table class="table table-flush permission-table">
                        <thead class="thead-light">
                            <tr>
                                <th width="200px">{{ __('Module') }}</th>
                                <th>{{ __('Permissions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allModules as $row)
                                @if ($row != 'module')
                                    <tr>
                                        <td> {{ __(ucfirst($row)) }}</td>
                                        <td>
                                            <div class="row">
                                                <?php $default_permissions = ['manage', 'create', 'edit', 'delete', 'view', 'impersonate', 'show', 'upload', 'mass-create']; ?>
                                                @foreach ($default_permissions as $permission)
                                                    @if (in_array($permission . '-' . $row, $allPermissions))
                                                        @php($key = array_search($permission . '-' . $row, $allPermissions))
                                                        <div class="col-3 custom-control custom-checkbox">
                                                            {{ Form::checkbox('permissions[]', $key, in_array($permission . '-' . $row, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                            {{ Form::label('permission_' . $key, ucfirst($permission), ['class' => 'form-check-label']) }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            <?php $modules = []; ?>
                            @foreach ($modules as $module)
                                <?php $s_name = $module; ?>
                                <tr>
                                    <td>
                                        {{ __(ucfirst($module)) }}
                                    </td>
                                    <td>
                                        <div class="row">
                                            @if (in_array('manage-' . $module, $allPermissions))
                                                @php($key = array_search('manage-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Manage'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('create-' . $module, $allPermissions))
                                                @php($key = array_search('create-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Create'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('edit-' . $module, $allPermissions))
                                                @php($key = array_search('edit-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Edit'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('delete-' . $module, $allPermissions))
                                                @php($key = array_search('delete-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Delete'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('view-' . $module, $allPermissions))
                                                @php($key = array_search('view-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('View'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('impersonate-' . $module, $allPermissions))
                                                @php($key = array_search('impersonate-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Impersonate'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('upload-' . $module, $allPermissions))
                                                @php($key = array_search('upload-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Upload'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                            @if (in_array('mass-create-' . $module, $allPermissions))
                                                @php($key = array_search('mass-create-' . $module, $allPermissions))
                                                <div class="col-3 custom-control custom-checkbox">
                                                    {{ Form::checkbox('permissions[]', $key, in_array($key, $permissions), ['class' => 'form-check-input', 'id' => 'permission_' . $key]) }}
                                                    {{ Form::label('permission_' . $key, __('Mass Create'), ['class' => 'form-check-label']) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                        @endforeach
                    </table>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
