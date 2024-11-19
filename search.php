<?php
include 'config.php';

if (isset($_POST['search'])) {
    $searchRes = searchItem($_POST['search']);

    $output = '';
    if (count($searchRes) > 0) {
        foreach ($searchRes as $item) {
            $output .= "
            <form method=\"post\" class=\"flex flex-row justify-between gap-4 border rounded-2xl p-1 my-1 bg-white w-full\">
                <div class=\"flex gap-2\">
                    <div class=\"h-16 w-16 rounded-xl overflow-hidden\">
                    <img src='{$item['image']}' alt='{$item['name']}' class=\"h-full w-full object-cover\">
                    </div>
                    <div class=\"flex flex-col items-start gap-1\">
                    <p class=\"text-xl\">{$item['name']}</p>
                    <p class=\"text-lg\">AED. {$item['price']}</p>
                    <input type=\"hidden\" name=\"id\" value=\"{$item['id']}\">
                    </div>
                </div>
                <button type=\"submit\" name=\"add-To-Cart\" class=\" bg-red-500 hover:bg-red-200 hover:text-red-700 hover:font-semibold rounded-xl px-4 py-2 text-white flex flex-row items-center justify-center\">
                    Add
                    <span class=\"material-symbols-outlined\">add</span>
                </button>
            </form>";
        }
    } else {
        $output = '
        <div class="z-10 flex flex-col items-center justify-center gap-2 bg-white rounded p-4">
            <span class="material-symbols-outlined text-4xl">search</span>
            <p class="text-xl">No items found</p>
        </div>';
    }

    echo $output;
    exit;
}
?>