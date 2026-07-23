<template>
    <div class="container-xxl flex-grow-1 container-p-y projects-board">
        <div class="board-header">
            <div class="board-title">
                <h4 class="fw-bold mb-0">{{ workspaceName }} <i class="bx bx-chevron-down"></i></h4>
            </div>
            <div class="board-tabs">
                <span class="board-tab active">
                    <i class="bx bx-table"></i> Tabla principal
                </span>
                <span class="board-tab-add"><i class="bx bx-plus"></i></span>
            </div>
        </div>

        <div class="board-toolbar">
            <div class="dropdown">
                <button class="btn-add-task" @click="addProject(groups[0])">
                    <i class="bx bx-plus"></i> Agregar proyecto
                    <i class="bx bx-chevron-down ms-1"></i>
                </button>
            </div>
            <div class="toolbar-actions">
                <div class="toolbar-search">
                    <i class="bx bx-search"></i>
                    <input v-model="search" type="text" placeholder="Buscar..." />
                </div>
                <button class="toolbar-btn"><i class="bx bx-user-circle"></i> Persona</button>
                <button class="toolbar-btn"><i class="bx bx-filter-alt"></i> Filtrar</button>
                <button class="toolbar-btn"><i class="bx bx-sort-up"></i> Ordenar</button>
                <button class="toolbar-btn"><i class="bx bx-hide"></i> Ocultar</button>
                <button class="toolbar-btn"><i class="bx bx-layer"></i> Agrupar por</button>
            </div>
        </div>

        <div class="board-group" v-for="group in filteredGroups" :key="group.key">
            <div class="group-header" @click="toggleGroup(group)">
                <i class="bx" :class="group.collapsed ? 'bx-chevron-right' : 'bx-chevron-down'"></i>
                <span class="group-title" :style="{ color: group.color }">{{ group.name }}</span>
                <span class="group-count">{{ group.items.length }}</span>
            </div>

            <div class="board-table" v-show="!group.collapsed">
                <div class="table-row table-head">
                    <div class="col col-check"><input type="checkbox" /></div>
                    <div class="col col-title">Tarea</div>
                    <div class="col col-responsible">Responsable</div>
                    <div class="col col-status">Estado <i class="bx bx-info-circle"></i></div>
                    <div class="col col-due">Vencimiento <i class="bx bx-info-circle"></i></div>
                    <div class="col col-files">Archivos</div>
                    <div class="col col-timeline">Cronograma <i class="bx bx-info-circle"></i></div>
                    <div class="col col-add"><i class="bx bx-plus"></i></div>
                </div>

                <div
                    class="table-row project-row"
                    v-for="item in group.items"
                    :key="item.id"
                    :style="{ borderLeftColor: statusMeta(item.status).color }"
                >
                    <div class="col col-check"><input type="checkbox" /></div>
                    <div class="col col-title">
                        <input
                            v-if="item.editing"
                            :ref="'titleInput' + item.id"
                            v-model="item.title"
                            type="text"
                            class="title-input"
                            placeholder="Nombre del proyecto..."
                            @blur="finishEditing(item, group)"
                            @keyup.enter="finishEditing(item, group)"
                        />
                        <span v-else>{{ item.title }}</span>
                    </div>
                    <div class="col col-responsible">
                        <div class="avatar" :class="{ 'avatar-empty': !item.user }">
                            <span v-if="item.user">{{ initials(item.user) }}</span>
                            <i v-else class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="col col-status">
                        <div
                            class="status-pill"
                            :style="{ background: statusMeta(item.status).color }"
                            @click.stop="openStatusItemId = openStatusItemId === item.id ? null : item.id"
                        >
                            {{ statusMeta(item.status).label }}
                        </div>
                        <div class="status-dropdown" v-if="openStatusItemId === item.id">
                            <div
                                v-for="opt in statusOptions"
                                :key="opt.value"
                                class="status-option"
                                @click.stop="setStatus(item, opt.value)"
                            >
                                <span class="status-dot" :style="{ background: opt.color }"></span>
                                {{ opt.label }}
                            </div>
                        </div>
                    </div>
                    <div class="col col-due">
                        <i class="bx" :class="dueMeta(item).icon" :style="{ color: dueMeta(item).color }"></i>
                        {{ formatDate(item.deadline) }}
                    </div>
                    <div class="col col-files">
                        <span v-if="item.files > 0" class="file-badge">
                            <i class="bx bxs-file-blank"></i> {{ item.files }}
                        </span>
                    </div>
                    <div class="col col-timeline">
                        <div class="timeline-pill" :style="{ background: dueMeta(item).color }">
                            {{ formatRange(item.start_date, item.deadline) }}
                        </div>
                    </div>
                    <div class="col col-add"></div>
                </div>

                <div class="table-row add-row" @click="addProject(group)">
                    <div class="col col-check"></div>
                    <div class="col add-task-link"><i class="bx bx-plus"></i> Agregar proyecto</div>
                </div>

                <div class="table-row summary-row">
                    <div class="col col-check"></div>
                    <div class="col col-title"></div>
                    <div class="col col-responsible"></div>
                    <div class="col col-status">
                        <div class="summary-bar" v-if="group.items.length">
                            <span
                                v-for="seg in statusDistribution(group)"
                                :key="seg.status"
                                :style="{ background: seg.color, width: seg.pct + '%' }"
                            ></span>
                        </div>
                    </div>
                    <div class="col col-due">
                        <span class="summary-pill" v-if="group.items.length">{{ groupDueRange(group) }}</span>
                    </div>
                    <div class="col col-files">
                        <span class="summary-text">{{ totalFiles(group) }} archivos</span>
                    </div>
                    <div class="col col-timeline">
                        <span class="summary-pill" v-if="group.items.length">{{ groupTimelineRange(group) }}</span>
                    </div>
                    <div class="col col-add"></div>
                </div>
            </div>
        </div>

        <button class="btn-add-group" @click="addGroup">
            <i class="bx bx-plus"></i> Agregar grupo nuevo
        </button>
    </div>
</template>

<script>
export default {
    data() {
        const today = new Date();
        const addDays = (n) => {
            const d = new Date(today);
            d.setDate(d.getDate() + n);
            return d.toISOString().slice(0, 10);
        };
        return {
            workspaceName: "Proyectos",
            search: "",
            openStatusItemId: null,
            statusOptions: [
                { value: "curso", label: "En curso", color: "#F5A623" },
                { value: "listo", label: "Listo", color: "#28C76F" },
                { value: "detenido", label: "Detenido", color: "#EA5455" },
                { value: "pendiente", label: "Sin estado", color: "#A8AAAE" },
            ],
            groups: [
                {
                    key: "pending",
                    name: "Pendientes",
                    color: "#4A6CF7",
                    collapsed: false,
                    items: [
                        {
                            id: 1,
                            title: "Proyecto 1",
                            status: "curso",
                            user: { name: "Juan Perez" },
                            start_date: addDays(-1),
                            deadline: addDays(-1),
                            files: 1,
                            editing: false,
                        },
                        {
                            id: 2,
                            title: "Proyecto 2",
                            status: "listo",
                            user: null,
                            start_date: addDays(1),
                            deadline: addDays(2),
                            files: 0,
                            editing: false,
                        },
                        {
                            id: 3,
                            title: "Proyecto 3",
                            status: "detenido",
                            user: null,
                            start_date: addDays(3),
                            deadline: addDays(4),
                            files: 0,
                            editing: false,
                        },
                    ],
                },
                {
                    key: "completed",
                    name: "Completado",
                    color: "#28C76F",
                    collapsed: false,
                    items: [],
                },
            ],
            nextId: 4,
        };
    },
    computed: {
        filteredGroups() {
            if (!this.search.trim()) return this.groups;
            const term = this.search.trim().toLowerCase();
            return this.groups.map((group) => ({
                ...group,
                items: group.items.filter((item) => item.title.toLowerCase().includes(term)),
            }));
        },
    },
    methods: {
        toggleGroup(group) {
            group.collapsed = !group.collapsed;
        },
        statusMeta(status) {
            return this.statusOptions.find((opt) => opt.value === status) || this.statusOptions[3];
        },
        dueMeta(item) {
            if (item.status === "listo") {
                return { state: "done", color: "#28C76F", icon: "bx-check" };
            }
            const due = new Date(item.deadline);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (due < today) {
                return { state: "overdue", color: "#EA5455", icon: "bx-error-circle" };
            }
            return { state: "upcoming", color: "#6E6B7B", icon: "bx-time-five" };
        },
        initials(user) {
            return user.name
                .split(" ")
                .map((n) => n[0])
                .join("")
                .slice(0, 2)
                .toUpperCase();
        },
        formatDate(dateStr) {
            const months = ["ene.", "feb.", "mar.", "abr.", "may.", "jun.", "jul.", "ago.", "sep.", "oct.", "nov.", "dic."];
            const d = new Date(dateStr);
            return `${months[d.getMonth()]} ${d.getDate()}`;
        },
        formatRange(start, end) {
            const months = ["ene.", "feb.", "mar.", "abr.", "may.", "jun.", "jul.", "ago.", "sep.", "oct.", "nov.", "dic."];
            const s = new Date(start);
            const e = new Date(end);
            if (s.getMonth() === e.getMonth()) {
                return `${months[s.getMonth()]} ${s.getDate()} - ${e.getDate()}`;
            }
            return `${months[s.getMonth()]} ${s.getDate()} - ${months[e.getMonth()]} ${e.getDate()}`;
        },
        setStatus(item, value) {
            item.status = value;
            this.openStatusItemId = null;
        },
        addProject(group) {
            const item = {
                id: this.nextId++,
                title: "",
                status: "pendiente",
                user: null,
                start_date: new Date().toISOString().slice(0, 10),
                deadline: new Date().toISOString().slice(0, 10),
                files: 0,
                editing: true,
            };
            group.items.push(item);
            this.$nextTick(() => {
                const ref = this.$refs["titleInput" + item.id];
                const el = Array.isArray(ref) ? ref[0] : ref;
                if (el) el.focus();
            });
        },
        finishEditing(item, group) {
            item.editing = false;
            if (!item.title.trim()) {
                group.items = group.items.filter((i) => i.id !== item.id);
            }
        },
        addGroup() {
            this.groups.push({
                key: "group-" + Date.now(),
                name: "Nuevo grupo",
                color: "#A8AAAE",
                collapsed: false,
                items: [],
            });
        },
        totalFiles(group) {
            return group.items.reduce((sum, item) => sum + (item.files || 0), 0);
        },
        groupDueRange(group) {
            const dates = group.items.map((i) => new Date(i.deadline)).sort((a, b) => a - b);
            if (!dates.length) return "-";
            return this.formatRange(dates[0], dates[dates.length - 1]);
        },
        groupTimelineRange(group) {
            const starts = group.items.map((i) => new Date(i.start_date)).sort((a, b) => a - b);
            const ends = group.items.map((i) => new Date(i.deadline)).sort((a, b) => a - b);
            if (!starts.length) return "-";
            return this.formatRange(starts[0], ends[ends.length - 1]);
        },
        statusDistribution(group) {
            const total = group.items.length;
            if (!total) return [];
            const counts = {};
            group.items.forEach((item) => {
                counts[item.status] = (counts[item.status] || 0) + 1;
            });
            return Object.keys(counts).map((status) => ({
                status,
                color: this.statusMeta(status).color,
                pct: (counts[status] / total) * 100,
            }));
        },
    },
};
</script>

<style scoped>
.projects-board {
    font-family: -apple-system, "Segoe UI", Roboto, Poppins, sans-serif;
}

.board-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.board-tabs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 1rem 0;
    border-bottom: 1px solid #e4e6ef;
}

.board-tab {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 0.9rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4a6cf7;
    border-bottom: 2px solid #4a6cf7;
}

.board-tab-add {
    display: flex;
    align-items: center;
    padding: 0.6rem 0.5rem;
    color: #a8aaae;
    cursor: pointer;
}

.board-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.6rem;
    margin-bottom: 1rem;
}

.btn-add-task {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    background: #4a6cf7;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 0.5rem 0.9rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
}

.toolbar-actions {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
}

.toolbar-search {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.4rem 0.7rem;
    border-radius: 4px;
    color: #6e6b7b;
    font-size: 0.85rem;
}

.toolbar-search input {
    border: none;
    outline: none;
    background: transparent;
    font-size: 0.85rem;
    width: 110px;
}

.toolbar-btn {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    background: transparent;
    border: none;
    color: #6e6b7b;
    font-size: 0.85rem;
    padding: 0.4rem 0.6rem;
    border-radius: 4px;
    cursor: pointer;
}

.toolbar-btn:hover {
    background: #f5f6fa;
}

.board-group {
    margin-bottom: 1.5rem;
}

.group-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 0.2rem;
    cursor: pointer;
    user-select: none;
}

.group-title {
    font-weight: 700;
    font-size: 0.95rem;
}

.group-count {
    background: #f0f1f7;
    color: #6e6b7b;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.1rem 0.5rem;
    border-radius: 10px;
}

.board-table {
    border: 1px solid #e4e6ef;
    border-radius: 6px;
    overflow: hidden;
}

.table-row {
    display: grid;
    grid-template-columns: 40px 1fr 70px 140px 130px 90px 150px 40px;
    align-items: center;
    border-bottom: 1px solid #e4e6ef;
    background: #fff;
}

.table-row:last-child {
    border-bottom: none;
}

.table-head {
    background: #fafbfc;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6e6b7b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.table-head .col-add {
    color: #a8aaae;
}

.col {
    padding: 0.7rem 0.6rem;
    font-size: 0.85rem;
    color: #4b4b4b;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.col-check {
    justify-content: center;
}

.col-add {
    justify-content: center;
}

.project-row {
    border-left: 3px solid transparent;
    position: relative;
}

.title-input {
    width: 100%;
    border: 1px solid #4a6cf7;
    border-radius: 4px;
    padding: 0.2rem 0.4rem;
    font-size: 0.85rem;
    outline: none;
}

.avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #1b1b1b;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
}

.avatar-empty {
    background: #f0f1f7;
    color: #c4c6d0;
    border: 1px dashed #c4c6d0;
}

.status-pill {
    width: 100%;
    text-align: center;
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 0.35rem 0.4rem;
    border-radius: 4px;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.status-dropdown {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    border: 1px solid #e4e6ef;
    border-radius: 6px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    z-index: 20;
    padding: 0.3rem;
    min-width: 140px;
}

.status-option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.5rem;
    font-size: 0.8rem;
    border-radius: 4px;
    cursor: pointer;
    white-space: nowrap;
}

.status-option:hover {
    background: #f5f6fa;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.file-badge {
    display: flex;
    align-items: center;
    gap: 0.2rem;
    background: #f0f1f7;
    color: #4a6cf7;
    border-radius: 4px;
    padding: 0.15rem 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.timeline-pill {
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
}

.add-row {
    grid-template-columns: 40px 1fr;
    cursor: pointer;
}

.add-task-link {
    color: #a8aaae;
    font-size: 0.85rem;
    padding: 0.7rem 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.add-row:hover .add-task-link {
    color: #4a6cf7;
}

.summary-row {
    background: #fafbfc;
}

.summary-bar {
    width: 100%;
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    background: #e4e6ef;
}

.summary-pill {
    background: #4a6cf7;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.6rem;
    border-radius: 12px;
}

.summary-text {
    font-size: 0.78rem;
    color: #6e6b7b;
    font-weight: 600;
}

.btn-add-group {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    background: #fff;
    border: 1px solid #e4e6ef;
    border-radius: 4px;
    padding: 0.5rem 0.9rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6e6b7b;
    cursor: pointer;
}

.btn-add-group:hover {
    background: #f5f6fa;
}
</style>
