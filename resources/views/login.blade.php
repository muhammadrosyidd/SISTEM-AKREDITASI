<!DOCTYPE html>
<html lang="en">

<head>
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
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <button type="button" class="close-btn" onclick="closeModal()">×</button>

      <label for="username">Username</label>
      <input style="margin-top: 0%" type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>

      <label for="password">Password</label>
      <input style="margin-top: 0%" type="password" id="password" name="password" placeholder="Password" required>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <button type="submit">Log In</button>
    </form>
  </div>

  <script>
    function openModal() {
      const modal = document.getElementById("login");
      modal.style.display = "flex";
      setTimeout(() => {
        modal.classList.add("show");
      }, 10);
    }

    function closeModal() {
      const modal = document.getElementById("login");
      modal.classList.remove("show");
      setTimeout(() => {
        modal.style.display = "none";
      }, 300);
    }
  </script>

</body>

</html>