document.addEventListener('DOMContentLoaded', () => {
    let currentUrl = window.location.href;
    let url = new URL(window.location.href);
    let searchParams = url.searchParams;


    init();

    function init() {
        let params = window
            .location
            .search
            .replace('?', '')
            .split('&')
            .reduce(
                function (p, e) {
                    var a = e.split('=');
                    p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                    return p;
                },
                {}
            );
        let symbol = (params[''] === 'undefined') ? '?' : '&';

        setTabs();
        setItems();
        setMenuItems();
        setSelect();
        productsTabs();
        updateCategorySelect();
        updateProducts();
    }

    function setTabs() {
        let tabs = document.querySelectorAll('.advert-tabs__item');
        let subTabs = document.querySelectorAll('.menu-item a');
        if (tabs.length !== 0) {
            let section = searchParams.get('section');

            if (!section) {
                searchParams.append('section', tabs[0].getAttribute('data-sect'));
                window.history.pushState({}, '', `${url.pathname}?${searchParams.toString()}`);
                tabs[0].classList.add('active');
                getAds(url.href);
            }

            if (!document.querySelector('.advert-tabs__item[data-sect="' + section + '"]')) {
                let container = document.querySelector('.container');
                container.style.filter = "blur(5px)";
                searchParams.set('section', tabs[0].getAttribute('data-sect'));
                window.history.pushState({}, '', `${url.pathname}?${searchParams.toString()}`)
                getAds(url.href);
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', event => {
                    event.preventDefault();

                    let activeTab = document.querySelector('.advert-tabs__item.active');
                    if (activeTab) {
                        activeTab.classList.remove('active');
                    }
                    tab.classList.add('active');

                    searchParams.set('section', tab.getAttribute('data-sect'));
                    window.history.pushState({}, '', `${url.pathname}?${searchParams.toString()}`);
                    getAds(url.href);
                })
            })
        }
    }

    function updateProducts() {
        let updateProductBtn = document.querySelector('.product-update-btn');
        if (updateProductBtn) {
            updateProductBtn.addEventListener('click', (event) => {
                event.preventDefault();
                let updateProductSelect = document.querySelector('#updateProduct');
                let action = updateProductSelect.value;
                let elements = document.querySelectorAll('input.product-check:checked');
                let elementsId = elements.length !== 0 ? Array.from(elements).map(element => element.value) : [];

                if(action === 'delete') {
                    showDeletePopupAjax(elements);
                } else {
                    ajaxAction(action, elements);
                }
            })
        }

        let checkAllProducts = document.querySelector('#all-product-2');
        let itemCheck = document.querySelectorAll('input.product-check');
        if (checkAllProducts) {
            checkAllProducts.addEventListener('change', (event) => {
                let isChecked = checkAllProducts.checked;
                itemCheck.forEach(item => {
                    item.checked = isChecked;
                })
            })
        }
    }

    function setItems() {
        let items = document.querySelectorAll('.advert-item, .product-advert__item');

        items.forEach(item => {
            item.addEventListener('click', (event) => {
                let target = event.target;

                if (target.tagName.toLowerCase() === 'svg') {
                    target = target.parentElement;
                } else if (target.tagName.toLowerCase() === 'path') {
                    let svgParent = target.closest('svg');
                    target = svgParent.parentElement;
                }


                if (target.classList.contains('advert-btn-pause')) {
                    event.preventDefault();
                    ajaxAction('pause', [target]);
                }

                if (target.classList.contains('advert-btn-post')) {
                    event.preventDefault();
                    ajaxAction('active', [target]);
                }

                if (target.classList.contains('advert-edit__del')) {
                    event.preventDefault();
                    showDeletePopupAjax([target]);
                }
            })
        })
    }

    function showDeletePopupAjax(elements) {
        fetch('/ajax/form_custom.php', {
            method: 'POST',
            body: new URLSearchParams({type: 'delete'}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            let form = document.createElement('div');
            form.innerHTML = data;
            document.querySelector('#popup_iframe_wrapper').prepend(form.querySelector('.jqmOverlay'));
            document.querySelector('#popup_iframe_wrapper').appendChild(form.querySelector('.delete_frame'));
            $('.delete_frame ').addClass('show');

            document.querySelector('#popup_iframe_wrapper').style.zIndex = "3000";
            document.querySelector('#popup_iframe_wrapper').style.display = "flex";

            $(document).on('click', '.jqmClose', function(e){
                e.preventDefault();
                $(this).closest('#popup_iframe_wrapper').removeAttr('style');
                $(this).closest('.delete_frame').remove();
                $('.jqmOverlay').remove();
            })

            $(".jqmOverlay").on("click", function () {
                $("#popup_iframe_wrapper").css("display", "none");
                $(".delete_frame").remove();
            });

            let delAgree = document.querySelector('#popup_iframe_wrapper .btn-del');
            delAgree.addEventListener('click', () => {
                ajaxAction('delete', elements);
            })
        }).catch((error) => console.log(error));
    }

    function ajaxAction(action, elements) {
        let parentBlock = document.querySelector('.product-advert, .advert-list');
        let elementsId = [];
        let elementsBlock = [];
        elements.forEach(element => {
            let elementBlock = element.closest('.advert-item') || element.closest('.product-advert__item');
            elementsId.push(elementBlock.getAttribute('data-id'));
            elementsBlock.push(elementBlock);
        })

        let params = new URLSearchParams({
            action: action,
            iblock: parentBlock.getAttribute('data-iblock')
        });

        elementsId.forEach(id => {
            params.append('elementsId[]', id);
        });

        if (action === 'price') {
            let price = document.querySelector('.product-custom-block input');
            if (price.value.length !== 0) {
                params.append('price', price.value);
            } else {
                return;
            }
        }

        if (action === 'category') {
            let section = document.querySelector('#section');
            if (section.value.length !== 0) {
                params.append('section', section.value);
            } else {
                return;
            }
        }


        fetch('/ajax/edit_element.php', {
            method: 'POST',
            body: params,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.json();
        }).then(data => {
            if (action === 'pause' || action === 'active') {
                setElementStatus(data, elementsBlock);
            }

            if (action === 'delete') {
                elementsBlock.forEach(element => {
                    element.remove();
                })

                getAds(window.location.href);
            }

            if (action === 'category') {
                let section = document.querySelector('#section');
                let sectionName = section.options[0].text;
                elementsBlock.forEach(element => {
                    element.querySelector('.product-item__name').innerHTML = sectionName;
                })

                ajaxUpdateProductsMenu();
            }

        }).catch((error) => console.log(error));
    }

    function ajaxUpdateProductsMenu() {
        fetch(url.href, {
            method: 'POST',
            body: new URLSearchParams({action: 'updateProductsMenu'}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            let menu = document.querySelector('.product-menu ul.menu');
            menu.innerHTML = data;
            setMenuItems();
        }).catch((error) => console.log(error));
    }

    function templateStatusPause(text, desc) {
        return `<div class="advert-item__status__content__btn">
                            <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="3" cy="3" r="3" fill="#ED1C24"/>
                            </svg>
                            ${text}
                        </div>
                        <span>${desc}</span>`
    }

    function templateBtnPause(text) {
        return `<a href="#" class="advert-btn-pause">
                         ${text}
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.5 0C2.91744 0 0 2.91744 0 6.5C0 10.0826 2.91744 13 6.5 13C10.0826 13 13 10.0826 13 6.5C13 2.91744 10.0826 0 6.5 0ZM5.44186 8.76744C5.44186 9.02442 5.24535 9.22093 4.98837 9.22093C4.7314 9.22093 4.53488 9.02442 4.53488 8.76744V4.23256C4.53488 3.97558 4.7314 3.77907 4.98837 3.77907C5.24535 3.77907 5.44186 3.97558 5.44186 4.23256V8.76744ZM8.46512 8.76744C8.46512 9.02442 8.2686 9.22093 8.01163 9.22093C7.75465 9.22093 7.55814 9.02442 7.55814 8.76744V4.23256C7.55814 3.97558 7.75465 3.77907 8.01163 3.77907C8.2686 3.77907 8.46512 3.97558 8.46512 4.23256V8.76744Z" fill="#ED1C24"></path>
                        </svg>
                    </a>`
    }

    function templateStatusActive(text, desc) {
        return `<div class="advert-status--published">
                           <svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="3" cy="3" r="3" fill="#30A960"/>
                           </svg>
                           ${text}
                       </div>
                       <span>
                           <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 0.5C2.91744 0.5 0 3.41744 0 7C0 10.5826 2.91744 13.5 6.5 13.5C10.0826 13.5 13 10.5826 13 7C13 3.41744 10.0826 0.5 6.5 0.5ZM5.44186 9.26744C5.44186 9.52442 5.24535 9.72093 4.98837 9.72093C4.7314 9.72093 4.53488 9.52442 4.53488 9.26744V4.73256C4.53488 4.47558 4.7314 4.27907 4.98837 4.27907C5.24535 4.27907 5.44186 4.47558 5.44186 4.73256V9.26744ZM8.46512 9.26744C8.46512 9.52442 8.2686 9.72093 8.01163 9.72093C7.75465 9.72093 7.55814 9.52442 7.55814 9.26744V4.73256C7.55814 4.47558 7.75465 4.27907 8.01163 4.27907C8.2686 4.27907 8.46512 4.47558 8.46512 4.73256V9.26744Z" fill="#30A960"/>
    </svg>

                                                ${desc}</span>`
    }

    function templateBtnActive(text) {
        return `<a href="" class="advert-btn-post">
                            ${text}
                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.14738 0.808087C1.99486 0.89135 1.9 1.05124 1.9 1.225L1.9 9.775C1.9 9.94875 1.99486 10.1086 2.14738 10.1919C2.2999 10.2752 2.48567 10.2685 2.63188 10.1746L9.28186 5.89957C9.41782 5.81217 9.5 5.66164 9.5 5.5C9.5 5.33836 9.41782 5.18783 9.28186 5.10043L2.63188 0.825439C2.48568 0.731479 2.2999 0.724824 2.14738 0.808087Z"
                                      fill="#028F3A"/>
                                <path d="M0.949218 9.775C0.949218 10.0373 0.736561 10.25 0.474218 10.25C0.211876 10.25 -0.000781644 10.0373 -0.000781633 9.775L-0.000781259 1.225C-0.000781247 0.962667 0.211876 0.75 0.474219 0.75C0.736561 0.75 0.949219 0.962667 0.949219 1.225L0.949218 9.775Z"
                                      fill="#028F3A"/>
                            </svg>
                        </a>`
    }

    function setElementStatus(data, elements) {
        elements.forEach(element => {
            let statusBlock = element.querySelector('.advert-item__status__content');
            element.querySelector('.advert-btn-pause, .advert-btn-post').remove();
            let upBtn = element.querySelector('.advert-btn-up');
            let newBtn = document.createElement('div');
            const updateStatusAndButton = (statusHtml, btnHtml, isChecking) => {
                if (statusBlock) {
                    statusBlock.innerHTML = statusHtml;
                    statusBlock.classList.toggle('checking', isChecking);
                }
                newBtn.innerHTML = btnHtml;
                upBtn.after(newBtn.querySelector('a'));
            };

            if (data['status'] === 'pause') {
                updateStatusAndButton(
                    templateStatusPause(data['statusText'], data['statusDesc']),
                    templateBtnActive(data['btnText']),
                    false
                );
            }

            if (data['status'] === 'active') {
                updateStatusAndButton(
                    templateStatusActive(data['statusText'], data['statusDesc']),
                    templateBtnPause(data['btnText']),
                    true
                );
            }
        })
    }

    function setMenuItems() {
        let menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(function (menuItem) {
            let link = menuItem.querySelector('a');
            let submenu = menuItem.querySelector('.submenu');
            let arrow = menuItem.querySelector('.arrow');

            if (submenu) {
                menuItem.classList.add('has-submenu');

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    let isOpen = submenu.style.display === 'block';

                    if (isOpen) {
                        submenu.style.display = 'none';
                        arrow.classList.remove("active")
                        this.classList.remove("active")
                    } else {
                        this.classList.add("active")
                        submenu.style.display = 'block';
                        arrow.classList.add("active")
                    }
                });
            }
        });
        productsTabs();
    }

    function setSelect() {
        const selectList = document.querySelectorAll(".custom-select");
        selectList.forEach((el) => {
            if (el.classList.contains("selectSearch")) {
                let text = el.getAttribute("data-text")
                const selectSearch = new Choices(el, {
                    searchEnabled: true,
                    shouldSort: false,
                    searchPlaceholderValue: text,
                    position: 'bottom'
                })
                if (el.id === 'categorySelect') {
                    selectCategory = selectSearch;
                }

                listenerSelect(el, selectSearch)
            } else {
                const selectType = new Choices(el, {
                    searchEnabled: false,
                    shouldSort: false,
                    position: 'bottom'
                })
            }
        })

        $('.choices__item--choice[data-id=1]').hide();
    }

    function listenerSelect(el, select) {
        el.addEventListener(
            'change',
            function (event) {
                let textContent = event.target.textContent.replace(/\s+/g, '')
                if (textContent === "Сбросить") {
                    select.setChoiceByValue('');
                }
                setTimeout(() => {
                    $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                }, 0)
            },
            false,
        );
    }

    function productsTabs() {
        let productTabs = document.querySelectorAll('.last');
        if (productTabs.length !== 0) {
            productTabs.forEach(tab => {
                tab.addEventListener('click', event => {
                    event.preventDefault();
                    let symbol = (searchParams.toString()) ? '&' : '?';
                    let newUrl = url.href + symbol + 'subsection=' + tab.getAttribute('data-sect');
                    let activeTab = document.querySelector('a.selected');
                    if (activeTab) {
                        activeTab.classList.remove('selected');
                    }
                    console.log(newUrl);
                    tab.classList.add('selected');
                    getProducts(newUrl);
                })
            })
        }
    }

    function getAds(url) {
        let tabsBlock = document.querySelector('.advert-tabs');
        let oldListBlock = document.querySelector('.advert-list') || document.querySelector('.product-block');
        let container = document.querySelector('.container');
        if (oldListBlock) oldListBlock.style.filter = 'blur(5px)';

        fetch(url, {
            method: 'GET',
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            container.innerHTML = data;
            container.removeAttribute('style');
            init();
        }).catch((error) => console.log(error));
    }

    function getProducts(url) {
        let listBlock = document.querySelector('.product-advert');
        listBlock.style.filter = 'blur(5px)';
        fetch(url, {
            method: 'GET',
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            listBlock.innerHTML = data;
            listBlock.removeAttribute('style');
        }).catch((error) => console.log(error));
    }

    function updateCategorySelect() {
        let updateProductSelect = document.querySelector('#updateProduct');
        if (updateProductSelect) {
            updateProductSelect.onchange = (event) => {
                let productUpdate = document.querySelector('.product-update-select');
                let productCustomBlock = document.querySelector('.product-custom-block');
                if (productCustomBlock) productCustomBlock.remove();

                if (updateProductSelect.value === 'category') {
                    fetch('/ajax/edit_product.php', {
                        method: 'POST',
                        body: new URLSearchParams({action: 'getCategories', sectId: searchParams.get('section')}),
                        headers: {'X-Requested-With': 'XMLHttpRequest'}
                    }).then(res => {
                        return res.json();
                    }).then(data => {
                        let div = document.createElement('div');
                        div.className = 'product-custom-block';
                        div.innerHTML = data;
                        productUpdate.after(div);
                        let select = document.querySelector('#section');

                        const selectType = new Choices(select, {
                            searchEnabled: false,
                            shouldSort: false,
                            position: 'bottom'
                        })
                        $('.choices__item--choice[data-id=1]').hide();

                    }).catch((error) => console.log(error));
                }

                if (updateProductSelect.value === 'price') {
                    let div = document.createElement('div');
                    div.className = 'product-custom-block';
                    let input = document.createElement('input');
                    input.type = 'text';
                    div.appendChild(input);

                    productUpdate.after(div);
                }

            }
        }
    }
})