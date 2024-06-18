@if ($requestdomain->is_approved == 0)
    <a class="btn btn-sm small btn btn-success" href="{{ route('request.domain.approve.status', $requestdomain->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Approved') }}"
        aria-label="{{ __('Approved') }}">
        <i class="ti ti-access-point text-white"></i>
    </a>
    <a class="btn btn-sm small btn btn-danger reason" data-url="/request-domain/disapprove/{{ $requestdomain->id }}"
        href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Disapproved') }}">
        <i class="ti ti-access-point text-white"></i>
    </a>
    @can('edit-domain-request')
        <a class="btn btn-sm small btn btn-warning" href="{{ route('request.domain.edit', $requestdomain->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
            <i class="ti ti-edit text-white"></i>
        </a>
    @endcan
    @can('delete-domain-request')
        {!! Form::open([
            'method' => 'DELETE',
            'class' => 'd-inline',
            'route' => ['request.domain.delete', $requestdomain->id],
            'id' => 'delete-form-' . $requestdomain->id,
        ]) !!}
        <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
            data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
            <i class="ti ti-trash text-white"></i>
        </a>
        {!! Form::close() !!}
    @endcan
@endif
