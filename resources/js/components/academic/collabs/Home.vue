<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Colaboradores</h4>
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title">Tabla de Colaboradores</h5>
            </div>
            <div class="card-datatable table-responsive">
                <div
                    id="DataTables_Table_0_wrapper"
                    class="dataTables_wrapper dt-bootstrap5 no-footer"
                >
                    <div class="row mx-2 py-2">
                        <div class="col-md-2">
                            <div class="me-3">
                                <div
                                    class="dataTables_length"
                                    id="DataTables_Table_0_length"
                                >
                                    <label
                                        ><select
                                            name="DataTables_Table_0_length"
                                            aria-controls="DataTables_Table_0"
                                            class="form-select"
                                        >
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select></label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label
                                        ><input
                                            type="search"
                                            class="form-control"
                                            placeholder="Buscar..."
                                            aria-controls="DataTables_Table_0"
                                    /></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table
                        class="datatables-users table border-top dataTable no-footer dtr-column"
                        id="DataTables_Table_0"
                        aria-describedby="DataTables_Table_0_info"
                        style="width: 1039px"
                    >
                        <thead>
                            <tr>
                                <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1" style="width: 0px; display: none" aria-label=""></th>
                                <th
                                    class="sorting sorting_desc"
                                    tabindex="0"
                                    aria-controls="DataTables_Table_0"
                                    rowspan="1"
                                    colspan="1"
                                    style="width: 252px"
                                    aria-label="User: activate to sort column ascending"
                                    aria-sort="descending"
                                >
                                    Colaborador
                                </th>
                                <th
                                    class="sorting"
                                    tabindex="0"
                                    aria-controls="DataTables_Table_0"
                                    rowspan="1"
                                    colspan="1"
                                    style="width: 120px"
                                    aria-label="Role: activate to sort column ascending"
                                >
                                    Equipo
                                </th>
                                <th
                                    class="sorting_disabled"
                                    rowspan="1"
                                    colspan="1"
                                    style="width: 99px"
                                    aria-label="Actions"
                                >
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even">
                                <td
                                    class="control"
                                    tabindex="0"
                                    style="display: none"
                                ></td>
                                <td class="sorting_1">
                                    <div
                                        class="d-flex justify-content-start align-items-center user-name"
                                    >
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-success"
                                                    >VK</span
                                                >
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a
                                                href="app-user-view-account.html"
                                                class="text-body text-truncate"
                                                ><span class="fw-semibold"
                                                    >Vladamir Koschek</span
                                                ></a
                                            ><small class="text-muted"
                                                >vkoschek17@abc.net.au</small
                                            >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-success"
                                        >Equipo A</span
                                    >
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-sm btn-icon">
                                            <i class="bx bx-edit"></i></button
                                        ><button
                                            class="btn btn-sm btn-icon delete-record"
                                        >
                                            <i class="bx bx-trash"></i></button
                                        ><button
                                            class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"
                                        >
                                            <i
                                                class="bx bx-dots-vertical-rounded"
                                            ></i>
                                        </button>
                                        <div
                                            class="dropdown-menu dropdown-menu-end m-0"
                                        >
                                            <a
                                                href="app-user-view-account.html"
                                                class="dropdown-item"
                                                >View</a
                                            ><a
                                                href="javascript:;"
                                                class="dropdown-item"
                                                >Suspend</a
                                            >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
            
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style lang=""></style>
