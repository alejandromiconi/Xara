@props(['backwhite' => false])


<div class="sidebar-brand" style="justify-content: inherit;">
                <!--begin::Brand Link-->
                <a href="./index.html" class="brand-link">
                    <!--begin::Brand Image-->
                    <img
                        src="{{ asset($backwhite ? 'images/logos/logo.png' : 'images/logos/logo.png') }}"
                        alt="Your Logo"
                        class="brand-image opacity-75" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light">Let's go!</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>