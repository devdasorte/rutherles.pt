@can('edit-email-template')
    <a class="btn btn-sm small btn-warning" href="{{ route('email-template.edit', $row->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="text-white ti ti-edit"></i>
    </a>
@endcan
