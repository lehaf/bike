const urlObj = new URL(window.location);
const searchParams = urlObj.searchParams;
let accordionId = searchParams.get('tab');

if(accordionId) {
    const accordion = document.querySelector(`.accordion-head[href='#${accordionId}']`);
    accordion?.parentElement.classList.add('opened');
    accordion?.click();
}

