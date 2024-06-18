<?php
include app_path('Includes/settings.php');

$filter = $_GET['status'] ?? 1; // Verifica se há um filtro na URL, caso contrário, usa 1 como padrão

function getQuery($conn, $filter) {
    return $conn->query("SELECT * FROM `product_list` WHERE status = $filter AND private_draw = '0' ORDER BY id DESC");
}

$qry = getQuery($conn, $filter);
?>

   
    <script>
		$(document).ready(function() {
            $('header').removeClass('campanhas');
            $('.back-bar').removeClass('campanhas');
			var filter = <?= $filter ?>;
			if (filter == 1) {
				$('.filter1').addClass('active');}
				$('.filter2').removeClass('active');
				$('.filter3').removeClass('active');
			if (filter == 2) {

				$('.filter2').addClass('active');
				$('.filter1').removeClass('active');
				$('.filter3').removeClass('active');
			}
			if (filter == 3) {
				$('.filter3').addClass('active');
				$('.filter1').removeClass('active');
				$('.filter2').removeClass('active');
			}
		});
        function filter(filter) {
			  
            Livewire.navigate('?status=' + filter); 
        }
    </script>
<style>
	.active{
		background-color: var(--incrivel-primariaDarken);color:var(--incrivel-bgColor);
	}
</style>
    <div class="container app-main">
        <div class="app-title">
            <h1>⚡ Campanhas</h1>
            <div class="app-title-desc">Escolha sua sorte</div>
        </div>
        <div class="app-card card mb-2">
            <div class="app-body d-flex align-items-center justify-content-center py-2">
                <p class="text-muted font-xs text-uppercase mb-0 me-2">Listar</p>
                <div class="btn-group btn-group-sm" role="group" aria-label="Filtros de listagem">
                    <button type="button" class="btn filter1" >
                        <a href="#" onclick="filter(1)" wire:navigate>Ativas</a>
                    </button>
                    <button type="button" class="btn filter2">
                        <a href="#" onclick="filter(2)" wire:navigate>Concluídas</a>
                    </button>
                    <button type="button" class="btn filter3">
                        <a href="#" onclick="filter(3)" wire:navigate>Em breve</a>
                    </button>
                </div>
            </div>
        </div>
        <div class="campanhas-listagem">
            <?php if ($qry->num_rows > 0) : ?>
                <?php while ($row = $qry->fetch_assoc()) : ?>
                    <div class="mb-2">
                        <a href="/campanhas/<?= $row['slug'] ?>" wire:navigate>
                            <div class="SorteioTpl_sorteioTpl__2s2Wu pointer">
                                <div class="SorteioTpl_imagemContainer__2-pl4 col-auto">
                                    <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                        <img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                        <noscript>
                                            <img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy"/>
                                        </noscript>
                                    </div>
                                </div>
                                <div class="SorteioTpl_info__t1BZr">
                                    <h1 class="SorteioTpl_title__3RLtu"><?= $row['name'] ?></h1>
                                    <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px"><?= $row['subtitle'] ?? '' ?></p>
                                    <?php
                                    switch ($row['status_display']) {
                                        case 1:
                                            echo '<span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>';
                                            break;
                                        case 3:
                                            echo '<span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>';
                                            break;
                                        case 4:
                                            echo '<span class="badge bg-dark font-xsss">Concluído</span>';
                                            break;
                                        case 5:
                                            echo '<span class="badge bg-dark font-xsss">Em breve</span>';
                                            break;
                                        case 6:
                                            echo '<span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>';
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="alert alert-info"><i class="bi bi-info-circle"></i> Nenhuma campanha encontrada</div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col"></div>
        </div>
    </div>
