<?php require_once('../settings.php') ?>

<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php')){
  redirect('admin/login.php');
}
if(isset($_SESSION['userdata']) && strpos($link, 'login.php')){
  redirect('admin/index.php');
}
$module = array('','dashboard','');
if(isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'admin/')) && $_SESSION['userdata']['login_type'] !=  1){
  echo "<script>alert('Access Denied!');location.replace('".BASE_URL."admin');</script>";
    exit;
} 

?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
  rel="stylesheet"
  />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>admin/assets/css/tailwind.output.css" />
  <script src="<?php echo BASE_URL ?>libs/jquery/jquery.min.js"></script>

  <script
  src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
  defer
  ></script>

  <script src="<?php echo BASE_URL ?>admin/assets/js/init-alpine.js"></script>
  <script>
    var _base_url_ = '<?php echo BASE_URL ?>';
     var _base_domain_ = '<?php echo BASE_DOMAIN ?>';
  </script>
    <script src="<?php echo BASE_URL ?>admin/assets/js/script.js"></script>
</head>
<body>
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div
    class="flex-1 h-full max-w-2xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
     style="max-width:25rem;">
    <div class="overflow-y-auto">
      <div class="flex items-center justify-center p-6 md:grid-cols-2 xl:grid-cols-2">
        <div class="w-full">
          <h1
          class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
          >
          Login
        </h1>
        <form id="login-frm" action="" method="post">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Usuário</span>
            <input type="email" name="email" id="email" autofocus
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Informe o usuário"
            />
          </label>
          <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Senha</span>
            <input name="password" id="password"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="***************"
            type="password"
            />
          </label>

          <button type="submit"
          class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"

          >
          Login
        </button>
      </form>

      <p class="mt-4">
        <a
        class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
        href="#"
        >
        Recuperar senha?
      </a>
    </p>

  </div>
</div>
</div>
</div>
</div>

<script>
// Função para obter um cookie pelo nome
function getCookie(name) {
    const cookieArr = document.cookie.split('; ');
    for (const cookie of cookieArr) {
        const [key, value] = cookie.split('=');
        if (name === key.trim()) {
            return decodeURIComponent(value);
        }
    }
    return null;
}

$(document).ready(function() {
    // Obtendo o token CSRF
    fetch(_base_domain_ + "sanctum/csrf-cookie", { method: 'GET' })
    .then(() => {
        const token = getCookie('XSRF-TOKEN');

        if (token) {
            let email = $('#email');
            let password = $('#password');

            // Manuseio do formulário de login
            $('#login-frm').submit(function(e) {
                e.preventDefault();
                
                const _this = $(this);
                const el = $('<div>').addClass('alert alert-dark err_msg').hide();
                $('.err_msg').remove();

                $.ajax({
                    url: _base_domain_ + "entrar",
                    method: 'POST',
                    headers: {
                        'X-XSRF-TOKEN': token,
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: JSON.stringify({ email: email.val(), password: password.val() }),
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: function(err) {
                        console.log(err);
                        alert('An error occurred');
                    },
                    success: function(resp) {
                        if (resp.status === 'success') {
                            console.log(resp);
                            location.href = './';
                        } else if (resp.msg) {
                            el.html(resp.msg).show('slow');
                            _this.prepend(el);
                            $('html, body').scrollTop(0);
                        } else {
                            alert('An error occurred');
                            console.log(resp);
                        }
                    }
                });
            });
        } else {
            console.error('CSRF token not found.');
            alert('An error occurred');
        }
    })
    .catch(error => {
        console.error('Error setting CSRF token:', error);
        alert('An error occurred');
    });
});

</script>
</body>
</html>


