import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        url: String,
        page: String,
        pageMax: String,
        arrowPageUpOn: Number,
        trickPerPage: Number
    }
    static targets = ['result','addTrickButton','endTrickButton','arrowPageUp']
    counter = 1;
    async onClickMore()
    {
        let page = parseInt(this.pageValue) + this.counter;
        if (this.arrowPageUpOnValue <= page * this.trickPerPageValue) {
            this.arrowPageUpTarget.classList.remove('d-none');
            this.arrowPageUpTarget.href = this.urlValue + '?page=' + page + '#tricks-list';
        }
        if (page >= this.pageMaxValue) {
            this.addTrickButtonTarget.classList.add('d-none');
            this.endTrickButtonTarget.classList.remove('d-none');
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