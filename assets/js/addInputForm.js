document.querySelectorAll('.add_item_link').forEach(btn => {
    btn.addEventListener("click", addFormToCollection)
});

document.querySelectorAll('ul.videos li').forEach((video) => {
    addTagFormDeleteLink(video)
})
document.querySelectorAll('ul.pictures li').forEach((picture) => {
    addTagFormDeleteLink(picture)
})

function addFormToCollection(e)
{
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    const item = document.createElement('li');
    item.classList.add('row', 'ps-0', 'pe-0', 'm-0');
    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );
    item.childNodes[0].classList.add('col-10', 'ps-0');
    addTagFormDeleteLink(item)
    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;
}

function addTagFormDeleteLink(item)
{
    const removeFormButton = document.createElement('button');
    removeFormButton.classList.add('col-2', 'btn', 'btn-danger', 'align-self-start', 'justify-self-end');
    const img = document.createElement('img')
    img.src = document.querySelector('.add_item_link').dataset.urlIconDelete;
    img.classList.add('icon-delete-field');
    removeFormButton.appendChild(img);
    item.append(removeFormButton);
    item.childNodes[0].classList.add('col-10', 'ps-0');

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });
}
