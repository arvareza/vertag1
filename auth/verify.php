<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recaptchaSecret = "6LcgX1wrAAAAADJTWANJfjtpjjmy1_Yp14CgwnX5";
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // verify captcha
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captchaSuccess = json_decode($verify);

    if ($captchaSuccess->success) {
        // Redirect to main index page
        header("Location: ../about/index.html");
        exit;
    } else {
        echo "<h2>CAPTCHA failed. Please try again.</h2>";
        echo "<a href='verify.html'>Go back</a>";
    }
} else {
    header("Location: verify.html");
    exit;
}
?>
