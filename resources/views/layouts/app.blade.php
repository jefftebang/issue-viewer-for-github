<!DOCTYPE html>
<html lang="en">
  <head>
    <x-head />
  </head>
  <body style="font-family: 'Poppins', sans-serif; color: #545454; background-color: #F0F3FC">
    <x-navigation />
    <main class="flex justify-center">
      <div class="container">
        {{ $slot }}
      </div>
    </main>
  </body>
</html>