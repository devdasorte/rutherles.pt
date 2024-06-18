{{-- -------------------- Saved Messages -------------------- --}}
@if ($get == 'saved')
    <table class="messenger-list-item m-li-divider @if ('user_' . Auth::user()->id == $id && $id != '0') m-list-active @endif">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="avatar av-m avtar-div">
                    <span class="far fa-bookmark avr-side"></span>
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ 'user_' . Auth::user()->id }}">{{ __('Saved Messages') }} <span>{{ __('You') }}</span></p>
                <span>{{ __('Save messages secretly') }}</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- All users/group list -------------------- --}}
@if ($get == 'users')
    <table class="messenger-list-item @if ($user->id == $id && $id != '0') m-list-active @endif" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td class="msg-list">
                @if ($user->active_status)
                    <span class="activeStatus"></span>
                @endif



                @if (tenant('id') == null)
                    <div class="avatar av-m"
                        style="background-image: url('{{ $user->avatar ? Storage::url($user->avatar) : Storage::url('avatar/avatar.png') }}');">
                    </div>

                @else
                    @if (config('filesystems.default') == 'local')

                        <div class="avatar av-m"
                            style="background-image: url('{{ file_exists(storage_path() . '/' . $user->avatar)? Storage::url(tenant('id') . '/' . $user->avatar): Storage::url('avatar/avatar.png') }}');">
                        </div>

                    @else
                        <div class="avatar av-m"
                            style="background-image: url('{{ $user->avatar ? Storage::url($user->avatar) : Storage::url('avatar/avatar.png') }}');">
                        </div>

                    @endif
                @endif


            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $type . '_' . $user->id }}">
                    {{ strlen($user->name) > 12 ? trim(substr($user->name, 0, 12)) . '..' : $user->name }}
                    <span>{{ $lastMessage->created_at->diffForHumans() }}</span>
                </p>
                <span>
                    {{-- Last Message user indicator --}}
                    {!! $lastMessage->from_id == Auth::user()->id ? '<span class="lastMessageIndicator">You :</span>' : '' !!}
                    {{-- Last message body --}}
                    @if ($lastMessage->attachment == null)
                        {{ strlen($lastMessage->body) > 30 ? trim(substr($lastMessage->body, 0, 30)) . '..' : $lastMessage->body }}
                    @else
                        <span class="fas fa-file"></span> {{ __('Attachment') }}
                    @endif
                </span>
                {{-- New messages counter --}}
                {!! $unseenCounter > 0 ? '<b>' . $unseenCounter . '</b>' : '' !!}
            </td>

        </tr>
    </table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if ($get == 'search_item')
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="avatar av-m"
                    style="background-image: url('{{ asset('/storage/' . config('chatify.user_avatar.folder') . '/' . $user->avatar) }}');">
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $type . '_' . $user->id }}">
                    {{ strlen($user->name) > 12 ? trim(substr($user->name, 0, 12)) . '..' : $user->name }}
            </td>

        </tr>
    </table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if ($get == 'sharedPhoto')
    <div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif
