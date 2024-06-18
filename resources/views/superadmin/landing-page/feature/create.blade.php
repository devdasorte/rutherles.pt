{!! Form::open([
    'route' => 'feature.store',
    'method' => 'Post',
    'class' => 'form-horizontal',
    'enctype' => 'multipart/form-data',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('feature_name', __('Feature Name'), ['class' => 'form-label']) }}
                {!! Form::text('feature_name', null, [
                    'class' => 'form-control',
                    'rows' => '1',
                    'placeholder' => __('Enter feature name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('feature_bold_name', __('Feature Bold Name'), ['class' => 'form-label']) }}
                {!! Form::text('feature_bold_name', null, [
                    'class' => 'form-control',
                    'rows' => '1',
                    'placeholder' => __('Enter feature Bold name'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('feature_detail', __('Feature Detail'), ['class' => 'form-label']) }}
                {!! Form::textarea('feature_detail', null, [
                    'class' => 'form-control',
                    'rows' => '3',
                    'placeholder' => __('Enter feature detail'),
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('feature_image', __('Image (svg)'), ['class' => 'form-label']) }}
                *
                {!! Form::file('feature_image', ['class' => 'form-control', 'id' => 'feature_image']) !!}
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
