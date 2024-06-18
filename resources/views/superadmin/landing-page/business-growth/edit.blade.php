{{ Form::model(null, ['route' => ['business.growth.update', $key], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('business_growth_title', __('Business Growth Title'), ['class' => 'form-label']) }}
                {!! Form::text('business_growth_title', $businessGrowthSetting['business_growth_title'], [
                    'class' => 'form-control',
                    'rows' => '1',
                    'placeholder' => __('Enter business growth title'),
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
