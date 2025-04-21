<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand" style="justify-content: inherit;">
        <!--begin::Brand Link-->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('images/logos/logo.png') }}" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">{{ config('app.name', 'Laravel') }}</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">


                <!-- Masters -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Masters
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/crud/addresses') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Addresses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/crud/items') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Items</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Transactions -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bag-fill"></i>
                        <p>
                            Transactions
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/transaction/SCC') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Solicitud de contratación</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/transaction/AOF') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Asignación de oferente</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- Setup -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            Setup
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ url('/crud/document_types') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Document types</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ url('/crud/next_numbers') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Next Numbers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/crud/subsidiaries') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Subsidiaries</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/udcs/item_type') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>UDC by type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/crud/users') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Centrals -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-highlights"></i>
                        <p>
                            Centrals
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ url('/crud/udcs') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>UDCs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/crud/companies') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Companies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/crud/columns') }}" class="nav-link active">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Columns</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>


        <a href="{{ asset('/dist/pages/index.html') }}" class="nav-item nav-link active mt-5 fs-6">
            <i class="nav-icon bi bi-palette"></i>
            Templates (AdminLTE)
        </a>
    </div>
    <!--end::Sidebar Wrapper-->


</aside>
<!--end::Sidebar-->