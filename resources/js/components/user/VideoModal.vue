<template>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row p-2">
                        <div class="col-12">
                            <div
                                style="padding: 100% 0 0 0; position: relative"
                            >
                                <iframe
                                    :src="`${videoSrc}?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479`"
                                    frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture; clipboard-write"
                                    style="
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 100%;
                                        height: 100%;
                                    "
                                    title="¿Qué sucede si mi asesor universitario rechaza el tema propuesto"
                                ></iframe>
                            </div>
                        </div>
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
    width: 100%;
    height: 20em;
    padding: 0px !important;
    border-radius: 30px;
}
</style>
