<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('myPosts') }}" class="nav-link {{ Request::is('myPosts') ? 'active' : '' }}">
        <i class="nav-icon fas fa-solid fa-paste"></i>
        <p>Posts</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('myProfile') }}" class="nav-link {{ Request::is('myProfile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-solid fa-user"></i>
        <p>Profile</p>
    </a>
</li>
