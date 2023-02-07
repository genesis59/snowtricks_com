import {Controller} from "@hotwired/stimulus";


export default class extends Controller {

    static values = {
        url: String,
        page: String,
        pageMax: String
    }
    static targets = ['result','startButton','endButton']
    counter = 1;
    async onClickMoreComment()
    {
        let page = parseInt(this.pageValue) + this.counter;
        if (page > this.pageMaxValue) {
            return;
        }
        const params = new URLSearchParams({
            page : page,
            commentBystim: '1'
        }).toString();
        this.counter++;
        const response = await fetch(this.urlValue + '?' + params)
        this.resultTarget.innerHTML = await response.text();
        if (page >= this.pageMaxValue) {
            console.log('ici')
            console.log(this.startButtonTarget)
            console.log(this.endButtonTarget)
            this.startButtonTarget.classList.add('d-none');
            this.endButtonTarget.classList.remove('d-none');
        }
    }
}