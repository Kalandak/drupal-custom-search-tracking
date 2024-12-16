var Drupal = Drupal || { 'settings': {}, 'behaviors': {}, 'locale': {} };
(function ($, Drupal, drupalSettings) {
  const baseUrl = drupalSettings.search_form.base_url;
  const form_attr_id = drupalSettings.search_form.form_attr_id;
  const form_class = drupalSettings.search_form.form_class;
  const input_name = drupalSettings.search_form.input_name;
  const facet_name = drupalSettings.search_form.facet_name;
  let facet_language_name = drupalSettings.search_form.facet_language_name;
  const url_param = drupalSettings.search_form.url_param;

  function getCookieValue(name) {
    const cookies = document.cookie.split('; ');
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].split('=');
      if (cookie[0] === name) {
        return decodeURIComponent(cookie[1]);
      }
    }
    return null;
  }

  if (form_attr_id != null && input_name != null) {
    const forms = document.querySelectorAll(form_attr_id);
    console.log(forms)
    forms.forEach(form => {
      form.addEventListener('submit', function (event) {
        console.log(event+ '  here')
        // Fetch form data based on attribute name.
        var name_input = "[name='" + input_name + "']";
        var facet_business_input = "[name='" + facet_name + "']";

        const jsonString = getCookieValue('acquia_extract:fcso_business_filters');
        const jsonObject = JSON.parse(jsonString);
        const businessLine = jsonObject.business_line;
        console.log(businessLine);

        let facet_business_name_value = businessLine === "296"
          ? "Part A" 
          : "Part B";

        // Determine language based on URL path
        const pathName = window.location.pathname;
        const facet_language_name_value = pathName.startsWith("/es/") ? "Spanish" : "English";

        const formData = {
          name: form.querySelector(name_input).value,
          facet_business_name: facet_business_name_value,
          facet_language_name: facet_language_name_value,
        };

        const url = baseUrl + '/api/form-data';

        $.ajax({
          url: url,
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function (response) {},
          error: function (xhr, status, error) {}
        });
      });
    });
  } else if (form_class != null && input_name != null) {
    const forms = document.querySelectorAll(form_class);
    forms.forEach(form => {
      form.addEventListener('submit', function (event) {
        // Fetch form data based on attribute name.
        var name_input = "[name='" + input_name + "']";
        const formData = {
          name: form.querySelector(name_input).value,
        };
        const url = baseUrl + '/api/form-data';

        $.ajax({
          url: url,
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function (response) {},
          error: function (xhr, status, error) {}
        });
      });
    });
  } else if (url_param != null) {
    var searchParams = new URLSearchParams(window.location.search);
    var url_parameter = searchParams.get(url_param);
    const formData = {
      name: url_parameter,
    };
    const url = baseUrl + '/api/form-data';

    $.ajax({
      url: url,
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(formData),
      success: function (response) {},
      error: function (xhr, status, error) {}
    });
  }
})(jQuery, Drupal, drupalSettings);
