<div class="flex gap-2">
    @foreach($getRecord()->likes()->with("user")->limit(5)->get()->pluck("user.avatar") as $url)
    <x-filament::avatar
        src="{{ $url }}"
        alt="Dan Harrin"
        size="sm" />
    @endforeach
</div>