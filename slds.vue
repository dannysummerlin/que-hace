<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
<link rel='stylesheet' href='https://unpkg.com/v-calendar/lib/v-calendar.min.css'/>
<script src='https://unpkg.com/v-calendar'></script>
<template id="template-lightning-vertical-tab-nav">
	<li :class="'slds-vertical-tabs__nav-item' + (active ? ' slds-is-active' : '')" :title="title" role="presentation" @click="selectTab">
		<a class="slds-vertical-tabs__link" href="javascript:void(0)" role="tab" :tabindex="tab" :aria-selected="active" :aria-controls="'slds-vertical-tabs-'+ tab" :id="'slds-vertical-tabs-'+ tab +'__nav'">
			<span class="slds-vertical-tabs__left-icon"></span>
			<span class="slds-truncate" :title="title">{{ title }} <slot></slot></span>
			<span class="slds-vertical-tabs__right-icon"></span>
		</a>
	</li>
</template>
<script type="text/javascript">
var sldsVerticalTabNav = Vue.component("lightning-vertical-tab-nav", {
	template: document.getElementById('template-lightning-vertical-tab-nav').innerHTML,
	props: ['title', 'active', 'tab'],
	data() { return {} },
	created() { this.active = this.active || false },
	methods: {
		selectTab(ev) {
			let tab = {}
			if(ev.target.tagName == 'LI') { tab = ev.target }
			else { tab = ev.target.closest('li') }
		
			let classClean = [].slice.call( tab.parentElement.getElementsByTagName('li')).forEach( (e)=>{ e.classList.remove('slds-is-active') } )
			tab.classList.add('slds-is-active')
			let tabClean = [].slice.call( tab.parentElement.parentElement.getElementsByClassName('slds-vertical-tabs__content')).forEach((e)=>{
				e.classList.remove('slds-show')
				e.classList.add('slds-hide')
			})
			let tabContentId = tab.getElementsByTagName('a')[0].getAttribute('aria-controls')
			document.getElementById(tabContentId).classList.add('slds-show')
			document.getElementById(tabContentId).classList.remove('slds-hide')
		}
	}
})
</script>

<template id='template-lightning-input'>
	<div class="slds-form-element">
		<label class="slds-form-element__label" for="sldsinput">{{ label }}</label>
		<div class="slds-form-element__control">
			<input :disabled="disabled" :placeholder="placeholder" class="slds-input" :type="type " v-model="inputValue" />
			<button :disabled="disabled" @click="inputValue = ''" class="slds-button slds-button_icon slds-input__icon slds-input__icon_right" title="Clear" style="float:right;margin:-1.7em 1em 0 0">&#10006;<span class="slds-assistive-text">Clear</span></button>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsInput = Vue.component("lightning-input", {
	template: document.getElementById('template-lightning-input').innerHTML,
	props: ['label', 'placeholder', 'value', 'type', 'disabled'],
	data() { return { inputValue: this.value } },
	created() { this.type = this.type || 'text' },
	methods: {},
	watch: {
		inputValue(val) { this.$emit('input', val) },
		value(val) { this.inputValue = val },
	}
})
</script>

<template id="template-lightning-header">
	<div class="slds-page-header">
		<div class="slds-page-header__row">
			<div class="slds-page-header__col-title">
				<div class="slds-media">
					<div class="slds-media__body">
						<div class="slds-page-header__name">
							<div class="slds-page-header__name-title">
								<h1>
									<span class="slds-page-header__title slds-truncate" :title="title">{{title}}</span>
								</h1>
							</div>
						</div>
						<p class="slds-page-header__name-meta">{{secondLine}}</p>
					</div>
				</div>
			</div>
			<div class="slds-page-header__col-actions">
				<div class="slds-page-header__controls">
					<slot></slot>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsHeader = Vue.component("lightning-header", { template: document.getElementById('template-lightning-header').innerHTML,
	props: ['title', 'secondLine'], data() { return {} }
})
</script>

<template id="template-lightning-card">
	<div class="slds-card">
		<div class="slds-card__header slds-grid" v-if="title">
			<header class="slds-media slds-media_center slds-has-flexi-truncate">
				<div class="slds-media__body">
					<h2 class="slds-card__header-title">
						<a href="javascript:void(0);" class="slds-card__header-link slds-truncate" :title="title">
							<span>{{ title }}</span>
						</a>
					</h2>
				</div>
				<div class="slds-no-flex">
					<slot name="button"></slot>
				</div>
			</header>
		</div>
		<div class="slds-card__body slds-card__body_inner slds-grid slds-gutters">
			<slot></slot>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsCard = Vue.component("lightning-card", {
	template: document.getElementById('template-lightning-card').innerHTML,
	props: ['title'],
	data() { return { data: null } },
	created() {},
	methods: {}
})
</script>

<template id="template-lightning-spinner">
	<div role="status" class="slds-spinner slds-spinner_medium slds-spinner_brand">
		<span class="slds-assistive-text">Loading</span>
		<div class="slds-spinner__dot-a"></div>
		<div class="slds-spinner__dot-b"></div>
	</div>
</template>
<style>
.slds-spinner { margin:0 auto; position:absolute;top:4rem;}
</style>
<script type="text/javascript">
var sldsSpinner = Vue.component("lightning-spinner", { template: document.getElementById('template-lightning-spinner').innerHTML })
</script>

<template id="template-lightning-button">
	<button :class="'slds-button slds-button_' + type" :disabled="disabled" @click="action">
		<slot></slot>
	</button>
</template>
<script type="text/javascript">
var sldsButton = Vue.component("lightning-button", {
	template: document.getElementById('template-lightning-button').innerHTML,
	props: ['type', 'action', 'disabled'],
	data() { return {} },
	created() { this.type = this.type || 'neutral' },
	methods: {}
})
</script>

<template id="template-lightning-checkbox">
	<div class="slds-form-element" style="margin-top:1em">
		<div class="slds-form-element__control">
			<div class="slds-checkbox">
				<input type="checkbox" :disabled="disabled" :name="name" v-model="inputValue" />
				<label class="slds-checkbox__label">
					<span class="slds-checkbox_faux" @click="inputValue = (disabled ? false : !inputValue)"></span>
					<span class="slds-form-element__label" @click="inputValue = (disabled ? false : !inputValue)">{{ label }}</span>
				</label>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsCheckbox = Vue.component("lightning-checkbox", {
	template: document.getElementById('template-lightning-checkbox').innerHTML,
	props: ['label', 'value', 'name', 'disabled'],
	data() { return { inputValue: this.value } },
	watch: {
		inputValue(val) { this.$emit('input', val) },
		value(val) { this.inputValue = val }
	}
})
</script>

<template id="template-lightning-tiles">
	<ul class="slds-has-dividers_around-space lightning-tiles">
		<slot></slot>
	</ul>
</template>
<style>
.lightning-tiles { display: flex; flex-flow: column wrap; height: 100%; align-content: space-between; }
.lightning-tiles .slds-item:nth-child(3n+1) { order: 1; }
.lightning-tiles .slds-item:nth-child(3n+2) { order: 2; }
.lightning-tiles .slds-item:nth-child(3n)   { order: 3; }
.lightning-tiles::before, .lightning-tiles::after { content: ""; flex-basis: 100%; width: 0; order: 2 }
.lightning-tiles .slds-item { width: 32% }
.lightning-tiles .slds-item:first-child { margin-top:9px }
/* .lightning-tiles.slds-has-dividers_around-space > .slds-item + .slds-item { margin-top: 0 } */
</style>
<script type="text/javascript">
var sldsTiles = Vue.component("lightning-tiles", { template: document.getElementById('template-lightning-tiles').innerHTML, data() { return {} }, methods: {} })
</script>

<template id="template-lightning-tile">
	<li class="slds-item">
		<article class="slds-tile slds-tile_board">
			<h3 class="slds-tile__title slds-truncate" :title="title">{{ title }}</h3>
			<div class="slds-tile__detail">
				<p class="slds-text-heading_medium">{{ value }}</p>
				<p class="slds-truncate">
					<slot></slot>
				</p>
			</div>
		</article>
	</li>
</template>
<script type="text/javascript">
var sldsTile = Vue.component("lightning-tile", {
	template: document.getElementById('template-lightning-tile').innerHTML,
	props: ['title', 'value', 'detail']
})
</script>

<template id="template-lightning-col">
	<div class="slds-col"><slot></slot></div>
</template>
<script type="text/javascript">
var sldsCol = Vue.component("lightning-col", { template: document.getElementById('template-lightning-col').innerHTML, data() { return {} }, methods: {} })
</script>

<template id="template-lightning-listbox-item">
	<li role="presentation" class="slds-listbox__item" @click="returnItemId(itemId)">
		<div class="slds-media slds-listbox__option slds-listbox__option_entity slds-listbox__option_has-meta" role="option">
			<span class="slds-listbox__option-text slds-listbox__option-text_entity">
					<span>{{ displayLine }}</span>
					<span class="slds-listbox__option-meta slds-listbox__option-meta_entity">{{ secondLine }}</span>
					<input type="hidden" :value="itemId" />
			</span>
		</div>
	</li>
</template>
<script type="text/javascript">
var sldsListboxItem = Vue.component("lightning-listbox-item", {
	template: document.getElementById('template-lightning-listbox-item').innerHTML,
	props: ['itemId', 'displayLine', 'secondLine'],
	data() { return {} },
	created() {},
	methods: { returnItemId(id) { this.$emit('input', id) } }
})
</script>

<template id="template-lightning-lookup-search">
	<div class="slds-form-element">
		<label class="slds-form-element__label">{{ title }}</label>
		<div class="slds-form-element__control">
			<div :class="'slds-combobox_container ' + ( selectionId != '' ? 'slds-has-selection' : '')">
				<div :class="'slds-combobox slds-dropdown-trigger slds-dropdown-trigger_click ' + (results.length ? 'slds-is-open' : '')" aria-expanded="true" aria-haspopup="listbox" role="combobox">
					<div class="slds-combobox__form-element" role="none">
						<input :disabled="disabled" v-if="selectionId == ''" class="slds-input slds-combobox__input" aria-activedescendant="option1" aria-autocomplete="list" autocomplete="off" role="combobox" type="text" v-model="searchString" @input="debouncedSearchSObjects" @blur="showSearch = false" @keyup.esc="showSearch = false" />
						<input :disabled="disabled" v-if="selectionId != ''" readonly="" class="slds-input slds-combobox__input slds-combobox__input-value" aria-activedescendant="option2" aria-autocomplete="list" autocomplete="off" role="combobox" type="text" v-model="selectionName" />
						<button :disabled="disabled" v-if="selectionId != ''" @click="clearSelection" class="slds-button slds-button_icon slds-input__icon slds-input__icon_right" title="Remove selected option" style="float:right;margin:-1.7em 1em 0 0">&#10006;<span class="slds-assistive-text">Remove selected option</span></button>
						<lightning-spinner v-if="showProgress"></lightning-spinner>
					</div>
					<div class="slds-dropdown slds-dropdown_length-with-icon-7 slds-dropdown_fluid" role="listbox" v-if="selectionId == '' || showSearch">
						<ul class="slds-listbox slds-listbox_vertical" role="presentation">
							<li role="presentation" class="slds-listbox__item">
								<div class="slds-media slds-listbox__option slds-listbox__option_entity slds-listbox__option_term slds-has-focus" role="option">
									<span class="slds-media__figure slds-listbox__option-icon">
										<span class="slds-icon_container slds-icon-utility-search " :title="'Search for ' + title ">
											<lightning-icon-search></lightning-icon-search>
											<span class="slds-assistive-text">Search for {{ title }}: </span>
										</span>
									</span>
									<span class="slds-media__body">
										<span class="slds-listbox__option-text slds-listbox__option-text_entity">Results for "{{ searchString }}"</span>
									</span>
								</div>
							</li>
							<lightning-listbox-item v-for="item in results" :display-line="item.FirstName + ' ' + item.LastName" :item-id="item.Id" :second-line="item.Email" v-model="selectionId" :key="item.Id"></lightning-listbox-item>
						</ul>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsLookupSearch = Vue.component("lightning-lookup-search", {
	template: document.getElementById('template-lightning-lookup-search').innerHTML,
	props: ['title', 'sObject', 'field', 'displayLine', 'currentValue', 'disabled'],
	data() { return { searchString: '', results: [], showProgress: false, selection: {}, selectionId: '', showSearch: false } },
	created() {
		if(!isEmpty(this.currentValue))
			this.selectionId = this.currentValue
		this.debouncedSearchSObjects = _.debounce(this.searchSObjects, 500)
	},
	computed: {
		selectionName() {
			let name = ''
			switch (this.sObject.toLowerCase()) {
				case 'contact':
					name = (typeof this.selection != 'undefined' && Object.keys(this.selection).length > 0) ? this.selection.FirstName + " " + this.selection.LastName : this.displayLine
					break
			}
			return name
		}
	},
	methods: {
		clearSelection() {
			this.selectionId = ''
			this.selection = {}
			this.searchString = ''
			this.showSearch = false
		},
		searchSObjects() {
			if(this.searchString.length > 2) {
				let url = "/wp-admin/admin-ajax.php";
				let requestData = {
					auth: 'kl4ds802354nmnswdf',
					action: 'sfQuerySObject',
					fields: 'default'
				}
				this.showProgress = true
				axios.post(url, Object.assign(Object.create({}), { sObject: this.sObject, where: this.field + " like '%"+ this.searchString +"%'" }, requestData))
				.then(result => {
					this.results = result.data.records
					this.showSearch = true
					this.showProgress = false
				})
				.catch(error => {
					console.log("error", error)
					this.showSearch = false
					this.showProgress = false
				})
			}
		}
	},
	watch: {
		selectionId(val) {
			this.selection = this.results.filter((r)=>{return r.Id == val})[0]
			if(!isEmpty(val))
				this.showSearch = false
			this.$emit('input', val)
		}
	}
})
</script>

<style>
.slds-toast-hidden {display:none}
.slds-toast-show {
	opacity: 0;
	animation-name: fadeInOpacity;
	animation-iteration-count: 1;
	animation-timing-function: ease-in;
	animation-duration: 5s;
	width: auto;
	margin: 0 30%
}
@keyframes fadeInOpacity {
	0% { opacity: 0 }
	10% { opacity: 0.8 }
	90% { opacity: 0.8 }
	100% { opacity: 0 }
}
</style>
<template id="template-lightning-toast">
  <div class="slds-notify_container slds-is-absolute">
		<div :class="'slds-notify slds-notify_toast slds-theme_' + type" role="status">
			<span class="slds-icon_container slds-icon-utility-info slds-m-right_small slds-no-flex slds-align-top">&#128712;</span>
			<div class="slds-notify__content"><h2 class="slds-text-heading_small"><slot></slot></h2></div>
			<!-- <div class="slds-notify__close">
				<button class="slds-button slds-button_icon slds-button_icon-inverse" title="Close">&#10006;<span class="slds-assistive-text">Close</span></button>
			</div> -->
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsToast = Vue.component("lightning-toast", {
	template: document.getElementById('template-lightning-toast').innerHTML,
	props: ['type'],
	data() { return {} },
	created() { this.type = this.type || 'info' },
	methods: {}
})
</script>

<template id="template-lightning-appnav">
	<div>
		<div class="slds-context-bar">
			<div class="slds-context-bar__primary">
				<div class="slds-context-bar__item slds-context-bar__dropdown-trigger slds-dropdown-trigger slds-dropdown-trigger_click slds-no-hover">
					<div class="slds-context-bar__icon-action">
						<button class="slds-button slds-icon-waffle_container slds-context-bar__button" @click="showAppMenu = true">
							<span class="slds-icon-waffle">
								<span class="slds-r1"></span>
								<span class="slds-r2"></span>
								<span class="slds-r3"></span>
								<span class="slds-r4"></span>
								<span class="slds-r5"></span>
								<span class="slds-r6"></span>
								<span class="slds-r7"></span>
								<span class="slds-r8"></span>
								<span class="slds-r9"></span>
							</span>
							<span class="slds-assistive-text">Open App Launcher</span>
						</button>
					</div>
					<span class="slds-context-bar__label-action slds-context-bar__app-name">
						<span class="slds-truncate" :title="title">{{ title }}</span>
					</span>
				</div>
			</div>
			<nav class="slds-context-bar__secondary" role="navigation">
				<ul class="slds-grid">
					<li class="slds-context-bar__item" v-for="item in navItems">
						<router-link :to="'/' + item.url" class="slds-context-bar__label-action">{{ item.title }}</router-link>
					</li>
				</ul>
			</nav>
		</div>
		<lightning-appmenu :app-menu-items="appMenuItems" :show="showAppMenu"></lightning-appmenu>
	</div>
</template>
<script type="text/javascript">
var sldsAppNav = Vue.component("lightning-appnav", {
	template: document.getElementById('template-lightning-appnav').innerHTML,
	props: ['navItems', 'title', 'appMenuItems'],
	data() { return { showAppMenu: false } },
	created() {},
	methods: {}
})
</script>

<template id="template-lightning-appmenu">
	<div :class="show ? 'slds-show' : 'slds-hide'">
		<section role="dialog" tabindex="-1" class="slds-modal slds-fade-in-open slds-modal_large slds-app-launcher" aria-modal="true" aria-describedby="modal-content-id-1" @click="show = false">
			<div class="slds-modal__container">
				<header class="slds-modal__header slds-grid slds-grid_align-spread slds-grid_vertical-align-center">
					<button class="slds-button slds-button_icon slds-modal__close slds-button_icon-inverse" title="Close" @click="show = false">
						X
						<span class="slds-assistive-text">Close</span>
					</button>
					<h2 class="slds-text-heading_medium">App Launcher</h2>
					<!-- <div class="slds-app-launcher__header-search">
						<div class="slds-form-element">
							<label for="app-launcher-search" class="slds-form-element__label slds-assistive-text">Find an app</label>
							<div class="slds-form-element__control slds-input-has-icon slds-input-has-icon_left">
								<lightning-icon-search></lightning-icon-search>
								<input type="search" class="slds-input" id="app-launcher-search" placeholder="Find an app" />
							</div>
						</div>
					</div> -->
				</header>
				<div class="slds-modal__content slds-app-launcher__content slds-p-around_medium" id="modal-content-id-1">
					<div class="slds-section slds-is-open">
						<h3 class="slds-section__title">
							<button aria-controls="appsContent" aria-expanded="true" class="slds-button slds-section__title-action">
								<span class="slds-truncate" title="All Apps">All Apps</span>
							</button>
						</h3>
						<div aria-hidden="false" class="slds-section__content" id="appsContent">
							<div class="slds-assistive-text" id="drag-live-region" aria-live="assertive"></div>
							<ul class="slds-grid slds-grid_pull-padded slds-wrap">
	<!-- start -->
								<li class="slds-p-horizontal_small slds-size_1-of-1 slds-medium-size_1-of-3" v-for="item in appMenuItems" :key="item.url">
									<div draggable="true" class="slds-app-launcher__tile slds-text-link_reset">
										<div class="slds-app-launcher__tile-figure">
											<span class="slds-avatar slds-avatar_large">
												<abbr class="slds-avatar__initials slds-icon-custom-27" :title="item.title">{{ item.abbr }}</abbr>
											</span>
										</div>
										<div class="slds-app-launcher__tile-body">
											<a :href="item.url">{{ item.title }}</a>
											<p>{{ item.description }}</p>
											<div class="slds-popover slds-popover_tooltip slds-nubbin_top slds-hide" role="tooltip" id="help-0" style="position:absolute;top:100px;left:165px">
												<div class="slds-popover__body"></div>
											</div>
										</div>
									</div>
								</li>
	<!-- end -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="slds-backdrop slds-backdrop_open" @click="show = false"></div>
	</div>
</template>
<script type="text/javascript">
var sldsAppmenu = Vue.component("lightning-appmenu", {
	template: document.getElementById('template-lightning-appmenu').innerHTML,
	props: ['appMenuItems', 'show'],
	data() { return {} }
})
</script>

<template id="template-lightning-textarea">
	<div class="slds-form-element">
		<label class="slds-form-element__label">{{ title }}</label>
		<div class="slds-form-element__control">
			<textarea :maxlength="maxlength" :disabled="disabled" class="slds-textarea" :placeholder="placeholder" v-model="inputValue"></textarea>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsTextarea = Vue.component("lightning-textarea", {
	template: document.getElementById('template-lightning-textarea').innerHTML,
	props: ['placeholder', 'title', 'value', 'disabled', 'maxlength'],
	data() { return { inputValue: this.value } },
	watch: { inputValue(val) { this.$emit('input', val) } }
})
</script>

<template id="template-lightning-picklist">
	<div class="slds-form-element">
		<label class="slds-form-element__label">{{ title }}</label>
		<div class="slds-form-element__control">
			<div class="slds-combobox_container">
				<div :class="'slds-combobox slds-combobox__form-element slds-input-has-icon slds-input-has-icon_right slds-dropdown-trigger slds-dropdown-trigger_click' + (showOptions ? ' slds-is-open' : '')" aria-haspopup="listbox" role="combobox">
					<input :disabled="disabled" class="slds-input slds-combobox__input slds-combobox__input-value" autocomplete="off" role="textbox" type="text" :placeholder="placeholder" readonly="" v-model="inputValue" @click="showOptions = !showOptions" />
					<span class="slds-icon_container slds-input__icon slds-input__icon_right"><lightning-icon-down :class-list="'slds-icon slds-icon_x-small slds-icon-text-default'"></lightning-icon-down></span>
					<div role="listbox">
						<ul class="slds-listbox slds-listbox_vertical slds-dropdown slds-dropdown_fluid" role="presentation">
							<lightning-picklist-option v-for="option in options" :key="option.value" :option="option" :selected="option.value == inputValue" v-model="inputValue"></lightning-picklist-option>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsPicklist = Vue.component("lightning-picklist", {
	template: document.getElementById('template-lightning-picklist').innerHTML,
	props: ['placeholder', 'title', 'value', 'options', 'disabled'],
	data() { return { inputValue: '', showOptions: false } },
	created() {
		this.inputValue = this.value
		this.placeholder = this.placeholder || "Select an Option"
	},
	watch: {
	value(val) { this.inputValue = val },
	inputValue(val) {
		this.$emit('input', val)
		this.showOptions = false
	} }
})
</script>
	
<template id="template-lightning-picklist-option">
	<li role="presentation" class="slds-listbox__item" @click="selectOption">
		<div class="slds-media slds-listbox__option slds-listbox__option_plain slds-media_small slds-media_center slds-is-selected" role="option">
			<span class="slds-media__figure" v-if="selected">
				<lightning-icon-check :class="'slds-icon slds-icon_x-small slds-listbox__icon-selected'"></lightning-icon-check>
			</span>
			<span class="slds-media__body">
				<span class="slds-truncate" :title="option.title">{{ option.title }}</span>
			</span>
		</div>
	</li>
</template>
<script type="text/javascript">
var sldsPicklistOption = Vue.component("lightning-picklist-option", {
	template: document.getElementById('template-lightning-picklist-option').innerHTML,
	props: ['option', 'selected'],
	data() { return {} },
	methods: { selectOption() { this.$emit('input', this.option.value) } }
})
</script>

<template id="template-lightning-accordion">
	<ul class="slds-accordion">
		<slot></slot>
	</ul>
</template>
<style>
.slds-accordion {width:100%}
</style>
<script type="text/javascript">
var sldsAccordion = Vue.component("lightning-accordion", {
	template: document.getElementById('template-lightning-accordion').innerHTML,
	data() { return {} }
})
</script>

<template id="template-lightning-accordion-item">
	<li :class="'slds-accordion__list-item lightning-accordion-item' + (theme ? ' slds-theme_' + theme : '')">
		<details class="slds-accordion__section">
			<summary class="slds-accordion__summary">
				<h3 class="slds-accordion__summary-heading">
					<lightning-icon-chevron-right :class-list="'slds-button__icon slds-accordion__summary-action-icon slds-button__icon_left'"></lightning-icon-chevron-right>
					<span class="slds-truncate" :title="title">{{ title }}</span>
					<lightning-icon-warning v-if="icon == 'warning'" :class-list="'slds-button__icon slds-button__icon_right'"></lightning-icon-warning>
					<lightning-icon-undo v-if="icon == 'undo'" :class-list="'slds-button__icon slds-button__icon_right'"></lightning-icon-undo>
					<lightning-icon-reassign v-if="icon == 'reassign'" :class-list="'slds-button__icon slds-button__icon_right'"></lightning-icon-reassign>
					<lightning-icon-check v-if="icon == 'check'" :class-list="'slds-button__icon slds-button__icon_right'"></lightning-icon-check>
				</h3>
			</summary>
			<div>
				<slot></slot>
			</div>
		</details>
	</li>
</template>
<style>
.lightning-accordion-item.slds-accordion__list-item { text-transform: capitalize }
.lightning-accordion-item.slds-accordion__list-item summary::-webkit-details-marker { display: none }
.lightning-accordion-item.slds-accordion__list-item details summary svg { transform: rotate(0deg); transition: transform 0.1s }
.lightning-accordion-item.slds-accordion__list-item details[open] summary svg { transform: rotate(90deg); transition: transform 0.1s }
</style>
<script type="text/javascript">
var sldsAccordionItem = Vue.component("lightning-accordion-item", {
	template: document.getElementById('template-lightning-accordion-item').innerHTML,
	props: ['title', 'show', 'icon', 'theme'],
	data() { return {} }
})
</script>

<template id="template-lightning-panel">
	<div :class='"slds-panel slds-size_medium slds-panel_docked slds-panel_docked-"+ side +" "+ (show ? "slds-is-open":"")'>
		<div class="slds-panel__header">
			<h2 class="slds-panel__header-title slds-text-heading_small slds-truncate" title="Panel Header">{{title}}</h2>
			<button class="slds-button slds-button_icon slds-button_icon-small slds-panel__close" @click="show = false" title="Collapse Panel Header">
				<!-- <lightning-icon-close></lightning-icon-close> -->
				X
				<span class="slds-assistive-text">Collapse Panel</span>
			</button>
		</div>
		<div class="slds-panel__body">
			<slot></slot>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsPanel = Vue.component("lightning-panel", {
	template: document.getElementById('template-lightning-panel').innerHTML,
	props: ['title', 'show', 'side'],
	created() {
		// this.side = this.side || 'left'
	}
})
</script>

<template id="template-lightning-datepicker">
	<div class="slds-form-element lightning-datepicker">
		<label class="slds-form-element__label">{{ label }}</label>
		<v-date-picker v-model="dateValue" :popover-visibility="disabled ? 'hidden' : 'focus'" :popover-direction="direction" :input-props="{class: 'slds-input', disabled: disabled}"></v-date-picker>
		<span class="slds-icon_container slds-input__icon slds-input__icon_right" style="position: absolute;margin-top:-1.5rem;right:0.5rem"><lightning-icon-dateinput :class-list="'slds-icon slds-icon_x-small slds-icon-text-default'"></lightning-icon-dateinput></span>
	</div>
</template>
<style>
.c-pane-container {font-family: "Salesforce Sans",Arial,sans-serif !important; border-radius: 0.25rem; border:1px solid rgb(221, 219, 218); box-shadow: rgba(0, 0, 0, 0.16) 0px 2px 3px 0px;background:#fff !important}
.c-day-background {background-color:#005fb2 !important}
.lightning-datepicker .slds-input input {border:0}
</style>
<script type="text/javascript">
var sldsDatepicker = Vue.component("lightning-datepicker", {
	template: document.getElementById('template-lightning-datepicker').innerHTML,
	props: ['value', 'label', 'disabled', 'direction'],
	data() { return { dateValue: null }},
	created() {
		if(this.value)
			this.dateValue = new Date(this.value)
		this.direction = this.direction || 'top'
	},
	watch: {
		value(val) { if(val)
			this.dateValue = new Date(val + "T04:00:00")
		},
		dateValue(val) { this.$emit('input', val.toISOString().substring(0,10)) }
	}
})
</script>

<template id="template-lightning-box">
	<div :class="'slds-box ' + classList">
		<slot></slot>
	</div>
</template>
<script type="text/javascript">
var sldsBox = Vue.component("lightning-box", { template: document.getElementById('template-lightning-box').innerHTML, props: ['classList'] })
</script>

<template id="template-lightning-warning">
	<lightning-box :class-list="'lightning-warning slds-theme_warning slds-theme_alert-texture'">
		<lightning-icon-warning :class-list="'slds-icon slds-theme_warning'"></lightning-icon-warning>
		<slot></slot>
	</lightning-box>
</template>
<style>
.lightning-warning { margin:0;padding:6px;text-align:center }
.lightning-warning .slds-icon {height:1.3rem;width:1.3rem}
</style>
<script type="text/javascript">
var sldsWarning = Vue.component("lightning-warning", { template: document.getElementById('template-lightning-warning').innerHTML })
</script>

<style>
.slds-icon {fill:currentColor !important}
</style>
<template id="template-lightning-icon-search">
	<svg :class="'slds-icon lightning-icon-search '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><title></title><path d="M22.9 20.9l-6.2-6.1c1.3-1.8 1.9-4 1.6-6.4-.6-3.9-3.8-7.1-7.8-7.4C5 .4.4 5 1 10.5c.3 4 3.5 7.3 7.4 7.8 2.4.3 4.6-.3 6.4-1.5l6.1 6.1c.3.3.7.3 1 0l.9-1c.3-.3.3-.7.1-1zM3.7 9.6c0-3.2 2.7-5.9 5.9-5.9 3.3 0 6 2.7 6 5.9 0 3.3-2.7 6-6 6-3.2 0-5.9-2.6-5.9-6z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconSearch = Vue.component("lightning-icon-search", { template: document.getElementById('template-lightning-icon-search').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-warning">
	<svg :class="'slds-icon lightning-icon-warning '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M23.7 19.6L13.2 2.5c-.6-.9-1.8-.9-2.4 0L.3 19.6c-.7 1.1 0 2.6 1.1 2.6h21.2c1.1 0 1.8-1.5 1.1-2.6zM12 18.5c-.8 0-1.4-.6-1.4-1.4s.6-1.4 1.4-1.4 1.4.6 1.4 1.4-.6 1.4-1.4 1.4zm1.4-4.2c0 .3-.2.5-.5.5h-1.8c-.3 0-.5-.2-.5-.5v-6c0-.3.2-.5.5-.5h1.8c.3 0 .5.2.5.5v6z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconWarning = Vue.component("lightning-icon-warning", { template: document.getElementById('template-lightning-icon-warning').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-chevron-right">
	<svg :class="'slds-icon lightning-icon-chevron-right '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M8.3 2l9.5 9.5c.3.3.3.7 0 1L8.3 22c-.3.2-.8.2-1.1 0l-1-1c-.2-.3-.2-.8 0-1.1l7.6-7.4c.2-.3.2-.7 0-1L6.3 4.1C6 3.8 6 3.3 6.3 3l1-1c.3-.2.7-.2 1 0z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconChevronRight = Vue.component("lightning-icon-chevron-right", { template: document.getElementById('template-lightning-icon-chevron-right').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-check">
	<svg :class="'slds-icon lightning-icon-check '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M8.8 19.6L1.2 12c-.3-.3-.3-.8 0-1.1l1-1c.3-.3.8-.3 1 0L9 15.7c.1.2.5.2.6 0L20.9 4.4c.2-.3.7-.3 1 0l1 1c.3.3.3.7 0 1L9.8 19.6c-.2.3-.7.3-1 0z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconCheck = Vue.component("lightning-icon-check", { template: document.getElementById('template-lightning-icon-check').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-down">
	<svg :class="'slds-icon lightning-icon-down '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M3.8 6.5h16.4c.4 0 .8.6.4 1l-8 9.8c-.3.3-.9.3-1.2 0l-8-9.8c-.4-.4-.1-1 .4-1z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconDown = Vue.component("lightning-icon-down", { template: document.getElementById('template-lightning-icon-down').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-undo">
	<svg :class="'slds-icon lightning-icon-undo '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M14 5.8c4.8 0 8.7 3.9 8.7 8.7s-3.9 8.8-8.7 8.8h-3.8c-.4 0-.6-.3-.6-.7v-1.5c0-.3.3-.7.6-.7H14c3.3 0 5.9-2.6 5.9-5.9S17.3 8.6 14 8.6H7.6s-.4 0-.5.1c-.4.2-.3.4 0 .8l2.3 2.2c.2.3.2.7-.1 1l-1 1c-.3.3-.6.3-.9.1l-6-6c-.2-.3-.2-.6 0-.9l6-5.9c.3-.3.7-.3 1 0l.9.9c.3.3.3.8 0 1L7.1 5.2c-.3.2-.3.6.1.6H14z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconUndo = Vue.component("lightning-icon-undo", { template: document.getElementById('template-lightning-icon-undo').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-redo">
	<svg :class="'slds-icon lightning-icon-redo '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M16.4 5.8h.3c.5 0 .5-.4.2-.6l-2.3-2.3c-.2-.2-.2-.7 0-1l1-.9c.2-.3.7-.3 1 0l5.9 5.9c.3.3.3.6 0 .9l-6 6c-.3.2-.6.2-.9-.1l-1-1c-.2-.3-.3-.7 0-1l2.2-2.2c.4-.4.5-.6.1-.8-.1-.1-.5-.1-.5-.1H10c-3.3 0-5.9 2.7-5.9 5.9s2.6 5.9 5.9 5.9h3.7c.4 0 .7.4.7.7v1.5c0 .4-.3.7-.6.7H10c-4.8 0-8.8-3.9-8.8-8.8s4-8.7 8.8-8.7h6.4z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconRedo = Vue.component("lightning-icon-redo", { template: document.getElementById('template-lightning-icon-redo').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-reassign">
	<svg :class="'slds-icon lightning-icon-reassign '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M10.7 4.7C8.4 2.4 4.6 1.6 1.3 2.6c-.1 0-.3.3-.3.6V5c0 .4.3.5.5.4C4 4.4 7.1 4.9 9 7l.6.5c.2.3 0 .8-.4.8H5.6c-.3 0-.7.2-.7.7v1.3c0 .4.3.7.7.7l8.9.1c.4 0 .7-.3.7-.7V1.6c0-.4-.2-.7-.7-.7h-1.3c-.4 0-.8.3-.8.7v3.6c0 .4-.5.6-.8.3 0 .1-.9-.8-.9-.8zm-9.1 8.1H3c.4 0 .7.4.7.7v6.1c0 .4.3.7.7.7h15.2c.4 0 .7-.3.7-.7V7.8c0-.4-.3-.7-.7-.7h-1.8c-.4 0-.7-.3-.7-.7V5c0-.3.3-.7.7-.7h3.4c1 0 1.9.9 1.9 1.9v15c0 1-.9 1.9-1.9 1.9H2.8c-1 0-1.9-.9-1.9-1.9v-7.7c0-.3.3-.7.7-.7z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconReassign = Vue.component("lightning-icon-reassign", { template: document.getElementById('template-lightning-icon-reassign').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-dateinput">
	<svg :class="'slds-icon lightning-icon-dateinput '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M21.4 9.1H2.6c-.4 0-.7.3-.7.7v10.9c0 1.2 1 2.1 2.2 2.1h15.8c1.2 0 2.2-.9 2.2-2.1V9.8c0-.4-.3-.7-.7-.7zm-13 10.1c0 .4-.3.7-.7.7H6.2c-.4 0-.7-.3-.7-.7v-1.4c0-.4.3-.8.7-.8h1.5c.4 0 .7.4.7.8v1.4zm5 0c0 .4-.3.7-.7.7h-1.4c-.5 0-.8-.3-.8-.7v-1.4c0-.4.3-.8.8-.8h1.4c.4 0 .7.4.7.8v1.4zm0-5c0 .4-.3.7-.7.7h-1.4c-.5 0-.8-.3-.8-.7v-1.5c0-.4.3-.7.8-.7h1.4c.4 0 .7.3.7.7v1.5zm5.1 0c0 .4-.3.7-.7.7h-1.5c-.4 0-.7-.3-.7-.7v-1.5c0-.4.3-.7.7-.7h1.5c.4 0 .7.3.7.7v1.5zm1.4-10.9h-1.8v-.7c0-.8-.6-1.4-1.4-1.4-.8 0-1.4.6-1.4 1.4v.7H8.8v-.7c0-.8-.7-1.4-1.5-1.4s-1.4.6-1.4 1.4v.7H4.1c-1.2 0-2.2 1-2.2 2.2v.7c0 .4.3.8.7.8h18.8c.4 0 .8-.4.8-.8v-.7c-.1-1.2-1.1-2.2-2.3-2.2z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconDateInput = Vue.component("lightning-icon-dateinput", { template: document.getElementById('template-lightning-icon-dateinput').innerHTML, props: ['classList'], data() { return {} } })
</script>
<template id="template-lightning-icon-routing-offline">
	<svg :class="'slds-icon lightning-icon-routing-offline '+classList" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%"><path d="M19.8 4.2C15.5-.1 8.5-.1 4.2 4.2s-4.3 11.3 0 15.6 11.3 4.3 15.6 0 4.3-11.3 0-15.6zM12 20.3c-4.6 0-8.3-3.7-8.3-8.3S7.4 3.7 12 3.7s8.3 3.7 8.3 8.3-3.7 8.3-8.3 8.3z"></path></svg>
</template>
<script type="text/javascript">
var sldsIconRoutingOffline = Vue.component("lightning-icon-routing-offline", { template: document.getElementById('template-lightning-icon-routing-offline').innerHTML, props: ['classList'] })
</script>
<template id="template-lightning-progress-bar">
	<div>
		<div class="slds-grid slds-grid_align-spread slds-p-bottom_x-small">
			<span>{{title}}</span>
			<span aria-hidden="true">
				<strong>{{percent}}% Complete</strong>
			</span>
		</div>
		<div class="slds-progress-bar" aria-valuemin="0" aria-valuemax="100" :aria-valuenow="percent" role="progressbar">
			<span class="slds-progress-bar__value" :style="'width:' + percent + '%'">
				<span class="slds-assistive-text">Progress: {{percent}}%</span>
			</span>
		</div>
	</div>
</template>
<script type="text/javascript">
var sldsProgressBar = Vue.component("lightning-progress-bar", { template: document.getElementById('template-lightning-progress-bar').innerHTML, props: ['title','percent'] })
</script>