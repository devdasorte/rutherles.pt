@can('impersonate-user')
    <a class="btn btn-sm small btn btn-info" target="_new" href="{{ route('users.impersonate', $user->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Impersonate') }}">
        <i class="ti ti-new-section text-white"></i>
    </a>
@endcan
@can('edit-user')
    <a class="btn btn-sm small btn btn-warning" href="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-user')
    {!! Form::open([
        'method'    => 'DELETE',
        'class'     => 'd-inline',
        'route'     => ['users.destroy', $user->id],
        'id'        => 'delete-form-' . $user->id,
    ]) !!}
    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
