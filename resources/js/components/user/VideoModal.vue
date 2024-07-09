<template>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="embed-responsive embed-responsive-16by9 pt-2">
                        <iframe
                            class="embed-responsive-item w-100 vh-75"
                            :src="videoSrc"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        videoSrc: String,
    },
    methods: {
        stopVideo() {
            var videos = document.querySelectorAll("iframe, video");
            Array.prototype.forEach.call(videos, function (video) {
                if (video.tagName.toLowerCase() === "video") {
                    video.pause();
                } else {
                    var src = video.src;
                    video.src = src;
                }
            });
        },
    },
    mounted() {
        $("#videoModal").on("hidden.bs.modal", this.stopVideo);
    },
};
</script>
<style scoped>
iframe {
    padding-bottom: -20px !important;
}
</style>
