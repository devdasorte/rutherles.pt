{{-- ---------------------- Image modal box ---------------------- --}}
<div id="imageModalBox" class="imageModal">
    <span class="imageModal-close">&times;</span>
    <img class="imageModal-content" id="imageModalBoxSrc">
</div>

{{-- ---------------------- Delete Modal ---------------------- --}}
<div class="app-modal" data-name="delete">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="delete" data-modal='0'>
            <div class="app-modal-header">{{ __('Are you sure you want to delete this?') }}</div>
            <div class="app-modal-body">{{ __('You can not undo this action') }}</div>
            <div class="app-modal-footer">
                <a href="javascript:void(0)" class="app-btn cancel">{{ __('Cancel') }}</a>
                <a href="javascript:void(0)" class="app-btn a-btn-danger delete">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
{{-- ---------------------- Alert Modal ---------------------- --}}
<div class="app-modal" data-name="alert">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="alert" data-modal='0'>
            <div class="app-modal-header"></div>
            <div class="app-modal-body"></div>
            <div class="app-modal-footer">
                <a href="javascript:void(0)" class="app-btn cancel">{{ __('Cancel') }}</a>
            </div>
        </div>
    </div>
</div>
{{-- ---------------------- Settings Modal ---------------------- --}}
<div class="app-modal" data-name="settings">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="settings" data-modal='0'>
            <form id="update-settings" action="{{ route('avatar.update') }}" enctype="multipart/form-data"
                method="POST">
                @csrf
                <div class="app-modal-header">{{ __('Update your theme') }}</div>
                <div class="app-modal-body">

                    {{-- Dark/Light Mode --}}
                    <p class="divider"></p>
                    <p class="app-modal-header">{{ __('Dark Mode') }} <span
                            class="
                        {{ Auth::user()->dark_mode > 0 ? 'fas' : 'far' }} fa-moon dark-mode-switch"
                            data-mode="{{ Auth::user()->dark_mode > 0 ? 1 : 0 }}"></span></p>
                    {{-- change messenger color --}}
                    
                    <p class="divider"></p>
                    <p class="app-modal-header">{{ _('Change') }} {{ config('chatify.name') }} {{ __('Color') }}</p>
                    <div class="update-messengerColor">
                        <span class="messengerColor-1 color-btn"></span>
                        <span class="messengerColor-2 color-btn"></span>
                        <span class="messengerColor-3 color-btn"></span>
                        <span class="messengerColor-4 color-btn"></span>
                        <span class="messengerColor-5 color-btn"></span>
                        <br />
                        <span class="messengerColor-6 color-btn"></span>
                        <span class="messengerColor-7 color-btn"></span>
                        <span class="messengerColor-8 color-btn"></span>
                        <span class="messengerColor-9 color-btn"></span>
                        <span class="messengerColor-10 color-btn"></span>
                    </div>
                </div>
                <div class="app-modal-footer">
                    <a href="javascript:void(0)" class="app-btn cancel">{{ __('Cancel') }}</a>
                    <input type="submit" class="app-btn a-btn-success update" value="Update" />
                </div>
            </form>
        </div>
    </div>
</div>
