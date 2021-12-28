<!--=====================================
MENU
======================================-->

<div class="container-fluid menu">

	<a href="#" class="btnClose">X</a>

	<ul class="nav flex-column text-center">

		<?php foreach ($categorias as $key => $valor) : ?>
			<li class="nav-item">

				<a class="nav-link text-white" href="<?php echo $valor["ruta_categoria"];?>"><?php echo $valor['descripcion_categoria']; ?></a>

			</li>

		<?php endforeach ?>		

	</ul>

</div>