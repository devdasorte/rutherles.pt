{!! Form::open([
    'route' => ['footer.main.menu.update' , $footerMainMenuEdit->id],
    'method' => 'Post',
    'class' => 'form-horizontal',
    'data-validate',
]) !!}
<div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('menu', __('Footer Main Menu'), ['class' => 'form-label']) }}
                    {!! Form::text('menu', $footerMainMenuEdit->menu, [
                        'class' => 'form-control',
                        'placeholder' => __('Enter footer main menu'),
                    ]) !!}
                </div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'id' => 'save-btn', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{{ Form::close() }}
