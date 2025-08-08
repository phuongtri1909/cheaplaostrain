@include('layouts.partials.header')

<div class="mt-90">
    @push('scripts')
    @endpush
    @include('components.toast')
    @include('components.toast-main')
    
    @yield('content')
    @include('components.top_button')
</div>

@include('layouts.partials.footer')
