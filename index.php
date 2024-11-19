<?php
include 'config.php';

// $check = mail("rexlucifer761@gmail.com", "testing mail", "We are testing your mail services", "From:rollacaf@rollacafeteria.whf.bz");

// if ($check) {
//     echo "email sent";
// } else {
//     echo "email not sent";
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rolla</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="w-full h-screen flex flex-col justify-between">
    <div id="sid"
        class="z-10 fixed top-0 bottom-0 left-0 right-0 hidden flex flex-col gap-4 items-center justify-center bg-[#0e0d0dad]">
        <form method="post" id="search-form" class="flex gap-4">
            <input type="text" name="search" class="w-full border p-2 rounded-xl" placeholder="Search">
            <button type="submit" name="search-items"
                class="hover:bg-[#CEE2F3] bg-white flex items-center justify-center border p-2 rounded-xl">
                <span class="material-symbols-outlined">search</span>
            </button>
        </form>
        <div id="searchResults">

        </div>
    </div>
    <div>

    <nav class="w-full flex items-center justify-between border-b px-8 py-3 sticky bg-white">
        <a href="index.php" class="text-3xl font-semibold">Rolla</a>
        <div class="flex gap-4">
            <button onclick="search()"
                class="hover:bg-[#CEE2F3] flex items-center justify-center border p-2 rounded-xl">
                <span class="material-symbols-outlined">
                    search
                </span>
            </button>
            <div id="indicator" class="hidden fixed top-3 right-20 bg-red-500 rounded-full h-3 w-3"></div>
            <a href="cart.php" class="hover:bg-[#CEE2F3] flex items-center justify-center border p-2 rounded-xl">
                <span class="material-symbols-outlined">
                    local_mall
                </span>
            </a>
            <?php
            if (isLoggedIn()) {
                echo "<form method=\"post\" class=\"hover:bg-[#CEE2F3] flex items-center justify-center border p-2 rounded-xl\">
                        <button type=\"submit\" name=\"logout\"  class=\"flex items-center justify-center\">
                            <span class=\"material-symbols-outlined\">logout</span>
                        </button>
                    </form>";
            } else {
                echo "<a href=\"auth.php\" class=\"hover:bg-[#CEE2F3] flex items-center justify-center border p-2 rounded-xl\">
                        <span class=\"material-symbols-outlined\">person</span>
                    </a>";
            }
            ?>
        </div>
    </nav>
    <main class="mx-[6vw] my-8 flex flex-col sm:flex-row gap-8">
        <section class=" hidden md:flex lg:flex">
            <?php
            $selectedCategory = isset($_POST['select-category']) ? $_POST['select-category'] : 'All';
            $menu = getCategorys();
            $items = getProducts($selectedCategory);

            echo "
            <form method=\"post\" class=\"flex flex-col gap-2 items-start\">
                <p class=\"text-2xl font-semibold\">Menu</p>
                <button type=\"submit\" value=\"All\" name=\"select-category\" class=\"text-xl py-2 ps-1\">All</button>";
            foreach ($menu as $item) {
                echo "<button type=\"submit\" name=\"select-category\" value=\"{$item}\" class=\"text-xl py-2 ps-1 \">$item</button>";
            }
            echo "</form>";
            ?>
        </section>
        <section class="lg:hidden md:hidden">
            <?php
            $selectedCategory = isset($_POST['select-category']) ? $_POST['select-category'] : 'All';
            $menu = getCategorys();
            $items = getProducts($selectedCategory);

            echo "
            <form method=\"post\" class=\"flex flex-row flex-wrap gap-2 w-full items-center justify-center\">
                <button type=\"submit\" value=\"All\" name=\"select-category\" class=\"text-xl px-4 py-1 rounded-full border\">All</button>";
            foreach ($menu as $item) {
                echo "<button onclick=\"select()\" type=\"submit\" id=\"select-category\" name=\"select-category\" value=\"{$item}\" class=\"text-xl px-4 py-1 rounded-full border\">$item</button>";
            }
            echo "</form>";
            ?>
        </section>
        <section class="flex flex-row flex-wrap gap-4 items-start">
            <?php
            foreach ($items as $item) {
                echo "
                <div class=\" flex flex-row gap-2 border rounded-3xl p-2 hover:bg-[#f0f4f9] w-[360px] truncate\">
                    <div class=\"w-32 h-32 min-w-32 bg-gray-200 rounded-2xl overflow-hidden\">
                        <img src=\"{$item['image']}\" alt=\"{$item['name']}\" class=\"w-full h-full object-cover\">
                    </div>
                    <form method=\"post\" class=\"flex flex-col items-start justify-between gap-1\">
                        <p class=\"text-xl text-wrap truncate\">{$item['name']}</p>
                        <p class=\"text-xl\">AED. {$item['price']}</p>
                        <input type=\"hidden\" name=\"id\" value=\"{$item['id']}\">
                        <button type=\"submit\" name=\"add-To-Cart\" class=\" bg-red-500 hover:bg-red-200 hover:text-red-700 hover:font-semibold rounded-xl px-4 py-2 text-white flex flex-row items-center justify-center\">
                            Add
                            <span class=\"material-symbols-outlined\">add</span>
                        </button>
                    </form>
                </div>
                ";
            }
            ?>
        </section>
    </main>
    </div>

    <footer
        class="w-full h-[250px] mt-[20px] gap-2 flex flex-col items-center justify-center border-t px-8 py-3 bg-[#181818] text-white">
        <div class="flex flex-row gap-1">
            <p>&copy; 2024 Taj Al Rolla Cafeteria</p>
            <p class="mx-4">|</p>
            <a href="https://www.linkedin.com/in/abhishekmaurya208/">Developed by Priya Ray</a>
        </div>

        <address>
            Al Mahatta - Al Qasimia - Sharjah - United Arab Emirates
        </address>

        <p>Contact Us - 06-53 00439</p>
        </div>
    </footer>
    <script>
        // prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        function search() {
            document.getElementById('sid').classList.toggle('hidden');
        }
        document.getElementById('sid').addEventListener('click', function (e) {
            if (e.target.id === 'sid') {
                document.getElementById('sid').classList.add('hidden');
            }
        });

        const searchForm = document.getElementById('search-form');
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const search = searchForm.querySelector('input[name="search"]').value;
            if (search.trim() === '') {
                return;
            }
            const searchResults = document.getElementById('searchResults');
            searchResults.innerHTML = `
            <div class="z-10 flex flex-col items-center justify-center gap-2 bg-white rounded p-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                <p class="text-xl">Searching...</p>
            </div>
        `;
            const formData = new FormData();
            formData.append('search', search);
            fetch('search.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text()).then(data => {
                searchResults.innerHTML = data;
                const addToCartButtons = document.querySelectorAll('button[name="add-To-Cart"]');
                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        const id = button.parentElement.querySelector('input[name="id"]').value;
                        const formData = new FormData();
                        formData.append('id', id);
                        formData.append('add-To-Cart', true);
                        fetch('cart-handler.php', {
                            method: 'POST',
                            body: formData
                        }).then(response => response.text()).then(data => {
                            if (data === 'success') {
                                button.innerHTML = 'Added';
                                button.classList.remove('bg-red-500');
                                button.classList.add('bg-green-500');
                            }
                        });
                    });
                });
            });
        });

        // add to cart
        const addToCartButtons = document.querySelectorAll('button[name="add-To-Cart"]');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const id = button.parentElement.querySelector('input[name="id"]').value;
                const formData = new FormData();
                formData.append('id', id);
                formData.append('add-To-Cart', true);
                fetch('cart-handler.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text()).then(data => {
                    if (data == 'success') {
                        button.innerHTML = 'Added';
                        button.classList.remove('bg-red-500');
                        button.classList.add('bg-green-500');
                    }
                    updateIndicator();
                });
            });
        });

        //indicator
        function updateIndicator() {
            const formData = new FormData();
            formData.append('total-cart-value', true);
            fetch('config.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
                .then(data => {
                    // toggle hidden
                    if (data != 0) {
                        document.getElementById('indicator').classList.remove('hidden');
                    } else {
                        document.getElementById('indicator').classList.add('hidden');
                    }
                });
        }
        window.addEventListener('load', updateIndicator());
    </script>
</body>

</html>