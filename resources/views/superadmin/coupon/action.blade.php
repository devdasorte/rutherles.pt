@can('show-coupon')
    <a class="btn btn-sm small btn btn-info" href="{{ route('coupons.show', ['id' => $coupon->id]) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Show') }}">
        <i class="ti ti-eye text-white"></i>
    </a>
@endcan
@can('edit-coupon')
    <a class="btn btn-sm small btn btn-warning" href="{{ route('coupon.edit', $coupon->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-coupon')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['coupon.destroy', $coupon->id],
        'id' => 'delete-form-' . $coupon->id,
    ]) !!}
    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
