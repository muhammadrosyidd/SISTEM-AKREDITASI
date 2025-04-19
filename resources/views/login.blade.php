<!DOCTYPE html>
<html lang="en">
<head>
  <title>Glassmorphism Login Form</title>
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

</head>

<body>

  <button class="open-btn" onclick="openModal()" style="font-weight: 530">LOGIN</button>

  <div class="modal" id="login">
    <div class="background">
      <div class="shape"></div>
      <div class="shape"></div>
    </div>
    <form onsubmit="return false;">
      <button type="button" class="close-btn" onclick="closeModal()">×</button>

      <label for="username">Username</label>
      <input style="margin-top: 0%" type="text" id="username" name="username" placeholder="Username">

      <label for="password">Password</label>
      <input style="margin-top: 0%" type="password" id="password" name="password" placeholder="Password">

      <button type="submit">Log In</button>
    </form>
  </div>

  <script>
    function openModal() {
      document.getElementById("login").style.display = "flex";
    }

    function closeModal() {
      document.getElementById("login").style.display = "none";
    }
  </script>

</body>
</html>
