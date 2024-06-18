@if ($offlinerequest->is_approved == 0)
    <a class="btn btn-sm small btn btn-success" href="{{ route('offline.request.status', $offlinerequest->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Approved') }}">
        <i class="ti ti-access-point text-white"></i>
    </a>
    <a class="btn btn-sm small btn btn-danger reason" href="javascript:void(0)"
        data-url="{{ route('offline.disapprove.status', $offlinerequest->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Disapproved') }}">
        <i class="ti ti-access-point-off text-white"></i>
    </a>
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['offline.destroy', $offlinerequest->id],
        'id' => 'delete-form-' . $offlinerequest->id,
    ]) !!}
    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endif
