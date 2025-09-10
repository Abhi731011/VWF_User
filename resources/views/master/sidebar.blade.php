<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="#" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo/logodark.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/Logowithname.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('profile.edit') }}">
                    <iconify-icon icon="solar:user-outline" class="menu-icon"></iconify-icon>
                    <span>My Profile</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('packages.index') }}">
                    <iconify-icon icon="solar:shop-2-outline" class="menu-icon"></iconify-icon>
                    <span>Buy Plans</span>
                </a>
            </li>
            
            <li>
                <a href="{{route('events.index')}}">
                    <iconify-icon icon="solar:clipboard-list-outline" class="menu-icon"></iconify-icon>
                    <span>Events</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.my-registrations') }}">
                    <iconify-icon icon="solar:user-check-outline" class="menu-icon"></iconify-icon>
                    <span>My Registrations</span>
                </a>
            </li>
            
            <li>
               <a href="#">
                    <iconify-icon icon="solar:diploma-verified-outline" class="menu-icon"></iconify-icon>
                    <span>Certificate</span>
                </a>
            </li>
            
            <li>
          <a href="#">
                    <iconify-icon icon="solar:bell-outline" class="menu-icon"></iconify-icon>
                    <span>Announcements</span>
                </a>
            </li>
            
            <li>
              <a href="#">
                    <iconify-icon icon="solar:chat-round-dots-outline" class="menu-icon"></iconify-icon>
                    <span>Support & Feedback</span>
                </a>
            </li>
        </ul>
    </div>
</aside>