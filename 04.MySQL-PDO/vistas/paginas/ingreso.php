<div class="d-flex justify-content-center text-center">

	<form class="p-5 bg-light" method="post">

		<div class="form-group">

			<label for="email">Correo electrónico:</label>

			<div class="input-group">
				
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-envelope"></i>
					</span>
				</div>

				<input type="email" class="form-control" id="email" name="ingresoEmail">
			
			</div>
			
		</div>

		<div class="form-group">
			<label for="pwd">Contraseña:</label>

			<div class="input-group">
				
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="fas fa-lock"></i>
					</span>
				</div>

				<input type="password" class="form-control" id="pwd" name="ingresoPassword">

			</div>

		</div>

		<?php 
		// NOs interesa utilizar un método no estático, por lo que creo un nuevo objeto que utiliza el método ctrIngreso
		$ingreso = new ControladorFormularios();
		$ingreso -> ctrIngreso();
		
		// Usamos métodos no estáticos, como este último, para que se ejecuten directamente en el controlador

		// Usamos métodos estáticos para que ese objeto lo podemos reutilizar en la vista realizando otras acciones con ese objeto


		?>
		
		<button type="submit" class="btn btn-primary">Ingresar</button>

	</form>

</div>