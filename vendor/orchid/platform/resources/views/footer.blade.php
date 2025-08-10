@guest
    <div class="m-4 text-muted text-center">
        Admin Management
    </div>

    <p class="mb-1 px-5 text-center small">
        {{ __('Copyright') }}  - {{date('Y')}}
    </p>


@else

    <div class="d-lg-block my-4 text-center user-select-none d-none">
        <p class="mb-0 small">

            {{ __('Copyright') }} {{date('Y')}}<br>
            {{-- <a href="http://orchid.software" target="_blank" rel="noopener">
                {{ __('Version') }}: {{\Orchid\Platform\Dashboard::version()}}
            </a> --}}
        </p>
    </div>
@endguest
