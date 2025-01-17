let tabs = document.querySelectorAll('ul.tabs li');
tabs.forEach(tab => {
   tab.addEventListener('click', () => {
       let mainContainer = tab.closest('.tab_slider_wrapp');
       let itemsContainer = mainContainer.querySelector('.tabs-content.active');
       let tabContent = tab.closest('.tab_slider_wrapp').querySelector(`.tabs-content[data-code="${tab.getAttribute('data-code')}"]`);

       if(!tabContent) {
           itemsContainer.classList.add('loading-state');
           console.log(tab.getAttribute('data-code'));
           fetch(window.location.pathname, {
               method: 'POST',
               body: new URLSearchParams({
                   sectId: tab.getAttribute('data-code'),
                   tabsId: mainContainer.querySelector('.tabs-wrapper').getAttribute('data-id')
               }),
               headers: {'X-Requested-With': 'XMLHttpRequest'}
           }).then(res => {
               return res.text();
           }).then(data => {
               let activeTab = mainContainer.querySelector('.tabs-content.active');
               activeTab.classList.remove('active');

               let tabContentWrapper = document.createElement('div');
               tabContentWrapper.innerHTML = data;
               mainContainer.appendChild(tabContentWrapper.querySelector('.tabs-content'));
               itemsContainer.classList.remove('loading-state');

           }).catch((error) => console.log(error));
           console.log(tab.getAttribute('data-code'));
       } else {
           let activeTab = mainContainer.querySelector('.tabs-content.active');
           activeTab.classList.remove('active');
           tabContent.classList.add('active');
       }

   })
});