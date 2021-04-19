<ul class="nav navbar-nav navbar-right">
    <!-- Authentication Links -->
    @if (!Auth::guard('web')->guest())
        <li class="{{ active(route('admin.dashboard'))}}">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="{{ active(route('admin.nominees.index'))}}">
            <a href="{{ route('admin.nominees.index') }}">Honoree</a>
        </li>
        <li class="{{ active(route('admin.positions.index'))}}">
            <a href="{{ route('admin.positions.index') }}">Category</a>
        </li>
        <li class="{{active(route('admin.slots.index'))}}">
            <a href="{{ route('admin.slots.index') }}">Slot</a>
        </li>
        <li class="{{active(route('admin.elections.index'))}}">
            <a href="{{ route('admin.elections.index') }}">Session/Year</a>
        </li>
        <li class="{{active(route('admin.results.index'))}}">
            <a href="{{ route('admin.results.index') }}">Vote</a>
        </li>
        <li>
            <a href="{{ route('admin.logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('admin-logout-form').submit();">
                Logout
            </a>

            <form id="admin-logout-form" action="{{ route('admin.logout') }}" 
                method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    @elseif(!Auth::guard('voter')->guest())
        <li>
            <a href="{{ route('front.vote.logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('vote-logout-form').submit();">
                Logout
            </a>

            <form id="vote-logout-form" action="{{ route('front.vote.logout') }}" 
                method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    @else
        <li class="dropdown">
            {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a> --}}

            <ul class="dropdown-menu" role="menu">
                {{-- <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li> --}}
            </ul>
        </li>
    @endif
</ul>
