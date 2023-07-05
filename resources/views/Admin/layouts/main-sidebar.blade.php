<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{route('adminHome')}}">
            <img src="{{asset('assets/admin/images/logo.png')}}" class="header-brand-img light-logo1" alt="logo">
        </a>
        <!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li><h3>العناصر</h3></li>
        <li class="slide">
            <a class="side-menu__item" href="{{route('adminHome')}}">
                <i class="icon icon-home side-menu__icon"></i>
                <span class="side-menu__label">الرئيسية</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{route('admins.index')}}">
                <i class="fe fe-users side-menu__icon"></i>
                <span class="side-menu__label">المشرفين</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-circle side-menu__icon"></i>
                <span class="side-menu__label">الاقسام</span><i class="angle fa fa-angle-left"></i>
            </a>
            <ul class="slide-menu">

                <li><a href="{{ route('categories.index') }}" class="slide-item">الاقسام الرئيسية</a></li>
                <li><a href="{{ route('subcategories.index') }}" class="slide-item">الاقسام الفرعية</a></li>
            </ul>
        </li>

{{--        <li class="slide">--}}
{{--            <a class="side-menu__item" href="{{route('feasibility_study.index')}}">--}}
{{--                <i class="fe fe-book side-menu__icon"></i>--}}
{{--                <span class="side-menu__label">دراسة الجدوي</span>--}}
{{--            </a>--}}
{{--        </li>--}}

{{--        <li class="slide">--}}
{{--            <a class="side-menu__item" href="{{route('feasibility_type.index')}}">--}}
{{--                <i class="fe fe-book side-menu__icon"></i>--}}
{{--                <span class="side-menu__label">نوع دراسة الجدوي</span>--}}
{{--            </a>--}}
{{--        </li>--}}

{{--        <li class="slide">--}}
{{--            <a class="side-menu__item" href="{{route('projects.index')}}">--}}
{{--                <i class="fe fe-package side-menu__icon"></i>--}}
{{--                <span class="side-menu__label">المشاريع</span>--}}
{{--            </a>--}}
{{--        </li>--}}

        <li class="slide">
            <a class="side-menu__item" href="{{route('posts.index')}}">
                <i class="fe fe-hash side-menu__icon"></i>
                <span class="side-menu__label">المنشورات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('services.index')}}">
                <i class="fe fe-hash side-menu__icon"></i>
                <span class="side-menu__label">طلب خدمة</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('reports_index')}}">
                <i class="fe fe-alert-triangle side-menu__icon"></i>
                <span class="side-menu__label">البلاغات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('contact_us.index')}}">
                <i class="fe fe-message-circle side-menu__icon"></i>
                <span class="side-menu__label">الرسائل</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-user side-menu__icon"></i>
                <span class="side-menu__label">المستخدمين</span><i class="angle fa fa-angle-left"></i>
            </a>
            <ul class="slide-menu">

                <li><a href="{{ route('users_client') }}" class="slide-item"> العملاء</a></li>
                <li><a href="{{ route('users_freelancer') }}" class="slide-item">مقدم خدمة</a></li>

            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-settings side-menu__icon"></i>
                <span class="side-menu__label">الاعدادات</span><i class="angle fa fa-angle-left"></i>
            </a>
            <ul class="slide-menu">

                <li><a href="{{ route('setting.about') }}" class="slide-item"> من نحن</a></li>
                <li><a href="{{ route('setting.terms') }}" class="slide-item">الشروط و الاحكام</a></li>
                <li><a href="{{ route('setting.privacy') }}" class="slide-item">الخصوصية</a></li>

            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('admin.logout')}}">
                <i class="icon icon-lock side-menu__icon"></i>
                <span class="side-menu__label">تسجيل الخروج</span>
            </a>
        </li>

    </ul>
</aside>
