<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user"
            src="{{ auth()->user()->avatar ? auth()->user()->avatar->url : asset('assets/images/users/avatar-1.jpg') }}"
            alt="Header Avatar">
        <span class="d-none d-sm-inline-block ml-1">{{ auth()->user()->name }}</span>
        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item d-flex align-items-center justify-content-between"
            href="{{ route('admin.profile-edit') }}" wire:navigate>
            <span>Профиль</span>
            <span>
                <span class="badge badge-pill badge-soft-danger">1</span>
            </span>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
            Настройки
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
            <span>Блокировка экрана</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit"
                class="dropdown-item d-flex align-items-center justify-content-between border-0 bg-transparent">
                <span>Выйти</span>
            </button>
        </form>
    </div>
</div>