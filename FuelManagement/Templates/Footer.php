

<footer class="pt-4 my-md-5 pt-md-5 border-top" style="text-align:center">

<a href="Files/TermsOfUse.pdf" target="_blank">Όροι χρήσης</a> -
    <a href="Files/PrivacyPolicy.pdf" target="_blank">Πολιτική Απορρήτου</a>

</footer>
</div>

</body>
<script>
    // Κώδικας JavaScript που χρησιμοποιείται για custom Bootstrap validation και προβολή προσωποποιημένων
    // μηνυμάτων στις φόρμες.
    (function () {
        'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
                26
            })
    })()
</script>

</html>