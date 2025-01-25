<div class="right-sidebar">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16 text-blue">
            Layout Settings
            <span class="btn-block font-weight-400 font-12"
                >User Interface Settings</span
            >
        </h3>
        <div class="close-sidebar" data-toggle="right-sidebar-close">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>
    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a
                    href="javascript:void(0);"
                    class="btn btn-outline-primary header-white active"
                    >White</a
                >
                <a
                    href="javascript:void(0);"
                    class="btn btn-outline-primary header-dark"
                    >Dark</a
                >
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a
                    href="javascript:void(0);"
                    class="btn btn-outline-primary sidebar-light"
                    >White</a
                >
                <a
                    href="javascript:void(0);"
                    class="btn btn-outline-primary sidebar-dark active"
                    >Dark</a
                >
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
            <div class="sidebar-radio-group pb-10 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebaricon-1"
                        name="menu-dropdown-icon"
                        class="custom-control-input"
                        value="icon-style-1"
                        checked=""
                    />
                    <label class="custom-control-label" for="sidebaricon-1"
                        ><i class="fa fa-angle-down"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebaricon-2"
                        name="menu-dropdown-icon"
                        class="custom-control-input"
                        value="icon-style-2"
                    />
                    <label class="custom-control-label" for="sidebaricon-2"
                        ><i class="ion-plus-round"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebaricon-3"
                        name="menu-dropdown-icon"
                        class="custom-control-input"
                        value="icon-style-3"
                    />
                    <label class="custom-control-label" for="sidebaricon-3"
                        ><i class="fa fa-angle-double-right"></i
                    ></label>
                </div>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
            <div class="sidebar-radio-group pb-30 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-1"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-1"
                        checked=""
                    />
                    <label class="custom-control-label" for="sidebariconlist-1"
                        ><i class="ion-minus-round"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-2"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-2"
                    />
                    <label class="custom-control-label" for="sidebariconlist-2"
                        ><i class="fa fa-circle-o" aria-hidden="true"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-3"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-3"
                    />
                    <label class="custom-control-label" for="sidebariconlist-3"
                        ><i class="dw dw-check"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-4"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-4"
                        checked=""
                    />
                    <label class="custom-control-label" for="sidebariconlist-4"
                        ><i class="icon-copy dw dw-next-2"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-5"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-5"
                    />
                    <label class="custom-control-label" for="sidebariconlist-5"
                        ><i class="dw dw-fast-forward-1"></i
                    ></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input
                        type="radio"
                        id="sidebariconlist-6"
                        name="menu-list-icon"
                        class="custom-control-input"
                        value="icon-list-style-6"
                    />
                    <label class="custom-control-label" for="sidebariconlist-6"
                        ><i class="dw dw-next"></i
                    ></label>
                </div>
            </div>

            <div class="reset-options pt-30 text-center">
                <button class="btn btn-danger" id="reset-settings">
                    Reset Settings
                </button>
            </div>
        </div>
    </div>
</div>

<!-- left side bar  -->

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="/">
            <h2>Jio-Soul-2</h2>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                @role('super-admin')
                     <li>
                        <a href="{{route('admin.dashboard')}}" class="dropdown-toggle">
                            <span class="micon bi bi-speedometer2"></span>
                            <span class="mtext">Admin Dashboard</span>
                        </a>
                    <li>
                    <li>
                        <a href="{{route('user.lists')}}" class="dropdown-toggle">
                            <span class="micon icon-copy fa fa-list-ul"></span>
                            <span class="mtext">User Lists</span>
                        </a>
                    <li>
                    <li>
                        <a href="{{ route('deposited-amount') }}" class="dropdown-toggle">
                            <span class="micon icon-copy fa fa-spinner"></span>
                            <span class="mtext">Payment Dashboard</span>
                        </a>
                    <li>
                @endrole
                <li>
                    <a href="{{route('user.dashboard')}}" class="dropdown-toggle">
                        <span class="micon bi bi-speedometer2"></span>
                        <span class="mtext">User Dashboard</span>
                    </a>
                <li>
                <!-- <li>
                    <a href="{{route('collection.create')}}" class="dropdown-toggle">
                        <span class="micon bi bi-bank"></span>
                        <span class="mtext">Users</span>
                    </a>
                <li> -->
                <li>
                    <a href="{{route('collection.create')}}" class="dropdown-toggle">
                        <span class="micon bi bi-bank"></span>
                        <span class="mtext">Deposit</span>
                    </a>
                <li>
                <li>
                <!-- <i class="bi bi-currency-rupee"></i> -->
                    @role('super-admin')
                        <a href="{{route('purchase.amount.list')}}" class="dropdown-toggle">
                            <span class="micon bi bi-graph-up-arrow"></span>
                            <span class="mtext">Purchase Amount List</span>
                        </a>
                    @endrole
                    <a href="{{route('add.wallet.amount')}}" class="dropdown-toggle">
                        <span class="micon bi bi-currency-exchange"></span>
                        <span class="mtext"> Add Purchase Amount</span>
                    </a>
                <li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>