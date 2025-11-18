<?php
/*
Template Name: Facont App
*/
get_header();

$facont_dir = get_stylesheet_directory() . '/facont';
$facont_uri = get_stylesheet_directory_uri() . '/facont';
$facont_version = 0;

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

<script>
  window.FACONT_BASE_URL = '<?php echo esc_js( $facont_uri ); ?>';
</script>
<script src="<?php echo esc_url( $facont_uri . '/facont.js?ver=' . $facont_version ); ?>"></script>

<?php
get_footer();
