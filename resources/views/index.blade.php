<html>
<head>
<title>OTP Menggunakan Firebase</title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
<h1>OTP Menggunakan Firebase</h1>
<div class="alert alert-danger" id="error" style="display: none;"></div>
<div class="card">
<div class="card-header">
    Enter Phone Number
</div>

<div class="card-body">
<div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
<form>
<label>Phone Number:</label>
<input type="text" id="number" class="form-control" placeholder="+62********">
<div id="recaptcha-container"></div><hr>
<button type="button" class="btn btn-success" onclick="phoneSendAuth();">Send Code</button>
</form>

</div>
</div>
<div class="card" style="margin-top: 10px">
<div class="card-header">
    Enter Verification code
</div>
<div class="card-body">
<div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
<form>
<input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code"><hr>
<button type="button" class="btn btn-success" onclick="codeverify();">Verify Code</button>
</form>
</div>
</div>
</div>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
var firebaseConfig = {

    apiKey: "AIzaSyAcGCclCIDRz-W6DXH-oxFODoxmXa5OGz4",
    authDomain: "otpcode-8de7b.firebaseapp.com",
    databaseURL: "https://otpcode-8de7b-default-rtdb.firebaseio.com",
    projectId: "otpcode-8de7b",
    storageBucket: "otpcode-8de7b.appspot.com",
    messagingSenderId: "886666133123",
    appId: "1:886666133123:web:a6e4a93cd1654b399525b6",
    measurementId: "G-R1F7JR49HK"

};
firebase.initializeApp(firebaseConfig);
</script>
<script type="text/javascript">
window.onload=function () {
render();
};
function render() {
window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
recaptchaVerifier.render();
}
function phoneSendAuth() {
var number = $("#number").val();
firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
window.confirmationResult=confirmationResult;
coderesult=confirmationResult;
console.log(coderesult);
$("#sentSuccess").text("Message Sent Successfully.");
$("#sentSuccess").show();
}).catch(function (error) {
$("#error").text(error.message);
$("#error").show();
});
}
function codeverify() {
var code = $("#verificationCode").val();
coderesult.confirm(code).then(function (result) {
var user=result.user;
console.log(user);
$("#successRegsiter").text("you are register Successfully.");
$("#successRegsiter").show();
}).catch(function (error) {
$("#error").text(error.message);
$("#error").show();
});
}
</script>
</body>
</html>