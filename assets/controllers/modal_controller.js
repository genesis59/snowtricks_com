import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    onDelete(e)
    {
        const modalContainer = document.querySelector(".modal-container");
        document.querySelector('#modal-delete-link').href = e.target.dataset.url
        modalContainer.classList.toggle("active")
    }
}