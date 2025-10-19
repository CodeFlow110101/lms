<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        <div
            x-data="videoPlayer('{{ route('video.stream', ['filename' => Str::after($getState(), 'files/')]) }}', '{{ route('image.show', ['filename' => Str::after($record->image, 'files/')]) }}')"
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
        <!-- <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('videoPlayer', () => ({
                    isPlaying: false,
                    isMuted: false,
                    showThumbnail: true,
                    duration: 0,
                    currentTime: 0,
                    progress: 0,

                    thumbnail: 'https://peach.blender.org/wp-content/uploads/title_anouncement.jpg?x11217',
                    videoSrc: "{{ route('video.stream', ['filename' => Str::chopStart($getState(),'files/')]) }}",

                    init() {
                        this.$refs.video.src = this.videoSrc;
                    },

                    playVideo() {
                        this.showThumbnail = false;
                        this.togglePlay();
                    },

                    togglePlay() {
                        const v = this.$refs.video;
                        if (v.paused) {
                            v.play();
                            this.isPlaying = true;
                            this.showThumbnail = false;
                        } else {
                            v.pause();
                            this.isPlaying = false;
                        }
                    },

                    toggleMute() {
                        const v = this.$refs.video;
                        v.muted = !v.muted;
                        this.isMuted = v.muted;
                    },

                    updateProgress() {
                        const v = this.$refs.video;
                        this.currentTime = v.currentTime;
                        this.progress = (v.currentTime / v.duration) * 100;
                    },

                    setDuration() {
                        this.duration = this.$refs.video.duration;
                    },

                    seek(event) {
                        const v = this.$refs.video;
                        const rect = event.target.getBoundingClientRect();
                        const pos = (event.clientX - rect.left) / rect.width;
                        v.currentTime = pos * v.duration;
                    },

                    // Format time as MM:SS
                    formatTime(seconds) {
                        if (!seconds || isNaN(seconds)) return "00:00";
                        const m = Math.floor(seconds / 60).toString().padStart(2, "0");
                        const s = Math.floor(seconds % 60).toString().padStart(2, "0");
                        return `${m}:${s}`;
                    },

                    get currentTimeDisplay() {
                        return this.formatTime(this.currentTime);
                    },

                    get durationDisplay() {
                        return this.formatTime(this.duration);
                    },
                }));
            });
        </script> -->



    </div>
</x-dynamic-component>