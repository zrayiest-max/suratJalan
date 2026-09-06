import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.bootstrap5.css";

const folderSelect = document.querySelector(".tom-select-folder");

if (folderSelect) {
    new TomSelect(folderSelect, {
        create: false,
        allowEmptyOption: true,
        placeholder: "Cari folder...",
    });
}
