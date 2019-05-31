<?php
opcache_reset();
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(stristr($contentType, 'application/json')) {
		$content = trim(file_get_contents("php://input"));
		$decoded = json_decode($content, true);
		if($decoded['action'] == 'updateTracker') {
			// security check on write?
			echo file_put_contents('./trackers/'. $decoded['tracker']['hash'] .'.json', json_encode($decoded['tracker']).',') ? 'success' : 'error';
			die();
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Que Hace</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/design-system/2.9.3/styles/salesforce-lightning-design-system.min.css" />
	<script src="https://unpkg.com/axios/dist/axios.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
	<?= file_get_contents('slds.vue'); ?>
	<style>
.slds-card__body { width: 100%; }
	</style>
	<script>
	$TRACKERS = [
		<?php
			foreach(glob('trackers/*.json') as $filename) { echo file_get_contents($filename); }
		?>
	]
	</script>
	<template id="template-workingBoard">
		<lightning-card style="display:flex">
			<lightning-tiles style="width:100%">
				<vue-tracker v-for="tracker in progressTrackers" :tracker="tracker" :key="tracker.hash"></vue-tracker>
			</lightning-tiles>
		</lightning-card>
	</template>
	<template id="template-updateTracker">
		<lightning-card :title="'Update tracker for ' + tracker.name">
			<lightning-spinner v-if="showProgress"></lightning-spinner>
			<h2 v-if="message != ''">{{message}}</h2>
			<div class="slds-grid">
				<lightning-col><lightning-input v-model="tracker.task" label="Task Label"></lightning-input></lightning-col>
				<lightning-col><lightning-picklist v-model="tracker.length" :options="lengthOptions" title="Length of Time"></lightning-picklist></lightning-col>
				<lightning-col><lightning-picklist v-model="tracker.flexibility" :options="flexibilityOptions" title="Flexibility"></lightning-picklist></lightning-col>
			</div>
			<lightning-button style="margin:auto;margin-top:1rem" :disabled="showProgress" :type="'brand'" :action="updateTracker">Update Tracker</lightning-button>
		</lightning-card>
	</template>
	<template id="template-vueTracker">
		<lightning-tile>
			<h1 :class="'slds-text-heading_large ' + (remainingTime < 6 ? 'slds-text-color_error' : 'slds-text-color_success')" style="font-weight: bold">
				{{ tracker.task }}
				<span :class="'slds-badge' + (tracker.flexibility=='Flexible' ? '':' slds-badge_inverse' )" style="float:right">{{ tracker.flexibility }}</span>
			</h1>
			{{ tracker.name }}
			<h4>Time Remaining: {{ remainingTime }}</h4>
			<lightning-toast v-if="percentRemainingTime == 100" type="warning" style="margin-top:2rem">Current activity information is out of date</lightning-toast>
			<lightning-progress-bar :title="'Progress'" :percent="percentRemainingTime"></lightning-progress-bar>
		</lightning-tile>
	</template>
	<script type="text/javascript">
		var vueWorkingBoard = Vue.component("vueWorkingBoard", {
			template: document.getElementById('template-workingBoard').innerHTML,
			data() { return { progressTrackers: $TRACKERS, }}
		})
		var vueUpdateTracker = Vue.component("vueUpdateTracker", {
			template: document.getElementById('template-updateTracker').innerHTML,
			props: ['trackerHash'],
			data() { return {
				tracker: {},
				message: '',
				showProgress: false,
				lengthOptions: [
					{title: '15 Minutes', value: 15},
					{title: '30 Minutes', value: 30},
					{title: '60 Minutes', value: 60},
				],
				flexibilityOptions: [
					{title: 'Flexible', value: 'Flexible'},
					{title: 'Focused', value: 'Focused'},
				],
			}},
			created() {
				this.tracker = $TRACKERS.filter(t=>{ return t.hash == this.trackerHash })[0]
			},
			methods: {
				updateTracker() {
					let url = "./";
					this.tracker.fromTime = (new Date()).toISOString()
					let requestData = {
						action: 'updateTracker',
						tracker: this.tracker,
					}
					this.showProgress = true
					this.message = ''
					axios.post(url, requestData)
						.then(result => {
							if(result.data == 'success')
								router.push('/')
							else
								this.message = "There was an error saving your tracker, please try again"
							this.showProgress = false
						})
						.catch(error => {
							console.log("error", error)
							this.message = "There was an error saving your tracker, please try again"
							this.showProgress = false
						})
				},
			}
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
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'
var app = new Vue({
	el: '#app',
	router,
})
	</script>
</body>
</html>
