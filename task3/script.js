console.log("connected");
var wrongCount = 0;

function getEmail() {
  var e = document.getElementById("email").value;
  var err = document.getElementById("emailErr");
  err.innerHTML = e.indexOf("@") === -1 ? "Email must contain @" : "";
  return err.innerHTML === "";
}

function getPassword() {
  var p = document.getElementById("password").value;
  var msg = (p.length < 6 ? "At least 6 characters" : "") + (p.indexOf("#") === -1 ? (p.length < 6 ? ". Must contain #" : "Password must contain #") : "");
  document.getElementById("pwdErr").innerHTML = msg;
  return msg === "";
}

function collectFormData() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  console.log("Printing given values...", email, password);

  var eErr = document.getElementById("emailErr");
  var pErr = document.getElementById("pwdErr");
  eErr.innerHTML = "";
  pErr.innerHTML = "";

  eErr.innerHTML = !email ? "Email is required" : email.indexOf("@") === -1 ? "Email must contain @" : "";
  var pMsg = (password.length < 6 ? "Password must be at least 6 characters" : "") + (password.indexOf("#") === -1 ? (password.length < 6 ? ". " : "") + "Password must contain #" : "");
  pErr.innerHTML = pMsg;

  if (eErr.innerHTML || pMsg) {
    wrongCount++;
    document.getElementById("invalidCount").style.display = "block";
    document.getElementById("count").innerHTML = wrongCount;
    return false;
  }
  alert("Success! Form is valid.");
  return true;
}
