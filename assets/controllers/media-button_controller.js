import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    static targets = ['mediaList']
    toggle()
    {
        this.mediaListTarget.classList.toggle('d-none');
    }
}