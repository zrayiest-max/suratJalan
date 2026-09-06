import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.bootstrap5.css";

document.querySelectorAll(".tom-select").forEach((element) => {
    new TomSelect(element, {
        create: false,
        allowEmptyOption: true,
    });
});

const tableBody = document.querySelector("#item-table-body");

if (tableBody) {
    function updateRows() {
        const rows = tableBody.querySelectorAll(".item-row");

        rows.forEach((row, index) => {
            row.querySelector(".row-number").textContent = index + 1;

            row.querySelector(".item-jumlah").name = `items[${index}][jumlah]`;

            row.querySelector(".item-nama-barang").name =
                `items[${index}][nama_barang]`;

            const removeButton = row.querySelector(".btn-remove-row");

            removeButton.disabled = rows.length === 1;
        });
    }

    function addRow() {
        const index = tableBody.querySelectorAll(".item-row").length;

        const row = document.createElement("tr");
        row.classList.add("item-row");

        row.innerHTML = `
            <th scope="row" class="row-number">${index + 1}</th>

            <td>
                <input
                    type="number"
                    name="items[${index}][jumlah]"
                    class="form-control item-jumlah"
                    min="1"
                    required
                >
            </td>

            <td>
                <input
                    type="text"
                    name="items[${index}][nama_barang]"
                    class="form-control item-nama-barang"
                    required
                >
            </td>

            <td class="text-center">
                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm btn-remove-row"
                >
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(row);

        updateRows();

        row.querySelector(".item-jumlah").focus();
    }

    tableBody.addEventListener("keydown", (event) => {
        const target = event.target;

        if (!target.classList.contains("item-nama-barang")) {
            return;
        }

        const currentRow = target.closest(".item-row");

        const rows = [...tableBody.querySelectorAll(".item-row")];

        const isLastRow = currentRow === rows[rows.length - 1];

        if (event.key === "Tab" && !event.shiftKey && isLastRow) {
            event.preventDefault();

            if (
                currentRow.querySelector(".item-jumlah").value &&
                currentRow.querySelector(".item-nama-barang").value.trim()
            ) {
                addRow();
            }
        }
    });

    tableBody.addEventListener("click", (event) => {
        const button = event.target.closest(".btn-remove-row");

        if (!button) {
            return;
        }

        const rows = tableBody.querySelectorAll(".item-row");

        if (rows.length === 1) {
            return;
        }

        button.closest(".item-row").remove();

        updateRows();
    });

    updateRows();
}
