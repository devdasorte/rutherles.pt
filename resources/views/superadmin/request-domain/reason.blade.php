{!! Form::model($requestDomain, [
    'route' => ['status.update', $requestDomain->id],
    'method' => 'post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group ">
        {{ Form::label('reason', __('Disapprove Reason'), ['class' => 'form-label']) }}
        {!! Form::textarea('reason', null, [
            'class' => 'form-control',
            ' required',
            'placeholder' => __('Enter reason'),
        ]) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
