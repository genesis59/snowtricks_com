import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        url: String,
        page: String,
        pageMax: String
    }
    static targets = ['result','addTrickButton','endTrickButton']
    counter = 1;
    async onClickMore()
    {
        let page = parseInt(this.pageValue) + this.counter;
        if (page >= this.pageMaxValue) {
            this.addTrickButtonTarget.classList.add('d-none');
            this.endTrickButtonTarget.classList.remove('d-none');
            this.endTrickButtonTarget.classList.remove('d-inline-block');
        }
        if (page > this.pageMaxValue) {
            return;
        }
        let params = new URLSearchParams({
            page: page,
            addByStim: 1
        }).toString();
        this.counter++;
        const response = await fetch(this.urlValue + '?' + params);
        this.resultTarget.innerHTML = await response.text();
    }
}