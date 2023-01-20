const modalContainer = document.querySelector(".modal-container");
const modalTriggers = document.querySelectorAll(".modal-trigger");
modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal));

function toggleModal(e)
{
    document.querySelector('#modal-delete-link').href = e.target.dataset.url
    modalContainer.classList.toggle("active")
}