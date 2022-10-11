<?= $this->layout('shared/template', [
  'css' => [ '/login.css']
]) ?>



<div class="parent clearfix">
  <div class="bg-illustration">

    <div class="burger-btn">
      <span></span>
      <span></span>
      <span></span>
    </div>

  </div>

  <div class="login">
    <div class="container">
      <h1>Painel Administrativo</h1>
      <h2>Mercado Sto. Antônio</h2>
      <div class="login-form">
        <form action="<?= route('login/store') ?>" method="POST">
          <?= csrf(); ?>
          <input type="text" placeholder="Usuário" name="username">
          <input type="password" placeholder="Palavra chave" name="password">

          <div class="remember-form">
            <input type="checkbox">
            <span>Manter-me conectado</span>
          </div>
          <div class="forget-pass">
            <a href="https://devjesus.com.br" target="_blank">Devjesus</a>
          </div>

          <button type="submit">Acessar Aplicação</button>

        </form>
      </div>

    </div>
  </div>
</div>