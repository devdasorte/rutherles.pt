<?php
include app_path('Includes/settings.php');
?>

<div class="container app-main app-form">
   <div class="app-title mb-2">
      <h1>✉️ Contato</h1>
      <div class="app-title-desc">Tire suas dúvidas.</div>
   </div>
   <form id="form-contact">
      <div class="app-card card mb-2">
         <div class="card-body">
            <div class="mb-2">
               <label class="form-label">Nome</label>
               <input type="text" name="nome" id="nome" class="form-control text-black" required="">
            </div>
            <div class="mb-2">
               <label class="form-label">Email</label>
               <input type="email" maxlength="50" name="email" id="email" class="form-control text-black" required="" value="">
            </div>
            <div class="mb-2">
               <label class="form-label">Telefone</label>
               <input onkeyup="formatarTEL(this);" maxlength="15" name="telefone" id="telefone" class="form-control text-black" required="" value="">
            </div>
            <div class="mb-2">
               <label class="form-label">Campanha</label>
               <select name="campanha" id="campanha" class="form-control text-black" required="">
                  <option>Deseja falar sobre uma campanha?</option>
                  <?php
                  $qry = $conn->query('SELECT * from `product_list` order by id desc');
                  if ($qry->num_rows > 0) {
                     while ($row = $qry->fetch_assoc()) {
                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                     }
                  }
                  ?>
               </select>
            </div>
            <div class="mb-2">
               <label class="form-label">Assunto</label>
               <select name="assunto" id="assunto" class="form-control text-black" required="">
                  <option>Outro(s)</option>
                  <option>Problemas com cadastro</option>
                  <option>Problemas com compras</option>
                  <option>Quero ser parceiro</option>
                  <option>Recuperar senha</option>
               </select>
            </div>
            <div class="mb-2">
               <label class="form-label">Mensagem</label>
               <textarea type="text" minlength="20" name="mensagem" id="mensagem" class="form-control mb-1 text-black" required="" rows="6"></textarea>
               <small class="text-muted font-xss">mínimo de 20 caracteres</small>
            </div>
         </div>
      </div>
      <div class="text-end">
         <button type="submit" class="btn btn-primary btn-wide">Enviar <i class="bi bi-arrow-right"></i></button>
      </div>
   </form>
</div>
<script>
   $(document).ready(function () {
      $('#form-contact').submit(function (e) {
         e.preventDefault();

         $.ajax({
            url: _base_url_ + "class/Main.php?action=contact_send_email",
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
            success: function (resp) {
               if (resp.status == 'success') {
                  alert('Email enviado com sucesso.');
                  location.href = ('./')
               } else {
                  alert('An error occurred')
                  console.log(resp)
               }
            }
         })
      })
   })
</script>
