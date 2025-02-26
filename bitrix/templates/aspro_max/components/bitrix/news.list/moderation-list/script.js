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
        console.log(data.status);
    }).catch((error) => console.log(error));
}