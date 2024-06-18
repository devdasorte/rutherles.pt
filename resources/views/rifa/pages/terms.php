<?php
include app_path('Includes/settings.php');
?>

<div class="container app-main">
   <div class="app-title">
      <h1><i class="icone bi bi-blockquote-right"></i> Termos de utilização </h1>
      <div class="app-title-desc"></div>
   </div>
   <div>
      <?php echo $_settings->info('terms'); ?>
   </div>
</div>
