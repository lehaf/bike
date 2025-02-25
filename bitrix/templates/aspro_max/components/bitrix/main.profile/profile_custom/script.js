$(document).ready(function(){
	$('a.cancel').click(function(e){
		e.preventDefault()
		document.form1.reset();
	});
});


init();

function init() {
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

	document.querySelector("form[name='form1']").addEventListener("submit", function() {
		regionSelect.enable();
		citySelect.enable();
	});
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
					let attribute = el.id;
					if (attribute === "country") {
						regionSelect.setChoiceByValue('');
						citySelect.setChoiceByValue('');
						// $(".location-group-select .is-active").removeClass("is-active")
					} else if (attribute === "region") {
						// cityEl.closest(".is-active") ? cityEl.closest(".is-active").classList.remove("is-active") : false
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
					// this.closest(".form-row__col-30").classList.remove("is-active");
				} else {
					$('.custom-select-inner .choices__item--choice[data-id=1]').hide();
					if (selectClear) {
						selectClear.enable();
					}
					// this.closest(".form-row__col-30").classList.add("is-active");
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
		// $(el).closest('.form-row__col-30').removeClass('is-active');
		$(el).siblings('.choices__list').find('.choices__item--selectable').addClass('choices__placeholder');
		if (secondElChoices) {
			secondElChoices.setChoiceByValue('');
			// secondElChoices.disable();
		}
		if (secondEl) {
			// $(secondEl).closest('.form-row__col-30').removeClass('is-active');
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
		}
	}
}


