$(document).on('ajaxSuccess', function (event, xhr, settings) {
    const [path, queryString] = settings.url.split("?");
    if (queryString) {
        const queryParams = new URLSearchParams(queryString);
        if (queryParams.get('display') || queryParams.get('linerow')) {
            init();
        }
    }

    if(path.includes('filter/clear')) {
        init();
    }
})


init();

function init() {
    let params = getUrlParams();

    const countryEl = document.querySelector("#country");
    const regionEl = document.querySelector("#region");
    const cityEl = document.querySelector("#city");

    selectAdd(countryEl, regionEl);

    const countrySelect = new Choices(countryEl, {
        searchEnabled: false,
        shouldSort: false,
        position: 'bottom'
    })

    const regionSelect = new Choices(regionEl, {
        searchEnabled: false,
        shouldSort: false,
        position: 'bottom'
    })

    const citySelect = new Choices(cityEl, {
        searchEnabled: false,
        shouldSort: false,
        position: 'bottom'
    })

    addListener(countryEl, countrySelect, regionSelect, citySelect)
    addListener(regionEl, regionSelect, citySelect)
    addListener(cityEl, citySelect, false)

    let filterName = document.querySelector('#countryFilter').getAttribute('data-name') || 'arFilter';
    // if(params[filterName + '_country']) {
    //     getLocation('getRegions', 'location', params[filterName + '_country']);
    // }
    // if(params[filterName + '_region']) {
    //     getLocation('getCities', 'location', params[filterName + '_region']);
    // }

    let locationSelects = document.querySelectorAll('.row-border select');

    locationSelects.forEach(select => {
        select.addEventListener('change', () => {
            let attribute = select.getAttribute("id");
            if (attribute === "country") {
                regionSelect.setChoiceByValue('');
                citySelect.setChoiceByValue('');
            } else if (attribute === "region") {
                citySelect.setChoiceByValue('');
            }

            let form = document.querySelector('#countryFilter');
            let formData = new FormData(form);

            let url = window.location.pathname;
            const filterUrl = Array.from(formData.entries())
                .filter(([key, value]) => value !== "" && value !== "0")
                .map(([key, value]) => `${key}=${value}`)
                .join('&');

            if(filterUrl.length !== 0) {
                url += "?" + filterUrl;
            }

            let displayBtns = document.querySelectorAll('a.controls-view__link');
            displayBtns.forEach(btn => {
                let url = window.location.pathname;
                let queryString = btn.href.split('?')[1];
                let params = new URLSearchParams(queryString);
                let modifiedParamsUrl = "?display=" + params.get('display') + '&' + filterUrl;

                btn.setAttribute('data-url', url + modifiedParamsUrl);
                btn.href = url + modifiedParamsUrl;
            })

            document.querySelector('.ajax_load').classList.add('loading-state');
            fetch(url, {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).then(res => {
                return res.text();
            }).then(data => {
                let tmpBlock = document.createElement('div');
                tmpBlock.innerHTML = data;
                document.querySelector('.bx_filter_parameters').innerHTML = tmpBlock.querySelector('.bx_filter_parameters').innerHTML;
                document.querySelector('.inner_wrapper').innerHTML = tmpBlock.querySelector('.inner_wrapper').innerHTML;
                history.pushState(null, null, url);
                document.querySelector('.ajax_load').classList.remove('loading-state');
            }).catch((error) => console.log(error));
        })
    })

    function getUrlParams() {
        return window
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
    }
    function selectAdd(countryEl, regionEl) {
        if (countryEl && regionEl) {
            countryEl.onchange = () => {
                if(countryEl.value !== 'reset') {
                    $('.select-region').addClass('loading-state');
                    getLocation('getRegions', 'location', countryEl.value);
                }
                //фильтрация по городу
            };
            regionEl.onchange = () => {
                if(regionEl.value !== 'reset') {
                    $('.select-city').addClass('loading-state');
                    getLocation('getCities', 'location', regionEl.value);
                }
            };
        }
    }

    function addListener(el, select, selectClear, selectClearSecond) {
        $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();

        el.addEventListener(
            'change',
            function (event) {
                let textContent = event.target.textContent.replace(/\s+/g, '').toLowerCase();

                if (textContent === "сбросить" || textContent === "любая") {
                    let attribute = el.getAttribute("id");
                    if (attribute === "country") {
                        regionSelect.setChoiceByValue('');
                        citySelect.setChoiceByValue('');
                        $(".location-group-select .is-active").removeClass("is-active")
                    } else if (attribute === "region") {
                        cityEl.closest(".is-active") ? cityEl.closest(".is-active").classList.remove("is-active") : false
                        citySelect.setChoiceByValue('');
                    }

                    select.setChoiceByValue('');
                    $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                    if (selectClear) {
                        selectClear.setChoiceByValue('');
                        selectClear.disable();
                    }
                    if (selectClearSecond) {
                        selectClearSecond.setChoiceByValue('');
                        selectClearSecond.disable();
                    }
                    this.closest(".form-row__col-30").classList.remove("is-active");
                } else {
                    $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                    if (selectClear) {
                        selectClear.enable();
                    }
                    this.closest(".form-row__col-30").classList.add("is-active");

                }
                $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            },
            false,
        );
    }

    function getLocation(flag, action, id) {
        fetch('/ajax/create_element.php', {
            method: 'POST',
            body: new URLSearchParams({action: action, id: id, flag: flag}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.json();
        }).then(data => {
            if (flag === 'getRegions') {
                let emptyOption = regionEl.querySelector('option[value=""]');
                if (emptyOption) emptyOption.selected = true;
                let listsArr = data;
                listsArr.unshift({ID: "", NAME: 'Область'}, {ID: "reset", NAME: "Сбросить"});
                ajaxSelect(regionEl, cityEl, listsArr, regionSelect, citySelect, 'region-list');
                $('.select-region').removeClass('loading-state');
            }

            if (flag === 'getCities') {
                let cityArr = data;
                cityArr.unshift({ID: "", NAME: 'Город'}, {ID: "reset", NAME: "Сбросить"});
                ajaxSelect(cityEl, null, cityArr, citySelect, null, 'city-list');
                $('.select-city').removeClass('loading-state');
            }
        }).catch((error) => console.log(error));
    }

    function ajaxSelect(el, secondEl, listsArr, elChoices, secondElChoices, listType) {
        elChoices.setChoiceByValue('');
        $(el).closest('.form-row__col-30').removeClass('is-active');
        $(el).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
        if (secondElChoices) {
            secondElChoices.setChoiceByValue('');
            // secondElChoices.disable();
        }
        if (secondEl) {
            $(secondEl).closest('.form-row__col-30').removeClass('is-active');
            $(secondEl).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
        }

        elChoices.clearChoices();

        $('[data-select="' + listType + '"]').empty();
        if (listsArr) {
            for (let i = 0; i < listsArr.length; i++) {
                o = new Option(listsArr[i]['NAME'], i, false, false);
                $('[data-select="' + listType + '"]').append(o);
                elChoices.setChoices(
                    [
                        {value: listsArr[i]['ID'], label: listsArr[i]['NAME'], disabled: false},

                    ],
                    'value',
                    'label',
                    false,
                );
            }

            $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            $('.custom-select-inner .choices__item--choice[data-id=1]').hide();

            params = getUrlParams();
            let elementId = params[filterName + '_' + el.id];
            if (elementId) {
                elChoices.setChoiceByValue(elementId);
                elChoices.enable();
            }
        }
    }
}


