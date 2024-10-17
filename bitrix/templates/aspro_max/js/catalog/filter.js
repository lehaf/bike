let brandOptions = [{value: "", label: 'Марка'}, {value: "reset", label: "Любая"}];

let brandChoies = "";
let modelChoies = "";

// console.log(brandOptions);

document.addEventListener("DOMContentLoaded", () => {
    const templateFoundBrand = (name, sum) => {
        let brandEl =
            `
    <div class="found-brand__el">
            <a href="#" class="found-brand__name">
                ${name}
            </a>
            <span class="found-brand__line"></span>
            <span class="found-brand__sum">${sum}</span>
    </div>
    `
        return brandEl
    }
    const fullDataFoundBrand = {
        BMW: {name: "BMW", count: 4776},
        Honda: {name: "Honda", count: 6980},
        Motorland: {name: "Motorland", count: 4596},
        Voge: {name: "Voge", count: 4596},
        Ducati: {name: "Ducati", count: 1038},
        Kawasaki: {name: "Kawasaki", count: 1050},
        Suzuki: {name: "Suzuki", count: 1023},
        Yamaha: {name: "Yamaha", count: 1023},
        'Harley-Davidson': {name: "Harley-Davidson", count: 1092},
        KTM: {name: "KTM", count: 1115},
        Triumph: {name: "Triumph", count: 2046},
        Tesla: {name: "Tesla", count: 1500},
        Audi: {name: "Audi", count: 2000},
        Ford: {name: "Ford", count: 3000},
        Chevrolet: {name: "Chevrolet", count: 1800},
        Nissan: {name: "Nissan", count: 2200},
        Mercedes: {name: "Mercedes", count: 2500},
        Lexus: {name: "Lexus", count: 1400},
        Porsche: {name: "Porsche", count: 1700},
        Subaru: {name: "Subaru", count: 1300},
        Volkswagen: {name: "Volkswagen", count: 2100},
        Ferrari: {name: "Ferrari", count: 800},
        Lamborghini: {name: "Lamborghini", count: 750},
        Maserati: {name: "Maserati", count: 900},
        Bentley: {name: "Bentley", count: 650},
        'Aston Martin': {name: "Aston Martin", count: 700},
        'Rolls-Royce': {name: "Rolls-Royce", count: 600},
        'Alfa Romeo': {name: "Alfa Romeo", count: 850},
        Bugatti: {name: "Bugatti", count: 500},
        Cadillac: {name: "Cadillac", count: 950},
        Citroen: {name: "Citroen", count: 400},
        Fiat: {name: "Fiat", count: 300},
        Infiniti: {name: "Infiniti", count: 1100},
        Jaguar: {name: "Jaguar", count: 950},
        Jeep: {name: "Jeep", count: 1200},
        'Land Rover': {name: "Land Rover", count: 1150},
        Lincoln: {name: "Lincoln", count: 450},
        Mazda: {name: "Mazda", count: 1300},
        Mitsubishi: {name: "Mitsubishi", count: 1250},
        Peugeot: {name: "Peugeot", count: 1000},
        Renault: {name: "Renault", count: 850},
        Saab: {name: "Saab", count: 600},
        Seat: {name: "Seat", count: 500},
        Skoda: {name: "Skoda", count: 700},
        Volvo: {name: "Volvo", count: 1400}
    };

    const foundBrandBlock = document.querySelector(".found-brand-content");
    const templateBtn = (obj) => {
        return `
    <div class="found-brand__btn">Все марки - <span>${obj}</span></div>
    `
    }

    if (foundBrandBlock) {
        previewFoundBrand();
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
    })

    const brandSelect = document.getElementById('brand-select');
    const modelSelect = document.getElementById('model-select');

    const brandChoices = new Choices(brandSelect, {
        placeholder: true,
        searchPlaceholderValue: 'Марка',
        duplicateItemsAllowed: true,
        choices: brandOptions,
        shouldSort: false,
        shouldSortItems: false,
        position: "bottom"
    });

    const modelChoices = new Choices(modelSelect, {
        placeholder: true,
        searchPlaceholderValue: 'Модель',
        // choices: ["Модель"],
        shouldSort: false,
        resetScrollPosition: false,
        renderSelectedChoices: 'always',
        removeItemButton: true,
        duplicateItemsAllowed: true,
        position: "bottom"
    });

    hideSelectItem();

    brandSelect.addEventListener('change', function (event) {
        const selectedBrands = Array.from(brandSelect.selectedOptions).map(option => option.value);
        if (selectedBrands.length > 0) {
            this.parentElement.classList.add("is-active")
            this.closest(".choices").classList.add("is-active")
            this.closest(".form-row__col").classList.add("is-active")
            // const models = selectedBrands.flatMap(brand => data[brand]);
            // const uniqueModels = [...new Set(models)];

            modelChoices.clearStore();
            getCategories('getModels', 'categories', event.target.value, modelChoices);
            // modelChoices.setChoices(modelOptions, 'value', 'label', true);
            modelChoices.enable();
        } else {
            modelChoices.clearStore();
            modelChoices.enable();
        }
        const textContent = event.target.textContent.replace(/\s+/g, '')
        if (textContent.includes("Любая")) {
            brandChoices.setChoiceByValue('');
            modelChoices.setChoiceByValue('1')
            modelChoices.disable();
            this.parentElement.classList.remove("is-active")
            this.closest(".choices").classList.remove("is-active")
            this.closest(".form-row__col").classList.remove("is-active")
        }

        hideSelectItem()
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
            setTimeout(() => {
                modelChoices.removeActiveItems();
                modelChoices.hideDropdown()
                brandChoices.setChoiceByValue('');
                this.closest(".form-row__col").classList.remove("is-active")
            })
        } else {
            this.closest(".form-row__col").classList.add("is-active")
        }

    });

    modelSelect.addEventListener('change', function (event) {
        hideSelectItem()
    });

    const templateSelect = (id) => {
        return `
     <div class="form-row custom-select-inner form-group-custom-select flex-row flex-row--new">
            <div class="form-row__col">
                <div class="form-row">
                    <select id="brand-select-${id}" name="arFilter_mark_${id}"></select>
                </div>
                <div class="form-row add-select select-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.087 4.94545H12V7.10303H7.087V12H4.90072V7.10303H0V4.94545H4.90072V0H7.087V4.94545Z" fill="#666666"/>
                    </svg>
                </div>
            </div>
            <div class="form-row__col custom-select--multiple">
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


    let sectId = document.querySelector('form.selection-block').getAttribute('data-sect');
    getCategories('getMarks', 'categories', sectId, brandChoices);

    $("body").on("click", function (event) {
        let target = event.target;

        if (target.closest(".add-select")) {
            let numberId = $(".model-selection").children().length
            $(".model-selection").append(templateSelect(numberId + 1))
            addSelectBrandMark(numberId + 1)
            $(".remove-select").removeClass("hide");
            $(".remove-select").addClass("show");

        } else if (target.closest(".remove-select")) {
            target.closest(".custom-select-inner").remove()
            if ($(".model-selection").children().length < 2) {
                $(".remove-select").addClass("hide");
                $(".remove-select").removeClass("show");
            }
        }
    })

    const transportSelect = document.getElementById('transportSelect');
    const cylinderSelect = document.getElementById('cylinder');
    const cyclesSelect = document.getElementById('cycles');
    const mainGearSelect = document.getElementById('mainGear');
    const transmissionSelect = document.getElementById('transmission');
    console.log(cylinderSelect);

    if(transportSelect) selectMultiple(transportSelect, "Тип мотоцикла");
    if(cylinderSelect) selectMultiple(cylinderSelect, "Расположение цилиндров");
    if(cyclesSelect) selectMultiple(cyclesSelect, "Число тактов");
    if(mainGearSelect) selectMultiple(mainGearSelect, "Главная передача");
    if(transmissionSelect) selectMultiple(transmissionSelect, "Коробка");
    let listCustomSelect = document.querySelectorAll(".color-select select");

    listCustomSelect.forEach((el) => {
        el.addEventListener("change", (event) => {
            if (event.target.value !== "reset") {
                event.target.closest(".choices__inner").classList.add("is-active")
            } else {
                event.target.closest(".choices__inner").classList.remove("is-active")
            }
        })
    })

    let inputChange = document.querySelectorAll(".input-change");

    inputChange.forEach(function (el) {
        el.addEventListener("change", function () {
            const value = this.value.replace(this.getAttribute("data-text"), "");
            if (value) {
                if(this.getAttribute("data-text")) {
                    this.value = value.replace(", ", "") + ", " + this.getAttribute("data-text");
                }
                this.parentElement.classList.add("is-active");
            } else {
                this.parentElement.classList.remove("is-active")
            }
        })
    })

    $(".reset-input").on("click", function () {
        let inputElem = $(this).parent().find("input");
        this.parentElement.classList.remove("is-active");
        inputElem.val("");
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

    $(".save-search").on("click", function () {
        this.classList.add("active");
        $(".save-search-popup").addClass("active");
    })

    $(".search-popup__btn").on("click", function () {
        $(".save-search").removeClass("active");
        $(".save-search-popup").removeClass("active");
    })
})

function previewFoundBrand() {
    foundBrandBlock.innerHTML = ""
    for (let el in fullDataFoundBrand) {
        let index = Object.keys(fullDataFoundBrand)
        index.find((element, i) => {
            if (element === el && i < 11) {
                let item = templateFoundBrand(fullDataFoundBrand[el].name, fullDataFoundBrand[el].count)
                foundBrandBlock.innerHTML += item
                return
            } else if (element === el && i === 11) {
                foundBrandBlock.innerHTML += templateBtn(index.length)
                return;
            }
        })
    }
}
function addELlFoundBrand() {
    foundBrandBlock.innerHTML = ""
    for (let el in fullDataFoundBrand) {
        let item = templateFoundBrand(fullDataFoundBrand[el].name, fullDataFoundBrand[el].count)
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
    const brandChoices = new Choices(selectList[`brandChoices${id}`], {
        placeholder: true,
        searchPlaceholderValue: 'Марка',
        duplicateItemsAllowed: true,
        choices: brandOptions,
        shouldSort: false,
        shouldSortItems: false,
        position: "bottom"
    });

    const modelChoices = new Choices(selectList[`modelSelect${id}`], {
        placeholder: true,
        searchPlaceholderValue: 'Модель',
        // choices: ["Модель"],
        shouldSort: false,
        resetScrollPosition: false,
        renderSelectedChoices: 'always',
        removeItemButton: true,
        duplicateItemsAllowed: true,
        position: "bottom"
    });

    hideSelectItem()
    selectList[`brandChoices${id}`].addEventListener('change', function (event) {
        const selectedBrands = Array.from(selectList[`brandChoices${id}`].selectedOptions).map(option => option.value);

        if (selectedBrands.length > 0) {
            this.parentElement.classList.add("is-active")
            this.closest(".choices").classList.add("is-active")
            this.closest(".form-row__col").classList.add("is-active")
            // const models = selectedBrands.flatMap(brand => data[brand]);
            // const uniqueModels = [...new Set(models)];

            // const modelOptions = uniqueModels.map(model => {
            //     return {value: model, label: model};
            // });

            modelChoices.clearStore();
            getCategories('getModels', 'categories', event.target.value, modelChoices);

            // modelChoices.setChoices(modelOptions, 'value', 'label', true);
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
            this.parentElement.classList.remove("is-active")
            this.closest(".choices").classList.remove("is-active")
            this.closest(".form-row__col").classList.remove("is-active")
        }

        hideSelectItem()
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
                modelChoices.hideDropdown()
                brandChoices.setChoiceByValue('');
                this.closest(".form-row__col").classList.remove("is-active")
            })
        } else {
            this.closest(".form-row__col").classList.add("is-active")
        }

    });

    selectList[`modelSelect${id}`].addEventListener('change', function (event) {
        hideSelectItem()
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
                selectMultiple.hideDropdown()
                this.closest(".form-row__col").classList.remove("is-active")
            })
        } else {
            this.closest(".form-row__col").classList.add("is-active")
        }

    });

    item.addEventListener('change', function (event) {
        hideSelectItem()
    });

    hideSelectItem()
}

function getCategories(flag, action, sectId, choices) {
    fetch('/ajax/create_element.php', {
        method: 'POST',
        body: new URLSearchParams({action: action, sectId: sectId, flag: flag}),
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(res => {
        return res.json();
    }).then(data => {
        if(data.length !== 0) {
            if (flag === 'getMarks') {
                data.forEach(mark => {
                    brandOptions.push({value:mark['ID'], label:mark['NAME']});
                })
                choices.setChoices(brandOptions, 'value', 'label', true);
                hideSelectItem();
            }

            if (flag === 'getModels') {
                let modelOptions = [{value: "", label: 'Модель'}, {value: "reset", label: "Любая"}];
                data.forEach(model => {
                    modelOptions.push({value:model['ID'], label:model['NAME']});
                })

                choices.setChoices(modelOptions, 'value', 'label', true);
                hideSelectItem();
            }
        }
    }).catch((error) => console.log(error));
}

