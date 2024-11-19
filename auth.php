<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="flex h-screen w-full items-center justify-center bg-[#f0f4f9]">
    <main class="flex flex-row border rounded-2xl overflow-hidden bg-white">
        <section class="bg-red-500 p-4 text-white min-w-[20vw] min-h-[50vh]">
            <div class="login">
                <h1 class="text-2xl font-bold">Login</h1>
                <p class="text-sm">Login to your account</p>
            </div>
            <div class="signup hidden">
                <h1 class="text-2xl font-bold">SignUp</h1>
                <p class="text-sm">Signup to your account</p>
            </div>

        </section>
        <section class="">
            <form action="config.php" method="post" class="hidden signup-form flex flex-col items-start p-4">

                <label for="name" class="">Name</label>
                <input type="text" name="name" placeholder="Name" class=" border border-gray-400 w-64 h-10 rounded-lg p-2 m-2">

                <label for="email">Email</label>
                <input type="text" placeholder="Email" name="email" class="border border-gray-400 w-64 h-10 rounded-lg p-2 m-2">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" name="password"
                    class="border border-gray-400 w-64 h-10 rounded-lg p-2 m-2">

                <input type="submit" name="signup" class=" bg-red-500 text-white w-64 h-10 rounded-full p-2 m-2">

                <p class="text-sm">Already have an account? <button onclick="Toggle(event)"
                        class="text-blue-500">Login</button>
                </p>
            </form>
            <form action="config.php" method="post" class="login-form flex flex-col items-start p-4">
                <label for="email">Email</label>
                <input type="text" placeholder="Email" class="border border-gray-400 w-64 h-10 rounded-lg p-2 m-2" name="email">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" name="password"
                    class="border border-gray-400 w-64 h-10 rounded-lg p-2 m-2">

                <input type="submit" class="bg-red-500 text-white w-64 h-10 rounded-full p-2 m-2" name="login" />

                <p class="text-sm">Don't have an account? <button onclick="Toggle(event)"
                        class="text-blue-500">Register</button>
                </p>
            </form>
        </section>
    </main>
    <script>
        var toggle = false;
        function Toggle(event) {
            event.preventDefault();
            toggle = !toggle;
            if (toggle) {
                document.querySelector('.login').classList.add('hidden');
                document.querySelector('.login-form').classList.add('hidden');
                document.querySelector('.signup').classList.remove('hidden');
                document.querySelector('.signup-form').classList.remove('hidden');
            } else {
                document.querySelector('.login').classList.remove('hidden');
                document.querySelector('.login-form').classList.remove('hidden');
                document.querySelector('.signup').classList.add('hidden');
                document.querySelector('.signup-form').classList.add('hidden');
            }
        }
    </script>
</body>

</html>