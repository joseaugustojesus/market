<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mercado Sto. Antônio</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
  <!-- <link rel="stylesheet" href="<?= css_path('/shared/bootstrap.css') ?>" /> -->

  <link rel="stylesheet" href="<?= css_path('/shared/toastify.css') ?>">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="<?= css_path('/dashboard.css') ?>">
  <?php if (isset($css)) { ?>
    <?php foreach ($css as $link) { ?>
      <link rel="stylesheet" href="<?= css_path($link) ?>">
    <?php } ?>
  <?php } ?>


  <!-- Page -->
  <?= $this->section('css') ?>
</head>

<body>

  <div class="container">
    <aside>
      <div class="top">
        <div class="logo">
          <img src="<?= image_path('logo.png') ?>" alt="">
          <h2>Sto. <span class="perigo">Antônio</span></h2>
        </div>
        <div class="close" id="close-btn">
          <span class="material-icons-sharp">
            close
          </span>
        </div>
      </div>
      <div class="sidebar">

        <!-- Dashboard -->
        <a href="<?= route('dashboard') ?>" class="<?= isUrl('/dashboard') ? 'ativo' : '' ?>">
          <span class="material-icons-sharp">
            grid_view
          </span>
          <h3>Dashboard</h3>
        </a>

        <!-- Produtos -->
        <a href="<?= route('products') ?>" class="<?= isUrl('/products') ? 'ativo' : '' ?>">
          <span class="material-icons-sharp">
            inventory
          </span>
          <h3>Produtos</h3>
        </a>

        <!-- Vendas -->
        <a href="<?= route('sales') ?>" class="<?= isUrl('/sales') ? 'ativo' : '' ?>">
          <span class="material-icons-sharp">
            receipt_long
          </span>
          <h3>Vendas</h3>
        </a>

        <!-- <a href="#" class="text-muted" aria-disabled="true">
          <span class="material-icons-sharp">
            person_outline
          </span>
          <h3>Clientes</h3>
        </a>


        <a href="#">
          <span class="material-icons-sharp">
            insights
          </span>
          <h3>Analise</h3>
        </a>
        <a href="#">
          <span class="material-icons-sharp">
            mail_outline
          </span>
          <h3>Menssagens </h3>
          <span class="cont-msg">26</span>
        </a>

        <a href="#">
          <span class="material-icons-sharp">
            report_gmailerrorred
          </span>
          <h3>Relatórios</h3>
        </a>
        <a href="#">
          <span class="material-icons-sharp">
            settings
          </span>
          <h3>Configurações</h3>
        </a>
        <a href="#">
          <span class="material-icons-sharp">
            add
          </span>
          <h3>Add Produto</h3>
        </a> -->
        <a href="#">
          <span class="material-icons-sharp">
            logout
          </span>
          <h3>Sair</h3>
        </a>
      </div>

    </aside>

    <?= $this->section('content'); ?>



    <div class="direita">

      <div class="cabecalho">
        <button id="menu-btn">
          <span class="material-icons-sharp">menu</span>
        </button>
        <div class="alt-tema">
          <span class="material-icons-sharp" onclick="handleTheme('light')">light_mode</span>
          <span class="material-icons-sharp" onclick="handleTheme('dark')">dark_mode</span>
        </div>
        <div class="perfil">
          <div class="info">
            <p>Olá, <b><?= auth()->username ?></b></p>
            <small class="legendas">Admin</small>
          </div>
        </div>
        <div class="foto-perfil">
          <img src="<?= image_path('profile-1.jpg'); ?>">
        </div>
      </div>


      <div class="atualizacoes-recentes">
        <h2>Últimas vendas</h2>


        <div class="atualizacoes">


          <?php foreach ($lastSales as $index => $sale) { ?>
            <div class="atualizacao">
              <div class="foto-perfil">
                <img src="<?= image_path('profile-2.jpg'); ?>">
              </div>
              <div class="mensagem">
                <p><b><?= $sale->user_name ?></b> <br> Realizou uma venda de R$ <?= numberBR($sale->total) ?></p>
                <small class="legendas"><?= timestampToDateBRAndTime($sale->created_at) ?></small>
              </div>
            </div>
          <?php } ?>



          <p class="t-center"><a href="<?= route('sales/all') ?>">Visualizar todas as vendas</a></p>
        </div>

      </div>


      <div class="analise-vendas">
        <h2>Análise de Vendas</h2>
        <div class="item online">
          <div class="icone">
            <span class="material-icons-sharp">shopping_cart</span>
          </div>
          <div class="direita">
            <div class="info">
              <h3>Ontem</h3>
              <small class="legendas">Visualizar dados</small>
            </div>
            <h5 class="sucesso">0%</h5>
            <h3>0</h3>
          </div>
        </div>

        <div class="item offline">
          <div class="icone">
            <span class="material-icons-sharp">local_mall</span>
          </div>
          <div class="direita">
            <div class="info">
              <h3>Última Semana</h3>
              <small class="legendas">Visualizar dados</small>
            </div>
            <h5 class="sucesso">0%</h5>
            <h3>0</h3>
          </div>
        </div>

        <div class="item cliente">
          <div class="icone">
            <span class="material-icons-sharp">person</span>
          </div>
          <div class="direita">
            <div class="info">
              <h3>Últimos 30 dias</h3>
              <small class="legendas">Visualizar dados</small>
            </div>
            <h5 class="sucesso">0%</h5>
            <h3>0</h3>
          </div>
        </div>
        <!-- <div class="item add-produto">
          <div>
            <span class="material-icons-sharp">add</span>
            <h3>Adicionar Produtos</h3>
          </div>
        </div> -->
      </div>
    </div>
  </div>
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
  <?php forgetSessions(['isWrong', 'old', 'devolution']) ?>
</body>

</html>