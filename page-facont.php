<?php
/*
Template Name: Facont App
*/
get_header();
?>

<style>
  /* Базовый контейнер приложения */
  .facont-app {
    display:flex;
    min-height:80vh;
    background:#f5f5f5;
    color:#111;
    font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  }

  .facont-app * {
    box-sizing:border-box;
    font-family:inherit;
  }

  /* Сайдбар */
  .facont-sidebar {
  width:240px;
  background:#111827;
  color:#e5e7eb;
  /* убираем растягивание по высоте */
  display:block;
  padding:16px;
  }

  .facont-logo {
    font-weight:700;
    font-size:18px;
    margin-bottom:4px;
  }

  .facont-muted {
    font-size:13px;
    color:#9ca3af;
  }

  .facont-menu-title {
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#9ca3af;
    margin:8px 0 4px;
  }

  .facont-menu {
  list-style:none;
  margin:0 0 12px 0;
  padding:0;
  display:block;
  }

  .facont-menu-item {
    padding:8px 10px;
    margin-bottom:4px;
    border-radius:6px;
    cursor:pointer;
    font-size:14px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    transition:background .15s ease,color .15s ease;
  }

  .facont-menu-item span {
    opacity:.9;
  }

  .facont-menu-item:hover {
    background:#1f2937;
  }

  .facont-menu-item.active {
    background:#2563eb;
    color:#fff;
  }

  .facont-menu-bottom {
  margin-top:8px;
  }

  .facont-pill {
    font-size:12px;
    border-radius:999px;
    padding:2px 8px;
    background:#374151;
  }

  /* Основная область */
  .facont-main {
    flex:1;
    padding:20px;
    overflow:auto;
    background:#f5f5f5;
  }

  .facont-main h1,
  .facont-main h2,
  .facont-main h3,
  .facont-main p {
    margin:0;
  }

  .facont-main h1 {
    font-size:22px;
    margin-bottom:8px;
  }

  .facont-main h2 {
    font-size:18px;
    margin-bottom:8px;
  }

  .facont-main h3 {
    font-size:16px;
    margin-bottom:8px;
  }

  .facont-main p {
    margin-bottom:6px;
  }

  .facont-main .muted {
    font-size:13px;
    color:#6b7280;
  }

  /* Карточки */
  .facont-main .card {
    background:#fff;
    border-radius:10px;
    border:1px solid #e5e7eb;
    padding:16px 18px;
    margin-bottom:16px;
    box-shadow:0 1px 2px rgba(15,23,42,0.04);
  }

  /* Формы */
  .facont-main label {
    display:block;
    font-size:13px;
    margin-bottom:4px;
    color:#4b5563;
  }

  .facont-main input[type="text"],
  .facont-main textarea {
    width:100%;
    padding:8px 10px;
    font:inherit;
    border-radius:6px;
    border:1px solid #d1d5db;
    background:#fff;
    resize:vertical;
    outline:none;
  }

  .facont-main input[type="text"]:focus,
  .facont-main textarea:focus {
    border-color:#2563eb;
    box-shadow:0 0 0 1px rgba(37,99,235,0.25);
  }

  .facont-main textarea {
    min-height:120px;
  }

  .facont-main .row {
    display:flex;
    gap:12px;
    flex-wrap:wrap;
  }

  .facont-main .row .col {
    flex:1;
    min-width:220px;
  }

  /* Кнопки */
  .facont-main .btn {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:8px 14px;
    border-radius:6px;
    border:1px solid #111827;
    background:#111827;
    color:#fff;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
    margin-right:8px;
    text-decoration:none;
    line-height:1.2;
    transition:background .15s ease,border-color .15s ease,transform .05s ease;
  }

  .facont-main .btn.secondary {
    background:#f3f4f6;
    color:#111827;
    border-color:#d1d5db;
  }

  .facont-main .btn:hover:not([disabled]) {
    background:#020617;
    border-color:#020617;
    transform:translateY(-1px);
  }

  .facont-main .btn.secondary:hover:not([disabled]) {
    background:#e5e7eb;
  }

  .facont-main .btn[disabled] {
    opacity:.6;
    cursor:not-allowed;
    transform:none;
  }

  /* Статусы и спиннер */
  .facont-status {
    font-size:13px;
    margin-top:6px;
    color:#6b7280;
  }

  .facont-status.ok { color:#059669; }
  .facont-status.err { color:#b91c1c; }

  .facont-main .spinner {
    display:inline-block;
    width:14px;
    height:14px;
    border-radius:50%;
    border:2px solid #d1d5db;
    border-top-color:#111827;
    animation:facont-spin .7s linear infinite;
    margin-left:6px;
  }

  @keyframes facont-spin {
    to { transform:rotate(360deg); }
  }

  /* Вопросы онбординга */
  .facont-main .onb-question {
    margin-bottom:14px;
  }

  .facont-main .onb-question-title {
    font-size:14px;
    font-weight:600;
    margin-bottom:4px;
  }

  .facont-main .onb-question-sub {
    font-size:13px;
    color:#4b5563;
    margin-bottom:4px;
  }

  .facont-main .onb-question-example {
    font-size:13px;
    color:#6b7280;
    font-style:italic;
  }

  @media (max-width:768px) {
    .facont-app {
      flex-direction:column;
    }
    .facont-sidebar {
      width:100%;
    }
  }
  
  /* Онбординг: прогресс и шаги */
  .facont-main .onb1-progress {
    margin-bottom:12px;
  }
  .facont-main .onb1-progress-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:13px;
    color:#4b5563;
  }
  .facont-main .onb1-progress-bar {
    width:100%;
    height:6px;
    border-radius:999px;
    background:#e5e7eb;
    overflow:hidden;
    margin-top:6px;
  }
  .facont-main .onb1-progress-bar-inner {
    height:100%;
    width:0;
    background:#2563eb;
    transition:width .2s ease;
  }

  .facont-main .onb1-step {
    margin-top:8px;
  }

</style>

<div class="facont-app">
  <aside class="facont-sidebar">
    <div>
      <div class="facont-logo">ИИ-контент</div>
      <div class="facont-muted">однопользовательский интерфейс</div>
    </div>

    <div class="facont-menu-title">Рабочие экраны</div>
    <ul class="facont-menu" id="facont-menu-top">
      <li class="facont-menu-item active" data-view="onboarding">
        <span>Онбординг</span>
        <span class="facont-pill">4 блока</span>
      </li>
      <li class="facont-menu-item" data-view="prompt1"><span>Промт 1</span></li>
      <li class="facont-menu-item" data-view="prompt2"><span>Промт 2</span></li>
      <li class="facont-menu-item" data-view="prompt3"><span>Промт 3</span></li>
    </ul>

    <div class="facont-menu-title">Системное</div>
    <ul class="facont-menu facont-menu-bottom">
      <li class="facont-menu-item" data-view="settings"><span>Настройки</span></li>
    </ul>

    <div style="margin-top:12px; font-size:13px; border-top:1px solid #374151; padding-top:10px;">
      <div style="margin-bottom:4px;">Нужны кастомные промпты или консультация?</div>
      <a href="https://t.me/venibak" target="_blank" style="color:#93c5fd; text-decoration:none;">
        Написать в Telegram
      </a>
    </div>
  </aside>

  <main class="facont-main">
    <div id="facont-main-content">
      <!-- сюда будем подгружать HTML-блоки -->
    </div>
    <div id="facont-global-status" class="facont-status"></div>
  </main>
</div>

<script>
  // НАСТРОЙКИ
  const API_URL = 'https://itrex-auto-prod.up.railway.app/webhook/d3499289-9710-47bc-bd72-8aa9ccbd1426';
  const USER_ID = 1;
  const TOKEN = '';

  // поправь путь под свою тему
  const FACONT_BASE = '<?php echo esc_js( get_stylesheet_directory_uri() ); ?>/facont';

  const VIEW_FILES = {
    onboarding: FACONT_BASE + '/onboarding-identity.html',
    settings:  FACONT_BASE + '/settings.html',
    prompt1:   FACONT_BASE + '/prompt1.html',
    prompt2:   FACONT_BASE + '/prompt2.html',
    prompt3:   FACONT_BASE + '/prompt3.html'
  };

  const el = id => document.getElementById(id);

  // === Онбординг блок 1: глобальное состояние шагов ===
  let facontOnb1Steps = ['intro','q1_1','q1_2','q1_3','q1_4','q1_5','summary'];
  let facontOnb1Index = 0;
  let facontOnb1HandlersBound = false;

  function facontOnb1UpdateStep() {
    const container = el('facont-main-content');
    if (!container) return;

    facontOnb1Steps.forEach((s, i) => {
      const block = el('onb1-step-' + s);
      if (!block) return;
      block.style.display = (i === facontOnb1Index) ? '' : 'none';
    });

    const progressBar = el('onb1-progress-bar-inner');
    const progressLabel = el('onb1-progress-label');

    const total = facontOnb1Steps.length;
    const stepNumber = facontOnb1Index + 1;

    if (progressLabel) {
      progressLabel.textContent = 'Шаг ' + stepNumber + ' из ' + total;
    }
    if (progressBar) {
      progressBar.style.width = (stepNumber / total) * 100 + '%';
    }
  }

  function facontOnb1GoNext() {
    if (facontOnb1Index < facontOnb1Steps.length - 1) {
      facontOnb1Index++;
      facontOnb1UpdateStep();
    }
  }

  function facontOnb1GoPrev() {
    if (facontOnb1Index > 0) {
      facontOnb1Index--;
      facontOnb1UpdateStep();
    }
  }

  // === Онбординг блок 2: продукт ===
  let facontOnb2Steps = ['intro','q2_1','q2_2','q2_3','q2_4','q2_5','q2_6','summary'];
  let facontOnb2Index = 0;
  let facontOnb2HandlersBound = false;

  function facontOnb2UpdateStep() {
    const container = el('facont-main-content');
    if (!container) return;

    facontOnb2Steps.forEach((s, i) => {
      const block = el('onb2-step-' + s);
      if (!block) return;
      block.style.display = (i === facontOnb2Index) ? '' : 'none';
    });

    const progressBar = el('onb2-progress-bar-inner');
    const progressLabel = el('onb2-progress-label');

    const total = facontOnb2Steps.length;
    const stepNumber = facontOnb2Index + 1;

    if (progressLabel) {
      progressLabel.textContent = 'Шаг ' + stepNumber + ' из ' + total;
    }
    if (progressBar) {
      progressBar.style.width = (stepNumber / total) * 100 + '%';
    }
  }

  function facontOnb2GoNext() {
    if (facontOnb2Index < facontOnb2Steps.length - 1) {
      facontOnb2Index++;
      facontOnb2UpdateStep();
    }
  }

  function facontOnb2GoPrev() {
    if (facontOnb2Index > 0) {
      facontOnb2Index--;
      facontOnb2UpdateStep();
    }
  }

  // универсальный вызов бекенда
  async function facontCallAPI(cmd, data = {}) {
    const body = { cmd, userId: USER_ID, ...data };
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Accept':'application/json',
        'Content-Type':'application/json',
        ...(TOKEN ? { 'x-auth': TOKEN } : {})
      },
      body: JSON.stringify(body)
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const ct = res.headers.get('content-type') || '';
    if (!ct.includes('application/json')) return {};
    return res.json();
  }

  // загрузка HTML-вьюхи
  async function facontLoadView(viewId) {
    const container = el('facont-main-content');
    const status = el('facont-global-status');
    status.textContent = '';
    status.className = 'facont-status';

    const url = VIEW_FILES[viewId];
    if (!url) {
      container.innerHTML = '<p>Этот экран ещё не реализован.</p>';
      return;
    }

    try {
      const res = await fetch(url + '?v=' + Date.now());
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const html = await res.text();
      container.innerHTML = html;

      facontAttachHandlers(viewId);
    } catch (e) {
      container.innerHTML = '<p>Ошибка загрузки интерфейса: ' + e.message + '</p>';
      status.textContent = 'Ошибка загрузки: ' + e.message;
      status.className = 'facont-status err';
    }
  }

  // навигация слева
  function facontSetActiveMenu(viewId) {
    document.querySelectorAll('.facont-menu-item').forEach(mi => {
      mi.classList.toggle('active', mi.dataset.view === viewId);
    });
  }

  document.querySelectorAll('.facont-menu-item').forEach(mi => {
    mi.addEventListener('click', () => {
      const viewId = mi.dataset.view;
      facontSetActiveMenu(viewId);
      facontLoadView(viewId);
    });
  });

  // состояние онбординга (обновляется через get_settings / onboarding_save)
  let facontOnboardingState = {};

  function facontUpdateOnboardingUI(onboardingJson) {
    facontOnboardingState = onboardingJson || {};
    // подсветка блоков можно будет добавить внутри онбордингового партиала,
    // сейчас просто держим состояние в JS
  }

  // загрузка настроек (для view=settings + заодно onboarding)
  async function facontLoadUserSettingsIntoForm() {
    try {
      const res = await facontCallAPI('get_settings');
      const u = res.user || {};

      const fName = el('set-first-name');
      if (fName) fName.value = u.firstName || '';

      const lName = el('set-last-name');
      if (lName) lName.value = u.lastName || '';

      const wUrl = el('set-website');
      if (wUrl) wUrl.value = u.websiteUrl || '';

      const cInfo = el('set-company-info');
      if (cInfo) cInfo.value = u.companyInfo || '';

      const sPrompt = el('set-style-prompt');
      if (sPrompt) sPrompt.value = u.stylePrompt || '';

      if (u.onboarding) facontUpdateOnboardingUI(u.onboarding);
    } catch (e) {
      const status = el('facont-global-status');
      if (status) {
        status.textContent = 'Ошибка загрузки настроек: ' + e.message;
        status.className = 'facont-status err';
      }
    }
  }

  // привязка логики к подгруженным вьюхам
  function facontAttachHandlers(viewId) {
    if (viewId === 'onboarding') {
      facontInitOnboardingIdentity();
    }
    if (viewId === 'settings') {
      facontInitSettings();
      facontLoadUserSettingsIntoForm();
    }
    // prompt1/2/3 пока заглушки – без логики
  }

  // ==== Онбординг: блок 1 ====
  function facontInitOnboardingIdentity() {
    // при каждом заходе в онбординг сбрасываем шаг на начало
    facontOnb1Index = 0;
    facontOnb1UpdateStep();

    // Вешаем обработчики один раз на весь документ (делегирование)
    if (facontOnb1HandlersBound) return;
    facontOnb1HandlersBound = true;

    document.addEventListener('click', async (e) => {
      const container = el('facont-main-content');
      if (!container) return;

      const status = el('onb1-status');
      const busy   = el('onb1-busy');

      // === Кнопка "Дальше" ===
      const nextBtn = e.target.closest('[data-onb1-next]');
      if (nextBtn && container.contains(nextBtn)) {
        const requireId = nextBtn.getAttribute('data-onb1-require');
        if (requireId) {
          const field = el(requireId);
          const value = (field && field.value) ? field.value.trim() : '';
          if (!value) {
            if (status) {
              status.textContent = 'Заполни поле перед переходом дальше';
              status.className = 'facont-status err';
            } else {
              alert('Заполни поле перед переходом дальше');
            }
            if (field) field.focus();
            return;
          }
        }
        if (status) {
          status.textContent = '';
          status.className = 'facont-status';
        }
        facontOnb1GoNext();
        return;
      }

      // === Кнопка "Назад" ===
      const prevBtn = e.target.closest('[data-onb1-prev]');
      if (prevBtn && container.contains(prevBtn)) {
        if (status) {
          status.textContent = '';
          status.className = 'facont-status';
        }
        facontOnb1GoPrev();
        return;
      }

      // === Кнопка "Сохранить блок 1" ===
      const saveBtn = e.target.closest('#btn-onb1-save');
      if (saveBtn && container.contains(saveBtn)) {
        if (!status || !busy) return;

        status.textContent = '';
        status.className = 'facont-status';
        busy.style.display = 'inline-block';
        saveBtn.disabled = true;

        try {
          const answers = {
            q1_1_name:         (el('onb-q1-1-name')?.value || '').trim(),
            q1_2_role:         (el('onb-q1-2-role')?.value || '').trim(),
            q1_3_achievements: (el('onb-q1-3-achievements')?.value || '').trim(),
            q1_4_what:         (el('onb-q1-4-what')?.value || '').trim(),
            q1_5_values:       (el('onb-q1-5-values')?.value || '').trim()
          };

          // все поля должны быть чем-то заполнены
          const missing = Object.entries(answers).filter(([, v]) => !v);
          if (missing.length > 0) {
            status.textContent = 'Заполни все ответы выше перед сохранением блока';
            status.className = 'facont-status err';
            busy.style.display = 'none';
            saveBtn.disabled = false;
            return;
          }

          let finalText = (el('onb1-final-text')?.value || '').trim();
          if (!finalText) {
            const parts = [];
            if (answers.q1_1_name)         parts.push('Имя: ' + answers.q1_1_name);
            if (answers.q1_2_role)         parts.push('Роль: ' + answers.q1_2_role);
            if (answers.q1_3_achievements) parts.push('Достижения: ' + answers.q1_3_achievements);
            if (answers.q1_4_what)         parts.push('Чем занимается: ' + answers.q1_4_what);
            if (answers.q1_5_values)       parts.push('Ценности: ' + answers.q1_5_values);
            finalText = parts.join('\n\n');
          }

          const res = await facontCallAPI('onboarding_save', {
            block: 'identity',
            answers,
            finalText
          });

          if (res && res.ok) {
            status.textContent = 'Блок 1 сохранён';
            status.className = 'facont-status ok';
            if (res.onboarding) {
              facontUpdateOnboardingUI(res.onboarding);
            }
          } else {
            throw new Error('Сервер вернул некорректный ответ');
          }
        } catch (err) {
          status.textContent = 'Ошибка: ' + err.message;
          status.className = 'facont-status err';
        } finally {
          busy.style.display = 'none';
          saveBtn.disabled = false;
        }

        return;
      }
    });
  }

  function facontInitOnboardingProduct() {
    facontOnb2Index = 0;
    facontOnb2UpdateStep();

    if (facontOnb2HandlersBound) return;
    facontOnb2HandlersBound = true;

    document.addEventListener('click', async (e) => {
      const container = el('facont-main-content');
      if (!container) return;

      const status = el('onb2-status');
      const busy   = el('onb2-busy');

      // "Дальше"
      const nextBtn = e.target.closest('[data-onb2-next]');
      if (nextBtn && container.contains(nextBtn)) {
        const requireKey = nextBtn.getAttribute('data-onb2-require');
        if (requireKey) {
          let ok = true;
          if (requireKey === 'price') {
            const checked = container.querySelector('input[name="onb-q2-5-price"]:checked');
            ok = !!checked;
            if (!ok && status) {
              status.textContent = 'Выбери уровень цен перед переходом дальше';
              status.className = 'facont-status err';
            }
          } else {
            const field = el(requireKey);
            const value = (field && field.value) ? field.value.trim() : '';
            ok = !!value;
            if (!ok) {
              if (status) {
                status.textContent = 'Заполни поле перед переходом дальше';
                status.className = 'facont-status err';
              } else {
                alert('Заполни поле перед переходом дальше');
              }
              if (field) field.focus();
            }
          }
          if (!ok) return;
        }
        if (status) {
          status.textContent = '';
          status.className = 'facont-status';
        }
        facontOnb2GoNext();
        return;
      }

      // "Назад"
      const prevBtn = e.target.closest('[data-onb2-prev]');
      if (prevBtn && container.contains(prevBtn)) {
        if (status) {
          status.textContent = '';
          status.className = 'facont-status';
        }
        facontOnb2GoPrev();
        return;
      }

      // "Сохранить блок 2"
      const saveBtn = e.target.closest('#btn-onb2-save');
      if (saveBtn && container.contains(saveBtn)) {
        if (!status || !busy) return;

        status.textContent = '';
        status.className = 'facont-status';
        busy.style.display = 'inline-block';
        saveBtn.disabled = true;

        try {
          const priceChecked = container.querySelector('input[name="onb-q2-5-price"]:checked');
          const priceValue = priceChecked ? priceChecked.value : '';

          const answers = {
            q2_1_name:      (el('onb-q2-1-name')?.value || '').trim(),
            q2_2_what:      (el('onb-q2-2-what')?.value || '').trim(),
            q2_3_problems:  (el('onb-q2-3-problems')?.value || '').trim(),
            q2_4_benefits:  (el('onb-q2-4-benefits')?.value || '').trim(),
            q2_5_price:     priceValue,
            q2_6_unique:    (el('onb-q2-6-unique')?.value || '').trim()
          };

          const missing = Object.entries(answers).filter(([, v]) => !v);
          if (missing.length > 0) {
            status.textContent = 'Заполни все ответы в блоке перед сохранением';
            status.className = 'facont-status err';
            busy.style.display = 'none';
            saveBtn.disabled = false;
            return;
          }

          let finalText = (el('onb2-final-text')?.value || '').trim();
          if (!finalText) {
            const parts = [];
            if (answers.q2_1_name)     parts.push('Название продукта: ' + answers.q2_1_name);
            if (answers.q2_2_what)     parts.push('Что делает продукт: ' + answers.q2_2_what);
            if (answers.q2_3_problems) parts.push('Какие проблемы решает: ' + answers.q2_3_problems);
            if (answers.q2_4_benefits) parts.push('Преимущества: ' + answers.q2_4_benefits);
            if (answers.q2_5_price) {
              let priceText = '';
              if (answers.q2_5_price === 'premium') priceText = 'Премиум (дорого, для избранных)';
              if (answers.q2_5_price === 'mid')     priceText = 'Средний сегмент';
              if (answers.q2_5_price === 'low')     priceText = 'Доступный (для всех)';
              if (priceText) parts.push('Уровень цен: ' + priceText);
            }
            if (answers.q2_6_unique)   parts.push('Уникальность: ' + answers.q2_6_unique);
            finalText = parts.join('\n\n');
          }

          const res = await facontCallAPI('onboarding_save', {
            block: 'product',
            answers,
            finalText
          });

          if (res && res.ok) {
            status.textContent = 'Блок 2 сохранён';
            status.className = 'facont-status ok';
            if (res.onboarding) {
              facontUpdateOnboardingUI(res.onboarding);
            }
          } else {
            throw new Error('Сервер вернул некорректный ответ');
          }
        } catch (err) {
          status.textContent = 'Ошибка: ' + err.message;
          status.className = 'facont-status err';
        } finally {
          busy.style.display = 'none';
          saveBtn.disabled = false;
        }
        return;
      }
    });
  }

  // ==== Настройки ====
  function facontInitSettings() {
    const btnSaveUser = el('btn-save-user');
    const btnCollect = el('btn-collect-site');
    const btnSaveStyle = el('btn-save-style');

    if (btnSaveUser) {
      const status = el('save-user-status');
      const busy = el('save-user-busy');

      btnSaveUser.addEventListener('click', async () => {
        if (!status || !busy) return;
        const firstName = (el('set-first-name')?.value || '').trim();
        const lastName  = (el('set-last-name')?.value || '').trim();
        const website   = (el('set-website')?.value || '').trim();

        status.textContent = '';
        status.className = 'facont-status';
        busy.style.display = 'inline-block';
        btnSaveUser.disabled = true;

        try {
          await facontCallAPI('save_user', { firstName, lastName, websiteUrl: website });
          status.textContent = 'Настройки сохранены';
          status.className = 'facont-status ok';
        } catch (e) {
          status.textContent = 'Ошибка: ' + e.message;
          status.className = 'facont-status err';
        } finally {
          busy.style.display = 'none';
          btnSaveUser.disabled = false;
        }
      });
    }

    if (btnCollect) {
      const status = el('save-user-status');
      const busy = el('collect-busy');

      btnCollect.addEventListener('click', async () => {
        if (!status || !busy) return;
        const rawWebsite = (el('set-website')?.value || '').trim();

        status.textContent = '';
        status.className = 'facont-status';
        busy.style.display = 'inline-block';
        btnCollect.disabled = true;

        try {
          if (!rawWebsite) throw new Error('Сначала укажи ссылку на сайт');

          const normalized =
            rawWebsite.startsWith('http://') || rawWebsite.startsWith('https://')
              ? rawWebsite
              : 'https://' + rawWebsite;

          const res = await facontCallAPI('collect_site', { websiteUrl: normalized });

          if (res && res.companyInfo && el('set-company-info')) {
            el('set-company-info').value = res.companyInfo;
          }

          status.textContent = 'Информация с сайта обновлена';
          status.className = 'facont-status ok';
        } catch (e) {
          status.textContent = 'Ошибка: ' + e.message;
          status.className = 'facont-status err';
        } finally {
          busy.style.display = 'none';
          btnCollect.disabled = false;
        }
      });
    }

    if (btnSaveStyle) {
      const status = el('save-style-status');
      const busy = el('save-style-busy');

      btnSaveStyle.addEventListener('click', async () => {
        if (!status || !busy) return;
        const stylePrompt = (el('set-style-prompt')?.value || '').trim();

        status.textContent = '';
        status.className = 'facont-status';
        busy.style.display = 'inline-block';
        btnSaveStyle.disabled = true;

        try {
          if (!stylePrompt) throw new Error('Промт стиля пуст');
          await facontCallAPI('save_style', { stylePrompt });
          status.textContent = 'Стиль сохранён';
          status.className = 'facont-status ok';
        } catch (e) {
          status.textContent = 'Ошибка: ' + e.message;
          status.className = 'facont-status err';
        } finally {
          busy.style.display = 'none';
          btnSaveStyle.disabled = false;
        }
      });
    }
  }

  // старт: грузим онбординг
  document.addEventListener('DOMContentLoaded', () => {
    facontSetActiveMenu('onboarding');
    facontLoadView('onboarding');
  });
</script>

<?php
get_footer();