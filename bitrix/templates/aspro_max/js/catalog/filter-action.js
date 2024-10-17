let isBlockMoved = false;
$(document).on('ajaxSuccess', function (event, xhr, settings) {
    if (settings.url.includes('catalog') && isBlockMoved) {
        document.querySelector('.js-load-wrapper #filter').remove();
    }
})

document.addEventListener('DOMContentLoaded', () => {
    let form = document.querySelector('#filter');
    //отправка формы
    if (form) {
        let filter = new AjaxFilter(form);
        let container = document.querySelector('.container');
        if(container) container.classList.add('loading-state');
        filter.getElementsCount();
        isBlockMoved = filter.replaceFilterBlock();

        let checkboxes = form.querySelectorAll('input[type="checkbox"], input[type="radio"]');
        let inputs = form.querySelectorAll('input[type="text"]');
        let selects = form.querySelectorAll('select');

        history.replaceState(null, null, filter.generateUrl());

        if (inputs.length !== 0) {
            inputs.forEach(input => {
                let inputVal = '';
                input.addEventListener('keyup', (e) => {
                    e.target.value = e.target.value.replace(/[^\d]/g, '');
                    filter.inputParams(e.target);
                });

                input.addEventListener('focus', (e) => {
                    inputVal = e.target.value;
                });

                input.addEventListener('blur', (e) => {
                    if (inputVal !== e.target.value) {
                        filter.getElementsCount();
                    }
                });
            });
        }

        if (selects.length !== 0) {
            selects.forEach(select => {
                select.addEventListener('change', (e) => {
                    filter.changeSelect(select);
                })
            })
        }

        document.body.addEventListener('click', (event) => {
            if (event.target.closest(".add-select")) {
                let flexRows = document.querySelectorAll('.flex-row--new');
                if(flexRows.length !== 0) {
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

        if (checkboxes.length !== 0) {
            checkboxes.forEach((check) => {
                check.addEventListener('click', (e) => {
                    filter.getElementsCount();
                });
            });
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            filter.submit();
        })
    }
})

function AjaxFilter(form) {
    this.url = window.location.pathname;
    this.paramsUrl = "";
    this.params = this.getParams();
    this.form = form;
    this.filterName = this.form.getAttribute('data-filter') || "arFilter"
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

AjaxFilter.prototype.generateSort = function () {
    let sortBlock = document.querySelector('.sort');
    let options = sortBlock.querySelectorAll('option');
    let sort = sortBlock.querySelector('option:checked').value;

    sortBlock.addEventListener('click', e => {
        if (!e.target.classList.contains('sel')) return;
        options.forEach(option => {
            if (option.text == e.target.innerText.trim()) sort = option.value;
        })
    })

    return sort;
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
    console.log(formData);
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

    // console.log(formData);

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

AjaxFilter.prototype.getElementsCount = function () {
    this.generateUrl();
    console.log(this.generateUrl());
    fetch(this.url + this.paramsUrl, {
            method: 'POST',
            body: new URLSearchParams({'ajaxCount': "y"}),
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
        let blurBlocks = document.querySelectorAll('.loading-state');
        if(blurBlocks.length !== 0) {
            blurBlocks.forEach(block => {
                block.classList.remove('loading-state');
            })
        }
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
    this.getElementsCount();
}

AjaxFilter.prototype.submit = function () {
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






