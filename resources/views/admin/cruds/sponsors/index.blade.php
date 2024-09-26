@extends('admin.layouts.master', [
    'title' => 'Patrocinadores',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('sponsors.index') => 'Patrocinadores',
    ]
])

@section('content')

    @include('admin.cruds.sponsors.partials.table-list')

@endsection

@section('scripts')

@php
    $edit_route = route("sponsors.edit", ["sponsor" => 'id-here']);
    $delete_route = route("sponsors.destroy", ["sponsor" => 'id-here']);
@endphp

<script>
    $(document).ready(function () {

        //Initializate select2
        $('.categories').select2();

        columns = [
            { data: 'id' }, //Get ID for show checkbox selector
            { data: 'id' }, //Return ID in the ROW
            { data: 'logo' },
            { data: 'category.name_es' },
            { data: 'order_id' },
            { data: 'link' },
            { data: 'actions', orderable: false }
        ];

		const table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            ajax: {
                url: "{{ route('sponsors.index') }}",
                dataFilter: function(data){
                    var json = JSON.parse( data );
                    json.recordsTotal = json.last_page;
                    json.recordsFiltered = json.total;
        
                    return JSON.stringify( json );
                },
                data: function(data, settings){
                    const page = $('.table').DataTable().page.info().page;

                    for(let key in data.order){
                        const column = data.order[key].column;

                        data.order[key].column_name = settings.aoColumns[column].data;
                    }

                    data.page = page + 1;
                }
            },
            columns: columns,
            columnDefs: [
                    {
		                targets: 0,
		                orderable: false,
		                render: function (data) {
		                    return `
		                        <div class="form-check form-check-sm form-check-custom form-check-solid justify-content-center">
		                            <input class="form-check-input" type="checkbox" name="sponsors[]" value="${data}" />
		                        </div>
                               `;
		                }
		            },
                    {
		                targets: 2,
                        render: function (data, type, row) { 
                            let image = `{{ asset('storage/${row.logo}') }}`;
                            return `<img src="${image}" alt="" width="100" />`;
                        }
                    },
                    {
		                targets: 3,
		                render: function (data, type, row) {
                            return `<div class="badge badge-light-dark fs-8 fw-bolder">${row.category.name_es}</div>`
		                }
		            },
                    {
                        targets: -1,
                        data: null,
                        orderable: false,
                        className: 'text-end',
                        render: function (data, type, row) {

                            actionsHtml = `
                                            <div class="dropdown ">
                                                <a class="w-100px btn btn-light btn-active-white btn-sm" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acciones<i class="fas fa-angle-down"></i>
                                                </a>
                                                <div class="menu dropdown-menu w-50 menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 fw-bold fs-7 w-200px py-4" aria-labelledby="dropdownMenuButton1">`;
                            
                                actionsHtml+= `     <div class="menu-item px-3">
                                                        <a href="{{ $edit_route }}" class="menu-link px-3 bg-hover-pelorous">
                                                            <span class="mx-3"><i class="fas fa-edit"></i></span>
                                                            Editar
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <form class="delete-form" method="POST" action="{{ $delete_route }}">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <a href="#" class="delete-item menu-link px-3 bg-hover-pelorous">
                                                                <span class="mx-3"><i class="fas fa-trash-alt"></i></span>
                                                                Eliminar
                                                            </a>
                                                        </form>
                                                    </div>`;

                            let actions = actionsHtml.replaceAll('id-here', row.id);

                            return `${actions}`
                        },
                    }
                ],
            order: [[ 1, "desc" ]]
        });
	});
</script>
@endsection