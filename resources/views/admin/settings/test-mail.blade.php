{!! Form::open([
    'route' => 'test.send.mail',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12 ">
            <label class="form-label" class="form-label" for="email">{{ __('Email') }}</label>
            <input type="text" name="email" class="form-control" placeholder="{{ __('Enter email') }}" required>
            @error('email')
                <span class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::button(__('Send'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
