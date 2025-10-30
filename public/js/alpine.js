document.addEventListener("livewire:init", () => {
  // Disable right click
  document.addEventListener("contextmenu", event => event.preventDefault());

  // Disable copy shortcuts
  document.addEventListener("keydown", function(e) {
    if (e.ctrlKey && (e.key === "c" || e.key === "u")) e.preventDefault();
    if (e.ctrlKey && e.shiftKey && e.key === "I") e.preventDefault(); // Ctrl+Shift+I
  });
});

function videoPlayer(video) {
  return {
    isPlaying: false,
    isMuted: false,
    duration: 0,
    currentTime: 0,
    progress: 0,
    videoSrc: video,

    init() {
      this.$refs.video.src = this.videoSrc;
    },

    playVideo() {
      this.togglePlay();
    },

    togglePlay() {
      const v = this.$refs.video;
      if (v.paused) {
        v.play();
        this.isPlaying = true;
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
      this.progress = v.currentTime / v.duration * 100;
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
    }
  };
}
