<div class="tab-pane fade" id="security" role="tabpanel">
	<div class="card mb-5 mb-xl-10">
		<div class="card-header cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Detalles del Perfil</h3>
			</div>
		</div>
		<div class="card-body p-9">
            <div class="table-responsive">
				<table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
					<tbody class="fs-6 fw-bold text-gray-600">
						<tr>
							<td>Correo</td>
							<td>{{ auth()->user()->email }}</td>
							<td class="text-end"></td>
						</tr>
						<tr>
							<td>Contraseña</td>
							<td>********</td>
							<td class="text-end">
								<a 
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                    href="javascript:void(0);"
                                    onclick="modalShow('#update_password','{{ route("dashboard.index") }}');">
									<span class="svg-icon svg-icon-3">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<rect opacity="0.25" x="3" y="21" width="18" height="2" rx="1" fill="#191213" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M4.08576 11.5L3.58579 12C3.21071 12.375 3 12.8838 3 13.4142V17C3 18.1045 3.89543 19 5 19H8.58579C9.11622 19 9.62493 18.7893 10 18.4142L10.5 17.9142L4.08576 11.5Z" fill="#121319" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10.0858L11.5858 4L18 10.4142L11.9142 16.5L5.5 10.0858Z" fill="#121319" />
											<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M18.1214 1.70705C16.9498 0.535476 15.0503 0.535476 13.8787 1.70705L13 2.58576L19.4142 8.99997L20.2929 8.12126C21.4645 6.94969 21.4645 5.0502 20.2929 3.87862L18.1214 1.70705Z" fill="#191213" />
										</svg>
									</span>
                                </a>
							</td>
						</tr>
						<tr>
                            <td>Rol</td>
                            <td>{{ auth()->user()->getRoleNames()[0] }}</td>
                            <td class="text-end"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>