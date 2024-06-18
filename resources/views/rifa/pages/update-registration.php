<?php
include app_path('Includes/settings.php');
$settings = [
	'enable_cpf' => $_settings->info('enable_cpf'),
	'enable_email' => $_settings->info('enable_email'),
	'enable_address' => $_settings->info('enable_address'),
	'enable_password' => $_settings->info('enable_password'),
	'enable_two_phone' => $_settings->info('enable_two_phone'),
	'enable_birth' => $_settings->info('enable_birth'),
	'enable_instagram' => $_settings->info('enable_instagram')
];

$userId = $_settings->userdata('id');
if ($userId != '') {
	$qry = $conn->query('SELECT * FROM `customer_list` WHERE id = \'' . $userId . '\'');
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_array() as $k => $v) {
			if (!is_numeric($k)) {
				$$k = $v;
			}
		}
	}
} else {
	echo '<script>alert("Você não tem permissão para acessar essa página"); location.replace("/");</script>';
	exit();
}

function renderInput($type, $name, $label, $placeholder, $value, $required = true, $additionalAttributes = '')
{
	$requiredAttr = $required ? 'required' : '';
	return "
    <div class='mb-2'>
        <label for='{$name}' class='form-label'>{$label}</label>
        <input type='{$type}' name='{$name}' class='form-control text-black' id='{$name}' placeholder='{$placeholder}' value='{$value}' {$requiredAttr} {$additionalAttributes}>
    </div>
    ";
}

?>

<div class="container app-main app-form">
	<form id="form-cadastro" method="post" action=".">
		<div class="perfil app-card card mb-2">
			<div class="rounded-pill mt-2 mb-2" style="margin-inline: auto; width: 180px; height: 180px; position: relative; overflow: hidden;">
				<img id="cimg" alt="" src="<?php echo validate_image(isset($avatar) ? $avatar : ''); ?>" class="img-fluid" decoding="async" data-nimg="fill">
			</div>
			<div style="margin-inline:auto; padding: 0 10px 0 10px">
				<input id="customFile" name="img" onchange="displayImg(this,$(this))" type="file" accept=".png, .jpg, .jpeg">
			</div>
			<div class="card-body">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
				<?php
				echo renderInput('text', 'firstname', 'Nome', 'Primeiro nome', isset($firstname) ? $firstname : '', true);
				echo renderInput('text', 'lastname', 'Sobrenome', 'Sobrenome', isset($lastname) ? $lastname : '', true);

				if ($settings['enable_cpf'] == 1) {
					echo renderInput('text', 'cpf', 'CPF', '000.000.000-00', isset($cpf) ? $cpf : '', true, 'maxlength="14" minlength="14" oninput="formatarCPF(this.value)"');
				}

				if ($settings['enable_email'] == 1) {
					echo renderInput('email', 'email', 'E-mail', 'exemplo@exemplo.com', isset($email) ? $email : '');
				}
				?>
				<div class="mb-2">
					<label for="phone" class="form-label">Telefone</label>
					<input readonly onkeyup="formatarTEL(this);" class="form-control text-black mb-2" name="phone" id="phone" maxlength="15" required value="<?php echo isset($phone) ? formatPhoneNumber($phone) : ''; ?>" style="background-color: #eeee;">
				</div>

				<?php
				if ($settings['enable_birth'] == 1) {
					echo renderInput('date', 'birth', 'Data de nascimento', '', isset($birth) ? $birth : '');
				}

				if ($settings['enable_instagram'] == 1) {
					echo renderInput('text', 'instagram', 'Instagram', '@usuario', isset($instagram) ? $instagram : '');
				}
				?>
			</div>
		</div>

		<?php if ($settings['enable_address']) : ?>
			<div class="endereco app-card card mb-2">
				<div class="card-body">
					<?php
					echo renderInput('text', 'zipcode', 'CEP', '', isset($zipcode) ? $zipcode : '', false, 'onkeyup="handleZipCode(event)" onblur="pesquisacep(this.value);" maxlength="9" size="10"');
					echo renderInput('text', 'address', 'Endereço', '', isset($address) ? $address : '');
					echo renderInput('text', 'number', 'Número', '', isset($number) ? $number : '');
					echo renderInput('text', 'neighborhood', 'Bairro', '', isset($neighborhood) ? $neighborhood : '');
					echo renderInput('text', 'complement', 'Complemento', '', isset($complement) ? $complement : '');
					?>
					<div class="mb-2">
						<label for="state" class="form-label">Estado</label>
						<select class="form-select text-black" name="state" id="state">
							<option value="">-- Estado --</option>
							<?php
							$states = ["AC" => "Acre", "AL" => "Alagoas", "AP" => "Amapá", "AM" => "Amazonas", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraiba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RS" => "Rio Grande do Sul", "RO" => "Rondônia", "RR" => "Roraima", "SC" => "Santa Catarina", "SP" => "São Paulo", "SE" => "Sergipe", "TO" => "Tocantins"];
							foreach ($states as $abbr => $name) {
								$selected = isset($state) && $state == $abbr ? 'selected' : '';
								echo "<option value='{$abbr}' {$selected}>{$name}</option>";
							}
							?>
						</select>
					</div>
					<?php
					echo renderInput('text', 'city', 'Cidade', '', isset($city) ? $city : '', false, 'size="40"');
					echo renderInput('text', 'reference_point', 'Ponto de referência', '', isset($reference_point) ? $reference_point : '');
					?>
				</div>
			</div>
		<?php endif; ?>

		<button type="submit" class="btn btn-secondary btn-wide">Salvar</button>
	</form>
</div>

<script>
	var fileInput = document.getElementById("customFile");
	var allowedExtensions = [".jpg", ".jpeg", ".png"];

	fileInput.addEventListener("change", function() {
		var hasInvalidFiles = Array.from(this.files).some(file => {
			return !allowedExtensions.some(ext => file.name.endsWith(ext));
		});
		if (hasInvalidFiles) {
			fileInput.value = "";
			alert("Unsupported file selected.");
		}
	});

	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		} else {
			$('#cimg').attr('src', "<?php echo validate_image(isset($avatar) ? $avatar : ''); ?>");
		}
	}

	const handleZipCode = (event) => {
		let input = event.target;
		input.value = zipCodeMask(input.value);
	}

	const zipCodeMask = (value) => {
		if (!value) return "";
		value = value.replace(/\D/g, '');
		value = value.replace(/(\d{5})(\d)/, '$1-$2');
		return value;
	}

	function limpa_formulário_cep() {
		document.getElementById('address').value = "";
		document.getElementById('neighborhood').value = "";
		document.getElementById('city').value = "";
		document.getElementById('state').value = "";
	}

	function meu_callback(conteudo) {
		if (!("erro" in conteudo)) {
			document.getElementById('address').value = conteudo.logradouro;
			document.getElementById('neighborhood').value = conteudo.bairro;
			document.getElementById('city').value = conteudo.localidade;
			document.getElementById('state').value = conteudo.uf;
		} else {
			limpa_formulário_cep();
			alert("CEP não encontrado.");
		}
	}

	function pesquisacep(valor) {
		var cep = valor.replace(/\D/g, '');
		if (cep != "") {
			var validacep = /^[0-9]{8}$/;
			if (validacep.test(cep)) {
				document.getElementById('address').value = "...";
				document.getElementById('neighborhood').value = "...";
				document.getElementById('city').value = "...";
				document.getElementById('state').value = "...";
				var script = document.createElement('script');
				script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
				document.body.appendChild(script);
			} else {
				limpa_formulário_cep();
				alert("Formato de CEP inválido.");
			}
		} else {
			limpa_formulário_cep();
		}
	}


	$(document).ready(function() {
		$('#form-cadastro').submit(function(e) {
			console.log(e)
			e.preventDefault()
			var phoneValue = $('#phone').val();

			$.ajax({
				url: _base_url_ + "customer/Customer.php?action=update_customer",
				method: 'POST',
				type: 'POST',
				data: new FormData($(this)[0]),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				error: err => {
					console.log(err)
					alert('An error occurred')
				},
				success: function(resp) {
					console.log(resp)
					if (resp.status == 'success') {
						alert('Dados atualizados com sucessso.');
						location.reload();
					} else if (resp.status == 'phone_already') {
						alert('Este telefone já está cadastrado.');
					} else if (resp.status == 'cpf_already') {
						alert('Este CPF já está cadastrado.');
					} else if (resp.status == 'cpf_invalid') {
						alert(resp.msg);
					} else if (!!resp.msg) {
						el.html(resp.msg)
						el.show('slow')
						_this.prepend(el)
					} else {
						alert('An error occurred')
						console.log(resp)
					}
				}
			})
		})
	})
</script>