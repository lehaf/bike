let isBlockMoved = false;
//перемещение фильтра за пределы блока с объявлениями
$(document).on('ajaxSuccess', function (event, xhr, settings) {
    if (settings.url.includes('catalog') && isBlockMoved) {
        document.querySelector('.js-load-wrapper #filter').remove();
    }
})
//загрузка страницы (прелоудер)
let container = document.querySelector('.container');
if (container) container.classList.add('loading-state');

document.addEventListener('DOMContentLoaded', () => {
    let form = document.querySelector('#filter');
    if (form) {
        let filter = new AjaxFilter(form);

        isBlockMoved = filter.replaceFilterBlock();

        let checkboxes = form.querySelectorAll('input[type="checkbox"]:not([name="emailMes"]), input[type="radio"]');
        let inputs = form.querySelectorAll('input[type="text"]');
        let selects = form.querySelectorAll('select');
        let resetInputBtns = form.querySelectorAll(".reset-input");

        let url = filter.generateUrl();
        for (let key in filter.params) {
            if (key.includes(filter.filterName + '_mark')) url += "&" + key + "=" + filter.params[key];
        }

        history.replaceState(null, null, url);
        filter.getElementsCount(url);

        inputs.forEach(input => {
            let inputVal = '';

            input.addEventListener('focus', (e) => {
                inputVal = e.target.value;
            });

            input.addEventListener('blur', (e) => {
                if (inputVal !== e.target.value) {
                    filter.getElementsCount();
                }
            });
        });

        resetInputBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filter.getElementsCount();
            })
        })

        //изменение select
        selects.forEach(select => {
            select.addEventListener('change', (e) => {
                filter.changeSelect(select);
            })

            if (select.multiple) {
                select.addEventListener('removeItem', (event) => {
                    filter.getElementsCount();
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
                        })
                    })
                }
            } else if (event.target.closest(".remove-select")) {
                filter.getElementsCount();
            }
        })

        //получение количества элементов на checkboxes
        if (checkboxes.length !== 0) {
            checkboxes.forEach((check) => {
                check.addEventListener('click', (e) => {
                    filter.getElementsCount();
                });
            });
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
        })

        //отправка формы
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            filter.submit();
        })
    }
})

function AjaxFilter(form) {
    this.url = window.location.pathname;
    this.emptyUrl = window.location.pathname + "?set_filter=Y";
    this.paramsUrl = "";
    this.params = this.getParams();
    this.form = form;
    this.filterName = this.form.getAttribute('data-filter') || "arFilter";
    this.sectionId = this.form.getAttribute('data-sect') || "0";
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

AjaxFilter.prototype.replaceFilterBlock = function () {
    let isBlockMoved = false;
    let wrapper = document.querySelector('.js_wrapper_items');
    if (wrapper) {
        this.form.remove();
        wrapper.parentNode.insertBefore(this.form, wrapper);
        isBlockMoved = true;
    }

    return isBlockMoved;
}

AjaxFilter.prototype.generateUrl = function () {
    let symbol = (this.params.hasOwnProperty("") && this.params[""] === undefined) ? "&" : "?";
    this.paramsUrl = symbol + "set_filter=Y";
    const filterData = {};
    let formData = new FormData(this.form);
    //преобразование марок и моделей
    let delParams = [];
    formData.forEach((value, key) => {
        const matchMark = key.match(/^arFilter_mark(_\d+)?$/); // поиск постфикса
        const matchModel = key.match(/^arFilter_model(_\d+)?$/);
        if (matchMark && value.length !== 0) {
            const postfix = matchMark[1] || '';
            filterData[value] = []; // Создаем массив для моделей с ключом mark (value)
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

    for (const el in filterData) {
        formData.append("arFilter_mark[" + el + "]", filterData[el])
    }
    //фильтрация множественных селектов
    let multipleSelects = document.querySelectorAll('select[multiple]');
    multipleSelects.forEach(selectElement => {
        if (!selectElement.id.includes("model-select")) {
            Array.from(selectElement.selectedOptions).forEach(option => {
                let key = selectElement.name + "_" + option.value;
                formData.append(key, "Y");
            });
            formData.delete(selectElement.name);
        }
    });

    for (let pair of formData.entries()) {
        if (pair[1].length !== 0) {
            this.paramsUrl += "&" + pair[0] + "=" + pair[1];
        }
        if (pair[0].includes(this.filterName + '_mark[') && pair[1].length === 0) {
            this.paramsUrl += "&" + pair[0] + "=" + 'Y';
        }
    }

    for (let key in this.params) {
        if (!this.paramsUrl.includes(key) && !key.includes(this.filterName)) this.paramsUrl += "&" + key + "=" + this.params[key];
    }

    return this.url + this.paramsUrl;
}

AjaxFilter.prototype.getElementsCount = function (url = '') {
    if (url === "") {
        this.generateUrl();
    } else {
        this.paramsUrl = url.split('?')[1];
    }

    document.querySelector('.result-block').classList.add('loading-state');
    fetch('/ajax/elements_filter.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: "ajaxCount",
                url: this.paramsUrl,
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
        document.querySelector('.result-block').classList.remove('loading-state');
        document.querySelector('.container').classList.remove('loading-state');

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
    catalog.classList.add('loading-state');

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
            let modifiedParamsUrl = "?display=" + params.get('display') + '&' + this.paramsUrl.substring(1);
            btn.setAttribute('data-url', this.url + modifiedParamsUrl);
            btn.href = this.url + modifiedParamsUrl;
        })

    }).catch((error) => console.log(error));
    history.replaceState(null, null, url);
    this.scrollToElements();
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






