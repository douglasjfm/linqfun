<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>Linq.Fun</title>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HPV6B5YYJF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-HPV6B5YYJF');
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<!-- Analytics -->

<script type="text/javascript">
function chm() {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var o = JSON.parse(this.responseText);
      document.getElementById("linq").value = o.m;
      if (o.r == 0) {
        document.getElementById("rgsbtn").hidden = false;
      }
    }
  };
  
  str = document.getElementById("link").value;
  
  if (str.length > 10)
  {
    is_aut = "f";
    frase = "meulink";
    test = document.getElementById("url").value;
    if (test.length < 1) {
      is_aut = "t";
    }
    else {
      is_aut = "f";
      frase = test;
    }
    xhttp.open("POST", "_hash?aut=" + is_aut + "&frase=" + frase, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    if (str.substr(0,7) == "http://") xhttp.send("l=" + encodeURI(str.substr(7)));
    else xhttp.send("l=" + encodeURI(str));
  }
  else
  {
    document.getElementById("linq").value = str;
  }
}

function rgs() {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var res = this.responseText;
      var rid = res.split("|")[0];
      var lnq = res.split("|")[1];
      if (rid == "-1" || rid == "-2") {
          alert ("error: " + lnq);
      } else {
          alert("link recorded");
      }
      document.getElementById("rgsbtn").disabled = true;
      document.getElementById("llnq").hidden = false;
    }
  };
  linq = document.getElementById("linq").value;
  link = document.getElementById("link").value;

  linq = linq.substr(linq.lastIndexOf("/")+1);

  xhttp.open("POST", "_regis?h=" + linq, true);
  xhttp.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("l=" + encodeURI(link));
}

function onSubmit(token) {
     chm();
}

function openlnq() {
     var s = document.getElementById("linq").value;
     window.open(s);
}

</script>
</head>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<body class="antialiased">

<h3>linq.fun - free link shortener</h3>

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
  <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
    <label for="fname">1. link</label>
    <input type="text" id="link" name="link" placeholder="http://link...">

    <label for="lname">2. custom alias (optional, only up to 12 letters and/or numbers long)</label>
    <input type="text" id="url" name="url" placeholder="CustomAlias" lenght="12" pattern="[a-zA-Z0-9]+">
  
    <button type="button" {{ $callback_rgs }} id="cllbtn">Make Linq</button>
    
    <div>
      <label for="lname">linq:</label>
      <input type="text" readonly id="linq" name="linq" placeholder="linq.fun/EasyHint" value="">
      <button type="button" hidden id="rgsbtn" onclick="rgs()">Register</button>
      <div id="llnq" hidden>
        <label for="lname">test linq:</label> <button onclick="openlnq()">open</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
