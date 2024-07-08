<template>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe class="w-100 h-100" :src="videoSrc"> </iframe>
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
};
</script>
