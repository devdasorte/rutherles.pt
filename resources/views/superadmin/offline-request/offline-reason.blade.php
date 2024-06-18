{!! Form::model($requestUser, [
    'route' => ['request.user.disapprove.update', $requestUser->id],
    'method' => 'POST',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('disapprove_reason', __('Disapprove Reason'), ['class' => 'form-label']) }}
        {!! Form::textarea('disapprove_reason', null, [
            'class' => 'form-control',
            'required',
            'placeholder' => __('Enter disapprove reason'),
        ]) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
