/* -----------------------------
   Глобальные настройки
------------------------------*/

const FACONT_API_URL = 'https://itrex-auto-prod.up.railway.app/webhook/d3499289-9710-47bc-bd72-8aa9ccbd1426';
const FACONT_USER_ID = 1;
const FACONT_BASE_URL = (window.FACONT_BASE_URL || '').replace(/\/$/, '');

/* -----------------------------
   Вспомогательные функции
------------------------------*/

// Вызов n8n backend
async function facontCallAPI(cmd, data = {}) {
  const payload = { cmd, userId: FACONT_USER_ID, ...data };

  const res = await fetch(FACONT_API_URL, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  });

  if (!res.ok) {
    throw new Error('HTTP ' + res.status);
  }

  const ct = res.headers.get('content-type') || '';
  if (ct.includes('application/json')) {
    return res.json();
  }
  return res.text();
}

// Загрузка partial-файла в #facont-main
async function facontLoadPartial(relativePath) {
  const main = document.getElementById('facont-main');
  if (!main) return null;

  main.innerHTML = 'Загрузка...';

  let url = relativePath.replace(/^\//, '');
  if (FACONT_BASE_URL) {
    url = FACONT_BASE_URL + '/' + url;
  }

  const res = await fetch(url, { cache: 'no-cache' });
  if (!res.ok) {
    main.innerHTML = '<div class="card">Ошибка загрузки: ' + res.status + '</div>';
    return null;
  }

  const html = await res.text();
  main.innerHTML = html;
  return main;
}

/* -----------------------------
   Роутер по экранам
------------------------------*/

async function facontShowView(view) {
  const sidebar = document.querySelector('.facont-sidebar');
  if (sidebar) {
    sidebar.querySelectorAll('.facont-menu-item').forEach(item => {
      item.classList.toggle('active', item.dataset.view === view);
    });
  }

  if (view === 'onboarding_overview') {
    const main = await facontLoadPartial('onboarding-overview.html');
    if (main) facontInitOnboardingOverview();
  } else if (view === 'onboarding_identity') {
    const main = await facontLoadPartial('onboarding-identity.html');
    if (main) facontInitOnboardingIdentity();
  } else if (view === 'onboarding_product') {
    const main = await facontLoadPartial('onboarding-product.html');
    if (main) facontInitOnboardingProduct();
  } else if (view === 'settings') {
    const main = await facontLoadPartial('settings.html');
    if (main) facontInitSettings();
  }
}

/* -----------------------------
   Экран: Обзор онбординга
   (onboarding-overview.html)
------------------------------*/

async function facontInitOnboardingOverview() {
  const root = document.getElementById('facont-onb0');
  if (!root) return;

  const statusElems = {
    identity: root.querySelector('[data-status="identity"]'),
    product: root.querySelector('[data-status="product"]'),
    audience: root.querySelector('[data-status="audience"]'),
    style: root.querySelector('[data-status="style"]')
  };

  function setStatus(block, value) {
    const el = statusElems[block];
    if (!el) return;

    const done = value === 'ok';
    el.textContent = done ? 'Готово' : 'Не заполнен';
    el.classList.remove('done', 'todo');
    el.classList.add(done ? 'done' : 'todo');

    const card = root.querySelector('.facont-onb-block[data-block="' + block + '"]');
    if (!card) return;

    const btn = card.querySelector('[data-open-block]');
    if (!btn) return;

    btn.textContent = done ? 'Редактировать' : 'Заполнить';
  }

  try {
    const res = await facontCallAPI('get_settings', {});
    const user = res && res.user ? res.user : {};
    const onboarding = user.onboarding || {};

    setStatus('identity', onboarding.identity || null);
    setStatus('product', onboarding.product || null);
    setStatus('audience', onboarding.audience || null);
    setStatus('style', onboarding.style || null);
  } catch (e) {
    ['identity', 'product', 'audience', 'style'].forEach(b => setStatus(b, null));
  }

  root.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-open-block]');
    if (!btn) return;

    const block = btn.dataset.openBlock;
    if (block === 'identity') {
      facontShowView('onboarding_identity');
    } else if (block === 'product') {
      facontShowView('onboarding_product');
    } else if (block === 'audience') {
      alert('Блок 3 (Аудитория) ещё не реализован.');
    } else if (block === 'style') {
      alert('Блок 4 (Стиль) ещё не реализован.');
    }
  });
}

/* -----------------------------
   Блок 1: Identity
   (onboarding-identity.html)
------------------------------*/

function facontInitOnboardingIdentity() {
  const anyStep = document.querySelector('.onb1-step');
  if (!anyStep) return;
  const root = anyStep.parentElement || document;

  const steps = [
    'intro',
    'q1_1_name',
    'q1_2_role',
    'q1_3_achievements',
    'q1_4_what',
    'q1_5_values',
    'summary'
  ];
  let index = 0;

  const total = steps.length;
  const label = document.getElementById('onb1-progress-label');
  const bar = document.getElementById('onb1-progress-bar-inner');

  function showStep() {
    const all = root.querySelectorAll('.onb1-step');
    all.forEach(el => { el.style.display = 'none'; });

    const currentId = 'onb1-step-' + steps[index];
    const current = document.getElementById(currentId);
    if (current) current.style.display = 'block';

    if (label) {
      label.textContent = 'Шаг ' + (index + 1) + ' из ' + total;
    }
    if (bar) {
      const maxIndex = total - 1;
      const percent = maxIndex > 0 ? (index / maxIndex) * 100 : 100;
      bar.style.width = percent + '%';
    }
  }

  function validateRequired(requireId) {
    if (!requireId) return true;

    const el = document.getElementById(requireId);
    if (!el) return true;

    const value = (el.value || '').trim();
    if (!value) {
      alert('Заполни поле перед тем, как идти дальше.');
      el.focus();
      return false;
    }
    return true;
  }

  function collectAnswers() {
    return {
      q1_1_name: (document.getElementById('onb-q1-1-name')?.value || '').trim(),
      q1_2_role: (document.getElementById('onb-q1-2-role')?.value || '').trim(),
      q1_3_achievements: (document.getElementById('onb-q1-3-achievements')?.value || '').trim(),
      q1_4_what: (document.getElementById('onb-q1-4-what')?.value || '').trim(),
      q1_5_values: (document.getElementById('onb-q1-5-values')?.value || '').trim()
    };
  }

  async function saveBlock() {
    const btn = document.getElementById('btn-onb1-save');
    const busy = document.getElementById('onb1-busy');
    const status = document.getElementById('onb1-status');
    const finalEl = document.getElementById('onb1-final-text');

    if (!btn || !busy || !status || !finalEl) return;

    const answers = collectAnswers();

    const lines = [];
    Object.keys(answers).forEach(key => {
      const val = answers[key];
      if (val) {
        lines.push(key + ': ' + val);
      }
    });
    const inputText = lines.join('\n');
    const finalText = (finalEl.value || '').trim() || inputText;

    btn.disabled = true;
    busy.style.display = 'inline-block';
    status.textContent = '';

    try {
      await facontCallAPI('onboarding_save', {
        block: 'identity',
        answers,
        inputText,
        finalText,
        meta: {
          answers,
          ui_version: 1,
          saved_from: 'frontend_onboarding'
        }
      });
      status.textContent = 'Сохранено.';
    } catch (e) {
      status.textContent = 'Ошибка: ' + (e.message || e);
    } finally {
      btn.disabled = false;
      busy.style.display = 'none';
    }
  }

  root.addEventListener('click', (e) => {
    const nextBtn = e.target.closest('[data-onb1-next]');
    if (nextBtn) {
      const requireId = nextBtn.dataset.onb1Require || null;
      if (!validateRequired(requireId)) return;
      if (index < steps.length - 1) {
        index += 1;
        showStep();
      }
      return;
    }

    const prevBtn = e.target.closest('[data-onb1-prev]');
    if (prevBtn) {
      if (index > 0) {
        index -= 1;
        showStep();
      }
      return;
    }

    const saveBtn = e.target.closest('#btn-onb1-save');
    if (saveBtn) {
      saveBlock();
    }
  });

  showStep();
}

/* -----------------------------
   Блок 2: Product
   (onboarding-product.html)
------------------------------*/

function facontInitOnboardingProduct() {
  const anyStep = document.querySelector('.onb2-step');
  if (!anyStep) return;
  const root = anyStep.parentElement || document;

  const steps = [
    'intro',
    'q2_1_name',
    'q2_2_what',
    'q2_3_problems',
    'q2_4_benefits',
    'q2_5_price_level',
    'q2_6_unique',
    'summary'
  ];
  let index = 0;

  const total = steps.length;
  const label = document.getElementById('onb2-progress-label');
  const bar = document.getElementById('onb2-progress-bar-inner');

  function showStep() {
    const all = root.querySelectorAll('.onb2-step');
    all.forEach(el => { el.style.display = 'none'; });

    const currentId = 'onb2-step-' + steps[index];
    const current = document.getElementById(currentId);
    if (current) current.style.display = 'block';

    if (label) {
      label.textContent = 'Шаг ' + (index + 1) + ' из ' + total;
    }
    if (bar) {
      const maxIndex = total - 1;
      const percent = maxIndex > 0 ? (index / maxIndex) * 100 : 100;
      bar.style.width = percent + '%';
    }
  }

  function validateRequired(requireKey) {
    if (!requireKey) return true;

    if (requireKey === 'price') {
      const checked = root.querySelector('input[name="onb-q2-5-price"]:checked');
      if (!checked) {
        alert('Выбери примерный ценовой уровень перед продолжением.');
        return false;
      }
      return true;
    }

    const el = document.getElementById(requireKey);
    if (!el) return true;

    const value = (el.value || '').trim();
    if (!value) {
      alert('Заполни поле перед тем, как идти дальше.');
      el.focus();
      return false;
    }
    return true;
  }

  function collectAnswers() {
    const priceInput = root.querySelector('input[name="onb-q2-5-price"]:checked');
    const priceLevel = priceInput ? priceInput.value : '';

    return {
      q2_1_name: (document.getElementById('onb-q2-1-name')?.value || '').trim(),
      q2_2_what: (document.getElementById('onb-q2-2-what')?.value || '').trim(),
      q2_3_problems: (document.getElementById('onb-q2-3-problems')?.value || '').trim(),
      q2_4_benefits: (document.getElementById('onb-q2-4-benefits')?.value || '').trim(),
      q2_5_price_level: priceLevel,
      q2_6_unique: (document.getElementById('onb-q2-6-unique')?.value || '').trim()
    };
  }

  async function saveBlock() {
    const btn = document.getElementById('btn-onb2-save');
    const busy = document.getElementById('onb2-busy');
    const status = document.getElementById('onb2-status');
    const finalEl = document.getElementById('onb2-final-text');

    if (!btn || !busy || !status || !finalEl) return;

    const answers = collectAnswers();

    const lines = [];
    Object.keys(answers).forEach(key => {
      const val = answers[key];
      if (val) {
        lines.push(key + ': ' + val);
      }
    });
    const inputText = lines.join('\n');
    const finalText = (finalEl.value || '').trim() || inputText;

    btn.disabled = true;
    busy.style.display = 'inline-block';
    status.textContent = '';

    try {
      await facontCallAPI('onboarding_save', {
        block: 'product',
        answers,
        inputText,
        finalText,
        meta: {
          answers,
          ui_version: 1,
          saved_from: 'frontend_onboarding'
        }
      });
      status.textContent = 'Сохранено.';
    } catch (e) {
      status.textContent = 'Ошибка: ' + (e.message || e);
    } finally {
      btn.disabled = false;
      busy.style.display = 'none';
    }
  }

  root.addEventListener('click', (e) => {
    const nextBtn = e.target.closest('[data-onb2-next]');
    if (nextBtn) {
      const requireKey = nextBtn.dataset.onb2Require || null;
      if (!validateRequired(requireKey)) return;
      if (index < steps.length - 1) {
        index += 1;
        showStep();
      }
      return;
    }

    const prevBtn = e.target.closest('[data-onb2-prev]');
    if (prevBtn) {
      if (index > 0) {
        index -= 1;
        showStep();
      }
      return;
    }

    const saveBtn = e.target.closest('#btn-onb2-save');
    if (saveBtn) {
      saveBlock();
    }
  });

  showStep();
}

/* -----------------------------
   Экран: Настройки
   (settings.html)
------------------------------*/

function facontInitSettings() {
  const firstNameEl = document.getElementById('set-first-name');
  const lastNameEl = document.getElementById('set-last-name');
  const websiteEl = document.getElementById('set-website');
  const companyInfoEl = document.getElementById('set-company-info');
  const stylePromptEl = document.getElementById('set-style-prompt');

  const btnSaveUser = document.getElementById('btn-save-user');
  const btnCollectSite = document.getElementById('btn-collect-site');
  const btnSaveStyle = document.getElementById('btn-save-style');

  const busyUser = document.getElementById('save-user-busy');
  const statusUser = document.getElementById('save-user-status');
  const busyCollect = document.getElementById('collect-busy');
  const busyStyle = document.getElementById('save-style-busy');
  const statusStyle = document.getElementById('save-style-status');

  async function loadSettings() {
    try {
      const res = await facontCallAPI('get_settings', {});
      const user = res && res.user ? res.user : {};

      if (firstNameEl) firstNameEl.value = user.firstName || '';
      if (lastNameEl) lastNameEl.value = user.lastName || '';
      if (websiteEl) websiteEl.value = user.websiteUrl || '';
      if (companyInfoEl) {
        const ci = user.companyInfo || res.companyInfo || '';
        companyInfoEl.value = ci;
      }
      if (stylePromptEl) {
        stylePromptEl.value = user.stylePrompt || '';
      }
    } catch (e) {
      if (statusUser) {
        statusUser.textContent = 'Не удалось загрузить настройки: ' + (e.message || e);
      }
    }
  }

  async function saveUser() {
    if (!btnSaveUser || !busyUser || !statusUser) return;

    const firstName = (firstNameEl?.value || '').trim();
    const lastName = (lastNameEl?.value || '').trim();
    const websiteUrl = (websiteEl?.value || '').trim();

    btnSaveUser.disabled = true;
    busyUser.style.display = 'inline-block';
    statusUser.textContent = '';

    try {
      await facontCallAPI('save_user', {
        firstName,
        lastName,
        websiteUrl
      });
      statusUser.textContent = 'Сохранено.';
    } catch (e) {
      statusUser.textContent = 'Ошибка: ' + (e.message || e);
    } finally {
      btnSaveUser.disabled = false;
      busyUser.style.display = 'none';
    }
  }

  async function collectSite() {
    if (!btnCollectSite || !busyCollect || !companyInfoEl) return;

    const websiteUrl = (websiteEl?.value || '').trim();
    if (!websiteUrl) {
      alert('Сначала укажи сайт компании.');
      websiteEl && websiteEl.focus();
      return;
    }

    btnCollectSite.disabled = true;
    busyCollect.style.display = 'inline-block';

    try {
      const res = await facontCallAPI('collect_site', { websiteUrl });
      if (res && res.companyInfo) {
        companyInfoEl.value = res.companyInfo;
      }
    } catch (e) {
      alert('Ошибка при сборе информации: ' + (e.message || e));
    } finally {
      btnCollectSite.disabled = false;
      busyCollect.style.display = 'none';
    }
  }

  async function saveStyle() {
    if (!btnSaveStyle || !busyStyle || !statusStyle || !stylePromptEl) return;

    const stylePrompt = stylePromptEl.value || '';

    btnSaveStyle.disabled = true;
    busyStyle.style.display = 'inline-block';
    statusStyle.textContent = '';

    try {
      await facontCallAPI('save_style', { stylePrompt });
      statusStyle.textContent = 'Стиль сохранён.';
    } catch (e) {
      statusStyle.textContent = 'Ошибка: ' + (e.message || e);
    } finally {
      btnSaveStyle.disabled = false;
      busyStyle.style.display = 'none';
    }
  }

  if (btnSaveUser) {
    btnSaveUser.addEventListener('click', (e) => {
      e.preventDefault();
      saveUser();
    });
  }

  if (btnCollectSite) {
    btnCollectSite.addEventListener('click', (e) => {
      e.preventDefault();
      collectSite();
    });
  }

  if (btnSaveStyle) {
    btnSaveStyle.addEventListener('click', (e) => {
      e.preventDefault();
      saveStyle();
    });
  }

  loadSettings();
}

/* -----------------------------
   Инициализация приложения
------------------------------*/

document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.querySelector('.facont-sidebar');
  if (sidebar) {
    sidebar.addEventListener('click', (e) => {
      const item = e.target.closest('.facont-menu-item');
      if (!item) return;
      const view = item.dataset.view;
      if (!view) return;
      facontShowView(view);
    });
  }

  // стартовый экран – обзор онбординга
  facontShowView('onboarding_overview');
});
