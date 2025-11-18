<?php
/*
Template Name: Facont App
*/
get_header();

$facont_dir = get_stylesheet_directory() . '/facont';
$facont_uri = get_stylesheet_directory_uri() . '/facont';
$facont_version = 0;
$facont_user_id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

foreach ( array( 'facont.css', 'facont.js' ) as $facont_asset ) {
  $asset_path = $facont_dir . '/' . $facont_asset;

  if ( file_exists( $asset_path ) ) {
    $facont_version = max( $facont_version, filemtime( $asset_path ) );
  }
}

if ( ! $facont_version ) {
  $facont_version = time();
}
?>

<link rel="stylesheet" href="<?php echo esc_url( $facont_uri . '/facont.css?ver=' . $facont_version ); ?>">

<?php if ( $facont_user_id ) : ?>
  <div class="facont-app">
    <aside class="facont-sidebar">
      <div>
        <div class="facont-logo">ИИ-контент</div>
        <div class="facont-subtitle">однопользовательский интерфейс</div>
      </div>

      <ul class="facont-menu">
        <li class="facont-menu-item active" data-view="onboarding_overview">Онбординг</li>
        <li class="facont-menu-item" data-view="onboarding_identity">Блок 1: Личность</li>
        <li class="facont-menu-item" data-view="onboarding_product">Блок 2: Продукт</li>
        <li class="facont-menu-item" data-view="settings">Настройки</li>
      </ul>

      <div class="facont-tg-box">
        <div style="margin-bottom:4px;">Нужны кастомные промпты или консультация?</div>
        <a href="https://t.me/venibak" target="_blank" rel="noopener noreferrer">
          Написать в Telegram
        </a>
      </div>
    </aside>

    <main class="facont-main">
      <div id="facont-main"></div>
    </main>
  </div>
<?php else : ?>
  <div class="facont-login-page">
    <div class="facont-login-card">
      <h1>Вход в Facont</h1>
      <p>Введите email и пароль. Мы проверим данные через n8n и подключим ваш профиль.</p>
      <form id="facont-login-form" class="facont-login-form">
        <div class="facont-field">
          <label for="facont-login-email">Email</label>
          <input type="email" id="facont-login-email" name="email" autocomplete="email" required>
        </div>
        <div class="facont-field">
          <label for="facont-login-password">Пароль</label>
          <input type="password" id="facont-login-password" name="password" autocomplete="current-password" required>
        </div>

        <div class="facont-login-actions">
          <button type="submit" id="facont-login-submit" class="facont-btn-primary">Войти</button>
          <span class="facont-login-hint">Проверка выполняется через n8n.</span>
        </div>
        <div id="facont-login-error" class="facont-login-error" role="alert"></div>
      </form>
    </div>
  </div>
<?php endif; ?>

<script>
  window.FACONT_BASE_URL = '<?php echo esc_js( $facont_uri ); ?>';
  window.FACONT_USER_ID = <?php echo (int) $facont_user_id; ?>;
</script>
<script src="<?php echo esc_url( $facont_uri . '/facont.js?ver=' . $facont_version ); ?>"></script>

<?php
get_footer();
