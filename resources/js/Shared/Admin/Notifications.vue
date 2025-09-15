<template>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title">Notifications</h3>
                <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
            </div>
            <div class="list-group list-group-flush list-group-hoverable">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                        <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 1</a>
                            <div class="d-block text-secondary text-truncate mt-n1">Change deprecated html tags to text decoration classes (#29604)</div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon text-muted //text-yellow icon-2"
                                >
                                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="#" class="btn btn-2 w-100"> Archive all </a>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-2 w-100"> Mark all as read </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
