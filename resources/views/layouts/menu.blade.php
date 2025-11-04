<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{ route('certificates.index') }}" class="nav-link {{ Request::is('certificates*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-certificate"></i>
            <p>Certificates</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('courses.index') }}" class="nav-link {{ Request::is('courses*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-book"></i>
            <p>Courses</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('events.index') }}" class="nav-link {{ Request::is('events*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Events</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('form-submissions.index') }}" class="nav-link {{ Request::is('form-submissions*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Form Submissions</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('gallery-items.index') }}" class="nav-link {{ Request::is('gallery-items*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-image"></i>
            <p>Gallery Items</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('involvement-submissions.index') }}" class="nav-link {{ Request::is('involvement-submissions*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Involvement Submissions</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('license-classes.index') }}" class="nav-link {{ Request::is('license-classes*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-id-card"></i>
            <p>License Classes</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('resources.index') }}" class="nav-link {{ Request::is('resources*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder"></i>
            <p>Resources</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('trainers.index') }}" class="nav-link {{ Request::is('trainers*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Trainers</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('training-programs.index') }}" class="nav-link {{ Request::is('training-programs*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Training Programs</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('useful-links.index') }}" class="nav-link {{ Request::is('useful-links*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-link"></i>
            <p>Useful Links</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>Users</p>
        </a>
    </li>
    
    <!-- Communication Module -->
    <li class="nav-item has-treeview {{ Request::is('communications*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('communications*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-comments"></i>
            <p>
                Communication
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('communications.email.index') }}" class="nav-link {{ Request::is('communications/email*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Email</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('communications.whatsapp.index') }}" class="nav-link {{ Request::is('communications/whatsapp*') ? 'active' : '' }}">
                    <i class="nav-icon fab fa-whatsapp"></i>
                    <p>WhatsApp</p>
                </a>
            </li>
        </ul>
    </li>
</ul>