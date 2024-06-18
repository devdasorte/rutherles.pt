<?php

include app_path('Includes/settings.php');

if ($_settings->userdata('id') != '') {
    $qry = $conn->query('SELECT * FROM `customer_list` WHERE id = \'' . $_settings->userdata('id') . '\'');

    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
} else {
    echo '<script>alert(\'Você não tem permissão para acessar essa página\'); location.replace(\'/\');</script>';
    exit();
}
?>

<div class="container app-main app-form">
    <form autocomplete="off" id="form-change-password">
        <div class="alteracao-de-senha app-card card mb-2">
            <div class="card-body">
                <div class="mb-2">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control text-black" id="password" autocomplete="off" placeholder="Digite sua senha" required="" minlength="5" maxlength="20">
                </div>
                <div>
                    <label for="csenha" class="form-label">Confirmação de senha</label>
                    <input type="password" name="rpassword" class="form-control text-black" id="cpassword" placeholder="Confirme sua senha" required="" minlength="5" maxlength="20">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary btn-wide">Alterar</button>
    </form>
</div>

<script>
  $(document).ready(function(){
    $('#form-change-password').submit(function(e){
        e.preventDefault()
        var _this = $(this)
        var el = $('<div>')
            el.addClass('alert alert-dark err_msg')
            el.hide()
        $('.err_msg').remove()
              
        $.ajax({
            url: _base_url_ + "customer/Customer.php?action=change_password_system",
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
            success: function(resp){
                if(resp.status == 'success'){
                  alert('Senha alterada com sucesso.');
                  //location.href = ('./')
                } else if (!!resp.msg){
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
