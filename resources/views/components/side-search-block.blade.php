<form action="{{route('search')}}" class="search sidebar__search">
    <p class="search-title">Find More</p>
    <p class="search-text">
        Use search to find the required information easier and faster
    </p>
    <div class="search-field">
        <button class="search-icon" type="submit">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="10.137" cy="10.1371" r="6.47345" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M18.3367 18.3364L14.7144 14.7141" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <input type="text" name="search" class="search-input" placeholder="Search for something..." value="{{request()->search}}" />
    </div>
</form>