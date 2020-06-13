function update_image_by_link(link) {
    let img = document.getElementById("selected_img");

    if (link.value && link.value.length) {
        img.src = link.value;
        img.alt = "Unable to upload photo";
    } else {
        img.src = "";
        img.alt = "";
    }
}

function update_image_by_file(file) {
    let img = document.getElementById("selected_img");

    if (FileReader && file && file.length) {
        let fr = new FileReader();
        fr.onload = () => {
            img.src = fr.result;
        }
        fr.readAsDataURL(file[0]);
        img.alt = "Unable to upload photo";
    } else if (!file.length) {
        img.src = "";
        img.alt = "";
    }
}

document.getElementById("radio_link").addEventListener("change", function (event) {
    document.getElementById("image_link").disabled = false;
    document.getElementById("image_file").disabled = true;

    update_image_by_link(document.getElementById("image_link"));
});

document.getElementById("radio_file").addEventListener("change", function (event) {
    document.getElementById("image_link").disabled = true;
    document.getElementById("image_file").disabled = false;

    update_image_by_file(document.getElementById("image_file").files);
});

document.getElementById("input_price").addEventListener("change", function (event) {
    let val = event.currentTarget.value.trim();

    if (val.match(/^\d{0,8}$/g) == null) {
        val = "0";
    }
    event.currentTarget.value = val;
});

document.getElementById("image_link").addEventListener("change", function (event) {
    update_image_by_link(event.currentTarget);
});

document.getElementById("image_file").addEventListener("change", function (event) {
    update_image_by_file(event.currentTarget.files);
});

document.getElementById("main_form").addEventListener("submit", function (event) {
    let name = document.getElementById("input_name");
    let price = document.getElementById("input_price");
    let radio_link = document.getElementById("radio_link");
    let link = document.getElementById("image_link");
    let file = document.getElementById("image_file");

    if (!name.value.length || !price.value.length
        || (radio_link.checked && !link.value.length)
        || (!radio_link.checked && (!file.files || !file.files.length))) {
        event.preventDefault();
    }
});