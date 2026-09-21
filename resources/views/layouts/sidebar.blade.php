<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            {!! app(\App\Services\MenuService::class)->getMenu(1) !!}
        </div>
    </div>
</div>
