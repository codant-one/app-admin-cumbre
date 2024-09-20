<div class="container">
    <div class="card">
		<div class="card-header border-0 pt-6">
            <div class="pt-0 table-responsive w-100">
                <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6" style="width:100%">
                    <thead class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <tr>
                            <th class="w-10px pe-2">
                                @can('bank_delete')
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1"/>
                                </div>
                                @endcan
                            </th>
                            <th class="w-60px">ID</th>
                            <th class="w-800px">Rol</th>
                            <th class="w-100px">Creado</th>
                            <th class="text-end min-w-100px">Acciones</th>
                        </tr>
                        <tr>
                            <th class="d-flex justify-content-center">
                                @can('bank_delete')
                                <a class="btn my-4 p-0  d-block deleteAll" title="Eliminar múltiples roles">
                                    <span><i class="fa fa-solid fa-trash text-danger fs-2"></i></span>
                                </a>
                                @endcan
                            </th>
                            <th>
                                <input type="number" min="1" class="form-control d-block" placeholder="ID">
                            </th>
                            <th>
                                <input type="text" class="form-control" placeholder="ROL">
                            </th>
                            <th>
                                <input type="date" class="form-control" placeholder="Creado">
                            </th>
                            <th class="text-end min-w-100px">
                                <button class="btn btn-info btn-reset">Limpiar</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>