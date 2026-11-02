document.addEventListener("DOMContentLoaded", function () {

    // Membuat kolom pencarian tabel
    const table = document.querySelector("table");

    if (table) {
        const search = document.createElement("input");

        search.type = "text";
        search.placeholder = "Cari data...";
        search.style.width = "100%";
        search.style.padding = "12px";
        search.style.marginTop = "20px";

        table.parentNode.insertBefore(search, table);

        search.addEventListener("keyup", function () {
            const keyword = search.value.toLowerCase();
            const rows = table.querySelectorAll("tr");

            rows.forEach(function (row, index) {
                if (index === 0) return;

                row.style.display =
                    row.textContent.toLowerCase().includes(keyword)
                    ? ""
                    : "none";
            });
        });
    }

});