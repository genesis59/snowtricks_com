import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        url: String,
        page: String,
        pageMax: String,
        arrowPageUpOn: Number,
        trickPerPage: Number,
        countTricks: Number
    }
    static targets = ['result','addTrickButton','endTrickButton','arrowPageUp']

    connect()
    {
        if (this.countTricksValue <= this.trickPerPageValue) {
            this.arrowPageUpTarget.classList.add('d-none');
            this.addTrickButtonTarget.classList.add('d-none');
            this.endTrickButtonTarget.classList.remove('d-none');
        }
        if (this.pageValue * this.trickPerPageValue > this.countTricksValue) {
            this.addTrickButtonTarget.classList.add('d-none');
            this.endTrickButtonTarget.classList.remove('d-none');
        }
    }

    counter = 1;
    async onClickMore()
    {
        let page = parseInt(this.pageValue) + 1;
        let countTricksOnPage = this.countTricksValue < (page * this.trickPerPageValue) ? this.countTricksValue : (page * this.trickPerPageValue);
        if (this.arrowPageUpOnValue <= countTricksOnPage) {
            this.arrowPageUpTarget.classList.remove('d-none');
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
        this.pageValue++;
        const response = await fetch(this.urlValue + '?' + params);
        this.resultTarget.innerHTML = await response.text();
    }
}