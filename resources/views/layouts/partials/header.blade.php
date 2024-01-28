<div class="navbar-top" style="backgroundColor:#2c6140;color:white ">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        @if (setting('site_logo') != null)
            <a class="navbar-brand brand-logo" href="#">
                <img src="{{ Storage::url(setting('site_logo')) }}" alt="logo">
            </a>
            <a class="navbar-brand brand-logo-mini" href="#">
                <img src="{{ Storage::url(setting('site_logo')) }}" alt="logo">
            </a>
        @else
            {{ setting('site_title') }} <br>
            {{ Auth::user()->station->name ?? '' }}
        @endif
    </div>
    <div class="navbar-menu-wrapper d-flex flex-grow ">
        <ul class="navbar-nav navbar-nav-left collapse navbar-collapse" id="horizontal-top-example">
            @role('admin')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}"> Dashboard </a>
                </li>

                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('admin/manufactures*') ? 'active' : '' }}"
                        href="{{ route('admin.manufactures.index') }}"> Manufactures </a>
                </li>

                {{-- <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('admin/stations*') ? 'active' : '' }}"
                        href="{{ route('admin.stations.index') }}"> Stations </a>
                </li> --}}

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Instruments </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                            href="{{ route('admin.instrument-types.index') }}"> Types </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('admin/instruments*') ? 'active' : '' }}"
                            href="{{ route('admin.instruments.index') }}">All Instruments</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/part*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Parts </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Request::is('admin/part-types*') ? 'active' : '' }}"
                            href="{{ route('admin.part-types.index') }}"> Types </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/parts*') ? 'active' : '' }}"
                            href="{{ route('admin.parts.index') }}">All Parts</a>
                    </div>
                </li>

                {{-- <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/roles*') || Request::is('admin/users*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> System </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/roles*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            <i class="mdi mdi-account-group mr-2 text-success"></i> Roles </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/users*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="mdi mdi-account-circle mr-2 text-info"></i> Users </a>
                    </div>
                </li> --}}

                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown" style="color:#a5a5a5">
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('admin.stock.instruments.index') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('admin.stock.parts.index') }}"> Parts </a>
                    </div>
                </li>

                {{-- <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/settings*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Settings </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.general') ? 'active' : '' }}"
                            href="{{ route('admin.settings.index') }}">
                            <i class="mdi mdi-settings mr-2 text-success"></i> General </a>

                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.appearance.index') ? 'active' : '' }}"
                            href="{{ route('admin.settings.appearance.index') }}">
                            <i class="mdi mdi-looks mr-2 text-info"></i> Appearance </a>

                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.mail.index') ? 'active' : '' }}"
                            href="{{ route('admin.settings.mail.index') }}">
                            <i class="mdi mdi-mailbox mr-2 text-info"></i> Mail </a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> National Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('national_stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('share.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('national_stock/parts*') ? 'active' : '' }}"
                            href="{{ route('share.parts') }}"> Parts </a>
                    </div>
                </li> --}}
            @endrole
            @role('central-admin')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}"> Dashboard </a>
                </li>

                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('admin/manufactures*') ? 'active' : '' }}"
                        href="{{ route('admin.manufactures.index') }}"> Manufactures </a>
                </li>

                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('admin/stations*') ? 'active' : '' }}"
                        href="{{ route('admin.stations.index') }}"> Stations </a>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Instruments </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                            href="{{ route('admin.instrument-types.index') }}"> Types </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('admin/instruments*') ? 'active' : '' }}"
                            href="{{ route('admin.instruments.index') }}">All Instruments</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/part*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Parts </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Request::is('admin/part-types*') ? 'active' : '' }}"
                            href="{{ route('admin.part-types.index') }}"> Types </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/parts*') ? 'active' : '' }}"
                            href="{{ route('admin.parts.index') }}">All Parts</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/roles*') || Request::is('admin/users*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> System </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/roles*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            <i class="mdi mdi-account-group mr-2 text-success"></i> Roles </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/users*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="mdi mdi-account-circle mr-2 text-info"></i> Users </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown" style="color:#a5a5a5">
                        <a style="color:#a5a5a5"
                            class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('admin.stock.instruments.index') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5" class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('admin.stock.parts.index') }}"> Parts </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('admin/settings*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Settings </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.general') ? 'active' : '' }}"
                            href="{{ route('admin.settings.index') }}">
                            <i class="mdi mdi-settings mr-2 text-success"></i> General </a>

                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.appearance.index') ? 'active' : '' }}"
                            href="{{ route('admin.settings.appearance.index') }}">
                            <i class="mdi mdi-looks mr-2 text-info"></i> Appearance </a>

                        <div class="dropdown-divider"></div>
                        <a style="color:#a5a5a5"
                            class="dropdown-item {{ Route::is('admin.settings.mail.index') ? 'active' : '' }}"
                            href="{{ route('admin.settings.mail.index') }}">
                            <i class="mdi mdi-mailbox mr-2 text-info"></i> Mail </a>
                    </div>
                </li>
            @endrole

            @role('director-general')
            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Route::is('directorGeneral.dashboard') ? 'active' : '' }}"
                   href="{{ route('directorGeneral.dashboard') }}"> Dashboard </a>
            </li>
            <!-- <li class="nav-item">
                <a style="color:white"
                   class="nav-link {{ Request::is('director-general/indents*') ? 'active' : '' }}"
                   href="{{ route('directorGeneral.indents.index') }}"> Indents </a>
            </li> -->

            <li class="nav-item dropdown">
                <a style="color:white"
                    class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                    id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Indents </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('director-general/indents*') ? 'active' : '' }}"
                        href="{{ route('directorGeneral.indents.index') }}"> General Indents </a>
                    <div class="dropdown-divider"></div>
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('director-general/generate') ? 'active' : '' }}"
                        href="{{ route('directorGeneral.indents.manufactureList') }}"> Central Indents </a>
                </div>
            </li>

            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Request::is('director-general/srb*') ? 'active' : '' }}"
                   href="{{ route('directorGeneral.srb.index') }}"> SRB </a>
            </li>

{{--            /* ggg*/--}}

            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Request::is('admin/manufactures*') ? 'active' : '' }}"
                   href="{{ route('admin.manufactures.index') }}"> Manufactures </a>
            </li>

            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Request::is('admin/stations*') ? 'active' : '' }}"
                   href="{{ route('admin.stations.index') }}"> Stations </a>
            </li>

            <li class="nav-item dropdown">
                <a style="color:white"
                   class="nav-link dropdown-toggle {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                   href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Instruments </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('admin/instrument-types*') ? 'active' : '' }}"
                        href="{{ route('admin.instrument-types.index') }}"> Types </a>
                    <div class="dropdown-divider"></div>
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('admin/instruments*') ? 'active' : '' }}"
                        href="{{ route('admin.instruments.index') }}">All Instruments</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a style="color:white"
                   class="nav-link dropdown-toggle {{ Request::is('admin/part*') ? 'active' : '' }}" href="#"
                   id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Parts </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a style="color:#a5a5a5"
                       class="dropdown-item {{ Request::is('admin/part-types*') ? 'active' : '' }}"
                       href="{{ route('admin.part-types.index') }}"> Types </a>
                    <div class="dropdown-divider"></div>
                    <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/parts*') ? 'active' : '' }}"
                       href="{{ route('admin.parts.index') }}">All Parts</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a style="color:white"
                   class="nav-link dropdown-toggle {{ Request::is('admin/roles*') || Request::is('admin/users*') ? 'active' : '' }}"
                   href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> System </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/roles*') ? 'active' : '' }}"
                       href="{{ route('admin.roles.index') }}">
                        <i class="mdi mdi-account-group mr-2 text-success"></i> Roles </a>
                    <div class="dropdown-divider"></div>
                    <a style="color:#a5a5a5" class="dropdown-item {{ Request::is('admin/users*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        <i class="mdi mdi-account-circle mr-2 text-info"></i> Users </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                   href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown" style="color:#a5a5a5">
                    <a style="color:#a5a5a5"
                       class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                       href="{{ route('admin.stock.instruments.index') }}"> Instruments </a>
                    <div class="dropdown-divider"></div>
                    <a style="color:#a5a5a5" class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                       href="{{ route('admin.stock.parts.index') }}"> Parts </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a style="color:white"
                   class="nav-link dropdown-toggle {{ Request::is('admin/settings*') ? 'active' : '' }}" href="#"
                   id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Settings </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a style="color:#a5a5a5"
                       class="dropdown-item {{ Route::is('admin.settings.general') ? 'active' : '' }}"
                       href="{{ route('admin.settings.index') }}">
                        <i class="mdi mdi-settings mr-2 text-success"></i> General </a>

                    <div class="dropdown-divider"></div>
                    <a style="color:#a5a5a5"
                       class="dropdown-item {{ Route::is('admin.settings.appearance.index') ? 'active' : '' }}"
                       href="{{ route('admin.settings.appearance.index') }}">
                        <i class="mdi mdi-looks mr-2 text-info"></i> Appearance </a>

                    <div class="dropdown-divider"></div>
                    <a style="color:#a5a5a5"
                       class="dropdown-item {{ Route::is('admin.settings.mail.index') ? 'active' : '' }}"
                       href="{{ route('admin.settings.mail.index') }}">
                        <i class="mdi mdi-mailbox mr-2 text-info"></i> Mail </a>
                </div>
            </li>
            @endrole

{{--            @role('director-general')--}}
{{--                <li class="nav-item">--}}
{{--                    <a style="color:white" class="nav-link {{ Route::is('directorGeneral.dashboard') ? 'active' : '' }}"--}}
{{--                        href="{{ route('directorGeneral.dashboard') }}"> Dashboard </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a style="color:white"--}}
{{--                        class="nav-link {{ Request::is('director-general/indents*') ? 'active' : '' }}"--}}
{{--                        href="{{ route('directorGeneral.indents.index') }}"> Indents </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a style="color:white" class="nav-link {{ Request::is('director-general/srb*') ? 'active' : '' }}"--}}
{{--                        href="{{ route('directorGeneral.srb.index') }}"> SRB </a>--}}
{{--                </li>--}}
{{--            @endrole--}}

            @role('ace')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('ACE.dashboard') ? 'active' : '' }}"
                        href="{{ route('ACE.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('ace/indents*') ? 'active' : '' }}"
                        href="{{ route('ACE.indents.manufactureList') }}"> Central Indents  </a>
                </li>
            @endrole

            @role('me')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('mainEngineer.dashboard') ? 'active' : '' }}"
                        href="{{ route('mainEngineer.dashboard') }}"> Dashboard </a>
                </li>
                <!-- <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('main-engineer/indents*') ? 'active' : '' }}"
                        href="{{ route('mainEngineer.indents.index') }}"> Indents </a>
                </li> -->
                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Indents </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('main-engineer/indents*') ? 'active' : '' }}"
                            href="{{ route('mainEngineer.indents.index') }}"> General Indents </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('main-engineer/generate') ? 'active' : '' }}"
                            href="{{ route('mainEngineer.indents.manufactureList') }}"> Central Indents </a>
                    </div>
                </li>
                    

                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('main-engineer/srb*') ? 'active' : '' }}"
                        href="{{ route('mainEngineer.srb.index') }}"> SRB </a>
                </li>
            @endrole
            @role('central-engineer')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('centralEngineer.dashboard') ? 'active' : '' }}"
                        href="{{ route('centralEngineer.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Indents </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('central-engineer/indents*') ? 'active' : '' }}"
                            href="{{ route('centralEngineer.indents.index') }}"> General Indents </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('central-engineer/generate') ? 'active' : '' }}"
                            href="{{ route('centralEngineer.indents.manufactureList') }}"> Central Indents </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('centralEngineer/srb*') ? 'active' : '' }}"
                        href="{{ route('centralEngineer.srb.index') }}"> SRB </a>
                </li>
            @endrole
            @role('se')
            <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('SE.dashboard') ? 'active' : '' }}"
                        href="{{ route('SE.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('se/indents*') ? 'active' : '' }}"
                        href="{{ route('SE.indents.manufactureList') }}"> Central Indents  </a>
                </li>
            @endrole
            @role('dse')
            <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('DSE.dashboard') ? 'active' : '' }}"
                        href="{{ route('DSE.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Indents </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('dse/indents*') ? 'active' : '' }}"
                            href="{{ route('DSE.indents.index') }}"> General Indents </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('dse/generate') ? 'active' : '' }}"
                            href="{{ route('DSE.indents.manufactureList') }}"> Central Indents  </a>
                    </div>
            @endrole
            @role('intent-officer')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('intentOfficer.dashboard') ? 'active' : '' }}"
                        href="{{ route('intentOfficer.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('intent-officer/indents*') ? 'active' : '' }}"
                        href="{{ route('intentOfficer.indents.index') }}"> Indents </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('intent-officer/srb*') ? 'active' : '' }}"
                        href="{{ route('intentOfficer.srb.index') }}"> SRB </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('intentOfficer.stock.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a  class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('intentOfficer.stock.parts') }}"> Parts </a>
                    </div>
                </li>
            @endrole
            @role('station-head')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('stationHead.dashboard') ? 'active' : '' }}"
                        href="{{ route('stationHead.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('station-head/indents*') ? 'active' : '' }}"
                        href="{{ route('stationHead.indents.index') }}"> Indents </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('station-head/srb*') ? 'active' : '' }}"
                        href="{{ route('stationHead.srb.index') }}"> SRB </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('station-head/sib*') ? 'active' : '' }}"
                        href="{{ route('stationHead.sib.index') }}"> SIB </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('stationHead.stock.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a  class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('stationHead.stock.parts') }}"> Parts </a>
                    </div>
                </li>
            @endrole
            @role('station-incharge')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('stationIncharge.dashboard') ? 'active' : '' }}"
                        href="{{ route('stationIncharge.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white"
                        class="nav-link {{ Request::is('station-incharge/indents*') ? 'active' : '' }}"
                        href="{{ route('stationIncharge.indents.index') }}"> Indents </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('station-incharge/srb*') ? 'active' : '' }}"
                        href="{{ route('stationIncharge.srb.index') }}"> SRB </a>
                </li>

                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('station-incharge/sib*') ? 'active' : '' }}"
                        href="{{ route('stationIncharge.sib.index') }}"> SIB </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('stationIncharge.stock.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a  class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('stationIncharge.stock.parts') }}"> Parts </a>
                    </div>
                </li>
            @endrole
            @role('storekeeper')
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Route::is('storekeeper.dashboard') ? 'active' : '' }}"
                        href="{{ route('storekeeper.dashboard') }}"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('storekeeper/srb*') ? 'active' : '' }}"
                        href="{{ route('storekeeper.srb.index') }}"> SRB </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('storekeeper/sib*') ? 'active' : '' }}"
                        href="{{ route('storekeeper.sib.index') }}"> SIB </a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link {{ Request::is('storekeeper/sib*') ? 'active' : '' }}"
                       href="{{ route('storekeeper.sib.damage') }}"> Damage </a>
                </li>
                <li class="nav-item dropdown">
                    <a style="color:white" class="nav-link dropdown-toggle {{ Request::is('stock*') ? 'active' : '' }}"
                        href="#" id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> Stocks </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('storekeeper.stock.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a  class="dropdown-item dropdown_color {{ Request::is('stock/parts*') ? 'active' : '' }}"
                            href="{{ route('storekeeper.stock.parts') }}"> Parts </a>
                    </div>
                </li>
            @endrole
            {{-- @if (!auth()->user()->hasRole('admin'))
                <li class="nav-item dropdown">
                    <a style="color:white"
                        class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                        id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> National Stock </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('national_stock/instruments*') ? 'active' : '' }}"
                            href="{{ route('share.instruments') }}"> Instruments </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item dropdown_color {{ Request::is('national_stock/parts*') ? 'active' : '' }}"
                            href="{{ route('share.parts') }}"> Parts </a>
                    </div>
                </li>
            @endif --}}

            <li class="nav-item dropdown">
                <a style="color:white"
                    class="nav-link dropdown-toggle {{ Request::is('share*') ? 'active' : '' }}" href="#"
                    id="actions-dropdown" data-toggle="dropdown" aria-expanded="false"> National Stock </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="actions-dropdown">
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('national_stock/instruments*') ? 'active' : '' }}"
                        href="{{ route('share.instruments') }}"> Instruments </a>
                    <div class="dropdown-divider"></div>
                    <a
                        class="dropdown-item dropdown_color {{ Request::is('national_stock/parts*') ? 'active' : '' }}"
                        href="{{ route('share.parts') }}"> Parts </a>
                </div>
            </li>
            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Route::is('troubleshootings.index') ? 'active' : '' }}"
                    href="{{ route('troubleshootings.index') }}"> Troubleshooting </a>
            </li>
            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Route::is('faqs.index') ? 'active' : '' }}"
                    href="{{ route('faqs.index') }}"> Faqs </a>
            </li>

            <li class="nav-item">
                <a style="color:white" class="nav-link {{ Route::is('forum.index') ? 'active' : '' }}"
                    href="{{ route('forum.index') }}"> Forum </a>
            </li>

        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a style="color:white" class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                    data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{ Auth::user()->getFirstMediaUrl('avatar') }}" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p style="color:white" class="mb-1 text-black">{{ Auth::user()->name }}</p>
                        <p style="color:white" class="font-weight-light mb-0">{{ Auth::user()->role->name }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item {{ Route::is('user.profile.index') ? 'active' : '' }}"
                        href="{{ route('user.profile.index') }}">
                        <i class="mdi mdi-face-profile mr-2 text-success"></i> Profile </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {{ Route::is('user.profile.password.change') ? 'active' : '' }}"
                        href="{{ route('user.profile.password.change') }}">
                        <i class="mdi mdi-textbox-password mr-2 text-warning"></i> Change Password </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout mr-2 text-primary"></i> Logout </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button"
            data-toggle="collapse" data-target="#horizontal-top-example">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</div>
