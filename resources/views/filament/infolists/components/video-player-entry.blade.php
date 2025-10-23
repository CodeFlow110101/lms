<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        <div
            x-data="videoPlayer('{{ route('video.stream', ['filename' => Str::after($getState(), 'files/')]) }}', '{{ route('image.show', ['filename' => Str::after($record->image, 'files/')]) }}', '{{ $getExtraAttributeBag()->get('trackCompletion') }}')"
            class=" w-full mx-auto bg-black rounded-lg overflow-hidden shadow-lg select-none"
            @keydown.window.space.prevent="togglePlay">
            <div class="relative">
                <!-- Video -->
                <video
                    x-ref="video"
                    class="w-full h-96 object-contain bg-black cursor-pointer"
                    preload="metadata"
                    playsinline
                    @click="togglePlay"
                    @contextmenu.prevent
                    @timeupdate="updateProgress"
                    @loadedmetadata="setDuration"></video>

                <!-- Thumbnail -->
                <template x-if="!isPlaying && showThumbnail">
                    <img
                        :src="thumbnail"
                        class="absolute inset-0 w-full h-full object-cover cursor-pointer"
                        @click="playVideo" />
                </template>

                <!-- Overlay Play Button -->
                <template x-if="!isPlaying && showThumbnail">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/50 text-4xl">
                        <x-filament::icon-button @click="playVideo" icon="heroicon-m-play" label="New label" size="xl" />
                    </div>
                </template>
            </div>

            <!-- Custom Controls -->
            <div class="bg-gray-100 dark:bg-gray-900 text-white px-4 py-2 flex items-center gap-3">
                <x-filament::icon-button x-show="!isPlaying" icon="heroicon-m-play" @click="togglePlay" label="New label" />
                <x-filament::icon-button x-show="isPlaying" icon="heroicon-m-pause" @click="togglePlay" label="New label" />

                <x-filament::icon-button x-show="!isMuted" icon="heroicon-m-speaker-wave" @click="toggleMute" label="New label" />
                <x-filament::icon-button x-show="isMuted" icon="heroicon-m-speaker-x-mark" @click="toggleMute" label="New label" />

                <!-- Progress bar + time in one line -->
                <div class="flex items-center gap-3 flex-1">
                    <div
                        class="flex-1 h-2 bg-gray-300 dark:bg-gray-700 rounded overflow-hidden cursor-pointer"
                        @click="seek($event)">
                        <div class="h-2 bg-primary-500" :style="{ width: progress + '%'}"></div>
                    </div>


                    <!-- <div class="text-sm text-gray-300 whitespace-nowrap"> -->
                    <x-filament::badge>
                        <span x-text="currentTimeDisplay"></span> /
                        <span x-text="durationDisplay"></span>
                    </x-filament::badge>


                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>