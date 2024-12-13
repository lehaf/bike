let isBlockMoved = false;
//перемещение фильтра за пределы блока с объявлениями
$(document).on('ajaxSuccess', function (event, xhr, settings) {
    if (settings.url.includes('catalog') && isBlockMoved) {
        document.querySelector('.js-load-wrapper #filter').remove();
        document.querySelector('.js-load-wrapper .found-brand').remove();
    }
})
//загрузка страницы (прелоудер)
let container = document.querySelector('.container');
if (container) container.classList.add('loading-state');
document.addEventListener('DOMContentLoaded', () => {
   initAjaxFilter();
})

function initAjaxFilter() {
    let form = document.querySelector('#filter');
    let foundBrands = document.querySelector('.found-brand');
    if (form) {
        let filter = new AjaxFilter(form);
        let isTabsFilter = form.closest('.filter-tabs-content');

        if(!isTabsFilter) {
            isBlockMoved = filter.replaceFilterBlock(form);
            if(foundBrands) isBlockMoved = filter.replaceFilterBlock(foundBrands);
        }

        let checkboxes = form.querySelectorAll('input[type="checkbox"]:not(.no-send), input[type="radio"]');
        let inputs = form.querySelectorAll('input[type="text"]');
        let selects = form.querySelectorAll('select:not(.no-send)');
        let resetInputBtns = form.querySelectorAll(".reset-input");
        let saveSearchBtn = document.querySelector('.save-search__prev');
        let notifyCheckboxes = document.querySelectorAll('.dependent-checkbox');
        let notifySelects = document.querySelectorAll('.notify-select');

        if(!isTabsFilter) {
            history.replaceState(null, null, filter.generateUrl(true));
        }
        // filter.getElementsCount(true);

        inputs.forEach(input => {
            let inputVal = '';

            input.addEventListener('focus', (e) => {
                inputVal = e.target.value;
            });

            input.addEventListener('blur', (e) => {
                if (inputVal !== e.target.value) {
                    filter.getElementsCount();
                    filter.checkExistSearch(filter.generateFilterUrl());
                }
            });
        });

        resetInputBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filter.getElementsCount();
                filter.checkExistSearch(filter.generateFilterUrl());
            })
        })


        //изменение select
        selects.forEach(select => {
            select.addEventListener('change', (e) => {
                filter.changeSelect(select);
                filter.checkExistSearch(filter.generateFilterUrl());
            })

            if (select.multiple) {
                select.addEventListener('removeItem', (event) => {
                    filter.getElementsCount();
                    filter.checkExistSearch(filter.generateFilterUrl());
                })
            }
        })

        document.body.addEventListener('click', (event) => {
            if (event.target.closest(".add-select")) {
                let flexRows = document.querySelectorAll('.flex-row--new');
                if (flexRows.length !== 0) {
                    let flexLastRow = flexRows[flexRows.length - 1];
                    let selects = flexLastRow.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', (e) => {
                            filter.changeSelect(select);
                            filter.checkExistSearch(filter.generateFilterUrl());
                        })

                        if (select.multiple) {
                            select.addEventListener('removeItem', (event) => {
                                filter.getElementsCount();
                                filter.checkExistSearch(filter.generateFilterUrl());
                            })
                        }
                    })
                }
            } else if (event.target.closest(".remove-select")) { //удаление строки марки и модели
                filter.getElementsCount();
                filter.checkExistSearch(filter.generateFilterUrl());
            } else if (event.target.closest(".remove-save-item")) { //удаление поиска
                let btn = event.target.closest(".remove-save-item");
                let searchBlock = btn.closest('.save-list__item') || btn.closest('.save-search-popup');
                filter.deleteSearch(searchBlock);
            }
        })

        //получение количества элементов на checkboxes
        if (checkboxes.length !== 0) {
            checkboxes.forEach((check) => {
                check.addEventListener('click', (e) => {
                    filter.getElementsCount();
                    filter.checkExistSearch(filter.generateFilterUrl());
                });
            });
        }

        //индентификации select интервала отправки писем
        notifySelects.forEach(notifySelect => {
            let parentPopup = notifySelect.closest('.save-search-popup') || notifySelect.closest('.save-list__item');

            let dependentChecbox = parentPopup.querySelector('.dependent-checkbox');
            let notifyChoice = new Choices(notifySelect, {
                searchEnabled: false,
                shouldSort: false,
                position: 'bottom'
            })
            notifyChoice.disable();
            if (dependentChecbox.checked) {
                notifyChoice.enable();
            }

            filter.notifyChoices.push(notifyChoice);
            filter.listenerChoice(notifySelect, notifyChoice);
        })

        notifyCheckboxes.forEach(notifyCheck => {
            notifyCheck.addEventListener('change', function () {
                filter.activeNotify(notifyCheck);
            })
        })
        //конец индентификации

        //сохранение поиска
        if (saveSearchBtn) {
            if (saveSearchBtn.getAttribute('data-auth') === 'Y') {
                saveSearchBtn.addEventListener('click', () => {
                    let searchBlock = document.querySelector('.save-search-popup');
                    if (searchBlock) {
                        filter.addSearch(searchBlock);
                    }
                })
            }
        }

        //сброс формы
        form.addEventListener('reset', (event) => {
            event.preventDefault();
            inputs.forEach(input => {
                input.value = '';
            });

            checkboxes.forEach(check => {
                check.checked = false;
                if (check.classList.contains('radio-block') && check.value === '') {
                    check.checked = true;
                }
            });

            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    option.selected = false;
                });
            })

            let activeBlocks = document.querySelectorAll('.is-active');
            let countBlock = document.querySelector('.cnt-parameters');

            activeBlocks.forEach(block => {
                block.classList.remove('is-active')
            })
            countBlock.textContent = "0";
            countBlock.style.visibility = "hidden";

            history.replaceState(null, null, filter.emptyUrl);
            filter.getElementsCount();
            filter.checkExistSearch(filter.generateFilterUrl());
        })

        //отправка формы
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            filter.submit();
        })
    }
}
function AjaxFilter(form) {
    this.url = window.location.pathname;
    this.emptyUrl = window.location.pathname + "?set_filter=Y";
    this.filterParamsUrl = "";
    this.otherParams = "";
    this.params = this.getParams();
    this.form = form;
    this.filterName = this.form.getAttribute('data-filter') || "arFilter";
    this.sectionId = this.form.getAttribute('data-sect') || "0";
    this.notifyChoices = [];
}

AjaxFilter.prototype.getParams = function () {
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

    return params;
}

AjaxFilter.prototype.replaceFilterBlock = function (block) {
    let isBlockMoved = false;
    let wrapper = document.querySelector('.js_wrapper_items');
    if (wrapper) {
        block.remove();
        wrapper.parentNode.insertBefore(block, wrapper);
        isBlockMoved = true;
    }

    return isBlockMoved;
}

AjaxFilter.prototype.generateFilterUrl = function (isPageLoad = false) {
    let symbol = (this.params.hasOwnProperty("") && this.params[""] === undefined) ? "&" : "?";
    this.filterParamsUrl = symbol + "set_filter=Y";
    const filterData = {};
    let formData = new FormData(this.form);
    //преобразование марок и моделей
    let delParams = [];
    let marks = [];
    formData.forEach((value, key) => {
        if (!key.includes(this.filterName) || value === "0") delParams.push((key));

        const matchMark = key.match(/^arFilter_mark(_\d+)?$/); // поиск постфикса
        const matchModel = key.match(/^arFilter_model(_\d+)?$/);
        if (matchMark && value.length !== 0) {
            const postfix = matchMark[1] || '';
            filterData[value] = []; // Создаем массив для моделей с ключом mark (value)
            marks.push(value);
            delParams.push(matchMark[0]);
        } else if (matchModel) {
            delParams.push(matchModel[0]);
            const postfix = matchModel[1] || ''; // Соответствующий постфикс (например, '', '_2')
            const markKey = [...formData.entries()].find(([k]) => k === `arFilter_mark${postfix}`);
            if (markKey) {
                filterData[markKey[1]].push(value); // Добавляем модель в массив для соответствующего mark
            }
        }
    })

    //очищение от ненужных параметров марок и моделей
    delParams = [...new Set(delParams)];

    delParams.forEach(param => {
        formData.delete(param);
    })

    for (let el in filterData) {
        filterData[el] = filterData[el].sort();
        formData.append("arFilter_mark[" + el + "]", filterData[el])
    }
    //фильтрация множественных селектов
    let multipleSelects = document.querySelectorAll('select[multiple]');
    multipleSelects.forEach(selectElement => {
        if (!selectElement.id.includes("model-select")) {
            const sortedOptions = Array.from(selectElement.selectedOptions).sort((a, b) =>
                a.textContent.localeCompare(b.textContent)
            );

            sortedOptions.forEach(option => {
                let key = selectElement.name + "_" + option.value;
                formData.append(key, "Y");
            });
            formData.delete(selectElement.name);
        }
    });

    for (let pair of formData.entries()) {
        if (pair[1].length !== 0) {
            this.filterParamsUrl += "&" + pair[0] + "=" + pair[1];
        }
        if (pair[0].includes(this.filterName + '_mark[') && pair[1].length === 0) {
            this.filterParamsUrl += "&" + pair[0] + "=" + 'Y';
        }
    }

    marks = marks.map(item => this.filterName + '_mark[' + item + ']');
    for (let key in this.params) {
        if (key.includes(this.filterName + '_mark') && !marks.includes(key) && isPageLoad) this.filterParamsUrl += "&" + key + "=" + this.params[key];
    }


    return this.filterParamsUrl;
}

AjaxFilter.prototype.generateUrl = function (isPageLoad = false) {
    this.generateFilterUrl(isPageLoad);
    this.otherParams = "";
    for (let key in this.params) {
        if (!this.filterParamsUrl.includes(key) && !key.includes(this.filterName)) this.otherParams += "&" + key + "=" + this.params[key];
    }

    return this.url + this.filterParamsUrl + this.otherParams;
}

AjaxFilter.prototype.getElementsCount = function (isPageLoad = false) {

    this.generateUrl(isPageLoad);

    document.querySelector('.result-block').classList.add('loading-state');
    fetch('/ajax/elements_filter.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: "ajaxCount",
                url: this.filterParamsUrl,
                filterName: this.filterName,
                sectId: this.sectionId
            }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    ).then(res => {
        return res.json();
    }).then(data => {
        let result = document.querySelector('.result-block');
        if (result) {
            if (data != 0) {
                result.innerHTML = this.templateCountBtn(data);
            } else {
                result.innerHTML = this.templateCountEmpty();
            }
        }
        //
        document.querySelector('.result-block').classList.remove('loading-state');
        // document.querySelector('.container').classList.remove('loading-state');
        // document.querySelector('.num_el').innerHTML = "(" + data + ")";
    }).catch((error) => console.log(error));
}

AjaxFilter.prototype.changeSelect = function (select) {
    const hasResetOption = Array.from(select.options).some(option => option.value === 'reset');
    if (hasResetOption) {
        Array.from(select.options).forEach(option => {
            option.selected = false;
        });
    }
    document.querySelector('.result-block').classList.add('loading-state');
    this.getElementsCount();
}

AjaxFilter.prototype.submit = function () {
    //убираем все параметры кроме фильтра
    this.params = Object.keys(this.params)
        .filter(key => key.includes(this.filterName) || key === 'set_filter')
        .reduce((result, key) => {
            result[key] = this.params[key];
            return result;
        }, {});

    let url = this.generateUrl();
    let catalog = document.querySelector('.inner_wrapper');
    if(catalog) catalog.classList.add('loading-state');

    let tabsFilter = this.form.closest('.filter-tabs-content');

    if(tabsFilter) {
        let activeTab = document.querySelector('.advert-tabs__item.active');
        let activeSection = activeTab.getAttribute('data-type');
        let parentSection = tabsFilter.getAttribute('data-sect');
        window.location.href = '/catalog/' + parentSection + '/' + activeSection + url;
    } else {
        fetch(url, {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }
        ).then(res => {
            return res.text();
        }).then(data => {
            let tmpWrapper = document.createElement('div');
            tmpWrapper.innerHTML = data;
            catalog.classList.remove('loading-state');
            document.querySelector(".inner_wrapper").innerHTML = tmpWrapper.querySelector('.inner_wrapper').innerHTML;

            //изменение ссылки в кнопках отображения вида
            let displayBtns = document.querySelectorAll('a.controls-view__link');
            displayBtns.forEach(btn => {
                let queryString = btn.href.split('?')[1];
                let params = new URLSearchParams(queryString);
                let modifiedParamsUrl = "?display=" + params.get('display') + '&' + this.filterParamsUrl.substring(1) + this.otherParams;
                btn.setAttribute('data-url', this.url + modifiedParamsUrl);
                btn.href = this.url + modifiedParamsUrl;
            })

        }).catch((error) => console.log(error));
        history.replaceState(null, null, url);
        this.scrollToElements();
    }
}

AjaxFilter.prototype.scrollToElements = function () {
    let hiddenElem = document.querySelector('#right_block_ajax');
    let offsetTop = hiddenElem.getBoundingClientRect().top + window.pageYOffset - 80;  // отступ 20px сверху
    window.scrollTo({
        top: offsetTop,
        behavior: 'smooth'
    });
    // hiddenElem.scrollIntoView({block: "start", behavior: "smooth"});
}

AjaxFilter.prototype.templateCountBtn = function (count) {
    return ` <button class="selection-btn count">
            Показать <span>${count}</span> предложений
        </button> `;
}

AjaxFilter.prototype.templateCountEmpty = function () {
    return ` <div class="search-result count">
            <div class="search-result-mes">
                Ничего не найдено
            </div>
            <div class="search-result-text">
                Попробуйте изменить параметры поиска
            </div>
        </div>`;
}

AjaxFilter.prototype.activeNotify = function (notifyCheck) {
    let checkId = notifyCheck.getAttribute('data-id');
    let select = this.notifyChoices.find((el) => el.passedElement.element.id === "notify-select-" + checkId);

    if (notifyCheck.checked) {
        select.enable();
    } else {
        select.disable()
        select.containerInner.element.classList.remove("is-active");
        select.containerInner.element.closest('.form-group').classList.remove('is-active');
    }

    let parentPopup = notifyCheck.closest('.save-search-popup') || notifyCheck.closest('.save-list__item');
    this.editSearch(parentPopup);
}

AjaxFilter.prototype.addSearch = function (searchBlock) {
    this.generateFilterUrl();
    console.log(searchBlock.querySelector('.search-popup__parameters'));
    let ajaxParams = {
        action: "addSearch",
        title: searchBlock.querySelector('.search-popup__mark').innerText || '',
        description: searchBlock.querySelector('.search-popup__parameters').innerText || '',
        isNotify: searchBlock.querySelector('#emailMes').checked,
        notifyInterval: searchBlock.querySelector('#notify-select-0').value,
        searchQuery: this.filterParamsUrl,
        sectionId: this.sectionId
    };
    fetch('/ajax/filter_search.php', {
            method: 'POST',
            body: new URLSearchParams(ajaxParams),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    ).then(res => {
        return res.json();
    }).then(data => {
        if (data['success']) {
            let search = data['success'];

            document.querySelector('.save-search-popup').setAttribute('data-id', search['searchId']);
            $(".save-list").prepend(this.templateItemListSave(search['searchId'], search['title'], search['description'], '', this.filterParamsUrl));

            let select = document.querySelector(`#notify-select-${search['searchId']}`);

            const selectHistory = new Choices(select, {
                searchEnabled: false,
                shouldSort: false,
                duplicateItemsAllowed: false
            })
            selectHistory.disable();

            this.listenerChoice(select, selectHistory);
            this.notifyChoices.push(selectHistory);

            let notifyCheckbox = document.querySelector(`.dependent-checkbox[data-id="${search['searchId']}"]`);
            if (notifyCheckbox) {
                notifyCheckbox.addEventListener('change', () => this.activeNotify(notifyCheckbox))
            }
        }
    }).catch((error) => console.log(error));
}

AjaxFilter.prototype.editSearch = function (searchBlock) {
    let searchId = searchBlock.getAttribute('data-id');
    let isNotify = searchBlock.querySelector('input[type="checkbox"].dependent-checkbox').checked;
    let interval = searchBlock.querySelector('select.notify-select').value;

    let ajaxParams = {
        action: "editSearch",
        searchId: searchId,
        isNotify: isNotify,
        notifyInterval: interval,
    };
    fetch('/ajax/filter_search.php', {
            method: 'POST',
            body: new URLSearchParams(ajaxParams),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    ).then(res => {
        return res.json();
    }).then(data => {
        if(data['success']) {
            let blocks = document.querySelectorAll(`.save-list__item[data-id="${searchId}"], .save-search-popup[data-id="${searchId}"]`);
            let selectInSaveList = this.notifyChoices.find((el) => el.passedElement.element.id === "notify-select-" + searchId);
            let selectInSave = this.notifyChoices.find((el) => el.passedElement.element.id === "notify-select-0");
            let selects = [selectInSave, selectInSaveList];

            blocks.forEach(block => {
                block.querySelector('.dependent-checkbox').checked = isNotify;
            })

            selects.forEach(select => {
                select.setChoiceByValue(interval)
                if(isNotify) {
                    select.enable();
                    if (select.passedElement.element.value !== '' && select.passedElement.element.value !== 'reset') {
                        select.containerInner.element.classList.add("is-active");
                    }
                } else {
                    select.disable();
                    select.containerInner.element.classList.remove("is-active");
                    select.containerInner.element.closest('.form-group').classList.remove('is-active');
                }
            })
        }
    }).catch((error) => console.log(error));
}

AjaxFilter.prototype.deleteSearch = function (searchBlock) {
    let searchId = searchBlock.getAttribute('data-id');
    let ajaxParams = {
        action: "deleteSearch",
        searchId: searchId,
    };
    fetch('/ajax/filter_search.php', {
            method: 'POST',
            body: new URLSearchParams(ajaxParams),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    ).then(res => {
        return res.json();
    }).then(data => {
       if(data['success']) {
           if(searchBlock.classList.contains('save-list__item')) {
               let saveSearchPopup = document.querySelector('.save-search-popup');
               searchBlock.remove();

               if(saveSearchPopup.getAttribute('data-id') === searchId) {
                   saveSearchPopup.classList.remove('active');
                   document.querySelector('.save-search').classList.remove('active');
               }
           } else if (searchBlock.classList.contains('save-search-popup')) {
               searchBlock.classList.remove('active');
               document.querySelector('.save-search').classList.remove('active');

               let listSaveSearchItem = document.querySelector(`.save-list__item[data-id="${searchId}"]`);
               if(listSaveSearchItem) {
                   listSaveSearchItem.remove();
               }
           }

           let saveItems = document.querySelectorAll('.save-list__item');
           if(saveItems.length === 0) {
               document.querySelector('.save-list-container').classList.add('hidden');
           }
       }
    }).catch((error) => console.log(error));
}

AjaxFilter.prototype.checkExistSearch = function (filterUrl) {
    fetch('/ajax/filter_search.php', {
            method: 'POST',
            body: new URLSearchParams({
                action : 'existSearch',
                url : filterUrl,
                sectionId: this.sectionId
            }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    ).then(res => {
        return res.json();
    }).then(data => {
       if(data['success']) {
           document.querySelector('.save-search__prev').parentElement.classList.add("active");
           let popup = document.querySelector('.save-search-popup');
           let select = this.notifyChoices.find((el) => el.passedElement.element.id === "notify-select-" + data['success']['id']);

           popup.setAttribute('data-id', data['success']['id']);
           popup.querySelector('.search-popup__mark').innerText = data['success']['title'];
           popup.querySelector('.search-popup__parameters').innerText = data['success']['description'];

           if(data['success']['interval'] !== "0") {
               popup.querySelector('.dependent-checkbox').checked = true;
               select.setChoiceByValue(data['success']['interval']);
               select.enable();
           }
       } else {
           document.querySelector('.save-search__prev').parentElement.classList.remove("active");
           let popup = document.querySelector('.save-search-popup');
           let select = this.notifyChoices.find((el) => el.passedElement.element.id === "notify-select-0");

           popup.querySelector('.dependent-checkbox').checked = false;
           select.setChoiceByValue('');
           select.containerInner.element.classList.remove('is-active');
           select.containerInner.element.closest('.form-group').classList.remove('is-active');
           select.disable();
       }
    }).catch((error) => console.log(error));
}

AjaxFilter.prototype.listenerChoice = function (el, select) {
    el.addEventListener('change', (event) => {
            let textContent = event.target.textContent.replace(/\s+/g, '')
            if (textContent === "Сбросить" || textContent === "Любая" || textContent === "Любой") {
                select.setChoiceByValue('');
                setTimeout(() => {
                    select.containerInner.element.classList.remove("is-active");
                    el.closest('.form-group').classList.remove("is-active");
                }, 0)
            }

            setTimeout(() => {
                $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                select.containerInner.element.classList.add("is-active");
                el.closest('.form-group').classList.add("is-active");
            }, 0)

            let parentPopup = el.closest('.save-search-popup') || el.closest('.save-list__item');
            this.editSearch(parentPopup);
        },
        false,
    );
}

AjaxFilter.prototype.templateItemListSave = function (id, title, desc, checked, url) {
    return `<div class="save-list__item" data-id="${id}">
                <a href="${url}" class="search-popup__mark">${title}</a>
                <a href="${url}" class="search-popup__parameters">${desc}</a>
                <div class="form-row form-row-checkbox form-row-checkbox--selection no-save">
                    <input type="checkbox" class="no-send input-checkbox dependent-checkbox" name="emailMes" id="emailMes-${id}" ${checked} data-id="${id}">
                    <label for="emailMes-${id}" class="checkbox-label">Уведомления на электронную почту</label>
                </div>
                                
                <div class="form-group custom-select-inner form-group-custom-select color-select no-save no-send">
                    <select class="select-type notify-select right-select no-send" id="notify-select-${id}">
                        <option value="">
                            Получать письма
                        </option>
                        <option value="reset">
                            Сбросить
                        </option>
                        <option value="4">
                            Получать письма каждые 4 часа
                        </option>
                        <option value="8">
                            Получать письма каждые 8 часа
                        </option>
                        <option value="24">
                            Получать письма каждые 24 часа
                        </option>
                    </select>
                </div>
                <div class="remove-save-item">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.2853 15.9999H3.42815C2.48284 15.9999 1.71387 15.2309 1.71387 14.2856V5.14272C1.71387 4.82717 1.96975 4.57129 2.2853 4.57129H11.4282C11.7437 4.57129 11.9996 4.82717 11.9996 5.14272V14.2856C11.9996 15.2309 11.2306 15.9999 10.2853 15.9999ZM2.85672 5.71415V14.2856C2.85672 14.6006 3.11312 14.857 3.42815 14.857H10.2853C10.6003 14.857 10.8567 14.6006 10.8567 14.2856V5.71415H2.85672Z" fill="#ED1C24"/>
                                    <path d="M12 5.71446H1.71429C0.768972 5.71446 0 4.94549 0 4.00017C0 3.05486 0.768972 2.28589 1.71429 2.28589H12C12.9453 2.28589 13.7143 3.05486 13.7143 4.00017C13.7143 4.94549 12.9453 5.71446 12 5.71446ZM1.71429 3.42875C1.39926 3.42875 1.14286 3.68515 1.14286 4.00017C1.14286 4.3152 1.39926 4.5716 1.71429 4.5716H12C12.315 4.5716 12.5714 4.3152 12.5714 4.00017C12.5714 3.68515 12.315 3.42875 12 3.42875H1.71429Z" fill="#ED1C24"/>
                                    <path d="M9.14286 3.42857H4.57143C4.25589 3.42857 4 3.17269 4 2.85714V0.571429C4 0.255886 4.25589 0 4.57143 0H9.14286C9.4584 0 9.71429 0.255886 9.71429 0.571429V2.85714C9.71429 3.17269 9.4584 3.42857 9.14286 3.42857ZM5.14286 2.28571H8.57143V1.14286H5.14286V2.28571Z" fill="#ED1C24"/>
                                    <path d="M5.14272 13.7138C4.82717 13.7138 4.57129 13.4579 4.57129 13.1424V7.42812C4.57129 7.11258 4.82717 6.85669 5.14272 6.85669C5.45826 6.85669 5.71415 7.11258 5.71415 7.42812V13.1424C5.71415 13.4579 5.45826 13.7138 5.14272 13.7138Z" fill="#ED1C24"/>
                                    <path d="M8.57094 13.7143C8.2554 13.7143 7.99951 13.4584 7.99951 13.1429V7.42861C7.99951 7.11306 8.2554 6.85718 8.57094 6.85718C8.88648 6.85718 9.14237 7.11306 9.14237 7.42861V13.1429C9.14237 13.4584 8.88648 13.7143 8.57094 13.7143Z" fill="#ED1C24"/>
                                </svg>
                                Удалить поиск
                            </div>
        </div>`
}





