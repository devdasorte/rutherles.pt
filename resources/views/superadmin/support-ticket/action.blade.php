@can('edit-support-ticket')
    <a class="btn btn-sm small btn btn-warning" href="{{ route('support-ticket.edit', $supportTicket->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Replay') }}">
        <i class="ti ti-corner-up-left text-white"></i>
    </a>
@endcan
@can('delete-support-ticket')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['support-ticket.destroy', $supportTicket->id],
        'id' => 'delete-form-' . $supportTicket->id,
    ]) !!}
    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
