<?php

$enable_hide_numbers = $_settings->info('enable_hide_numbers');
$enable_cpf = $_settings->info('enable_cpf');

$search_type = ($enable_cpf == 1) ? 'search_orders_by_cpf' : 'search_orders_by_phone';
?>

<div class="container app-main">
	<div class="mb-3">
		<div class="row justify-content-between w-100 align-items-center">
			<div class="col">
				<div class="app-title">
					<h1>🛒 Meus números</h1>
				</div>
			</div>
			<div class="col-auto text-end">
				<button id="find" type="button" data-bs-toggle="modal" data-bs-target="#modal-buscar" class="btn btn-primary btn-sm">
					<i class="bi bi-search"></i> Buscar
				</button>
			</div>
		</div>
	</div>
	<form id="modal-buscar" class="modal fade" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-sm modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Buscar compras</h5>
				</div>
				<div class="modal-body">
					<?php if ($enable_cpf != 1) { ?>
						<div class="form-group mb-3">
							<label class="form-label">Informe seu telefone</label>
							<input onkeyup="formatarTEL(this);" maxlength="15" name="phone" required class="form-control" value="">
						</div>
					<?php } else { ?>
						<div class="form-group mb-3">
							<label class="form-label">Informe seu CPF</label>
							<input name="cpf" class="form-control" id="cpf" value="" maxlength="14" minlength="14" placeholder="000.000.000-00" oninput="formatarCPF(this.value)" required>
						</div>
					<?php } ?>
					<div class="text-end">
						<button type="submit" class="btn btn-primary">Buscar compras</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="alert alert-warning">
		<i class="bi bi-exclamation-triangle"></i> Clique em buscar para localizar suas compras
	</div>
	<div>
		<?php
		$i = 1;
		$phone = (isset($_SESSION['phone']) ? $_SESSION['phone'] : '');
		$cpf = (isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '123');

		if ($enable_cpf != 1) {
			$phone = $conn->real_escape_string($phone);
			$phoneQuery = $conn->query("SELECT id FROM customer_list WHERE phone = '$phone'");
		} else {
			$cpf = $conn->real_escape_string($cpf);
			$phoneQuery = $conn->query("SELECT id FROM customer_list WHERE cpf = '$cpf'");
		}

		if ($phoneQuery && $phoneQuery->num_rows > 0) {
			$customerId = $phoneQuery->fetch_assoc()['id'];
			$orders = $conn->query("SELECT o.*, p.image_path, p.qty_numbers, o.product_id, p.type_of_draw 
                                    FROM `order_list` o 
                                    INNER JOIN `product_list` p ON o.product_id = p.id 
                                    WHERE o.customer_id = '$customerId' 
                                    ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC");

			if ($orders && $orders->num_rows > 0) {
				while ($orderRow = $orders->fetch_assoc()) {
					$class = '';
					$border = '';
					$btn = '';
					$status = $orderRow['status'];

					if ($orderRow['status'] == '1') {
						$class = 'bg-warning';
						$border = 'border-warning';
						$btn = 'btn-warning';
					}

					if ($orderRow['status'] == '2') {
						$class = 'bg-success';
						$border = 'border-success';
						$btn = 'btn-success';
					}

					if ($orderRow['status'] == '3') {
						$class = 'bg-danger';
						$border = 'border-danger';
						$btn = 'btn-danger';
					}
		?>
					<div class="card app-card mb-2 pointer border-bottom border-2 <?php echo $border; ?>">
						<div class="card-body">
							<div class="row align-items-center row-gutter-sm">
								<div class="col-auto">
									<div class="position-relative rounded-pill overflow-hidden box-shadow-08" style="width: 56px; height: 56px;">
										<div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
											<img src="<?php echo validate_image($orderRow['image_path']); ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
										</div>
									</div>
								</div>
								<div class="col ps-2">
									<div class="compra-title font-weight-500"><?php echo $orderRow['product_name']; ?></div>
									<small class="compra-data font-xss opacity-50 text-uppercase">
										<i class="bi bi-calendar4-week"></i> <?php echo date('d-m-Y H:i', strtotime($orderRow['date_created'])); ?>
									</small>
									
								</div>
								<div class="col-12 pt-2">
									<a href="/compra/<?php echo $orderRow['order_token']; ?>" >
										<span class="btn <?php echo $btn; ?> btn-sm p-1 px-2 w-100 font-xss">
											<?php
											if ($status == '1') {
												echo 'Efetuar pagamento';
											}

											if ($status == '2') {
												echo 'Visualizar compra';
											}

											if ($status == '3') {
												echo 'Compra cancelada';
											}
											?>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
		<?php
				}
			}
		}
		?>
	</div>
</div>
<script>
	document.addEventListener('livewire:navigated', () => { 
		var tipo = "<?php echo $status; ?>";
		if (!tipo) {
			$('#find').click();
		}
	});
	$(document).ready(function() {
		var tipo = "<?php echo $search_type; ?>";
		$('#modal-buscar').submit(function(e) {
			e.preventDefault()
			$.ajax({
				url: _base_url_ + "class/Main.php?action=" + tipo,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: 'POST',
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				error: err => {
					console.log(err)
					alert('An error occurred')
				},
				success: function(resp) {
					if (resp.status == 'success') {
						location.href = resp.redirect
					} else {
						alert('Nenhum registro de compra foi encontrado')
						console.log(resp)
					}
				}
			})
		})
	})
</script>