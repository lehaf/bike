initMainForFilter();
function  initMainForFilter() {
    let selectTypes = [];//new
    const selectList = document.querySelectorAll(".custom-select");

    setSelect(selectList);

    function setSelect(selectList) {
        selectList.forEach((el) => {
            if (el.classList.contains("selectSearch")) {
                let text = el.getAttribute("data-text")
                const selectSearch = new Choices(el, {
                    searchEnabled: true,
                    shouldSort: false,
                    searchPlaceholderValue: text,
                    removeItems: true,
                    position: 'bottom',
                    noResultsText: 'Ничего не найдено',
                    searchResultLimit: 100,
                    searchFields: ['label'],
                    fuseOptions: {
                        keys: ['label'], // Поиск только по полю label
                        threshold: 0.1, // Позволяет находить подстроки, избегая слишком "размытых" совпадений
                        distance: 1000, // Максимальное расстояние, в пределах которого совпадение считается допустимым
                    },
                })

                moveSearchField(el.closest('.row--brand'));
                listenerSelect(el, selectSearch);
                el.addEventListener('change', function (event) {
                    const selectedItems = Array.from(el.selectedOptions).map(option => option.value);

                    if (selectedItems.length > 0) {
                        this.parentElement.classList.add("is-active")
                        this.closest(".choices").classList.add("is-active")
                        this.closest(".form-row__col").classList.add("is-active")
                    }

                    if (el.value === "" || el.value === "reset") {
                        selectSearch.setChoiceByValue('');

                        this.parentElement.classList.remove("is-active");
                        this.closest(".choices").classList.remove("is-active");
                        this.closest(".form-row__col").classList.remove("is-active");
                    }
                    hideSelectItem();
                });
            } else {
                const selectType = new Choices(el, {
                    searchEnabled: false,
                    shouldSort: false,
                    position: 'bottom'
                })
                // if(el.closest(".save-search-popup") || el.closest(".save-list")){ //new
                //     selectType.disable()
                // }
                listenerSelect(el, selectType)
                selectTypes.push(selectType);//new
            }
        })

        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
    }
    function listenerSelect(el, select) {
        el.addEventListener(
            'change',
            function (event) {
                let textContent = event.target.textContent.replace(/\s+/g, '')
                if (textContent === "Сбросить" || textContent === "Любая" || textContent === "Любой") {
                    select.setChoiceByValue('');
                } else if (el.getAttribute("data-type") === "currency") {
                    changePrice()
                }
                setTimeout(() => {
                    $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                }, 0)
            },
            false,
        );
    }
    function changePrice() {
        let startPrice = document.querySelector(".price-start");
        let endPrice = document.querySelector(".price-end");
        let localСurrency = startPrice.getAttribute("data-text").toLowerCase();
        if (localСurrency === "byn") {
            startPrice.setAttribute("data-text", "USD");
            startPrice.setAttribute("placeholder", "Цена (USD), от");
            endPrice.setAttribute("data-text", "USD");
            if (startPrice.value) {
                let sumStart = startPrice.value.slice(0, -5);
                console.log(sumStart)
                startPrice.value = sumStart + ", " + "USD";
            }
            if (endPrice.value) {
                let sumStart = endPrice.value.slice(0, -5);
                endPrice.value = sumStart + ", " + "USD";
            }
        } else {
            startPrice.setAttribute("data-text", "BYN");
            startPrice.setAttribute("placeholder", "Цена (BYN), от");
            endPrice.setAttribute("data-text", "BYN");

            if (startPrice.value) {
                let sumStart = startPrice.value.slice(0, -5);
                startPrice.value = sumStart + ", " + "BYN";
            }
            if (endPrice.value) {
                let sumStart = endPrice.value.slice(0, -5);
                endPrice.value = sumStart + ", " + "BYN";
            }
        }
    }

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
    let filterName = document.querySelector('#filter').getAttribute('data-filter') || 'arFilter';

    $(".custom-input.number").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function ajaxSelect(el, secondEl, listsArr, elChoices, secondElChoices, listType) {
        elChoices.setChoiceByValue('');
        $(el).closest('.form-row__col-30').removeClass('is-active');
        $(el).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
        if (secondElChoices) {
            secondElChoices.setChoiceByValue('');
            secondElChoices.disable();
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

            let elementId = params[filterName + '_' + el.id];
            if (elementId) {
                elChoices.setChoiceByValue(elementId);
                elChoices.enable();
            }
        }
    }

    const countryEl = document.querySelector("#country");
    const regionEl = document.querySelector("#region");
    const cityEl = document.querySelector("#city");

    selectAdd();

    function selectAdd() {
        if (countryEl && regionEl) {
            countryEl.onchange = () => {
                if (countryEl.value !== "" && countryEl.value !== 'reset') {
                    $('.select-region').addClass('loading-state');
                    getLocation('getRegions', 'location', countryEl.value)
                }
            };
            regionEl.onchange = () => {
                if (countryEl.value !== "" && countryEl.value !== 'reset') {
                    $('.select-city').addClass('loading-state');
                    getLocation('getCities', 'location', regionEl.value);
                }
            };
        }
        let categoryEl = document.querySelector('#categorySelect');
        if (categoryEl) {
            categoryEl.onchange = () => getCategories('getSubCategories', 'categories', categoryEl.value);
        }
    }

    if (countryEl && regionEl && cityEl) {
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

        $(".reset-parameters").on("click", function () {
            $(".is-active").removeClass("is-active");

            selectTypes.forEach(selectType => {
                selectType.setChoiceByValue('');
            });
            countrySelect.setChoiceByValue('');

            regionSelect.setChoiceByValue('');
            regionSelect.disable()
            citySelect.setChoiceByValue('');
            citySelect.disable()

            setTimeout(() => {
                $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            })
        })

        // window.onload = selectCountry;
        function getLocation(flag, action, id) {
            $('#stepForm').addClass('blur');
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
                $('#stepForm').removeClass('blur')
            }).catch((error) => console.log(error));
        }

        function addListener(el, select, selectClear, selectClearSecond) {
            let cntParamСontent = document.querySelector(".cnt-parameters");
            $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");

            el.addEventListener(
                'change',
                function (event) {
                    let flagActiveItem = this.closest(".form-row__col-30").classList.contains("is-active");
                    let cityFlag = cityEl.closest(".form-row__col-30").classList.contains("is-active");
                    let regionFlag = regionEl.closest(".form-row__col-30").classList.contains("is-active");
                    let textContent = event.target.textContent.replace(/\s+/g, '').toLowerCase();

                    if (textContent === "сбросить" || textContent === "любая") {
                        let attribute = el.getAttribute("id");
                        if (attribute === "country") {
                            regionSelect.setChoiceByValue('1');
                            regionSelect.disable(); //new
                            citySelect.setChoiceByValue('1');
                            citySelect.disable(); //new

                            $(".location-group-select .is-active").removeClass("is-active")
                            if (flagActiveItem && regionFlag && cityFlag) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 3;
                            } else if (flagActiveItem && regionFlag) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 2;
                            } else if (flagActiveItem) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 1;
                            }
                        } else if (attribute === "region") {
                            cityEl.closest(".is-active") ? cityEl.closest(".is-active").classList.remove("is-active") : false
                            citySelect.setChoiceByValue('1');
                            if (flagActiveItem && cityFlag) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 2;
                            } else if (flagActiveItem) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 1;
                            }
                        } else {
                            if (flagActiveItem) {
                                cntParamСontent.textContent = +cntParamСontent.textContent - 1;
                            }
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
                        if (!flagActiveItem) {
                            cntParamСontent.textContent = +cntParamСontent.textContent + 1;
                        }

                    }

                    if (cntParamСontent.textContent > 0) {
                        cntParamСontent.style.visibility = 'visible';
                    } else {
                        cntParamСontent.style.visibility = 'hidden';
                    }

                    $(".save-search").removeClass("active");//new
                    $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
                },
                false,
            );
        }
    }

    setColor();


    function setColor() {
        const colorLIst = $("._color-item");

//отображение цвета
        $.each(colorLIst, function (key, value) {
            let colorItem = value.getAttribute("data-color");
            value.style.backgroundColor = colorItem;
        })
    }


    $(".custom-textarea").on("input", function () {
        const val = $(this).val();
        const maxLength = 2000;
        if (val.length <= maxLength) {
            $(this).next().find(".textarea-info__number").text(val.length)
        }
    })

    $(".custom-textarea").on('keyup', function () {
        if (this.scrollTop > 0) {
            this.style.height = this.scrollHeight + "px";
        }
    });

    const selectCurrency = document.querySelector("#currency")

    if (selectCurrency) {
        const selectType = new Choices(selectCurrency, {
            searchEnabled: false,
            shouldSort: false,
        })
    }

    $(".ad-description-list").on("click", function () {
        let target = $(event.target);
        if (target.closest(".ad-description-list__el").length) {
            let blockVal = $(".custom-textarea[data-text=\"ad-description\"]").val();
            if (!blockVal) {
                $(".custom-textarea[data-text=\"ad-description\"]").val(target.text() + ", ");
            } else {
                $(".custom-textarea[data-text=\"ad-description\"]").val(blockVal + target.text() + ", ");
            }
            $(".custom-textarea[data-text=\"ad-description\"]").next().find(".textarea-info__number").text($(".custom-textarea[data-text=\"ad-description\"]").val().length);
            target.remove();
            if (!$(".ad-description-list").children().length) {
                $(".ad-description-list").remove()
            }
        }
    })

    function moveSearchField(selectRow) {
        const choicesContainer = selectRow.querySelector('.choices');

        const searchInput = choicesContainer.querySelector('.choices__input.choices__input--cloned');

        const dropdown = choicesContainer.querySelector('.choices__list--dropdown');

        if (searchInput && dropdown) {
            choicesContainer.insertBefore(searchInput, dropdown);
        }
    }
}



