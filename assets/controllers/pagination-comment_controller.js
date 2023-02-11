import {Controller} from "@hotwired/stimulus";
import {round} from "@popperjs/core/lib/utils/math";


export default class extends Controller {

    page = 1;
    pageMax = 1;
    static values = {
        url: String,
        countComment: Number,
        commentPerPage: Number
    }
    static targets = ['result','startButton','endButton','formComment']
    connect()
    {
        console.log(this.countCommentValue)
        console.log(this.commentPerPageValue)
        console.log(this.page)
        console.log(this.pageMax)
        this.pageMax = round(this.countCommentValue / this.commentPerPageValue);
        if (this.page >= this.pageMax) {
            this.startButtonTarget.classList.add('d-none');
            this.endButtonTarget.classList.remove('d-none');
        }
    }

    async onClickMoreComment()
    {
        this.page++;
        await this.getTemplate();
    }
    async onClickAddComment(e)
    {
        e.preventDefault();
        await fetch(this.formCommentTarget.action,{
            method: this.formCommentTarget.method,
            body: new URLSearchParams(new FormData(this.formCommentTarget))
        });
        this.countCommentValue++;
        this.pageMax = round(this.countCommentValue / this.commentPerPageValue);
        await this.getTemplate();
    }

    async getTemplate()
    {
        console.log(this.countCommentValue)
        console.log(this.commentPerPageValue)
        console.log(this.page)
        console.log(this.pageMax)
        if (this.page > this.pageMax) {
            return;
        }
        const params = new URLSearchParams({
            page : this.page,
            commentBystim: '1'
        }).toString();
        const response = await fetch(this.urlValue + '?' + params)
        this.resultTarget.innerHTML = await response.text();
        if (this.page >= this.pageMax) {
            this.startButtonTarget.classList.add('d-none');
            this.endButtonTarget.classList.remove('d-none');
        }
    }
}