// несколько селектов с кнопкой сброса
document.addEventListener("DOMContentLoaded", () => {
    $(".step-form__btn:not(.step-form__btn-submit)").on("click", stepBtn);
    $(".custom-input.number").on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    const selectList = document.querySelectorAll(".custom-select");
    const selectDisabled = document.querySelector(".select-disabled");
    let selectCategory = '';
    let subSelectCategory = '';

    setSelect(selectList);
    function setSelect(selectList) {
        selectList.forEach((el) => {
            if (el.classList.contains("selectSearch")) {
                let text = el.getAttribute("data-text")
                const selectSearch = new Choices(el, {
                    searchEnabled: true,
                    shouldSort: false,
                    searchPlaceholderValue: text,
                })
                if (el.id === 'categorySelect') {
                    selectCategory = selectSearch;
                }

                listenerSelect(el, selectSearch)
            } else {
                const selectType = new Choices(el, {
                    searchEnabled: false,
                    shouldSort: false,
                })
                listenerSelect(el, selectType)
            }
        })


        $('.custom-select-inner .choices__item--choice[data-id=1]').hide();
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

    function ajaxSelect(el, listsArr, elChoices, listType) {
        elChoices.setChoiceByValue('');
        $(el).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
        elChoices.clearChoices();
        $('[data-select="' + listType + '"]').empty();
        if (listsArr) {
            for (let i = 0; i < listsArr.length; i++) {
                o = new Option(listsArr[i]['NAME'], i, false, false);
                $('[data-select="'+ listType +'"]').append(o);
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
        }
    }

    const countryEl = document.querySelector("#country");
    const regionEl = document.querySelector("#region");
    const cityEl = document.querySelector("#city");

    selectAdd();
    function selectAdd() {
        if(countryEl && regionEl) {
            countryEl.onchange = () => getLocation('getRegions', 'location', countryEl.value);
            regionEl.onchange = () => getLocation('getCities', 'location', regionEl.value);
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
        })

        const regionSelect = new Choices(regionEl, {
            searchEnabled: false,
            shouldSort: false,
        })

        const citySelect = new Choices(cityEl, {
            searchEnabled: false,
            shouldSort: false,
        })

        addListener(countryEl, countrySelect, regionSelect, citySelect)
        addListener(regionEl, regionSelect, citySelect)
        addListener(cityEl, citySelect, false)

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
                    ajaxSelect(regionEl, listsArr, regionSelect, 'region-list');
                }

                if (flag === 'getCities') {
                    let cityArr = data;
                    cityArr.unshift({ID: "", NAME: 'Город'}, {ID: "reset", NAME: "Сбросить"});
                    ajaxSelect(cityEl, cityArr, citySelect, 'city-list');
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
                    if (textContent === "Сбросить") {
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

    function getFields(sectId) {
        $('#stepForm').addClass('blur');
        fetch(window.location.href, {
            method: 'POST',
            body: new URLSearchParams({sectionId: sectId, action: 'updateSect'}),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(res => {
            return res.text();
        }).then(data => {
            $('.fields .step-form__title').nextUntil('.fields .step-form__btn').remove();
            $('.fields .step-form__title').hide();

            if (data.trim().length !== 0) {
                $('.fields .step-form__title').show();
                $('.fields .step-form__title').after(data);
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
            if(data.length !== 0) {
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
                }

                if (flag === 'getCategories') {
                    let categoryArr = data;
                    categoryArr.unshift({ID: "", NAME: 'Поиск по названию'}, {ID: "reset", NAME: "Сбросить"});
                    ajaxSelect(categoryEl, categoryArr, selectCategory, 'cat-list');
                }

                if (flag === 'getSubCategories') {
                    $('.subcategory').empty();
                    if (data.length !== 0) {
                        $('.subcategory').html(data);
                        let subCatEl = document.querySelector('#subCategorySelect');
                        let text = subCatEl.getAttribute("data-text")
                        const selectSearch = new Choices(subCatEl, {
                            searchEnabled: true,
                            shouldSort: false,
                            searchPlaceholderValue: text,
                        })

                        listenerSelect(subCatEl, selectSearch)
                        subCatEl.onchange = () => getFields(subCatEl.value);
                    } else {
                        getFields(sectId);
                    }
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
         <input type="radio" class="radio-block" name="SUBSECT" id="modal-${id}" value="${id}" data-id="${id}">
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
            for (let el in obj) {
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

    const selectType = new Choices(selectCurrency, {
        searchEnabled: false,
        shouldSort: false,
    })

    ymaps.ready(init);

    function init() {
        const searchInput = document.querySelector("#mapInput");

        var map = new ymaps.Map('map', {
                center: [53.90, 27.56],
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
        var suugestView = new ymaps.SuggestView(searchInput);

        searchInput.addEventListener("input", function () {
            searchControl.search(this.value);
            searchControl.events.add('load', function (event) {
                if (!event.get('skip') && searchControl.getResultsCount()) {
                    searchControl.showResult(0);
                }
            });
        })
        /*    var clusterer = new ymaps.Clusterer({
                clusterIcons: [
                    {
                        href: 'img/burger.png',
                        size: [100, 100],
                        offset: [-50, -50]
                    }
                ],
                clusterIconContentLayout: null
            });

            map.geoObjects.add(clusterer);*/
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
            target.remove();
            if (!$(".ad-description-list").children().length) {
                $(".ad-description-list").remove()
            }
        }
    })

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


    $(".size-input").on("change", function () {
        if ($(this).hasClass("size-input--square")) {
            let result = squareProduct($("#length"), $("#width"), $("#height"))
            if (result !== undefined) {
                $("#square").val(result + ", м2")
            }
        }
        // const value = this.value.replace(this.getAttribute("data-size"), "");
        // this.value = value.replace(", ", "") + ", " + this.getAttribute("data-size");


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

    $("#inputFile").on("change", function () {
        let imgList = Array.from(this.files)
        readerImgFile(imgList)
        this.value = ""
    })


    $(".dropzone__content").on("click", () => {
        let target = event.target
        if (target.closest(".preview-remove")) {
            let dataName = target.closest(".preview-remove").getAttribute("data-file")

            let removeItemImg = fileListImg.find(file => file.name === dataName)

            fileListImg = fileListImg.filter(file => file !== removeItemImg)

            const itemPreview = document.querySelector(`[data-file="${dataName}"]`).closest(".preview-img")
            itemPreview.classList.add("remove")

            setTimeout(() => {
                itemPreview.remove()
            }, 300)

        } else if (target.closest(".ad-main-photo")) {
            let previewImgList = document.querySelectorAll(".preview-img");
            previewImgList.forEach((el) => {
                el.classList.remove("is-active");
            })
            target.closest(".preview-img").classList.add("is-active");
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
                } else if (!el.value) {
                    flag = false;
                    if (tagName === "select") {
                        el.closest(".form-group").querySelector(".choices__inner").classList.add("error");
                    } else {
                        el.classList.add("error");
                    }
                    let parent =   el.closest(".form-col") ||  el.closest(".form-group");
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
    const squareProduct = function (a, b, c) {
        if (a.val() && b.val() && c.val()) {
            return a.val().replace(/\D+$/, '') * b.val().replace(/\D+$/, '') * c.val().replace(/\D+$/, '');
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
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            let formData = new FormData(event.target);
            formData.append('ajax', 'Y');

            let square = document.querySelector('input[name="square"]');
            if(square) formData.append('square', square.value);

            let phones = document.querySelectorAll('.dataUserTel');
            formData.delete('phone');
            if(phones.length !== 0) {
                phones.forEach(phone => {
                    if(phone.value.length !== 0) {
                        formData.append('phone[]', phone.value);
                    }
                })
            }

            // formData.append('NAME', 'test');

            let sectId = document.querySelectorAll("[name='IBLOCK_SECTION_ID']");
            if (sectId.length > 0) {
                let lastSectId = sectId[sectId.length - 1].value;
                formData.append('sectionId', lastSectId);
            }

            let subSect = document.querySelector("[name='SUBSECT']:checked");
            if(subSect) {
                formData.append("IBLOCK_SECTION_ID", subSect.value);
            }

            //добавление изображений
            let allImages = document.querySelectorAll(".dropzone__content .preview-img img");
            let previewImg = document.querySelector(".dropzone__content .preview-img.is-active img") || allImages[0];

            if (allImages.length !== 0 && previewImg) {
                allImages = Array.from(allImages).filter(function (item) {
                    return item !== previewImg;
                });

                formData.append('PREVIEW_PICTURE', previewImg.getAttribute('src'));
                formData.append('DETAIL_PICTURE', previewImg.getAttribute('src'));

                allImages.forEach(img => {
                    formData.append("MORE_PHOTO[]", img.getAttribute('src'));
                })
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

                    if(data['STATUS'] === 'ERROR') {
                        let allErrorBlocks = document.querySelectorAll('.error-form.show');
                        if(allErrorBlocks.length !== 0) {
                            allErrorBlocks.forEach(error => {error.classList.remove('show');})
                        }

                        let allErrorChoices = document.querySelectorAll('.error');
                        if(allErrorChoices.length !== 0) {
                            allErrorChoices.forEach(error => {error.classList.remove('error');})
                        }

                        for(let key in data['ERRORS']) {
                            let element = document.querySelector('[name="' + key + '"]') || document.querySelector('[name="' + key + '[]"]');
                            if(key === "country") {
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
                                let parentElement =  element.closest('.form-col') || element.closest('.form-group:not(.form-group--tel)') || element.closest('.form-row');

                                if (tagName === "SELECT") {
                                    parentElement.querySelector(".choices__inner").classList.add("error");
                                } else {
                                    element.classList.add("error");
                                }

                                let errorBlock = parentElement.querySelector('.error-form');
                                if(errorBlock) errorBlock.classList.add('show');
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
})
