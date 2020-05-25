<?= view('header') ?>

<div class="container h-100">
    <div class="alert alert-dismissible alert-danger">
        <div class="alert-message"></div>
    </div>
    <div class="row h-100 justify-content-center align-items-center">
        <form id="registerForm" class="col-6">
            <h2 class="py-2 text-truncate">Register.</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <input type="hidden" id="gRecaptchaResponse" name="gRecaptchaResponse">
            <button type="submit" class="btn btn-primary formSubmitBtn g-recaptcha"
                    data-sitekey="reCAPTCHA_site_key"
                    data-callback='onSubmit'
                    data-action='submit'>
                Submit
            </button>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=<?= $siteKey ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute("<?= $siteKey ?>", {action:'submit'})
            .then(function(token) {
                document.getElementById('gRecaptchaResponse').value = token;
            });
    });
</script>

<?= view('footer') ?>