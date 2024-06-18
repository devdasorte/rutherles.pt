{!! Form::open([
    'route' => 'business.growth.view.store',
    'method' => 'Post',
    'class' => 'form-horizontal',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('business_growth_view_name', __('Business Growth View Name'), ['class' => 'form-label']) }}
                {!! Form::text('business_growth_view_name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Enter business growth view name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('business_growth_view_amount', __('Business Growth View Amount'), ['class' => 'form-label']) }}
                {!! Form::text('business_growth_view_amount', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Enter business growth view name'),
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
