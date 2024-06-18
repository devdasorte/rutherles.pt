{{ Form::model(null, ['route' => ['business.growth.view.update', $key], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('business_growth_view_name', __('Business Growth View Name'), ['class' => 'form-label']) }}
                {!! Form::text('business_growth_view_name', $businessGrowthViewSetting['business_growth_view_name'], [
                    'class' => 'form-control',
                    'rows' => '1',
                    'placeholder' => __('Enter business growth name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('business_growth_view_amount', __('Business Growth View Amount'), ['class' => 'form-label']) }}
                {!! Form::text('business_growth_view_amount', $businessGrowthViewSetting['business_growth_view_amount'], [
                    'class' => 'form-control',
                    'rows' => '1',
                    'placeholder' => __('Enter business growth amount'),
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
