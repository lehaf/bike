document.addEventListener("DOMContentLoaded", () => {
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

    $(".step-form__btn:not(.step-form__btn-submit)").on("click", stepBtn);
    $(".custom-input.number").on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    let selectTypes = [];//new
    const selectList = document.querySelectorAll(".custom-select");
    const selectDisabled = document.querySelector(".select-disabled");
    let selectCategory = '';
    let subSelect = '';

    console.log('select');
    setSelect(selectList);

    function setSelect(selectList) {
        selectList.forEach((el) => {
            if (el.classList.contains("selectSearch")) {
                let text = el.getAttribute("data-text")
                const selectSearch = new Choices(el, {
                    searchEnabled: true,
                    shouldSort: false,
                    searchPlaceholderValue: text,
                    position: 'bottom',
                    noResultsText: 'Ничего не найдено',
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
                } else if(el.getAttribute("data-type") === "currency"){
                    changePrice()
                }
                setTimeout(() => {
                    $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                }, 0)
            },
            false,
        );
    }

    function changePrice(){
        let startPrice = document.querySelector(".price-start");
        let endPrice = document.querySelector(".price-end");
        let localСurrency = startPrice.getAttribute("data-text").toLowerCase();
        if(localСurrency === "byn"){
            startPrice.setAttribute("data-text" , "USD");
            startPrice.setAttribute("placeholder" , "Цена (USD), от");
            endPrice.setAttribute("data-text" , "USD");
            if(startPrice.value){
                let sumStart = startPrice.value.slice(0,-5);
                console.log(sumStart)
                startPrice.value = sumStart + ", " + "USD";
            }
            if(endPrice.value){
                let sumStart = endPrice.value.slice(0,-5);
                endPrice.value = sumStart + ", " + "USD";
            }
        }else{
            startPrice.setAttribute("data-text" , "BYN");
            startPrice.setAttribute("placeholder" , "Цена (BYN), от");
            endPrice.setAttribute("data-text" , "BYN");

            if(startPrice.value){
                let sumStart = startPrice.value.slice(0,-5);
                startPrice.value = sumStart + ", " + "BYN";
            }
            if(endPrice.value){
                let sumStart = endPrice.value.slice(0,-5);
                endPrice.value = sumStart + ", " + "BYN";
            }
        }
    }


    function ajaxSelect(el, secondEl, listsArr, elChoices, secondElChoices, listType) {
        elChoices.setChoiceByValue('');
        $(el).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
        if (secondElChoices) {
            secondElChoices.setChoiceByValue('');
            secondElChoices.disable();
        }
        if (secondEl) $(secondEl).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');

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


            let elementId = el.getAttribute('data-el');
            console.log(el);
            if (elementId) {
                console.log(elementId);
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
                $('.select-region').addClass('loading-state');
                getLocation('getRegions', 'location', countryEl.value)
            };
            regionEl.onchange = () => {
                $('.select-city').addClass('loading-state');
                getLocation('getCities', 'location', regionEl.value);
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
            countrySelect.setChoiceByValue('');
            regionSelect.setChoiceByValue('');
            citySelect.setChoiceByValue('');
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
            // $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");

            el.addEventListener(
                'change',
                function (event) {
                    let textContent = event.target.textContent.replace(/\s+/g, '')
                    if (textContent === "Сбросить" || textContent === "Любая") {
                        select.setChoiceByValue('');
                        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                        $(this).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');

                        if (selectClear) {
                            selectClear.setChoiceByValue('');
                            selectClear.disable();
                        }
                        if (selectClearSecond) {
                            selectClearSecond.setChoiceByValue('');
                            selectClearSecond.disable();
                        }
                    } else {
                        $(this).siblings('.choices__list').find('.choices__item--selectable').removeClass('choices__placeholder');
                        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
                        if (selectClear) {
                            selectClear.enable();
                        }
                    }
                    // $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
                },
                false,
            );
        }
    }


//вывод бренд и моделей в блоке

    function templateBtn() {
        return `<div className="step-form__btn form__btn--disable ">
            Далее
            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.40796 11.5L11 6.00001C9.59738 4.62435 6.81062 1.87566 5.40799 0.5L4.7022 1.1828C5.96397 2.41998 7.63288 4.06854 9.10532 5.5145L-2.1919e-07 5.51447L-2.61636e-07 6.48553L9.10533 6.48553L4.70223 10.8096L5.40796 11.5Z"
                    fill="white"></path>
            </svg>
        </div>`
    }

    function getFields(sectId, target) {
        $('#stepForm').addClass('blur');
        fetch(window.location.href, {
            method: 'POST',
            body: new URLSearchParams({sectionId: sectId, action: 'updateSect'}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            let stepFormInner = $('.subcategory').closest('.step-form__inner');

            if ($(data).filter('.form-group').length === 0) {
                $('.fields').remove();

                if (stepFormInner.next().css('display') === 'none' && stepFormInner.find('.step-form__btn').length === 0) {
                    stepFormInner.append($(data).filter('.step-form__btn'));
                    stepFormInner.find('.step-form__btn:not(.step-form__btn-submit)').on("click", stepBtn);
                }

            } else {
                if ($('.fields').length === 0) {
                    stepFormInner.after('<div class="step-form__inner fields"></div>');
                }

                if ($('.fields').next().css('display') !== 'none') {
                    $('.fields').css('display', 'block');
                    data = $(data).not('.step-form__btn');
                }

                $('.fields').html(data);
                $(".fields .step-form__btn:not(.step-form__btn-submit)").on("click", stepBtn);
            }

            const selectList = document.querySelectorAll(".custom-select");
            setSelect(selectList);
            setColor();
            $('#stepForm').removeClass('blur');

        }).catch((error) => console.log(error));
    }

    let isShowCategories = document.querySelector('div[data-action="cat"]');
    let categoryEl = document.querySelector('#categorySelect');
    let isShowModels = document.querySelector('div[data-action="catModel"]');
    let modelEl = document.querySelector('#brand');

    if (isShowCategories && categoryEl) {
        let sectId = isShowCategories.getAttribute('data-id');
        getCategories('getCategories', 'categories', sectId);
    }

    if (isShowModels && modelEl) {
        let sectId = isShowModels.getAttribute('data-id');
        getCategories('getMarks', 'categories', sectId);
    }

    function getCategories(flag, action, sectId) {
        $('#stepForm').addClass('blur');
        fetch('/ajax/create_element.php', {
            method: 'POST',
            body: new URLSearchParams({action: action, sectId: sectId, flag: flag}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.json();
        }).then(data => {
            if (data.length !== 0) {
                if (flag === 'getMarks') {
                    let listMarksFull = data;
                    let listMarks = listMarksFull.slice(0, 27);
                    let flag = (listMarks.length >= 27);
                    objContent(listMarks, flag);
                    inputBrand(listMarksFull);
                    clickbrandBlock(listMarksFull);
                }

                if (flag === 'getModels') {
                    let listModelsFull = data;
                    let listModels = listModelsFull.slice(0, 27);
                    let flag = (listModels.length >= 27);
                    objContentModel(listModels, flag);
                    inputBrandModel(listModelsFull);
                    clickModelBlock(listModelsFull);
                    if (params['element']) {
                        let models = modelBlock.querySelectorAll('.brand-list__el input');
                        if (models.length !== 0) {
                            models.forEach(model => {
                                if (model.value === modelBlock.getAttribute('data-el')) model.checked = true;
                            })
                            modelBlock.removeAttribute('data-el');
                        }
                    }

                }

                if (flag === 'getCategories') {
                    let categoryArr = data;
                    categoryArr.unshift({ID: "", NAME: 'Поиск по названию'}, {ID: "reset", NAME: "Сбросить"});
                    ajaxSelect(categoryEl, null, categoryArr, selectCategory, null, 'cat-list');
                }
            }

            if (flag === 'getSubCategories') {
                $('.subcategory').empty();
                if (data.length !== 0) {
                    $('.subcategory').html(data);

                    let subCatEl = document.querySelector('#subCategorySelect');

                    if (subCatEl) {
                        let text = subCatEl.getAttribute("data-text");
                        const newSelectSearch = new Choices(subCatEl, {
                            searchEnabled: true,
                            shouldSort: false,
                            searchPlaceholderValue: text,
                            position: 'bottom'
                        })
                        listenerSelect(subCatEl, newSelectSearch)
                        subCatEl.onchange = () => getFields(subCatEl.value);
                        if (params['element']) {
                            getFields($('.subcategory').attr('data-el'));
                        }
                        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();

                        if (params['element']) {
                            newSelectSearch.setChoiceByValue($('.subcategory').attr('data-el'));
                        }
                    }

                } else {
                    getFields(sectId);
                }
            }

            $('#stepForm').removeClass('blur');

        }).catch((error) => console.log(error));
    }

    const templateBrandsItem = (id, img, text) => {
        return `
                                <div class="brand-list__el" data-id="${id}">
                                    <div class="brand-list__el__img">
                                        <img src="${img}" alt="img">
                                    </div>
                                    <div class="brand-list__el__title">
                                        ${text}
                                    </div>
                                </div>
`
    }

    const templateModalItem = (id, name) => {
        return `
    <div class="form-col brand-list__el">
         <input type="radio" class="radio-block" name="SUBSECT" id="modal-${id}" value="${id}" data-id="${id}"}>
         <label for="modal-${id}" class="radio-mini__label">${name}</label>
    </div>
    `
    }

    const templateBrandsBtn = (text) => {
        return `
                                <div class="brand-list__el__btn" >
                                     ${text}
                                    <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1.5L5 5L1 8.5" stroke="#ED1C24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                </div>
`
    }

    const templateNotBrands = (text) => {
        return `
                                <a class="brand-list__el" data-mark="no-mark" href="https://yandex.ru/support/autoru/adding.html" target="_blank" >
                                     ${text}
                                </a>
`
    }

    const brandBlock = document.querySelector("#brandBlock");
    const modelBlock = document.querySelector("#modelBlock");
    const brandInput = document.querySelector("#brand");
    const brandModalInput = document.querySelector("#brandModel");

    if (brandBlock && modelBlock && brandInput) {
        function objContent(obj, flag) {
            brandBlock.innerHTML = "";
            for (let el in obj) {
                let itemBrand = templateBrandsItem(obj[el].ID, obj[el].PICTURE, obj[el].NAME);

                brandBlock.innerHTML = brandBlock.innerHTML + itemBrand;
            }
            if (flag) {
                brandBlock.innerHTML = brandBlock.innerHTML + templateBrandsBtn("Все марки");
            } else {
                brandBlock.innerHTML = brandBlock.innerHTML + templateNotBrands("Нет моей марки")
            }
        }

        function inputBrand(objBrandsFull) {
            brandInput.addEventListener("input", function (event) {
                let value = this.value;
                brandBlock.innerHTML = ""
                for (let el in objBrandsFull) {
                    const statusSearch = objBrandsFull[el].NAME.toLowerCase().includes(value.toLowerCase().replaceAll(' ', ''));
                    if (statusSearch) {
                        let itemBrand = templateBrandsItem(objBrandsFull[el].ID, objBrandsFull[el].PICTURE, objBrandsFull[el].NAME);

                        brandBlock.innerHTML = brandBlock.innerHTML + itemBrand;
                    }
                }
                brandBlock.innerHTML = brandBlock.innerHTML + templateNotBrands("Нет моей марки")
            })
        }

        brandInput.addEventListener("click", function () {
            $("#brandBlock").addClass("active");
        })

        function clickbrandBlock(objBrandsFull) {
            brandBlock.addEventListener("click", function (event) {
                let target = event.target;
                let content = target.closest(".brand-list__el");
                let noMark = content !== null ? content.hasAttribute("data-mark") : false;
                if (content && !noMark) {
                    brandInput.value = content.textContent.replace(/\s+/g, '');
                    $("#brandBlock").removeClass("active");
                    brandModalInput.removeAttribute("disabled");
                    brandModalInput.value = "";
                    getCategories('getModels', 'categories', content.getAttribute('data-id'));
                } else if (noMark) {
                    brandInput.value = "Нет моей марки"
                    // $("#brandBlock").removeClass("active");
                    // brandModalInput.removeAttribute("disabled")
                }

                if (target.closest(".brand-list__el__btn")) {
                    objContent(objBrandsFull, false)
                }

                if (this.value) {
                    brandModalInput.removeAttribute("disabled")
                }
            })
        }

        function objContentModel(obj, flag) {
            modelBlock.innerHTML = "";
            let elementModelId = modelBlock.getAttribute('data-el');
            for (let el in obj) {
                let checked = "";
                let itemBrand = templateModalItem(obj[el].ID, obj[el].NAME);
                modelBlock.innerHTML = modelBlock.innerHTML + itemBrand;
            }
            if (flag) {
                modelBlock.innerHTML = modelBlock.innerHTML + templateBrandsBtn("Все марки");
            } else {
                modelBlock.innerHTML = modelBlock.innerHTML + templateNotBrands("Нет моей марки")
            }
        }
    }

    if (brandModalInput) {
        function inputBrandModel(objModelFull) {
            brandModalInput.addEventListener("input", function (event) {
                let value = this.value;
                modelBlock.innerHTML = ""
                for (let el in objModelFull) {
                    const statusSearch = objModelFull[el].NAME.toLowerCase().includes(value.toLowerCase().replaceAll(' ', ''));
                    if (statusSearch) {
                        let itemBrand = templateModalItem(objModelFull[el].ID, objModelFull[el].NAME);

                        modelBlock.innerHTML = modelBlock.innerHTML + itemBrand;
                    }
                }
                modelBlock.innerHTML = modelBlock.innerHTML + templateNotBrands("Нет моей марки")
            })
        }

        brandModalInput.addEventListener("click", function () {
            $("#modelBlock").addClass("active");
        })

        function clickModelBlock(objModelFull) {
            modelBlock.addEventListener("click", function (event) {
                let target = event.target;
                let content = target.closest(".brand-list__el");
                let noMark = content !== null ? content.hasAttribute("data-mark") : false;
                if (content && !noMark) {
                    brandModalInput.value = content.textContent.replace(/\s+/g, '').replaceAll(' ', '');
                    let firstRadio = content.querySelector('input[type="radio"]');
                    if (firstRadio) {
                        firstRadio.checked = true;
                    }
                    $("#modelBlock").removeClass("active");
                    // brandModification.removeAttribute("disabled")
                } else if (noMark) {
                    brandModalInput.value = "Нет моей модели"
                    // $("#modelBlock").removeClass("active");
                    // brandModification.removeAttribute("disabled")
                }

                if (target.closest(".brand-list__el__btn")) {
                    objContentModel(objModelFull, false)
                }
            })
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


    $(".size-input").on("change", function () {
        if ($(this).hasClass("size-input--square")) {
            let result = squareProduct($("#length"), $("#width"))
            if (result !== undefined) {
                $("#square").val(result + ", м2")
            }
        }
    })

// Загрузка фото в объявлении

    let templateImg = (img, name) => {
        return `
            <div class="preview-img" data-img="${name}">
                <img src="${img}" alt="img">
                <span class="preview-remove" data-file="${name}">
                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.46063 0.844419L0.671515 7.63353M7.50912 7.68203L0.623021 0.795925" stroke="white" stroke-width="0.923168" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </span>
                <span class="main-photo">Главное фото</span>
                <span class="ad-main-photo">Сделать главным</span>
            </div>
            `
    }

    let fileListImg = [];

    let loadedImg = () => {
        $(".dropzone_count__loaded").text(fileListImg.length)
    }

    function readerImgFile(imgList) {

        if (imgList.length !== 0) {
            imgList.forEach((file) => {

                let reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = function () {
                    if (fileListImg.length < 10) {
                        $(".dropzone__content").append(templateImg(reader.result, file.name))
                        fileListImg.push(file);
                        loadedImg()
                    } else {
                        alert("Больше нельзя добавлять")
                    }
                }

            })
        }

    }

    let files = [];

    $("#inputFile").on("change", function () {
        let imgList = [...Array.from(this.files), ...files];
        files = [];
        readerImgFile(imgList)
        this.value = ""
    })

    if (params['element']) {
        fetch('/ajax/edit_element.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'photos',
                elementsId: params['element'],
                iblock: document.querySelector('.steps-content').getAttribute('data-iblock')
            }),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.json();
        }).then(async data => {
            for (const img of data) {
                let imgBlob = await getFileBlob(img);
                let imgFile = new File([imgBlob], img.split('/').pop(), {type: imgBlob.type});
                files.push(imgFile);
            }
            $("#inputFile").change();
            console.log(images);
        }).catch((error) => console.log(error));
    }


    $(".dropzone__content").on("click", () => {
        let target = event.target
        if (target.closest(".preview-remove")) {
            let dataName = target.closest(".preview-remove").getAttribute("data-file")
            let removeItemImg = fileListImg.find(file => file.name === dataName)

            fileListImg = fileListImg.filter(file => file !== removeItemImg)

            const itemPreview = document.querySelector(`[data-file="${dataName}"]`).closest(".preview-img")
            itemPreview.classList.add("remove");
            itemPreview.remove();

            // setTimeout(() => {
            // }, 300)

        } else if (target.closest(".ad-main-photo")) {
            let previewImgList = document.querySelectorAll(".preview-img");
            previewImgList.forEach((el) => {
                el.classList.remove("is-active");
            })
            target.closest(".preview-img").classList.add("is-active");

            const dataName = target.closest(".preview-img").querySelector(".preview-remove").getAttribute("data-file");
            const selectedFile = fileListImg.find(file => file.name === dataName);
            if (selectedFile) {
                fileListImg = fileListImg.filter(file => file !== selectedFile);
                fileListImg.unshift(selectedFile);
            }

        }
        loadedImg()
    })

    function highlightDropZone(event) {
        event.preventDefault()
        this.classList.add("drop")
    }

    function unHighlightDropZone(event) {
        event.preventDefault()
        this.classList.remove("drop")
    }

    const dropzone = document.querySelector(".dropzone")

    if (dropzone) {

        dropzone.addEventListener("dragover", highlightDropZone)
        dropzone.addEventListener("dragenter", highlightDropZone)
        dropzone.addEventListener("dragleave", unHighlightDropZone)
        dropzone.addEventListener("drop", (event) => {
            let dt = event.dataTransfer.files[0]
            let dtListImg = Array.from(event.dataTransfer.files)

            unHighlightDropZone.call(dropzone, event)
            readerImgFile(dtListImg)
        })
    }
// end loaded photo


// переход по шагам

    function checkFormButton(block) {
        let stateInput = block.querySelector("input:checked") !== null ? true : false;
        if (!stateInput) {
            block.querySelector(".error-form").classList.add("show");
        }
        return stateInput
    }

    $(".check-select-inner label").on("click", function (ev) {
        ev.stopPropagation();
    })


    if (selectDisabled) {
        const selectIsDisabled = new Choices(selectDisabled, {
            searchEnabled: false,
            shouldSort: false,
            disabledState: 'is-disabled',
        })

        listenerSelect(selectDisabled, selectIsDisabled)

        selectIsDisabled.disable()


        $(".check-select-inner").on("click", function () {
            let checkList = $(this).find(".form-checked");
            let flag;
            $.each(checkList, function (e, el) {
                let stateInput = el.querySelector("input:checked") !== null ? true : false;
                if (!stateInput) {
                    return flag = false
                } else {
                    return flag = true
                }
            })
            if (flag) {
                selectIsDisabled.enable();
            }
        })
    }

    function stepBtn() {
        let flag = !$(this).hasClass("form__btn--disable") ? true : false;
        let parent = $(this).parent();
        let listCheck = parent.find(".check-block");
        $(".error-form").removeClass("show");
        $(".error").removeClass("error");

        if (listCheck.length) {
            $.each(listCheck, function (i, el) {
                let tagName = el.tagName.toLowerCase();
                if (this.classList.contains("form-checked")) {
                    flag = checkFormButton(el);
                    if (!flag) return false
                } else if (!el.value || el.value === "0") {
                    flag = false;
                    if (tagName === "select") {
                        el.closest(".form-group").querySelector(".choices__inner").classList.add("error");
                    } else {
                        el.classList.add("error");
                    }
                    let parent = el.closest(".form-col") || el.closest(".form-group");
                    parent.querySelector(".error-form").classList.add("show");
                    return false
                } else if (listCheck.length === i + 1) {
                    flag = true
                }
            })
        } else flag = true

        if (flag) {
            parent.next().show();
            $(this).remove()
        }
    }

    const squareProduct = function (a, b) {
        if (a.val() && b.val()) {
            return a.val().replace(/\D+$/, '') * b.val().replace(/\D+$/, '');
        }

    }

    let imgList = document.querySelectorAll(".step-category__el__img img");

    imgList.forEach((el) => {
        let url = el.getAttribute("data-mobile");
        if (url) {
            el.setAttribute("src", url)
        }
    })

    let form = document.querySelector("#stepForm");

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            let formData = new FormData(event.target);
            formData.append('ajax', 'Y');
            formData.append('action', 'add');
            if (params['element']) {
                formData.set('action', 'edit');
            }

            console.log(fileListImg);
            let preview = fileListImg.shift();
            formData.append('picture', preview);

            fileListImg.forEach((img, key) => {
                formData.append("MORE_PHOTO[" + key + "]", img);
            })

            let square = document.querySelector('input[name="square"]');
            if (square) formData.append('square', square.value);

            let phones = document.querySelectorAll('.dataUserTel');
            formData.delete('phone');
            if (phones.length !== 0) {
                phones.forEach(phone => {
                    if (phone.value.length !== 0) {
                        formData.append('phone[]', phone.value);
                    }
                })
            }

            // formData.append('NAME', 'test');

            let sectId = document.querySelector("[name='SUBCATEGORY']") || document.querySelector("[name='CATEGORY']");
            if (sectId) {
                if (sectId.value.length !== 0) {
                    formData.append('sectionId', sectId.value);
                }
                formData.append("IBLOCK_SECTION_ID", sectId.value);
            }

            let subSect = document.querySelector("[name='SUBSECT']:checked");
            if (subSect) {
                formData.append("IBLOCK_SECTION_ID", subSect.value);
            }

            $("#stepForm").addClass('blur');
            fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).then(response => response.json())
                .then(data => {
                    if (data['STATUS'] === 'OK') {
                        if (data['FORM'].length !== 0) {
                            $('body').append(data['FORM']);
                        } else {
                            alert('Ваше объявление опубликовано! Обявление будет доступно после проверки модератора');
                            window.location.href = "/";
                        }
                    }

                    if (data['STATUS'] === 'ERROR') {
                        let allErrorBlocks = document.querySelectorAll('.error-form.show');
                        if (allErrorBlocks.length !== 0) {
                            allErrorBlocks.forEach(error => {
                                error.classList.remove('show');
                            })
                        }

                        let allErrorChoices = document.querySelectorAll('.error');
                        if (allErrorChoices.length !== 0) {
                            allErrorChoices.forEach(error => {
                                error.classList.remove('error');
                            })
                        }

                        for (let key in data['ERRORS']) {
                            let element = document.querySelector('[name="' + key + '"]') || document.querySelector('[name="' + key + '[]"]');
                            if (key === "country") {
                                let parentCountryBlock = element.closest('.step-form__inner');
                                let checkBlocks = parentCountryBlock.querySelectorAll('.check-block.country');
                                checkBlocks.forEach(block => {
                                    if (!block.value || block.value == 0) {
                                        block.closest(".form-group").querySelector(".choices__inner").classList.add("error");
                                        block.closest(".form-group").querySelector(".error-form").classList.add("show");
                                    }
                                })
                            }

                            if (element) {
                                let tagName = element.tagName;
                                let parentElement = element.closest('.form-col') || element.closest('.form-group:not(.form-group--tel)') || element.closest('.form-row');

                                if (tagName === "SELECT") {
                                    parentElement.querySelector(".choices__inner").classList.add("error");
                                } else {
                                    element.classList.add("error");
                                }

                                let errorBlock = parentElement.querySelector('.error-form');
                                if (errorBlock) errorBlock.classList.add('show');
                            }
                        }
                        $("#stepForm").removeClass('blur');
                        let hiddenElem = document.querySelector('.error-form.show');
                        hiddenElem.scrollIntoView({block: "center", behavior: "smooth"});
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        })
    }

    let checkContractPrice = document.querySelector('.contract-price');
    if (checkContractPrice) {
        let inputPrice = document.querySelector('div[data-type="price"]');
        if (checkContractPrice.checked) inputPrice.style.display = "none";
        checkContractPrice.addEventListener('change', (e) => {
            if (e.target.checked) {
                inputPrice.style.display = "none";
                inputPrice.querySelector('input').value = 1;
            } else {
                inputPrice.style.display = "block";
                inputPrice.querySelector('input').value = "";
            }
        })
    }

    //new code start
    $("#filter").on("reset", function (event) {
        $(".is-active").removeClass("is-active");
        cntParamСontent.textContent = "0";
        // selectTypes.forEach(selectType => {
        //     selectType.setChoiceByValue('');
        //     selectType.removeActiveItems();
        // });
        //
        // setTimeout(()=>{
        //     $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
        //     $('.custom-select-inner:not(".select-no_reset") .choices__item--choice[data-id=2]').attr("data-value", "reset");
        // })
    });
    // new code end

    if (params['element']) {
        getLocationPromise('getRegions', 'location', countryEl.getAttribute('data-el'))
            .then(() => {
                return getLocationPromise('getCities', 'location', regionEl.getAttribute('data-el'));
            })
            .then(() => {
                console.log('Все запросы завершены.');
            })
            .catch((error) => {
                console.error('Ошибка:', error);
            });
        // getLocation('getRegions', 'location', countryEl.getAttribute('data-el'));
        // getLocation('getCities', 'location', regionEl.getAttribute('data-el'));

        if (brandInput) {
            getCategories('getModels', 'categories', brandInput.getAttribute('data-el'));
        }

        if (categoryEl) {
            getCategories('getSubCategories', 'categories', categoryEl.getAttribute('data-el'));
        }
    }

    const maskPhone = () => {
        $(".dataUserTel").mask("+375 (99) 999-99-99");
    }

    maskPhone()

    const templatePhone = function () {
        return `
 <div class="form-group form-group--tel__new">
     <input type="tel" placeholder="+375 (xx) xxx-xx-xx" class="custom-input dataUserTel">
     <span class="remove_phone">
     <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.09758 6.44252L11.9531 10.298L10.2599 11.9912L6.40441 8.13569L2.56149 11.9786L0.845798 10.2629L4.68872 6.41999L0.842858 2.57413L2.53602 0.880967L6.38188 4.72683L10.2629 0.845859L11.9785 2.56156L8.09758 6.44252Z" fill="#666666"/>
</svg>
</span>
 </div>
`
    }

    $('.add-new-phone').on('click', function () {
        $('.form-tel-container').append(templatePhone)
        maskPhone()
        $(".remove_phone").on("click", function (event) {
            this.parentElement.remove();
        })
    });

    ymaps.ready(init);

    function init() {
        const searchInput = document.querySelector("#mapInput");

        var map = new ymaps.Map('map', {
                center: [55.70, 37.56],
                zoom: 12,
                controls: ['zoomControl'],
                behaviors: ['drag'],
            }
        );

        var searchControl = new ymaps.control.SearchControl({
            options: {
                provider: 'yandex#search',
                noPlacemark: true,
                noSelect: true,
            }
        });
        map.controls.add(searchControl);
        // var suugestView = new ymaps.SuggestView(searchInput);

        searchInput.addEventListener("input", function () {
            let inputValue =this.value.trim();
            let coords = inputValue.split(',').map(function (item) {
                return parseFloat(item.trim());
            });
            map.setCenter(coords);
            //
            searchControl.search(this.value);
            searchControl.events.add('load', function (event) {
                if (!event.get('skip') && searchControl.getResultsCount()) {
                    searchControl.showResult(0);
                }
            });
        })

        if(params['element']) {
            let inputValue = searchInput.value.trim();
            if(inputValue.length !== 0) {
                let coordinates = inputValue.split(',').map(function (item) {
                    return parseFloat(item.trim());
                });

                var myPlacemark = new ymaps.Placemark(coordinates);
                // Получение адреса по координатам
                ymaps.geocode(coordinates).then(function (res) {
                    var address = res.geoObjects.get(0).properties.get('text'); // Получаем полный адрес
                    const parts = address.split(',').map(part => part.trim());
                    const city = parts[0]; // Город
                    const street = parts[1] ? parts[1] + ',' + (parts[2] ? ' ' + parts[2] : '') : '';

                    // Форматируем содержимое балуна
                    var balloonContent = '<strong>' + street + '</strong><br><small>' + city + '</small>';
                    myPlacemark.properties.set('balloonContent', balloonContent); // Устанавливаем отформатированное содержимое в балун

                    // Открываем балун с адресом
                    map.geoObjects.add(myPlacemark);
                    myPlacemark.balloon.open();
                });
            }
        }

    }

    function getLocationPromise(flag, action, id) {
        return new Promise((resolve, reject) => {
            getLocation(flag, action, id); // Вызов оригинальной функции

            // Установить таймер для ожидания завершения асинхронной операции
            const checkCompletion = setInterval(() => {
                // Проверяем, завершился ли процесс
                if (!$('#stepForm').hasClass('blur')) {
                    clearInterval(checkCompletion); // Остановить проверку
                    resolve(); // Разрешить промис
                }
            }, 100); // Проверять каждые 100 мс
        });
    }

    async function getFileBlob(url) {
        const response = await fetch(url);
        const blob = await response.blob();
        return blob;
    }

})
