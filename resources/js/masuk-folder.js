const checkboxes = document.querySelectorAll(".surat-checkbox");
const btnFolder = document.getElementById("btnMasukkanFolder");
const selectAll = document.getElementById("selectAll");

function updateButton() {
    const selected = document.querySelectorAll(".surat-checkbox:checked");

    btnFolder.disabled = selected.length === 0;

    if (selected.length > 0) {
        btnFolder.innerHTML = `
            <i class="bi bi-folder-plus"></i>
            Masukkan ke Folder (${selected.length})
        `;
    } else {
        btnFolder.innerHTML = `
            <i class="bi bi-folder-plus"></i>
            Masukkan ke Folder
        `;
    }
}

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", updateButton);
});

selectAll.addEventListener("change", function () {
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
    });

    updateButton();
});

btnFolder.addEventListener("click", function () {
    const selected = document.querySelectorAll(".surat-checkbox:checked");

    document.getElementById("jumlahDipilih").textContent = selected.length;

    const container = document.getElementById("selectedSuratJalan");

    container.innerHTML = "";

    selected.forEach((checkbox) => {
        const input = document.createElement("input");

        input.type = "hidden";
        input.name = "surat_jalan_ids[]";
        input.value = checkbox.value;

        container.appendChild(input);
    });
});
