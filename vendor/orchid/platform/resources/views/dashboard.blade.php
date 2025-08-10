@extends(config('platform.workspace', 'platform::workspace.compact'))

@section('aside')
    <div class="d-flex flex-column bg-dark aside col-xs-12 col-xxl-2" data-controller="menu" data-bs-theme="dark">
        <header class="d-xl-block d-flex align-items-center mt-xl-4 p-3 w-100">
            <a href="#" class="d-flex align-items-center order-first me-auto header-toggler d-xl-none lh-1 link-body-emphasis"
               data-action="click->menu#toggle">
                <x-orchid-icon path="bs.three-dots-vertical" class="icon-menu"/>

                <span class="ms-2">@yield('title')</span>
            </a>

            <a class="order-last header-brand link-body-emphasis" href="{{ route(config('platform.index')) }}">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>
        </header>

        <nav class="aside-collapse collapse-horizontal d-xl-flex flex-column w-100 text-body-emphasis" id="headerMenuCollapse">

            @include('platform::partials.search')

            <ul class="flex-column gap-1 mb-auto mb-md-1 ps-0 nav nav-pills">
                {!! Dashboard::renderMenu() !!}
            </ul>

            <div class="to-top position-relative d-md-flex mt-md-5 w-100 h-100 cursor d-none"
                 data-action="click->html-load#goToTop"
                 title="{{ __('Scroll to top') }}">
                <div class="bottom-left mb-2 ps-3 w-100 overflow-hidden">
                    <small data-controller="viewport-entrance-toggle"
                           class="d-flex align-items-center gap-3 scroll-to-top"
                           data-viewport-entrance-toggle-class="show">
                        <x-orchid-icon path="bs.chevron-up"/>
                        {{ __('Scroll to top') }}
                    </small>
                </div>
            </div>

            <footer class="bottom-0 position-sticky">
                <div class="position-relative bg-dark overflow-hidden" style="padding-bottom: 10px;">
                    @includeWhen(Auth::check(), 'platform::partials.profile')
                </div>
            </footer>
        </nav>
    </div>
@endsection

@section('workspace')
    @if(Breadcrumbs::has())
        <nav aria-label="breadcrumb">
            <ol class="mb-2 px-4 breadcrumb">
                <x-tabuna-breadcrumbs
                    class="breadcrumb-item"
                    active="active"
                />
            </ol>
        </nav>
    @endif

    <div class="order-last order-md-0 command-bar-wrapper">
        <div class="@hasSection('navbar') @else d-none d-md-block @endif layout d-md-flex align-items-center">
            <header class="d-md-block me-3 p-0 d-none col-xs-12 col-md">
                <h1 class="m-0 text-body-emphasis fw-light h3">@yield('title')</h1>
                <small class="text-muted" title="@yield('description')">@yield('description')</small>
            </header>
            <nav class="ms-md-auto p-0 col-xs-12 col-md-auto">
                <ul class="d-flex flex-wrap-reverse flex-sm-nowrap justify-content-sm-end align-items-center justify-content-start gap-2 nav command-bar">
                    @yield('navbar')
                </ul>
            </nav>
        </div>
    </div>

    @include('platform::partials.alert')
    @yield('content')
@endsection
