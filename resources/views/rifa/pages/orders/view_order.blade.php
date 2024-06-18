<?php
use Illuminate\Support\Facades\Cache;
use App\Models\OrderItem;
include app_path('Includes/settings.php');
$conn = $_settings->conn;
$settings = $_settings;
$orderitem = Cache::remember("orderitem_{$id}", 60, function () use ($id) {
    return OrderItem::where('order_token', $id)->first();
});
$status = $orderitem->status;

$product = $conn->query("SELECT cotas_premiadas, type_of_draw, cotas_premiadas_premios FROM `product_list` where id = '{$orderitem->product_id}'");
$product = $product->fetch_assoc();
$type_of_draw = $product['type_of_draw'];
$cotas_p = $product['cotas_premiadas'];
$cotas_premiadas_premios = $product['cotas_premiadas_premios'];
$deserialized = [];
  $pairs = explode(',', $cotas_premiadas_premios);
  foreach ($pairs as $pair) {
      list($key, $value) = explode(':', $pair, 2);
      $deserialized[$key] = $value;
  }
$cotas_array = $deserialized;
$cotas_premiadas = explode(',', $cotas_p);
$my_numbers = 0;
$my_numbers = $orderitem->order_numbers;
$my_numbers = explode(',', $my_numbers);

// Inicialize a página atual com base no parâmetro da URL ou padrão para 1
$current_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

// Defina o limite de itens por página
$limit = 100;

// Calcule o offset para array_slice
$offset = ($current_page - 1) * $limit;

// Faça o slicing do array com base no offset e limite
$sliced_numbers = array_slice($my_numbers, $offset, $limit);






$whatsapp = $_settings->info('phone');

$enable_hide_numbers = $_settings->info('enable_hide_numbers');
if (isset($id) && $id > 0) {
    $qry = $conn->query("SELECT *  from `order_list` where order_token = '{$id}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
        $customer_id = $customer_id;
    } else {
        echo "<script>alert('Você não tem permissão para acessar essa página.'); 
   location.replace('/');</script>";
        exit();
    }
} else {
    echo "<script>alert('Você não tem permissão para acessar essa página.'); 
   location.replace('/');</script>";
    exit();
}
?>
<div class="app-main container">
    <div class="compra-status">
        <?php if ($status == "1") { ?>
        <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-check-circle text-warning"></i>
            <div class="app-alerta-msg--txt">
                <h3 class="app-alerta-msg--titulo">Aguardando Pagamento!</h3>
                <p>Finalize o pagamento</p>
            </div>
        </div>
        <?php } ?>

        <?php if ($status == "2") { ?>
        <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-check-circle text-success"></i>
            <div class="app-alerta-msg--txt">
                <h3 class="app-alerta-msg--titulo">Compra Aprovada!</h3>
                <p>Agora é só torcer!</p>
            </div>
        </div>
        <?php } ?>

        <?php if ($status == "3") { ?>
        <div class="app-alerta-msg mb-2">
            <i style="color:red" class="app-alerta-msg--icone bi bi-x-circle"></i>
            <div class="app-alerta-msg--txt">
                <h3 class="app-alerta-msg--titulo">Pedido cancelado!</h3>
                <p>O prazo para pagamento do seu pedido expirou.</p>
            </div>
        </div>
        <?php } ?>

        <hr class="my-2">
    </div>
    <?php if ($status == "1") { ?>
    <div class="compra-pagamento">
        <div class="pagamentoQrCode text-center">
            <div class="pagamento-rapido">
                <div class="app-card card rounded-top rounded-0 shadow-none border-bottom">
                    <div class="card-body">
                        <div class="pagamento-rapido--progress">
                            <div class="d-flex justify-content-center align-items-center mb-1 font-md">
                                <div><small>Você tem</small></div>
                                <div class="mx-1"><b class="font-md" id="tempo-restante"></b></div>
                                <div><small>para pagar</small></div>
                            </div>
                            <div class="progress bg-dark bg-opacity-50">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100" id="barra-progresso"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>







            <div class="app-card card rounded-bottom rounded-0 rounded-bottom b-1 border-dark mb-2">
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-12 text-start">
                            <div class="mb-1"><span class="badge bg-success badge-xs">1</span><span class="font-xs">
                                    Copie o código PIX abaixo. </span></div>
                            <div class="input-group mb-2">
                                <input id="pixCopiaCola" type="text" class="form-control" value="<?= $pix_code ?>">
                                <div class="input-group-append">
                                    <button onclick="copyPix()"
                                        class="app-btn btn btn-success rounded-0 rounded-end">Copiar</button>
                                </div>
                            </div>
                            <div class="mb-2"><span class="badge bg-success">2</span> <span class="font-xs">Abra o app
                                    do seu banco e escolha a opção PIX, como se fosse fazer uma transferência.</span>
                            </div>
                            <p><span class="badge bg-success">3</span> <span class="font-xs">Selecione a opção PIX cópia
                                    e cola, cole a chave copiada e confirme o pagamento.</span></p>
                        </div>
                        <div class="col-12 my-2">
                            <p class="alert alert-warning p-2 font-xss"
                                style="text-align: justify; margin-bottom:0.5rem !important">Este pagamento só pode ser
                                realizado dentro do tempo, após este período, caso o pagamento não for confirmado os
                                números voltam a ficar disponíveis.</p>
                            <?php if ($txid > 0) { ?>
                            <p class="alert alert-danger p-2 font-xss" style="text-align: justify;"><i
                                    class="bi bi-exclamation-circle"></i> Este pagamento possui uma taxa adicional de
                                <?= $txid ?>%.</p>
                            <?php } ?>
                        </div>

                    </div>
                    <div style="background-image: url('../assets/img/bg-btn-qr.png'); text-align: center;"><input
                            id="btmqr" class="btn-qr" type="button" value="Mostrar QR Code"></div>
                    <div id="exibeqr" style="display: none; margin-top:24px; margin-bottom:24px; align-items:center"
                        class="row justify-content-center">

                        <div class="col-6 pb-3">
                            <div style="text-align: left; font-size:0.9rem !important" class="font-xss">
                                <h5><i class="bi bi-qr-code"></i> QR Code</h5>
                                <div>Acesse o APP do seu banco e escolha a opção <strong>pagar com QR Code,</strong>
                                    escaneie o código ao lado e confirme o pagamento.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-block text-center">
                                <div id="img-qrcode" class="d-inline-block bg-white rounded"><img
                                        style="width:200px; height:200px" src="data:image/png;base64,<?= $pix_qrcode ?>"
                                        class="img-fluid"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="detalhes-compra">
        <div class="compra-sorteio mb-2">
            <?php
            $order_items = $conn->query(
                "SELECT o.*, p.name as product, p.price, p.qty_numbers, p.status_display, p.subtitle, p.image_path, p.slug, p.type_of_draw, p.cotas_premiadas_descricao, p.cotas_premiadas FROM `order_list` o inner join product_list p on o.product_id = p.id where o.id = '{$id}' "
            );
            while ($row = $order_items->fetch_assoc()):
                $gt += $row["price"] * $row["quantity"]; ?>


            <div class="SorteioTpl_sorteioTpl__2s2Wu   pointer">
                <div class="SorteioTpl_imagemContainer__2-pl4 col-auto ">
                    <div
                        style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                        <img alt="Pop 110i 2022 0km" src="<?= validate_image($row['image_path']) ?>" decoding="async"
                            data-nimg="fill" class="SorteioTpl_imagem__2GXxI"
                            style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                        <noscript></noscript>
                    </div>
                </div>
                <div class="SorteioTpl_info__t1BZr">
                    <h1 class="SorteioTpl_title__3RLtu"><a class="stretched-link"
                            href="/campanhas/<?= $row['slug'] ?>"><?= $row['product'] ?></a></h1>
                    <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom: 1px;"><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>
                    <?php if ($row["status_display"] == 1) { ?>
                    <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                    <?php } ?>
                    <?php if ($row["status_display"] == 2) { ?>
                    <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
                    <?php } ?>
                    <?php if ($row["status_display"] == 3) { ?>
                    <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde o sorteio!</span>
                    <?php } ?>
                    <?php if ($row["status_display"] == 4) { ?>
                    <span class="badge bg-dark font-xsss">Concluído</span>
                    <?php } ?>

                </div>
            </div>

        </div>

        <?php
        $cards = '';
      
        
        // Verificar o status de pagamento na tabela 'order_list'
        $stmt_status = $conn->prepare('SELECT status FROM order_list WHERE id = ?');
        $stmt_status->bind_param('s', $id);
        $stmt_status->execute();
        $result_status = $stmt_status->get_result();
        $row_status = $result_status->fetch_assoc();
        
        // Verifica se o status da ordem é 'pago'
        if ($row_status['status'] == 2 && $row['type_of_draw'] == 1) {
            // String para armazenar os números premiados encontrados
            $numeros_premiados = [];
        
            // Iterar sobre cada número comprado e verificar se algum deles é o número premiado
        
            foreach ($cotas_premiadas as $num) {
                if (empty($num)) {
                    continue;
                } // Pula elementos vazios
        
                $stmt = $conn->prepare("SELECT * FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND id = $id");
                $stmt->bind_param('s', $num);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    // Adiciona o número ao array de números premiados
                    $numeros_premiados[] = $num;
                }
            }
        
            if (!empty($numeros_premiados)) {
                $quantidade_premiados = count($numeros_premiados);
                $numeros_encontrados = implode(', ', $numeros_premiados);
                $numeros_encontrados = rtrim($numeros_encontrados, ', ');
        
                ob_start();
                foreach ($numeros_premiados as $num) {
                    $prize = $cotas_array[$num];
                    echo '<div class="d-flex" style="align-items: center; justify-content:center;gap:12px; margin-block:4px"><div style="background-color:#387f57; color:white !important; border-radius:6px; min-width:37px; width:fit-content !important;font-size:0.9rem !important;line-height:1 !important; padding:6px 8px !important;font-weight:900 !important "  class="  font-xs text-dark">' . (stripos($num, ',') !== false ? str_replace(',', '', $num) : $num) .' </div>';
                    echo '<div style="    font-weight: bold;line-height: 1;color: #387f57 !important;font-size: 0.9rem;opacity: 1 !important;">Prêmio: '.$prize.'</div></div>';
                }
                $output = ob_get_clean();
                $cards =
                    ' 
                                <div class="detalhes app-card-winner card mb-2 " style="background: rgb(25, 135, 84); color: rgb(255, 255, 255); opacity: 1;">
        
                                    <div class="confetti hidden">
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
                <div class="confetti-piece"></div>
              </div>
                                    <div class="card-body">
                                    <span  style="color:#387f57; font-size:1.5rem; font-weight:900">🥳Parabéns!🥳</span> 
                                
                                        <div class="font-xs mb-2 text-dark">
                                            <div class="pt-1 opacity-75 font-xs text-dark">Sua compra possui <strong>' .
                    $quantidade_premiados .
                    ' título(s) <br> contemplado(s)</strong> na  modalidade <br> <strong>Premiação instantânea:</strong></div>
                                            <div style="align-items:center; justify-content:center; gap:8px; margin-block:16px" class="">' .
                    $output .
                    '
                                           
                                
                                            </div>
                                            <div style="color:#387f57 !important; font-size:0.9rem !important; margin-block:0 !important; opacity: 1 !important; font-weight: 500 !important;" class=" opacity-75 font-xs text-dark">
                                            Em breve, nossa equipe entrará em contato com você para realizar a entrega do prêmio.!</div>
                                            <a href="https://wa.me/' .
                    $whatsapp .
                    '" target="_blank" style="z-index: 1001; position: relative;" class="" id="wpp_btn"><i style="margin-right:4px" class="bi bi-whatsapp"></i> Falar com o suporte</a>
                                        </div>
                                    </div>
                                </div>';
            } else {
                $quantidade_premiados = count($numeros_premiados);
                $numeros_encontrados = implode(', ', $numeros_premiados);
                $numeros_encontrados = rtrim($numeros_encontrados, ', ');
        
                $cards = ' 
                                <div class="detalhes app-card-winner card mb-2 " style="background:#ffe8da !important; color: rgb(255, 255, 255); opacity: 1;">
                                    <div class="card-body">
                                    <span  style="color:#a7263a; font-size:1.5rem; font-weight:900">😢Que pena!😢</span> 
                                
                                        <div class="font-xs mb-2 text-dark">
                                            <div style="color:#a7263a !important" class="pt-1 opacity-75 font-xs text-dark">Sua compra não possui <strong>  títulos <br> contemplados</strong> na  modalidade <br> <strong>Premiação instantânea:</strong></div>
                                            <div style="color:#a7263a !important; font-size:0.9rem !important; margin-block:0 !important;opacity: 1 !important; font-weight: 500 !important;" class=" opacity-75 font-xs text-dark">
                                            </div>
                                
                                            <div style="color:#a7263a !important; font-size:0.9rem !important; margin-block:0 !important; opacity: 1 !important; font-weight: 500 !important;" class=" opacity-75 font-xs text-dark">
                                            Não fique triste, você continua concorrendo ao <strong>prêmio principal</strong> <br> boa sorte!</div>
                                          
                                        </div>
                                    </div>
                                </div>';
            }
        }
        echo $cards;
        ?>
        <div style="opacity: 1!important; color:#000" class="detalhes app-card card mb-2">
            <div class="card-body font-xs">
                <div class="font-xs opacity-75 mb-2 border-bottom-rgba text-dark d-flex justify-content-between">
                    <div >
                    <i class="bi bi-info-circle"></i> Detalhes da sua compra&nbsp;
                    <div class="pt-1 opacity-50 mb-1"><?= isset($order_token) ? $order_token : '' ?></div></div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1">

                    <div class="result font-xs text-dark" style="text-transform: uppercase;">
                        <?php
                        $customerQuery = $conn->query("SELECT firstname, lastname, phone FROM `customer_list` WHERE id = '{$customer_id}'");
                        
                        if ($customerQuery && $customerQuery->num_rows > 0) {
                            $customer = $customerQuery->fetch_assoc();
                            $firstname = $customer['firstname'];
                            $lastname = $customer['lastname'];
                            $phone = $customer['phone'];
                        }
                        $firstname = ucwords($firstname);
                        $lastname = ucwords($lastname);
                        echo $firstname . ' ' . $lastname . '';
                        ?>
                    </div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1">
                    <div class="title me-1 text-dark">
                        <i class="bi bi-check-circle"></i> Transação
                    </div>
                    <div class="result font-xs text-dark"><?= $id ?> </div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1">
                    <div class="title me-1 text-dark"><i class="bi bi-phone"></i> Telefone</div>
                    <div class="result font-xs text-dark"><?= formatPhoneNumber($phone) ?></div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1">
                    <div class="title me-1 text-dark"><i class="bi bi-calendar-week"></i> Data/Hora</div>
                    <div class="result font-xs text-dark"><?php echo date('d-m-Y H:i', strtotime($date_created)); ?></div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1">
                    <div class="title me-1 text-dark">
                       <i class="bi bi-card-list"></i> 
                        <?= $quantity ?> Cota(s)
                    </div>
                </div>
                <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba">
                    <div class="title me-1 mb-1 text-dark">
                        <i class="bi bi-wallet2"></i> Valor
                    </div>
                    <div class="result font-xs text-dark">R$ <?= number_format($total_amount, 2, ',', '.') ?></div>
                </div>
                <div class="item  align-items-baseline container">
                    <?php if ($type_of_draw == 1 && $status == 1 && $enable_hide_numbers == 1) {
                        echo ' <div style="margin-left:-12px" class="title font-weight-500 me-1">                       <i class="bi me-1 bi-card-list"></i> 
Cotas:</div>';
                    } ?>
                    <div class="result font-xs  row" data-nosnippet="true" style="overflow:hidden;">
                        <?php
        if ($type_of_draw > 1) {
            echo leowp_format_luck_numbers($my_numbers, $row['qty_numbers'], $class = 'alert-success', $opt = true, $type_of_draw);
        } elseif ($type_of_draw == 1 && $status == 1 && $enable_hide_numbers == 1) {
            echo '            <p class="alert alert-warning p-2 mt-2 font-xss" style="text-align: justify; margin-bottom:0.5rem !important">As cotas serão geradas após o pagamento.</p>
';
        } else {
            echo leowp_format_luck_numbers($sliced_numbers, $limit, $class = 'alert-success', $opt = true, $type_of_draw);

        ?>
                    </div>
                    <div style="margin-top: 16px">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?p<?php echo $current_page - 1; ?>">
                                         <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                // Calcule o número total de páginas
                                $total_pages = ceil(count($my_numbers) / $limit);
                                
                                // Mostre a página anterior, atual e próxima
                                if ($current_page > 1 ) {
                                    echo '<li class="page-item"><a class="page-link" href="?p=' . ($current_page - 1) . '" >' . ($current_page - 1) . '</a></li>';
                                }
                                echo '<li class="page-item active"><a class="page-link" href="?p=' . $current_page . '" >' . $current_page . '</a></li>';
                               
                                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                                ?>
                                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?p=<?php echo $current_page + 1; ?>" >
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?php } ?>
                <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1"></div>
                <?php echo $mensagem; ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php
            endwhile;
            ?>

<script> 

  

    $("#btmqr").on('click', (function() {
        if (document.getElementById('exibeqr').style.display == 'flex') {
            document.getElementById('exibeqr').style.display = 'none';
            document.getElementById('btmqr').value = "Mostrar QR Code";
        } else {
            document.getElementById('exibeqr').style.display = "flex";
            document.getElementById('btmqr').value = "Ocultar QR Code";
        }
    }));

    function copyPix() {
        var copyText = document.getElementById("pixCopiaCola");

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        document.execCommand("copy");
        navigator.clipboard.writeText(copyText.value);

        alert("Chave pix 'Copia e Cola' copiada com sucesso!");
    }
    $(document).ready(function() {
        var tempoInicial = parseInt('<?= $order_expiration ?>');
        var token = '<?= isset($order_token) ? $order_token : '' ?>';
        var progressoMaximo = 100;
        var tempoRestante;

        if (localStorage.getItem(token)) {
            tempoRestante = parseInt(localStorage.getItem(token));
        } else {
            tempoRestante = tempoInicial * 60;
            localStorage.setItem(token, tempoRestante);
        }

        var intervalo = setInterval(function() {
            var minutos = Math.floor(tempoRestante / 60);
            var segundos = tempoRestante % 60;
            var tempoFormatado = minutos.toString().padStart(2, '0') + ':' + segundos.toString()
                .padStart(2, '0');
            $('#tempo-restante').text(tempoFormatado);
            var progresso = ((tempoInicial * 60 - tempoRestante) / (tempoInicial * 60)) *
                progressoMaximo;
            $('#barra-progresso').css('width', progresso + '%').attr('aria-valuenow', progresso);
            tempoRestante--;
            localStorage.setItem(token, tempoRestante);
            if (tempoRestante < 0) {
                clearInterval(intervalo);
                localStorage.removeItem(token);
            }
        }, 1000);

        <?php if ($status == 1) { ?>
        setInterval(function() {
            var check = {
                order_token: '<?= $order_token ?>',
            };
            $.ajax({
                type: 'POST',
                url: _base_url_ + "class/Main.php?action=check_order",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: check,

                success: function(resp) {


                    console.log(resp.status);
                    if (resp.status == '2') {
                        window.location.reload();
                    }
                },
            });
        }, 3000);
        <?php } ?>

    });


   

</script>
</div>
