<div class="navbar-custom-menu">
<ul class="nav navbar-nav">

<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    @foreach(App\Role::All() as $role)
    @if(Auth::user()->hasRole($role->slug)),
    {{$role->name}}
    @endif
@endforeach

{!!": <strong>".Auth::user()->first_name."</i></strong>"!!} <i class="fa fa-caret-down"></i>
</a>
<ul class="dropdown-menu">
    <li class="user-footer" style="background-color: #3C8DBC;">
        <div class="">
        </div>
        <div class="">
            <a href="{{ url('/change-password') }}" style="color:white;"><i class="fa fa-gear fa-fw"></i> Change Password</a>
        </div>
        <div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" style="color:white;">
                <i class="fa fa-sign-out fa-fw"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            </form>

        </div>
    </li>
</ul>
</li>
</ul>
</div>
