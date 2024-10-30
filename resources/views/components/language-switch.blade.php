<form action="{{ route('language.switch') }}" method="POST" class="d-inline-block">
    @csrf
    <div class="d-flex align-items-center gap-3 pt-2">
        <label class="d-flex align-items-center cursor-pointer">
            <input type="radio" name="language" value="en" onchange="this.form.submit()" {{ session('language') === 'en' ? 'checked' : '' }} class="d-none">
            <img src="{{ asset('images/united-kingdom.png') }}" alt="English"
                 class="rounded-circle border border-2 {{ session('language') === 'en' ? 'border-primary bg-primary' : 'border-transparent' }}"
                 style="width: 24px; height: 24px;">
            <span class="ms-2 {{ session('language') === 'en' ? 'text-white' : 'text-dark' }}">English</span>
        </label>

        <label class="d-flex align-items-center cursor-pointer">
            <input type="radio" name="language" value="alb" onchange="this.form.submit()" {{ session('language') === 'alb' ? 'checked' : '' }} class="d-none">
            <img src="{{ asset('images/albania.png') }}" alt="Albanian"
                 class="rounded-circle border border-2 {{ session('language') === 'alb' ? 'border-primary bg-primary' : 'border-transparent' }}"
                 style="width: 24px; height: 24px;">
            <span class="ms-2 {{ session('language') === 'alb' ? 'text-white' : 'text-dark' }}">Albanian</span>
        </label>
    </div>
</form>
