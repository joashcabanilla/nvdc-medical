$("#loginForm").submit((e) => {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "login", // Ensure this route exists in web.php
        data: $(e.currentTarget).serialize(),
        success: (res) => {
            // Redirect user based on role or success
            if (res.status === "success") {
                if (res.redirect_url) {
                    window.location.href = res.redirect_url;
                }
            } else {
                $(".error-text").removeClass("d-none").text(res.message || "Invalid credentials.");
            }
        },
        error: (xhr) => {
            // Handle HTTP errors
            $(".error-text").removeClass("d-none").text("Login failed. Please try again.");
        }
    });
});

//EYE
$("#togglePassword").click((e) => {
    const isPassword = $("#password").attr("type") === 'password';
    isPassword ? $("#password").attr("type", "text") : $("#password").attr("type", "password");
    isPassword ? $("#togglePassword").addClass("fa-eye").removeClass("fa-eye-slash") : $("#togglePassword").addClass("fa-eye-slash").removeClass("fa-eye");
});

$("#registrationForm").submit((e) => {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "register",
        data: $(e.currentTarget).serialize(),
        success: (res) => {
            if (res.status === "success") {
                // Redirect to login after successful registration
                window.location.href = "/"; // or route('user.login') if using named routes
            } else {
                // Display validation errors
                let errorMessages = Object.values(res.error).flat().join(" ");
                $(".error-text").removeClass("d-none").text(errorMessages);
            }
        },
        error: (xhr) => {
            $(".error-text").removeClass("d-none").text("Registration failed.");
        }
    });
});


