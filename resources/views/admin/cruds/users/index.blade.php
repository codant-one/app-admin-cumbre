@extends('admin.layouts.master', [
'title' => 'Usuarios',
'breadcrumbs' => [
route('dashboard.index') => 'Inicio',
route('users.index') => 'Usuarios',
]
])

@section('content')

    @include('admin.cruds.users.partials.table-list')

@endsection

@section('scripts')

@php
    $edit_route = route("users.edit", ["user" => 'id-here']);
    $delete_route = route("users.destroy", ["user" => 'id-here']);
    $desbanuser_route = route("users.index", ["user" => 'id-here']);
@endphp

<script>
    $(document).ready(function () {

        //Initializate select2
        $('.roles').select2();
        $('.token').select2();

        var can = "{!!  auth()->user()->can('user_edit','user_delete') !!}";
         
        var columns;
        // if(can){
            columns = [
                { data: 'id' }, //Get ID for show checkbox selector
                { data: 'id' }, //Return ID in the ROW
                { data: 'firstname',
                  render : function(data, type, row, meta){
                    return data +' '+ row.lastname;
                } },
                { data: 'email' },
                { data: 'token_2fa' },
                { data: 'roles' },
                { data: null , orderable: false },
                { data: 'actions', orderable: false }
            ];
        // } else {
        //     columns = [
        //         { data: 'id' }, //Get ID for show checkbox selector
        //         { data: 'id' }, //Return ID in the ROW
        //         { data: 'firstname',
        //           render : function(data, type, row, meta){
        //             return data +' '+ row.lastname;
        //         } },
        //         { data: 'email' },
        //         { data: 'token_2fa' },
        //         { data: 'roles' },
        //         { data: null, visible: false },
        //         { data: 'actions', visible: false }
        //     ];
        // }
		const table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            ajax: {
                url: "{{ route('users.index') }}",
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
		                            <input class="form-check-input" type="checkbox" name="users[]" value="${data}" />
		                        </div>
                               `;
		                }
		            },
                    {
		                targets: 2,
		                render: function (data, type, row) {
		                   	const title = data.length > 25 ? `${data.slice(0, 25).replace(/\s+$/, '')}...` : data

		                    return `<a href="${ `{{ route("users.edit", ["user" => 'here']) }}`.replace('here', row.id) }" class="text-dark fw-bolder text-hover-primary fs-6">
		                                ${title}
		                            </a>`
		                }
		            },
                    {
		                targets: 4,
		                render: function (data, type, row) {
		                    return (
		                        	row.token_2fa ?
		                        '<span class="badge badge-light-success">Habilitado</span>' :
		                        '<span class="badge badge-light-danger">No habilitado</span>'
		                    )
		                }
		            },
                    {
		                targets: 5,
		                render: function (data, type, row) {
		                let badges = {
                                'SuperAdmin': '<span class="badge badge-light-primary fw-bolder">Super Admin</span>',
		                    	'Administrador': '<span class="badge badge-light-info fw-bolder">Administrador</span>',
		                    	'Operador': '<span class="badge badge-light-warning fw-bolder">Operador</span>',
                                'Cliente': '<span class="badge badge-light-success fw-bolder">Cliente</span>'
		                    }
		                    return badges[data[0].name] 
		                }
		            },
                    {
                        targets: 6,
                        render: function(data, type, row){

                            if(data['lastType'] == 1)
                                return `<i class='fas fa-exclamation-circle fs-7' data-bs-toggle='tooltip' title='${data['lastReason']}'></i></a><span class='ms-2 badge badge-light-dark fw-bolder'>Leve</span>`;
                            else if(data['lastType'] == 2)
                                return `<i class='fas fa-exclamation-circle fs-7' data-bs-toggle='tooltip' title='${data['lastReason']}'></i></a><span class='ms-2 badge badge-light-dark fw-bolder'>Indefinido</span>`;
                            else
                                return '';
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
                                                        <a href="{{ $edit_route }}" class="menu-link px-3 text-hover-inverse-light">
                                                            <span class="mx-3"><i class="fas fa-edit"></i></span>
                                                            Editar
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <form class="delete-form" method="POST" action="{{ $delete_route }}">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <a href="#" class="delete-item menu-link px-3 text-hover-inverse-light">
                                                                <span class="mx-3"><i class="fas fa-trash-alt"></i></span>
                                                                Eliminar
                                                            </a>
                                                        </form>
                                                    </div>`;
                            if(row.lastType !== null && row.lastType !== 1){
                                actionsHtml += `    <div class="menu-item px-3">
                                                        <a href="{{ $desbanuser_route }}" class="menu-link px-3 text-hover-inverse-light disabledUser">
                                                            <span class="mx-3"><i class="fas fa-user-unlock"></i></span>
                                                            Desbanear
                                                        </a>
                                                    </div>`;
                            }else if(row.lastType === 2){
                                var a = 0;
                                actionsHtml = `
                                            <div class="dropdown ">
                                                <div>`;
                            }
                                
                            actionsHtml += `    </div>
                                            </div>
                                            `;

                            let actions = actionsHtml.replaceAll('id-here', row.id).replaceAll('id-user', row.id);

                            return `${actions}`
                        },
                    }
                ],
            order: [[ 1, "desc" ]]
        });
	});
</script>
@endsection