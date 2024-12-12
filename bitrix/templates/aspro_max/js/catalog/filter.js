let testUrl = "";
let brandOptions = [{value: "", label: 'Марка'}, {value: "reset", label: "Любая"}];

let cntParamСontent = "";
let fullDataFoundBrand = [];
let popularDataFoundBrand = [];

const transportSelect = document.getElementById('transportSelect');
const cylinderSelect = document.getElementById('cylinder');
const cyclesSelect = document.getElementById('cycles');
const mainGearSelect = document.getElementById('mainGear');
const transmissionSelect = document.getElementById('transmission');

if (transportSelect) selectMultiple(transportSelect, "Тип мотоцикла");
if (cylinderSelect) selectMultiple(cylinderSelect, "Расположение цилиндров");
if (cyclesSelect) selectMultiple(cyclesSelect, "Число тактов");
if (mainGearSelect) selectMultiple(mainGearSelect, "Главная передача");
if (transmissionSelect) selectMultiple(transmissionSelect, "Коробка");

const brandSelect = document.getElementById('brand-select');
const modelSelect = document.getElementById('model-select');
let numberIdSelect = 1; //new


const brandChoices = new Choices(brandSelect, {
    placeholder: true,
    searchPlaceholderValue: 'Марка',
    duplicateItemsAllowed: false,
    choices: brandOptions,
    shouldSort: false,
    shouldSortItems: false,
    searchEnabled: true,
    searchChoices: true,
    position: "bottom",
    noResultsText: 'Ничего не найдено',
    searchResultLimit: 100,
    fuseOptions: {
        keys: ['label'], // Поиск только по полю label
        threshold: 0.1, // Чем меньше значение, тем точнее поиск
        caseSensitive: false, // Игнорировать регистр
        distance: 100, // Максимальное расстояние от начала совпадения
    },
});

const originalSearch = brandChoices._handleSearch;
brandChoices._handleSearch = function (value) {
    originalSearch.call(this, value);
    hideDuplicateChoices(this.dropdown.element);
};

//удаление дубликатов при поиске в select
function hideDuplicateChoices(dropdown) {
    const uniqueLabels = new Set();
    const choices = dropdown.querySelectorAll('.choices__item--choice');

    choices.forEach(choice => {
        const label = choice.innerText.trim();
        if (uniqueLabels.has(label)) {
            choice.classList.add('hidden');
        } else {
            uniqueLabels.add(label);
            choice.classList.remove('hidden');
        }
    });
}

//
const modelChoices = new Choices(modelSelect, {
    placeholder: true,
    searchPlaceholderValue: 'Модель',
    choices: ["Модель"],
    shouldSort: false,
    resetScrollPosition: false,
    renderSelectedChoices: 'always',
    removeItemButton: true,
    duplicateItemsAllowed: true,
    position: "bottom",
    noResultsText: 'Ничего не найдено',
    searchResultLimit: 100,
    fuseOptions: {
        keys: ['label'], // Поиск только по полю label
        threshold: 0.1, // Чем меньше значение, тем точнее поиск
        caseSensitive: false, // Игнорировать регистр
        distance: 100, // Максимальное расстояние от начала совпадения
    },
});

//для выбранных марок, если количество больше 1
const allBrands = document.querySelectorAll('.select-brand select');
let allBrandChoices = [];

const allModels = document.querySelectorAll('.select-model select');
let allModelChoices = [];
allBrands.forEach(brand => {
    let brandId = brand.getAttribute('data-key');
    if (brandId && brandId !== "0") {
        addSelectBrandMark(brandId);
    }
})

const templateFoundBrand = (name, sum, href) => {
    let brandEl =
        `
    <div class="found-brand__el">
            <a href="${href}" class="found-brand__name">
                ${name}
            </a>
            <span class="found-brand__line"></span>
            <span class="found-brand__sum">${sum}</span>
    </div>
    `
    return brandEl
}

const foundBrandBlock = document.querySelector(".found-brand-content");
if (foundBrandBlock) {
    fetch('/ajax/elements_filter.php', {
        method: 'POST',
        body: new URLSearchParams({
            action: 'categoryWithPopular',
            flag: 'founds',
            sectId: foundBrandBlock.getAttribute('data-brand')
        }),
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(res => {
        return res.json();
    }).then(data => {
        fullDataFoundBrand = data['fullCategories'];
        popularDataFoundBrand = (data['popularCategories'].length !== 0) ? data['popularCategories'] : data['fullCategories'];
        previewFoundBrand();
    }).catch((error) => console.log(error));
}

const templateBtn = (obj, text) => {
    return `
    <div class="found-brand__btn">${text} - <span>${obj}</span></div>
    `
}

$("body").on("click", function () {
    let target = $(event.target);
    if (target.closest(".found-brand__btn").length) {
        $(".found-brand__collapse").addClass("active");
        addELlFoundBrand();
    } else if (target.closest(".found-brand__collapse").length) {
        $(".found-brand__collapse").removeClass("active");
        previewFoundBrand();
    }

    if (!target.closest(".save-search-popup").length && !target.closest(".save-search").length) {
        $(".save-search-popup").removeClass("active");
    }

    if (!target.closest(".save-list-container").length && !target.closest(".save-list").length) {
        $(".save-list").removeClass("active");
        addScroll();
    }
})

document.addEventListener("DOMContentLoaded", () => {
    cntParamСontent = document.querySelector(".cnt-parameters");

    moveSearchField(document.querySelector('.row--brand'));
    // setTimeout(moveSearchField, 100);

    brandSelect.addEventListener('change', function (event) {
        const selectedBrands = Array.from(brandSelect.selectedOptions).map(option => option.value);

        if (selectedBrands.length > 0) {
            cntParam(1, this.closest(".form-row__col"))
            this.parentElement.classList.add("is-active")
            this.closest(".choices").classList.add("is-active")
            this.closest(".form-row__col").classList.add("is-active")

            modelChoices.clearStore();
            document.querySelector('.select-model').classList.add('loading-state');
            getCategories('getModels', 'categories', event.target.value, modelChoices);
            modelChoices.enable();
        } else {
            modelChoices.clearStore();
            modelChoices.enable();
        }
        const textContent = event.target.textContent.replace(/\s+/g, '');
        if (textContent.includes("Любая")) {
            brandChoices.setChoiceByValue('');
            modelChoices.setChoiceByValue('1');
            modelChoices.disable();
            cntParam(-1, this.closest(".form-row__col"));

            this.parentElement.classList.remove("is-active");
            this.closest(".choices").classList.remove("is-active");
            this.closest(".form-row__col").classList.remove("is-active");
        }
        this.closest(".form-group-custom-select").querySelector(".custom-select--multiple").classList.remove("is-active");
        hideSelectItem();
    });

    modelSelect.addEventListener('choice', function (event) {
        const choiceValue = event.detail.choice.value;

        if (modelChoices.getValue(true).includes(choiceValue)) {
            setTimeout(() => {
                modelChoices.removeActiveItemsByValue(choiceValue);
                $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            }, 0)
        } else {
            hideSelectItem()
        }

        if (choiceValue === 'reset') {
            cntParam(-1, this.closest(".form-row__col"))
            setTimeout(() => {
                modelChoices.removeActiveItems();
                modelChoices.hideDropdown();
                // modelChoices.setChoiceByValue('');
                this.closest(".form-row__col").classList.remove("is-active")
            })
        } else {
            cntParam(1, this.closest(".form-row__col"))
            this.closest(".form-row__col").classList.add("is-active")
        }
        listItemMultiple(this);
        hideSelectItem();

    });

    const templateSelect = (id) => {
        return `
     <div class="form-row custom-select-inner form-group-custom-select flex-row flex-row--new">
            <div class="form-row__col row--brand select-brand">
                <div class="form-row">
                    <select id="brand-select-${id}" name="arFilter_mark_${id}"></select>
                </div>
                <div class="form-row add-select select-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.087 4.94545H12V7.10303H7.087V12H4.90072V7.10303H0V4.94545H4.90072V0H7.087V4.94545Z" fill="#666666"/>
                    </svg>
                </div>
            </div>
            <div class="form-row__col custom-select--multiple select-model">
                <div class="form-row">
                    <select id="model-select-${id}" name="arFilter_model_${id}" multiple disabled>
                        <option placeholder >Модель</option>
                    </select>
                </div>
                <div class="form-row remove-select select-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.09856 6.44252L11.9541 10.298L10.2609 11.9912L6.40539 8.13569L2.56247 11.9786L0.846775 10.2629L4.68969 6.41999L0.843834 2.57413L2.537 0.880967L6.38286 4.72683L10.2638 0.845859L11.9795 2.56156L8.09856 6.44252Z" fill="#666666"/>
                    </svg>
                </div>
            </div>
        </div>
    `
    }

    let choicesInstances = [];//new
    let sectId = document.querySelector('form.selection-block').getAttribute('data-sect');
    getCategories('getMarks', 'categoryWithPopular', sectId, brandChoices);
    setMarkAndModel(brandSelect, modelChoices);

    $("body").on("click", function (event) {
        let target = event.target;

        if (target.closest(".add-select")) {
            $(".model-selection").append(templateSelect(numberIdSelect)) //new
            addSelectBrandMark(numberIdSelect);
            $(".remove-select").removeClass("hide");
            $(".remove-select").addClass("show");
            numberIdSelect++; //new

        } else if (target.closest(".remove-select")) {
            let lengthItem = target.closest(".custom-select-inner").querySelectorAll(".is-active").length;
            let activeElem = target.closest(".custom-select-inner").querySelector(".is-active")

            target.closest(".custom-select-inner").remove()
            if ($(".model-selection").children().length < 2) {
                $(".remove-select").addClass("hide");
                $(".remove-select").removeClass("show");
            }
        }
    })

    let listCustomSelect = document.querySelectorAll(".color-select select");
    listCustomSelect.forEach((el) => {
        el.addEventListener("change", (event) => {
            if (event.target.value !== "") {
                setTimeout(() => event.target.closest(".choices__inner").classList.add("is-active"))
                if (el.closest(".no-save")) {
                    return
                }

                cntParam(1, event.target.closest(".choices__inner"))
            } else {
                setTimeout(() => event.target.closest(".choices__inner").classList.remove("is-active")) //new
                if (el.closest(".no-save")) {
                    return
                }
                cntParam(-1, event.target.closest(".choices__inner"))
            }
        })
    })

    let inputChange = document.querySelectorAll(".input-change");

    inputChange.forEach(function (el) {
        el.addEventListener("change", function () {
            const value = this.value.replace(this.getAttribute("data-text"), "");
            if (value) {
                cntParam(1, this.parentElement)
                if (this.getAttribute("data-text")) {
                    this.value = value.replace(", ", "") + ", " + this.getAttribute("data-text");
                }
                this.parentElement.classList.add("is-active");
            } else {
                cntParam(-1, this.parentElement)
                this.parentElement.classList.remove("is-active")
            }
        })
    })

    $(".reset-input").on("click", function () {
        cntParam(-1, this.parentElement);
        let inputElem = $(this).parent().find("input");
        this.parentElement.classList.remove("is-active");
        inputElem.val('');
    })

    $(".radio-color--checkbox").on("click", function (event) {
        let target = $(event.target)
        if (target.closest(".color-btn__arrow").length) {
            $(".radio-color--checkbox").toggleClass("active");
            $(".color-btn__arrow").toggleClass("rotate");
        } else if ($(".radio-color--checkbox .radio-block:checked").length
            && $(".radio-color--checkbox .radio-block:checked").length > 0) {
            $(".color-btn__cross").addClass("active");
            $(".color-btn__arrow").removeClass("active", "rotate")
            $(".radio-color--checkbox").addClass("active");
        } else {
            $(".radio-color--checkbox").removeClass("active");
            $(".color-btn__cross").removeClass("active");
            $(".color-btn__arrow").removeClass("rotate");
            $(".color-btn__arrow").addClass("active");
        }
    })

    $(".color-btn__cross").on("click", function () {
        cntParamСontent.textContent = +cntParamСontent.textContent - $(".radio-color--checkbox .radio-block:checked").length;
        $(".radio-color--checkbox .radio-block:checked").each((i, el) => {
                el.checked = false;
            }
        )

        $(".radio-color--checkbox").removeClass("active");
        $(".color-btn__cross").removeClass("active");
        $(".color-btn__arrow").removeClass("rotate");
        $(".color-btn__arrow").addClass("active");
    })

    $(".all-parameters").on("click", function () {
        let text = $(".all-parameters__text").text().toLowerCase()
        if (text === "скрыть") {
            $(".all-parameters__text").text("Все параметры")
            $(".inner-more-form").removeClass("active");
            $(".all-parameters").removeClass("active");
        } else {
            $(".inner-more-form").addClass("active");
            $(".all-parameters").addClass("active");
            $(".all-parameters__text").text("Скрыть")
        }
    })

    const templateItemListSave = (i, brand, info, checked, url) => {
        return `<div class="save-list__item">
                <a href="${url}" class="search-popup__mark">${brand}</a>
                <a href="${url}" class="search-popup__parameters">${info}</a>
                <div class="form-row form-row-checkbox form-row-checkbox--selection no-save">
                    <input type="checkbox" class="input-checkbox dependent-checkbox-${i}" name="emailMes" id="emailMes-${i}" ${checked}>
                    <label for="emailMes-${i}" class="checkbox-label">Уведомления на электронную почту</label>
                </div>
                                
                <div class="form-group custom-select-inner form-group-custom-select color-select no-save">
                    <select class="select-type custom-select right-select" id="custom-select-${i}">
                        <option value="">
                            Получать письма
                        </option>
                        <option value="reset">
                            Сбросить
                        </option>
                        <option value="Получать письма каждые 4 часа">
                            Получать письма каждые 4 часа
                        </option>
                        <option value="Получать письма каждые 8 часа">
                            Получать письма каждые 8 часа
                        </option>
                        <option value=" Получать письма каждые 8 часа">
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
    //new
    let numItemSearch = 0;
    $(".save-search__save").on("click", function () {
        this.parentElement.classList.add("active");
        $(".save-search-popup").addClass("active");
    })

    $(".save-search__prev").on("click", function () {
        if (this.getAttribute('data-auth') !== 'Y') {
            window.location.href = '/auth/';
        } else {
            $('.save-list-container').removeClass('hidden');
            this.parentElement.classList.add("active");
            $(".save-search-popup").addClass("active");
            selectableItems();
            let content = document.querySelector(".save-search-popup");
            let saveBrandContent = document.querySelector(".save-search-popup .search-popup__mark").textContent;
            let saveParamContent = document.querySelector(".save-search-popup .search-popup__parameters").textContent;
            let handleInputCheck = content.querySelector("input").checked ? "checked" : "";
            let selectSaveInfo = document.querySelector(".save-search-popup .choices__list--single .choices__item--selectable").textContent.trim();


            if (!saveBrandContent) {
                saveBrandContent = "Все марки"
            }

            // let contentClone = content.cloneNode(true);
            // contentClone.querySelector(".search-popup__btn").remove();

            // $(".save-list").append(templateItemListSave(numItemSearch, saveBrandContent, saveParamContent, handleInputCheck))
            // let selectNew = `#custom-select-${numItemSearch}`
            // // removeDuplicates(selectNew)
            // let select = document.querySelector(selectNew);
            //
            // const selectHistory = new Choices(select, {
            //     searchEnabled: false,
            //     shouldSort: false,
            //     duplicateItemsAllowed: false
            // })
            // setTimeout(() => {
            //     $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
            // }, 0)
            // if (!handleInputCheck) {
            //     selectHistory.disable()
            // }
            //
            // select.addEventListener('change', function (event) {
            //     let textContent = event.target.textContent.replace(/\s+/g, '')
            //     if (textContent === "Сбросить") {
            //         selectHistory.setChoiceByValue('');
            //         setTimeout(() => {
            //             this.closest(".choices__inner").classList.remove("is-active")
            //         }, 100)
            //
            //     }
            //     setTimeout(() => {
            //         $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
            //     }, 500)
            //
            // });
            //
            // $(`.dependent-checkbox-${numItemSearch}`).on("change", function () {
            //     if (this.checked) {
            //         selectHistory.enable()
            //     } else {
            //         selectHistory.disable()
            //         selectHistory.containerInner.element.classList.remove("is-active")
            //     }
            // })

            // selectOptionByText(selectSaveInfo);
            //
            // //new
            // function selectOptionByText(text) {
            //     const options = select.options;
            //     for (let i = 0; i < options.length; i++) {
            //         if (options[i].text === text) {
            //             select.value = options[i].value;
            //             selectHistory.setChoiceByValue(select.value);
            //             break;
            //         }
            //     }
            // }

            if (selectSaveInfo !== "Получать письма") {
                select.closest(".choices__inner").classList.add("is-active");
            }

            // select.addEventListener('change', function (event) {
            //         let textContent = event.target.textContent.replace(/\s+/g, '')
            //         if (textContent === "Сбросить") {
            //             this.closest(".choices__inner").classList.remove("is-active")
            //         } else {
            //             this.closest(".choices__inner").classList.add("is-active")
            //         }
            //         addScroll()
            //         setTimeout(() => {
            //             $('.custom-select-inner .choices__item--choice[data-id=1]').show();
            //         }, 0)
            //     },
            //     false,
            // );


            $(".save-list__item .search-popup__parameters").each(function (i, el) {
                if (!el.textContent) {
                    el.remove()
                }
            })

            numItemSearch++;
        }
    })

    $(".search-popup__btn").on("click", function () {
        $(".save-search").removeClass("active");
        $(".save-search-popup").removeClass("active");
        $(".selection-block").trigger('reset'); //new
    })

    $('input[type="radio"]').on('click', function () {
        if (this.closest(".no-save")) {
            return
        }

        let container = this.closest(".form-row-radio-block")
        let elValue = $(this).val().toLowerCase();
        $(".save-search").removeClass("active");

        if (!container.classList.contains("active")) {
            container.classList.add("active");
            if (cntParamСontent.textContent == 0) {
                cntParamСontent.style.visibility = 'visible';
            }
            cntParamСontent.textContent = +cntParamСontent.textContent + 1;
        } else if (elValue.length === 0) {
            cntParamСontent.textContent = +cntParamСontent.textContent - 1;
            if (cntParamСontent.textContent == 0) {
                cntParamСontent.style.visibility = 'hidden';
            }
            container.classList.remove("active");
        }
        console.log(cntParamСontent.textContent);
    });

    $(".save-list-btn").on("click", function () {
        $(".save-list").addClass("active");
    })

    $(".save-list").on("click", function (event) {
        let target = event.target;
        let parent = target.closest(".save-list__item");
        let list = parent.querySelector(".choices__list--dropdown");

        if (target.classList.contains("choices__inner") || target.closest(".choices__inner")) {
            let elPosition = parent.querySelector(".choices");
            showList(list, elPosition)
            setTimeout(() => {
                if (target.closest(".is-open") !== null) {
                    removeScroll()
                } else {
                    addScroll()
                }
            }, 200)
        } else {
            list.style.width = 0;
            addScroll();
        }
    })

    $('.selection-block input[type="checkbox"]').on('click', function () {
        if (this.closest(".no-save")) {
            return
        }

        $(".save-search").removeClass("active");
        if ($(this).is(':checked')) {
            if (cntParamСontent) {
                if (cntParamСontent.textContent == 0) {
                    cntParamСontent.style.visibility = 'visible';
                }
                cntParamСontent.textContent = +cntParamСontent.textContent + 1;
            }
        } else {
            if (cntParamСontent) {
                cntParamСontent.textContent = +cntParamСontent.textContent - 1;
                if (cntParamСontent.textContent == 0) {
                    cntParamСontent.style.visibility = 'hidden';
                }
            }
        }
    });


    document.querySelector('#filter').addEventListener('reset', () => {
        brandChoices.setChoices(brandOptions, 'value', 'label', true);
    });

    activeItems();

    //подсчет активных параметров
    let activeElements = document.querySelectorAll('.is-active, input[type="checkbox"]:checked, input[type="radio"]:checked');
    activeElements.forEach(elem => {
        if (cntParamСontent && elem.closest('.inner-more-form') && elem.value !== "") {
            cntParamСontent.textContent++;
            cntParamСontent.style.visibility = 'visible';
        }
    })

    // let selectedMarks = document.querySelectorAll('.select-brand.is-active, .select-model.is-active');
    // selectedMarks.forEach(mark => {
    //     // mark.querySelector('.choices').classList.add('is-active');
    //     mark.querySelector('.choices__inner').classList.add('is-active');
    // })
})

function previewFoundBrand() {
    foundBrandBlock.innerHTML = "";
    let text = document.querySelector('.found-brand').getAttribute('data-text');
    console.log(text);
    let index = 0;
    for (const brand of popularDataFoundBrand) {
        let href = window.location.pathname + brand.CODE + "/";
        let item = templateFoundBrand(brand.NAME, brand.ELEMENTS_COUNT, href)
        foundBrandBlock.innerHTML += item;
        index++;
        if (index === 11 && popularDataFoundBrand.length === fullDataFoundBrand.length) {
            foundBrandBlock.innerHTML += templateBtn(fullDataFoundBrand.length, text);
            break;
        }
    }

    if (popularDataFoundBrand.length < fullDataFoundBrand.length) {
        foundBrandBlock.innerHTML += templateBtn(fullDataFoundBrand.length, text);
    }
    // for (let el in popularDataFoundBrand) {
    //     let index = Object.keys(popularDataFoundBrand)
    //     index.find((element, i) => {
    //         if (element === el && i < 11) {
    //             console.log(popularDataFoundBrand[el]);
    //             let href = window.location.pathname + popularDataFoundBrand[el].CODE + "/";
    //             let item = templateFoundBrand(popularDataFoundBrand[el].NAME, popularDataFoundBrand[el].ELEMENTS_COUNT, href)
    //             foundBrandBlock.innerHTML += item;
    //             return;
    //         } else if (i === 11) {
    //             foundBrandBlock.innerHTML += templateBtn(fullDataFoundBrand.length)
    //             return;
    //         }
    //     })
    // }
}

function addELlFoundBrand() {
    foundBrandBlock.innerHTML = ""
    for (let el in fullDataFoundBrand) {
        let href = window.location.pathname + fullDataFoundBrand[el].CODE + "/";
        let item = templateFoundBrand(fullDataFoundBrand[el].NAME, fullDataFoundBrand[el].ELEMENTS_COUNT, href)
        foundBrandBlock.innerHTML += item
    }
}

function hideSelectItem() {
    setTimeout(() => {
        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
        $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
    }, 0)
}

function addSelectBrandMark(id) {
    const selectList = {
        [`brandChoices${id}`]: document.getElementById(`brand-select-${id}`),
        [`modelSelect${id}`]: document.getElementById(`model-select-${id}`)
    }

    let selectBrandRow = document.getElementById(`brand-select-${id}`).closest('.row--brand');
    const brandChoices = new Choices(selectList[`brandChoices${id}`], {
        placeholder: true,
        searchPlaceholderValue: 'Марка',
        duplicateItemsAllowed: true,
        choices: brandOptions,
        shouldSort: false,
        shouldSortItems: false,
        searchEnabled: true,
        searchChoices: true,
        position: "bottom",
        noResultsText: 'Ничего не найдено',
        searchResultLimit: 100,
        fuseOptions: {
            keys: ['label'], // Поиск только по полю label
            threshold: 0.1, // Чем меньше значение, тем точнее поиск
            caseSensitive: false, // Игнорировать регистр
            distance: 100, // Максимальное расстояние от начала совпадения
        },
    });
    brandChoices._handleSearch = function (value) {
        originalSearch.call(this, value);
        hideDuplicateChoices(this.dropdown.element);
    };
    allBrandChoices.push(brandChoices);

    const modelChoices = new Choices(selectList[`modelSelect${id}`], {
        placeholder: true,
        searchPlaceholderValue: 'Модель',
        // choices: ["Модель"],
        shouldSort: false,
        resetScrollPosition: false,
        renderSelectedChoices: 'always',
        removeItemButton: true,
        duplicateItemsAllowed: true,
        position: "bottom",
        searchResultLimit: 10
    });
    allModelChoices.push(modelChoices);

    moveSearchField(selectBrandRow);
    setMarkAndModel(selectList[`brandChoices${id}`], modelChoices);
    let selectedMark = selectList[`brandChoices${id}`].getAttribute('data-sect');
    if (selectedMark) {
        const options = selectList[`brandChoices${id}`].querySelectorAll('option');
        options.forEach(option => {
            if (option.value === selectedMark) {
                option.setAttribute('selected', 'selected');
            } else {
                option.removeAttribute('selected');
            }
        });
        brandChoices.setChoiceByValue(selectedMark);
    }
    // setTimeout(moveSearchField, 100);
    hideSelectItem();

    //new
    // selectList[`brandChoices${id}`].addEventListener('search', function (event) {
    //     $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
    //     $('.custom-select-inner .choices__item--choice[data-value="Любая"]').hide();
    // })
    //end new

    selectList[`brandChoices${id}`].addEventListener('change', function (event) {
        const selectedBrands = Array.from(selectList[`brandChoices${id}`].selectedOptions).map(option => option.value);

        if (selectedBrands.length > 0) {
            cntParam(1, this.closest(".form-row__col"))
            this.parentElement.classList.add("is-active")
            this.closest(".choices").classList.add("is-active")
            this.closest(".form-row__col").classList.add("is-active")

            modelChoices.clearStore();
            getCategories('getModels', 'categories', event.target.value, modelChoices);


            this.closest(".form-row__col").classList.add("is-active");
            modelChoices.enable();
        } else {
            modelChoices.clearStore();
            modelChoices.enable();
        }
        const textContent = event.target.textContent.replace(/\s+/g, '');
        if (textContent.includes("Любая")) {
            brandChoices.setChoiceByValue('');
            modelChoices.setChoiceByValue('1')
            modelChoices.disable();
            cntParam(-1, this.closest(".form-row__col"))

            //new
            let activeEl = Array.from(this.closest(".form-group-custom-select").querySelectorAll(".is-active"));
            activeEl.forEach((el) => {
                el.classList.remove("is-active")
            })
        }
        this.closest(".form-group-custom-select").querySelector(".custom-select--multiple").classList.remove("is-active");
        hideSelectItem();
    });

    selectList[`modelSelect${id}`].addEventListener('choice', function (event) {
        const choiceValue = event.detail.choice.value;

        if (modelChoices.getValue(true).includes(choiceValue)) {
            setTimeout(() => {
                modelChoices.removeActiveItemsByValue(choiceValue);
                $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            }, 0)
        } else {
            hideSelectItem()
        }

        if (choiceValue === 'reset') {
            setTimeout(() => {
                modelChoices.removeActiveItems();
                modelChoices.hideDropdown();
                brandChoices.setChoiceByValue('');
                cntParam(-1, this.closest(".form-row__col"));
                this.closest(".form-row__col").classList.remove("is-active");
            })
        } else {
            cntParam(1, this.closest(".form-row__col"));
            this.closest(".form-row__col").classList.add("is-active");
            listItemMultiple(this);
        }

    });

    selectList[`modelSelect${id}`].addEventListener('change', function (event) {
        hideSelectItem();
    });
}

function selectMultiple(item, name) {
    const selectMultiple = new Choices(item, {
        placeholder: true,
        searchEnabled: false,
        shouldSort: false,
        resetScrollPosition: false,
        renderSelectedChoices: 'always',
        removeItemButton: true,
        duplicateItemsAllowed: true,
        position: 'bottom'
    });

    item.addEventListener('choice', function (event) {
        const choiceValue = event.detail.choice.value;
        if (selectMultiple.getValue(true).includes(choiceValue)) {
            setTimeout(() => {
                selectMultiple.removeActiveItemsByValue(choiceValue);
                $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            }, 0)
        } else {
            hideSelectItem()
        }

        if (choiceValue === 'reset') {
            setTimeout(() => {
                selectMultiple.removeActiveItems();
                selectMultiple.hideDropdown();
                // cntParam(-1, this.closest(".form-row__col"));
                this.closest(".form-row__col").classList.remove("is-active");
            })
        } else {
            cntParam(1, this.closest(".form-row__col"));
            this.closest(".form-row__col").classList.add("is-active");
        }
        listItemMultiple(item);
    });

    // item.addEventListener('change', function (event) {
    //     hideSelectItem();
    // });

    listItemMultiple(item);
    hideSelectItem();
}

function setMarkAndModel(brandSelect, modelChoices) {
    let selectedMark = brandSelect.getAttribute('data-sect');
    if (selectedMark) {
        getCategories('getModels', 'categories', selectedMark, modelChoices);
    }
}

function getCategories(flag, action, sectId, choices) {
    fetch('/ajax/elements_filter.php', {
        method: 'POST',
        body: new URLSearchParams({action: action, sectId: sectId, flag: flag}),
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(res => {
        return res.json();
    }).then(data => {
        if (flag === 'getMarks') {
            if (data['popularCategories'].length !== 0) {
                brandOptions.push({
                    value: 'popular_group',
                    label: 'Популярные',
                    disabled: true,
                    customProperties: {type: 'group'}
                })
                brandOptions.push(
                    ...data['popularCategories'].map(mark => ({
                        value: mark['ID'],
                        label: mark['NAME']
                    }))
                );
            }

            if (data['fullCategories'].length !== 0) {
                brandOptions.push({
                    value: 'all_group',
                    label: 'Все',
                    disabled: true,
                    customProperties: {type: 'group'}
                })
                brandOptions.push(
                    ...data['fullCategories'].map(mark => ({
                        value: mark['ID'],
                        label: mark['NAME']
                    }))
                );
            }

            choices.setChoices(brandOptions, 'value', 'label', true);
            allBrandChoices.forEach(brandChoice => {
                brandChoice.setChoices(brandOptions, 'value', 'label', true);
            })
            allBrands.forEach(brandSelect => {
                numberIdSelect++; //new
                let selectedMark = brandSelect.getAttribute('data-sect');
                if (selectedMark) {
                    allBrandChoices.forEach(brandChoice => {
                        brandChoice.setChoiceByValue(selectedMark);
                    })
                }
            })

            let selectedMark = brandSelect.getAttribute('data-sect');
            if (selectedMark) {
                choices.setChoiceByValue(selectedMark);
            }
            hideSelectItem();
        }

        if (flag === 'getModels') {
            let modelOptions = [{value: "", label: 'Модель'}, {value: "reset", label: "Любая"}];
            data.forEach(model => {
                modelOptions.push({value: model['ID'], label: model['NAME']});
            })

            choices.setChoices(modelOptions, 'value', 'label', true);

            let selectedModel = choices.passedElement.element.getAttribute('data-sect') || "";

            if (selectedModel !== "") {
                selectedModel = (selectedModel.includes(',')) ? selectedModel.split(',') : [selectedModel];
                choices.setChoiceByValue(selectedModel);
            }

            listItemMultiple(choices.passedElement.element);
            hideSelectItem();
            document.querySelector('.select-model').classList.remove('loading-state');
        }
    }).catch((error) => console.log(error));
}

//новые функции
function moveSearchField(selectRow) {
    const choicesContainer = selectRow.querySelector('.choices');

    const searchInput = choicesContainer.querySelector('.choices__input.choices__input--cloned');

    const dropdown = choicesContainer.querySelector('.choices__list--dropdown');

    if (searchInput && dropdown) {
        choicesContainer.insertBefore(searchInput, dropdown);
    }
}

function listItemMultiple(item) {
    let val = item.value;
    setTimeout(() => {
        let container = item.parentNode.querySelector(".choices__list--multiple");
        if (container) {
            let allElem = Array.from(item.querySelectorAll("option")).map(item => item.innerText)

            $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
            $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
            if (item.length) {
                let concatStr = allElem.reduce((str, el) => str + "; " + el);
                container.innerHTML = `
              <div class="multipleSelectedContent">${concatStr}</div>
              <div class="multipleSelectedCnt">(${item.length})</div>
              `;
            } else {
                if (val !== "") {
                    cntParam(-1, item.closest(".form-row__col"))
                }
                // cntParam(-1, item.closest(".form-row__col"))
                item.closest(".form-row__col").classList.remove("is-active")
            }
        }
    })
}

function addBrandToString(brandName, brandString) {
    const lowerCaseBrandName = brandName.toLowerCase();
    const lowerCaseBrandString = brandString.toLowerCase();
    if (lowerCaseBrandString.includes(lowerCaseBrandName)) {
        return brandString;
    }
    const updatedBrandString = brandString ? `${brandString}, ${brandName}` : brandName;
    return updatedBrandString;
}

//new
function selectableItems() {
    let saveBrand = document.querySelector(".save-search-popup .search-popup__mark");
    saveBrand.textContent = ""
    let saveParam = document.querySelector(".save-search-popup .search-popup__parameters");
    saveParam.textContent = ""
    let arrSelectable = document.querySelectorAll(".choices__inner.is-active , .form-row__col.is-active");
    let checkboxList = document.querySelectorAll("input[type='checkbox']:checked:not(.no-send)")
    let radioList = document.querySelectorAll("input[type='radio']:checked")

    if (!arrSelectable.length) {
        saveBrand.textContent = "Все марки"
    }

    arrSelectable.forEach((el) => {
        let content = el.querySelector(".choices__item--selectable");
        let brand = el.closest(".row--brand");
        let filteredElements = Array.from(arrSelectable).filter(element =>
            element.closest('.row--brand') !== null
        );
        if (!filteredElements.length) {
            saveBrand.textContent = "Все марки"
        }

        if (brand) {
            saveBrand.textContent = addBrandToString(content.innerText, saveBrand.textContent);
        } else if (el.classList.contains("custom-select--multiple")) {
            let multipleItems = el.querySelector(".choices__list--multiple .multipleSelectedContent").innerText;
            let brandName = el.closest(".form-row").querySelector(".row--brand .choices__item--selectable").innerText;
            multipleItems = multipleItems.split(";");
            multipleItems.forEach((multiItem) => {
                let brandMark = multiItem;
                let str = `${brandName} ${brandMark}`;
                saveBrand.textContent = addBrandToString(str, saveBrand.textContent);
                let regEx = brandName + ",";
                saveBrand.textContent = saveBrand.textContent.replace(regEx, '')
            })
        } else if (el.querySelector(".custom-select--multiple")) {
            let multipleItems = el.querySelector(".choices__list--multiple .multipleSelectedContent").innerText;
            multipleItems = multipleItems.split(";");
            multipleItems.forEach((multiItem) => {
                let brandMark = multiItem;
                saveParam.textContent = addBrandToString(brandMark, saveParam.textContent);
            })
        } else if (el.classList.contains("choices__inner")) {
            if(el.closest('.form-group:not(.no-send)')) {
                let textContent = el.querySelector(".choices__item--selectable").innerText;
                if (el.closest(".year-end")) {
                    let yearStart = document.querySelector(".year-start select").value
                    if (yearStart) {
                        saveParam.textContent = saveParam.textContent + `-${textContent}`
                    } else {
                        saveParam.textContent = saveParam.textContent + `${textContent}`
                    }
                } else {
                    saveParam.textContent = addBrandToString(textContent, saveParam.textContent);
                }
            }
        } else {
            saveParam.textContent = addBrandToString(el.querySelector("input").value, saveParam.textContent);
        }
    })


    $(".save-list-btn").on("click", function () {
        $(".save-list").addClass("active");
    })

    checkboxList.forEach((el) => {
        let str = `${el.getAttribute('data-val')}`;
        saveParam.textContent = addBrandToString(str, saveParam.textContent);
        let regEx = el.getAttribute('data-val') + ",";
        saveParam.textContent = saveParam.textContent.replace(regEx, '')
    });

    radioList.forEach((el) => {
        let elValue = el.value.toLowerCase();
        if (elValue.length !== 0) {
            let str = `${el.getAttribute('data-val')}`;
            saveParam.textContent = addBrandToString(str, saveParam.textContent);
            let regEx = el.getAttribute('data-val') + ",";
            saveParam.textContent = saveParam.textContent.replace(regEx, '')
        }
    })

    let location = document.querySelectorAll(".form-row__col-30.is-active");
    location.forEach((el, i) => {
        let content = el.querySelector(".choices__item--selectable").textContent.trim();
        if (location.length - 1 === i) {
            saveParam.textContent = saveParam.textContent + " " + content
        } else {
            saveParam.textContent = saveParam.textContent + ` ${content},`
        }
    })

}

function cntParam(num, el) {
    $(".save-search").removeClass("active");
    if (cntParamСontent) {
        if (!el.classList.contains("is-active") && el.closest(".inner-more-form")) {
            cntParamСontent.textContent = +cntParamСontent.textContent + num;
        } else if (num < 0 && el.closest(".inner-more-form")) {
            cntParamСontent.textContent = +cntParamСontent.textContent + num;
        }

        if (cntParamСontent.textContent > 0) {
            cntParamСontent.style.visibility = 'visible';
        } else {
            cntParamСontent.style.visibility = 'hidden';
        }
    }
}

function activeItems() {
    let activeItem = document.querySelectorAll(".store-active");
    activeItem.forEach((el) => {
        el.querySelector(".choices__inner").classList.add("is-active");
    })
}

function removeDuplicates(el) {
    const select = document.querySelector(el);
    const textSet = new Set();
    for (let i = select.options.length - 1; i >= 0; i--) {
        const option = select.options[i];
        if (textSet.has(option.text)) {
            select.remove(i);
        } else {
            textSet.add(option.text);
        }
    }
}

//new
function showList(list, elPosition) {
    const rect = elPosition.getBoundingClientRect();

    list.style.top = `${rect.bottom + 5}px`;
    list.style.left = `${rect.left}px`;
    list.style.width = `${rect.width}px`;
    list.style.display = 'block';
}

//new
function preventScroll(event) {
    event.preventDefault();
}

//new
function hasScroll() {
    const documentHeight = document.documentElement.scrollHeight;
    const windowHeight = window.innerHeight;

    return documentHeight > windowHeight;
}

//new
function addScroll() {
    const scrollTop = window.scrollY;
    const scrollableElement = document.querySelector('.save-list');
    scrollableElement.removeEventListener('wheel', preventScroll);
    scrollableElement.removeEventListener('touchmove', preventScroll);
    $("body").removeClass("no-scroll")
    $("body").removeClass("fake")
}

//new
function removeScroll() {
    const scrollableElement = document.querySelector('.save-list');
    const scrollTop = window.scrollY;
    $("body").addClass("no-scroll")
    if (hasScroll()) {
        $("body").addClass("fake")
    }
    scrollableElement.addEventListener('wheel', preventScroll, {passive: false});
    scrollableElement.addEventListener('touchmove', preventScroll, {passive: false});
}