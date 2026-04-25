/**
 * Circuit Brilliance — Contact Form Actions
 */

(function () {
  'use strict';

  const FORMSPREE_ENDPOINT = 'https://formspree.io/f/YOUR_FORM_ID';

  const form         = document.getElementById('cbContactForm');
  const successMsg   = document.getElementById('cbSuccessMessage');
  const submitBtn    = document.getElementById('cbSubmitBtn');
  const submitLabel  = document.getElementById('cbSubmitLabel');
  const submitSpinner = document.getElementById('cbSubmitSpinner');

  if (!form) return;

  const REQUIRED_FIELDS = [
    {
      id: 'cbEmail',
      errorId: 'cbEmailError',
      validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      message: 'Please enter a valid email address.'
    },
    {
      id: 'cbCompany',
      errorId: 'cbCompanyError',
      validate: (val) => val.trim().length > 0,
      message: 'Company name is required.'
    },
    {
      id: 'cbCountry',
      errorId: 'cbCountryError',
      validate: (val) => val.trim().length > 0,
      message: 'Country is required.'
    },
    {
      id: 'cbDomain',
      errorId: 'cbDomainError',
      validate: (val) => val !== '',
      message: 'Please select a design domain.'
    },
    {
      id: 'cbDescription',
      errorId: 'cbDescriptionError',
      validate: (val) => val.trim().length >= 10,
      message: 'Please describe your project (at least 10 characters).'
    }
  ];

  function validateField (fieldConfig) {
    const el    = document.getElementById(fieldConfig.id);
    const errEl = document.getElementById(fieldConfig.errorId);
    if (!el || !errEl) return true;

    const val   = el.value;
    const valid = fieldConfig.validate(val);

    if (valid) {
      el.classList.remove('is-invalid');
      el.classList.add('is-valid');
      errEl.textContent = '';
    } else {
      el.classList.add('is-invalid');
      el.classList.remove('is-valid');
      errEl.textContent = fieldConfig.message;
    }
    return valid;
  }

  REQUIRED_FIELDS.forEach(function (fieldConfig) {
    const el = document.getElementById(fieldConfig.id);
    if (!el) return;
    el.addEventListener('blur', function () {
      validateField(fieldConfig);
    });
    el.addEventListener('input', function () {
      if (el.classList.contains('is-invalid')) {
        validateField(fieldConfig);
      }
    });
  });

  function validateAll () {
    let allValid = true;
    REQUIRED_FIELDS.forEach(function (fieldConfig) {
      const valid = validateField(fieldConfig);
      if (!valid) allValid = false;
    });
    return allValid;
  }

  function setLoading (loading) {
    if (loading) {
      submitBtn.disabled = true;
      submitLabel.hidden = true;
      submitSpinner.hidden = false;
    } else {
      submitBtn.disabled = false;
      submitLabel.hidden = false;
      submitSpinner.hidden = true;
    }
  }

  function showConfirmation () {
    form.hidden = true;
    successMsg.hidden = false;
    successMsg.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function buildPayload () {
    return {
      email:       document.getElementById('cbEmail').value.trim(),
      company:     document.getElementById('cbCompany').value.trim(),
      country:     document.getElementById('cbCountry').value.trim(),
      domain:      document.getElementById('cbDomain').value,
      description: document.getElementById('cbDescription').value.trim(),
      budget:      document.getElementById('cbBudget').value,
      timeline:    document.getElementById('cbTimeline').value,
    };
  }

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const honeypot = form.querySelector('input[name="website"]');
    if (honeypot && honeypot.value.trim() !== '') {
      showConfirmation();
      return;
    }

    if (!validateAll()) {
      const firstError = form.querySelector('.is-invalid');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
      return;
    }

    setLoading(true);

    try {
      const payload = buildPayload();

      // Mock form submission
      setTimeout(() => {
        showConfirmation();
        setLoading(false);
      }, 1000);

    } catch (networkError) {
      showFormError('Could not send your message — please try again.');
      setLoading(false);
    }
  });

  function showFormError (message) {
    let existing = form.querySelector('.cb-form-error-global');
    if (existing) existing.remove();

    const errorDiv = document.createElement('p');
    errorDiv.className = 'cb-error cb-form-error-global text-danger mb-3';
    errorDiv.textContent = message;

    submitBtn.insertAdjacentElement('beforebegin', errorDiv);
  }

})();
