<a href="{{ route('telescope', 'requests') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'requests' ? 'active' : '' }}">
    {{ __('Requests') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'commands') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'commands' ? 'active' : '' }}">
    {{ __('Commands') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'schedule') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'schedule' ? 'active' : '' }}">
    {{ __('Schedule') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'jobs') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'jobs' ? 'active' : '' }}">
    {{ __('Jobs') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'batches') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'batches' ? 'active' : '' }}">
    {{ __('Batches') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'cache') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'cache' ? 'active' : '' }}">
    {{ __('Cache') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'dumps') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'dumps' ? 'active' : '' }}">
    {{ __('Dumps') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'events') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'events' ? 'active' : '' }}">
    {{ __('Events') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'exceptions') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'exceptions' ? 'active' : '' }}">
    {{ __('Exceptions') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'gates') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'gates' ? 'active' : '' }}">
    {{ __('Gates') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'client-requests') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'client-requests' ? 'active' : '' }}">
    {{ __('HTTP Client') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'logs') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'logs' ? 'active' : '' }}">
    {{ __('Logs') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'mail') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'mail' ? 'active' : '' }}">
    {{ __('Mail') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'models') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'models' ? 'active' : '' }}">
    {{ __('Models') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'notifications') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'notifications' ? 'active' : '' }}">
    {{ __('Notifications') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'queries') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'queries' ? 'active' : '' }}">
    {{ __('Queries') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'redis') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'redis' ? 'active' : '' }}">
    {{ __('Redis') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="{{ route('telescope', 'views') }}"
    class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'telescope' && Request::segment(2) == 'views' ? 'active' : '' }}">
    {{ __('Views') }}
    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>
