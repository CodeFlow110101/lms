<div class="flex gap-4">
    @if ($this->chatWIthAdmin->isVisible())
    {{ $this->chatWIthAdmin }}
    @endif
    {{ $this->settings }}
</div>