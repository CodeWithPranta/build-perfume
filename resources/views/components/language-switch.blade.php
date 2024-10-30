<form action="{{ route('language.switch') }}" method="POST" class="inline-block">
    @csrf
    <div class="flex items-center space-x-4">
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="language" value="en" onchange="this.form.submit()" {{ session('language') === 'en' ? 'checked' : '' }} class="">
            <img src="{{ asset('images/united-kingdom.png') }}" alt="English" class="w-6 h-6 mr-2 border-2 border-transparent {{ app()->getLocale() === 'en' ? 'border-blue-500' : '' }}">
            English
        </label>

        <label class="flex items-center cursor-pointer">
            <input type="radio" name="language" value="alb" onchange="this.form.submit()" {{ session('language') === 'alb' ? 'checked' : '' }} class="">
            <img src="{{ asset('images/albania.png') }}" alt="Albanian" class="w-6 h-6 mr-2 border-2 border-transparent {{ app()->getLocale() === 'alb' ? 'border-blue-500' : '' }}">
            Albanian
        </label>
    </div>
</form>
