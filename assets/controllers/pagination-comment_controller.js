import {Controller} from "@hotwired/stimulus";


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
        this.pageMax = Math.ceil(this.countCommentValue / this.commentPerPageValue);
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
        const response = await fetch(this.formCommentTarget.action,{
            method: this.formCommentTarget.method,
            body: new URLSearchParams(new FormData(this.formCommentTarget))
        });
        if (!response.ok) {
            this.formCommentTarget.submit()
        } else {
            this.countCommentValue++;
            this.pageMax = Math.ceil(this.countCommentValue / this.commentPerPageValue);
            await this.getTemplate();
        }

    }

    async getTemplate()
    {
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