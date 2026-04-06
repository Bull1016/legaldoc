<!-- BEGIN: Vendor JS-->

@vite(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/popper/popper.js', 'resources/assets/vendor/js/bootstrap.js', 'resources/assets/vendor/libs/node-waves/node-waves.js', 'resources/assets/vendor/libs/@algolia/autocomplete-js.js'])

@if ($configData['hasCustomizer'])
    @vite('resources/assets/vendor/libs/pickr/pickr.js')
@endif

@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', 'resources/assets/vendor/libs/hammer/hammer.js', 'resources/assets/vendor/js/menu.js'])

@vite(['resources/assets/vendor/libs/notyf/notyf.js'])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Notyf !== 'undefined') {
            window.notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top',
                },
                ripple: true,
                dismissible: true,
                types: [{
                        type: 'info',
                        background: '#3498db',
                        icon: {
                            className: 'ti tabler-info-octagon',
                        },
                    },
                    {
                        type: 'warning',
                        background: '#f1c40f',
                        icon: {
                            className: 'ti tabler-alert-square-rounded',
                        },
                    },
                ]
            });

            @if (session('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                notyf.error("{{ session('error') }}");
            @endif

            @if (session('info'))
                notyf.info("{{ session('info') }}");
            @endif

            @if (session('warning'))
                notyf.warning("{{ session('warning') }}");
            @endif
        } else {
            console.error('⚠️ Notyf n\'est pas encore chargé.');
        }
    });
</script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/main.js'])
<!-- END: Theme JS-->

<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- app JS -->
@vite(['resources/js/app.js'])
<!-- END: app JS-->
