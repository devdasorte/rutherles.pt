{!! Form::open([
    'route' => 'coupon.upload.store',
    'method' => 'Post',
    'class' => 'form-horizontal',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 form-group">
            <a href="{{ Storage::url('coupon/coupon.csv') }}" class="btn btn-primary btn-sm"><i class="ti ti-download"></i>
                {{ __('Sample File') }}</a>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('file', __('CSV Upload'), ['class' => 'form-label']) }}
            {!! Form::file('file', [
                'class' => 'form-control font-style',
                'placeholder' => __('CSV upload'),
                'required' => 'required',
            ]) !!}
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
