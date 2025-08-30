<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($services as $item)
            <livewire:service-card :service="$item" :key="$item->id" />
        @endforeach
    </div>
</div>