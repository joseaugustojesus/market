<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mercado Sto. Antônio</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="<?= css_path('/shared/bootstrap.css') ?>" />

  <link rel="stylesheet" href="<?= css_path('/shared/toastify.css') ?>">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">


  <?php if (isset($css)) { ?>
    <?php foreach ($css as $link) { ?>
      <link rel="stylesheet" href="<?= css_path($link) ?>">
    <?php } ?>
  <?php } ?>


  <!-- Page -->
  <?= $this->section('css') ?>
</head>

<body>
  <?= $this->section('content'); ?>

  <!-- Bootstrap, init and toastify -->
  <script src="<?= js_path('/shared/bootstrap.js') ?>"></script>
  <script src="<?= js_path('/shared/init.js') ?>"></script>
  <script src="<?= js_path('/shared/toastify.js') ?>"></script>

  <!-- Page -->
  <?= $this->section('js') ?>


  <?php if (isset($js)) { ?>
    <?php foreach ($js as $script) { ?>
      <script src="<?= js_path($script) ?>"></script>
    <?php } ?>
  <?php } ?>

  <?php getToastify(); ?>
  <?php forgetSessions(['isWrong', 'old']) ?>
</body>

</html>