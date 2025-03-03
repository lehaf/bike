let tabs = document.querySelectorAll('.advert-tabs__item');
tabs.forEach(tab=> {
    tab.addEventListener('click', (event) => {
        event.preventDefault();
        tabs.forEach(item => {item.classList.remove('active')})
        tab.classList.add('active');
        document.querySelector('.advert-list')?.classList.add('loading-state');
        document.querySelector('.advert-empty')?.classList.add('loading-state');

        fetch(tab.href, {
            method: 'GET',
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            document.querySelector('.advert-list')?.remove();
            document.querySelector('.advert-empty')?.remove();
            document.querySelector('.advert-tabs').insertAdjacentHTML("afterend", data);
            initModeration();
        }).catch((error) => console.log(error));
    })
})

initModeration();
function initModeration() {
    let btns = document.querySelectorAll('.advert-btn-post, .advert-btn-pause');
    btns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            let element = event.target.closest('.advert-item');
            let action = event.target.getAttribute('data-action');
            moderationElement(element, action);
        });
    })

    let inputs = document.querySelectorAll('.custom-input');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            input.classList.remove('error');
        })
    })
}
function moderationElement(element, action) {
    let id = element.getAttribute('data-id');
    let text = element.querySelector('.custom-input').value;
    fetch('/ajax/moderation.php', {
        method: 'POST',
        body: new URLSearchParams({moderation:'Y',action: action, elementId: id, failText: text}),
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(res => {
        return res.json();
    }).then(data => {
        if(data['status'] === 'success') {
            element.remove();
            alert(data['message'])
        } else {
            element.querySelector('.custom-input').classList.add('error');
        }
    }).catch((error) => console.log(error));
}