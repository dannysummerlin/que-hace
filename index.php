<!DOCTYPE html>
<?php opcache_reset(); ?>
<html>
<head>
	<title>Working</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/design-system/2.9.3/styles/salesforce-lightning-design-system.min.css" />
	<script src="https://unpkg.com/axios/dist/axios.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
	<?= file_get_contents('slds.vue'); ?>
	<template id="template-workingBoard">
		<lightning-card>
			<lightning-tiles style="width:100%">
				<vue-tracker v-for="tracker in progressTrackers" :tracker="tracker" :key="tracker.hash"></vue-tracker>
			</lightning-tiles>
		</lightning-card>
	</template>
	<template id="template-updateTracker">
		<lightning-box>
				{{ trackerHash }}
		</lightning-box>
	</template>
	<template id="template-vueTracker">
		<lightning-tile>
			<h1 :class="'slds-text-heading_large ' + (remainingTime < 6 ? 'slds-text-color_error' : 'slds-text-color_success')" style="font-weight: bold">
				{{ tracker.task }}
				<span :class="'slds-badge' + (tracker.flexibility=='Flexible' ? '':' slds-badge_inverse' )" style="float:right">{{ tracker.flexibility }}</span>
			</h1>
			{{ tracker.name }}
			<h4>Time Remaining: {{ remainingTime }}</h4>
			<lightning-progress-bar :title="'Progress'" :percent="percentRemainingTime"></lightning-progress-bar>
		</lightning-tile>
	</template>
	<script type="text/javascript">
		var vueWorkingBoard = Vue.component("vueWorkingBoard", {
			template: document.getElementById('template-workingBoard').innerHTML,
			data() { return {
				progressTrackers: [
					<?php
						foreach(glob('trackers/*.json') as $filename) { echo file_get_contents($filename); }
					?>
				],
			}}
		})
		var vueUpdateTracker = Vue.component("vueUpdateTracker", {
			template: document.getElementById('template-updateTracker').innerHTML,
			props: ['trackerHash'],
			data() { return {}}
		})
		var vueTracker = Vue.component("vueTracker", {
			template: document.getElementById('template-vueTracker').innerHTML,
			props: ['tracker'],
			computed: {
				timestamp() { return (new Date(this.tracker.fromTime)) },
				remainingTime() { return ( this.tracker.length - Math.round( (Date.now() - this.timestamp) / 60000)) },
				percentRemainingTime() { 
					let val = Math.round( (this.tracker.length - this.remainingTime) / this.tracker.length * 10000 ) / 100
					return (val > 100 ? 100 : val)
				},
			},
			data() { return {}}
		})
	</script>
</head>
<body>
	<div class="container body-content" style="height:100%;background:#5e6a71">
		<div id="app">
			<router-view></router-view>
		</div>
	</div>
	<script type="text/javascript">
Vue.use(VueRouter)
const routes = [
	{ path: '/', component: vueWorkingBoard },
	{ path: '/update/:trackerHash', component: vueUpdateTracker, props: (route)=>({ trackerHash: route.params.trackerHash}) },
]
let router = new VueRouter({ routes })
router.beforeEach((to, from, next) => { next() })
var app = new Vue({
	el: '#app',
	router,
})
	</script>
</body>
</html>
