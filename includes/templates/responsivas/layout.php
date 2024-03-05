<?php
    use App\Responsivas;
    $responsivas = Responsivas::all();
?>

	<article class="consultas" id="layout">

		<div id="tabla_filter" class="dataTables_filter">
			<label>Busqueda por tag:</label>
            <input 
                type="search" 
                id="searchTerm" 
                class="input-busc" 
                placeholder=""
                onkeyup="doSearch()" 
                name="buscador" 
                aria-controls="tabla"
            >
		</div>

		<div class="opciones-d">
			<div class="d actualizar" onclick="generaResponsiva()"><a href="#">Genera Responsiva</a></div>
			<div class="d actualizar" onclick="subirResponsiva()"><a href="#">Subir responsiva</a></div>
			<div class="d actualizar">
                <a href="https://cn257.awmdm.com/AirWatch/Login?ReturnUrl=%2FAirWatch%2F#/Monitor" target="_blank">Airwatch</a>
            </div>
		</div>

	</article>

	<article class="tabla">
		<table id="tabla" class="table table-hover">
			<thead class="encabezado2">
				<tr>
					<th>TAG</th>
					<th>OFICINA</th>
					<th>DEVUSER</th>
					<th>FECHA ENTREGA</th>
					<th>ESTATUS</th>
					<th>QUIEN ATENDIÓ</th>
					<th>RESPONSIVA</th>
				</tr>
			</thead>
			<tbody class="tabladato">
				<?php foreach($responsivas as $responsiva): ?>
				<tr>
					<td>
						<?php echo $responsiva->tag ?>
					</td>
					<td>
						<?php echo $responsiva->oficina?>
					</td>
					<td>
						<?php echo $responsiva->devuser?>
					</td>
					<td>
						<?php echo $responsiva->fecha_entrega?>
					</td>
					<td>
						<?php echo $responsiva->estatus?>
					</td>
					<td>
						<?php echo $responsiva->usersis?>
					</td>
					<td>
						<img src="/mv2/img/pdf-icon.png" alt="Ver Archivo" class="lzy lazyload--done" width="26" onclick="abrirResponsiva('<?php echo $responsiva->responsiva; ?>')">
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
	</article>