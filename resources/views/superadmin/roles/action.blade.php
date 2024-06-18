@can('show-role')
    <a class="btn btn-sm small btn btn-info" href="{{ route('roles.show', $role->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Permission') }}">
        <i class="ti ti-key text-white"></i>
    </a>
@endcan
