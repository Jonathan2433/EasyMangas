// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
let btn = document.getElementsByClassName("myBtn");
// Get the area where inner the data
let text = document.getElementById("modal-manga-name");

// Get the area where inner the data in link
let btnAdd= document.getElementById("modal-btn-add");

// When the user clicks on the button, open the modal
let dataName;
let dataId;
for (let i = 0; i < btn.length; i++) {
    btn[i].onclick = function () {
        modal.style.display = "block";
        dataName = btn[i].getAttribute("data-name");

        text.innerHTML = dataName;
        dataId = btn[i].getAttribute("data-id");
        btnAdd.innerHTML =
            `
                <a href="add-to-library?mangaId=` +
            dataId +
            `" class="p-1 bg-dark color-light">Yes I want Add this manga to my library !</a>
                `;
    };
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

