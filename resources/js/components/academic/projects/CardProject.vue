<template>        
    <div class="card text-white mb-3 bg-danger cursor-pointer" draggable="true" @dragstart="drag" :id="`${project.id}`" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
        <div class="card-header">
        <p class="mb-0">{{ project.textStatus }}</p>
        <p class="mb-0">Fecha de Culminación: {{ project.deadline }}</p>
        </div>
        <div class="card-body">
        <a class="text-white" @click="showProgress(project.progress)" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#progressModal">
                {{ project.progress.reduce((acc, item)=> acc+item.percentage, 0) }} %
                </a>    
                <div class="progress">
                    <div class="progress-bar" role="progressbar" :style="{width: project.progress.reduce((acc, item)=> acc+item.percentage, 0) + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
        <h4 class="card-title text-white">{{ project.title }}</h4>
        <div class="card-text w-100">
            <span class="badge badge-center bg-success">
            <i class='bx bx-user bx-xs'></i>
            </span>
            <span data-bs-toggle="modal" data-bs-target="#teamModal" class="badge badge-center bg-success mx-2">
            <i class='bx bx-group bx-xs'></i>
            </span>
        </div>
        </div>
        </div>
</template>