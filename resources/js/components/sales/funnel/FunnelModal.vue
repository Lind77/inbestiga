<template>
    <div class="modal fade" id="funnelModal" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                <label for="nameLarge" class="form-label">Name</label>
                <input type="text" id="nameLarge" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="emailLarge" class="form-label">Email</label>
                <input type="email" id="emailLarge" class="form-control" placeholder="xxxx@xxx.xx">
                </div>
                <div class="col mb-0">
                <label for="dobLarge" class="form-label">DOB</label>
                <input type="date" id="dobLarge" class="form-control" placeholder="DD / MM / YY">
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    
}
</script>
