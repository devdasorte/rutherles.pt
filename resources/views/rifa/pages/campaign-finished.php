<?php
include app_path('Includes/settings.php');

?>
<?php
echo '<div class="container app-main">' . "\r\n" . '   <div class="app-title">' . "\r\n" . '      <h1>⚡ Campanhas</h1>' . "\r\n" . '      <div class="app-title-desc">Escolha sua sorte</div>' . "\r\n" . '   </div>' . "\r\n" . '   <div class="app-card card mb-2">' . "\r\n" . '      <div class="app-body d-flex align-items-center justify-content-center py-2">' . "\r\n" . '         <p class="text-muted font-xs text-uppercase mb-0 me-2">Listar</p>' . "\r\n" . '         <div class="btn-group btn-group-sm" role="group" aria-label="Filtros de listagem">' . "\r\n" . '            <button type="button" class="btn"><a href="/campanhas" wire:navigate>Ativas</a></button>' . "\r\n" . '            <button type="button" class="btn" style="background-color: var(--incrivel-primariaDarken);color:var(--incrivel-bgColor);"><a href="/concluidas" wire:navigate>Concluídas</a></button>' . "\r\n" . '            <button type="button" class="btn"><a href="/em-breve" wire:navigate>Em breve</a></button>' . "\r\n" . '         </div>' . "\r\n" . '      </div>' . "\r\n" . '   </div>' . "\r\n" . '   <div class="campanhas-listagem">' . "\r\n" . '      ';
$qry = $conn->query('SELECT * FROM `product_list` WHERE status = \'3\' AND private_draw = \'0\' ORDER BY id DESC');

if (0 < $qry->num_rows) {
	while ($row = $qry->fetch_assoc()) {
		echo '         <div class="mb-2">' . "\r\n" . '          <a href="/campanha/';
		echo $row['slug'];
		echo '"wire:navigate> ' . "\r\n" . '             <div class="SorteioTpl_sorteioTpl__2s2Wu   pointer">' . "\r\n" . '               <div class="SorteioTpl_imagemContainer__2-pl4 col-auto ">' . "\r\n" . '                  <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">' . "\r\n" . '                     <img alt="1.500,00 com apenas 0,03 centavos" src="';
		echo validate_image($row['image_path']);
		echo '" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">' . "\r\n" . '                     <noscript><img alt="1.500,00 com apenas 0,03 centavos" src="';
		echo validate_image($row['image_path']);
		echo '" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy"/></noscript>' . "\r\n" . '                  </div>' . "\r\n" . '               </div>' . "\r\n" . '               <div class="SorteioTpl_info__t1BZr">' . "\r\n" . '                  <h1 class="SorteioTpl_title__3RLtu">';
		echo $row['name'];
		echo '</h1>' . "\r\n" . '                  <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px">';
		echo (isset($row['subtitle']) ? $row['subtitle'] : '');
		echo '</p>' . "\r\n" . '                  ';

		if ($row['status_display'] == 1) {
			echo '                     <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>' . "\r\n" . '                  ';
		}


		echo '                  ';

		if ($row['status_display'] == 2) {
			echo '                     <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>' . "\r\n" . '                  ';
		}

		echo '                  ';

		if ($row['status_display'] == 3) {
			echo '                     <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde a campanha!</span>' . "\r\n" . '                  ';
		}

		echo '                  ';

		if ($row['status_display'] == 4) {
			echo '                     <span class="badge bg-dark font-xsss">Concluído</span>' . "\r\n" . '                  ';
		}

		echo '                  ';

		if ($row['status_display'] == 5) {
			echo '                     <span class="badge bg-dark font-xsss">Em breve</span>' . "\r\n" . '                  ';
		}

		echo '                  ';

		if ($row['status_display'] == 6) {
			echo '                     <span class="badge bg-dark font-xsss">Aguarde o sorteio!</span>' . "\r\n" . '                  ';
		}

		echo '               </div>' . "\r\n" . '            </div>' . "\r\n" . '         </a>' . "\r\n" . '      </div>' . "\r\n" . '   ';
	}

	echo '   ';
} else {
	echo '      <div class="alert alert-info"><i class="bi bi-info-circle"></i> Nenhuma campanha encontrada</div>' . "\r\n" . '   ';
}

echo "\r\n" . '</div>' . "\r\n" . '<div class="row">' . "\r\n" . '   <div class="col"></div>' . "\r\n" . '   <div class="col"></div>' . "\r\n" . '</div>' . "\r\n" . '</div>';

?>
