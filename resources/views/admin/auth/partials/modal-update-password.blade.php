<div class="modal fade" id="update_password" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="fw-bolder">Actualizar Contraseña</h2>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
					<span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
								<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
								<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
							</g>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
				<div class="fv-row mb-10">
					<label class="required form-label fs-6 mb-2">Contraseña actual</label>
					<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="current_password" autocomplete="off" required/>
				</div>
				<div class="mb-10 fv-row" data-kt-password-meter="true">
					<div class="mb-1">
						<label class="form-label fw-bold fs-6 mb-2">Nueva Contraseña</label>
						<div class="position-relative mb-3">
							<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" />
							<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
								<i class="bi bi-eye-slash fs-2"></i>
								<i class="bi bi-eye fs-2 d-none"></i>
							</span>
						</div>
						<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
							<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
							<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
							<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
							<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
						</div>
					</div>
					<div class="text-muted">Use 8 o más caracteres con una combinación de letras, números &amp; símbolos.</div>
				</div>
				<div class="fv-row mb-10">
					<label class="form-label fw-bold fs-6 mb-2">Confirmar nueva contraseña</label>
					<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
				</div>
			</div>
            <div class="modal-footer">
				<button type="reset" class="btn btn-light me-3 form-modal-dismiss">Descartar</button>
				<button type="submit" id="kt_modal_submit" class="btn btn-info"  data-kt-users-modal-action="submit">
					<span class="indicator-label">Registrar</span>
					<span class="indicator-progress">Cargando...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div> 
		</div>
	</div>
</div>