<?php



if (isset($_GET['id'])) {
	$user = $conn->query('SELECT * FROM users where id =\'' . $_GET['id'] . '\' ');

	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}

if ($_settings->chk_flashdata('success')) {
	echo '<script>' . "\r\n\t" . 'alert("';
	echo $_settings->flashdata('success');
	echo '",\'success\')' . "\r\n" . '</script>' . "\r\n";
}

echo '<style>' . "\r\n\t" . '#cimg{max-width:100%;max-height:25em;object-fit:scale-down;object-position:center center}' . "\r\n" . '</style>' . "\r\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\r\n\t" . '<div class="container px-6 mx-auto grid">' . "\r\n\t\t" . '<h2' . "\r\n\t\t" . 'class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"' . "\r\n\t\t" . '>' . "\r\n\t\t";
echo (isset($id) ? 'Editar usuário' : 'Novo usuário');
echo ' <a href="./?page=user/list"><button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\r\n\t\t\t" . 'Voltar' . "\r\n\t\t" . '</button></a>' . "\r\n\t" . '</h2>' . "\r\n\r\n\r\n\t" . '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' . "\r\n\t\t\t" . '<form action="" id="manage-user">' . "\t\r\n\t\t\t\t" . '<input type="hidden" name="id" value="';
echo (isset($meta['id']) ? $meta['id'] : '');
echo '">' . "\t\t\t\t\r\n\t\t\t" . '<label class="block text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Nome</span>' . "\r\n\t\t\t\t" . '<input name="firstname" id="firstname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . 'required placeholder="Nome" value="';
echo (isset($meta['firstname']) ? $meta['firstname'] : '');
echo '"/>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n\r\n\t\t\t" . '<label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Sobrenome</span>' . "\r\n\t\t\t\t" . '<input name="lastname" id="lastname" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . 'required placeholder="Sobrenome" value="';
echo (isset($meta['lastname']) ? $meta['lastname'] : '');
echo '"/>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n\t\t\t" . '<label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">Usuário</span>' . "\r\n\t\t\t\t" . '<input name="username" id="username" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . 'required placeholder="Usuário" value="';
echo (isset($meta['username']) ? $meta['username'] : '');
echo '"/>' . "\r\n\t\t\t" . '</label>' . "\r\n\r\n\t\t\t" . '<label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">';
echo (isset($meta['id']) ? 'Nova' : '');
echo ' Senha</span>' . "\r\n\t\t\t\t" . '<input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"' . "\r\n\t\t\t\t" . ' value=""/>' . "\r\n\t\t\t\t" . '   ';

if (isset($meta['id'])) {
	echo "\t\t\t\t\t" . '<small class="text-gray-700 dark:text-gray-200"><i>Deixe em branco se não quiser alterar a senha.</i></small>' . "\r\n" . '                    ';
}

echo "\r\n\t\t\t" . '</label>' . "\r\n\r\n\t\t\t";

if ($_settings->userdata('type') == '1') {
	echo "\t\t\t" . '<label class="block mt-4 text-sm">' . "\r\n\t\t\t\t" . '<span class="text-gray-700 dark:text-gray-400">' . "\r\n\t\t\t\t\t" . 'Tipo de usuário' . "\r\n\t\t\t\t" . '</span>' . "\r\n\t\t\t\t" . '<select name="type" id="type"' . "\r\n\t\t\t\t\t" . 'class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"' . "\r\n\t\t\t\t\t" . '>' . "\r\n\t\t\t\t\t" . '<option value="1" ';
	echo (isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '');
	echo '>Administrador</option>' . "\r\n\t\t\t\t\t" . '<option value="2" ';
	echo (isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '');
	echo '>Staff</option>' . "\r\n\t\t\t\t" . '</select>' . "\r\n\t\t\t" . '</label>' . "\r\n\t\t\t";
}

echo "\r\n\r\n\r\n\r\n" . '<label class="block mt-4 text-sm">' . "\r\n\t" . '<span class="text-gray-700 dark:text-gray-400">Imagem</span>' . "\r\n\t" . '<input id="customFile" name="img" onchange="displayImg(this,$(this))" type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"  accept="image/png, image/jpeg">' . "\r\n" . '</label>' . "\r\n\r\n" . '<label class="block mt-4 text-sm">' . "\r\n\t" . '<img src="';
echo validate_image((isset($meta['avatar']) ? $meta['avatar'] : ''));
echo '" alt="" id="cimg" class="img-fluid img-thumbnail">' . "\r\n" . '</div>' . "\r\n\r\n\r\n" . '<div class="text-center">' . "\r\n\t" . '<button form="manage-user" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' . "\r\n\t\t" . 'Salvar' . "\r\n\t" . '</button>' . "\r\n" . '</div>' . "\r\n\r\n" . '</main>' . "\r\n\r\n" . '<script>' . "\r\n\t" . 'function displayImg(input,_this) {' . "\r\n\t" . '    if (input.files && input.files[0]) {' . "\r\n\t" . '        var reader = new FileReader();' . "\r\n\t" . '        reader.onload = function (e) {' . "\r\n\t" . '        ' . "\t" . '$(\'#cimg\').attr(\'src\', e.target.result);' . "\r\n\t" . '        }' . "\r\n\r\n\t" . '        reader.readAsDataURL(input.files[0]);' . "\r\n\t" . '    }else{' . "\r\n\t\t\t" . '$(\'#cimg\').attr(\'src\', "';
echo validate_image((isset($meta['avatar']) ? $meta['avatar'] : ''));
echo '");' . "\r\n\t\t" . '}' . "\r\n\t" . '}' . "\r\n\t" . '$(\'#manage-user\').submit(function(e){' . "\r\n\t\t" . 'e.preventDefault();' . "\r\n\t\t" . '$.ajax({' . "\r\n\t\t\t" . 'url:_base_url_+\'class/Customer.php?action=save_system\',' . "\r\n\t\t\t" . 'data: new FormData($(this)[0]),' . "\r\n\t\t" . '    cache: false,' . "\r\n\t\t" . '    contentType: false,' . "\r\n\t\t" . '    processData: false,' . "\r\n\t\t" . '    method: \'POST\',' . "\r\n\t\t" . '    type: \'POST\',' . "\r\n\t\t\t" . 'success:function(resp){' . "\r\n\t\t\t\t" . 'if(resp == 1){' . "\r\n\t\t\t\t\t" . 'alert(\'Usuário cadastrado com sucesso!\');' . "\r\n\t\t\t\t\t" . 'location.href=\'./?page=user/list\';' . "\r\n\t\t\t\t" . '} else if (resp == 3){' . "\r\n\t\t\t\t\t" . 'alert(\'Verifique os campos e tente novamente.\');' . "\r\n\t\t\t\t" . '} else if (resp == 4){' . "\r\n\t\t\t\t\t" . 'alert(\'Usuário atualizado com sucesso!\');' . "\r\n\t\t\t\t\t" . 'location.href=\'./?page=user/list\';' . "\r\n\t\t\t\t" . '} else {' . "\r\n\t\t\t\t\t" . 'alert(\'Nome de usuário em uso!\');' . "\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '})' . "\r\n\t" . '})' . "\r\n\r\n" . '</script>';

?>