<div class="list-group">
    <a href="{{ route('admin.settings.index') }}" class="list-group-item list-group-item-action {{ Route::is('admin.settings.index') ? 'active' : ''  }}">
        General
    </a>
    <a href="{{ route('admin.settings.appearance.index') }}" class="list-group-item list-group-item-action {{ Route::is('admin.settings.appearance.index') ? 'active' : ''  }}">
        Appearance
    </a>
    <a href="{{ route('admin.settings.mail.index') }}" class="list-group-item list-group-item-action {{ Route::is('admin.settings.mail.index') ? 'active' : ''  }}">
        Mail
    </a>
</div>
