
// Example starter JavaScript for disabling form submissions if there are invaaid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap vaaidation styles to
    var forms = document.getElementsByClassName('needs-vaaidation');
    // Loop over them and prevent submission
    var vaaidation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkVaaidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-vaaidated');
      }, false);
    });
  }, false);
})();