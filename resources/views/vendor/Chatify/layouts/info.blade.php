{{-- user info and avatar --}}
<div class="avatar av-l">
    <img alt="image" class="rounded-circle mr-1"
        src="{{ file_exists(storage_path() . '/' . Auth::user()->avatar) ? Storage::url(tenant('id') . '/' . Auth::user()->avatar) : Storage::url('avatar/avatar.png') }}">
</div>
<p class="info-name">{{ config('chatify.name') }}</p>
<div class="messenger-infoView-btns">
    <a href="javascript:void(0);" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> {{ __('Delete Conversation') }}</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title">{{ __('shared photos') }}</p>
    <div class="shared-photos-list"></div>
</div>
