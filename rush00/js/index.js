let product_price = 0;

{
    let lists = document.getElementsByClassName('product_list');

    for (let i = 0; i < lists.length; i++) {
        let products = lists[i].children;

        if (products.length % 3 === 2) {
            for (let j = 0; j < products.length % 3; j++) {
                products[j].classList.remove('part_of_three');
                products[j].classList.add('part_of_two');
            }
        } else if (products.length % 3 === 1) {
            products[0].classList.remove('part_of_three');
            products[0].classList.add('part_of_one');
        }
    }

    let descriptions = document.getElementsByClassName("product_description");
    for (let elem of descriptions) {
        elem.addEventListener("click", function (event) {
            let parent = event.currentTarget.parentElement;
            let id = parent.children[0].value;
            let price = parent.children[1].value;
            let name = event.currentTarget.getElementsByClassName("product_name")[0].textContent;
            let link = parent.getElementsByClassName("product_image")[0].src;

            product_price = parseInt(price, 10);
            document.getElementById("buy_product").children[0].value = id;
            document.getElementById("buy_product_name").children[0].textContent = name;
            document.getElementById("buy_product_image").children[0].src = link;
            document.getElementById("buy_count_text").value = "1";
            document.getElementById("buy_product_count").children[0].textContent = "$" + price + "x";
            document.getElementById("buy_product_total_value").textContent = "$" + price;

            show_window(document.getElementById("buy_product_background"));
        });
    }

    document.getElementById("buy_product_count_panel_decrease").addEventListener("click", function (event) {
        let field = event.currentTarget.parentElement.children[1];
        let count = parseInt(field.value, 10);

        if (count > 1) {
            count -= 1;
            field.value = count.toString();
            document.getElementById("buy_product_total_value").textContent = "$" + (product_price * count);
        }
    });

    document.getElementById("buy_product_count_panel_increase").addEventListener("click", function (event) {
        let field = event.currentTarget.parentElement.children[1];
        let count = parseInt(field.value, 10);

        if (count < 9999) {
            count += 1;
            field.value = count.toString();
            document.getElementById("buy_product_total_value").textContent = "$" + (product_price * count);
        }
    });

    document.getElementById("buy_count_text").addEventListener("change", function (event) {
        let field = event.currentTarget;

        if (field.value.match(/^\s*[1-9]\d{0,3}\s*$/) != null) {
            field.value = field.value.replace(/^\s+|\s+$/g, '');
        } else {
            field.value = "1";
        }

        document.getElementById("buy_product_total_value").textContent = "$" + (product_price * parseInt(field.value, 10));
    });

    document.getElementById("buy_product_close").addEventListener("click", function (event) {
        hide_window(document.getElementById("buy_product_background"));
    });
}